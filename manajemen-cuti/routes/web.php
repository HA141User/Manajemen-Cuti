<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini tempat mendaftarkan semua rute aplikasi.
|
*/

// Halaman Depan (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Grup Route yang butuh Login & Verifikasi Email
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. DASHBOARD UTAMA (Mengarahkan user sesuai Role: Admin/HRD/Manager/Karyawan)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. MANAJEMEN DIVISI (Fitur Admin - Project 8)
    // Otomatis membuat route: index, create, store, edit, update, destroy
    Route::resource('divisions', DivisionController::class);

    // 3. PROFILE USER (Bawaan Breeze - Edit Nama/Password)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Logika Autentikasi (Login/Register/Logout dari Breeze)
require __DIR__.'/auth.php';