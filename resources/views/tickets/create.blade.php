@extends('layouts.app')

@section('title', 'Buat Tiket Baru')
@section('header', 'Pelaporan Masalah')

@section('content')
    <div class="max-w-4xl mx-auto pb-10">

        <div class="flex items-center justify-between mb-8">
            <div>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li>
                            <a href="{{ route('tickets.my') }}" class="hover:text-teal-600 transition-colors">Tiket Saya</a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </li>
                        <li class="font-medium text-gray-800">Buat Baru</li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 mt-2">Buat Tiket Laporan</h1>
                <p class="text-sm text-gray-500">Laporkan kendala perangkat jaringan di area kampus.</p>
            </div>

            <a href="{{ url()->previous() }}"
                class="hidden sm:inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                Batal
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Detail Perangkat</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-12 h-12 bg-teal-50 rounded-full flex items-center justify-center text-teal-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $accessPoint->status === 'active' ? 'bg-green-100 text-green-800' : ($accessPoint->status === 'offline' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($accessPoint->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-gray-400 font-medium uppercase">Nama Perangkat</label>
                                <p class="text-gray-900 font-semibold text-lg">{{ $accessPoint->name }}</p>
                            </div>

                            <div>
                                <label class="text-xs text-gray-400 font-medium uppercase">Lokasi</label>
                                <div class="flex items-start mt-1">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $accessPoint->room->floor->building->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $accessPoint->room->floor->display_name }} •
                                            {{ $accessPoint->room->name }}</p>
                                    </div>
                                </div>
                            </div>

                            @if ($accessPoint->notes)
                                <div class="pt-4 border-t border-gray-100">
                                    <label class="text-xs text-gray-400 font-medium uppercase">Catatan Teknis</label>
                                    <p class="text-xs text-gray-600 mt-1 italic">"{{ $accessPoint->notes }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-blue-700">Pastikan deskripsi masalah ditulis dengan jelas agar teknisi
                                dapat menangani dengan cepat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">

                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h4>
                                <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="access_point_id" value="{{ $accessPoint->id }}">

                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Kategori
                                Masalah</label>
                            <div class="relative">
                                <select name="category" id="category" required
                                    class="appearance-none w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent focus:bg-white transition-all outline-none text-gray-700">
                                    <option value="" disabled selected>Pilih jenis kendala...</option>
                                    <option value="Koneksi Terputus"
                                        {{ old('category') === 'Koneksi Terputus' ? 'selected' : '' }}>Koneksi Terputus
                                        (Putus-nyambung)</option>
                                    <option value="Koneksi Lambat"
                                        {{ old('category') === 'Koneksi Lambat' ? 'selected' : '' }}>Koneksi Lambat / Lemot
                                    </option>
                                    <option value="Access Point Mati"
                                        {{ old('category') === 'Access Point Mati' ? 'selected' : '' }}>Perangkat Mati
                                        Total (Lampu Off)</option>
                                    <option value="Sinyal Lemah"
                                        {{ old('category') === 'Sinyal Lemah' ? 'selected' : '' }}>Sinyal Wifi Lemah
                                    </option>
                                    <option value="Tidak Bisa Connect"
                                        {{ old('category') === 'Tidak Bisa Connect' ? 'selected' : '' }}>Gagal Terhubung
                                        (Can't Connect)</option>
                                    <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
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

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                                Detail</label>
                            <textarea name="description" id="description" rows="6" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent focus:bg-white transition-all outline-none text-gray-700 resize-none"
                                placeholder="Contoh: Lampu indikator AP mati, atau sinyal hilang saat jam kuliah...">{{ old('description') }}</textarea>
                        </div>

                        <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
                            <button type="submit"
                                class="w-full sm:w-auto flex-1 bg-gradient-to-r from-teal-600 to-teal-500 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-teal-500/30 hover:shadow-teal-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex justify-center items-center group">
                                <span>Kirim Laporan</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                </svg>
                            </button>

                            <a href="{{ url()->previous() }}"
                                class="sm:hidden w-full text-center py-3 text-gray-500 font-medium hover:text-gray-800">
                                Batalkan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
