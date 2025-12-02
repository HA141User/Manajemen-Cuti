<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $managedDivision = $user->managedDivision;

        $totalQuota = 12;
        $remainingQuota = $user->annual_leave_quota;
        
        $incomingRequests = 0;
        $pendingVerification = 0;
        $teamMembers = [];
        $membersOnLeave = [];

        if ($managedDivision) {
            $incomingRequests = LeaveRequest::whereHas('user', function($q) use ($managedDivision) {
                $q->where('division_id', $managedDivision->id);
            })->count();

            $pendingVerification = LeaveRequest::whereHas('user', function($q) use ($managedDivision) {
                $q->where('division_id', $managedDivision->id);
            })->where('status', 'pending')->count();

            $teamMembers = $managedDivision->members()->limit(5)->get();

            $membersOnLeave = LeaveRequest::whereHas('user', function($q) use ($managedDivision) {
                    $q->where('division_id', $managedDivision->id);
                })
                ->where('status', 'approved_hrd')
                ->where(function($q) {
                    $q->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()])
                      ->orWhereBetween('end_date', [now()->startOfWeek(), now()->endOfWeek()]);
                })
                ->with('user')
                ->get();
        }

        return view('leader.dashboard', compact(
            'user', 'remainingQuota', 'incomingRequests', 
            'pendingVerification', 'teamMembers', 'membersOnLeave', 'managedDivision'
        ));
    }

    /**
     * Menampilkan daftar approval khusus Leader.
     */
    public function approvalList()
    {
        $user = Auth::user();
        $managedDivision = $user->managedDivision;

        if (!$managedDivision) {
            return redirect()->route('leader.dashboard')->with('error', 'Anda tidak memimpin divisi apapun.');
        }

        // Ambil request yang STATUS = PENDING dan user-nya adalah anggota divisi ini
        // Kecuali request milik Leader sendiri (jika dia iseng masukin diri sendiri ke divisi)
        $requests = LeaveRequest::whereHas('user', function($q) use ($managedDivision) {
                $q->where('division_id', $managedDivision->id);
            })
            ->where('user_id', '!=', $user->id) // Jangan approve diri sendiri
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('leader.approvals', compact('requests'));
    }

    /**
     * Leader menyetujui request (Lanjut ke HRD).
     */
    public function approve(LeaveRequest $leaveRequest)
    {
        // Validasi: Pastikan status masih pending
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Request sudah diproses sebelumnya.');
        }

        $leaveRequest->update([
            'status' => 'approved_leader', // Naik level ke HRD
            'leader_approver_id' => Auth::id(),
        ]);

        return back()->with('success', 'Pengajuan disetujui. Menunggu verifikasi HRD.');
    }

    /**
     * Leader menolak request (Selesai).
     */
    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate(['rejection_note' => 'required|string']);

        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Request sudah diproses sebelumnya.');
        }

        // Kembalikan Kuota jika Cuti Tahunan
        if ($leaveRequest->type === 'annual') {
            $leaveRequest->user->increment('annual_leave_quota', $leaveRequest->total_days);
        }

        $leaveRequest->update([
            'status' => 'rejected',
            'leader_approver_id' => Auth::id(),
            'rejection_note' => $request->rejection_note
        ]);

        return back()->with('success', 'Pengajuan ditolak dan kuota dikembalikan.');
    }
}