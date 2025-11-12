@extends('layouts.app')

@section('title', 'Buat Ticket Baru')
@section('header', 'Buat Ticket Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('tickets.my') }}" class="text-gray-500 hover:text-gray-700">My Tickets</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <span class="text-gray-900 font-medium">Buat Ticket</span>
            </li>
        </ol>
    </nav>

    <!-- AP Info Card -->
    <div class="bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl shadow-lg p-6 text-white mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Access Point</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-teal-100 text-sm mb-1">Nama AP</p>
                <p class="font-semibold text-lg">{{ $accessPoint->name }}</p>
            </div>
            <div>
                <p class="text-teal-100 text-sm mb-1">Status</p>
                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full {{ $accessPoint->status === 'active' ? 'bg-green-500' : ($accessPoint->status === 'offline' ? 'bg-red-500' : 'bg-yellow-500') }}">
                    {{ $accessPoint->status_label }}
                </span>
            </div>
            <div class="md:col-span-2">
                <p class="text-teal-100 text-sm mb-1">Lokasi</p>
                <p class="font-semibold">{{ $accessPoint->room->floor->building->name }}</p>
                <p class="text-sm text-teal-100">{{ $accessPoint->room->floor->display_name }} - {{ $accessPoint->room->name }}</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Form Laporan Masalah</h3>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="access_point_id" value="{{ $accessPoint->id }}">

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori Masalah <span class="text-red-500">*</span>
                </label>
                <select 
                    name="category" 
                    id="category" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                >
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Koneksi Terputus" {{ old('category') === 'Koneksi Terputus' ? 'selected' : '' }}>Koneksi Terputus</option>
                    <option value="Koneksi Lambat" {{ old('category') === 'Koneksi Lambat' ? 'selected' : '' }}>Koneksi Lambat</option>
                    <option value="Access Point Mati" {{ old('category') === 'Access Point Mati' ? 'selected' : '' }}>Access Point Mati</option>
                    <option value="Sinyal Lemah" {{ old('category') === 'Sinyal Lemah' ? 'selected' : '' }}>Sinyal Lemah</option>
                    <option value="Tidak Bisa Connect" {{ old('category') === 'Tidak Bisa Connect' ? 'selected' : '' }}>Tidak Bisa Connect</option>
                    <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Masalah <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="6" 
                    required
                    placeholder="Jelaskan masalah yang terjadi secara detail..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent resize-none"
                >{{ old('description') }}</textarea>
                <p class="mt-2 text-sm text-gray-500">
                    Berikan informasi selengkap mungkin untuk membantu proses penanganan.
                </p>
            </div>

            <!-- Info Box -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Informasi:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Ticket akan otomatis diberi nomor unik</li>
                            <li>Anda akan mendapat notifikasi saat status ticket berubah</li>
                            <li>Superadmin akan menerima notifikasi ticket baru</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ url()->previous() }}" 
                   class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-center transition">
                    Batal
                </a>
                <button 
                    type="submit"
                    class="flex-1 px-6 py-3 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition shadow-lg hover:shadow-xl">
                    Submit Ticket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection