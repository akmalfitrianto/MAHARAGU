@extends('layouts.app')

@section('title', 'Semua Ruangan')
@section('header', 'Semua Ruangan')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, ...addRoomModal() }">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold mb-1">Manajemen Ruangan</h1>
                <p class="text-blue-100">Kelola semua ruangan dari berbagai gedung dan lantai</p>
            </div>
            <button @click="showModal = true"
                class="px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Ruangan</span>
            </button>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-blue-100">Total Ruangan</p>
                <p class="text-xl font-bold">{{ $rooms->total() }}</p>
            </div>
            <div>
                <p class="text-blue-100">Total AP</p>
                <p class="text-xl font-bold">{{ $rooms->sum('total_access_points') }}</p>
            </div>
            <div>
                <p class="text-blue-100">AP Normal</p>
                <p class="text-xl font-bold text-green-300">{{ $rooms->sum('active_access_points') }}</p>
            </div>
            <div>
                <p class="text-blue-100">AP Bermasalah</p>
                <p class="text-xl font-bold text-red-300">{{ $rooms->sum('offline_access_points') }}</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="space-y-4" x-data="filterForm()">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Ruangan</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama ruangan..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Building Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gedung</label>
                    <select name="building_id" x-model="building_id" @change="loadFloors()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Gedung</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"
                                {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Floor Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lantai</label>
                    <select name="floor_id" x-model="floor_id" :disabled="!building_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 disabled:bg-gray-100">
                        <option value="">Semua Lantai</option>
                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}"
                                {{ request('floor_id') == $floor->id ? 'selected' : '' }}>
                                {{ $floor->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition">
                        Filter
                    </button>
                    <a href="{{ route('admin.rooms.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rooms as $room)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                <!-- Room Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $room->name }}</h3>
                            <p class="text-xs text-gray-500">
                                {{ $room->floor->building->name }} - {{ $room->floor->display_name }}
                            </p>
                        </div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                            {{ ucfirst(str_replace('_', ' ', $room->shape_type)) }}
                        </span>
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
                        <div class="grid grid-cols-3 gap-2">
                            <a href="{{ route('admin.floors.rooms.index', $room->floor) }}"
                               class="px-3 py-2 bg-gray-500 text-white text-center text-xs font-medium rounded-lg hover:bg-gray-600 transition">
                                Lantai
                            </a>
                            <a href="{{ route('admin.rooms.edit', $room) }}"
                                class="px-3 py-2 bg-blue-500 text-white text-center text-xs font-medium rounded-lg hover:bg-blue-600 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                                onsubmit="return confirm('Yakin ingin menghapus ruangan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-3 py-2 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition">
                                    Hapus
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
                <p class="text-gray-500 mb-4">Tidak ada ruangan yang sesuai dengan filter</p>
                <a href="{{ route('admin.buildings.index') }}"
                    class="inline-block px-4 py-2 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600">
                    Kelola Gedung
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($rooms->hasPages())
        <div class="mt-6">
            {{ $rooms->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- Modal Tambah Ruangan -->
    <div x-show="showModal" 
         @click.self="showModal = false"
         class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6" @click.stop>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Tambah Ruangan Baru</h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <p class="text-sm text-gray-600">Pilih lokasi untuk ruangan baru:</p>

                <!-- Select Building -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gedung</label>
                    <select x-model="selectedBuilding" @change="loadFloors()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Pilih Gedung --</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}">{{ $building->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Floor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lantai</label>
                    <select x-model="selectedFloor" :disabled="!selectedBuilding"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 disabled:bg-gray-100">
                        <option value="">-- Pilih Lantai --</option>
                        <template x-for="floor in availableFloors" :key="floor.id">
                            <option :value="floor.id" x-text="floor.display_name"></option>
                        </template>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3 pt-4">
                    <button @click="showModal = false"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button @click="goToCreate()" :disabled="!selectedFloor"
                        :class="selectedFloor ? 'bg-teal-500 hover:bg-teal-600' : 'bg-gray-300 cursor-not-allowed'"
                        class="flex-1 px-4 py-2 text-white font-medium rounded-lg transition">
                        Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addRoomModal() {
        return {
            selectedBuilding: '',
            selectedFloor: '',
            availableFloors: [],

            async loadFloors() {
                if (!this.selectedBuilding) {
                    this.availableFloors = [];
                    this.selectedFloor = '';
                    return;
                }

                try {
                    const response = await fetch(`/api/buildings/${this.selectedBuilding}/floors`);
                    const data = await response.json();
                    this.availableFloors = data;
                } catch (error) {
                    console.error('Error loading floors:', error);
                    alert('Gagal memuat data lantai');
                }
            },

            goToCreate() {
                if (this.selectedFloor) {
                    window.location.href = `/admin/floors/${this.selectedFloor}/rooms/create`;
                }
            }
        }
    }

    function filterForm() {
        return {
            building_id: '{{ request('building_id') }}',
            floor_id: '{{ request('floor_id') }}',

            async loadFloors() {
                if (!this.building_id) {
                    this.floor_id = '';
                    return;
                }

                this.$el.closest('form').submit();
            }
        }
    }
</script>
@endsection