@php
    $prefix = auth()->user()->role;
@endphp

@extends('layouts.app')

@section('title', 'Data Pasien')

@section('page-title', 'Data dan Administrasi Pasien')

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
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">Kelola Pasien</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Kelola data pendaftaran dan identitas pasien.
            </p>
        </div>
        <div class="w-full sm:w-auto">
            @auth

                <button onclick="openCreatePasienModal()"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Pasien
                </button>

            @endauth
        </div>
    </div>

    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="pasien-search" placeholder="Cari nama, kode, No. Identitas, dan lain-lain..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-purple-500 focus:border-purple-500 text-sm">
        </div>
    </div>

    <div class="mb-2 flex flex-wrap items-end gap-4">
        <div class="flex flex-col justify-center">
            <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Lihat Semua</label>
            <div class="flex items-center gap-2 mt-2">
                <input type="checkbox" id="lihat_semua" name="lihat_semua" value="1"
                    {{ request('lihat_semua') == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="text-gray-700 dark:text-gray-300 text-sm">Tampilkan semua pasien</span>

            </div>
        </div>
        <!-- Filter Status -->
        <div class="flex flex-col text-sm">
            <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Status</label>
            <select id="filter_status"
                class="px-2 py-1 border rounded-md text-sm w-44
                   dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Semua</option>
                <option value="menunggu_konfirmasi" {{ request('status') == 'menunggu_konfirmasi' ? 'selected' : '' }}>
                    Menunggu</option>
                <option value="terdaftar" {{ request('status') == 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                <option value="diperiksa" {{ request('status') == 'diperiksa' ? 'selected' : '' }}>Diperiksa</option>
                <option value="menunggu_obat" {{ request('status') == 'menunggu_obat' ? 'selected' : '' }}>Menunggu Obat
                </option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <!-- Dari -->
        <div class="flex flex-col text-sm">
            <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Dari</label>
            <input type="date" id="start_date" value="{{ request('start_date') }}"
                class="px-2 py-1 border rounded-md text-sm w-36
               dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- Sampai -->
        <div class="flex flex-col text-sm">
            <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Sampai</label>
            <input type="date" id="end_date" value="{{ request('end_date') }}"
                class="px-2 py-1 border rounded-md text-sm w-36
               dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- Button -->
        <div class="flex gap-2">
            <button onclick="filterTanggal()"
                class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded-md">
                Filter
            </button>

            <a href="{{ route($prefix . '.pasien.index') }}"
                class="px-3 py-1.5 bg-gray-400 hover:bg-gray-500 text-white text-sm rounded-md">
                Reset
            </a>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400">
            <div class="w-full overflow-x-auto">
                <table class="min-w-[1200px] w-full text-left whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-gray-50 dark:bg-gray-700 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-center">

                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">No Antrian</th>
                            <th class="px-6 py-3">Tgl Daftar</th>
                            <th class="px-6 py-3">Estimasi Kedatangan</th>
                            <th class="px-6 py-3">NIK</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($data as $pasien)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition text-center">
                                {{-- NO --}}
                                <td class="px-6 py-4 text-sm">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- NO ANTRIAN --}}
                                <td class="px-6 py-4 text-sm font-semibold text-blue-600">
                                    {{ $pasien->queue_number ?? '-' }}
                                </td>

                                {{-- TANGGAL DAFTAR --}}
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($pasien->visit_date)->format('d-m-Y') }}
                                </td>

                                {{-- ESTIMASI KEDATANGAN --}}
                                <td class="px-6 py-4 text-sm">
                                    {{ $pasien->estimasi_jam ? \Carbon\Carbon::parse($pasien->estimasi_jam)->format('H:i') : '-' }}
                                </td>

                                {{-- NIK --}}
                                <td class="px-6 py-4 text-sm">
                                    {{ $pasien->identity->identity_number ?? '-' }}
                                </td>

                                {{-- NAMA --}}
                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ $pasien->identity->name ?? '-' }}
                                </td>

                                {{-- KATEGORI --}}
                                <td class="px-6 py-4 text-sm">
                                    {{ ucfirst($pasien->identity->identity_type ?? '-') }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4">
                                    @switch($pasien->status)
                                        @case('menunggu_konfirmasi')
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                                                Menunggu
                                            </span>
                                        @break

                                        @case('terdaftar')
                                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                                Terdaftar
                                            </span>
                                        @break

                                        @case('diperiksa')
                                            <span class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">
                                                Diperiksa
                                            </span>
                                        @break

                                        @case('menunggu_obat')
                                            <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded-full">
                                                Menunggu Obat
                                            </span>
                                        @break

                                        @case('selesai')
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                                Selesai
                                            </span>
                                        @break

                                        @default
                                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">
                                                -
                                            </span>
                                    @endswitch
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-4 text-right space-x-2">

                                    {{-- EDIT --}}
                                    <button data-pasien='@json($pasien)'onclick="editPasienFromButton(this)"
                                        class="text-purple-600 hover:text-purple-900">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- DETAIL --}}
                                    <a href="{{ route($prefix . '.pasien.show', $pasien->id) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route($prefix . '.pasien.destroy', $pasien->id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="button"
                                            data-action="{{ route($prefix . '.pasien.destroy', $pasien->id) }}"
                                            data-method="DELETE"
                                            data-confirm-type="delete"
                                            data-confirm-text="Data ini akan dihapus permanen!"
                                            onclick="handleActionWithConfirmation(this)"
                                            class="text-red-600 hover:text-red-800">
                                            
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-10 text-center text-gray-500">
                                        Data pasien masih kosong.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div id="create-pasien-modal" class="fixed inset-0 bg-black/50 z-50 hidden backdrop-blur-sm">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
                    <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold dark:text-white">Tambah Pasien Baru</h3>
                        <button onclick="closeCreatePasienModal()"><i class="fas fa-times text-gray-400"></i></button>
                    </div>

                    <form id="create-pasien-form" action="{{ route($prefix . '.pasien.store') }}" method="POST"
                        class="p-6 space-y-4">
                        @csrf

                        <input type="hidden" name="identity_type" id="hidden_identity_type">
                        <input type="hidden" name="gender" id="hidden_gender">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium">NIK *</label>
                                <input type="text" name="identity_number" id="nikInput" required
                                    class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium">Nama Lengkap *</label>
                                <input type="text" name="nama_pasien" id="namaInput" readonly
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Tanggal Lahir *</label>
                                <input type="date" name="tanggal_lahir" id="tglInput" readonly
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">No Telepon *</label>
                                <input type="text" name="no_telp" id="telpInput" readonly
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Kategori *</label>
                                <select name="identity_type" id="kategoriInput" disabled
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="karyawan">Karyawan</option>
                                    <option value="karyawan_buma">Karyawan BUMA</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Jenis Kelamin *</label>
                                <select name="gender" id="genderInput" disabled
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium">Alamat *</label>
                                <textarea name="alamat" id="alamatInput" rows="2" readonly
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100"></textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium">Poli *</label>

                                <input type="text" value="1"
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>

                                <input type="hidden" name="poli" value="1">
                            </div>

                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeCreatePasienModal()"
                                class="px-4 py-2 text-gray-600">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="edit-pasien-modal" class="fixed inset-0 bg-black/50 z-50 hidden backdrop-blur-sm">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
                    <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold dark:text-white">Edit Data Pasien</h3>
                        <button onclick="closeEditPasienModal()"><i class="fas fa-times text-gray-400"></i></button>
                    </div>

                    <form id="edit-pasien-form" method="POST" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-500">
                                    NIK
                                </label>
                                <input type="text" name="identity_number" id="edit-identity-number"
                                    class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium">Nama Lengkap *</label>
                                <input type="text" name="nama_pasien" id="edit-name" required
                                    class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Tanggal Lahir *</label>
                                <input type="date" name="tanggal_lahir" id="edit-birth-date" required
                                    class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">No Telepon *</label>
                                <input type="text" name="no_telp" id="edit-no-telp" required
                                    class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Kategori *</label>
                                <select name="identity_type" id="edit-identity-type" required
                                    class="w-full px-3 py-2 border rounded-lg">
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="karyawan">Karyawan</option>
                                    <option value="karyawan_buma">Karyawan BUMA</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Jenis Kelamin *</label>
                                <select name="gender" id="edit-gender" required class="w-full px-3 py-2 border rounded-lg">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium">Alamat *</label>
                                <textarea name="alamat" id="edit-address" rows="2" required class="w-full px-3 py-2 border rounded-lg"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Poli *</label>
                                <select name="poli" id="edit-poli"
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed" disabled>
                                    <option value="1" selected>1</option>
                                </select>

                                <!-- supaya tetap terkirim -->
                                <input type="hidden" name="poli" value="1">
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Status *</label>
                                <select name="status" id="edit-status" required class="w-full px-3 py-2 border rounded-lg">
                                    <option value="menunggu_konfirmasi">Menunggu</option>
                                    <option value="terdaftar">Terdaftar</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeEditPasienModal()"
                                class="px-4 py-2 text-gray-600">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function showNikNotFound() {
                    // hapus notif lama kalau ada
                    const old = document.getElementById('nik-alert');
                    if (old) old.remove();

                    const notif = document.createElement('div');
                    notif.id = 'nik-alert';
                    notif.className = "mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 text-sm";

                    notif.innerHTML = `
        <strong>NIK tidak ditemukan!</strong><br>
        Silakan tambahkan data pasien di <b>Kelola Civitas Akademik</b>.
    `;

                    const form = document.getElementById('create-pasien-form');
                    form.prepend(notif);

                    // auto hilang
                    setTimeout(() => {
                        notif.remove();
                    }, 5000);
                }
                document.querySelector('input[name="identity_number"]').addEventListener('blur', function() {
                    let nik = this.value;

                    if (nik.length === 16) {
                        fetch(`{{ route('cek.nik', '') }}/${nik}`)
                            .then(res => res.json())
                            .then(res => {

                                if (res.status) {
                                    let data = res.data;

                                    // isi field
                                    document.querySelector('input[name="nama_pasien"]').value = data.name ?? '';
                                    document.querySelector('input[name="tanggal_lahir"]').value = data.birth_date ?? '';
                                    document.querySelector('input[name="no_telp"]').value = data.no_telp ?? '';
                                    document.querySelector('textarea[name="alamat"]').value = data.address ?? '';

                                    document.querySelector('select[name="identity_type"]').value = data.identity_type ??
                                        '';
                                    document.querySelector('select[name="gender"]').value = data.gender ?? '';

                                    // 🔒 LOCK FIELD (readonly / disabled)
                                    document.querySelector('input[name="nama_pasien"]').readOnly = true;
                                    document.querySelector('input[name="tanggal_lahir"]').readOnly = true;
                                    document.querySelector('input[name="no_telp"]').readOnly = true;
                                    document.querySelector('textarea[name="alamat"]').readOnly = true;

                                    document.querySelector('select[name="identity_type"]').disabled = true;
                                    document.querySelector('select[name="gender"]').disabled = true;

                                    // 🔥 SYNC KE HIDDEN (biar tetap ke-submit)
                                    document.getElementById('hidden_identity_type').value = data.identity_type ?? '';
                                    document.getElementById('hidden_gender').value = data.gender ?? '';

                                } else {
                                    showNikNotFound();

                                    // 🔄 RESET FIELD
                                    document.querySelector('input[name="nama_pasien"]').value = '';
                                    document.querySelector('input[name="tanggal_lahir"]').value = '';
                                    document.querySelector('input[name="no_telp"]').value = '';
                                    document.querySelector('textarea[name="alamat"]').value = '';

                                    document.querySelector('select[name="identity_type"]').value = '';
                                    document.querySelector('select[name="gender"]').value = '';

                                    // 🔓 buka lagi kalau gagal
                                    document.querySelector('input[name="nama_pasien"]').readOnly = false;
                                    document.querySelector('input[name="tanggal_lahir"]').readOnly = false;
                                    document.querySelector('input[name="no_telp"]').readOnly = false;
                                    document.querySelector('textarea[name="alamat"]').readOnly = false;

                                    document.querySelector('select[name="identity_type"]').disabled = false;
                                    document.querySelector('select[name="gender"]').disabled = false;
                                }
                            })
                            .catch(() => {
                                alert("Terjadi kesalahan saat mengambil data.");
                            });
                    }
                });

                function openCreatePasienModal() {
                    document.getElementById('create-pasien-modal').classList.remove('hidden');
                }

                function closeCreatePasienModal() {
                    document.getElementById('create-pasien-modal').classList.add('hidden');
                    document.getElementById('create-pasien-form').reset();
                }

                function closeEditPasienModal() {
                    document.getElementById('edit-pasien-modal').classList.add('hidden');
                }

                function editPasienFromButton(btn) {
                    let data = JSON.parse(btn.dataset.pasien);
                    editPasien(data.id, data);
                }

                function editPasien(id, data) {

                    document.getElementById('edit-pasien-form')
                        .action = `{{ url($prefix . '/pasien') }}/${id}`;

                    document.getElementById('edit-identity-number').value = data.identity_number ?? '';
                    document.getElementById('edit-name').value = data.name ?? '';
                    document.getElementById('edit-birth-date').value = data.birth_date ?? '';
                    document.getElementById('edit-no-telp').value = data.no_telp ?? '';
                    document.getElementById('edit-identity-type').value = data.identity_type ?? '';
                    document.getElementById('edit-gender').value = data.gender ?? '';
                    document.getElementById('edit-address').value = data.address ?? '';
                    document.getElementById('edit-poli').value = data.poli ?? '';
                    document.getElementById('edit-status').value = data.status ?? '';

                    document.getElementById('edit-pasien-modal')
                        .classList.remove('hidden');
                }
                document.addEventListener('DOMContentLoaded', function() {

                    const input = document.getElementById('pasien-search');
                    const rows = document.querySelectorAll('.pasien-row');
                    const tbody = document.querySelector('tbody');

                    // membuat row "data tidak ditemukan"
                    const emptyRow = document.createElement('tr');
                    emptyRow.style.display = 'none';

                    emptyRow.innerHTML = `
        <td colspan="12" class="px-6 py-10 text-center text-gray-500">
            Data pasien tidak ditemukan.
        </td>
    `;

                    tbody.appendChild(emptyRow);

                    input.addEventListener('input', function() {

                        const keyword = this.value.toLowerCase().trim();
                        let visibleCount = 0;

                        rows.forEach(row => {

                            const match = row.innerText.toLowerCase().includes(keyword);

                            row.style.display = match ? '' : 'none';

                            if (match) visibleCount++;
                        });

                        // logika jika tidak ada hasil
                        if (keyword !== '' && visibleCount === 0) {
                            emptyRow.style.display = '';
                        } else {
                            emptyRow.style.display = 'none';
                        }

                    });

                });

                function filterTanggal() {
                    let start = document.getElementById('start_date').value;
                    let end = document.getElementById('end_date').value;

                    if (start) start = formatTanggal(start);
                    if (end) end = formatTanggal(end);

                    if (start && end && start > end) {
                        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                        return;
                    }

                    let url = new URL(window.location.href);

                    url.searchParams.delete('page');

                    if (start) {
                        url.searchParams.set('start_date', start);
                    } else {
                        url.searchParams.delete('start_date');
                    }

                    if (end) {
                        url.searchParams.set('end_date', end);
                    } else {
                        url.searchParams.delete('end_date');
                    }

                    window.location.href = url.toString();
                }

                function applyFilter() {
                    let status = document.getElementById('filter_status').value;

                    let url = new URL(window.location.href);

                    url.searchParams.delete('page');

                    // status
                    if (status) {
                        url.searchParams.set('status', status);
                    } else {
                        url.searchParams.delete('status');
                    }

                    window.location.href = url.toString();
                }


                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('start_date').addEventListener('change', filterTanggal);
                    document.getElementById('end_date').addEventListener('change', filterTanggal);
                    document.getElementById('filter_status').addEventListener('change', applyFilter);
                });

                document.getElementById('lihat_semua').addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    if (this.checked) {
                        url.searchParams.set('lihat_semua', 1); // tambahkan parameter
                    } else {
                        url.searchParams.delete('lihat_semua'); // hapus parameter jika tidak dicentang
                    }
                    window.location.href = url.toString(); // redirect otomatis
                });
            </script>
        @endpush

    @endsection
