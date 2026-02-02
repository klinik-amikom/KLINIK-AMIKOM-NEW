@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<!-- Welcome Section -->
<div class="animate-fade-in">
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white mb-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">
                    Selamat datang, Admin!
                </h1>
                <p class="text-purple-100 text-lg">
                    Pantau seluruh sistem dan kelola operasional Klinik Amikom
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Main Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Dokter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                <i class="fa-solid fa-user-doctor text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $totalDokterAktif }} {{-- Menggunakan variabel dari controller --}}
            </span>
        </div>
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
            Total Dokter Aktif
        </h3>
        <p class="text-xs text-green-600 flex items-center">
            <i class="fas fa-arrow-up mr-1"></i>
            +{{ $dokterBaruBulanIni }} dokter baru bulan ini {{-- Menggunakan variabel dari controller --}}
        </p>
    </div>

    <!-- Total Admin -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl">
                <i class="fas fa-user-shield text-white text-xl"></i> {{-- Mengubah ikon --}}
            </div>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $totalAdmin }} {{-- Menggunakan variabel dari controller --}}
            </span>
        </div>
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
            Total Admin {{-- Mengubah teks judul --}}
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">
            Pengelola Sistem
        </p>
    </div>

    <!-- Total Jenis Obat -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                <i class="fa-solid fa-capsules text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $totalJenisObat }}
            </span>
        </div>
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
            Total Jenis Obat
        </h3>
        <p class="text-xs text-green-600 flex items-center">
            <i class="fas fa-arrow-up mr-1"></i>
            Naik 12.5% dibading kemarin
        </p>
    </div>

    <!-- Jumlah Pasien Hari Ini -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $jumlahKunjunganHariIni }}
            </span>
        </div>
        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
            Jumlah Kunjungan Pasien Hari Ini
        </h3>
        <p class="text-xs text-green-600 flex items-center">
            <i class="fas fa-clock mr-1"></i>
            2 pasien sedang dilayani
        </p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Chart Section -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Bar Chart Kunjungan Pasien -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Statistik Kunjungan Pasien
                </h2>
                <div class="flex space-x-2">
                    <button id="btnDailyVisits" class="text-xs px-3 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 rounded-full">
                        Harian
                    </button>
                    <button id="btnWeeklyVisits" class="text-xs px-3 py-1 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                        Mingguan
                    </button>
                    <button id="btnMonthlyVisits" class="text-xs px-3 py-1 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                        Bulanan
                    </button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="patientVisitsChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Aktivitas Terbaru
                </h3>
            </div>
            <div class="space-y-3">
                <!-- Activity 1 -->
                <div class="flex items-center space-x-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            Pasien baru terdaftar
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            "Agus Pratama" telah mendaftar sebagai pasien baru
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400 font-semibold">
                            2 menit lalu
                        </p>
                    </div>
                </div>

                <!-- Activity 2 -->
                <div class="flex items-center space-x-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            Obat berhasil diberikan
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Paracetamol 500mg untuk pasien Andi diserahkan
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400 font-semibold">
                            5 menit lalu
                        </p>
                    </div>
                </div>

                <!-- Activity 3 -->
                <div class="flex items-center space-x-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-xs">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            Sistem maintenance
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Backup otomatis telah selesai
                        </p>
                        <p class="text-xs text-yellow-600 dark:text-yellow-400 font-semibold">
                            1 jam lalu
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="space-y-6">
        <!-- Top Merchants -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Kategori Pasien
                </h3>
            </div>
            <div class="space-y-3">
                <!-- Merchant 1 -->
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                            <i class="fas fa-user-graduate"></i> {{-- Icon untuk Mahasiswa --}}
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Mahasiswa</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalMahasiswa }} Pasien</p>
                    </div>
                </div>
                <!-- Merchant 2 -->
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                            <i class="fas fa-chalkboard-teacher"></i> {{-- Icon untuk Dosen --}}
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Dosen</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalDosen }} Pasien</p>
                    </div>
                </div>
                <!-- Merchant 3 -->
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                            <i class="fas fa-user-tie"></i> {{-- Icon untuk Staff --}}
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Karyawan</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $totalKaryawan }} Pasien</p>
                    </div>
                </div>
                 @if ($totalLainnyaKategori > 0)
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
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

        <!-- Pending Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Tindakan Diperlukan
            </h3>
            <div class="space-y-3">
                <!-- Pending Withdraw -->
                <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center text-white text-xs">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                Permintaan Obat Masuk
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                5 permintaan menunggu
                            </p>
                        </div>
                    </div>
                    <button class="text-xs px-3 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md transition-colors duration-200">
                        Review
                    </button>
                </div>

                <!-- New Merchant Approval -->
                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-xs">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                Pasien Baru Terdaftar
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                2 pendaftaran baru
                            </p>
                        </div>
                    </div>
                    <button class="text-xs px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                        Approve
                    </button>
                </div>

                <!-- System Issues -->
                <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                Error Sistem / Antrian Macet
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                1 issue ditemukan
                            </p>
                        </div>
                    </div>
                    <button class="text-xs px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200">
                        Check
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Tindakan Lainnya
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <button onclick="exportReport()"
                    class="flex flex-col items-center p-3 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors duration-200">
                    <i class="fas fa-download text-green-600 dark:text-green-400 text-lg mb-1"></i>
                    <span class="text-xs font-medium text-green-700 dark:text-green-300">Export</span>
                </button>
                <button onclick="addMerchant()"
                    class="flex flex-col items-center p-3 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors duration-200">
                    <i class="fas fa-plus text-green-600 dark:text-green-400 text-lg mb-1"></i>
                    <span class="text-xs font-medium text-green-700 dark:text-green-300">Add User</span>
                </button>
                <button onclick="systemBackup()"
                    class="flex flex-col items-center p-3 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors duration-200">
                    <i class="fas fa-database text-purple-600 dark:text-purple-400 text-lg mb-1"></i>
                    <span class="text-xs font-medium text-purple-700 dark:text-purple-300">Backup</span>
                </button>
                <button onclick="systemSettings()"
                    class="flex flex-col items-center p-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                    <i class="fas fa-cog text-gray-600 dark:text-gray-400 text-lg mb-1"></i>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Settings</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Semua kode Chart.js dan fungsi agregasi lainnya tetap di sini) ...

        // Quick Actions Functions (DIUBAH)
        window.exportReport = function() {
            window.showConfirmation({
                title: 'Export Laporan',
                text: 'Export laporan data klinik?', // Mengubah teks
                icon: 'question',
                confirmButtonText: 'Ya, Export',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showToast('Laporan sedang diproses...', 'info', 3000);
                    // Dalam aplikasi nyata, picu fungsionalitas ekspor (misal, AJAX call ke endpoint export laporan)
                    setTimeout(() => {
                        showToast('Laporan berhasil diunduh!', 'success');
                    }, 3000);
                }
            });
        }

        window.systemBackup = function() {
            window.showConfirmation({
                title: 'Backup Sistem', // Mengubah judul
                text: 'Mulai backup data sistem klinik sekarang? Proses ini mungkin memakan waktu beberapa menit.', // Mengubah teks
                icon: 'question',
                confirmButtonText: 'Ya, Backup',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showToast('Backup sistem dimulai...', 'info', 5000);
                    // Dalam aplikasi nyata, picu proses backup
                    setTimeout(() => {
                        showToast('Backup berhasil diselesaikan!', 'success');
                    }, 8000);
                }
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data rekam medis dari backend Laravel Anda
        // Pastikan variabel ini diisi dengan @json($rekamMedisData) dari DashboardController Anda
        const rawRekamMedisData = @json($rekamMedisData);

        const ctxVisits = document.getElementById('patientVisitsChart').getContext('2d');
        let currentVisitsChart; // Variabel untuk menyimpan instance chart kunjungan aktif

        // Fungsi untuk menghitung jumlah pasien per hari
        function aggregateDaily(data) {
            const dailyCounts = {};
            data.forEach(record => {
                const date = record.tanggal_periksa; // Ambil tanggal_periksa
                if (date) { // Pastikan tanggal_periksa ada
                    dailyCounts[date] = (dailyCounts[date] || 0) + 1;
                }
            });

            // Urutkan berdasarkan tanggal
            const sortedDates = Object.keys(dailyCounts).sort((a, b) => new Date(a) - new Date(b));
            const labels = sortedDates;
            const counts = sortedDates.map(date => dailyCounts[date]);

            return { labels, counts };
        }

        // Fungsi untuk menghitung jumlah pasien per minggu
        function aggregateWeekly(data) {
            const weeklyCounts = {};
            data.forEach(record => {
                const date = new Date(record.tanggal_periksa);
                // Hitung awal minggu (Minggu)
                const startOfWeek = new Date(date);
                startOfWeek.setDate(date.getDate() - date.getDay());
                startOfWeek.setHours(0, 0, 0, 0); // Reset time to start of day for consistency
                const weekKey = startOfWeek.toISOString().split('T')[0]; // Format YYYY-MM-DD
                weeklyCounts[weekKey] = (weeklyCounts[weekKey] || 0) + 1;
            });

            const sortedWeeks = Object.keys(weeklyCounts).sort((a, b) => new Date(a) - new Date(b));
            const labels = sortedWeeks.map(week => {
                const start = new Date(week);
                const end = new Date(start);
                end.setDate(start.getDate() + 6); // Akhir minggu (Sabtu)
                return `${start.toLocaleDateString('id-ID', { month: 'short', day: 'numeric' })} - ${end.toLocaleDateString('id-ID', { month: 'short', day: 'numeric' })}`;
            });
            const counts = sortedWeeks.map(week => weeklyCounts[week]);

            return { labels, counts };
        }

        // Fungsi untuk menghitung jumlah pasien per bulan
        function aggregateMonthly(data) {
            const monthlyCounts = {};
            data.forEach(record => {
                const date = new Date(record.tanggal_periksa);
                const monthKey = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}`; // YYYY-MM
                monthlyCounts[monthKey] = (monthlyCounts[monthKey] || 0) + 1;
            });

            const sortedMonths = Object.keys(monthlyCounts).sort();
            const labels = sortedMonths.map(month => {
                const [year, mon] = month.split('-');
                return new Date(year, mon - 1, 1).toLocaleDateString('id-ID', { year: 'numeric', month: 'long' });
            });
            const counts = sortedMonths.map(month => monthlyCounts[month]);

            return { labels, counts };
        }

        // Fungsi untuk membuat atau memperbarui chart kunjungan pasien
        function createOrUpdateVisitsChart(type) {
            if (currentVisitsChart) {
                currentVisitsChart.destroy(); // Hancurkan chart sebelumnya jika ada
            }

            let chartData, titleText;
            let barColors = 'rgba(102, 51, 153, 0.8)'; // Ungu standar (sesuai tema Anda)
            let borderColors = 'rgba(102, 51, 153, 1)';

            if (type === 'daily') {
                const { labels, counts } = aggregateDaily(rawRekamMedisData);
                chartData = { labels, datasets: [{ label: 'Jumlah Pasien', data: counts }] };
                titleText = 'Jumlah Pasien Harian';
            } else if (type === 'weekly') {
                const { labels, counts } = aggregateWeekly(rawRekamMedisData);
                chartData = { labels, datasets: [{ label: 'Jumlah Pasien', data: counts }] };
                titleText = 'Jumlah Pasien Mingguan';
            } else if (type === 'monthly') {
                const { labels, counts } = aggregateMonthly(rawRekamMedisData);
                chartData = { labels, datasets: [{ label: 'Jumlah Pasien', data: counts }] };
                titleText = 'Jumlah Pasien Bulanan';
            }

            // Atur warna bar dan border
            chartData.datasets[0].backgroundColor = barColors;
            chartData.datasets[0].borderColor = borderColors;
            chartData.datasets[0].borderWidth = 1;

            currentVisitsChart = new Chart(ctxVisits, {
                type: 'bar', // Tipe chart: 'bar'
                data: chartData,
                options: {
                    responsive: true, // Membuat chart responsif
                    maintainAspectRatio: false, // Penting untuk kontrol tinggi/lebar
                    plugins: {
                        legend: {
                            display: true, // Tampilkan legend karena ada 1 dataset
                            labels: {
                                color: 'rgb(156, 163, 175)' // Warna teks legend (gray-400)
                            }
                        },
                        title: {
                            display: true,
                            text: titleText,
                            color: 'rgb(156, 163, 175)' // Warna judul chart (gray-400)
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: 'rgb(156, 163, 175)', // Warna teks sumbu Y (gray-400)
                                precision: 0 // Pastikan angka bulat untuk jumlah pasien
                            },
                            grid: {
                                color: 'rgba(209, 213, 219, 0.1)' // Warna grid sumbu Y
                            }
                        },
                        x: {
                            ticks: {
                                color: 'rgb(156, 163, 175)' // Warna teks sumbu X (gray-400)
                            },
                            grid: {
                                color: 'rgba(209, 213, 219, 0.1)' // Warna grid sumbu X
                            }
                        }
                    }
                }
            });
            updateVisitsButtonStyles(type);
        }

        // Fungsi untuk mengupdate styling tombol aktif untuk chart kunjungan
        function updateVisitsButtonStyles(activeType) {
            document.querySelectorAll('#btnDailyVisits, #btnWeeklyVisits, #btnMonthlyVisits').forEach(button => {
                button.classList.remove('bg-purple-100', 'text-purple-800', 'dark:bg-purple-900/30', 'dark:text-purple-400');
                button.classList.add('text-gray-500', 'dark:text-gray-400', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
            });

            const activeButton = document.getElementById(`btn${activeType.charAt(0).toUpperCase() + activeType.slice(1)}Visits`);
            activeButton.classList.remove('text-gray-500', 'dark:text-gray-400', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
            activeButton.classList.add('bg-purple-100', 'text-purple-800', 'dark:bg-purple-900/30', 'dark:text-purple-400');
        }

        // Event Listener untuk tombol filter chart kunjungan
        document.getElementById('btnDailyVisits').addEventListener('click', () => createOrUpdateVisitsChart('daily'));
        document.getElementById('btnWeeklyVisits').addEventListener('click', () => createOrUpdateVisitsChart('weekly'));
        document.getElementById('btnMonthlyVisits').addEventListener('click', () => createOrUpdateVisitsChart('monthly'));

        // Inisialisasi chart kunjungan pertama kali dengan tampilan harian
        createOrUpdateVisitsChart('daily');

        // --- Bagian script yang sudah ada untuk weeklyTransactionChart dan lainnya ---
        // Kode untuk weeklyTransactionChart, dark mode update, setInterval,
        // dan Quick Actions Functions tetap di sini
        const ctxWeeklyTransaction = document.getElementById('weeklyTransactionChart').getContext('2d');
        const weeklyChart = new Chart(ctxWeeklyTransaction, {
            type: 'pie',
            data: {
                labels: ['QRIS', 'Cash', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: [
                        '#22c55e', // green-500
                        '#10b981', // emerald-500
                        '#f59e0b', // yellow-500
                        '#ef4444'  // red-500
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverBorderWidth: 3,
                    hoverBorderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // We have custom legend below
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + percentage + '% (' + value + '%)';
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 1000
                }
            }
        });

        // Dark mode chart update
        function updateChartColors() {
            const isDark = document.documentElement.classList.contains('dark');
            weeklyChart.options.plugins.tooltip.backgroundColor = isDark ? '#374151' : '#ffffff';
            weeklyChart.options.plugins.tooltip.titleColor = isDark ? '#f3f4f6' : '#1f2937';
            weeklyChart.options.plugins.tooltip.bodyColor = isDark ? '#d1d5db' : '#6b7280';
            weeklyChart.update();
        }

        // Observe dark mode toggle
        const observer = new MutationObserver(updateChartColors);
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        updateChartColors();

        // Auto refresh data every 5 minutes
        setInterval(() => {
            // In real app, fetch new data via AJAX
            console.log('Refreshing dashboard data...');
        }, 300000); // Check every 5 minutes

        // Quick Actions Functions
        window.exportReport = function() {
            window.showConfirmation({
                title: 'Export Laporan',
                text: 'Export laporan transaksi hari ini?',
                icon: 'question',
                confirmButtonText: 'Ya, Export',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showToast('Laporan sedang diproses...', 'info', 3000);
                    // In real app, trigger export functionality
                    setTimeout(() => {
                        showToast('Laporan berhasil didownload!', 'success');
                    }, 3000);
                }
            });
        }

        window.addMerchant = function() {
            // Redirect to add merchant page
            window.location.href = '/admin/users/create';
        }

        window.systemBackup = function() {
            window.showConfirmation({
                title: 'System Backup',
                text: 'Mulai backup sistem sekarang? Proses ini mungkin memakan waktu beberapa menit.',
                icon: 'question',
                confirmButtonText: 'Ya, Backup',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showToast('Backup sistem dimulai...', 'info', 5000);
                    // In real app, trigger backup process
                    setTimeout(() => {
                        showToast('Backup berhasil diselesaikan!', 'success');
                    }, 8000);
                }
            });
        }

        window.systemSettings = function() {
            // Redirect to settings page
            window.location.href = '/admin/settings';
        }

        // Real-time notification simulation
        setInterval(() => {
            if (Math.random() > 0.95) { // 5% chance every interval
                const notifications = [
                    { message: 'Transaksi baru dari Bakso Kang Adi', type: 'info' },
                    { message: 'Merchant baru mendaftar', type: 'success' },
                    { message: 'Withdraw request masuk', type: 'warning' }
                ];

                const randomNotif = notifications[Math.floor(Math.random() * notifications.length)];
                showToast(randomNotif.message, randomNotif.type, 4000);
            }
        }, 10000); // Check every 10 seconds
    });
</script>
@endpush