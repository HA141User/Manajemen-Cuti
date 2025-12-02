<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Holiday; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan library PDF

class LeaveRequestController extends Controller
{
    /**
     * Menampilkan riwayat pengajuan cuti (Hanya milik User Login).
     */
    public function index(Request $request)
    {
        // SATPAM: Admin & HRD dilarang masuk sini (Mereka punya menu sendiri)
        if (in_array(Auth::user()->role, ['admin', 'hrd'])) {
             return redirect()->route('dashboard');
        }

        $query = LeaveRequest::where('user_id', Auth::id());

        // Filter Logic
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        // Urutkan dan Paginate
        $leaves = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('leaves.index', compact('leaves'));
    }

    /**
     * Form pengajuan cuti baru.
     */
    public function create()
    {
        if (in_array(Auth::user()->role, ['admin', 'hrd'])) {
            abort(403, 'Role Admin dan HRD tidak diizinkan mengajukan cuti.');
        }
        return view('leaves.create');
    }

    /**
     * Proses penyimpanan data cuti.
     */
    public function store(Request $request)
    {
        // 1. Blokir Admin/HRD
        if (in_array(Auth::user()->role, ['admin', 'hrd'])) {
            abort(403, 'Role Admin dan HRD tidak diizinkan mengajukan cuti.');
        }

        // 2. Validasi Input
        $request->validate([
            'type' => 'required|in:annual,sick',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
            'leave_address' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:20',
            'attachment' => 'required_if:type,sick|file|mimes:pdf,jpg,jpeg,png|max:2048', 
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // 3. VALIDASI OVERLAP
        $isOverlap = LeaveRequest::where('user_id', $user->id)
            ->where('status', '!=', 'rejected') 
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                      });
            })
            ->exists();

        if ($isOverlap) {
            return back()->withInput()->withErrors(['start_date' => 'Anda sudah memiliki pengajuan cuti pada rentang tanggal tersebut.']);
        }

        // 4. Validasi H-3
        if ($request->type === 'annual') {
            if ($startDate->lessThan(now()->addDays(2)->startOfDay())) {
                return back()->withInput()->withErrors(['start_date' => 'Cuti Tahunan wajib diajukan minimal H-3.']);
            }
        }

        // 5. LOGIKA HITUNG HARI KERJA
        $holidays = Holiday::whereBetween('holiday_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->pluck('holiday_date')
            ->map(function ($date) { return $date->format('Y-m-d'); })
            ->toArray();

        $totalDays = 0;
        $tempDate = $startDate->copy();
        
        while ($tempDate->lte($endDate)) {
            if (!$tempDate->isSaturday() && !$tempDate->isSunday() && !in_array($tempDate->format('Y-m-d'), $holidays)) {
                $totalDays++;
            }
            $tempDate->addDay();
        }

        if ($totalDays == 0) {
            return back()->withInput()->withErrors(['end_date' => 'Anda mengajukan cuti pada hari libur (Sabtu/Minggu/Tanggal Merah).']);
        }

        // 6. Cek Kuota
        if ($request->type === 'annual') {
            if ($user->annual_leave_quota < $totalDays) {
                return back()->withInput()->withErrors(['type' => 'Sisa kuota cuti tahunan Anda tidak mencukupi (Sisa: ' . $user->annual_leave_quota . ' hari).']);
            }
        }

        // 7. Upload File
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        // 8. Simpan
        LeaveRequest::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'status' => 'pending', 
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'leave_address' => $request->leave_address,
            'emergency_contact' => $request->emergency_contact,
            'attachment' => $attachmentPath,
        ]);

        // 9. Kurangi Kuota
        if ($request->type === 'annual') {
            $user->decrement('annual_leave_quota', $totalDays);
        }

        return redirect()->route('leaves.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    /**
     * Menampilkan Detail Pengajuan Cuti (SHOW).
     */
    public function show($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        if ($leave->user_id !== Auth::id() && Auth::user()->role !== 'hrd') {
            abort(403, 'Anda tidak berhak melihat pengajuan cuti ini.');
        }

        $leave->load(['leaderApprover', 'hrdApprover']);

        return view('leaves.show', compact('leave'));
    }

    /**
     * FITUR BARU: Generate & Download PDF
     */
    public function downloadPdf($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        // 1. Validasi Akses (Pemilik atau HRD)
        if ($leave->user_id !== Auth::id() && Auth::user()->role !== 'hrd') {
            abort(403, 'Anda tidak berhak mengunduh dokumen ini.');
        }

        // 2. Validasi Status (Harus Approved HRD)
        if ($leave->status !== 'approved_hrd') {
            return back()->with('error', 'Surat Cuti hanya tersedia untuk pengajuan yang sudah disetujui HRD.');
        }

        // 3. Load relasi untuk tampilan PDF
        $leave->load(['user.division', 'leaderApprover', 'hrdApprover']);

        // 4. Generate PDF dari View
        $pdf = Pdf::loadView('leaves.pdf', compact('leave'));
        
        // Set ukuran kertas A4
        $pdf->setPaper('A4', 'portrait');

        // 5. Download
        return $pdf->download('Surat_Cuti_' . $leave->user->name . '_' . $leave->created_at->format('Ymd') . '.pdf');
    }

    /**
     * Membatalkan pengajuan (Hapus).
     */
    public function destroy($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        if ($leave->user_id !== Auth::id()) {
            abort(403);
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cuti yang sudah diproses tidak bisa dibatalkan.');
        }

        if ($leave->type === 'annual') {
            $leave->user->increment('annual_leave_quota', $leave->total_days);
        }

        if ($leave->attachment) {
            Storage::disk('public')->delete($leave->attachment);
        }

        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Pengajuan cuti berhasil dibatalkan dan kuota dikembalikan.');
    }
}