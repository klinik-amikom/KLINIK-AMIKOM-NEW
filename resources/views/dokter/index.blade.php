@extends('layouts.app')

@section('title', 'Kelola Dokter')

@section('page-title', 'Kelola Dokter')

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
    <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 mb-6 sm:mb-8">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">
                Kelola Dokter
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                Kelola data Dokter dalam sistem
            </p>
        </div>
        <div class="w-full sm:w-auto">
            <button onclick="openCreateUserModal()"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Dokter
            </button>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0 justify-between">
        <!-- Search -->
        <div class="sm:w-2/4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="user-search" placeholder="Cari nama, username, kode, atau spesialis..."
                    class="block w-full pl-10 pr-3 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 text-sm sm:text-base">
            </div>
        </div>
        
        <!-- Filter by Spesialis -->
        <div class="sm:w-1/4">
            <label for="spesialis-filter" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Filter Spesialis
            </label>
            <select id="spesialis-filter" 
                class="w-full px-3 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 text-sm sm:text-base">
                <option value="">Semua Spesialis</option>
                <option value="Umum">Umum</option>
                <option value="Gigi">Gigi</option>
            </select>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                    Daftar Dokter
                </h3>
            </div>
        </div>

        <!-- Table View -->
        <div id="table-view" class="table-container overflow-x-auto">
            <table class="w-full text-left min-w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-0 bg-gray-50 dark:bg-gray-700 z-10 sm:static">
                            #
                        </th>
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell min-w-[120px]">
                            Kode
                        </th>
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-8 bg-gray-50 dark:bg-gray-700 z-10 sm:static min-w-[180px]">
                            Nama
                        </th>
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell min-w-[150px]">
                            Username
                        </th>
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[130px]">
                            No Telepon
                        </th>
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell min-w-[100px]">
                            Spesialis
                        </th>
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell min-w-[150px]">
                            Alamat
                        </th>
                        <th
                            class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-right sticky right-0 bg-gray-50 dark:bg-gray-700 z-10 sm:static min-w-[100px]">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="users-table-body">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 user-row">
                            <td
                                class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white font-medium sticky left-0 bg-white dark:bg-gray-800 z-10 sm:static">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $user->kode }}</div>
                            </td>
                            <td
                                class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap sticky left-8 bg-white dark:bg-gray-800 z-10 sm:static">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="ml-2 sm:ml-4 min-w-0">
                                        <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $user->username }}</div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $user->no_telp }}</div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $user->spesialis == 'Umum' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                    {{ $user->spesialis }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-xs sm:text-sm text-gray-900 dark:text-white truncate max-w-[150px]" title="{{ $user->alamat }}">
                                    {{ $user->alamat }}
                                </div>
                            </td>
                            <td
                                class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium sticky right-0 bg-white dark:bg-gray-800 z-10 sm:static">
                                <div class="flex items-center justify-end space-x-1">
                                    <button
                                        onclick="editUser({{ $user->id }}, {
                                        name: '{{ addslashes($user->name) }}',
                                        username: '{{ addslashes($user->username) }}',
                                        no_telp: '{{ addslashes($user->no_telp) }}',
                                        kode: '{{ addslashes($user->kode) }}',
                                        alamat: '{{ addslashes($user->alamat) }}',
                                        spesialis: '{{ addslashes($user->spesialis) }}'
                                        })"
                                        class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 p-1.5 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200"
                                        title="Edit">
                                        <i class="fas fa-edit text-xs sm:text-sm"></i>
                                    </button>
                                    <button onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                        class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                        title="Delete">
                                        <i class="fas fa-trash text-xs sm:text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Data dokter tidak tersedia</p>
                                    <p class="text-sm">Belum ada dokter yang terdaftar dalam sistem</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card View (Mobile Alternative) -->
        <div id="card-view" class="hidden">
            <div class="p-4 space-y-4" id="users-card-body">
                @forelse ($users as $user)
                    <div
                        class="user-card bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</h4>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium mt-1
                                        {{ $user->spesialis == 'Umum' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                        {{ $user->spesialis }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-1">
                                <button
                                    onclick="editUser({{ $user->id }}, {
                                    name: '{{ addslashes($user->name) }}',
                                    username: '{{ addslashes($user->username) }}',
                                    no_telp: '{{ addslashes($user->no_telp) }}',
                                    kode: '{{ addslashes($user->kode) }}',
                                    alamat: '{{ addslashes($user->alamat) }}',
                                    spesialis: '{{ addslashes($user->spesialis) }}'
                                    })"
                                    class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 p-2 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Username:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->username }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Telepon:</span>
                                <span class="text-gray-900 dark:text-white">{{ $user->no_telp }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 dark:text-gray-400">Alamat:</span>
                                <span class="text-gray-900 dark:text-white truncate max-w-[150px]" title="{{ $user->alamat }}">{{ $user->alamat }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="text-gray-500 dark:text-gray-400">
                            <i class="fas fa-users text-4xl mb-4"></i>
                            <h4 class="text-lg font-medium">Data Dokter Tidak Tersedia</h4>
                            <p class="text-sm">Belum ada dokter yang terdaftar dalam sistem</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="create-user-modal"
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50 hidden backdrop-blur-sm transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-sm sm:max-w-md transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
                <div
                    class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                            Tambah Dokter Baru
                        </h3>
                        <button onclick="closeCreateUserModal()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form id="create-user-form" class="p-4 sm:p-6">
                    @csrf
                    <div class="space-y-3 sm:space-y-4">
                        <!-- Nama -->
                        <div>
                            <label for="create-name"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="create-name" name="name" required value="{{ old('name') }}"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label for="create-phone"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                No. Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="create-phone" name="phone" required value="{{ old('phone') }}"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                placeholder="+62 812-3456-7890">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="create-alamat"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Alamat
                            </label>
                            <textarea id="create-alamat" name="alamat" rows="2"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                        </div>
                        
                        <!-- Spesialis -->
                        <div>
                            <label for="create-spesialis" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Spesialis <span class="text-red-500">*</span>
                            </label>
                            <select id="create-spesialis" name="spesialis" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                <option value="" disabled selected>Pilih Spesialis</option>
                                <option value="Umum" {{ old('spesialis') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                <option value="Gigi" {{ old('spesialis') == 'Gigi' ? 'selected' : '' }}>Gigi</option>
                            </select>
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <label for="create-password"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="create-password" name="password" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                placeholder="Minimal 8 karakter">
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="create-password-confirm"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="create-password-confirm" name="password_confirmation" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                placeholder="Konfirmasi password">
                        </div>
                    </div>
                </form>

                <div
                    class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                        <button type="button" onclick="closeCreateUserModal()"
                            class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            Batal
                        </button>
                        <button type="button" onclick="saveUser()"
                            class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="edit-user-modal"
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50 hidden backdrop-blur-sm transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-sm sm:max-w-md transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
                <div
                    class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Dokter
                        </h3>
                        <button onclick="closeEditUserModal()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form id="edit-user-form" class="p-4 sm:p-6">
                    @csrf
                    <input type="hidden" id="edit-user-id" name="user_id">
                    <div class="space-y-3 sm:space-y-4">
                        <!-- Nama -->
                        <div>
                            <label for="edit-name"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit-name" name="name" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label for="edit-phone"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                No. Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="edit-phone" name="phone" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="edit-username"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Username
                            </label>
                            <input type="text" id="edit-username" name="username"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        </div>

                        <!-- Kode -->
                        <div>
                            <label for="edit-kode"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Kode
                            </label>
                            <input type="text" id="edit-kode" name="kode"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="edit-alamat"
                                class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Alamat
                            </label>
                            <textarea id="edit-alamat" name="alamat" rows="2"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"></textarea>
                        </div>
                        
                        <!-- Spesialis -->
                        <div>
                            <label for="edit-spesialis" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Spesialis <span class="text-red-500">*</span>
                            </label>
                            <select id="edit-spesialis" name="spesialis" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                <option value="Umum">Umum</option>
                                <option value="Gigi">Gigi</option>
                            </select>
                        </div>
                        
                        <!-- Change Password -->
                        <div class="pt-2 sm:pt-4 border-t border-gray-200 dark:border-gray-600">
                            <label class="flex items-center">
                                <input type="checkbox" id="change-password-checkbox"
                                    class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-xs sm:text-sm text-gray-700 dark:text-gray-300">Ubah Password</span>
                            </label>
                        </div>

                        <!-- New Password (Hidden by default) -->
                        <div id="password-fields" class="space-y-3 sm:space-y-4 hidden">
                            <div>
                                <label for="edit-password"
                                    class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Password Baru
                                </label>
                                <input type="password" id="edit-password" name="password"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                    placeholder="Minimal 8 karakter">
                            </div>

                            <div>
                                <label for="edit-password-confirm"
                                    class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" id="edit-password-confirm" name="password_confirmation"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                    placeholder="Konfirmasi password baru">
                            </div>
                        </div>
                    </div>
                </form>

                <div
                    class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                        <button type="button" onclick="closeEditUserModal()"
                            class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            Batal
                        </button>
                        <button type="button" onclick="updateUser()"
                            class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid currentColor;
            border-radius: 50%;
            border-right-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* View toggle button styles */
        .view-toggle {
            transition: all 0.2s ease;
        }

        .view-toggle.active {
            transform: scale(1.05);
        }

        /* Responsive table improvements */
        @media (max-width: 640px) {

            /* Hide table view on mobile by default */
            #table-view {
                display: none;
            }

            /* Show card view on mobile by default */
            #card-view {
                display: block !important;
            }

            /* Improve table scroll on very small screens */
            .table-container {
                -webkit-overflow-scrolling: touch;
            }

            /* Better mobile table styling */
            table {
                min-width: 700px;
            }

            th,
            td {
                white-space: nowrap;
            }

            /* Sticky columns for mobile */
            .sticky {
                position: sticky;
                z-index: 10;
            }
        }

        @media (min-width: 641px) {

            /* Hide view toggle buttons on desktop */
            .view-toggle {
                display: none;
            }

            /* Show table view on desktop by default */
            #table-view {
                display: block;
            }

            /* Hide card view on desktop by default */
            #card-view {
                display: none !important;
            }

            /* Remove sticky positioning on desktop */
            .sticky {
                position: static;
            }
        }

        /* Card hover effects */
        .user-card {
            transition: all 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dark .user-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Smooth transitions for view switching */
        #table-view,
        #card-view {
            transition: opacity 0.3s ease;
        }

        /* Better mobile form styling */
        @media (max-width: 640px) {
            .modal-content {
                margin: 1rem;
                max-height: calc(100vh - 2rem);
            }
        }

        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #22c55e;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Better focus states for accessibility */
        .user-card:focus-within {
            ring: 2px;
            ring-color: #22c55e;
            ring-opacity: 0.5;
        }

        /* Responsive text sizing */
        @media (max-width: 480px) {
            .user-card h4 {
                font-size: 0.875rem;
            }

            .user-card .text-sm {
                font-size: 0.75rem;
            }
        }

        /* Form validation states */
        .border-red-300 {
            border-color: #fca5a5 !important;
        }

        .ring-red-200 {
            ring-color: #fecaca !important;
            ring-width: 2px !important;
        }

        /* Improved button states */
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Better mobile pagination */
        @media (max-width: 640px) {
            .pagination-text {
                font-size: 0.75rem;
            }

            .pagination-button {
                min-width: 32px;
                height: 32px;
                padding: 0.25rem;
            }
        }

        /* Tooltip styling */
        [title] {
            position: relative;
        }

        /* Improved table scroll shadow */
        .table-container {
            background:
                /* Shadow covers */
                linear-gradient(90deg, rgba(255, 255, 255, 1) 30%, rgba(255, 255, 255, 0)) left,
                linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1) 70%) right;
            background-repeat: no-repeat;
            background-color: white;
            background-size: 40px 100%, 40px 100%;
            background-attachment: local, local;
        }

        .dark .table-container {
            background:
                linear-gradient(90deg, rgba(31, 41, 55, 1) 30%, rgba(31, 41, 55, 0)) left,
                linear-gradient(90deg, rgba(31, 41, 55, 0), rgba(31, 41, 55, 1) 70%) right;
            background-repeat: no-repeat;
            background-color: rgb(31 41 55);
            background-size: 40px 100%, 40px 100%;
            background-attachment: local, local;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Search functionality with support for both table and card views
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('user-search');
            const spesialisFilter = document.getElementById('spesialis-filter');

            function filterUsers() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedSpesialis = spesialisFilter.value;

                // Filter table rows
                const rows = document.querySelectorAll('.user-row');
                // Filter card views
                const cards = document.querySelectorAll('.user-card');

                [...rows, ...cards].forEach(item => {
                    let name, username, kode, phone, alamat, spesialis;

                    if (item.classList.contains('user-row')) {
                        // Table row filtering
                        const cells = item.querySelectorAll('td');
                        name = cells[2]?.textContent.toLowerCase() || '';
                        username = cells[3]?.textContent.toLowerCase() || '';
                        phone = cells[4]?.textContent.toLowerCase() || '';
                        spesialis = cells[5]?.textContent.toLowerCase() || '';
                        alamat = cells[6]?.textContent.toLowerCase() || '';
                        kode = cells[1]?.textContent.toLowerCase() || '';
                    } else {
                        // Card filtering
                        name = item.querySelector('h4')?.textContent.toLowerCase() || '';
                        const spesialisElement = item.querySelector('.inline-flex');
                        spesialis = spesialisElement?.textContent.toLowerCase() || '';
                        const spans = item.querySelectorAll('.text-gray-900');
                        username = spans[0]?.textContent.toLowerCase() || '';
                        phone = spans[1]?.textContent.toLowerCase() || '';
                        alamat = spans[2]?.textContent.toLowerCase() || '';
                    }

                    const matchesSearch = name.includes(searchTerm) ||
                        username.includes(searchTerm) ||
                        kode.includes(searchTerm) ||
                        phone.includes(searchTerm) ||
                        alamat.includes(searchTerm) ||
                        spesialis.includes(searchTerm);

                    const matchesSpesialis = !selectedSpesialis || spesialis.includes(selectedSpesialis.toLowerCase());

                    if (matchesSearch && matchesSpesialis) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterUsers);
            }

            if (spesialisFilter) {
                spesialisFilter.addEventListener('change', filterUsers);
            }

            // Change password checkbox toggle
            const changePasswordCheckbox = document.getElementById('change-password-checkbox');
            const passwordFields = document.getElementById('password-fields');

            if (changePasswordCheckbox && passwordFields) {
                changePasswordCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        passwordFields.classList.remove('hidden');
                        document.getElementById('edit-password').required = true;
                        document.getElementById('edit-password-confirm').required = true;
                    } else {
                        passwordFields.classList.add('hidden');
                        document.getElementById('edit-password').required = false;
                        document.getElementById('edit-password-confirm').required = false;
                        document.getElementById('edit-password').value = '';
                        document.getElementById('edit-password-confirm').value = '';
                    }
                });
            }

            // Auto switch to card view on mobile
            function checkViewMode() {
                const tableView = document.getElementById('table-view');
                const cardView = document.getElementById('card-view');

                if (window.innerWidth < 640) {
                    if (tableView && cardView) {
                        tableView.style.display = 'none';
                        cardView.style.display = 'block';
                    }
                } else {
                    if (tableView && cardView) {
                        cardView.style.display = 'none';
                        tableView.style.display = 'block';
                    }
                }
            }

            // Initial check
            checkViewMode();

            // Check on resize
            window.addEventListener('resize', checkViewMode);
        });

        // View switching function
        function switchView(viewType) {
            const tableView = document.getElementById('table-view');
            const cardView = document.getElementById('card-view');

            if (viewType === 'table') {
                tableView.classList.remove('hidden');
                cardView.classList.add('hidden');
            } else {
                cardView.classList.remove('hidden');
                tableView.classList.add('hidden');
            }
        }

        // Modal Functions
        function openCreateUserModal() {
            const modal = document.getElementById('create-user-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                const transform = modal.querySelector('.transform');
                if (transform) {
                    transform.classList.remove('scale-95');
                    transform.classList.add('scale-100');
                }
            }, 10);
        }

        function closeCreateUserModal() {
            const modal = document.getElementById('create-user-modal');
            const transform = modal.querySelector('.transform');
            if (transform) {
                transform.classList.add('scale-95');
                transform.classList.remove('scale-100');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('create-user-form').reset();
            }, 300);
        }

        function openEditUserModal() {
            const modal = document.getElementById('edit-user-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                const transform = modal.querySelector('.transform');
                if (transform) {
                    transform.classList.remove('scale-95');
                    transform.classList.add('scale-100');
                }
            }, 10);
        }

        function closeEditUserModal() {
            const modal = document.getElementById('edit-user-modal');
            const transform = modal.querySelector('.transform');
            if (transform) {
                transform.classList.add('scale-95');
                transform.classList.remove('scale-100');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('edit-user-form').reset();
                const checkbox = document.getElementById('change-password-checkbox');
                const passwordFields = document.getElementById('password-fields');
                if (checkbox) checkbox.checked = false;
                if (passwordFields) passwordFields.classList.add('hidden');
            }, 300);
        }

        // User Management Functions - Using Form Submission
        function saveUser() {
            const form = document.getElementById('create-user-form');
            const saveButton = document.querySelector('#create-user-modal button[onclick="saveUser()"]');

            // Basic client-side validation
            const name = form.querySelector('[name="name"]').value;
            const phone = form.querySelector('[name="phone"]').value;
            const spesialis = form.querySelector('[name="spesialis"]').value;
            const password = form.querySelector('[name="password"]').value;
            const passwordConfirm = form.querySelector('[name="password_confirmation"]').value;

            if (!name || !phone || !spesialis || !password) {
                alert('Semua field wajib diisi!');
                return;
            }

            if (password !== passwordConfirm) {
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }

            if (password.length < 8) {
                alert('Password minimal 8 karakter!');
                return;
            }

            // Add loading state
            const originalText = saveButton.innerHTML;
            saveButton.innerHTML = '<span class="loading-spinner mr-2"></span>Menyimpan...';
            saveButton.disabled = true;

            // Set form action and method
            form.action = '/admin/dokter';
            form.method = 'POST';

            // Submit form
            form.submit();
        }

        function editUser(userId, userData) {
            // Populate form fields with passed data
            document.getElementById('edit-user-id').value = userId;
            document.getElementById('edit-name').value = userData.name || '';
            document.getElementById('edit-phone').value = userData.no_telp || '';

            // Additional fields
            const editUsernameField = document.getElementById('edit-username');
            const editKodeField = document.getElementById('edit-kode');
            const editAlamatField = document.getElementById('edit-alamat');
            const editSpesialisField = document.getElementById('edit-spesialis');

            if (editUsernameField) editUsernameField.value = userData.username || '';
            if (editKodeField) editKodeField.value = userData.kode || '';
            if (editAlamatField) editAlamatField.value = userData.alamat || '';
            if (editSpesialisField) editSpesialisField.value = userData.spesialis || '';

            // Open modal
            openEditUserModal();
        }

        function updateUser() {
            const form = document.getElementById('edit-user-form');
            const changePassword = document.getElementById('change-password-checkbox').checked;
            const updateButton = document.querySelector('#edit-user-modal button[onclick="updateUser()"]');
            const userId = document.getElementById('edit-user-id').value;

            // Basic validation
            const name = form.querySelector('[name="name"]').value;
            const phone = form.querySelector('[name="phone"]').value;
            const spesialis = form.querySelector('[name="spesialis"]').value;

            if (!name || !phone || !spesialis) {
                alert('Nama, telepon, dan spesialis wajib diisi!');
                return;
            }

            if (changePassword) {
                const password = form.querySelector('[name="password"]').value;
                const passwordConfirm = form.querySelector('[name="password_confirmation"]').value;

                if (!password || !passwordConfirm) {
                    alert('Password dan konfirmasi password wajib diisi!');
                    return;
                }

                if (password !== passwordConfirm) {
                    alert('Password dan konfirmasi password tidak cocok!');
                    return;
                }

                if (password.length < 8) {
                    alert('Password minimal 8 karakter!');
                    return;
                }
            }

            // Add loading state
            const originalText = updateButton.innerHTML;
            updateButton.innerHTML = '<span class="loading-spinner mr-2"></span>Memperbarui...';
            updateButton.disabled = true;

            // Set form action and method
            form.action = `/admin/dokter/${userId}`;
            form.method = 'POST';

            // Add method spoofing for PUT
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }

            // Submit form
            form.submit();
        }

        function deleteUser(userId, userName) {
            // Show confirmation dialog
            if (!confirm(
                    `Apakah Anda yakin ingin menghapus Dokter "${userName}"? Data yang dihapus tidak dapat dikembalikan!`
                    )) {
                return;
            }

            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/dokter/${userId}`;

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfInput);

            // Add method spoofing for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            // Append form to body and submit
            document.body.appendChild(form);
            form.submit();
        }

        // Enhanced form validation with visual feedback
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500', 'ring-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500', 'ring-red-500');
                }
            });

            return isValid;
        }

        // Real-time validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const forms = ['create-user-form', 'edit-user-form'];

            forms.forEach(formId => {
                const form = document.getElementById(formId);
                if (form) {
                    const inputs = form.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.addEventListener('blur', function() {
                            if (this.required && !this.value.trim()) {
                                this.classList.add('border-red-300', 'ring-red-200');
                            } else {
                                this.classList.remove('border-red-300', 'ring-red-200');
                            }
                        });

                        input.addEventListener('input', function() {
                            if (this.classList.contains('border-red-300')) {
                                this.classList.remove('border-red-300', 'ring-red-200');
                            }
                        });
                    });
                }
            });
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateUserModal();
                closeEditUserModal();
            }
        });

        // Handle form submission with Enter key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const createModal = document.getElementById('create-user-modal');
                const editModal = document.getElementById('edit-user-modal');

                if (!createModal.classList.contains('hidden')) {
                    e.preventDefault();
                    saveUser();
                } else if (!editModal.classList.contains('hidden')) {
                    e.preventDefault();
                    updateUser();
                }
            }
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-auto-hide');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 300);
                }, 5000);
            });
        });
    </script>
@endpush