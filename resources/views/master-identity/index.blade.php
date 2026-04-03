@extends('layouts.app')

@section('title', 'Master Pasien')
@section('page-title', 'Master Pasien')

@section('content')

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Master Civitas Akademik
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Data mahasiswa, dosen, dan karyawan
            </p>
        </div>

        <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg">
            <i class="fas fa-plus mr-2"></i> Tambah Data
        </button>
    </div>

    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="search" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, NIK, atau jenis..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg 
                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                   focus:ring-purple-500 focus:border-purple-500 text-sm">
        </div>
    </div>

    <div class="flex flex-wrap gap-4 mb-6 items-end">

        <!-- KATEGORI -->
        <div class="flex flex-col text-sm">
            <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Jenis</label>
            <select id="kategori_filter"
                class="px-2 py-1 border rounded-md text-sm w-48
            dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                <option value="">Semua</option>
                <option value="mahasiswa" {{ request('kategori') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="dosen" {{ request('kategori') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="karyawan" {{ request('kategori') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
        </div>

        <!-- DARI -->
        <div class="flex flex-col text-sm">
            <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Dari</label>
            <input type="date" id="start_date" value="{{ request('start_date') }}"
                class="px-2 py-1 border rounded-md text-sm w-36
            dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- SAMPAI -->
        <div class="flex flex-col text-sm">
            <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Sampai</label>
            <input type="date" id="end_date" value="{{ request('end_date') }}"
                class="px-2 py-1 border rounded-md text-sm w-36
            dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- BUTTON -->
        <div class="flex gap-2">
            <button onclick="applyFilter()"
                class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded-md">
                Filter
            </button>

            <a href="{{ route('master-identity.index') }}"
                class="px-3 py-1.5 bg-gray-400 hover:bg-gray-500 text-white text-sm rounded-md">
                Reset
            </a>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-xs uppercase">#</th>
                        <th class="px-6 py-3 text-xs uppercase">NIK</th>
                        <th class="px-6 py-3 text-xs uppercase">Nama</th>
                        <th class="px-6 py-3 text-xs uppercase">Jenis</th>
                        <th class="px-6 py-3 text-xs uppercase">Gender</th>
                        <th class="px-6 py-3 text-xs uppercase">No Telp</th>
                        <th class="px-6 py-3 text-xs uppercase text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $item->identity_number }}</td>
                            <td class="px-6 py-4 font-medium">{{ $item->name }}</td>
                            <td class="px-6 py-4 capitalize">{{ $item->identity_type }}</td>
                            <td class="px-6 py-4">{{ $item->gender }}</td>
                            <td class="px-6 py-4">{{ $item->no_telp ?? '-' }}</td>

                            <td class="px-6 py-4 text-right">

                                <div class="flex justify-end space-x-3">

                                    <button onclick='editData(@json($item))'
                                        class="text-purple-600 hover:text-purple-800">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('master-identity.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                            <td colspan="7" class="text-center py-10 text-gray-500">
                                Data belum tersedia
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

@endsection


{{-- ================= MODAL CREATE ================= --}}
<div id="create-modal"
    class="fixed inset-0 bg-black/50 hidden backdrop-blur-sm flex items-center justify-center p-4 z-50">

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md">

        {{-- HEADER --}}
        <div class="p-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Tambah Data
            </h3>

            <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- FORM --}}
        <form action="{{ route('master-identity.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <input name="identity_number" placeholder="NIK" class="w-full px-3 py-2 border rounded-lg">

            <input name="name" placeholder="Nama" class="w-full px-3 py-2 border rounded-lg">

            <select name="identity_type" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Jenis</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
                <option value="karyawan">Karyawan</option>
            </select>

            <select name="gender" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Gender</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <input name="no_telp" placeholder="No Telp" class="w-full px-3 py-2 border rounded-lg">

            <input name="email" placeholder="Email" class="w-full px-3 py-2 border rounded-lg">

            <textarea name="address" placeholder="Alamat" class="w-full px-3 py-2 border rounded-lg"></textarea>

            {{-- BUTTON --}}
            <div class="flex justify-end space-x-3 pt-2">

                <button type="button" onclick="closeCreateModal()"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Batal
                </button>

                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Simpan
                </button>

            </div>

        </form>

    </div>
</div>

<!-- MODAL EDIT -->
<div id="edit-modal"
    class="fixed inset-0 bg-black/50 hidden backdrop-blur-sm flex items-center justify-center p-4 z-50">

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md">

        <div class="p-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Edit Data
            </h3>

            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="edit-form" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <input id="edit-identity_number" name="identity_number" class="w-full px-3 py-2 border rounded-lg">

            <input id="edit-name" name="name" class="w-full px-3 py-2 border rounded-lg">

            <select id="edit-identity_type" name="identity_type" class="w-full px-3 py-2 border rounded-lg">
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
                <option value="karyawan">Karyawan</option>
            </select>

            <select id="edit-gender" name="gender" class="w-full px-3 py-2 border rounded-lg">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <input id="edit-no_telp" name="no_telp" class="w-full px-3 py-2 border rounded-lg">

            <input id="edit-email" name="email" class="w-full px-3 py-2 border rounded-lg">

            <textarea id="edit-address" name="address" class="w-full px-3 py-2 border rounded-lg"></textarea>

            <div class="flex justify-end space-x-3 pt-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded-lg">
                    Batal
                </button>

                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
    <script>
        function openCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-modal').classList.add('hidden');
        }

        function editData(data) {
            console.log(data);
        }

        function editData(data) {
            // buka modal
            document.getElementById('edit-modal').classList.remove('hidden');

            // set value ke form
            document.getElementById('edit-identity_number').value = data.identity_number;
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-identity_type').value = data.identity_type;
            document.getElementById('edit-gender').value = data.gender;
            document.getElementById('edit-no_telp').value = data.no_telp;
            document.getElementById('edit-email').value = data.email;
            document.getElementById('edit-address').value = data.address;

            // set action form
            document.getElementById('edit-form').action = `/master-identity/${data.id}`;
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
    </script>

    <script>
        // ================= AUTO SEARCH =================
        const searchInput = document.getElementById('search');
        let delayTimer;

        searchInput.addEventListener('keyup', function() {
            clearTimeout(delayTimer);

            delayTimer = setTimeout(() => {
                applyFilterURL();
            }, 500);
        });

        // ================= AUTO KATEGORI =================
        const kategoriSelect = document.getElementById('kategori_filter');

        kategoriSelect.addEventListener('change', function() {
            applyFilterURL();
        });

        // ================= FILTER TANGGAL (BUTTON) =================
        function applyFilter() {
            applyFilterURL();
        }

        // ================= FUNCTION GLOBAL =================
        function applyFilterURL() {
            let search = document.getElementById('search').value;
            let kategori = document.getElementById('kategori_filter').value;
            let start = document.getElementById('start_date').value;
            let end = document.getElementById('end_date').value;

            let url = new URL(window.location.href);

            // search
            if (search) url.searchParams.set('search', search);
            else url.searchParams.delete('search');

            // kategori (AUTO)
            if (kategori) url.searchParams.set('kategori', kategori);
            else url.searchParams.delete('kategori');

            // tanggal (tetap ikut, tapi trigger dari button)
            if (start) url.searchParams.set('start_date', start);
            else url.searchParams.delete('start_date');

            if (end) url.searchParams.set('end_date', end);
            else url.searchParams.delete('end_date');

            window.location.href = url.toString();
        }
    </script>
@endpush
