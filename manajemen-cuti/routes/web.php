<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; // <--- PASTIKAN INI ADA
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. MANAJEMEN DIVISI (Admin)
    Route::resource('divisions', DivisionController::class);

    // 3. MANAJEMEN USER (Admin) - SUDAH DIAKTIFKAN
    Route::resource('users', UserController::class);

    // 4. PENGAJUAN CUTI (Karyawan)
    Route::resource('leaves', LeaveRequestController::class)->only(['index', 'create', 'store', 'destroy']);

    // 5. APPROVAL (Manager & HRD)
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::patch('/approvals/{leaveRequest}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::patch('/approvals/{leaveRequest}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');

    // 6. PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';