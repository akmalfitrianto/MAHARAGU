<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->with('ticket.accessPoint.room.floor.building')
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        // Check ownership
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }

    public function destroy(Notification $notification)
    {
        // Check ownership
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->delete();

        // Return JSON response untuk AJAX
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }

    public function destroyRead()
    {
        $count = auth()->user()
            ->notifications()
            ->whereNotNull('read_at')
            ->delete();

        return redirect()->back()->with('success', "Berhasil menghapus {$count} notifikasi");
    }
}