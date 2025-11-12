<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\AccessPoint;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        // Superadmin only
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('tickets.my');
        }

        $tickets = Ticket::with(['accessPoint.room.floor.building', 'admin'])
            ->latest()
            ->paginate(20);

        return view('tickets.index', compact('tickets'));
    }

    public function myTickets()
    {
        $tickets = Ticket::with(['accessPoint.room.floor.building'])
            ->where('admin_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('tickets.my-tickets', compact('tickets'));
    }

    public function create(AccessPoint $accessPoint)
    {
        $accessPoint->load('room.floor.building');
        
        return view('tickets.create', compact('accessPoint'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'access_point_id' => 'required|exists:access_points,id',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'access_point_id' => $request->access_point_id,
            'admin_id' => auth()->id(),
            'category' => $request->category,
            'description' => $request->description,
            'status' => 'open',
        ]);

        // Create notification for all superadmins
        $superadmins = User::where('role', 'superadmin')->get();
        foreach ($superadmins as $superadmin) {
            Notification::createForTicket($ticket, 'new_ticket', $superadmin);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket berhasil dibuat dengan nomor: ' . $ticket->ticket_number);
    }

    public function show(Ticket $ticket)
    {
        // Check access
        if (!auth()->user()->isSuperAdmin() && $ticket->admin_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this ticket.');
        }

        $ticket->load(['accessPoint.room.floor.building', 'admin', 'resolver']);

        return view('tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        // Superadmin only
        if (!auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'resolution_notes' => 'nullable|string',
        ]);

        $oldStatus = $ticket->status;
        $ticket->status = $request->status;

        if ($request->status === 'resolved') {
            $ticket->resolved_at = now();
            $ticket->resolved_by = auth()->id();
        }

        if ($request->status === 'closed') {
            $ticket->closed_at = now();
        }

        if ($request->filled('resolution_notes')) {
            $ticket->resolution_notes = $request->resolution_notes;
        }

        $ticket->save();

        // Notify ticket creator about status change
        if ($oldStatus !== $request->status) {
            Notification::createForTicket($ticket, 'status_changed', $ticket->admin);
        }

        return redirect()->back()
            ->with('success', 'Status ticket berhasil diubah menjadi: ' . $ticket->status_label);
    }

    public function resolve(Request $request, Ticket $ticket)
    {
        $request->validate([
            'resolution_notes' => 'required|string',
        ]);

        $ticket->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
            'resolution_notes' => $request->resolution_notes,
        ]);

        Notification::createForTicket($ticket, 'ticket_resolved', $ticket->admin);

        return redirect()->back()
            ->with('success', 'Ticket berhasil diselesaikan.');
    }

    public function close(Ticket $ticket)
    {
        $ticket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        Notification::createForTicket($ticket, 'ticket_closed', $ticket->admin);

        return redirect()->back()
            ->with('success', 'Ticket berhasil ditutup.');
    }
}