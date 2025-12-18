@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Overview')

@section('content')
    <div class="space-y-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Gedung</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_buildings'] }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-xl group-hover:bg-indigo-100 transition-colors">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-indigo-600 h-1.5 rounded-full" style="width: 70%"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">AP Normal</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active_aps'] }}</h3>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl group-hover:bg-green-100 transition-colors">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    @php
                        $totalAP = $stats['active_aps'] + $stats['offline_aps'] + $stats['maintenance_aps'];
                        $percentActive = $totalAP > 0 ? ($stats['active_aps'] / $totalAP) * 100 : 0;
                    @endphp
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $percentActive }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">AP Bermasalah</p>
                        <h3 class="text-3xl font-bold text-red-600 mt-1">{{ $stats['offline_aps'] }}</h3>
                    </div>
                    <div class="p-3 bg-red-50 rounded-xl group-hover:bg-red-100 transition-colors">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    @php $percentOffline = $totalAP > 0 ? ($stats['offline_aps'] / $totalAP) * 100 : 0; @endphp
                    <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ $percentOffline }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Maintenance</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['maintenance_aps'] }}</h3>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl group-hover:bg-yellow-100 transition-colors">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    @php $percentMaint = $totalAP > 0 ? ($stats['maintenance_aps'] / $totalAP) * 100 : 0; @endphp
                    <div class="bg-yellow-500 h-1.5 rounded-full" style="width: {{ $percentMaint }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Statistik Tiket</h2>
                        <p class="text-sm text-gray-500">Jumlah laporan dalam 7 hari terakhir</p>
                    </div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-700 border border-teal-100">
                        Total Minggu Ini: {{ $ticketStats['total'] }}
                    </span>
                </div>
                <div class="relative h-64 w-full">
                    <canvas id="ticketChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Status Penanganan</h2>
                    <p class="text-sm text-gray-500 mb-6">Ringkasan status tiket saat ini</p>
                </div>

                <div class="space-y-4">
                    <div
                        class="flex items-center p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-white hover:shadow-sm transition-all">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                            <span class="font-bold text-sm">{{ $ticketStats['open'] }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">Menunggu (Open)</p>
                            <p class="text-xs text-gray-500">Belum diproses</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-white hover:shadow-sm transition-all">
                        <div
                            class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4">
                            <span class="font-bold text-sm">{{ $ticketStats['resolved'] }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">Selesai (Resolved)</p>
                            <p class="text-xs text-gray-500">Masalah teratasi</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-white hover:shadow-sm transition-all">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-4">
                            <span class="font-bold text-sm">{{ $ticketStats['closed'] }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">Ditutup (Closed)</p>
                            <p class="text-xs text-gray-500">Arsip laporan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-900">Tiket Terbaru</h2>
                <a href="{{ route('tickets.my') }}"
                    class="text-sm font-medium text-teal-600 hover:text-teal-800 transition-colors">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">Tiket #</th>
                            <th class="px-6 py-4">Perangkat</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Status</th>
                            @if (auth()->user()->isSuperAdmin())
                                <th class="px-6 py-4">Pelapor</th>
                            @endif
                            <th class="px-6 py-4 text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentTickets as $ticket)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-teal-700">
                                    <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->ticket_number }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $ticket->accessPoint->name }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $ticket->accessPoint->room->floor->building->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium border border-gray-200">
                                        {{ $ticket->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $ticket->status_color }}">
                                        {{ $ticket->status_label }}
                                    </span>
                                </td>
                                @if (auth()->user()->isSuperAdmin())
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600 mr-2">
                                                {{ substr($ticket->admin->name, 0, 2) }}
                                            </div>
                                            <span class="text-gray-700">{{ $ticket->admin->name }}</span>
                                        </div>
                                    </td>
                                @endif
                                <td class="px-6 py-4 text-right text-gray-500">
                                    {{ $ticket->created_at->format('d M') }}
                                    <span class="text-gray-400 ml-1">{{ $ticket->created_at->format('H:i') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada tiket terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('ticketChart');
        new Chart(ctx, {
            type: 'bar', // Bisa diganti 'line' jika suka
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Jumlah Tiket',
                    data: @json($chartData['data']),
                    backgroundColor: '#14b8a6', // Teal-500
                    borderRadius: 4,
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
