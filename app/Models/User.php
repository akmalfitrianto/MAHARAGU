<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'unit_kerja',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'admin_id');
    }

    public function resolvedTickets()
    {
        return $this->hasMany(Ticket::class, 'resolved_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function buildings()
    {
        return $this->belongsToMany(Building::class, 'building_user')
                    ->withTimestamps();
    }

    // helper methods
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasAccessToBuilding($buildingId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->buildings()->where('building_id', $buildingId)->exists();
    }

    public function accessibleBuilding()
    {
        if ($this->isSuperAdmin()){
            return Building::all();
        }

        return $this->buildings;
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at')->orderBy('created_at', 'desc');
    }

    public function unreadNotificationsCount(): int
    {
        return $this->unreadNotifications()->count();
    }
}
