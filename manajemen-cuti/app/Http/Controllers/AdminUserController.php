<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar user dengan filter lengkap.
     */
    public function index(Request $request)
    {
        // Eager load divisi biar query ringan
        $query = User::with('division'); 

        // 1. Filter Text (Nama / Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 3. Filter Divisi
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        // Sorting default: Nama A-Z
        $users = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        // Ambil data divisi untuk dropdown filter
        $divisions = Division::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'divisions'));
    }

    /**
     * Menampilkan form tambah user.
     */
    public function create()
    {
        $divisions = Division::all();
        return view('admin.users.create', compact('divisions'));
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user,leader,hrd',
            'division_id' => 'nullable|exists:divisions,id',
            'annual_leave_quota' => 'required|integer|min:0',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'division_id' => $request->division_id,
            'annual_leave_quota' => $request->annual_leave_quota,
            'join_date' => now(), // Default hari ini
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(User $user)
    {
        $divisions = Division::all();
        return view('admin.users.edit', compact('user', 'divisions'));
    }

    /**
     * Mengupdate data user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,user,leader,hrd',
            'division_id' => 'nullable|exists:divisions,id',
            'annual_leave_quota' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'division_id' => $request->division_id,
            'annual_leave_quota' => $request->annual_leave_quota,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        // FIX: Menggunakan Auth::id() agar editor tidak error
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if (!in_array($user->role, ['user', 'leader'])) {
             // Opsional
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}