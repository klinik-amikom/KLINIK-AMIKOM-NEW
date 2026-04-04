@extends('layouts.app')

@section('title', 'Kelola Tim Medis')
@section('page-title', 'Kelola Tim Medis')

@section('content')

    {{-- Alert Messages --}}
    @if (session('success'))
        <div
            class="alert-auto-hide mb-4 bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded relative dark:bg-purple-900/30 dark:border-purple-600 dark:text-purple-300">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div
            class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Kelola Tim Medis
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Kelola data tim medis dalam sistem
            </p>
        </div>
        <div class="w-full sm:w-auto">
            <button onclick="openCreateUserModal()"
                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg">
                <i class="fas fa-plus mr-2"></i> Tambah Tim Medis
            </button>
        </div>
    </div>

    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="users-search" placeholder="Cari Nama, Username, atau Email..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-purple-500 focus:border-purple-500 text-sm">
        </div>
    </div>

    <!-- Tabel Tim Medis -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium uppercase">#</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Foto</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Nama</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($data as $index => $item)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>

                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="w-12 h-12 rounded-full object-cover">
                            </td>

                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->deskripsi }}</td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end items-center gap-2">
                                    
                                    <!-- Edit Button -->
                                    <button 
                                        onclick='openEditModal(@json($item))'
                                        class="flex items-center justify-center w-7 h-7 text-purple-600 hover:text-white hover:bg-purple-600 rounded-lg transition"
                                    >
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('tim_medis.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            onclick="return confirm('Yakin hapus?')"
                                            class="flex items-center justify-center w-7 h-7 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                Data belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody> 
            </table>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Tambah Tim Medis</h2>

            <form action="{{ route('tim_medis.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="block text-sm">Nama</label>
                    <input type="text" name="name" class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="mb-3">
                    <label class="block text-sm">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="block text-sm">Gambar</label>
                    <input type="file" name="gambar" class="w-full">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg">Batal</button>

                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Edit Tim Medis</h2>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" id="edit_name" class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>

                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="w-full">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg">Batal</button>

                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('users-search').addEventListener('keyup', function () {
            let keyword = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });

        function openCreateUserModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('createModal').classList.add('flex');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('createModal').classList.remove('flex');
        }

        function openEditModal(data) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');

            // isi form
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_deskripsi').value = data.deskripsi;

            // set action form
            document.getElementById('editForm').action = `/tim_medis/${data.id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
    </script>
@endsection