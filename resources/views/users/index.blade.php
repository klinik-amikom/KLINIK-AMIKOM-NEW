@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert-auto-hide mb-4 bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded relative dark:bg-purple-900/30 dark:border-purple-600 dark:text-purple-300"
            role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.parentElement.remove()"
                    class="fill-current h-6 w-6 text-purple-500 cursor-pointer" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300"
            role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.parentElement.remove()"
                    class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300"
            role="alert">
            <strong class="font-bold">Validasi Error!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.parentElement.remove()"
                    class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
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
            <button onclick="openCreateUserModal()"
                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg">
                <i class="fas fa-plus mr-2"></i> Tambah User
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
                        <th class="px-6 py-3 text-xs font-medium uppercase">Posisi</th>
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
                            <td>{{ $user->position->position ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <button
                                        onclick='editUser(@json($user))'
                                        class="text-purple-600 hover:text-purple-800">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="button"
                                            data-action="{{ route('users.destroy', $user->id) }}"
                                            data-method="DELETE"
                                            data-confirm-type="delete"
                                            data-confirm-text="Data ini akan dihapus permanen!"
                                            onclick="handleActionWithConfirmation(this)"
                                            class="text-red-600 hover:text-red-800">
                                            
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

    <!-- MODAL CREATE -->
    <div id="create-user-modal"
        class="fixed inset-0 bg-black/50 z-50 hidden backdrop-blur-sm flex items-center justify-center p-4">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md">

            <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 dark:text-white">Tambah User</h3>
                <button onclick="closeCreateUserModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium mb-1">Nama (Identity) *</label>
                    <select name="identity_id" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">

                        <option value="">Pilih Nama</option>

                        @foreach($identities as $identity)
                            <option value="{{ $identity->id }}">
                                {{ $identity->id }} - {{ $identity->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Username *</label>
                    <input type="text" name="username" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-purple-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                    <input type="email" name="email" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-purple-500">
                </div>

                <div>
                    <label class="block text-xs font-medium mb-1">Posisi *</label>
                    <select name="position_id" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                        
                        <option value="">Pilih Posisi</option>

                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">
                                {{ $position->position }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Password *</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password
                        *</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeCreateUserModal()"
                        class="px-4 py-2 text-sm text-gray-600 border rounded-lg">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Simpan User
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="edit-user-modal"
        class="fixed inset-0 bg-black/50 z-50 hidden backdrop-blur-sm flex items-center justify-center p-4">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md">

            <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 dark:text-white">Edit Data User</h3>

                <button onclick="closeEditUserModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="edit-user-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- Identity (Nama) -->
                <div>
                    <label class="block text-xs font-medium mb-1">Nama *</label>
                    <select name="identity_id" id="edit-identity" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">

                        <option value="">Pilih Nama</option>

                        @foreach($identities as $identity)
                            <option value="{{ $identity->id }}">
                                {{ $identity->id }} - {{ $identity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                    <input type="text" name="username" id="edit-username" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" name="email" id="edit-email" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium mb-1">Posisi</label>

                    <select name="position_id" id="edit-position"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">

                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">
                                {{ $position->position }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>

                <div class="flex justify-end space-x-3 pt-4">

                    <button type="button" onclick="closeEditUserModal()"
                        class="px-4 py-2 text-sm text-gray-600 border rounded-lg">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Update Data
                    </button>

                </div>

            </form>
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

        function openCreateUserModal() {
            const modal = document.getElementById('create-user-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            modal.querySelector('form').reset(); // 🔥 reset input
        }

        function closeCreateUserModal() {
            const modal = document.getElementById('create-user-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openEditUserModal() {
            const modal = document.getElementById('edit-user-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditUserModal() {
            const modal = document.getElementById('edit-user-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editUser(user) {

            const form = document.getElementById('edit-user-form');

            form.action = `/users/${user.id}`;

            document.getElementById('edit-identity').value = user.identity_id;
            document.getElementById('edit-username').value = user.username;
            document.getElementById('edit-email').value = user.email;
            document.getElementById('edit-position').value = user.position_id;

            openEditUserModal();
        }
    </script>
@endpush
