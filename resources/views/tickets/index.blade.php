@extends('layouts.app')

@section('title', 'Daftar Tiket')
@section('header', 'Semua Tiket')

@section('content')
    <div class="space-y-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Tiket</h3>
                    <div class="p-2 bg-purple-50 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-gray-900">{{ $tickets->total() }}</p>
                    <span class="ml-2 text-xs font-medium text-gray-400">Laporan</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Perlu Tindakan</h3>
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-blue-600">
                        {{ $tickets->where('status', 'open')->count() + $tickets->where('status', 'in_progress')->count() }}
                    </p>
                    <span class="ml-2 text-xs font-medium text-gray-400">Sedang diproses</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Diselesaikan</h3>
                    <div class="p-2 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-green-600">{{ $tickets->where('status', 'resolved')->count() }}</p>
                    <span class="ml-2 text-xs font-medium text-gray-400">Berhasil</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Ditutup</h3>
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-gray-600">{{ $tickets->where('status', 'closed')->count() }}</p>
                    <span class="ml-2 text-xs font-medium text-gray-400">Arsip</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col">

            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="relative max-w-sm w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm w-full focus:ring-2 focus:ring-teal-500 focus:border-transparent placeholder-gray-400 transition-all"
                        placeholder="Cari ID tiket, lokasi, atau pelapor...">
                </div>

                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-48">
                        <select onchange="window.location.href='?status='+this.value"
                            class="appearance-none w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white text-gray-600 cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto rounded-b-2xl">
                <table class="w-full divide-y divide-gray-100" id="ticketsTable">
                    <thead class="bg-gray-50/50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left">
                                ID Ticket
                            </th>

                            <th scope="col" class="px-4 py-3 text-left">
                                Perangkat & Lokasi
                            </th>

                            <th scope="col" class="px-4 py-3 text-left hidden md:table-cell">
                                Kategori
                            </th>

                            <th scope="col" class="px-4 py-3 text-left hidden lg:table-cell">
                                Pelapor
                            </th>

                            <th scope="col" class="px-4 py-3 text-center">
                                Status
                            </th>

                            <th scope="col" class="px-4 py-3 text-left hidden xl:table-cell">
                                Tanggal
                            </th>

                            <th scope="col" class="px-4 py-3 text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50/80 transition-colors group">

                                <td class="px-4 py-3 align-middle">
                                    <span class="text-xs font-bold text-teal-700 font-mono">
                                        #{{ $ticket->ticket_number }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 align-middle overflow-hidden">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 truncate"
                                            title="{{ $ticket->accessPoint->name }}">
                                            {{ $ticket->accessPoint->name }}
                                        </span>
                                        <span class="text-xs text-gray-500 mt-0.5 truncate"
                                            title="{{ $ticket->accessPoint->room->floor->building->name }} • {{ $ticket->accessPoint->room->name }}">
                                            {{ $ticket->accessPoint->room->floor->building->name }} •
                                            {{ $ticket->accessPoint->room->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-4 py-3 align-middle hidden md:table-cell">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-[10px] font-semibold bg-gray-100 text-gray-600 border border-gray-200 truncate w-full text-center"
                                        title="{{ $ticket->category }}">
                                        {{ $ticket->category }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 align-middle hidden lg:table-cell">
                                    <div class="flex items-center">
                                        <div
                                            class="h-6 w-6 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white text-[10px] font-bold shadow-sm shrink-0">
                                            {{ substr($ticket->admin->name, 0, 2) }}
                                        </div>
                                        <div class="ml-2 overflow-hidden w-full">
                                            <div class="text-xs font-bold text-gray-700 truncate"
                                                title="{{ $ticket->admin->name }}">
                                                {{ $ticket->admin->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 align-middle">
                                    @php
                                        $statusStyles = [
                                            'open' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                            'in_progress' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                                            'resolved' => 'bg-green-50 text-green-700 ring-green-600/20',
                                            'closed' => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                                        ];
                                        $style = $statusStyles[$ticket->status] ?? 'bg-gray-50 text-gray-600';
                                    @endphp
                                    <span
                                        class="inline-flex items-center justify-center w-full rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-wide ring-1 ring-inset {{ $style }}">
                                        {{ $ticket->status_label }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 align-middle text-xs text-gray-500 hidden xl:table-cell">
                                    {{ $ticket->created_at->format('d M') }}
                                    <span class="text-gray-400 ml-1">{{ $ticket->created_at->format('H:i') }}</span>
                                </td>

                                <td class="px-4 py-3 align-middle text-right">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                        class="inline-flex items-center justify-center p-1.5 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm group"
                                        title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 rounded-full p-4 mb-3">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">Belum ada tiket</h3>
                                        <p class="text-sm text-gray-500 mt-1">Belum ada laporan masalah yang dibuat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tickets->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#ticketsTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
@endsection
