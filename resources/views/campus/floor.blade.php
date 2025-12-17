@extends('layouts.app')

@section('title', 'Lantai ' . $floor->floor_number . ' - ' . $building->name)
@section('header', $building->name)

@section('content')
    <div class="flex flex-col lg:flex-row h-[calc(100vh-theme(spacing.32))] bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 relative"
        x-data="{ showSidebar: true }">

        <div class="w-full lg:w-72 bg-gray-50 border-b lg:border-b-0 lg:border-r border-gray-200 flex flex-col shrink-0 z-10"
            x-show="showSidebar" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-10">

            <div class="p-5 border-b border-gray-200 bg-white">

                <a href="{{ route('campus.map') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-teal-600 mb-4 transition-colors group">
                    <div
                        class="w-6 h-6 rounded-full bg-gray-100 group-hover:bg-teal-50 flex items-center justify-center mr-2 transition-colors">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-teal-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    Kembali ke Peta
                </a>

                <h1 class="font-bold text-gray-800 text-xl leading-tight">{{ $building->name }}</h1>
                <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                    <span>{{ $building->total_floors }} Lantai</span>
                    <span>•</span>
                    <span>{{ $building->total_rooms }} Ruangan</span>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-3 space-y-1 custom-scrollbar">
                <p class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Navigasi Lantai</p>

                @foreach ($floors as $f)
                    <a href="{{ route('building.floor', [$building->id, $f->id]) }}"
                        class="flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 group
                   {{ $f->id == $floor->id
                       ? 'bg-teal-600 text-white shadow-md transform scale-[1.02]'
                       : 'text-gray-600 hover:bg-white hover:shadow-sm hover:text-teal-600' }}">

                        <div class="flex items-center">
                            <span
                                class="{{ $f->id == $floor->id ? 'text-teal-200' : 'text-gray-400 group-hover:text-teal-500' }} font-bold mr-3 text-xs">L{{ $f->floor_number }}</span>
                            <span>{{ $f->display_name ?? 'Lantai ' . $f->floor_number }}</span>
                        </div>

                        @if ($f->offline_access_points > 0)
                            <span class="flex h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"
                                title="Masalah Jaringan"></span>
                        @elseif($f->maintenance_access_points > 0)
                            <span class="flex h-2.5 w-2.5 rounded-full bg-yellow-400 ring-2 ring-white"
                                title="Maintenance"></span>
                        @else
                            @if ($f->id == $floor->id)
                                <span class="flex h-2 w-2 rounded-full bg-white/40"></span>
                            @endif
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="p-4 border-t border-gray-200 bg-white">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wide mb-2">Statistik Lantai Ini</p>
                    <div class="flex justify-between items-center text-sm">
                        <div class="text-center">
                            <span class="block font-bold text-gray-800">{{ $floor->total_rooms }}</span>
                            <span class="text-[10px] text-gray-500">Ruangan</span>
                        </div>
                        <div class="h-8 w-px bg-blue-200"></div>
                        <div class="text-center">
                            <span class="block font-bold text-green-600">{{ $floor->active_access_points }}</span>
                            <span class="text-[10px] text-gray-500">Online</span>
                        </div>
                        <div class="text-center">
                            <span class="block font-bold text-red-600">{{ $floor->offline_access_points }}</span>
                            <span class="text-[10px] text-gray-500">Offline</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 bg-slate-100 relative overflow-hidden flex flex-col group transition-all duration-300">

            <button @click="showSidebar = !showSidebar"
                class="absolute top-4 left-4 z-20 bg-white p-2.5 rounded-lg shadow-md border border-gray-200 text-gray-600 hover:text-teal-600 hover:border-teal-300 transition-all transform hover:scale-105"
                :title="showSidebar ? 'Tutup Sidebar' : 'Buka Sidebar'">

                <svg x-show="showSidebar" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7">
                    </path>
                </svg>

                <svg x-show="!showSidebar" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <div class="flex-1 overflow-auto relative flex items-center justify-center p-8 custom-scrollbar">
                <div class="relative w-full h-full flex items-center justify-center min-h-[500px]">

                    <svg id="floorMap" viewBox="0 0 1000 600"
                        class="w-full h-full max-w-6xl drop-shadow-xl bg-white rounded-xl border border-gray-100">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#f1f5f9" stroke-width="1" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />

                        @foreach ($floor->rooms as $room)
                            <g class="room-group hover:opacity-95 transition-opacity">
                                <path d="{{ $room->generateSvgPath() }}" fill="{{ $room->color }}" stroke="#3b82f6"
                                    stroke-width="2" class="room-path" />
                                <text x="{{ $room->position_x + $room->width / 2 }}"
                                    y="{{ $room->position_y + $room->height / 2 }}" text-anchor="middle"
                                    class="text-xs font-bold pointer-events-none select-none font-sans"
                                    fill="#1e3a8a" style="text-shadow: 0px 1px 1px rgba(255,255,255,0.9);">
                                    {{ $room->name }}
                                </text>
                                @foreach ($room->accessPoints as $ap)
                                    @php
                                        $apX = $room->position_x + $ap->position_x;
                                        $apY = $room->position_y + $ap->position_y;
                                    @endphp

                                    <g class="cursor-pointer hover:scale-125 transition-transform duration-200 ease-out"
                                        onclick="showAPModal({{ $ap->id }})"
                                        style="transform-origin: {{ $apX }}px {{ $apY }}px">

                                        @if ($ap->status == 'active')
                                            <circle cx="{{ $apX }}" cy="{{ $apY }}" r="12"
                                                fill="{{ $ap->status_color }}" opacity="0.3" />
                                        @endif

                                        <circle cx="{{ $apX }}" cy="{{ $apY }}" r="6"
                                            fill="{{ $ap->status_color }}" stroke="#fff" stroke-width="2"
                                            class="shadow-sm" />

                                        <circle cx="{{ $apX }}" cy="{{ $apY }}" r="14"
                                            fill="transparent" />
                                    </g>
                                @endforeach
                            </g>
                        @endforeach
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div id="apModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-black/50" id="apModalBackdrop"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white text-left shadow-2xl"
                    id="apModalPanel">
                    <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-white">
                        <h3 class="text-lg font-bold text-gray-900" id="apModalTitle">Detail AP</h3>
                        <button type="button" onclick="closeAPModal()"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none p-1 rounded-md hover:bg-gray-100">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-5" id="apModalContent"></div>
                    <div class="bg-gray-50 p-5 flex space-x-3">
                        <button onclick="closeAPModal()"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-white font-medium transition-colors">Tutup</button>
                        <a id="createTicketBtn" href="#"
                            class="flex-1 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 shadow-sm font-medium text-center transition-colors">Buat
                            Tiket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const accessPoints = @json($floor->rooms->flatMap->accessPoints);
        const modal = document.getElementById('apModal');

        function showAPModal(apId) {
            const ap = accessPoints.find(a => a.id === apId);
            if (!ap) return;

            if (ap.status === 'maintenance') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sedang Maintenance',
                    text: 'Perangkat ini sedang dalam perbaikan.',
                    confirmButtonColor: '#d97706',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                });
                return;
            }

            const statusBadges = {
                'active': '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>Normal</span>',
                'offline': '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"><span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>Offline</span>',
                'maintenance': '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>Maintenance</span>'
            };

            document.getElementById('apModalTitle').textContent = ap.name;
            document.getElementById('createTicketBtn').href = `/tickets/create/${ap.id}`;
            document.getElementById('apModalContent').innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-gray-50 rounded-xl"><p class="text-xs text-gray-500 mb-1">Status</p>${statusBadges[ap.status] || '-'}</div>
                        <div class="p-3 bg-gray-50 rounded-xl"><p class="text-xs text-gray-500 mb-1">Lokasi</p><p class="text-sm font-semibold text-gray-800 truncate">{{ $building->name }}</p><p class="text-xs text-gray-600 truncate">{{ $floor->display_name ?? 'Lantai ' . $floor->floor_number }}</p></div>
                    </div>
                    ${ap.notes ? `<div class="p-4 bg-blue-50 border border-blue-100 rounded-xl"><div class="flex items-start"><svg class="w-4 h-4 text-blue-500 mt-0.5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><div class="overflow-hidden"><p class="text-xs font-bold text-blue-700 mb-0.5">Catatan Teknis</p><p class="text-xs text-blue-600 leading-relaxed break-words">${ap.notes}</p></div></div></div>` : ''}
                    <div class="text-xs text-center text-gray-400 mt-2">ID Perangkat: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">#AP-${ap.id}</span></div>
                </div>
            `;
            modal.classList.remove('hidden');
        }

        function closeAPModal() {
            modal.classList.add('hidden');
        }

        document.getElementById('apModal')?.addEventListener('click', function(e) {
            if (e.target.id === 'apModalBackdrop' || e.target.closest('#apModalBackdrop')) {
                closeAPModal();
            }
        });
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection
