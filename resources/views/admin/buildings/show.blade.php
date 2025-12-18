@extends('layouts.app')

@section('title', $building->name)
@section('header', 'Detail ' . $building->name)

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="space-y-8" x-data="buildingDetail()">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li><a href="{{ route('admin.buildings.index') }}"
                                class="hover:text-teal-600 transition-colors">Manajemen Gedung</a></li>
                        <li><svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></li>
                        <li class="font-medium text-gray-800">{{ $building->name }}</li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">{{ $building->name }}</h1>
            </div>

            <a href="{{ route('admin.buildings.edit', $building) }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                </svg>
                Edit Gedung
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div
                class="lg:col-span-2 bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-white/5 to-transparent"></div>
                <div class="absolute -right-6 -bottom-6 text-white/10">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 2H5c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM5 20V4h14l.002 16H5z">
                        </path>
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <h2 class="text-3xl font-bold mb-1">{{ $building->name }}</h2>
                        <p class="text-gray-300 text-sm">UIN Antasari Banjarmasin</p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mt-8">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-bold">Lantai</p>
                            <p class="text-2xl font-bold">{{ $building->total_floors }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-bold">Ruangan</p>
                            <p class="text-2xl font-bold">{{ $building->total_rooms }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-bold">Access Point</p>
                            <p class="text-2xl font-bold">{{ $building->total_access_points }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex flex-col justify-center">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4 border-b pb-2">Status Perangkat (AP)
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-green-500 mr-3"></div>
                            <span class="text-sm text-gray-600">Normal</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $building->active_access_points }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-red-500 mr-3"></div>
                            <span class="text-sm text-gray-600">Bermasalah</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $building->offline_access_points }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-yellow-500 mr-3"></div>
                            <span class="text-sm text-gray-600">Maintenance</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $building->maintenance_access_points }}</span>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="flex h-2 w-full rounded-full bg-gray-100 overflow-hidden">
                        @if ($building->total_access_points > 0)
                            @php
                                $total = $building->total_access_points;
                                $p_active = ($building->active_access_points / $total) * 100;
                                $p_offline = ($building->offline_access_points / $total) * 100;
                                $p_maint = ($building->maintenance_access_points / $total) * 100;
                            @endphp
                            <div class="bg-green-500" style="width: {{ $p_active }}%"></div>
                            <div class="bg-red-500" style="width: {{ $p_offline }}%"></div>
                            <div class="bg-yellow-400" style="width: {{ $p_maint }}%"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-bold text-gray-900">Daftar Lantai</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($building->floors()->orderBy('floor_number')->get() as $floor)
                    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-all group">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $floor->display_name }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $floor->total_rooms }} Ruangan •
                                    {{ $floor->total_access_points }} AP</p>
                            </div>
                            <div class="flex space-x-1">
                                <span
                                    class="w-2.5 h-2.5 rounded-full {{ $floor->offline_access_points > 0 ? 'bg-red-500' : 'bg-green-500' }}"
                                    title="{{ $floor->offline_access_points > 0 ? 'Ada Masalah' : 'Semua Normal' }}"></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-auto">
                            <button
                                @click="openFloorMap({{ $floor->id }}, '{{ $floor->display_name }}', {{ $floor->rooms->toJson() }})"
                                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-blue-50 text-blue-700 text-sm font-bold rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                                Lihat Denah
                            </button>
                            <a href="{{ route('admin.floors.rooms.index', $floor) }}"
                                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                Kelola Ruangan
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div x-show="showFloorMap" x-cloak
            class="fixed inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center p-4 sm:p-6"
            @click.self="closeFloorMap()">

            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-6xl h-[85vh] flex flex-col overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white z-10">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900" x-text="'Denah ' + currentFloorName"></h3>
                        <p class="text-sm text-gray-500">Preview layout ruangan</p>
                    </div>
                    <button @click="closeFloorMap()"
                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 bg-slate-100 relative overflow-hidden flex items-center justify-center p-8">

                    <div x-show="currentRooms.length === 0" class="text-center">
                        <div class="bg-white p-4 rounded-full inline-block mb-3 shadow-sm">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada ruangan yang digambar.</p>
                    </div>

                    <div x-show="currentRooms.length > 0" class="relative w-full h-full flex items-center justify-center">
                        <svg viewBox="0 0 1000 700"
                            class="max-w-full max-h-full drop-shadow-xl bg-white rounded-lg border border-gray-200">
                            <defs>
                                <pattern id="floorGrid" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#f1f5f9" stroke-width="1" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#floorGrid)" />
                            <g x-html="renderRooms()"></g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function buildingDetail() {
            return {
                showFloorMap: false,
                currentFloorId: null,
                currentFloorName: '',
                currentRooms: [],

                openFloorMap(floorId, floorName, rooms) {
                    this.currentFloorId = floorId;
                    this.currentFloorName = floorName;
                    this.currentRooms = rooms;
                    this.showFloorMap = true;
                    document.body.style.overflow = 'hidden';
                },

                closeFloorMap() {
                    this.showFloorMap = false;
                    document.body.style.overflow = '';
                },

                renderRooms() {
                    if (this.currentRooms.length === 0) return '';

                    // 1. Calculate Bounding Box
                    let minX = Infinity,
                        minY = Infinity,
                        maxX = -Infinity,
                        maxY = -Infinity;

                    this.currentRooms.forEach(room => {
                        const x = room.position_x || 100;
                        const y = room.position_y || 100;
                        const w = room.width || 200;
                        const h = room.height || 150;
                        minX = Math.min(minX, x);
                        minY = Math.min(minY, y);
                        maxX = Math.max(maxX, x + w);
                        maxY = Math.max(maxY, y + h);
                    });

                    // 2. Center Calculation
                    const contentW = maxX - minX;
                    const contentH = maxY - minY;
                    const centerX = minX + contentW / 2;
                    const centerY = minY + contentH / 2;
                    const viewCX = 500;
                    const viewCY = 350;
                    const offX = viewCX - centerX;
                    const offY = viewCY - centerY;

                    // 3. Render Elements
                    return this.currentRooms.map(room => {
                        const x = (room.position_x || 100) + offX;
                        const y = (room.position_y || 100) + offY;
                        const w = room.width || 200;
                        const h = room.height || 150;
                        const color = room.color || '#bfdbfe';

                        return `
                            <g class="hover:opacity-90 transition-opacity cursor-default">
                                <rect x="${x}" y="${y}" width="${w}" height="${h}" rx="4"
                                      fill="${color}" stroke="#2563eb" stroke-width="2" opacity="0.9" />
                                <text x="${x + w/2}" y="${y + h/2}" 
                                      text-anchor="middle" dominant-baseline="middle"
                                      font-family="sans-serif" font-size="14" font-weight="bold" fill="#1e3a8a"
                                      style="pointer-events: none;">
                                    ${room.name}
                                </text>
                            </g>
                        `;
                    }).join('');
                }
            }
        }
    </script>
@endsection
