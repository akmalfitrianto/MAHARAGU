<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class CampusMapController extends Controller
{
    public function index()
    {
        $buildings = Building::with('floors')->get();

        // Calculate totals for info panel
        $totalAPs = 0;
        $activeAPs = 0;
        $offlineAPs = 0;
        $maintenanceAPs = 0;

        foreach ($buildings as $building) {
            $totalAPs += $building->total_access_points;
            $activeAPs += $building->active_access_points;
            $offlineAPs += $building->offline_access_points;
            $maintenanceAPs += $building->maintenance_access_points;
        }

        $campusStats = [
            'total_buildings' => $buildings->count(),
            'total_aps' => $totalAPs,
            'active_aps' => $activeAPs,
            'offline_aps' => $offlineAPs,
            'maintenance_aps' => $maintenanceAPs,
        ];

        return view('campus.map', compact('buildings', 'campusStats'));
    }

    public function show(Building $building)
    {
        $firstFloor = $building->floors()->orderBy('floor_number', 'asc')->first();

        if ($firstFloor) {
            return redirect()->route('building.floor', [
                'building' => $building->id, 
                'floor' => $firstFloor->id
            ]);
        }

        return back()->with('error', 'Denah lantai belum tersedia untuk gedung ini.');
    }

    public function floor(Building $building, Floor $floor)
    {
        // Ensure floor belongs to building
        if ($floor->building_id !== $building->id) {
            abort(404);
        }

        $floor->load(['rooms.accessPoints.room']);

        // Get all floors for pagination
        $floors = $building->floors()->orderBy('floor_number')->get();

        return view('campus.floor', compact('building', 'floor', 'floors'));
    }
}
