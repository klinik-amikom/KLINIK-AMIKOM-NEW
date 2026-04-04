@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')

@section('content')
    <!-- Welcome Section -->
    <div class="animate-fade-in">
        <div class="bg-[#8151B1] rounded-2xl p-6 text-white mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">
                        Selamat datang, Admin!
                    </h1>
                    <p class="text-white/80 text-lg">
                        Pantau seluruh sistem dan kelola operasional Klinik Amikom
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pasien -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                    <i class="fa-solid fa-user-doctor text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $totalPasien }} {{-- Menggunakan variabel dari controller --}}
                </span>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                Total Pasien
            </h3>
            <p class="text-xs text-green-600 flex items-center">
                <i class="fas fa-arrow-up mr-1"></i>
                +{{ $pasienBaruBulanIni }} pasien baru bulan ini {{-- Menggunakan variabel dari controller --}}
            </p>
        </div>

        <!-- Total Jumlah Kunjungan Hari ini -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-[#8151B1] rounded-xl">
                    <i class="fas fa-user-shield text-white text-xl"></i> {{-- Mengubah ikon --}}
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $kunjunganHariIni }}
                </span>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                Jumlah Kunjungan Pasien Hari Ini {{-- Mengubah teks judul --}}
            </h3>
            <p class="text-xs 
    {{ $persenKunjungan >= 0 ? 'text-green-600' : 'text-red-600' }} 
    flex items-center">

                <i class="fas 
        {{ $persenKunjungan >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} 
        mr-1"></i>

                {{ abs(round($persenKunjungan, 1)) }}% dibanding kemarin
            </p>
        </div>

        <!-- Pasien Aktif Saat Ini -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                    <i class="fa-solid fa-user-clock text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $pasienAktif }}
                </span>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                Pasien Aktif Saat Ini
            </h3>
            <p
                class="text-xs 
                {{ $persenPerubahan >= 0 ? 'text-green-600' : 'text-red-600' }} 
                flex items-center">

                <i
                    class="fas 
                    {{ $persenPerubahan >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} 
                    mr-1"></i>

                {{ abs(round($persenPerubahan, 1)) }}% dibanding kemarin
            </p>
        </div>

        <!-- Rata-rata Waktu Pelayanan -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $rataRataHariIni }} menit
                </span>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                Rata-rata Waktu Pelayanan
            </h3>
            <p
                class="text-xs 
                {{ $persenWaktu <= 0 ? 'text-green-600' : 'text-red-600' }} 
                flex items-center">

                <i
                    class="fas 
                    {{ $persenWaktu <= 0 ? 'fa-arrow-down' : 'fa-arrow-up' }} 
                    mr-1"></i>

                {{ abs(round($persenWaktu, 1)) }}% dibanding kemarin
            </p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Aktivitas Terbaru
                    </h3>
                </div>
                <div class="space-y-3">
                    @forelse($aktivitas as $item)
                        @php
                            // mapping status ke tampilan
                            $config = [
                                'menunggu_konfirmasi' => [
                                    'title' => 'Menunggu Konfirmasi',
                                    'color' => 'yellow',
                                    'icon' => 'fa-clock',
                                ],
                                'terdaftar' => [
                                    'title' => 'Pasien Terdaftar',
                                    'color' => 'green',
                                    'icon' => 'fa-user-plus',
                                ],
                                'diperiksa' => [
                                    'title' => 'Sedang Diperiksa',
                                    'color' => 'blue',
                                    'icon' => 'fa-stethoscope',
                                ],
                                'menunggu_obat' => [
                                    'title' => 'Menunggu Obat',
                                    'color' => 'purple',
                                    'icon' => 'fa-pills',
                                ],
                                'selesai' => [
                                    'title' => 'Selesai',
                                    'color' => 'gray',
                                    'icon' => 'fa-check',
                                ],
                            ];

                            $c = $config[$item->status] ?? $config['menunggu_konfirmasi'];
                        @endphp

                        <div
                            class="flex items-center space-x-3 p-3 
            bg-{{ $c['color'] }}-50 dark:bg-{{ $c['color'] }}-900/20 rounded-lg">

                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-{{ $c['color'] }}-500 rounded-full flex items-center justify-center text-white text-xs">
                                    <i class="fas {{ $c['icon'] }}"></i>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $c['title'] }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    "{{ $item->identity->name ?? '-' }}" sedang dalam proses
                                    {{ str_replace('_', ' ', $item->status) }}
                                </p>

                                <p
                                    class="text-xs text-{{ $c['color'] }}-600 dark:text-{{ $c['color'] }}-400 font-semibold">
                                    {{ $item->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                    @empty
                        <p class="text-sm text-gray-500 text-center">
                            Belum ada aktivitas hari ini
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- Bar Chart Kunjungan Pasien -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Statistik Kunjungan Pasien
                    </h2>
                    <div class="flex space-x-2">
                        <button id="btnDailyVisits"
                            class="text-xs px-3 py-1 bg-[#A78BFA]/20 text-[#6D28D9] dark:bg-[#7C3AED]/20 dark:text-[#A78BFA] rounded-full">
                            Harian
                        </button>
                        <button id="btnWeeklyVisits"
                            class="text-xs px-3 py-1 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                            Mingguan
                        </button>
                        <button id="btnMonthlyVisits"
                            class="text-xs px-3 py-1 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                            Bulanan
                        </button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="patientVisitsChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Obat Menipis -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Obat Menipis
                    </h3>

                    <!-- Button lihat lainnya -->
                    <a href="{{ route(auth()->user()->role . '.obat.index') }}"
                        class="text-xs px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                        Lihat lainnya
                    </a>
                </div>

                <!-- List -->
                <div class="space-y-3">

                    @forelse($obatMenipis->take(5) as $obat)
                        <div class="flex items-center space-x-3">
                            
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="
                                    w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm
                                    @if($obat->stok == 0)
                                        bg-red-600
                                    @elseif($obat->stok <= 5)
                                        bg-red-500
                                    @else
                                        bg-yellow-500
                                    @endif
                                ">
                                    <i class="fas fa-pills"></i>
                                </div>
                            </div>

                            <!-- Nama Obat -->
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $obat->nama_obat }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($obat->stok == 0)
                                        Stok habis
                                    @elseif($obat->stok <= 5)
                                        Stok kritis
                                    @else
                                        Stok menipis
                                    @endif
                                </p>
                            </div>

                            <!-- Jumlah -->
                            <div class="text-right">
                                <p class="
                                    text-sm font-semibold
                                    @if($obat->stok == 0)
                                        text-red-600 dark:text-red-400
                                    @elseif($obat->stok <= 5)
                                        text-red-500 dark:text-red-400
                                    @else
                                        text-yellow-600 dark:text-yellow-400
                                    @endif
                                ">
                                    {{ $obat->stok }}
                                </p>
                            </div>

                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                            Semua stok obat aman 👍
                        </p>
                    @endforelse

                </div>
            </div>
            <!-- Pending Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Tindakan Diperlukan
                </h3>

                <div class="space-y-3">

                    <!-- Menunggu Konfirmasi -->
                    <div
                        class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    Menunggu Konfirmasi
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $totalMenungguKonfirmasi }} pasien menunggu
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('rekammedis.index', ['status' => 'menunggu_konfirmasi']) }}"
                            class="text-xs px-3 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md transition">
                            Cek
                        </a>
                    </div>

                    <!-- Terdaftar -->
                    <div
                        class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    Terdaftar
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $totalTerdaftar }} pasien terdaftar
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('rekammedis.index', ['status' => 'terdaftar']) }}"
                            class="text-xs px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md transition">
                            Cek
                        </a>
                    </div>

                    <!-- Diperiksa -->
                    <div
                        class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    Diperiksa
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $totalDiperiksa }} pasien diperiksa
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('rekammedis.index', ['status' => 'diperiksa']) }}"
                            class="text-xs px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                            Cek
                        </a>
                    </div>

                    <!-- Menunggu Obat -->
                    <div
                        class="flex items-center justify-between p-3 bg-[#A78BFA]/20 dark:bg-purple-900/20 rounded-lg border border-[#A78BFA] dark:border-purple-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-[#7C3AED] rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-pills"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    Menunggu Obat
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $totalMenungguObat }} pasien menunggu obat
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('rekammedis.index', ['status' => 'menunggu_obat']) }}"
                            class="text-xs px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md transition">
                            Cek
                        </a>
                    </div>

                    <!-- Selesai -->
                    <div
                        class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    Selesai
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $totalSelesai }} pasien selesai
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('rekammedis.index', ['status' => 'selesai']) }}"
                            class="text-xs px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition">
                            Cek
                        </a>
                    </div>

                </div>
            </div>

            <!-- Top Merchants -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Kategori Pasien yang berobat
                    </h3>
                </div>
                <div class="space-y-3">
                    <!-- Merchant 1 -->
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div
                                class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                <i class="fas fa-user-graduate"></i> {{-- Icon untuk Mahasiswa --}}
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Mahasiswa</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalMahasiswa }}
                                Pasien</p>
                        </div>
                    </div>
                    <!-- Merchant 2 -->
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div
                                class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                <i class="fas fa-chalkboard-teacher"></i> {{-- Icon untuk Dosen --}}
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Dosen</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalDosen }} Pasien
                            </p>
                        </div>
                    </div>
                    <!-- Merchant 3 -->
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div
                                class="w-8 h-8 bg-[#7C3AED] rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                <i class="fas fa-user-tie"></i> {{-- Icon untuk Staff --}}
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Karyawan</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalKaryawan }}
                                Pasien</p>
                        </div>
                    </div>
                    <!-- Merchant 4 -->
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div
                                class="w-8 h-8 bg-[#75619D] rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                <i class="fas fa-user-tie"></i> {{-- Icon untuk Staff --}}
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Karyawan BUMA</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalKaryawanBuma }}
                                Pasien</p>
                        </div>
                    </div>
                    @if ($totalLainnyaKategori > 0)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-gray-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    <i class="fas fa-users"></i> {{-- Icon generik untuk Lainnya --}}
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Lainnya</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $totalLainnyaKategori }} Pasien</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===============================
            // DATA DARI CONTROLLER (WAJIB ADA)
            // ===============================
            const kunjunganHarian = @json($kunjunganHarian);
            const kunjunganMingguan = @json($kunjunganMingguan);
            const kunjunganBulanan = @json($kunjunganBulanan);

            const ctx = document.getElementById('patientVisitsChart').getContext('2d');
            let chart;

            // ===============================
            // FUNCTION RENDER CHART
            // ===============================
            function renderChart(labels, data, title) {
                if (chart) chart.destroy();

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Kunjungan',
                            data: data,
                            backgroundColor: 'rgba(102, 51, 153, 0.8)',
                            borderColor: 'rgba(102, 51, 153, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#9CA3AF'
                                }
                            },
                            title: {
                                display: true,
                                text: title,
                                color: '#9CA3AF'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#9CA3AF',
                                    precision: 0
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#9CA3AF'
                                }
                            }
                        }
                    }
                });
            }

            // ===============================
            // DEFAULT: HARIAN
            // ===============================
            renderChart(
                kunjunganHarian.map(i => i.tanggal),
                kunjunganHarian.map(i => i.total),
                'Kunjungan Harian'
            );

            // ===============================
            // BUTTON ACTION
            // ===============================
            document.getElementById('btnDailyVisits').onclick = () => {
                renderChart(
                    kunjunganHarian.map(i => i.tanggal),
                    kunjunganHarian.map(i => i.total),
                    'Kunjungan Harian'
                );
                setActive('Daily');
            };

            document.getElementById('btnWeeklyVisits').onclick = () => {
                renderChart(
                    kunjunganMingguan.map(i => 'Minggu ' + i.minggu),
                    kunjunganMingguan.map(i => i.total),
                    'Kunjungan Mingguan'
                );
                setActive('Weekly');
            };

            document.getElementById('btnMonthlyVisits').onclick = () => {
                renderChart(
                    kunjunganBulanan.map(i => i.bulan),
                    kunjunganBulanan.map(i => i.total),
                    'Kunjungan Bulanan'
                );
                setActive('Monthly');
            };

            // ===============================
            // STYLE BUTTON AKTIF
            // ===============================
            function setActive(type) {
                const buttons = ['Daily', 'Weekly', 'Monthly'];

                buttons.forEach(btn => {
                    const el = document.getElementById(`btn${btn}Visits`);
                    el.classList.remove('bg-[#A78BFA]/20', 'text-[#6D28D9]', 'dark:bg-[#7C3AED]/20',
                        'dark:text-[#A78BFA]');
                    el.classList.add('text-gray-500', 'dark:text-gray-400');
                });

                const active = document.getElementById(`btn${type}Visits`);
                active.classList.add('bg-[#A78BFA]/20', 'text-[#6D28D9]', 'dark:bg-[#7C3AED]/20',
                    'dark:text-[#A78BFA]');
            }

        });

        setInterval(() => {
            location.reload();
        }, 30000); // refresh tiap 30 detik
    </script>
@endpush