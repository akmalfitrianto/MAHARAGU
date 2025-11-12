<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\AccessPoint;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Stats Cards
        $stats = [
            'total_buildings' => Building::count(),
            'active_aps' => AccessPoint::where('status', 'active')->count(),
            'offline_aps' => AccessPoint::where('status', 'offline')->count(),
            'maintenance_aps' => AccessPoint::where('status', 'maintenance')->count(),
        ];

        // Recent Tickets
        if ($user->isSuperAdmin()) {
            $recentTickets = Ticket::with(['accessPoint.room.floor.building', 'admin'])
                ->latest()
                ->take(5)
                ->get();
            
            $totalTickets = Ticket::count();
            $openTickets = Ticket::whereIn('status', ['open', 'in_progress'])->count();
        } else {
            $recentTickets = Ticket::with(['accessPoint.room.floor.building'])
                ->where('admin_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
            
            $totalTickets = $user->tickets()->count();
            $openTickets = $user->tickets()->whereIn('status', ['open', 'in_progress'])->count();
        }

        // Ticket Stats
        $ticketStats = [
            'total' => $totalTickets,
            'open' => $openTickets,
            'resolved' => $user->isSuperAdmin() 
                ? Ticket::where('status', 'resolved')->count()
                : $user->tickets()->where('status', 'resolved')->count(),
            'closed' => $user->isSuperAdmin() 
                ? Ticket::where('status', 'closed')->count()
                : $user->tickets()->where('status', 'closed')->count(),
        ];

        // Chart Data - Last 7 Days Tickets
        $chartData = $this->getWeeklyTicketData($user);

        return view('dashboard.index', compact('stats', 'recentTickets', 'ticketStats', 'chartData'));
    }

    private function getWeeklyTicketData($user)
    {
        $days = [];
        $counts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('D'); // Mon, Tue, Wed, etc
            
            $query = Ticket::whereDate('created_at', $date->format('Y-m-d'));
            
            if (!$user->isSuperAdmin()) {
                $query->where('admin_id', $user->id);
            }
            
            $counts[] = $query->count();
        }

        return [
            'labels' => $days,
            'data' => $counts,
        ];
    }
}