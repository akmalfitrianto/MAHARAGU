@extends('layouts.app')

@section('title', 'Data Unit Kerja')
@section('header', 'Manajemen Unit Kerja')

@section('content')
    <div x-data="{
        showModal: false,
        editMode: false,
        formAction: '',
        formMethod: 'POST',
        data: { id: '', nama: '', aktif: true }
    }">

        <div class="mb-6 flex justify-between items-center">
            <p class="text-gray-500 text-sm">Kelola daftar Fakultas atau Unit Kerja.</p>
            <button
                @click="
            showModal = true; 
            editMode = false; 
            formAction = '{{ route('admin.unit-kerja.store') }}';
            formMethod = 'POST';
            data = { id: '', nama: '', aktif: true };
        "
                class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-sm font-medium text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Unit
            </button>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium border-b">
                    <tr>
                        <th class="px-6 py-3 w-16 text-center">No</th>
                        <th class="px-6 py-3">Nama Unit Kerja / Fakultas</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($units as $index => $unit)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $unit->nama }}</td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold {{ $unit->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $unit->aktif ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button
                                    @click="
                            showModal = true; 
                            editMode = true; 
                            formAction = '{{ route('admin.unit-kerja.update', $unit->id) }}';
                            formMethod = 'PUT';
                            data = { id: {{ $unit->id }}, nama: '{{ $unit->nama }}', aktif: {{ $unit->aktif ? 'true' : 'false' }} };
                        "
                                    class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</button>

                                <form action="{{ route('admin.unit-kerja.destroy', $unit->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Yakin ingin menghapus unit ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data unit kerja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" class="fixed inset-0 transition-opacity" @click="showModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div x-show="showModal"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form :action="formAction" method="POST">
                        @csrf
                        <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900"
                                        x-text="editMode ? 'Edit Unit Kerja' : 'Tambah Unit Kerja'"></h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nama Unit /
                                                Fakultas</label>
                                            <input type="text" name="nama" x-model="data.nama" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50"
                                                placeholder="Contoh: Fakultas Tarbiyah">
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="aktif" id="aktif" value="1"
                                                x-model="data.aktif"
                                                class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                                            <label for="aktif" class="ml-2 block text-sm text-gray-900">Status
                                                Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan
                            </button>
                            <button type="button" @click="showModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
