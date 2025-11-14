@extends('layouts.app')

@section('title', 'Denah ' . $building->name)
@section('header', 'Denah ' . $building->name)

@section('content')
    <div class="space-y-6">
        <!-- Breadcrumb & Back Button -->
        <div class="flex items-center justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('campus.map') }}" class="text-gray-500 hover:text-gray-700">Denah Kampus</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-900 font-medium">{{ $building->name }}</span>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li>
                        <span class="text-teal-600 font-medium">{{ $floor->display_name }}</span>
                    </li>
                </ol>
            </nav>

            <a href="{{ route('campus.map') }}"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                ← Kembali ke Denah Gedung
            </a>
        </div>

        <!-- Floor Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">{{ $floor->display_name }}</h2>

                <!-- Floor Pagination -->
                <div class="flex items-center space-x-2">
                    @foreach ($floors as $f)
                        <a href="{{ route('building.floor', [$building, $f]) }}"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition {{ $f->id === $floor->id ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Lantai {{ $f->floor_number }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Floor Map Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-0">
                <!-- SVG Canvas -->
                <div class="lg:col-span-3 p-6 bg-gray-50">
                    <div class="bg-white rounded-lg border-2 border-gray-300 overflow-hidden" style="height: 600px;">
                        <svg id="floorMap" viewBox="0 0 1000 600" class="w-full h-full">
                            <!-- Grid Background -->
                            <defs>
                                <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                                    <path d="M 50 0 L 0 0 0 50" fill="none" stroke="#f3f4f6" stroke-width="1" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#grid)" />

                            <!-- Rooms -->
                            @foreach ($floor->rooms as $room)
                                <g class="room-group">
                                    <!-- Room Shape -->
                                    <path d="{{ $room->generateSvgPath() }}" fill="{{ $room->color }}" stroke="#3b82f6"
                                        stroke-width="2" class="room-path" />

                                    <!-- Room Label -->
                                    <text x="{{ $room->position_x + $room->width / 2 }}"
                                        y="{{ $room->position_y + $room->height / 2 }}" text-anchor="middle"
                                        class="text-xs font-semibold pointer-events-none" fill="#1e40af">
                                        {{ $room->name }}
                                    </text>

                                    <!-- Access Points in Room -->
                                    @foreach ($room->accessPoints as $ap)
                                        <g class="ap-group cursor-pointer" onclick="showAPModal({{ $ap->id }})"
                                            data-ap-id="{{ $ap->id }}">

                                            <circle cx="{{ $room->position_x + $ap->position_x }}"
                                                cy="{{ $room->position_y + $ap->position_y }}" r="8"
                                                fill="{{ $ap->status_color }}" stroke="#fff" stroke-width="2"
                                                class="ap-marker transition-all duration-200 hover:r-10" />

                                            <circle cx="{{ $room->position_x + $ap->position_x }}"
                                                cy="{{ $room->position_y + $ap->position_y }}" r="12" fill="transparent"
                                                class="pointer-events-auto" />
                                        </g>
                                    @endforeach
                                </g>
                            @endforeach
                        </svg>
                    </div>
                </div>

                <!-- Info Panel -->
                <div class="p-6 bg-gray-50 border-l border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi:</h3>

                    <!-- Room Legend -->
                    <div class="mb-6">
                        <div class="flex items-center p-3 bg-blue-100 border border-blue-300 rounded-lg">
                            <div class="w-8 h-8 bg-blue-200 border-2 border-blue-500 rounded mr-3"></div>
                            <span class="text-sm font-medium text-gray-900">Ruangan</span>
                        </div>
                    </div>

                    <!-- AP Legend -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Access Point:</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-green-500 rounded-full mr-2 border-2 border-white"></div>
                                <span class="text-sm text-gray-700">Active</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2 border-2 border-white"></div>
                                <span class="text-sm text-gray-700">Maintenance</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-red-500 rounded-full mr-2 border-2 border-white"></div>
                                <span class="text-sm text-gray-700">Offline</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="space-y-3">
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-600">Total Ruangan Lantai {{ $floor->floor_number }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $floor->total_rooms }}</p>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-600">Total AP Lantai {{ $floor->floor_number }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $floor->total_access_points }}</p>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-800">
                            <strong>Petunjuk:</strong><br>
                            Klik pada titik access point untuk membuat laporan ticket.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AP Modal -->
    <div id="apModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
        style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900" id="apModalTitle"></h3>
                <button onclick="closeAPModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div id="apModalContent" class="space-y-4">
                <!-- Content will be injected by JavaScript -->
            </div>

            <div class="mt-6 flex space-x-3">
                <button onclick="closeAPModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <a id="createTicketBtn" href="#"
                    class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 text-center">
                    Buat Ticket
                </a>
            </div>
        </div>
    </div>

    <script>
        const accessPoints = @json($floor->rooms->flatMap->accessPoints);

        function showAPModal(apId) {
            const ap = accessPoints.find(a => a.id === apId);
            if (!ap) return;

            if (ap.status === 'maintenance') {
                Swal.fire({
                    icon: 'warning',
                    title: 'AP Sedang Maintenance',
                    text: 'Access Point ini sedang dalam maintenance. Tidak dapat membuat ticket baru.',
                    confirmButtonColor: '#14b8a6'
                });
                return;
            }

            const statusBadge = {
                'active': '<span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>',
                'offline': '<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Offline</span>',
                'maintenance': '<span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Maintenance</span>'
            };

            document.getElementById('apModalTitle').textContent = ap.name;
            document.getElementById('apModalContent').innerHTML = `
        <div class="space-y-3">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Status</p>
                ${statusBadge[ap.status]}
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Lokasi</p>
                <p class="font-medium text-gray-900">{{ $building->name }}</p>
                <p class="text-sm text-gray-600">{{ $floor->display_name }} - ${ap.room?.name || 'Unknown Room'}</p>
            </div>
            ${ap.notes ? `
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm text-gray-600 mb-1">Catatan</p>
                                    <p class="text-sm text-gray-900">${ap.notes}</p>
                                </div>
                                ` : ''}
        </div>
    `;

            document.getElementById('createTicketBtn').href = `/tickets/create/${ap.id}`;

            // Show modal
            document.getElementById('apModal').style.display = 'flex';
        }

        function closeAPModal() {
            document.getElementById('apModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('apModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAPModal();
            }
        });

        // Add hover effect to AP markers
        document.querySelectorAll('.ap-group').forEach(group => {
            group.addEventListener('mouseenter', function() {
                const circle = this.querySelector('.ap-marker');
                circle.setAttribute('r', '12');
            });

            group.addEventListener('mouseleave', function() {
                const circle = this.querySelector('.ap-marker');
                circle.setAttribute('r', '8');
            });
        });
    </script>
@endsection
