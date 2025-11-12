<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index(Building $building)
    {
        $building->load(['floors.rooms.accessPoints']);
        
        return view('admin.floors.index', compact('building'));
    }

    public function create(Building $building)
    {
        return view('admin.floors.create', compact('building'));
    }

    public function store(Request $request, Building $building)
    {
        $validated = $request->validate([
            'floor_number' => 'required|integer|min:1',
            'name' => 'nullable|string|max:255',
        ]);

        // Check if floor number already exists
        $exists = Floor::where('building_id', $building->id)
            ->where('floor_number', $validated['floor_number'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['floor_number' => 'Nomor lantai sudah ada untuk gedung ini.'])
                ->withInput();
        }

        $validated['building_id'] = $building->id;
        $validated['name'] = $validated['name'] ?? "Lantai {$validated['floor_number']}";

        Floor::create($validated);

        return redirect()->route('admin.buildings.floors.index', $building)
            ->with('success', 'Lantai berhasil ditambahkan!');
    }

    public function show(Floor $floor)
    {
        $floor->load(['building', 'rooms.accessPoints']);
        
        return view('admin.floors.show', compact('floor'));
    }

    public function edit(Floor $floor)
    {
        $floor->load('building');
        
        return view('admin.floors.edit', compact('floor'));
    }

    public function update(Request $request, Floor $floor)
    {
        $validated = $request->validate([
            'floor_number' => 'required|integer|min:1',
            'name' => 'nullable|string|max:255',
        ]);

        // Check if floor number already exists (except current floor)
        $exists = Floor::where('building_id', $floor->building_id)
            ->where('floor_number', $validated['floor_number'])
            ->where('id', '!=', $floor->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['floor_number' => 'Nomor lantai sudah ada untuk gedung ini.'])
                ->withInput();
        }

        $validated['name'] = $validated['name'] ?? "Lantai {$validated['floor_number']}";

        $floor->update($validated);

        return redirect()->route('admin.buildings.floors.index', $floor->building)
            ->with('success', 'Lantai berhasil diupdate!');
    }

    public function destroy(Floor $floor)
    {
        $building = $floor->building;
        
        // Check if floor has rooms
        if ($floor->rooms()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus lantai yang masih memiliki ruangan!');
        }

        $floor->delete();
        
        return redirect()->route('admin.buildings.floors.index', $building)
            ->with('success', 'Lantai berhasil dihapus!');
    }
}