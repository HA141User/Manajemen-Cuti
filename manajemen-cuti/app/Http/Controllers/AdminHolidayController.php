<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminHolidayController extends Controller
{
    /**
     * Menampilkan daftar hari libur.
     */
    public function index()
    {
        // Urutkan dari tanggal terbaru ke terlama
        $holidays = Holiday::orderBy('holiday_date', 'desc')->paginate(10);
        return view('admin.holidays.index', compact('holidays'));
    }

    /**
     * Form tambah hari libur.
     */
    public function create()
    {
        return view('admin.holidays.create');
    }

    /**
     * Simpan hari libur baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'holiday_date' => 'required|date|unique:holidays,holiday_date',
            'description' => 'nullable|string',
        ]);

        Holiday::create($request->all());

        return redirect()->route('admin.holidays.index')->with('success', 'Hari libur berhasil ditambahkan.');
    }

    /**
     * Form edit hari libur.
     */
    public function edit(Holiday $holiday)
    {
        return view('admin.holidays.edit', compact('holiday'));
    }

    /**
     * Update hari libur.
     */
    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'holiday_date' => ['required', 'date', Rule::unique('holidays')->ignore($holiday->id)],
            'description' => 'nullable|string',
        ]);

        $holiday->update($request->all());

        return redirect()->route('admin.holidays.index')->with('success', 'Hari libur berhasil diperbarui.');
    }

    /**
     * Hapus hari libur.
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('admin.holidays.index')->with('success', 'Hari libur berhasil dihapus.');
    }
}