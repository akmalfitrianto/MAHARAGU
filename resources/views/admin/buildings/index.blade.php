@extends('layouts.app')

@section('title', 'Manajemen Gedung')
@section('header', 'Daftar Gedung')

@section('content')
    <div class="space-y-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen Gedung</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data gedung, lantai, dan ruangan kampus.</p>
            </div>
            <a href="{{ route('admin.buildings.create') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-900/20 group">
                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-white transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Gedung
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($buildings as $building)
                @php
                    // Dynamic Gradient Theme
                    $themes = [
                        ['bg' => 'from-blue-500 to-indigo-600', 'text' => 'text-indigo-100'],
                        ['bg' => 'from-teal-500 to-emerald-600', 'text' => 'text-emerald-100'],
                        ['bg' => 'from-violet-500 to-purple-600', 'text' => 'text-purple-100'],
                        ['bg' => 'from-orange-400 to-pink-600', 'text' => 'text-pink-100'],
                    ];
                    $theme = $themes[$building->id % 4];
                @endphp

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">

                    <div
                        class="relative h-28 bg-gradient-to-br {{ $theme['bg'] }} p-6 flex flex-col justify-end overflow-hidden">

                        <div
                            class="absolute -right-6 -top-6 opacity-20 transform rotate-12 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 2H5c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM5 20V4h14l.002 16H5z">
                                </path>
                            </svg>
                        </div>

                        <div class="relative z-10">
                            <h3 class="text-xl font-bold text-white leading-tight text-shadow-sm mb-1">
                                {{ $building->name }}
                            </h3>
                            <p class="text-xs font-medium {{ $theme['text'] }} opacity-90">
                                {{ $building->total_floors }} Lantai
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-5 flex-1 flex flex-col gap-5">

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 rounded-lg p-2.5 border border-gray-100 text-center">
                                <span
                                    class="block text-gray-400 text-[10px] font-bold uppercase tracking-wider">Ruangan</span>
                                <span class="block text-lg font-bold text-gray-800">{{ $building->total_rooms }}</span>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2.5 border border-gray-100 text-center">
                                <span class="block text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total
                                    AP</span>
                                <span
                                    class="block text-lg font-bold text-gray-800">{{ $building->total_access_points }}</span>
                            </div>
                        </div>

                        <div class="space-y-2 mt-auto">
                            <div class="flex justify-between text-[11px] font-medium text-gray-500">
                                <span>Status Perangkat</span>
                                @if ($building->offline_access_points > 0)
                                    <span class="text-red-500 font-bold">{{ $building->offline_access_points }}
                                        Bermasalah</span>
                                @else
                                    <span class="text-green-600">Semua Normal</span>
                                @endif
                            </div>

                            <div class="flex h-2.5 w-full rounded-full bg-gray-100 overflow-hidden">
                                @if ($building->total_access_points > 0)
                                    @php
                                        $total = $building->total_access_points;
                                        $p_active = ($building->active_access_points / $total) * 100;
                                        $p_offline = ($building->offline_access_points / $total) * 100;
                                        $p_maint = ($building->maintenance_access_points / $total) * 100;
                                    @endphp

                                    <div class="bg-green-500 hover:bg-green-400 transition-colors"
                                        style="width: {{ $p_active }}%"
                                        title="{{ $building->active_access_points }} Active"></div>
                                    <div class="bg-red-500 hover:bg-red-400 transition-colors"
                                        style="width: {{ $p_offline }}%"
                                        title="{{ $building->offline_access_points }} Offline"></div>
                                    <div class="bg-yellow-400 hover:bg-yellow-300 transition-colors"
                                        style="width: {{ $p_maint }}%"
                                        title="{{ $building->maintenance_access_points }} Maintenance"></div>
                                @else
                                    <div class="bg-gray-200 w-full"></div>
                                @endif
                            </div>

                            <div class="flex justify-start space-x-3 text-[10px] text-gray-400">
                                <div class="flex items-center"><span
                                        class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>{{ $building->active_access_points }}
                                </div>
                                <div class="flex items-center"><span
                                        class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>{{ $building->offline_access_points }}
                                </div>
                                <div class="flex items-center"><span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-400 mr-1.5"></span>{{ $building->maintenance_access_points }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-3">
                        <a href="{{ route('admin.buildings.show', $building) }}"
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-lg hover:bg-teal-50 hover:text-teal-700 hover:border-teal-200 transition-all shadow-sm group/btn">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-1.5 text-gray-400 group-hover/btn:text-teal-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                        <div class="flex items-center space-x-1">
                            <a href="{{ route('admin.buildings.edit', $building) }}"
                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                title="Edit Data">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </a>

                            <button type="button"
                                onclick="confirmDeleteBuilding({{ $building->id }}, '{{ $building->name }}')"
                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                title="Hapus Gedung">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>

                            <form id="delete-building-{{ $building->id }}"
                                action="{{ route('admin.buildings.destroy', $building) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center text-center">
                    <div class="bg-gray-100 rounded-full p-6 mb-4">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Belum ada gedung</h3>
                    <p class="text-gray-500 mt-2 mb-8 max-w-sm">Data gedung diperlukan untuk memetakan lantai dan
                        menempatkan access point.</p>
                    <a href="{{ route('admin.buildings.create') }}"
                        class="px-6 py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-600/20">
                        + Tambah Gedung Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function confirmDeleteBuilding(buildingId, buildingName) {
            Swal.fire({
                title: 'Hapus Gedung?',
                html: `<div class="text-sm text-gray-600">Anda akan menghapus: <span class="font-bold text-gray-900">${buildingName}</span></div>
                       <div class="mt-3 p-3 bg-red-50 text-red-800 text-xs rounded-lg border border-red-200 text-left">
                           <strong>⚠️ Peringatan Fatal:</strong><br>
                           Tindakan ini akan menghapus permanen:<br>
                           • Semua Lantai di gedung ini<br>
                           • Semua Ruangan<br>
                           • Semua Access Point<br>
                           • Semua Tiket Laporan terkait
                       </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#e5e7eb',
                confirmButtonText: 'Ya, Hapus Permanen',
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
                    document.getElementById(`delete-building-${buildingId}`).submit();
                }
            });
        }
    </script>
@endsection
