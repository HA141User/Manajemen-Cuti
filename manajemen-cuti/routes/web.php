<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LeaderDashboardController;
use App\Http\Controllers\HrdDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminDivisionController;
use App\Http\Controllers\AdminHolidayController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// --- GATEWAY / PENENTU ARAH DASHBOARD ---
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'hrd':
            return redirect()->route('hrd.dashboard');
        case 'leader':
            return redirect()->route('leader.dashboard');
        default:
            return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// --- 1. DASHBOARD USER (KARYAWAN) ---
Route::middleware(['auth', 'verified', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    });


// --- 2. DASHBOARD ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Modules Standar
    Route::resource('users', AdminUserController::class);
    
    // CRUD Divisi + FITUR CUSTOM MEMBER (JANGAN DIHAPUS)
    Route::resource('divisions', AdminDivisionController::class);
    Route::post('/divisions/{division}/add-member', [AdminDivisionController::class, 'addMember'])->name('divisions.members.add');
    Route::delete('/divisions/members/{user}', [AdminDivisionController::class, 'removeMember'])->name('divisions.members.remove');

    // CRUD Hari Libur
    Route::resource('holidays', AdminHolidayController::class);
});


// --- 3. DASHBOARD HRD ---
Route::middleware(['auth', 'role:hrd'])->prefix('hrd')->name('hrd.')->group(function () {
    Route::get('/dashboard', [HrdDashboardController::class, 'index'])->name('dashboard');
    
    // Approval Routes HRD
    Route::get('/approvals', [HrdDashboardController::class, 'approvalList'])->name('approvals');
    Route::post('/approve/{leaveRequest}', [HrdDashboardController::class, 'approve'])->name('approve');
    Route::post('/reject/{leaveRequest}', [HrdDashboardController::class, 'reject'])->name('reject');
    
    // Bulk Action & Laporan
    Route::post('/bulk-action', [HrdDashboardController::class, 'bulkAction'])->name('bulk_action');
    Route::get('/recapitulation', [HrdDashboardController::class, 'recapitulation'])->name('recapitulation');
});


// --- 4. DASHBOARD LEADER ---
Route::middleware(['auth', 'role:leader'])->prefix('leader')->name('leader.')->group(function () {
    Route::get('/dashboard', [LeaderDashboardController::class, 'index'])->name('dashboard');
    
    // Approval Routes Leader
    Route::get('/approvals', [LeaderDashboardController::class, 'approvalList'])->name('approvals');
    Route::post('/approve/{leaveRequest}', [LeaderDashboardController::class, 'approve'])->name('approve');
    Route::post('/reject/{leaveRequest}', [LeaderDashboardController::class, 'reject'])->name('reject');
});


// --- FITUR PENGAJUAN CUTI (Shared) ---
Route::middleware(['auth'])->group(function () {
    Route::resource('leaves', LeaveRequestController::class);
    
    // ROUTE BARU: DOWNLOAD PDF (Hanya bisa diakses jika sudah login)
    Route::get('/leaves/{leave}/download', [LeaveRequestController::class, 'downloadPdf'])->name('leaves.download');
});


// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';