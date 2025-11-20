@extends('layouts.app')

@section('title', 'Denah Kampus')
@section('header', 'Denah UIN Antasari Banjarmasin')

@section('content')
    <div class="space-y-6">
        <!-- Campus Info Card -->
        <div class="bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Denah Gedung Kampus</h2>
                    <p class="text-teal-100">Klik gedung untuk melihat detail denah ruangan</p>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold">{{ $campusStats['total_buildings'] }}</p>
                        <p class="text-sm text-teal-100">Total Gedung</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold">{{ $campusStats['total_aps'] }}</p>
                        <p class="text-sm text-teal-100">Total AP</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Map Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-0">
                <!-- SVG Canvas -->
                <div class="lg:col-span-3 p-6 bg-gray-50">
                    <div class="bg-white rounded-lg border-2 border-gray-300 overflow-hidden" style="height: 600px;">
                        <svg id="campusMap" viewBox="0 0 1800 1200" class="w-full h-full">
                            <defs>
                                <!-- Grid Pattern -->
                                <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                                    <path d="M 50 0 L 0 0 0 50" fill="none" stroke="#e5e7eb" stroke-width="1" />
                                </pattern>
                            </defs>

                            <!-- Background Image -->
                            <image href="{{ asset('images/background-map.png') }}" x="0" y="0" width="1800" height="1200"
                                preserveAspectRatio="xMidYMid slice" />

                            <!-- Buildings -->
                            @foreach ($buildings as $building)
                                @php
                                    // Split nama gedung untuk multi-line (max 2 lines)
                                    $nameWords = explode(' ', $building->name);
                                    $totalWords = count($nameWords);

                                    if ($totalWords > 2) {
                                        // Jika lebih dari 2 kata, bagi jadi 2 baris
                                        $midPoint = ceil($totalWords / 2);
                                        $line1 = implode(' ', array_slice($nameWords, 0, $midPoint));
                                        $line2 = implode(' ', array_slice($nameWords, $midPoint));
                                    } else {
                                        // Jika 1-2 kata, tampilkan 1 baris
                                        $line1 = $building->name;
                                        $line2 = '';
                                    }

                                    $centerX = $building->position_x + $building->width / 2;
                                    $centerY = $building->position_y + $building->height / 2;
                                @endphp

                                <g class="building-group cursor-pointer" data-building-id="{{ $building->id }}"
                                    data-color="{{ $building->color }}" onclick="showBuildingModal({{ $building->id }})">

                                    <!-- Building Shape with Rotation -->
                                    <g
                                        @if ($building->rotation > 0) transform="rotate({{ $building->rotation }} {{ $centerX }} {{ $centerY }})" @endif>
                                        <path d="{{ $building->generateSvgPath() }}" fill="{{ $building->color }}"
                                            stroke="#000000" stroke-width="2"
                                            class="building-path transition-all duration-200" />
                                    </g>

                                    <!-- Text Label with Black Stroke (Multi-line support) -->
                                    <text text-anchor="middle" font-size="16" font-weight="bold"
                                        class="pointer-events-none select-none">

                                        @if ($line2)
                                            <!-- Line 1 (top) -->
                                            <tspan x="{{ $centerX }}" y="{{ $centerY - 8 }}" stroke="white"
                                                stroke-width="4" paint-order="stroke" fill="#000000">
                                                {{ $line1 }}
                                            </tspan>

                                            <!-- Line 2 (bottom) -->
                                            <tspan x="{{ $centerX }}" y="{{ $centerY + 12 }}" stroke="white"
                                                stroke-width="4" paint-order="stroke" fill="#000000">
                                                {{ $line2 }}
                                            </tspan>
                                        @else
                                            <!-- Single Line -->
                                            <tspan x="{{ $centerX }}" y="{{ $centerY }}"
                                                dominant-baseline="middle" stroke="white" stroke-width="4"
                                                paint-order="stroke" fill="#000000">
                                                {{ $line1 }}
                                            </tspan>
                                        @endif
                                    </text>

                                    <!-- Native SVG Tooltip (on hover) -->
                                    <title>{{ $building->name }} - {{ $building->total_floors }} Lantai,
                                        {{ $building->total_rooms }} Ruangan, {{ $building->total_access_points }} AP
                                    </title>
                                </g>
                            @endforeach
                        </svg>
                    </div>
                </div>

                <!-- Info Panel -->
                <div class="p-6 bg-gray-50 border-l border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Denah</h3>

                    <!-- Access Point Status -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Status Access Point:</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-700">Aktif</span>
                                </div>
                                <span class="text-sm font-bold text-green-600">{{ $campusStats['active_aps'] }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-700">Offline</span>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ $campusStats['offline_aps'] }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-700">Maintenance</span>
                                </div>
                                <span
                                    class="text-sm font-bold text-yellow-600">{{ $campusStats['maintenance_aps'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-800">
                            <strong>Petunjuk:</strong><br>
                            Klik pada gedung untuk melihat detail denah ruangan dan access point.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Building Modal -->
    <div id="buildingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900" id="modalTitle"></h3>
                    <button onclick="closeBuildingModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <div id="modalContent" class="space-y-4">
                    <!-- Content will be injected by JavaScript -->
                </div>

                <div class="mt-6 flex space-x-3">
                    <button onclick="closeBuildingModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <a id="viewFloorBtn" href="#"
                        class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 text-center">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const buildings = @json($buildings);

        // Helper function to darken a hex color
        function darkenColor(hex, percent = 20) {
            // Remove # if present
            hex = hex.replace('#', '');

            // Convert to RGB
            let r = parseInt(hex.substring(0, 2), 16);
            let g = parseInt(hex.substring(2, 4), 16);
            let b = parseInt(hex.substring(4, 6), 16);

            // Darken by reducing each component
            r = Math.floor(r * (1 - percent / 100));
            g = Math.floor(g * (1 - percent / 100));
            b = Math.floor(b * (1 - percent / 100));

            // Convert back to hex
            const toHex = (c) => {
                const hex = c.toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            };

            return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
        }

        function showBuildingModal(buildingId) {
            const building = buildings.find(b => b.id === buildingId);
            if (!building) return;

            // Update modal content
            document.getElementById('modalTitle').textContent = building.name;
            document.getElementById('modalContent').innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Jumlah Lantai</p>
                <p class="text-2xl font-bold text-gray-900">${building.total_floors}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Jumlah Ruangan</p>
                <p class="text-2xl font-bold text-gray-900">${building.total_rooms}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg col-span-2">
                <p class="text-sm text-gray-600 mb-2">Total Access Points</p>
                <p class="text-2xl font-bold text-gray-900">${building.total_access_points} AP</p>
                <div class="mt-2 flex items-center space-x-4 text-sm">
                    <span class="text-green-600">● ${building.active_access_points} Aktif</span>
                    <span class="text-red-600">● ${building.offline_access_points} Offline</span>
                    <span class="text-yellow-600">● ${building.maintenance_access_points} Maintenance</span>
                </div>
            </div>
        </div>
    `;

            // Update view button link
            document.getElementById('viewFloorBtn').href = `/building/${building.id}`;

            // Show modal
            const modal = document.getElementById('buildingModal');
            modal.classList.remove('hidden');
        }

        function closeBuildingModal() {
            const modal = document.getElementById('buildingModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('buildingModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeBuildingModal();
            }
        });

        // Add dynamic hover effect based on building color
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.building-group').forEach(group => {
                const originalColor = group.dataset.color;
                const darkerColor = darkenColor(originalColor, 20); // 20% darker

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
@endsection
