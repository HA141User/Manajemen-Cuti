<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Karyawan (Requirement: Total, Aktif, Tidak Aktif)
        $totalEmployees = User::count();
        $activeEmployees = User::where('is_active', true)->count();
        $inactiveEmployees = User::where('is_active', false)->count();
        
        // 2. Total Cuti Bulan Ini (Approved Only)
        $leavesThisMonth = LeaveRequest::where('status', 'approved_hrd')
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->count();

        // 3. Pending Approval (Global: Menunggu Leader atau Menunggu HRD)
        $pendingApprovals = LeaveRequest::whereIn('status', ['pending', 'approved_leader'])->count();

        // 4. Daftar Probation (Masa kerja < 1 tahun)
        // Load relasi 'division' agar bisa ditampilkan di tabel
        $oneYearAgo = now()->subYear();
        $probationEmployees = User::with('division')
            ->where('join_date', '>', $oneYearAgo)
            ->orderBy('join_date', 'desc')
            ->limit(5) // Tampilkan 5 terbaru
            ->get();

        // 5. Total Divisi
        $totalDivisions = Division::count();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'leavesThisMonth',
            'pendingApprovals',
            'probationEmployees',
            'totalDivisions'
        ));
    }
}