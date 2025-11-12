@extends('layouts.app')

@section('title', 'Manajemen Access Point - ' . $room->name)
@section('header', 'Manajemen Access Point')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
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
                <a href="{{ route('admin.buildings.show', $room->floor->building) }}" class="text-gray-500 hover:text-gray-700">{{ $room->floor->building->name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('admin.floors.rooms.index', $room->floor) }}" class="text-gray-500 hover:text-gray-700">{{ $room->floor->display_name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <span class="text-gray-900 font-medium">{{ $room->name }}</span>
            </li>
        </ol>
    </nav>

    <!-- Room Info Header -->
    <div class="bg-gradient-to-r from-teal-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-1">{{ $room->name }}</h1>
                <p class="text-teal-100">{{ $room->floor->building->name }} - {{ $room->floor->display_name }}</p>
            </div>
            <a href="{{ route('admin.rooms.access-points.create', $room) }}" 
               class="px-4 py-2 bg-white text-teal-600 font-medium rounded-lg hover:bg-teal-50 transition flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Access Point</span>
            </a>
        </div>
        <div class="mt-4 grid grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-teal-100">Total AP</p>
                <p class="text-xl font-bold">{{ $room->total_access_points }}</p>
            </div>
            <div>
                <p class="text-teal-100">Aktif</p>
                <p class="text-xl font-bold text-green-300">{{ $room->active_access_points }}</p>
            </div>
            <div>
                <p class="text-teal-100">Offline</p>
                <p class="text-xl font-bold text-red-300">{{ $room->offline_access_points }}</p>
            </div>
            <div>
                <p class="text-teal-100">Maintenance</p>
                <p class="text-xl font-bold text-yellow-300">{{ $room->maintenance_access_points }}</p>
            </div>
        </div>
    </div>

    <!-- Access Points Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Access Points</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama AP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi (X, Y)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Open Tickets</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($room->accessPoints as $ap)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" 
                                     style="background-color: {{ $ap->status_color }}20;">
                                    <svg class="w-5 h-5" style="color: {{ $ap->status_color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $ap->name }}</p>
                                    <p class="text-xs text-gray-500">ID: {{ $ap->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.access-points.status', $ap) }}" class="inline-block">
                                @csrf
                                @method('PUT')
                                <select name="status" 
                                        onchange="this.form.submit()"
                                        class="px-3 py-1 text-xs font-medium rounded-full border-0 focus:ring-2 focus:ring-teal-500
                                               {{ $ap->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                  ($ap->status === 'offline' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    <option value="active" {{ $ap->status === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="offline" {{ $ap->status === 'offline' ? 'selected' : '' }}>Offline</option>
                                    <option value="maintenance" {{ $ap->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ({{ $ap->position_x }}, {{ $ap->position_y }})
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($ap->openTickets()->count() > 0)
                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                {{ $ap->openTickets()->count() }} Open
                            </span>
                            @else
                            <span class="text-sm text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $ap->notes ? Str::limit($ap->notes, 30) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('admin.access-points.edit', $ap) }}" 
                               class="text-blue-600 hover:text-blue-900 font-medium">
                                Edit
                            </a>
                            <form method="POST" 
                                  action="{{ route('admin.access-points.destroy', $ap) }}" 
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus Access Point ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900 font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                            </svg>
                            <p class="text-sm mb-4">Belum ada Access Point di ruangan ini</p>
                            <a href="{{ route('admin.rooms.access-points.create', $room) }}" 
                               class="inline-block px-4 py-2 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600">
                                Tambah Access Point Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection