<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'name',
        'shape_type',
        'svg_path',
        'width',
        'height',
        'position_x',
        'position_y',
        'color',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function accessPoints()
    {
        return $this->hasMany(AccessPoint::class);
    }

    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, AccessPoint::class);
    }

    public function getTotalAccessPointsAttribute(): int
    {
        return $this->accessPoints()->count();
    }

    public function getActiveAccessPointsAttribute(): int
    {
        return $this->accessPoints()->where('status', 'active')->count();
    }

    public function getOfflineAccessPointsAttribute(): int
    {
        return $this->accessPoints()->where('status', 'offline')->count();
    }

    public function getMaintenanceAccessPointsAttribute(): int
    {
        return $this->accessPoints()->where('status', 'maintenance')->count();
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

    public function getCenterPosition(): array
    {
        return [
            'x' => $this->position_x + ($this->width / 2),
            'y' => $this->position_y + ($this->height / 2),
        ];
    }
}