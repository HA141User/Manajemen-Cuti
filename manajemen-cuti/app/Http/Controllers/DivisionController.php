<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User; // <--- PENTING: Jangan lupa import model User
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Tampilkan daftar divisi.
     */
    public function index()
    {
        // Mengambil data divisi beserta info manager dan jumlah anggotanya
        $divisions = Division::with('manager')->withCount('users')->get();
        
        return view('admin.divisions.index', compact('divisions'));
    }

    /**
     * Tampilkan form buat divisi baru.
     */
    public function create()
    {
        // PERBAIKAN: Ambil daftar user yang jabatannya 'division_manager'
        // untuk ditampilkan di dropdown pilihan ketua divisi
        $managers = User::where('role', 'division_manager')->get();

        return view('admin.divisions.create', compact('managers'));
    }

    /**
     * Simpan divisi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        Division::create($request->all());

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dibuat!');
    }

    /**
     * Tampilkan form edit divisi.
     */
    public function edit(Division $division)
    {
        // PERBAIKAN: Kita juga butuh daftar manager di halaman edit
        $managers = User::where('role', 'division_manager')->get();

        return view('admin.divisions.edit', compact('division', 'managers'));
    }

    /**
     * Update data divisi.
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            // Validasi unik kecuali untuk id divisi ini sendiri
            'name' => 'required|string|max:255|unique:divisions,name,' . $division->id,
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $division->update($request->all());

        return redirect()->route('divisions.index')->with('success', 'Data divisi diperbarui!');
    }

    /**
     * Hapus divisi.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dihapus!');
    }
}