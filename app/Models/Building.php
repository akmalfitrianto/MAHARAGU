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
        'position_x',
        'position_y',
        'color',
    ];

    protected $appends = [
        'total_rooms',
        'total_access_points',
        'active_access_points',
        'offline_access_points',
        'maintenance_access_points',
    ];

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function rooms()
    {
        return $this->hasManyThrough(Room::class, Floor::class);
    }

    public function getTotalRoomsAttribute(): int
    {
        return $this->rooms()->count();
    }

    public function getTotalAccessPointsAttribute(): int
    {
        $total = 0;
        foreach ($this->floors as $floor) {
            $total += $floor->accessPoints()->count();
        }
        return $total;
    }

    public function getActiveAccessPointsAttribute(): int
    {
        $total = 0;
        foreach ($this->floors as $floor) {
            $total += $floor->accessPoints()->where('status', 'active')->count();
        }
        return $total;
    }

    public function getOfflineAccessPointsAttribute(): int
    {
        $total = 0;
        foreach ($this->floors as $floor) {
            $total += $floor->accessPoints()->where('status', 'offline')->count();
        }
        return $total;
    }

    public function getMaintenanceAccessPointsAttribute(): int
    {
        $total = 0;
        foreach ($this->floors as $floor) {
            $total += $floor->accessPoints()->where('status', 'maintenance')->count();
        }
        return $total;
    }

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
