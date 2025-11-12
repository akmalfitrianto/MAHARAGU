<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'floor_number',
        'name',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function accessPoints()
    {
        return $this->hasManyThrough(AccessPoint::class, Room::class);
    }

    public function getTotalRoomsAttribute(): int
    {
        return $this->rooms()->count();
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

    public function getDisplayNameAttribute(): string
    {
        return $this->name ?? "Lantai {$this->floor_number}";
    }
}