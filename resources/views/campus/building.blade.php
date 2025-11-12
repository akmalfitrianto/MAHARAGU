@extends('layouts.app')

@section('title', $building->name)
@section('header', $building->name)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('campus.map') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Denah Kampus
        </a>
    </div>

    <!-- Building Info Header -->
    <div class="bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl shadow-lg p-8 text-white">
        <h1 class="text-3xl font-bold mb-4">{{ $building->name }}</h1>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-teal-100 text-sm">Total Lantai</p>
                <p class="text-3xl font-bold mt-1">{{ $building->total_floors }}</p>
            </div>
            <div>
                <p class="text-teal-100 text-sm">Total Ruangan</p>
                <p class="text-3xl font-bold mt-1">{{ $building->total_rooms }}</p>
            </div>
            <div>
                <p class="text-teal-100 text-sm">Total Access Points</p>
                <p class="text-3xl font-bold mt-1">{{ $building->total_access_points }}</p>
            </div>
            <div>
                <p class="text-teal-100 text-sm">Status AP</p>
                <div class="flex items-center space-x-3 mt-2">
                    <span class="text-sm">🟢 {{ $building->active_access_points }}</span>
                    <span class="text-sm">🔴 {{ $building->offline_access_points }}</span>
                    <span class="text-sm">🟡 {{ $building->maintenance_access_points }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Floors List -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Lantai</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($building->floors()->orderBy('floor_number')->get() as $floor)
            <a href="{{ route('building.floor', [$building, $floor]) }}" 
               class="bg-white rounded-xl shadow-sm border-2 border-gray-200 hover:border-teal-500 transition-all duration-200 overflow-hidden group hover:shadow-lg">
                <!-- Floor Header -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 group-hover:from-teal-500 group-hover:to-teal-600 transition-all">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $floor->display_name }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Floor Stats -->
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-gray-600">Ruangan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $floor->total_rooms }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Access Points</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $floor->total_access_points }}</p>
                        </div>
                    </div>

                    <!-- AP Status -->
                    <div class="flex items-center justify-between text-sm p-3 bg-gray-50 rounded-lg">
                        <span class="flex items-center text-green-600">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            {{ $floor->active_access_points }}
                        </span>
                        <span class="flex items-center text-red-600">
                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                            {{ $floor->offline_access_points }}
                        </span>
                        <span class="flex items-center text-yellow-600">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                            {{ $floor->maintenance_access_points }}
                        </span>
                    </div>

                    <!-- View Button -->
                    <div class="mt-4 flex items-center justify-center text-teal-600 font-medium text-sm group-hover:text-teal-700">
                        <span>Lihat Denah Lantai</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mt-1 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-semibold text-blue-900 mb-2">Informasi</h3>
                <p class="text-sm text-blue-800">
                    Pilih lantai untuk melihat denah ruangan dan access point. 
                    Klik pada access point yang bermasalah untuk membuat laporan ticket.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection