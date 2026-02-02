@extends('layouts.app')

@section('title', 'Data Pasien')

@section('page-title', 'Kelola Pasien')

@section('content')

{{-- Alert Messages --}}
@if(session('success'))
<div class="alert-auto-hide mb-4 bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded relative dark:bg-purple-900/30 dark:border-purple-600 dark:text-purple-300" role="alert">
    <strong class="font-bold">Berhasil!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg onclick="this.parentElement.parentElement.remove()" class="fill-current h-6 w-6 text-purple-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>Close</title>
            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
        </svg>
    </span>
</div>
@endif

@if(session('error'))
<div class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session('error') }}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg onclick="this.parentElement.parentElement.remove()" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>Close</title>
            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
        </svg>
    </span>
</div>
@endif

@if($errors->any())
<div class="alert-auto-hide mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/30 dark:border-red-600 dark:text-red-300" role="alert">
    <strong class="font-bold">Validasi Error!</strong>
    <ul class="mt-2 list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg onclick="this.parentElement.parentElement.remove()" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>Close</title>
            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
        </svg>
    </span>
</div>
@endif

<!-- Page Header -->
<div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 mb-6 sm:mb-8">
    <div>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">
            Kelola Pasien
        </h2>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
            Kelola data Pasien dalam sistem
        </p>
    </div>
    <div class="w-full sm:w-auto">
        <button onclick="openCreatePasienModal()"
            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah Pasien
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
            <input type="text" id="pasien-search" placeholder="Cari nama pasien, tanggal atau kode..."
                class="block w-full pl-10 pr-3 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 text-sm sm:text-base">
        </div>
    </div>
</div>

