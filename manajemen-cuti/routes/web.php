<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\UserController; // <--- SAYA KOMENTAR DULU AGAR TIDAK ERROR
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

    // 3. MANAJEMEN USER (Admin) - KITA SKIP DULU
    // Route::resource('users', UserController::class); 

    // 4. PENGAJUAN CUTI (Karyawan)
    Route::resource('leaves', LeaveRequestController::class)->only(['index', 'create', 'store', 'destroy']);

    // 5. PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';