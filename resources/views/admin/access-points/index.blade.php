@extends('layouts.app')

@section('title', 'Manajemen Access Point - ' . $room->name)
@section('header', 'Manajemen Access Point')

@section('content')
    <div class="space-y-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li><a href="{{ route('admin.buildings.index') }}"
                                class="hover:text-teal-600 transition-colors">Gedung</a></li>
                        <li><svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></li>
                        <li><a href="{{ route('admin.buildings.show', $room->floor->building) }}"
                                class="hover:text-teal-600 transition-colors">{{ $room->floor->building->name }}</a></li>
                        <li><svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></li>
                        <li><a href="{{ route('admin.floors.rooms.index', $room->floor) }}"
                                class="hover:text-teal-600 transition-colors">{{ $room->floor->display_name }}</a></li>
                        <li><svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></li>
                        <li class="font-medium text-gray-800">{{ $room->name }}</li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">{{ $room->name }}</h1>
            </div>

            <a href="{{ route('admin.rooms.access-points.create', $room) }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-900/20 group">
                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-white transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah AP
            </a>
        </div>

        <div
            class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12"></div>
            <div class="absolute -right-6 -bottom-6 text-white/10">
                <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                    </path>
                </svg>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-xl font-bold mb-1">Manajemen Perangkat</h2>
                    <p class="text-emerald-100 text-sm">Lokasi: {{ $room->floor->building->name }} •
                        {{ $room->floor->display_name }}</p>
                </div>

                <div class="flex gap-4">
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20 text-center min-w-[100px]">
                        <span class="block text-xs text-emerald-200 uppercase font-bold mb-1">Total AP</span>
                        <span class="block text-2xl font-bold">{{ $room->total_access_points }}</span>
                    </div>
                    <div
                        class="bg-green-500/20 backdrop-blur-sm rounded-xl p-3 border border-green-400/30 text-center min-w-[100px]">
                        <span class="block text-xs text-green-200 uppercase font-bold mb-1">Normal</span>
                        <span class="block text-2xl font-bold text-green-50">{{ $room->active_access_points }}</span>
                    </div>
                    <div
                        class="bg-red-500/20 backdrop-blur-sm rounded-xl p-3 border border-red-400/30 text-center min-w-[100px]">
                        <span class="block text-xs text-red-200 uppercase font-bold mb-1">Bermasalah</span>
                        <span class="block text-2xl font-bold text-red-50">{{ $room->offline_access_points }}</span>
                    </div>
                    <div
                        class="bg-yellow-500/20 backdrop-blur-sm rounded-xl p-3 border border-yellow-400/30 text-center min-w-[100px]">
                        <span class="block text-xs text-yellow-200 uppercase font-bold mb-1">Maintenance</span>
                        <span class="block text-2xl font-bold text-yellow-50">{{ $room->maintenance_access_points }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-800">Daftar Access Point</h2>
            </div>

            <div class="overflow-x-auto rounded-b-2xl">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Perangkat</th>
                            <th class="px-6 py-4">Status & Kontrol</th>
                            <th class="px-6 py-4 text-center">Posisi (X,Y)</th>
                            <th class="px-6 py-4">Tiket</th>
                            <th class="px-6 py-4">Catatan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($room->accessPoints as $ap)
                            <tr class="hover:bg-gray-50/80 transition-colors group">

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 shrink-0"
                                            style="background-color: {{ $ap->status_color }}15; color: {{ $ap->status_color }};">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $ap->name }}</p>
                                            <p class="text-xs text-gray-500 font-mono mt-0.5">ID: {{ $ap->id }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.access-points.status', $ap) }}">
                                        @csrf @method('PUT')
                                        <div class="relative w-32">
                                            <select name="status" onchange="this.form.submit()"
                                                class="appearance-none w-full pl-3 pr-8 py-1.5 text-xs font-bold rounded-lg cursor-pointer focus:ring-2 focus:ring-offset-1 focus:outline-none transition-all
                                                {{ $ap->status === 'active'
                                                    ? 'bg-green-100 text-green-700 border-green-200 focus:ring-green-500'
                                                    : ($ap->status === 'offline'
                                                        ? 'bg-red-100 text-red-700 border-red-200 focus:ring-red-500'
                                                        : 'bg-yellow-100 text-yellow-700 border-yellow-200 focus:ring-yellow-500') }}">
                                                <option value="active" {{ $ap->status === 'active' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="offline" {{ $ap->status === 'offline' ? 'selected' : '' }}>
                                                    Offline</option>
                                                <option value="maintenance"
                                                    {{ $ap->status === 'maintenance' ? 'selected' : '' }}>Maintenance
                                                </option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                                                <svg class="h-3 w-3 {{ $ap->status === 'active' ? 'text-green-600' : ($ap->status === 'offline' ? 'text-red-600' : 'text-yellow-600') }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </form>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block bg-gray-100 text-gray-600 text-xs font-mono px-2 py-1 rounded border border-gray-200">
                                        X:{{ $ap->position_x }} Y:{{ $ap->position_y }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($ap->openTickets()->count() > 0)
                                        <a href="{{ route('tickets.index', ['search' => $ap->name]) }}"
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition-colors">
                                            {{ $ap->openTickets()->count() }} Open
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 max-w-xs">
                                    @if ($ap->notes)
                                        <span class="text-xs text-gray-600 truncate block"
                                            title="{{ $ap->notes }}">{{ Str::limit($ap->notes, 30) }}</span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada catatan</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end items-center space-x-2">
                                        <a href="{{ route('admin.access-points.edit', $ap) }}"
                                            class="p-2 bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 rounded-lg transition-colors shadow-sm"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.access-points.destroy', $ap) }}"
                                            id="delete-ap-{{ $ap->id }}">
                                            @csrf @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDeleteAP({{ $ap->id }}, '{{ $ap->name }}')"
                                                class="p-2 bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-200 rounded-lg transition-colors shadow-sm"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 rounded-full p-4 mb-4">
                                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-gray-900">Belum ada Access Point</h3>
                                        <p class="text-sm text-gray-500 mt-1 mb-4">Ruangan ini belum memiliki perangkat
                                            terdaftar.</p>
                                        <a href="{{ route('admin.rooms.access-points.create', $room) }}"
                                            class="px-4 py-2 bg-teal-600 text-white text-sm font-bold rounded-lg hover:bg-teal-700 transition">
                                            + Tambah AP Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteAP(apId, apName) {
            Swal.fire({
                title: 'Hapus Access Point?',
                html: `<div class="text-sm text-gray-600">Anda akan menghapus: <strong>${apName}</strong></div>
                       <div class="mt-2 text-xs text-red-500">Tindakan ini tidak dapat dibatalkan.</div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#e5e7eb',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: '<span class="text-gray-600">Batal</span>',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    document.getElementById(`delete-ap-${apId}`).submit();
                }
            });
        }
    </script>
@endsection
