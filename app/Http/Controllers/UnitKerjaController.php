<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $units = UnitKerja::latest()->get();
        return view('admin.unit-kerja.index', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:unit_kerja,nama',
            'aktif' => 'nullable|boolean',
        ]);

        UnitKerja::create([
            'nama' => $request->nama,
            'aktif' => $request->has('aktif') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:unit_kerja,nama,' . $unitKerja->id,
            'aktif' => 'nullable|boolean',
        ]);

        $unitKerja->update([
            'nama' => $request->nama,
            'aktif' => $request->has('aktif') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        if ($unitKerja->users()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus Unit Kerja ini karena masih digunakan oleh User.');
        }

        $unitKerja->delete();
        return redirect()->back()->with('success', 'Unit kerja berhasil dihapus.');
    }
}