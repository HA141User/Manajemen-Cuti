<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // LOGIC HITUNG KUOTA (Requirement: Info Kuota Realtime)
        // 1. Sisa (Ada di database kolom annual_leave_quota)
        $remaining = $user->annual_leave_quota;

        // 2. Terpakai (Hitung dari history cuti tahunan yang tidak ditolak)
        // Kita hitung yang statusnya 'pending', 'approved_leader', 'approved_hrd'
        // Karena sistem kita mengurangi kuota di awal (saat pending), maka semua status selain rejected dianggap terpakai/booking.
        // Tapi logika kita: user->decrement saat store. Jadi annual_leave_quota adalah REAL SISA.
        
        // Untuk mencari "Total Awal" (Plafon), kita harus menjumlahkan Sisa + Terpakai.
        // Mari hitung berapa yang sudah diambil tahun ini.
        $used = $user->leaveRequests()
            ->where('type', 'annual')
            ->whereYear('start_date', now()->year)
            ->where('status', '!=', 'rejected')
            ->sum('total_days');

        $total = $remaining + $used; 

        return view('profile.edit', [
            'user' => $user,
            'quotaInfo' => [
                'total' => $total,
                'used' => $used,
                'remaining' => $remaining
            ]
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Ambil data yang divalidasi
        $data = $request->validated();

        // Handle Email Verification reset if email changes
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // HANDLE UPLOAD AVATAR
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada (dan bukan default/placeholder jika kita pakai)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan yang baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        // Update User
        $user->fill($data);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}