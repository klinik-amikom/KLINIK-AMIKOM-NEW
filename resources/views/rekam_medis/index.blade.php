@extends('layouts.app')

@section('title', 'Data Rekam Medis')

@section('page-title', 'Kelola Rekam Medis')

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


    {{-- ================= HEADER ================= --}}
    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">
            Kelola Rekam Medis
        </h2>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
            Daftar seluruh rekam medis pasien
        </p>

        <div class="mt-6 mb-6">
            <div class="relative max-w-md">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>

                <input type="text" id="rekammedis-search"
                    placeholder="Cari kode, nama pasien, NIK, dokter, atau diagnosis..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 text-sm">
            </div>
        </div>


        <div class="flex flex-wrap items-end gap-4 mb-4">

            <!-- LIHAT SEMUA -->
            <div class="flex flex-col justify-center">
                <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Lihat Semua</label>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="lihat_semua" name="lihat_semua" value="1"
                        {{ request('lihat_semua') == 1 ? 'checked' : '' }}>
                    <span class="text-gray-700 dark:text-gray-300 text-sm">Tampilkan semua rekam medis</span>
                </div>
            </div>

            <!-- STATUS -->
            <div class="flex flex-col text-sm">
                <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Status</label>
                <select id="status_filter" name="status"
                    class="px-2 py-1 border rounded-md text-sm w-56
            dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua</option>
                    <option value="menunggu_pemeriksaan"
                        {{ request('status') == 'menunggu_pemeriksaan' ? 'selected' : '' }}>
                        Menunggu Pemeriksaan
                    </option>
                    <option value="diperiksa" {{ request('status') == 'diperiksa' ? 'selected' : '' }}>
                        Sedang Diperiksa
                    </option>
                    <option value="menunggu_obat" {{ request('status') == 'menunggu_obat' ? 'selected' : '' }}>
                        Menunggu Obat
                    </option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div>

            <!-- KATEGORI -->
            <div class="flex flex-col text-sm">
                <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Kategori</label>
                <select id="kategori_filter" name="kategori"
                    class="px-2 py-1 border rounded-md text-sm w-48
                    dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    <option value="">Semua</option>

                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- DARI -->
            <div class="flex flex-col text-sm">
                <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Dari</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                    class="px-2 py-1 border rounded-md text-sm w-36
            dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- SAMPAI -->
            <div class="flex flex-col text-sm">
                <label class="text-gray-500 dark:text-gray-400 text-xs mb-1">Sampai</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                    class="px-2 py-1 border rounded-md text-sm w-36
            dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- BUTTON FILTER & RESET -->
            <div class="flex gap-2">
                <button onclick="filterTanggal()"
                    class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded-md">
                    Filter
                </button>

                <a href="{{ route('rekammedis.index') }}"
                    class="px-3 py-1.5 bg-gray-400 hover:bg-gray-500 text-white text-sm rounded-md">
                    Reset
                </a>
            </div>

        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl border overflow-hidden">

        <div class="p-4 border-b dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">
                Daftar Rekam Medis
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase divide-x dark:divide-gray-600">
                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-100">
                        <th class="px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Tgl Daftar</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Jam Daftar</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Kode</th>
                        <th class="px-4 py-3 text-center border border-gray-200">NIK</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Nama Pasien</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Kategori</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Dokter</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Obat</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Diagnosis</th>
                        <th class="px-4 py-3 text-center border border-gray-200">Status</th>

                        @if (auth()->user()->role == 'dokter')
                            <th class="px-4 py-3 text-center">Periksa</th>
                        @endif

                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 divide-x">

                    @forelse ($dataRekamMedis as $item)
                        <tr
                            class="rekammedis-row odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-100">
                            <td class="px-4 py-3 border border-gray-200">{{ $loop->iteration }}</td>

                            <td class="px-4 py-3 border border-gray-200 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->tanggal_periksa)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-3 border border-gray-200 whitespace-nowrap">
                                {{ $item->pasien->identity->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-purple-600">
                                {{ $item->kode_rekam_medis }}
                            </td>

                            {{-- NIK --}}
                            <td class="px-4 py-3 border border-gray-200">
                                {{ $item->pasien->identity->identity_number ?? '-' }}
                            </td>

                            {{-- Nama Pasien --}}
                            <td class="px-4 py-3 border border-gray-200 whitespace-nowrap">
                                {{ $item->pasien->identity->name ?? '-' }}
                            </td>

                            {{-- Kategori --}}
                            <td class="px-4 py-3 border border-gray-200 text-center">
                                {{ $item->pasien->identity->identity_type ?? '-' }}
                            </td>

                            {{-- Nama Dokter --}}
                            <td class="px-4 py-3 border border-gray-200 whitespace-nowrap">
                                {{ $item->dokter->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 border border-gray-200">
                                @if ($item->resepObat->count() > 0)
                                    <ul class="space-y-1">
                                        @foreach ($item->resepObat as $resep)
                                            <li class="text-xs bg-gray-100 px-2 py-1 rounded">
                                                <strong>{{ $resep->obat->nama_obat ?? '-' }}</strong>
                                                ({{ $resep->jumlah }} pcs)
                                                <br>
                                                <span class="text-gray-500">
                                                    {{ $resep->aturan_pakai ?? '-' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 border border-gray-200">
                                {{ $item->diagnosis ?? '-' }}
                            </td>

                            {{-- STATUS BADGE --}}
                            <td class="px-4 py-3 border border-gray-200">
                                @switch($item->status)
                                    @case('menunggu_pemeriksaan')
                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">
                                            Menunggu Pemeriksaan
                                        </span>
                                    @break

                                    @case('diperiksa')
                                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">
                                            Sedang Diperiksa
                                        </span>
                                    @break

                                    @case('menunggu_obat')
                                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">
                                            Menunggu Obat
                                        </span>
                                    @break

                                    @case('selesai')
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                            Selesai
                                        </span>
                                    @break

                                    @default
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">
                                            -
                                        </span>
                                @endswitch
                            </td>

                            @if (auth()->user()->role == 'dokter')
                                <td class="px-4 py-3 text-center">

                                    {{-- Jika masih menunggu --}}
                                    @if ($item->status == 'menunggu_pemeriksaan')
                                        <form id="form-mulai-{{ $item->id }}" action="{{ route(auth()->user()->role . '.pasien.periksa', $item->pasien_id) }}" method="POST">
                                            @csrf
                                            <button type="button"
                                                onclick="confirmMulai({{ $item->id }})"
                                                class="bg-yellow-500 text-white text-xs px-3 py-1 rounded hover:bg-yellow-600">
                                                Mulai
                                            </button>
                                        </form>

                                        {{-- Jika sudah diperiksa --}}
                                    @elseif($item->status == 'diperiksa')
                                        <button
                                            class="bg-gray-400 text-white text-xs px-3 py-1 rounded cursor-not-allowed">
                                            Sedang
                                        </button>

                                        {{-- Jika sudah lanjut --}}
                                    @else
                                        <button
                                            class="bg-gray-300 text-gray-600 text-xs px-3 py-1 rounded cursor-not-allowed">
                                            Selesai
                                        </button>
                                    @endif

                                </td>
                            @endif

                            {{-- AKSI --}}
                                <td class="px-4 py-3 border border-gray-200">
                                    <div class="flex justify-end space-x-3">

                                        {{-- ✅ KHUSUS APOTEKER --}}
                                        @if (auth()->user()->role == 'apoteker')
                                            @if ($item->status == 'menunggu_obat')
                                                <form id="form-obat-{{ $item->id }}" action="{{ route('rekammedis.selesai', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="button"
                                                        onclick="confirmObatApoteker({{ $item->id }})"
                                                        class="bg-green-600 text-white text-xs px-3 py-1 rounded hover:bg-green-700">
                                                        Konfirmasi Obat
                                                    </button>
                                                </form>
                                            @elseif($item->status == 'selesai')
                                                <span
                                                    class="bg-gray-300 text-gray-600 text-xs px-3 py-1 rounded inline-block w-full text-center">
                                                    Sudah Diberikan
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">
                                                    Menunggu Dokter
                                                </span>
                                            @endif
                                        @endif

                                            <a href="{{ route('rekammedis.show', $item->id) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <form action="{{ route('rekammedis.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="button"
                                                    data-action="{{ route('rekammedis.destroy', $item->id) }}"
                                                    data-method="DELETE"
                                                    data-confirm-type="delete"
                                                    data-confirm-text="Data ini akan dihapus permanen!"
                                                    onclick="handleActionWithConfirmation(this)"
                                                    class="text-red-600 hover:text-red-800">
                                                    
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        <a href="{{ route('rekammedis.export.pasien', $item->pasien_id) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-file"></i>
                                        </a>
                                    </div>
                                </td>

                        </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-8 text-gray-500">
                                    Data rekam medis belum tersedia
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="p-4">
                    {{ $dataRekamMedis->links() }}
                </div>
            </div>
        </div>


        {{-- ================= EXPORT ================= --}}
        @if (in_array(auth()->user()->role, ['admin', 'dokter', 'admin_klinik']))
            <div class="flex justify-end mt-4 space-x-2">

                <button onclick="openExportModal('pdf')" class="bg-red-600 text-white px-4 py-2 text-sm rounded hover:bg-red-700">
                    Export PDF
                </button>

                <button onclick="openExportModal('excel')"
                    class="bg-green-600 text-white px-4 py-2 text-sm rounded hover:bg-green-700">
                    Export Excel
                </button>

            </div>
        @endif
        {{-- ================= MODAL EXPORT ================= --}}
        <div id="export-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

            <div class="bg-white rounded-lg shadow-lg w-96 p-6">

                <h3 class="text-lg font-semibold mb-4">
                    Export Rekam Medis
                </h3>

                <form id="export-form" method="GET">

                    <div class="mb-4">
                        <label class="block text-sm mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm mb-1">Tanggal Akhir</label>
                        <input type="date" name="tanggal_selesai" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="flex justify-end space-x-2 mt-4">

                        <button type="button" onclick="closeExportModal()"
                            class="px-3 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">
                            Batal
                        </button>

                        <button type="submit" class="px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            Export
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // ================= SEARCH =================
                const input = document.getElementById('rekammedis-search');
                const rows = document.querySelectorAll('.rekammedis-row');
                const tbody = document.querySelector('table tbody');

                const emptyRow = document.createElement('tr');
                emptyRow.style.display = 'none';

                emptyRow.innerHTML = `
                    <td colspan="11" class="px-6 py-10 text-center text-gray-500">
                        Data rekam medis tidak ditemukan.
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

                    emptyRow.style.display = (keyword !== '' && visibleCount === 0) ? '' : 'none';
                });


                // ================= AUTO FILTER =================
                document.getElementById('start_date')?.addEventListener('change', filterTanggal);
                document.getElementById('end_date')?.addEventListener('change', filterTanggal);
                document.getElementById('status_filter')?.addEventListener('change', filterTanggal);
                document.getElementById('kategori_filter')?.addEventListener('change', filterTanggal);

            });


            // ================= EXPORT =================
            function openExportModal(type) {
                let form = document.getElementById('export-form');

                if (type === 'pdf') {
                    form.action = "{{ route('rekammedis.export.pdf') }}";
                } else {
                    form.action = "{{ route('rekammedis.export.excel') }}";
                }

                document.getElementById('export-modal').classList.remove('hidden');
                document.getElementById('export-modal').classList.add('flex');
            }

            function closeExportModal() {
                document.getElementById('export-modal').classList.add('hidden');
            }


            // ================= FILTER =================
            function filterTanggal() {

                let start = document.getElementById('start_date')?.value;
                let end = document.getElementById('end_date')?.value;
                let status = document.getElementById('status_filter')?.value;

                if (start && end && start > end) {
                    alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                    return;
                }

                let kategori = document.getElementById('kategori_filter')?.value;

                let url = new URL(window.location.href);

                url.searchParams.delete('page');

                if (start) url.searchParams.set('start_date', start);
                else url.searchParams.delete('start_date');

                if (end) url.searchParams.set('end_date', end);
                else url.searchParams.delete('end_date');

                if (start || end) {
                    url.searchParams.delete('lihat_semua');
                }

                if (status) url.searchParams.set('status', status);
                else url.searchParams.delete('status');

                if (kategori) url.searchParams.set('kategori', kategori);
                else url.searchParams.delete('kategori');

                window.location.href = url.toString();
            }

            document.getElementById('lihat_semua').addEventListener('change', function() {
                const params = new URLSearchParams(window.location.search);

                if (this.checked) {
                    params.set('lihat_semua', 1); // centang = tampil semua
                } else {
                    params.delete('lihat_semua'); // tidak centang = default filter
                }

                // reload halaman dengan query baru
                window.location.search = params.toString();
            });

            function confirmMulai(id) {
                Swal.fire({
                    title: 'Mulai Pemeriksaan?',
                    text: "Apakah benar ingin melanjutkan ke tahap pemeriksaan?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#f59e0b',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, mulai!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-mulai-' + id).submit();
                    }
                });
            }

            function confirmObatApoteker(id) {
                Swal.fire({
                    title: 'Konfirmasi Penyerahan Obat',
                    html: `
                        <div style="text-align:left">
                            <p>Apakah Anda yakin obat sudah diberikan kepada pasien?</p>
                            <br>
                            <ul style="font-size:14px; color:#555">
                                <li>• Pastikan obat sesuai resep dokter</li>
                                <li>• Pastikan jumlah dan aturan pakai sudah dijelaskan</li>
                                <li>• Tindakan ini akan menyelesaikan proses pelayanan</li>
                            </ul>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, sudah diberikan',
                    cancelButtonText: 'Periksa kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-obat-' + id).submit();
                    }
                });
            }
        </script>
    @endsection