<!-- Tabel Pasien -->
<div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                Daftar Pasien
            </h3>
        </div>
    </div>
    
    <!-- Table View -->
    <div id="table-wiew" class="table-container overflow-x-auto">
        <table class="w-full text-left min-w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700">
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-0 bg-gray-50 dark:bg-gray-700 z-10 sm:static">
                        #
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-8 bg-gray-50 dark:bg-gray-700 z-10 sm:static min-w-[100px]">
                        Kode Pasien
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-8 bg-gray-50 dark:bg-gray-700 z-10 sm:static min-w-[100px]">
                        Nama Pasien
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell min-w-[100px]">
                        Tanggal Lahir
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell min-w-[100px]">
                        Jenis Kelamin
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell min-w-[100px]">
                        Poli
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[100px]">
                        Alamat
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell min-w-[100px]">
                        No Telp
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell min-w-[100px]">
                        Kategori
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell min-w-[100px]">
                        Status
                    </th>
                    <th class="px-3 sm:px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-right sticky right-0 bg-gray-50 dark:bg-gray-700 z-10 sm:static min-w-[70px]">
                        Aksi
                    </th>
                </tr>
            </thead>
           <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="pasien-table-body">
                @forelse ($data as $pasien)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 pasien-row">
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white font-medium sticky left-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->kode_pasien }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap sticky left-8 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                {{ strtoupper(substr($pasien->nama_pasien ?? 'P', 0, 1)) }}
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">{{ $pasien->nama_pasien }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->tanggal_lahir }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden lg:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->jenis_kel }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->poli }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->alamat }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->no_telp }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->kategori }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $pasien->status }}</div>
                    </td>
                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium sticky right-0 bg-white dark:bg-gray-800 z-10 sm:static">
                        <div class="flex items-center justify-end space-x-1">
                            <button onclick="editPasien({{ $pasien->id }}, {
                                nama_pasien: '{{ addslashes($pasien->nama_pasien) }}',
                                kode_pasien: '{{ addslashes($pasien->kode_pasien) }}',
                                tanggal_lahir: '{{ $pasien->tanggal_lahir }}',
                                jenis_kel: '{{ $pasien->jenis_kel }}',
                                poli: '{{ $pasien->poli }}',
                                alamat: '{{ addslashes($pasien->alamat) }}',
                                no_telp: '{{ addslashes($pasien->no_telp) }}',
                                status: '{{ $pasien->status }}',
                                kategori: '{{ $pasien->kategori }}'
                                })"
                                class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 p-1.5 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200"
                                title="Edit">
                                <i class="fas fa-edit text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="deletePasien({{ $pasien->id }}, '{{ addslashes($pasien->nama_pasien) }}')"
                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                title="Delete">
                                <i class="fas fa-trash text-xs sm:text-sm"></i>
                            </button>
                            <a href="{{route('admin.pasien.show',$pasien->id)}}"
                                class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 p-1.5 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors duration-200"
                                title="show">
                                <i class="fas fa-eye text-xs sm:text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8">
                        <div class="text-gray-500 dark:text-gray-400">
                            <i class="fas fa-user-injured text-4xl mb-4"></i>
                            <p class="text-lg font-medium">Data pasien tidak tersedia</p>
                            <p class="text-sm">Belum ada pasien yang terdaftar dalam sistem</p>
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
        @forelse ($data as $pasien)
            <div class="user-card bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($pasien->nama_pasien ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $pasien->nama_pasien }}</h4>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button onclick="editPasien({{ $pasien->id }},
                            nama_pasien: '{{ addslashes($pasien->nama_pasien) }}',
                            kode_pasien: '{{ addslashes($pasien->kode_pasien) }}',
                            tanggal_lahir: '{{ $pasien->tanggal_lahir }}',
                            jenis_kel: '{{ $pasien->jenis_kel }}',
                            poli: '{{ $pasien->poli }}',
                            alamat: '{{ addslashes($pasien->alamat) }}',
                            no_telp: '{{ addslashes($pasien->no_telp) }}',
                            status: '{{ $pasien->status }}'
                            })"
                            class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 p-2 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>

                        <button onclick="deletePasien({{ $pasien->id }}, '{{ addslashes($pasien->nama_pasien) }}')"
                            class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                            title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Nama Pasien:</span>
                        <span class="text-gray-900 dark:text-white">{{ $pasien->nama_pasien }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Jenis Kelamin</span>
                        <span class="text-gray-900 dark:text-white">{{ $pasien->jenis_kel }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Poli</span>
                        <span class="text-gray-900 dark:text-white">{{ $pasien->poli }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 dark:text-gray-400">No Telepon</span>
                        <span class="text-gray-900 dark:text-white">{{ $pasien->no_telp }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Status</span>
                        <span class="text-gray-900 dark:text-white">{{ $pasien->status }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="text-gray-500 dark:text-gray-400">
                    <i class="fas fa-users text-4xl mb-4"></i>
                    <h4 class="text-lg font-medium">Data Pasien Tidak Tersedia</h4>
                    <p class="text-sm">Belum ada admin yang terdaftar dalam sistem</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Create Pasien Modal -->
<div id="create-pasien-modal" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50 hidden backdrop-blur-sm transition-all duration-300">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-sm sm:max-w-md transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
            <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                <div class="flex items-center justify-between">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                        Tambah Pasien Baru
                    </h3>
                    <button onclick="closeCreatePasienModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <form id="create-pasien-form" class="p-4 sm:p-6">
                @csrf
                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <label for="create-name" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="create-name" name="nama_pasien" required value="{{ old('nama_pasien') }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                            placeholder="Masukkan nama pasien">
                    </div>

                    <div>
                        <label for="birth-date" class="block text-xs sm:text-sm font-medium text-purple-700 dark:text-purple-300 mb-1">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="birth-date" name="tanggal_lahir" required
                        class="w-full px-3 py-2 text-sm border border-purple-300 dark:border-purple-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                        placeholder="Tanggal Lahir">
                    </div>

                    <div>
                        <label for="jenis-kelamin" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis-kelamin" name="jenis_kel" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="kategori" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori" name="kategori" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div>
                        <label for="pilihan-poli" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Poli <span class="text-red-500">*</span>
                        </label>
                        <select id="pilihan-poli" name="poli" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                            <option value="" disabled selected>Pilih Poli yang Akan Dikunjungi</option>
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                        </select>
                    </div>

                    <div>
                        <label for="create-phone" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            No. Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="create-phone" name="no_telp" required value="{{ old('no_telp') }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                            placeholder="+62 812-3456-7890">
                    </div>

                    <div>
                        <label for="create-alamat" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Alamat
                        </label>
                        <textarea id="create-alamat" name="alamat" rows="2"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                            placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </form>

            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-xl">
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" onclick="closeCreatePasienModal()"
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="button" onclick="savePasien()"
                        class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Pasien Modal -->
<div id="edit-pasien-modal" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50 hidden backdrop-blur-sm transition-all duration-300">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-sm sm:max-w-md transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
            <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                <div class="flex items-center justify-between">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Pasien
                    </h3>
                    <button onclick="closeEditPasienModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <form id="edit-pasien-form" class="p-4 sm:p-6">
                @csrf
                <input type="hidden" id="edit-pasien-id" name="pasien_id">
                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <label for="edit-name" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit-name" name="nama_pasien" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                    </div>

                    <div>
                        <label for="birth-date-edit" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="birth-date-edit" name="tanggal_lahir" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"
                        placeholder="Tanggal Lahir">
                    </div>

                    <div>
                        <label for="jenis-kelamin-edit" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis-kelamin-edit" name="jenis_kel" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Perempuan">Perempuan</option>
                            <option value="Laki-laki">Laki-laki</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-pilihan-poli" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Poli <span class="text-red-500">*</span>
                        </label>
                        <select id="edit-pilihan-poli" required name="poli"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                            <option value="" disabled selected>Pilih Poli yang Akan Dikunjungi</option>
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-kategori" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="edit-kategori" required name="kategori"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit-phone" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            No. Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="edit-phone" name="no_telp" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                    </div>

                    <div>
                        <label for="edit-alamat" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Alamat
                        </label>
                        <textarea id="edit-alamat" name="alamat" rows="2"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200"></textarea>
                    </div>
                </div>
            </form>

            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-xl">
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" onclick="closeEditPasienModal()"
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="button" onclick="updatePasien()"
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
        
        th, td {
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
    #table-view, #card-view {
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
            linear-gradient(90deg, rgba(255,255,255,1) 30%, rgba(255,255,255,0)) left,
            linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,1) 70%) right;
        background-repeat: no-repeat;
        background-color: white;
        background-size: 40px 100%, 40px 100%;
        background-attachment: local, local;
    }
    
    .dark .table-container {
        background: 
            linear-gradient(90deg, rgba(31,41,55,1) 30%, rgba(31,41,55,0)) left,
            linear-gradient(90deg, rgba(31,41,55,0), rgba(31,41,55,1) 70%) right;
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
    const searchInput = document.getElementById('pasien-search');

    function filterPasiens() {
        const searchTerm = searchInput.value.toLowerCase();

        // Filter table rows
        const rows = document.querySelectorAll('.pasien-row');
        // Filter card views
        const cards = document.querySelectorAll('.pasien-card');

        [...rows, ...cards].forEach(item => {
            let name, username, kode, phone, alamat;

            if (item.classList.contains('pasien-row')) {
                // Table row filtering
                const cells = item.querySelectorAll('td');
                name = cells[1].textContent.toLowerCase();
                username = cells[2] ? cells[2].textContent.toLowerCase() : '';
                kode = cells[3] ? cells[3].textContent.toLowerCase() : '';
                phone = cells[4] ? cells[4].textContent.toLowerCase() : '';
                alamat = cells[5] ? cells[5].textContent.toLowerCase() : '';
            } else {
                // Card filtering
                name = item.querySelector('h4').textContent.toLowerCase();
                const spans = item.querySelectorAll('.text-gray-900');
                username = spans[1] ? spans[1].textContent.toLowerCase() : '';
                phone = spans[2] ? spans[2].textContent.toLowerCase() : '';
                alamat = spans[3] ? spans[3].textContent.toLowerCase() : '';
            }

            const matchesSearch = name.includes(searchTerm) ||
                                username.includes(searchTerm) ||
                                kode.includes(searchTerm) ||
                                phone.includes(searchTerm) ||
                                alamat.includes(searchTerm);

            if (matchesSearch) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterPasiens);
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
function openCreatePasienModal() {
    const modal = document.getElementById('create-pasien-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            const transform = modal.querySelector('.transform');
            if (transform) {
                transform.classList.remove('scale-95');
                transform.classList.add('scale-100');
            }
        }, 10);
    }

    function closeCreatePasienModal() {
        const modal = document.getElementById('create-pasien-modal');
        const transform = modal.querySelector('.transform');
        if (transform) {
            transform.classList.add('scale-95');
            transform.classList.remove('scale-100');
        }
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('create-pasien-form').reset();
            // Clear validation errors if any
            document.querySelectorAll('#create-pasien-form .border-red-500, #create-pasien-form .ring-red-500').forEach(el => {
                el.classList.remove('border-red-500', 'ring-red-500');
            });
        }, 300);
    }

    function openEditPasienModal() {
        const modal = document.getElementById('edit-pasien-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            const transform = modal.querySelector('.transform');
            if (transform) {
                transform.classList.remove('scale-95');
                transform.classList.add('scale-100');
            }
        }, 10);
    }

    function closeEditPasienModal() {
        const modal = document.getElementById('edit-pasien-modal');
        const transform = modal.querySelector('.transform');
        if (transform) {
            transform.classList.add('scale-95');
            transform.classList.remove('scale-100');
        }
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('edit-pasien-form').reset();
            // Clear validation errors if any
            document.querySelectorAll('#edit-pasien-form .border-red-500, #edit-pasien-form .ring-red-500').forEach(el => {
                el.classList.remove('border-red-500', 'ring-red-500');
            });
        }, 300);
    }

    // User Management Functions - Menggunakan Form Submission seperti yang Anda inginkan
    function savePasien() {
        const form = document.getElementById('create-pasien-form');
        const saveButton = document.querySelector('#create-pasien-modal button[onclick="savePasien()"]');

        // Lakukan validasi menggunakan fungsi validateForm
        if (!validateForm('create-pasien-form')) {
            alert('Mohon lengkapi semua kolom yang wajib diisi!');
            return;
        }

        // Loading state
        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = '<span class="loading-spinner mr-2"></span>Menyimpan...';
        saveButton.disabled = true;

        // Atur action dan method form
        // Pastikan route '/admin/pasien' sudah ada di web.php (Laravel) dengan method POST
        form.action = '{{ route('admin.pasien.store') }}'; // Menggunakan helper route Laravel
        form.method = 'POST';

        // Submit form
        form.submit();
    }

    function editPasien(pasienId, pasienData) { // Perbaiki nama parameter menjadi pasienData
        // Populate form fields with passed data
        console.log(pasienData);
        document.getElementById('edit-pasien-id').value = pasienId;
        document.getElementById('edit-name').value = pasienData.nama_pasien || ''; // Sesuaikan dengan nama kolom database
        document.getElementById('birth-date-edit').value = pasienData.tanggal_lahir || ''; // Tambahkan ini
        document.getElementById('jenis-kelamin-edit').value = pasienData.jenis_kel || ''; // Tambahkan ini
        document.getElementById('edit-pilihan-poli').value = pasienData.poli || ''; // Sesuaikan dengan nama kolom database
        document.getElementById('edit-phone').value = pasienData.no_telp || '';
        document.getElementById('edit-alamat').value = pasienData.alamat || ''; // Sesuaikan dengan nama kolom database
        document.getElementById('edit-kategori').value = pasienData.kategori || ''; // Sesuaikan dengan nama kolom database

        // Open modal
        openEditPasienModal();
    }

    function updatePasien() {
        const form = document.getElementById('edit-pasien-form');
        const updateButton = document.querySelector('#edit-pasien-modal button[onclick="updatePasien()"]');
        const pasienId = document.getElementById('edit-pasien-id').value;

        // Lakukan validasi menggunakan fungsi validateForm
        if (!validateForm('edit-pasien-form')) {
            alert('Mohon lengkapi semua kolom yang wajib diisi!');
            return;
        }

        // Add loading state
        const originalText = updateButton.innerHTML;
        updateButton.innerHTML = '<span class="loading-spinner mr-2"></span>Memperbarui...';
        updateButton.disabled = true;

        // Set form action and method
        // Pastikan route 'admin.pasien.update' sudah ada di web.php (Laravel) dengan method PUT
        form.action = `{{ url('/admin/pasien') }}/${pasienId}`; // Menggunakan url helper dan template literal
        form.method = 'POST'; // Tetap POST untuk spoofing method

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

    function deletePasien(pasienId, pasienName) {
        // Show confirmation dialog
        if (!confirm(`Apakah Anda yakin ingin menghapus Pasien "${pasienName}"? Data yang dihapus tidak dapat dikembalikan!`)) {
            return;
        }

        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        // Pastikan route 'admin.pasien.destroy' sudah ada di web.php (Laravel) dengan method DELETE
        form.action = `{{ url('/admin/pasien') }}/${pasienId}`; // Menggunakan url helper dan template literal

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
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]'); // Tambahkan textarea
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
        const forms = ['create-pasien-form', 'edit-pasien-form'];

        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                const inputs = form.querySelectorAll('input, select, textarea'); // Tambahkan textarea
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
            closeCreatePasienModal();
            closeEditPasienModal();
        }
    });

    // Handle form submission with Enter key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const createModal = document.getElementById('create-pasien-modal');
            const editModal = document.getElementById('edit-pasien-modal');

            // Cek apakah modal "Create Pasien" sedang terbuka
            if (!createModal.classList.contains('hidden') && document.activeElement.closest('#create-pasien-form')) {
                e.preventDefault(); // Mencegah submit default
                savePasien();
            }
            // Cek apakah modal "Edit Pasien" sedang terbuka
            else if (!editModal.classList.contains('hidden') && document.activeElement.closest('#edit-pasien-form')) {
                e.preventDefault(); // Mencegah submit default
                updatePasien();
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