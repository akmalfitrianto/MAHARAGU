<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_floors',
        'shape_type',
        'svg_path',
        'width',
        'height',
        'rotation',
        'position_x',
        'position_y',
        'color',
    ];

    // Atribut ini akan otomatis muncul (dihitung) setiap kali gedung diambil
    protected $appends = [
        'total_rooms',
        'total_access_points',
        'active_access_points',
        'offline_access_points',
        'maintenance_access_points',
    ];

    // --- RELATIONS ---

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function rooms()
    {
        // Shortcut untuk mengambil semua room di gedung ini
        return $this->hasManyThrough(Room::class, Floor::class);
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'building_user')
            ->where('role', 'admin')
            ->withTimestamps();
    }

    // --- ACCESSORS (CALCULATED FIELDS) ---
    // Best Practice: Hitung dari Collection yang sudah di-Eager Load di Controller

    public function getTotalRoomsAttribute(): int
    {
        return $this->rooms->count();
    }

    public function getTotalAccessPointsAttribute(): int
    {
        // Loop: Floors -> Rooms -> AccessPoints (Collection)
        return $this->floors->sum(function ($floor) {
            return $floor->rooms->sum(function ($room) {
                return $room->accessPoints->count();
            });
        });
    }

    public function getActiveAccessPointsAttribute(): int
    {
        return $this->floors->sum(function ($floor) {
            return $floor->rooms->sum(function ($room) {
                return $room->accessPoints->where('status', 'active')->count();
            });
        });
    }

    public function getOfflineAccessPointsAttribute(): int
    {
        return $this->floors->sum(function ($floor) {
            return $floor->rooms->sum(function ($room) {
                return $room->accessPoints->where('status', 'offline')->count();
            });
        });
    }

    public function getMaintenanceAccessPointsAttribute(): int
    {
        return $this->floors->sum(function ($floor) {
            return $floor->rooms->sum(function ($room) {
                return $room->accessPoints->where('status', 'maintenance')->count();
            });
        });
    }

    // --- SVG GENERATOR ---

    public function generateSvgPath(): string
    {
        if ($this->shape_type === 'custom' && $this->svg_path) {
            return $this->svg_path;
        }

        $w = $this->width;
        $h = $this->height;
        $x = $this->position_x;
        $y = $this->position_y;

        return match ($this->shape_type) {
            'rectangle', 'square' => "M {$x} {$y} L " . ($x + $w) . " {$y} L " . ($x + $w) . " " . ($y + $h) . " L {$x} " . ($y + $h) . " Z",
            'l_shape' => $this->generateLShape($x, $y, $w, $h),
            'u_shape' => $this->generateUShape($x, $y, $w, $h),
            default => "M {$x} {$y} L " . ($x + $w) . " {$y} L " . ($x + $w) . " " . ($y + $h) . " L {$x} " . ($y + $h) . " Z",
        };
    }

    private function generateLShape($x, $y, $w, $h): string
    {
        $legWidth = $w * 0.4;
        $legHeight = $h * 0.6;

        return "M {$x} {$y} L " . ($x + $w) . " {$y} L " . ($x + $w) . " " . ($y + $legHeight) .
            " L " . ($x + $legWidth) . " " . ($y + $legHeight) .
            " L " . ($x + $legWidth) . " " . ($y + $h) .
            " L {$x} " . ($y + $h) . " Z";
    }

    private function generateUShape($x, $y, $w, $h): string
    {
        return "M {$x} {$y} L " . ($x + $w) . " {$y} L " . ($x + $w) . " " . ($y + $h) .
            " L " . ($x + $w - ($w * 0.35)) . " " . ($y + $h) .
            " L " . ($x + $w - ($w * 0.35)) . " " . ($y + ($h * 0.5)) .
            " L " . ($x + ($w * 0.35)) . " " . ($y + ($h * 0.5)) .
            " L " . ($x + ($w * 0.35)) . " " . ($y + $h) .
            " L {$x} " . ($y + $h) . " Z";
    }
}
