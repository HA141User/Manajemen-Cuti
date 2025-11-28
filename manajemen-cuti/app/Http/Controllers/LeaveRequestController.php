<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveRequestController extends Controller
{
    // 1. Tampilkan Riwayat Cuti Saya [cite: 928-931]
    public function index()
    {
        $requests = LeaveRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.leaves.index', compact('requests'));
    }

    // 2. Form Pengajuan Cuti Baru [cite: 932-936]
    public function create()
    {
        return view('employee.leaves.create');
    }

    // 3. Proses Simpan & Validasi [cite: 937-944]
    public function store(Request $request)
    {
        // Validasi Dasar
        $request->validate([
            'leave_type' => 'required|in:annual,sick',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Maks 2MB
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // --- VALIDASI LOGIKA BISNIS ---

        // A. Validasi Cuti Tahunan (H-3) [cite: 940]
        if ($request->leave_type == 'annual') {
            if ($startDate->diffInDays(now()) < 3 && $startDate->isFuture()) {
                return back()->withErrors(['start_date' => 'Pengajuan Cuti Tahunan minimal H-3 dari hari ini.'])->withInput();
            }
        }

        // B. Validasi Cuti Sakit (Wajib File) [cite: 943]
        if ($request->leave_type == 'sick' && !$request->hasFile('attachment')) {
            return back()->withErrors(['attachment' => 'Bukti surat dokter wajib diunggah untuk Cuti Sakit.'])->withInput();
        }

        // C. Hitung Total Hari Kerja (Skip Sabtu/Minggu & Libur Nasional) [cite: 944]
        $totalDays = 0;
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        
        // Ambil hari libur dari database agar tidak query berulang
        $holidays = Holiday::pluck('holiday_date')->toArray();

        foreach ($period as $date) {
            // Jika bukan Sabtu/Minggu DAN bukan tanggal merah
            if (!$date->isWeekend() && !in_array($date->format('Y-m-d'), $holidays)) {
                $totalDays++;
            }
        }

        if ($totalDays == 0) {
            return back()->withErrors(['start_date' => 'Anda memilih tanggal libur/akhir pekan. Tidak ada hari kerja yang dihitung.'])->withInput();
        }

        // D. Cek Kuota (Khusus Cuti Tahunan) [cite: 939]
        if ($request->leave_type == 'annual') {
            if ($user->annual_leave_quota < $totalDays) {
                return back()->withErrors(['annual_leave_quota' => "Kuota tidak cukup. Sisa: {$user->annual_leave_quota}, Diminta: {$totalDays}."])->withInput();
            }
        }

        // E. Cek Overlap (Tidak boleh mengajukan di tanggal yang sudah ada pengajuan pending/approved) [cite: 941]
        $overlap = LeaveRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved_by_leader', 'approved'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate]);
            })->exists();

        if ($overlap) {
            return back()->withErrors(['start_date' => 'Anda sudah memiliki pengajuan cuti pada rentang tanggal tersebut.'])->withInput();
        }

        // --- SIMPAN DATA ---
        
        // Upload file jika ada
        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        // Kurangi Kuota Langsung (Agar tidak double spend, nanti dibalikin kalau reject/cancel)
        if ($request->leave_type == 'annual') {
            $user->decrement('annual_leave_quota', $totalDays);
        }

        LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type' => $request->leave_type,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'attachment_path' => $path,
            'address_during_leave' => $request->address_during_leave,
            'emergency_contact' => $request->emergency_contact,
            'status' => 'pending', // Awal selalu pending
        ]);

        return redirect()->route('leaves.index')->with('success', 'Pengajuan cuti berhasil dikirim! Menunggu persetujuan.');
    }

    // 4. Pembatalan Cuti (Hanya jika status Pending) [cite: 945-948]
    public function destroy(LeaveRequest $leaveRequest)
    {
        // Pastikan yang menghapus adalah pemiliknya
        if (Auth::id() !== $leaveRequest->user_id) {
            abort(403);
        }

        // Hanya boleh batal kalau masih Pending
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Cuti yang sudah diproses tidak bisa dibatalkan.');
        }

        // Kembalikan Kuota jika Cuti Tahunan
        if ($leaveRequest->leave_type == 'annual') {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->increment('annual_leave_quota', $leaveRequest->total_days);
        }

        $leaveRequest->status = 'cancelled'; // Soft delete (ubah status jadi cancelled)
        $leaveRequest->save();

        return redirect()->route('leaves.index')->with('success', 'Pengajuan cuti berhasil dibatalkan. Kuota dikembalikan.');
    }
}