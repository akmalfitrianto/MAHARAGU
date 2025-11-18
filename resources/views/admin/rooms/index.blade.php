@extends('layouts.app')

@section('title', 'Manajemen Ruangan - ' . $floor->display_name)
@section('header', 'Manajemen Ruangan')

@section('content')
    <div class="space-y-6">
        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.buildings.index') }}" class="text-gray-500 hover:text-gray-700">Manajemen
                        Gedung</a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <a href="{{ route('admin.buildings.show', $floor->building) }}"
                        class="text-gray-500 hover:text-gray-700">{{ $floor->building->name }}</a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-gray-900 font-medium">{{ $floor->display_name }}</span>
                </li>
            </ol>
        </nav>

        <!-- Floor Info Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-1">{{ $floor->building->name }}</h1>
                    <p class="text-blue-100">{{ $floor->display_name }} - Manajemen Ruangan</p>
                </div>
                <a href="{{ route('admin.floors.rooms.create', $floor) }}"
                    class="px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Ruangan</span>
                </a>
            </div>
            <div class="mt-4 grid grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-blue-100">Total Ruangan</p>
                    <p class="text-xl font-bold">{{ $floor->total_rooms }}</p>
                </div>
                <div>
                    <p class="text-blue-100">Total AP</p>
                    <p class="text-xl font-bold">{{ $floor->total_access_points }}</p>
                </div>
                <div>
                    <p class="text-blue-100">AP Aktif</p>
                    <p class="text-xl font-bold text-green-300">{{ $floor->active_access_points }}</p>
                </div>
                <div>
                    <p class="text-blue-100">AP Offline</p>
                    <p class="text-xl font-bold text-red-300">{{ $floor->offline_access_points }}</p>
                </div>
            </div>
        </div>

        <!-- Rooms Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($floor->rooms as $room)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                    <!-- Room Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $room->name }}</h3>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                    {{ ucfirst(str_replace('_', ' ', $room->shape_type)) }}
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Room Stats -->
                    <div class="p-6">
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Access Points:</span>
                                <span class="font-bold text-gray-900">{{ $room->total_access_points }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Ukuran:</span>
                                <span class="font-medium text-gray-900">{{ $room->width }} x {{ $room->height }}
                                    px</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Posisi:</span>
                                <span class="font-medium text-gray-900">({{ $room->position_x }},
                                    {{ $room->position_y }})</span>
                            </div>
                        </div>

                        <!-- AP Status -->
                        <div class="flex items-center justify-between text-xs mb-4 p-3 bg-gray-50 rounded-lg">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                                {{ $room->active_access_points }}
                            </span>
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                                {{ $room->offline_access_points }}
                            </span>
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></span>
                                {{ $room->maintenance_access_points }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-2">
                            <a href="{{ route('admin.rooms.access-points.index', $room) }}"
                                class="block w-full px-4 py-2 bg-teal-500 text-white text-center text-sm font-medium rounded-lg hover:bg-teal-600 transition">
                                Kelola Access Points
                            </a>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('admin.rooms.edit', $room) }}"
                                    class="px-4 py-2 bg-blue-500 text-white text-center text-sm font-medium rounded-lg hover:bg-blue-600 transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus ruangan ini? Semua AP di dalamnya akan ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="confirmDeleteRoom({{ $room->id }}, '{{ $room->name }}')"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Hapus Ruangan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <p class="text-gray-500 mb-4">Belum ada ruangan di {{ $floor->display_name }}</p>
                    <a href="{{ route('admin.floors.rooms.create', $floor) }}"
                        class="inline-block px-4 py-2 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600">
                        Tambah Ruangan Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
    <script>
        function confirmDeleteRoom(roomId, roomName) {
            Swal.fire({
                title: 'Hapus Ruangan?',
                html: `Apakah Anda yakin ingin menghapus ruangan <strong>${roomName}</strong>?<br><br>
               <span class="text-red-600 text-sm">Semua access point di ruangan ini akan ikut terhapus!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById(`delete-room-${roomId}`).submit();
                }
            });
        }
    </script>
@endsection
