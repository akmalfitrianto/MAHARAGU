<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UnitKerja;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->with('buildings')
            ->withCount('tickets')
            ->latest()
            ->paginate(20);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $unitKerjaList = UnitKerja::aktif()
            ->orderBy('nama')
            ->get();
        
        $buildings = Building::orderBy('name')->get();

        return view('admin.admins.create', compact('unitKerjaList', 'buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'unit_kerja' => 'required|exists:unit_kerja,nama',
            'buildings' => 'nullable|array',
            'buildings.*' => 'exists:buildings,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'admin';

        $admin = User::create($validated);

        if ($request->has('buildings')) {
            $admin->buildings()->attach($request->buildings);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil ditambahkan!'); 
    }

    public function edit(User $admin)
    {

        if ($admin->role !== 'admin') {
            abort(404);
        }

        $unitKerjaList = UnitKerja::aktif()
            ->orderBy('nama')
            ->get();

        $buildings = Building::orderBy('name')->get();

        return view('admin.admins.edit', compact('admin', 'unitKerjaList', 'buildings'));
    }

    public function update(Request $request, User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'unit_kerja' => 'required|exists:unit_kerja,nama',
            'buildings' => 'nullable|array',
            'buildings.*' => 'exists:buildings,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        $admin->buildings()->sync($request->buildings ?? []);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil diupdate!');
    }

    public function destroy(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        if ($admin->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus akun Anda sendiri!');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil dihapus!');
    }
}