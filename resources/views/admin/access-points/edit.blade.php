@extends('layouts.app')

@section('title', 'Edit Access Point')
@section('header', 'Edit Access Point')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('admin.buildings.index') }}" class="text-gray-500 hover:text-gray-700">Manajemen Gedung</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('admin.buildings.show', $accessPoint->room->floor->building) }}" class="text-gray-500 hover:text-gray-700">{{ $accessPoint->room->floor->building->name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('admin.floors.rooms.index', $accessPoint->room->floor) }}" class="text-gray-500 hover:text-gray-700">{{ $accessPoint->room->floor->display_name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('admin.rooms.access-points.index', $accessPoint->room) }}" class="text-gray-500 hover:text-gray-700">{{ $accessPoint->room->name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <span class="text-gray-900 font-medium">Edit {{ $accessPoint->name }}</span>
            </li>
        </ol>
    </nav>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- AP Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Total Tickets</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $accessPoint->tickets()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Open Tickets</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $accessPoint->openTickets()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Resolved</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $accessPoint->tickets()->where('status', 'resolved')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning if has open tickets -->
    @if($accessPoint->openTickets()->count() > 0)
    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="text-sm text-yellow-800">
                <p class="font-medium mb-1">Perhatian:</p>
                <p class="text-xs">Access Point ini memiliki {{ $accessPoint->openTickets()->count() }} open ticket. Pertimbangkan untuk menyelesaikan ticket terlebih dahulu sebelum mengubah status.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Edit Informasi Access Point</h2>

        <form method="POST" action="{{ route('admin.access-points.update', $accessPoint) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Access Point <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       value="{{ old('name', $accessPoint->name) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" 
                        id="status"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <option value="active" {{ old('status', $accessPoint->status) === 'active' ? 'selected' : '' }}>Active (Aktif)</option>
                    <option value="offline" {{ old('status', $accessPoint->status) === 'offline' ? 'selected' : '' }}>Offline (Mati)</option>
                    <option value="maintenance" {{ old('status', $accessPoint->status) === 'maintenance' ? 'selected' : '' }}>Maintenance (Pemeliharaan)</option>
                </select>
            </div>

            <!-- Position -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="position_x" class="block text-sm font-medium text-gray-700 mb-2">
                        Posisi X <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="position_x" 
                           id="position_x"
                           value="{{ old('position_x', $accessPoint->position_x) }}"
                           min="0"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="position_y" class="block text-sm font-medium text-gray-700 mb-2">
                        Posisi Y <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="position_y" 
                           id="position_y"
                           value="{{ old('position_y', $accessPoint->position_y) }}"
                           min="0"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan
                    <span class="text-gray-500 font-normal">(Opsional)</span>
                </label>
                <textarea name="notes" 
                          id="notes"
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 resize-none">{{ old('notes', $accessPoint->notes) }}</textarea>
            </div>

            <!-- Location Info -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-sm font-medium text-gray-700 mb-2">Lokasi:</p>
                <div class="text-sm text-gray-600 space-y-1">
                    <p><span class="font-medium">Gedung:</span> {{ $accessPoint->room->floor->building->name }}</p>
                    <p><span class="font-medium">Lantai:</span> {{ $accessPoint->room->floor->display_name }}</p>
                    <p><span class="font-medium">Ruangan:</span> {{ $accessPoint->room->name }}</p>
                    <p><span class="font-medium">Dibuat:</span> {{ $accessPoint->created_at->format('d M Y H:i') }}</p>
                    <p><span class="font-medium">Terakhir Update:</span> {{ $accessPoint->updated_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.rooms.access-points.index', $accessPoint->room) }}" 
                   class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-center transition">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 px-6 py-3 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition shadow-lg hover:shadow-xl">
                    Update Access Point
                </button>
            </div>
        </form>
    </div>
</div>
@endsection