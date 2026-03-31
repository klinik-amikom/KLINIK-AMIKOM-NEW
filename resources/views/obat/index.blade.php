@extends('layouts.app')

@section('title', 'Kelola Obat')

@section('page-title', 'Kelola Obat')

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

    <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 mb-6 sm:mb-8">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">Kelola Obat</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Manajemen stok, deskripsi, dan masa berlaku
                obat.</p>
        </div>
        <div class="w-full sm:w-auto">
            @if(auth()->user()->isApoteker())
                <button onclick="openCreateObatModal()"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Obat
                </button>
            @endif
        </div>
    </div>

    <div class="mb-6 flex flex-col sm:flex-row gap-3 sm:items-center">
        <!-- SEARCH -->
        <div class="relative max-w-md w-full">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="obat-search" placeholder="Cari kode, nama, atau deskripsi..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 text-sm">
        </div>
        <!-- FILTER -->
        <form method="GET">
            <select name="filter" onchange="this.form.submit()"
                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500">

                <option value="">Urutkan</option>

                <option value="stok_terkecil" {{ request('filter') == 'stok_terkecil' ? 'selected' : '' }}>
                    Stok Paling Sedikit
                </option>

                <option value="stok_terbesar" {{ request('filter') == 'stok_terbesar' ? 'selected' : '' }}>
                    Stok Paling Banyak
                </option>

            </select>
        </form>
    </div>

    @if($obatMenipis->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-red-200 dark:border-red-800 mb-6">

        <!-- Header -->
        <div class="p-4 sm:p-6 border-b border-red-200 dark:border-red-800 flex justify-between items-center">
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-7 h-7 bg-red-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-exclamation-triangle text-xs"></i>
                    </span>
                    Obat Stok Menipis
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Obat dengan stok ≤ 20
                </p>
            </div>

            <span class="text-xs px-3 py-1 bg-red-600 text-white rounded-full">
                {{ $obatMenipis->count() }} obat
            </span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-red-50 dark:bg-red-900/20 text-xs uppercase text-gray-500 dark:text-gray-300">
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama Obat</th>
                        <th class="px-6 py-3">Stok</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @foreach($obatMenipis as $obat)
                        <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition">

                            <td class="px-6 py-3 font-mono text-purple-600 dark:text-purple-400 font-bold text-sm">
                                {{ $obat->kode_obat }}
                            </td>

                            <td class="px-6 py-3 text-sm text-gray-900 dark:text-white">
                                {{ $obat->nama_obat }}
                            </td>

                            <td class="px-6 py-3 text-sm font-semibold
                                @if($obat->stok == 0)
                                    text-red-600
                                @elseif($obat->stok <= 5)
                                    text-red-500
                                @else
                                    text-yellow-600
                                @endif
                            ">
                                {{ $obat->stok }}
                            </td>

                            <td class="px-6 py-3">
                                @if($obat->stok == 0)
                                    <span class="px-2 py-1 text-xs bg-red-600 text-white rounded-md">
                                        Habis
                                    </span>
                                @elseif($obat->stok <= 5)
                                    <span class="px-2 py-1 text-xs bg-red-500 text-white rounded-md">
                                        Kritis
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-yellow-500 text-white rounded-md">
                                        Menipis
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Daftar Stok Obat</h3>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-500 dark:text-gray-300 font-medium">
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Nama Obat</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Kadaluarsa</th>
                        @if(auth()->user()->isApoteker())
                            <th class="px-6 py-4 text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse ($dataObat as $obat)
                        <tr class="obat-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono text-purple-600 dark:text-purple-400 font-bold">
                                {{ $obat->kode_obat }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $obat->nama_obat }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                {{ $obat->stok }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 italic max-w-xs truncate">
                                {{ $obat->deskripsi ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="px-2 py-1 rounded text-xs {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->isPast()
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-green-100 text-green-700' }}">
                                    {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                @if(auth()->user()->isApoteker())
                                    <button onclick="editObat({{ json_encode($obat) }})"
                                        class="text-purple-600 hover:text-purple-900">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST"
                                        class="inline shadow-none m-0"
                                        onsubmit="return confirm('Hapus data obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr class="obat-empty hidden">
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                Data obat masih kosong.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
            <div class="p-4">
                {{ $dataObat->links() }}
            </div>
        </div>

        <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($dataObat as $obat)
                <div class="obat-card p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span
                                class="text-[10px] font-mono text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded">{{ $obat->kode_obat }}</span>
                            <h4 class="font-bold text-gray-900 dark:text-white mt-1">{{ $obat->nama_obat }}</h4>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="editObat({{ json_encode($obat) }})" class="p-2 text-purple-600"><i
                                    class="fas fa-edit"></i></button>
                            <form action="{{ route(auth()->user()->role . '.obat.destroy', $obat->id) }}" method="POST"
                                class="inline shadow-none">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 line-clamp-2 italic">
                        "{{ $obat->deskripsi ?? 'Tidak ada deskripsi' }}"</p>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-600 dark:text-gray-300">Stok: <strong>{{ $obat->stok }}</strong></span>
                        <span class="text-gray-600 dark:text-gray-300">Exp:
                            <strong>{{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d/m/Y') }}</strong></span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="create-obat-modal"
        class="fixed inset-0 bg-black/50 z-50 hidden backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md">
            <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 dark:text-white">Tambah Obat Baru</h3>
                <button onclick="closeCreateObatModal()" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times"></i></button>
            </div>
            <form action="{{ route(auth()->user()->role . '.obat.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Obat *</label>
                        <input type="text" name="kode_obat" required maxlength="10"
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Stok *</label>
                        <input type="number" name="stok" required min="0"
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-purple-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Obat *</label>
                    <input type="text" name="nama_obat" required maxlength="100"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Kadaluarsa
                        *</label>
                    <input type="date" name="tanggal_kadaluarsa" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm focus:ring-purple-500"
                        placeholder="Ketik keterangan obat di sini..."></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeCreateObatModal()"
                        class="px-4 py-2 text-sm text-gray-600 border rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700">Simpan
                        Obat</button>
                </div>
            </form>
        </div>
    </div>

    <div id="edit-obat-modal"
        class="fixed inset-0 bg-black/50 z-50 hidden backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md">
            <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 dark:text-white">Edit Data Obat</h3>
                <button onclick="closeEditObatModal()" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times"></i></button>
            </div>
            <form id="edit-obat-form" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Obat</label>
                        <input type="text" name="kode_obat" id="edit-kode_obat" required
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Stok</label>
                        <input type="number" name="stok" id="edit-stok" required
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Obat</label>
                    <input type="text" name="nama_obat" id="edit-nama_obat" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                        Kadaluarsa</label>
                    <input type="date" name="tanggal_kadaluarsa" id="edit-tanggal_kadaluarsa" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="edit-deskripsi" rows="3"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white text-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeEditObatModal()"
                        class="px-4 py-2 text-sm text-gray-600 border rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700">Update
                        Data</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function openCreateObatModal() {
            document.getElementById('create-obat-modal').classList.remove('hidden');
        }

        function closeCreateObatModal() {
            document.getElementById('create-obat-modal').classList.add('hidden');
        }

        function openEditObatModal() {
            document.getElementById('edit-obat-modal').classList.remove('hidden');
        }

        function closeEditObatModal() {
            document.getElementById('edit-obat-modal').classList.add('hidden');
        }

        function editObat(data) {
            const form = document.getElementById('edit-obat-form');
            form.action = `/${"{{ auth()->user()->role }}"}/obat/${data.id}`;

            document.getElementById('edit-kode_obat').value = data.kode_obat;
            document.getElementById('edit-nama_obat').value = data.nama_obat;
            document.getElementById('edit-stok').value = data.stok;
            document.getElementById('edit-tanggal_kadaluarsa').value = data.tanggal_kadaluarsa;
            document.getElementById('edit-deskripsi').value = data.deskripsi || '';

            openEditObatModal();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('obat-search');
            const rows = document.querySelectorAll('.obat-row');
            const tbody = document.querySelector('tbody');

            // bikin row "kosong" via JS (BUKAN Blade)
            const emptyRow = document.createElement('tr');
            emptyRow.style.display = 'none';
            emptyRow.innerHTML = `
        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
            Data obat masih kosong.
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

                // LOGIKA PENTING 
                if (keyword !== '' && visibleCount === 0) {
                    emptyRow.style.display = '';
                } else {
                    emptyRow.style.display = 'none';
                }
            });
        });
    </script>
@endpush