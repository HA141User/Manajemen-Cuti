<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDivisionController extends Controller
{
    /**
     * Menampilkan daftar divisi.
     */
    public function index()
    {
        // Eager load leader dan hitung jumlah anggota (members_count)
        $divisions = Division::with('leader')->withCount('members')->get();
        return view('admin.divisions.index', compact('divisions'));
    }

    /**
     * Form tambah divisi.
     */
    public function create()
    {
        // Cari User dengan role 'leader' yang belum punya managedDivision
        $potentialLeaders = User::where('role', 'leader')
            ->doesntHave('managedDivision')
            ->get();

        return view('admin.divisions.create', compact('potentialLeaders'));
    }

    /**
     * Simpan divisi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name',
            'description' => 'nullable|string',
            'leader_id' => 'required|exists:users,id', 
        ]);

        // 1. Buat Divisi
        $division = Division::create([
            'name' => $request->name,
            'description' => $request->description,
            'leader_id' => $request->leader_id,
        ]);

        // 2. Update User Leader agar masuk ke divisi ini
        $leader = User::find($request->leader_id);
        if ($leader) {
            $leader->update(['division_id' => $division->id]);
        }

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dibuat.');
    }

    /**
     * Menampilkan Detail Divisi & Anggotanya
     */
    public function show(Division $division)
    {
        // Load Leader dan Anggota (urutkan anggota berdasarkan nama)
        $division->load(['leader', 'members' => function($query) {
            $query->orderBy('name', 'asc');
        }]);

        // FITUR TAMBAHAN: Ambil daftar karyawan (role user) yang BELUM punya divisi
        // Ini untuk dropdown "Tambah Anggota"
        $nonDivisionalEmployees = User::where('role', 'user')
            ->whereNull('division_id')
            ->orderBy('name')
            ->get();

        return view('admin.divisions.show', compact('division', 'nonDivisionalEmployees'));
    }

    /**
     * LOGIC BARU: Menambahkan Anggota ke Divisi
     */
    public function addMember(Request $request, Division $division)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);

        // Pastikan user memang belum punya divisi (Double check security)
        if ($user->division_id !== null) {
            return back()->with('error', 'User tersebut sudah memiliki divisi.');
        }

        $user->update(['division_id' => $division->id]);

        return back()->with('success', 'Anggota berhasil ditambahkan ke divisi ' . $division->name);
    }

    /**
     * LOGIC BARU: Mengeluarkan Anggota dari Divisi (Kick)
     */
    public function removeMember(User $user)
    {
        // Pastikan user bukan Leader dari divisi tersebut (Opsional, tapi aman)
        // Leader harus diganti lewat Edit Divisi, bukan di-kick.
        if ($user->managedDivision) {
            return back()->with('error', 'Tidak bisa mengeluarkan Ketua Divisi. Silakan ganti Ketua Divisi melalui menu Edit.');
        }

        $user->update(['division_id' => null]);

        return back()->with('success', 'Anggota berhasil dikeluarkan dari divisi.');
    }

    /**
     * Form edit divisi.
     */
    public function edit(Division $division)
    {
        // Cari Leader potensial
        $potentialLeaders = User::where('role', 'leader')
            ->where(function($query) use ($division) {
                $query->doesntHave('managedDivision')
                      ->orWhere('id', $division->leader_id);
            })
            ->get();

        return view('admin.divisions.edit', compact('division', 'potentialLeaders'));
    }

    /**
     * Update divisi.
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('divisions')->ignore($division->id)],
            'description' => 'nullable|string',
            'leader_id' => 'required|exists:users,id',
        ]);

        $oldLeaderId = $division->leader_id;
        $newLeaderId = $request->leader_id;

        $division->update([
            'name' => $request->name,
            'description' => $request->description,
            'leader_id' => $newLeaderId,
        ]);

        // Logic Sinkronisasi Anggota
        if ($oldLeaderId != $newLeaderId) {
            $newLeader = User::find($newLeaderId);
            $newLeader->update(['division_id' => $division->id]);
        }

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Hapus divisi.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }
}