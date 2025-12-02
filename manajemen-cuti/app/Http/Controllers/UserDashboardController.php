<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        // FIX: Tambahkan baris ini agar error 'load' hilang
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Info Kuota
        $totalQuota = 12; // Default tahunan
        $remainingQuota = $user->annual_leave_quota;
        $usedQuota = $totalQuota - $remainingQuota;

        // 2. Jumlah Cuti Sakit (Tahun ini)
        $sickLeaveCount = LeaveRequest::where('user_id', $user->id)
            ->where('type', 'sick')
            ->whereYear('created_at', now()->year)
            ->count();

        // 3. Total Pengajuan (History)
        $totalRequests = LeaveRequest::where('user_id', $user->id)->count();

        // 4. Info Divisi & Ketua
        $user->load('division.leader');

        return view('dashboard', compact(
            'user',
            'totalQuota',
            'remainingQuota',
            'usedQuota',
            'sickLeaveCount',
            'totalRequests'
        ));
    }
}