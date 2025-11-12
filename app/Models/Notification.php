<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'type',
        'title',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getIsReadAttribute(): bool
    {
        return !is_null($this->read_at);
    }

    public function getIsUnreadAttribute(): bool
    {
        return is_null($this->read_at);
    }

    public function markAsRead(): void
    {
        if ($this->isUnread) {
            $this->update(['read_at' => now()]);
        }
    }

    public function markAsUnread(): void
    {
        if ($this->isRead) {
            $this->update(['read_at' => null]);
        }
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    public static function createForTicket(Ticket $ticket, string $type, User $recipient): self
    {
        $messages = [
            'new_ticket' => [
                'title' => 'Ticket Baru',
                'message' => "Ticket baru #{$ticket->ticket_number} telah dibuat untuk AP {$ticket->accessPoint->name}",
            ],
            'status_changed' => [
                'title' => 'Status Ticket Diubah',
                'message' => "Ticket #{$ticket->ticket_number} telah diubah menjadi {$ticket->status_label}",
            ],
            'ticket_resolved' => [
                'title' => 'Ticket Diselesaikan',
                'message' => "Ticket #{$ticket->ticket_number} telah diselesaikan",
            ],
            'ticket_closed' => [
                'title' => 'Ticket Ditutup',
                'message' => "Ticket #{$ticket->ticket_number} telah ditutup",
            ],
        ];

        $data = $messages[$type] ?? [
            'title' => 'Notifikasi Ticket',
            'message' => "Update untuk ticket #{$ticket->ticket_number}",
        ];

        return static::create([
            'user_id' => $recipient->id,
            'ticket_id' => $ticket->id,
            'type' => $type,
            'title' => $data['title'],
            'message' => $data['message'],
        ]);
    }
}