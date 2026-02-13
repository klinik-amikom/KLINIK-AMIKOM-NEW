@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

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
                Kelola User
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Kelola data pengguna dalam sistem
            </p>
        </div>
        <div class="w-full sm:w-auto">
            <a href="{{ route('admin.admin.create') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2
              bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium
              rounded-lg shadow-sm transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> Tambah User
            </a>
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

    <!-- Users Table -->
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-10">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Daftar User Aktif
            </h3>
            @if (isset($hasTrashedUser) && $hasTrashedUser)
                <form action="{{ route('users.restore-all', $role) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2
                                px-4 py-2 rounded-lg
                                bg-green-600 hover:bg-green-700
                                text-white text-sm font-semibold
                                shadow transition">
                        <i class="fa-solid fa-rotate-left"></i>
                        Restore
                    </button>
                </form>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium uppercase">#</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Nama</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Username</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Email</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase">Identitas</th>
                        <th class="px-6 py-3 text-xs font-medium uppercase text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>

                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-3">{{ $user->name }}</div>
                                </div>
                            </td>

                            <td class="px-6 py-4">{{ $user->username }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td>{{ $user->position?->position ?? '-' }}</td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.admin.edit', $user->id) }}"
                                        class="text-purple-600 hover:text-purple-800">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                Data user belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Pastikan ini dijalankan setelah tabel dan input sudah ada di DOM
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('users-search');
            const rows = document.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();

                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();

                    // Tampilkan semua jika input kosong
                    if (keyword === '') {
                        row.style.display = '';
                        return;
                    }

                    // Cek apakah row mengandung keyword
                    if (text.includes(keyword)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
