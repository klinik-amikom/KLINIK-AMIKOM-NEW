@extends('layouts.app')

@section('title', 'Data Pasien')

@section('page-title', 'Kelola Pasien')

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
            <button onclick="openCreatePasienModal()"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> Tambah Pasien
            </button>
        </div>
    </div>

    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="pasien-search" placeholder="Cari nama, kode, atau No. Identitas..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-purple-500 focus:border-purple-500 text-sm">
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Kode Pasien</th>
                        <th class="px-6 py-3">No Identitas</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">TTL</th>
                        <th class="px-6 py-3">Gender</th>
                        <th class="px-6 py-3">No Telp</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3">Poli</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($data as $pasien)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>

                            <td class="px-6 py-4 font-bold text-purple-600">
                                {{ $pasien->kode_pasien }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $pasien->identity->identity_number ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium">
                                {{ $pasien->identity->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ ucfirst($pasien->identity->identity_type ?? '-') }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $pasien->identity->birth_date ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $pasien->identity->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $pasien->identity->no_telp ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm max-w-xs truncate">
                                {{ $pasien->identity->address ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $pasien->poli }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
            {{ $pasien->status == 'terdaftar' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($pasien->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button
                                    onclick="editPasien({{ $pasien->id }}, {
                                        identity_number: '{{ $pasien->identity->identity_number }}',
                                        name: '{{ addslashes($pasien->identity->name) }}',
                                        birth_date: '{{ $pasien->identity->birth_date }}',
                                        no_telp: '{{ $pasien->identity->no_telp }}',
                                        identity_type: '{{ $pasien->identity->identity_type }}',
                                        gender: '{{ $pasien->identity->gender }}',
                                        address: '{{ addslashes($pasien->identity->address) }}',
                                        poli: '{{ $pasien->poli }}',
                                        status: '{{ $pasien->status }}'
                                    })"
                                    class="text-purple-600 hover:text-purple-900"><i class="fas fa-edit"></i></button>

                                <a href="{{ route('admin.pasien.show', $pasien->id) }}"
                                    class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>

                                <form action="{{ route('admin.pasien.destroy', $pasien->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">Data pasien masih kosong.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="create-pasien-modal" class="fixed inset-0 bg-black/50 z-50 hidden backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
                <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold dark:text-white">Tambah Pasien Baru</h3>
                    <button onclick="closeCreatePasienModal()"><i class="fas fa-times text-gray-400"></i></button>
                </div>

                <form id="create-pasien-form" action="{{ route('admin.pasien.store') }}" method="POST"
                    class="p-6 space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium">No Identitas *</label>
                            <input type="text" name="identity_number" required
                                class="w-full px-3 py-2 border rounded-lg">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium">Nama Lengkap *</label>
                            <input type="text" name="nama_pasien" required class="w-full px-3 py-2 border rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" required
                                class="w-full px-3 py-2 border rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">No Telepon *</label>
                            <input type="text" name="no_telp" required class="w-full px-3 py-2 border rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Kategori *</label>
                            <select name="identity_type" required class="w-full px-3 py-2 border rounded-lg">
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="karyawan">Karyawan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Jenis Kelamin *</label>
                            <select name="gender" required class="w-full px-3 py-2 border rounded-lg">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium">Alamat *</label>
                            <textarea name="alamat" rows="2" required class="w-full px-3 py-2 border rounded-lg"></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium">Poli *</label>
                            <select name="poli" required class="w-full px-3 py-2 border rounded-lg">
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                            </select>
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
        No Identitas
    </label>
    <input type="text"
        name="identity_number"
        id="edit-identity-number"
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
                            <select name="poli" id="edit-poli" required class="w-full px-3 py-2 border rounded-lg">
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                            </select>
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

    <script>
        document.querySelector('input[name="identity_number"]').addEventListener('blur', function() {
            let nik = this.value;

            if (nik.length === 16) {
                fetch(`/admin/pasien/identity/${nik}`)
                    .then(res => res.json())
                    .then(res => {

                        if (res.status) {
                            let data = res.data;

                            document.querySelector('input[name="nama_pasien"]').value = data.name ?? '';
                            document.querySelector('input[name="tanggal_lahir"]').value = data.birth_date ?? '';
                            document.querySelector('input[name="no_telp"]').value = data.no_telp ?? '';
                            document.querySelector('select[name="identity_type"]').value = data.identity_type ??
                                '';
                            document.querySelector('select[name="gender"]').value = data.gender ?? '';
                            document.querySelector('textarea[name="alamat"]').value = data.address ?? '';
                        }
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

        function editPasien(id, data) {

            document.getElementById('edit-pasien-form')
                .action = `/admin/pasien/${id}`;

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
    </script>
@endsection
