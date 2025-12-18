@extends('layouts.app')

@section('title', 'Manajemen Ruangan - ' . $floor->display_name)
@section('header', 'Manajemen Ruangan')

@section('content')
    <div class="space-y-8">

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
                        <li><a href="{{ route('admin.buildings.show', $floor->building) }}"
                                class="hover:text-teal-600 transition-colors">{{ $floor->building->name }}</a></li>
                        <li><svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></li>
                        <li class="font-medium text-gray-800">{{ $floor->display_name }}</li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">{{ $floor->display_name }}</h1>
            </div>

            <a href="{{ route('admin.floors.rooms.create', $floor) }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-900/20 group">
                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-white transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Ruangan
            </a>
        </div>

        <div
            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12"></div>
            <div class="absolute -right-6 -bottom-6 text-white/10">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 2H5c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM5 20V4h14l.002 16H5z">
                    </path>
                </svg>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-2xl font-bold mb-1">{{ $floor->building->name }}</h2>
                    <p class="text-blue-200 text-sm font-medium">Manajemen Ruangan - {{ $floor->display_name }}</p>
                </div>

                <div class="flex gap-4">
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20 text-center min-w-[100px]">
                        <span class="block text-xs text-blue-200 uppercase font-bold mb-1">Ruangan</span>
                        <span class="block text-2xl font-bold">{{ $floor->total_rooms }}</span>
                    </div>
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20 text-center min-w-[100px]">
                        <span class="block text-xs text-blue-200 uppercase font-bold mb-1">Total AP</span>
                        <span class="block text-2xl font-bold">{{ $floor->total_access_points }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($floor->rooms as $room)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">

                    <div
                        class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gradient-to-b from-gray-50/50 to-white">
                        <h3
                            class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors leading-tight truncate pr-4">
                            {{ $room->name }}
                        </h3>
                        <div
                            class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="px-6 py-5 flex-1">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-bold text-gray-500 uppercase">Access Points</span>
                                <span
                                    class="text-xs font-bold bg-white border border-gray-200 px-2 py-0.5 rounded-full text-gray-700 shadow-sm">
                                    Total: {{ $room->total_access_points }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-4 text-xs font-medium text-gray-600">
                                <div class="flex items-center" title="Normal">
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-500 mr-2"></div>
                                    {{ $room->active_access_points }}
                                </div>
                                <div class="flex items-center" title="Offline">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-500 mr-2"></div>
                                    {{ $room->offline_access_points }}
                                </div>
                                <div class="flex items-center" title="Maintenance">
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 mr-2"></div>
                                    {{ $room->maintenance_access_points }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center gap-2">
                        <a href="{{ route('admin.rooms.access-points.index', $room) }}"
                            class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-lg hover:bg-teal-50 hover:text-teal-700 hover:border-teal-200 transition-all shadow-sm">
                            Kelola AP
                        </a>

                        <a href="{{ route('admin.rooms.edit', $room) }}"
                            class="p-2 bg-white border border-gray-200 text-gray-400 hover:text-blue-600 hover:border-blue-200 rounded-lg transition-colors shadow-sm"
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                            id="delete-room-{{ $room->id }}">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDeleteRoom({{ $room->id }}, '{{ $room->name }}')"
                                class="p-2 bg-white border border-gray-200 text-gray-400 hover:text-red-600 hover:border-red-200 rounded-lg transition-colors shadow-sm"
                                title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center text-center">
                    <div class="bg-gray-100 rounded-full p-6 mb-4">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Belum ada ruangan</h3>
                    <p class="text-gray-500 mt-2 mb-8 max-w-sm">Tambahkan ruangan ke lantai ini untuk mulai menempatkan
                        Access Point.</p>
                    <a href="{{ route('admin.floors.rooms.create', $floor) }}"
                        class="px-6 py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-600/20">
                        + Tambah Ruangan Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function confirmDeleteRoom(roomId, roomName) {
            Swal.fire({
                title: 'Hapus Ruangan?',
                html: `<div class="text-sm text-gray-600">Anda akan menghapus: <span class="font-bold text-gray-900">${roomName}</span></div>
                       <div class="mt-3 p-3 bg-red-50 text-red-800 text-xs rounded-lg border border-red-200 text-left">
                           <strong>⚠️ Peringatan:</strong> Semua Access Point di dalam ruangan ini akan ikut terhapus permanen.
                       </div>`,
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
                    document.getElementById(`delete-room-${roomId}`).submit();
                }
            });
        }
    </script>
@endsection
