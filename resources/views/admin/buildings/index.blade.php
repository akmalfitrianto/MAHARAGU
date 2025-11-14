@extends('layouts.app')

@section('title', 'Manajemen Gedung')
@section('header', 'Manajemen Gedung')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Gedung</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola data gedung kampus</p>
            </div>
            <a href="{{ route('admin.buildings.create') }}"
                class="px-4 py-2 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition shadow-lg hover:shadow-xl flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Gedung</span>
            </a>
        </div>

        <!-- Buildings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($buildings as $building)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $building->name }}</h3>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Lantai:</span>
                                <span class="font-medium text-gray-900">{{ $building->total_floors }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Ruangan:</span>
                                <span class="font-medium text-gray-900">{{ $building->total_rooms }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Access Point:</span>
                                <span class="font-medium text-gray-900">{{ $building->total_access_points }}</span>
                            </div>
                        </div>

                        <!-- AP Status -->
                        <div class="flex items-center space-x-3 mb-4 text-xs">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                                {{ $building->active_access_points }}
                            </span>
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                                {{ $building->offline_access_points }}
                            </span>
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></span>
                                {{ $building->maintenance_access_points }}
                            </span>
                        </div>

                        <!-- Shape Badge -->
                        <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded mb-4">
                            {{ ucfirst(str_replace('_', ' ', $building->shape_type)) }}
                        </span>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.buildings.edit', $building) }}"
                                class="flex-1 px-4 py-2 bg-blue-500 text-white text-center text-sm font-medium rounded-lg hover:bg-blue-600 transition">
                                Edit
                            </a>
                            <a href="{{ route('admin.buildings.show', $building) }}"
                                class="flex-1 px-4 py-2 bg-gray-500 text-white text-center text-sm font-medium rounded-lg hover:bg-gray-600 transition">
                                Detail
                            </a>
                            <form method="POST" action="{{ route('admin.buildings.destroy', $building) }}"
                                id="delete-building-{{ $building->id }}" class="flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="confirmDeleteBuilding({{ $building->id }}, '{{ $building->name }}')"
                                    class="px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <p class="text-gray-500 mb-4">Belum ada gedung</p>
                    <a href="{{ route('admin.buildings.create') }}"
                        class="inline-block px-4 py-2 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600">
                        Tambah Gedung Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function confirmDeleteBuilding(buildingId, buildingName) {
            Swal.fire({
                title: 'Hapus Gedung?',
                html: `Apakah Anda yakin ingin menghapus gedung <strong>${buildingName}</strong>?<br><br>
               <span class="text-red-600 text-sm">⚠️ Semua lantai, ruangan, dan access point akan ikut terhapus!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    document.getElementById(`delete-building-${buildingId}`).submit();
                }
            });
        }
    </script>
@endsection
