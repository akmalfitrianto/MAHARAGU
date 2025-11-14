@extends('layouts.app')

@section('title', 'Ticket Detail')
@section('header', 'Ticket Detail')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ auth()->user()->isSuperAdmin() ? route('tickets.index') : route('tickets.my') }}"
                        class="text-gray-500 hover:text-gray-700">
                        {{ auth()->user()->isSuperAdmin() ? 'All Tickets' : 'My Tickets' }}
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-gray-900 font-medium">{{ $ticket->ticket_number }}</span>
                </li>
            </ol>
        </nav>

        <!-- Ticket Header -->
        <div class="bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $ticket->ticket_number }}</h1>
                    <p class="text-teal-100">{{ $ticket->category }}</p>
                </div>
                <span
                    class="px-4 py-2 text-sm font-medium rounded-full {{ $ticket->status === 'open' ? 'bg-blue-500' : ($ticket->status === 'in_progress' ? 'bg-yellow-500' : ($ticket->status === 'resolved' ? 'bg-green-500' : 'bg-gray-500')) }}">
                    {{ $ticket->status_label }}
                </span>
            </div>
            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-teal-100">Dibuat</p>
                    <p class="font-semibold">{{ $ticket->created_at->format('d M Y H:i') }}</p>
                </div>
                @if ($ticket->resolved_at)
                    <div>
                        <p class="text-teal-100">Diselesaikan</p>
                        <p class="font-semibold">{{ $ticket->resolved_at->format('d M Y H:i') }}</p>
                    </div>
                @endif
                @if ($ticket->closed_at)
                    <div>
                        <p class="text-teal-100">Ditutup</p>
                        <p class="font-semibold">{{ $ticket->closed_at->format('d M Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Problem Description -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Masalah</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $ticket->description }}</p>
                </div>

                <!-- Resolution Notes (if resolved) -->
                @if ($ticket->resolution_notes)
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-green-900 mb-2">Catatan Penyelesaian</h3>
                                <p class="text-green-800 mb-2">{{ $ticket->resolution_notes }}</p>
                                <p class="text-sm text-green-700">
                                    Diselesaikan oleh: <span class="font-medium">{{ $ticket->resolver->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Update Status (Superadmin Only) -->
                @if (auth()->user()->isSuperAdmin() && !in_array($ticket->status, ['closed']))
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status Ticket</h2>

                        <form method="POST" action="{{ route('tickets.update.status', $ticket) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>
                                        In Progress</option>
                                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>
                                        Resolved</option>
                                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan Penyelesaian
                                    <span class="text-gray-500 font-normal">(Opsional)</span>
                                </label>
                                <textarea name="resolution_notes" rows="4" placeholder="Jelaskan tindakan yang telah dilakukan..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 resize-none">{{ $ticket->resolution_notes }}</textarea>
                            </div>

                            <div class="flex space-x-3">
                                <button type="submit"
                                    class="flex-1 px-6 py-3 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition">
                                    Update Status
                                </button>
                                @if ($ticket->status !== 'resolved')
                                    <button type="button"
                                        onclick="document.querySelector('[name=status]').value='resolved'; this.closest('form').submit();"
                                        class="px-6 py-3 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition">
                                        Mark Resolved
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Access Point Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Access Point</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama AP</p>
                            <p class="font-medium text-gray-900">{{ $ticket->accessPoint->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status AP</p>
                            <span class="inline-block mt-1 px-3 py-1 text-xs font-medium rounded-full"
                                style="background-color: {{ $ticket->accessPoint->status_color }}20; color: {{ $ticket->accessPoint->status_color }};">
                                {{ $ticket->accessPoint->status_label }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Lokasi</p>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="font-medium text-gray-900">
                                    {{ $ticket->accessPoint->room->floor->building->name }}</p>
                                <p class="text-sm text-gray-600">{{ $ticket->accessPoint->room->floor->display_name }}</p>
                                <p class="text-sm text-gray-600">{{ $ticket->accessPoint->room->name }}</p>
                            </div>
                        </div>
                        <a href="{{ route('building.floor', [$ticket->accessPoint->room->floor->building, $ticket->accessPoint->room->floor]) }}"
                            class="block w-full px-4 py-2 bg-gray-100 text-center text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Lihat di Denah →
                        </a>
                    </div>
                </div>

                <!-- Reporter Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pelapor</h3>
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-teal-500 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($ticket->admin->name, 0, 2) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $ticket->admin->name }}</p>
                            <p class="text-sm text-gray-600">{{ $ticket->admin->unit_kerja }}</p>
                            <p class="text-xs text-gray-500">{{ $ticket->admin->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Ticket Dibuat</p>
                                <p class="text-xs text-gray-500">{{ $ticket->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @if ($ticket->status === 'in_progress')
                            <div class="flex">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Sedang Diproses</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        @if ($ticket->resolved_at)
                            <div class="flex">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Diselesaikan</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->resolved_at->format('d M Y H:i') }}</p>
                                    @if ($ticket->resolver)
                                        <p class="text-xs text-gray-500">oleh {{ $ticket->resolver->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if ($ticket->closed_at)
                            <div class="flex">
                                <div class="w-2 h-2 bg-gray-500 rounded-full mt-2 mr-3"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Ticket Ditutup</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->closed_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // ========================================
        // 1. UPDATE STATUS - Konfirmasi saat Submit Button
        // ========================================
        const updateStatusForm = document.querySelector('form[action="{{ route('tickets.update.status', $ticket) }}"]');

        if (updateStatusForm) {
            const statusSelect = updateStatusForm.querySelector('select[name="status"]');
            const submitButton = updateStatusForm.querySelector('button[type="submit"]');
            const currentStatus = '{{ $ticket->status }}';

            submitButton?.addEventListener('click', function(e) {
                e.preventDefault();

                const newStatus = statusSelect.value;
                const resolutionNotes = updateStatusForm.querySelector('textarea[name="resolution_notes"]').value;

                // Check if there's any change
                if (newStatus === currentStatus && !resolutionNotes.trim()) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Perubahan',
                        text: 'Status masih sama dan tidak ada catatan tambahan',
                        confirmButtonColor: '#14b8a6'
                    });
                    return;
                }

                const statusLabels = {
                    'open': 'Open',
                    'in_progress': 'In Progress',
                    'resolved': 'Resolved',
                    'closed': 'Closed'
                };

                let message = '';
                if (newStatus !== currentStatus) {
                    message =
                        `Ubah status dari <strong class="text-blue-600">${statusLabels[currentStatus]}</strong> ke <strong class="text-green-600">${statusLabels[newStatus]}</strong>?`;
                } else {
                    message = 'Update catatan penyelesaian ticket ini?';
                }

                Swal.fire({
                    title: 'Konfirmasi Update',
                    html: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#14b8a6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        updateStatusForm.submit();
                    }
                });
            });
        }

        // ========================================
        // 2. MARK RESOLVED - dengan Input Notes
        // ========================================
        const markResolvedBtn = updateStatusForm?.querySelector('button[onclick*="Mark Resolved"]');

        if (markResolvedBtn) {
            // Remove inline onclick
            markResolvedBtn.removeAttribute('onclick');

            markResolvedBtn.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Selesaikan Ticket',
                    html: `
                <div class="text-left space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Penyelesaian <span class="text-red-500">*</span>
                        </label>
                        <textarea id="swalResolutionNotes" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 resize-none" 
                                  rows="5"
                                  placeholder="Jelaskan bagaimana ticket ini diselesaikan...

Contoh:
- AP sudah diperbaiki dan kembali online
- Konfigurasi telah disesuaikan
- Hardware telah diganti"></textarea>
                    </div>
                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-800">
                            💡 <strong>Tips:</strong> Jelaskan secara detail tindakan yang dilakukan untuk menyelesaikan masalah
                        </p>
                    </div>
                </div>
            `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '✓ Selesaikan Ticket',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    width: '600px',
                    focusConfirm: false,
                    didOpen: () => {
                        // Focus on textarea
                        document.getElementById('swalResolutionNotes').focus();
                    },
                    preConfirm: () => {
                        const notes = document.getElementById('swalResolutionNotes').value.trim();

                        if (!notes) {
                            Swal.showValidationMessage('Catatan penyelesaian wajib diisi!');
                            return false;
                        }

                        if (notes.length < 10) {
                            Swal.showValidationMessage('Catatan terlalu singkat! Minimal 10 karakter.');
                            return false;
                        }

                        return notes;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update form values
                        const statusSelect = updateStatusForm.querySelector('select[name="status"]');
                        statusSelect.value = 'resolved';
                        updateStatusForm.querySelector('textarea[name="resolution_notes"]').value = result
                            .value;

                        // Show loading
                        Swal.fire({
                            title: 'Menyelesaikan Ticket...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        updateStatusForm.submit();
                    }
                });
            });
        }
    </script>
@endsection
