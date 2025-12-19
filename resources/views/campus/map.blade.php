@extends('layouts.app')

@section('title', 'Denah Kampus')
@section('header', 'Denah UIN Antasari Banjarmasin')
@section('subheader', 'Visualisasi lokasi gedung dan status jaringan')

@section('content')
    <div class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Gedung</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $campusStats['total_buildings'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="p-3 bg-teal-50 rounded-xl text-teal-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Access Point</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $campusStats['total_aps'] }}</h3>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-teal-500 to-teal-600 p-6 rounded-2xl shadow-lg text-white flex items-center justify-between">
                <div>
                    <p class="text-teal-100 font-medium text-sm">Konektivitas</p>
                    <h3 class="text-2xl font-bold">
                        @php
                            $total = $campusStats['total_aps'] > 0 ? $campusStats['total_aps'] : 1;
                            $percent = round(($campusStats['active_aps'] / $total) * 100);
                        @endphp
                        {{ $percent }}%
                    </h3>
                    <p class="text-xs text-teal-100 mt-1">Jaringan Optimal</p>
                </div>
                <div class="h-12 w-12 rounded-full border-4 border-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col lg:flex-row h-[700px] relative"
            x-data="{ showInfoPanel: true }">

            <div
                class="flex-1 bg-gray-50 relative group transition-all duration-300 ease-in-out flex items-center justify-center">

                <button @click="showInfoPanel = !showInfoPanel"
                    class="absolute top-4 right-4 z-20 bg-white p-2.5 rounded-lg shadow-md border border-gray-200 text-gray-600 hover:text-teal-600 hover:border-teal-300 transition-all"
                    :title="showInfoPanel ? 'Sembunyikan Panel Info' : 'Tampilkan Panel Info'">
                    <svg x-show="showInfoPanel" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7">
                        </path>
                    </svg>
                    <svg x-show="!showInfoPanel" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>

                <div class="w-full h-full p-4 flex items-center justify-center">
                    <svg id="campusMap" viewBox="0 0 1800 1200" class="w-full h-full" preserveAspectRatio="xMidYMid meet">
                        <defs>
                            <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                                <path d="M 50 0 L 0 0 0 50" fill="none" stroke="#e5e7eb" stroke-width="1" />
                            </pattern>
                        </defs>

                        <image href="{{ asset('images/background-map.png') }}" x="0" y="0" width="1800" height="1200"
                            preserveAspectRatio="xMidYMid slice" />

                        @foreach ($buildings as $building)
                            @php
                                // LOGIKA TEXT WRAPPING
                                $nameWords = explode(' ', $building->name);
                                $totalWords = count($nameWords);
                                if ($totalWords > 2) {
                                    $midPoint = ceil($totalWords / 2);
                                    $line1 = implode(' ', array_slice($nameWords, 0, $midPoint));
                                    $line2 = implode(' ', array_slice($nameWords, $midPoint));
                                } else {
                                    $line1 = $building->name;
                                    $line2 = '';
                                }
                                $centerX = $building->position_x + $building->width / 2;
                                $centerY = $building->position_y + $building->height / 2;
                            @endphp

                            <g class="building-group cursor-pointer" data-building-id="{{ $building->id }}"
                                data-color="{{ $building->color }}" onclick="showBuildingModal({{ $building->id }})">

                                <g
                                    @if ($building->rotation > 0) transform="rotate({{ $building->rotation }} {{ $centerX }} {{ $centerY }})" @endif>
                                    <path d="{{ $building->generateSvgPath() }}" fill="{{ $building->color }}"
                                        stroke="#000000" stroke-width="2"
                                        class="building-path transition-all duration-200 shadow-md" />
                                </g>

                                <text text-anchor="middle" font-size="16" font-weight="bold"
                                    class="pointer-events-none select-none drop-shadow-md">
                                    @if ($line2)
                                        <tspan x="{{ $centerX }}" y="{{ $centerY - 8 }}" stroke="white"
                                            stroke-width="4" paint-order="stroke" fill="#000000">{{ $line1 }}
                                        </tspan>
                                        <tspan x="{{ $centerX }}" y="{{ $centerY + 12 }}" stroke="white"
                                            stroke-width="4" paint-order="stroke" fill="#000000">{{ $line2 }}
                                        </tspan>
                                    @else
                                        <tspan x="{{ $centerX }}" y="{{ $centerY }}" dominant-baseline="middle"
                                            stroke="white" stroke-width="4" paint-order="stroke" fill="#000000">
                                            {{ $line1 }}</tspan>
                                    @endif
                                </text>

                                <title>{{ $building->name }} - {{ $building->total_floors }} Lantai,
                                    {{ $building->total_rooms }} Ruangan, {{ $building->total_access_points }} AP</title>
                            </g>
                        @endforeach
                    </svg>
                </div>
            </div>

            <div x-show="showInfoPanel" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-10"
                class="w-full lg:w-80 bg-white border-l border-gray-200 flex flex-col z-10 shrink-0 h-full shadow-xl lg:shadow-none">

                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <div>
                        <h3 class="font-bold text-gray-800">Pantauan Kritis</h3>
                        <p class="text-xs text-gray-500 mt-1">Gedung yang butuh perhatian</p>
                    </div>
                    <button @click="showInfoPanel = false" class="lg:hidden text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-4 space-y-4 overflow-y-auto flex-1 custom-scrollbar">

                    @php
                        // Filter gedung yang bermasalah (Offline > 0 atau Maintenance > 0)
                        $problemBuildings = $buildings->filter(function ($b) {
                            return $b->offline_access_points > 0 || $b->maintenance_access_points > 0;
                        });
                    @endphp

                    @if ($problemBuildings->count() > 0)
                        <div class="space-y-3">
                            @foreach ($problemBuildings as $problemBuilding)
                                <div onclick="showBuildingModal({{ $problemBuilding->id }})"
                                    class="group flex items-center justify-between p-3 rounded-xl border cursor-pointer transition-all hover:shadow-md
                                     {{ $problemBuilding->offline_access_points > 0 ? 'bg-red-50 border-red-100 hover:border-red-300' : 'bg-yellow-50 border-yellow-100 hover:border-yellow-300' }}">

                                    <div class="flex items-center space-x-3">
                                        <div class="shrink-0">
                                            @if ($problemBuilding->offline_access_points > 0)
                                                <span
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </span>
                                            @else
                                                <span
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900 group-hover:underline">
                                                {{ $problemBuilding->name }}</h4>
                                            <p class="text-xs text-gray-500">
                                                @if ($problemBuilding->offline_access_points > 0)
                                                    <span
                                                        class="text-red-600 font-bold">{{ $problemBuilding->offline_access_points }}
                                                        AP Offline</span>
                                                @else
                                                    <span
                                                        class="text-yellow-600 font-bold">{{ $problemBuilding->maintenance_access_points }}
                                                        AP Maintenance</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="flex flex-col items-center justify-center h-40 text-center p-4 border-2 border-dashed border-gray-100 rounded-2xl">
                            <div
                                class="h-12 w-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-900">Semua Sistem Normal</h4>
                            <p class="text-xs text-gray-500 mt-1">Tidak ada gedung yang mengalami gangguan saat ini.</p>
                        </div>
                    @endif
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">Terakhir diperbarui: {{ now()->format('H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div id="buildingModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-black/50 transition-opacity opacity-0" id="modalBackdrop"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg opacity-0 scale-95"
                    id="modalPanel">

                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900" id="modalTitle">Nama Gedung</h3>
                        <button type="button" onclick="closeBuildingModal()"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-6" id="modalContent"></div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse space-x-2 space-x-reverse">
                        <a id="viewFloorBtn" href="#"
                            class="inline-flex w-full justify-center rounded-xl bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 sm:w-auto transition-colors">
                            Lihat Denah Lantai
                        </a>
                        <button type="button" onclick="closeBuildingModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const buildings = @json($buildings);

        // Helper untuk menggelapkan warna saat hover
        function darkenColor(hex, percent = 20) {
            hex = hex.replace('#', '');
            if (hex.length === 3) hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
            let r = parseInt(hex.substring(0, 2), 16);
            let g = parseInt(hex.substring(2, 4), 16);
            let b = parseInt(hex.substring(4, 6), 16);
            r = Math.floor(r * (1 - percent / 100));
            g = Math.floor(g * (1 - percent / 100));
            b = Math.floor(b * (1 - percent / 100));
            const toHex = (c) => {
                const h = c.toString(16);
                return h.length === 1 ? '0' + h : h;
            };
            return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
        }

        // Modal Logic
        function showBuildingModal(buildingId) {
            const building = buildings.find(b => b.id === buildingId);
            if (!building) return;

            document.getElementById('modalTitle').textContent = building.name;
            document.getElementById('modalContent').innerHTML = `
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 text-center">
                        <span class="block text-2xl font-bold text-indigo-600">${building.total_floors}</span>
                        <span class="text-xs text-indigo-400 font-medium uppercase tracking-wide">Lantai</span>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 text-center">
                        <span class="block text-2xl font-bold text-blue-600">${building.total_rooms}</span>
                        <span class="text-xs text-blue-400 font-medium uppercase tracking-wide">Ruangan</span>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-bold text-gray-700">Status Jaringan</h4>
                        <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded text-gray-600">Total: ${building.total_access_points} AP</span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-gray-600"><span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>Normal</span>
                            <span class="font-bold text-gray-800">${building.active_access_points}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-gray-600"><span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>Bermasalah</span>
                            <span class="font-bold text-gray-800">${building.offline_access_points}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-gray-600"><span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>Maintenance</span>
                            <span class="font-bold text-gray-800">${building.maintenance_access_points}</span>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('viewFloorBtn').href = `/building/${building.id}`;

            const modal = document.getElementById('buildingModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');

            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeBuildingModal() {
            const modal = document.getElementById('buildingModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');

            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'scale-100');
            panel.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        document.getElementById('buildingModal')?.addEventListener('click', function(e) {
            if (e.target.id === 'modalBackdrop' || e.target.closest('#modalBackdrop')) {
                closeBuildingModal();
            }
        });

        // Hover Effect Logic
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.building-group').forEach(group => {
                const originalColor = group.dataset.color;
                const darkerColor = darkenColor(originalColor, 20);

                group.addEventListener('mouseenter', function() {
                    const path = this.querySelector('.building-path');
                    if (path) {
                        path.style.fill = darkerColor;
                        path.style.transform = 'scale(1.02)';
                        path.style.transformOrigin = 'center';
                    }
                });

                group.addEventListener('mouseleave', function() {
                    const path = this.querySelector('.building-path');
                    if (path) {
                        path.style.fill = originalColor;
                        path.style.transform = 'scale(1)';
                    }
                });
            });
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection
