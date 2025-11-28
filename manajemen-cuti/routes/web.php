<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ADMIN: Divisi & User
    Route::resource('divisions', DivisionController::class);
    Route::resource('users', UserController::class);

    // KARYAWAN: Cuti
    Route::resource('leaves', LeaveRequestController::class)->only(['index', 'create', 'store', 'destroy']);
    
    // ROUTE PDF (BARU)
    Route::get('/leaves/{id}/pdf', [LeaveRequestController::class, 'downloadPdf'])->name('leaves.download_pdf');

    // MANAGER & HRD: Approval
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::patch('/approvals/{leaveRequest}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::patch('/approvals/{leaveRequest}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';