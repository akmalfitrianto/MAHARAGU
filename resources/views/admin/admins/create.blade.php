@extends('layouts.app')

@section('title', 'Tambah Admin')
@section('header', 'Tambah Admin Baru')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.admins.index') }}" class="text-gray-500 hover:text-gray-700">Manajemen Admin</a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-gray-900 font-medium">Tambah Admin</span>
                </li>
            </ol>
        </nav>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Form Admin Baru</h2>

            <form method="POST" action="{{ route('admin.admins.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Ahmad Fauzi"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        placeholder="admin@uin.ac.id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <p class="text-xs text-gray-500 mt-1">Email akan digunakan untuk login</p>
                </div>

                <!-- Unit Kerja -->
                <div>
                    <label for="unit_kerja" class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Kerja <span class="text-red-500">*</span>
                    </label>
                    <select name="unit_kerja" id="unit_kerja" required
                        class="w-full px-4 py-3 border {{ $errors->has('unit_kerja') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach ($unitKerjaList as $unit)
                            <option value="{{ $unit->nama }}" {{ old('unit_kerja') == $unit->nama ? 'selected' : '' }}>
                                {{ $unit->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_kerja')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Akses Gedung -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gedung yang Dapat Diakses <span class="text-red-500">*</span>
                    </label>
                    <div class="border border-gray-300 rounded-lg p-4 max-h-64 overflow-y-auto">
                        @if($buildings->isEmpty())
                            <p class="text-sm text-gray-500">Belum ada gedung tersedia</p>
                        @else
                            <div class="space-y-2">
                                @foreach($buildings as $building)
                                    <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="buildings[]" 
                                            value="{{ $building->id }}"
                                            {{ in_array($building->id, old('buildings', [])) ? 'checked' : '' }}
                                            class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                                        >
                                        <span class="ml-3 text-sm text-gray-900">{{ $building->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Pilih gedung yang bisa diakses oleh admin ini. Jika tidak ada yang dipilih, admin tidak bisa membuat ticket.
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        placeholder="Ulangi password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Informasi:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Admin dapat membuat dan memonitor ticket untuk unit kerjanya</li>
                                <li>Password harus minimal 8 karakter</li>
                                <li>Admin dapat login menggunakan email dan password ini</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.admins.index') }}"
                        class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-center transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition shadow-lg hover:shadow-xl">
                        Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
