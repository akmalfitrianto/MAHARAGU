@extends('layouts.app')

@section('title', 'Detail Tiket #' . $ticket->ticket_number)
@section('header', 'Detail Laporan')

@section('content')
    <div class="max-w-6xl mx-auto pb-12">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li>
                            <a href="{{ auth()->user()->isSuperAdmin() ? route('tickets.index') : route('tickets.my') }}"
                                class="hover:text-teal-600 transition-colors">
                                {{ auth()->user()->isSuperAdmin() ? 'Semua Tiket' : 'Tiket Saya' }}
                            </a>
                        </li>
                        <li><svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg></li>
                        <li class="font-medium text-gray-800">{{ $ticket->ticket_number }}</li>
                    </ol>
                </nav>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tiket #{{ $ticket->ticket_number }}</h1>

                    @php
                        $statusColors = [
                            'open' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'in_progress' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'resolved' => 'bg-green-100 text-green-700 border-green-200',
                            'closed' => 'bg-gray-100 text-gray-600 border-gray-200',
                        ];
                        $statusClass = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <span
                        class="px-3 py-1 text-xs font-bold uppercase tracking-wider border rounded-full {{ $statusClass }}">
                        {{ $ticket->status_label }}
                    </span>
                </div>
            </div>

            <div class="text-sm text-gray-500 text-right hidden sm:block">
                <p>Dilaporkan pada:</p>
                <p class="font-medium text-gray-800">{{ $ticket->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Detail Masalah</h3>
                        <span
                            class="text-xs font-mono text-gray-400 bg-white border px-2 py-1 rounded">{{ $ticket->category }}</span>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $ticket->description }}</p>
                    </div>
                </div>

                @if ($ticket->resolution_notes)
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-24 h-24 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold text-green-800 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Laporan Penyelesaian
                            </h3>
                            <div class="bg-white/60 rounded-xl p-4 border border-green-100 mb-3">
                                <p class="text-green-900">{{ $ticket->resolution_notes }}</p>
                            </div>
                            <div class="flex items-center text-sm text-green-700">
                                <span class="mr-2">Diselesaikan oleh:</span>
                                <span
                                    class="font-bold bg-green-200/50 px-2 py-0.5 rounded text-green-900">{{ $ticket->resolver->name ?? 'Admin' }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $ticket->resolved_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->isSuperAdmin() && !in_array($ticket->status, ['closed']))
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Tindak Lanjut (Admin)
                        </h3>

                        <form method="POST" action="{{ route('tickets.update.status', $ticket) }}" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Update
                                        Status</label>
                                    <div class="relative">
                                        <select name="status"
                                            class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:bg-white appearance-none transition-all cursor-pointer">
                                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open
                                            </option>
                                            <option value="in_progress"
                                                {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan
                                            </option>
                                            <option value="resolved"
                                                {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Selesai (Resolved)
                                            </option>
                                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>
                                                Tutup (Closed)</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Catatan
                                    Tambahan / Penyelesaian</label>
                                <textarea name="resolution_notes" rows="4" placeholder="Tuliskan tindakan yang diambil..."
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:bg-white resize-none transition-all">{{ $ticket->resolution_notes }}</textarea>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                                <button type="submit"
                                    class="flex-1 px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-900/20">
                                    Simpan Perubahan
                                </button>

                                @if ($ticket->status !== 'resolved')
                                    <button type="button" onclick="markAsResolved()"
                                        class="flex-none px-6 py-3 bg-green-50 text-green-700 font-bold rounded-xl border border-green-200 hover:bg-green-100 hover:text-green-800 transition-colors">
                                        ✓ Tandai Selesai
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4 border-b pb-2">Perangkat Terkait
                    </h3>

                    <div class="flex items-start space-x-4 mb-4">
                        <div
                            class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center text-teal-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ $ticket->accessPoint->name }}</p>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide mt-1
                                {{ $ticket->accessPoint->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $ticket->accessPoint->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-500">Gedung</span>
                            <span
                                class="font-medium text-gray-800">{{ $ticket->accessPoint->room->floor->building->name }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-gray-500">Lantai</span>
                            <span
                                class="font-medium text-gray-800">{{ $ticket->accessPoint->room->floor->display_name }}</span>
                        </div>
                        <div class="flex justify-between pb-2">
                            <span class="text-gray-500">Ruangan</span>
                            <span class="font-medium text-gray-800">{{ $ticket->accessPoint->room->name }}</span>
                        </div>
                    </div>

                    <a href="{{ route('building.floor', [$ticket->accessPoint->room->floor->building, $ticket->accessPoint->room->floor]) }}"
                        class="mt-4 block w-full py-2.5 bg-gray-50 text-gray-600 text-center text-sm font-bold rounded-xl border border-gray-200 hover:bg-white hover:text-teal-600 hover:border-teal-200 transition-all">
                        Lihat Lokasi di Peta
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4 border-b pb-2">Pelapor</h3>
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                            {{ substr($ticket->admin->name, 0, 2) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="font-bold text-gray-900 truncate">{{ $ticket->admin->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $ticket->admin->unit_kerja }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">Riwayat Status</h3>

                    <div class="relative pl-4 border-l-2 border-gray-100 space-y-8">
                        <div class="relative">
                            <div
                                class="absolute -left-[21px] top-1 w-3.5 h-3.5 bg-blue-500 rounded-full border-2 border-white shadow-sm">
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Tiket Dibuat</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $ticket->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        @if ($ticket->status === 'in_progress' || $ticket->resolved_at || $ticket->closed_at)
                            <div class="relative">
                                <div
                                    class="absolute -left-[21px] top-1 w-3.5 h-3.5 bg-yellow-400 rounded-full border-2 border-white shadow-sm">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Sedang Diproses</p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{-- Gunakan logika updated_at jika belum selesai --}}
                                        {{ $ticket->resolved_at ? 'Diproses sebelum selesai' : $ticket->updated_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($ticket->resolved_at)
                            <div class="relative">
                                <div
                                    class="absolute -left-[21px] top-1 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white shadow-sm">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-green-700">Masalah Selesai</p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $ticket->resolved_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($ticket->closed_at)
                            <div class="relative">
                                <div
                                    class="absolute -left-[21px] top-1 w-3.5 h-3.5 bg-gray-500 rounded-full border-2 border-white shadow-sm">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-600">Tiket Ditutup</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $ticket->closed_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const updateStatusForm = document.querySelector('form[action="{{ route('tickets.update.status', $ticket) }}"]');

        function markAsResolved() {
            // Trigger tombol "Mark Resolved"
            if (!updateStatusForm) return;

            Swal.fire({
                title: 'Selesaikan Tiket?',
                html: `
                    <div class="text-left">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Penyelesaian <span class="text-red-500">*</span></label>
                        <textarea id="swalNotes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" rows="3" placeholder="Contoh: AP sudah di-restart dan normal kembali."></textarea>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Selesaikan',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const notes = document.getElementById('swalNotes').value;
                    if (!notes) {
                        Swal.showValidationMessage('Mohon isi catatan penyelesaian');
                    }
                    return notes;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const statusSelect = updateStatusForm.querySelector('select[name="status"]');
                    const notesArea = updateStatusForm.querySelector('textarea[name="resolution_notes"]');

                    if (statusSelect) statusSelect.value = 'resolved';
                    if (notesArea) notesArea.value = result.value;

                    updateStatusForm.submit();
                }
            });
        }

        if (updateStatusForm) {
            updateStatusForm.addEventListener('submit', function(e) {
                // Konfirmasi standar saat klik tombol "Simpan Perubahan"
                e.preventDefault();
                const currentStatus = '{{ $ticket->status }}';
                const newStatus = this.querySelector('select[name="status"]').value;

                if (newStatus === currentStatus && newStatus !==
                    'resolved') { // Allow adding notes without status change
                    // Optional check logic here
                }

                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: 'Status tiket akan diperbarui.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1f2937',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        }
    </script>
@endsection
