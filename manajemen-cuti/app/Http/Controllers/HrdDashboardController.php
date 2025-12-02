<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrdDashboardController extends Controller
{
    public function index()
    {
        $leavesThisMonth = LeaveRequest::where('status', 'approved_hrd')
            ->whereMonth('start_date', now()->month)
            ->count();

        $pendingFinalApproval = LeaveRequest::where('status', 'approved_leader')
            ->orWhere(function($query) {
                $query->where('status', 'pending')
                      ->whereHas('user', function($q) {
                          $q->where('role', 'leader');
                      });
            })->count();

        $employeesOnLeave = LeaveRequest::where('status', 'approved_hrd')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->with('user')
            ->get();

        $divisions = Division::with('leader')->withCount('members')->get();

        return view('hrd.dashboard', compact(
            'leavesThisMonth', 'pendingFinalApproval', 'employeesOnLeave', 'divisions'
        ));
    }

    public function approvalList()
    {
        $requests = LeaveRequest::with(['user.division', 'leaderApprover'])
            ->where('status', 'approved_leader')
            ->orWhere(function($query) {
                $query->where('status', 'pending')
                      ->whereHas('user', function($q) {
                          $q->where('role', 'leader');
                      });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('hrd.approvals', compact('requests'));
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        if (!in_array($leaveRequest->status, ['pending', 'approved_leader'])) {
            return back()->with('error', 'Status tidak valid.');
        }
        $leaveRequest->update([
            'status' => 'approved_hrd',
            'hrd_approver_id' => Auth::id(),
            'hrd_approval_date' => now(),
        ]);
        return back()->with('success', 'Pengajuan disetujui.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate(['rejection_note' => 'required|string|min:5']);
        if ($leaveRequest->type === 'annual') {
            $leaveRequest->user->increment('annual_leave_quota', $leaveRequest->total_days);
        }
        $leaveRequest->update([
            'status' => 'rejected',
            'hrd_approver_id' => Auth::id(),
            'rejection_note' => $request->rejection_note
        ]);
        return back()->with('success', 'Pengajuan ditolak.');
    }

    // BULK ACTION
    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:leave_requests,id',
            'action' => 'required|in:approve,reject',
            'bulk_note' => 'nullable|string' 
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $note = $request->bulk_note ?? ($action == 'approve' ? 'Bulk Approved' : 'Ditolak secara massal.');

        $leaveRequests = LeaveRequest::whereIn('id', $ids)->get();

        foreach ($leaveRequests as $req) {
            $isValidStatus = ($req->status == 'approved_leader') || 
                             ($req->status == 'pending' && $req->user->role == 'leader');
            
            if (!$isValidStatus) continue;

            if ($action === 'approve') {
                $req->update([
                    'status' => 'approved_hrd',
                    'hrd_approver_id' => Auth::id(),
                    'hrd_approval_date' => now(),
                ]);
            } else {
                if ($req->type === 'annual') {
                    $req->user->increment('annual_leave_quota', $req->total_days);
                }
                $req->update([
                    'status' => 'rejected',
                    'hrd_approver_id' => Auth::id(),
                    'rejection_note' => $note
                ]);
            }
        }
        return back()->with('success', 'Aksi massal berhasil.');
    }

    /**
     * FITUR BARU: REKAPITULASI (LAPORAN CUTI)
     * Menampilkan semua data cuti dengan filter.
     */
    public function recapitulation(Request $request)
    {
        $query = LeaveRequest::with(['user.division', 'leaderApprover', 'hrdApprover']);

        // Filter Nama
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Divisi
        if ($request->filled('division_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }

        // Filter Lain
        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('month')) $query->whereMonth('start_date', $request->month);
        if ($request->filled('year')) $query->whereYear('start_date', $request->year);

        $leaves = $query->latest()->paginate(15)->withQueryString();
        $divisions = Division::orderBy('name')->get();

        return view('hrd.recapitulation', compact('leaves', 'divisions'));
    }
}