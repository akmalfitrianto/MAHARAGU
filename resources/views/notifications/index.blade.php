@extends('layouts.app')

@section('title', 'Notifikasi')
@section('header', 'Notifikasi')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Semua Notifikasi</h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ auth()->user()->unreadNotificationsCount() }} notifikasi belum dibaca
                </p>
            </div>
            @if (auth()->user()->unreadNotificationsCount() > 0)
                <form method="POST" action="{{ route('notifications.read.all') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-teal-600 hover:text-teal-700 bg-teal-50 rounded-lg hover:bg-teal-100 transition">
                        Tandai Semua Sudah Dibaca
                    </button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y divide-gray-200">
            @forelse($notifications as $notification)
                <div class="p-6 hover:bg-gray-50 transition {{ $notification->is_unread ? 'bg-blue-50' : '' }}">
                    <div class="flex items-start space-x-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full flex items-center justify-center
                                {{ $notification->type === 'new_ticket'
                                    ? 'bg-blue-100'
                                    : ($notification->type === 'status_changed'
                                        ? 'bg-yellow-100'
                                        : ($notification->type === 'ticket_resolved'
                                            ? 'bg-green-100'
                                            : 'bg-gray-100')) }}">
                                @if ($notification->type === 'new_ticket')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                @elseif($notification->type === 'status_changed')
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                @elseif($notification->type === 'ticket_resolved')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                        </path>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $notification->title }}
                                        @if ($notification->is_unread)
                                            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full ml-2"></span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-700 mt-1">{{ $notification->message }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        <span>•</span>
                                        <a href="{{ route('tickets.show', $notification->ticket_id) }}"
                                            class="text-teal-600 hover:text-teal-700 font-medium">
                                            Lihat Ticket →
                                        </a>
                                    </div>
                                </div>

                                <!-- Mark as Read -->
                                @if ($notification->is_unread)
                                    <form method="POST" action="{{ route('notifications.read', $notification) }}"
                                        class="ml-4">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-gray-600"
                                            title="Tandai sudah dibaca">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Ticket Info -->
                            @if ($notification->ticket)
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between text-xs">
                                        <div>
                                            <span
                                                class="font-medium text-gray-900">{{ $notification->ticket->ticket_number }}</span>
                                            <span class="text-gray-500 mx-1">•</span>
                                            <span
                                                class="text-gray-600">{{ $notification->ticket->accessPoint->name }}</span>
                                        </div>
                                        <span class="px-2 py-1 rounded-full {{ $notification->ticket->status_color }}">
                                            {{ $notification->ticket->status_label }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <p class="text-gray-500">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($notifications->hasPages())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
