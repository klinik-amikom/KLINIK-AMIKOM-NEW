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
                    class="fill-current h-6 w-6 text-purple-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
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
                    class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 mb-6 sm:mb-8">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">
                Kelola Rekam Medis
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                Kelola data Rekam Medis dalam sistem
            </p>
        </div>
        <div class="w-full sm:w-auto">
            <button onclick="openCreateRekamMedisModal()"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Rekam Medis
            </button>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0 justify-between mb-4">
        <!-- Search Rekam Medis -->
        <div class="sm:w-2/4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="rekam-search" placeholder="Cari kode rekam medis, diagnosis, atau tanggal..."
                    class="block w-full pl-10 pr-3 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 text-sm sm:text-base">
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Daftar Rekam Medis</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kode Rekam</th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal Periksa
                        </th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Pasien</th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Dokter</th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Obat</th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Diagnosis</th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Resep</th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tgl Ambil Obat
                        </th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah Obat
                        </th>
                        <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($dataRekamMedis as $item)
                        <tr class="rekam-row">
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->kode_rekam_medis }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->tanggal_periksa }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                {{ $item->pasien->nama_pasien ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->obat->nama_obat ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->diagnosis ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->resep ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                {{ $item->tanggal_pengambilan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->jumlah_obat ?? '0' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-right">
                                <div class="flex justify-end space-x-2">
                                    <button onclick="editRekamMedis({{ $item->id }})"
                                        class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.rekammedis.destroy', $item->id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center px-4 py-8 text-gray-500 dark:text-gray-400">
                                <i class="fas fa-notes-medical text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Data rekam medis tidak tersedia</p>
                                <p class="text-sm">Belum ada rekam medis yang terdaftar dalam sistem</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end mt-4">
        <a href="{{ route('admin.rekam-medis.export.pdf') }}"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 mr-2">
            Export PDF
        </a>
        <a href="{{ route('admin.rekam-medis.export.excel') }}"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Export Excel
        </a>
    </div>

    <!-- Create Rekam Medis Modal -->
    <div id="create-rekammedis-modal"
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[999] hidden backdrop-blur-sm transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-sm sm:max-w-md transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
                <div
                    class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                            Tambah Rekam Medis Baru
                        </h3>
                        <button onclick="closeCreateRekamMedisModal()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form id="create-rekammedis-form" action="{{ route('admin.rekammedis.store') }}" method="POST"
                    class="p-4 sm:p-6">
                    @csrf
                    <div class="space-y-4">

                        <!-- Tanggal Periksa -->
                        <div>
                            <label for="tanggal_periksa"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tanggal Periksa <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tanggal_periksa" name="tanggal_periksa" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        </div>

                        <!-- Pasien -->
                        <div>
                            <label for="pasien_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Pasien <span class="text-red-500">*</span>
                            </label>
                            <select id="pasien_id" name="pasien_id" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="" disabled selected>Pilih Pasien</option>
                                @foreach ($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}">{{ $pasien->nama_pasien }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dokter -->
                        <div>
                            <label for="dokter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Dokter <span class="text-red-500">*</span>
                            </label>
                            <select id="dokter_id" name="dokter_id" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="" disabled selected>Pilih Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Obat -->
                        <div>
                            <label for="obat_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Obat <span class="text-red-500">*</span>
                            </label>
                            <select id="obat_id" name="obat_id" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="" disabled selected>Pilih Obat</option>
                                @foreach ($obats as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Diagnosis -->
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Diagnosis
                            </label>
                            <textarea id="diagnosis" name="diagnosis" rows="2"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">{{ old('diagnosis') }}</textarea>
                        </div>

                        <!-- Resep -->
                        <div>
                            <label for="resep" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Resep
                            </label>
                            <textarea id="resep" name="resep" rows="2"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">{{ old('resep') }}</textarea>
                        </div>

                        <!-- Tanggal Ambil Obat -->
                        <div>
                            <label for="tgl_ambil_obat"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tanggal Ambil Obat
                            </label>
                            <input type="date" id="tgl_ambil_obat" name="tgl_ambil_obat"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Jumlah Obat -->
                        <div>
                            <label for="jumlah_obat"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Jumlah Obat
                            </label>
                            <input type="number" id="jumlah_obat" name="jumlah_obat" min="1"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>

                    </div>

                    <div
                        class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-xl mt-6">
                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                            <button type="button" onclick="closeCreateRekamMedisModal()"
                                class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Edit Rekam Medis Modal -->
    <div id="edit-rekammedis-modal"
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[999] hidden backdrop-blur-sm transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-sm sm:max-w-md transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
                <div
                    class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Rekam Medis
                        </h3>
                        <button onclick="closeEditRekamMedisModal()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form id="edit-rekammedis-form" method="POST" class="p-4 sm:p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">

                        <!-- Tanggal Periksa -->
                        <div>
                            <label for="edit_tanggal_periksa"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tanggal Periksa <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="edit_tanggal_periksa" name="tanggal_periksa" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        </div>

                        <!-- Pasien -->
                        <div>
                            <label for="edit_pasien_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Pasien <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_pasien_id" name="pasien_id" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="" disabled>Pilih Pasien</option>
                                @foreach ($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}">{{ $pasien->nama_pasien }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dokter -->
                        <div>
                            <label for="edit_dokter_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Dokter <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_dokter_id" name="dokter_id" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="" disabled>Pilih Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Obat -->
                        <div>
                            <label for="edit_obat_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Obat <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_obat_id" name="obat_id" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="" disabled>Pilih Obat</option>
                                @foreach ($obats as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Diagnosis -->
                        <div>
                            <label for="edit_diagnosis"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Diagnosis
                            </label>
                            <textarea id="edit_diagnosis" name="diagnosis" rows="2"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"></textarea>
                        </div>

                        <!-- Resep -->
                        <div>
                            <label for="edit_resep" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Resep
                            </label>
                            <textarea id="edit_resep" name="resep" rows="2"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"></textarea>
                        </div>

                        <!-- Tanggal Ambil Obat -->
                        <div>
                            <label for="edit_tgl_ambil_obat"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tanggal Ambil Obat
                            </label>
                            <input type="date" id="edit_tgl_ambil_obat" name="tgl_ambil_obat"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Jumlah Obat -->
                        <div>
                            <label for="edit_jumlah_obat"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Jumlah Obat
                            </label>
                            <input type="number" id="edit_jumlah_obat" name="jumlah_obat" min="1"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>


                        <div
                            class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-xl mt-6">
                            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                                <button type="button" onclick="closeEditRekamMedisModal()"
                                    class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                                    Update
                                </button>
                            </div>
                        </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Data rekam medis untuk edit
        const rekamMedisData = @json($dataRekamMedis);

        function openCreateRekamMedisModal() {
            document.getElementById('create-rekammedis-modal').classList.remove('hidden');
            setTimeout(() => {
                const transform = document.querySelector('#create-rekammedis-modal .transform');
                if (transform) {
                    transform.classList.remove('scale-95');
                    transform.classList.add('scale-100');
                }
            }, 10);
        }

        function closeCreateRekamMedisModal() {
            const modal = document.getElementById('create-rekammedis-modal');
            const transform = modal.querySelector('.transform');
            if (transform) {
                transform.classList.add('scale-95');
                transform.classList.remove('scale-100');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('create-rekammedis-form').reset();
            }, 300);
        }

        function editRekamMedis(id) {
            const rekam = rekamMedisData.find(item => item.id === id);
            if (!rekam) return;

            // Set form action
            document.getElementById('edit-rekammedis-form').action = `/admin/rekammedis/${id}`;

            // Populate form fields
            document.getElementById('edit_tanggal_periksa').value = rekam.tanggal_periksa;
            document.getElementById('edit_pasien_id').value = rekam.pasien_id;
            document.getElementById('edit_dokter_id').value = rekam.user_id;
            document.getElementById('edit_obat_id').value = rekam.obat_id;
            document.getElementById('edit_diagnosis').value = rekam.diagnosis || '';
            document.getElementById('edit_resep').value = rekam.resep || '';
            document.getElementById('edit_tgl_ambil_obat').value = rekam.tanggal_pengambilan || '';
            document.getElementById('edit_jumlah_obat').value = rekam.jumlah_obat || '';

            // Open modal
            openEditRekamMedisModal();
        }

        function openEditRekamMedisModal() {
            document.getElementById('edit-rekammedis-modal').classList.remove('hidden');
            setTimeout(() => {
                const transform = document.querySelector('#edit-rekammedis-modal .transform');
                if (transform) {
                    transform.classList.remove('scale-95');
                    transform.classList.add('scale-100');
                }
            }, 10);
        }

        function closeEditRekamMedisModal() {
            const modal = document.getElementById('edit-rekammedis-modal');
            const transform = modal.querySelector('.transform');
            if (transform) {
                transform.classList.add('scale-95');
                transform.classList.remove('scale-100');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('edit-rekammedis-form').reset();
            }, 300);
        }

        // Search functionality
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('rekam-search');

            function filterRekamMedis() {
                const searchTerm = searchInput.value.toLowerCase();
                const rows = document.querySelectorAll('.rekam-row');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let found = false;

                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            found = true;
                        }
                    });

                    row.style.display = found ? '' : 'none';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterRekamMedis);
            }

            // Auto hide alerts
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

            // Close modal on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeCreateRekamMedisModal();
                    closeEditRekamMedisModal();
                }
            });
        });
    </script>
@endpush