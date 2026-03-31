<?php
namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Obat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama sesuai dengan role user yang login.
     */
    public function index()
    {
        // 1. Ambil data rekam medis untuk chart kunjungan (1 tahun terakhir)
        $rekamMedisData = RekamMedis::where('tanggal_periksa', '>=', now()->subYear())
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        // Total pasien (unique dari rekam medis)
        $totalPasien = RekamMedis::distinct('pasien_id')->count('pasien_id');

        // Pasien baru bulan ini (berdasarkan rekam medis bulan ini)
        $pasienBaruBulanIni = RekamMedis::whereYear('tanggal_periksa', now()->year)
            ->whereMonth('tanggal_periksa', now()->month)
            ->distinct('pasien_id')
            ->count('pasien_id');

        // Statistik Kunjungan Hari Ini (dari rekam medis)
        $jumlahKunjunganHariIni = RekamMedis::whereDate('tanggal_periksa', now()->toDateString())->count();

        // 4. Statistik Pasien berdasarkan identity_type dari master_identity
        $pasienByKategori = RekamMedis::join('pasien', 'rekam_medis.pasien_id', '=', 'pasien.id')
            ->join('master_identity', 'pasien.identity_id', '=', 'master_identity.id')
            ->select('master_identity.identity_type', DB::raw('COUNT(DISTINCT pasien.id) as total'))
            ->groupBy('master_identity.identity_type')
            ->pluck('total', 'identity_type')
            ->toArray();

        // Normalisasi nama key kategori (mengubah ke lowercase untuk konsistensi pengecekan)
        $pasienByKategori = array_change_key_case($pasienByKategori, CASE_LOWER);

        $totalMahasiswa = $pasienByKategori['mahasiswa'] ?? 0;
        $totalDosen     = $pasienByKategori['dosen'] ?? 0;
        $totalKaryawan  = $pasienByKategori['karyawan'] ?? 0;

        // Hitung kategori lainnya yang tidak termasuk dalam 3 kategori utama
        $totalLainnyaKategori = 0;
        foreach ($pasienByKategori as $kategori => $count) {
            if (! in_array($kategori, ['mahasiswa', 'dosen', 'karyawan'])) {
                $totalLainnyaKategori += $count;
            }
        }

                                       // 5. Tentukan View berdasarkan role dari position
        $role  = auth()->user()->role; // Uses getRoleAttribute() from User model

        $statusHariIni = Pasien::select('status', DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', today()) // ✅ lebih clean
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        // Mapping biar aman
        $totalMenungguKonfirmasi = $statusHariIni['menunggu_konfirmasi'] ?? 0;
        $totalTerdaftar          = $statusHariIni['terdaftar'] ?? 0;
        $totalDiperiksa          = $statusHariIni['diperiksa'] ?? 0;
        $totalMenungguObat       = $statusHariIni['menunggu_obat'] ?? 0;
        $totalSelesai            = $statusHariIni['selesai'] ?? 0;

        // 🔥 Pasien Aktif Hari Ini (selain status selesai)
        $pasienAktif = Pasien::whereDate('created_at', today())
            ->where('status', '!=', 'selesai')
            ->count();

        // 🔥 Hari ini
        $pasienAktifHariIni = Pasien::whereDate('created_at', today())
            ->where('status', '!=', 'selesai')
            ->count();

        // 🔥 Kemarin
        $pasienAktifKemarin = Pasien::whereDate('created_at', today()->subDay())
            ->where('status', '!=', 'selesai')
            ->count();

        // 🔥 Hitung persentase
        $persenPerubahan = 0;

        if ($pasienAktifKemarin > 0) {
            $persenPerubahan = (($pasienAktifHariIni - $pasienAktifKemarin) / $pasienAktifKemarin) * 100;
        }

        $kunjunganHarian = RekamMedis::select(
            DB::raw('DATE(tanggal_periksa) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
            ->where('tanggal_periksa', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $kunjunganMingguan = RekamMedis::select(
            DB::raw('YEARWEEK(tanggal_periksa) as minggu'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('minggu')
            ->orderBy('minggu')
            ->limit(8)
            ->get();

        $kunjunganBulanan = RekamMedis::select(
            DB::raw('DATE_FORMAT(tanggal_periksa, "%Y-%m") as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->limit(12)
            ->get();

        $rataWaktu = Pasien::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->get()
            ->map(function ($p) {
                return Carbon::parse($p->created_at)
                    ->diffInMinutes($p->updated_at);
            });

        $rataRataWaktu = $rataWaktu->count() > 0
            ? round($rataWaktu->avg())
            : 0;

        // 🔥 Ambil aktivitas terbaru per status (hari ini)
        $aktivitas = Pasien::with('identity')
            ->whereDate('created_at', today())
            ->latest()
            ->take(10) // ambil 10 terbaru saja
            ->get();

        // ===============================
        // 🔥 KUNJUNGAN HARI INI VS KEMARIN
        // ===============================
        $kunjunganHariIni = RekamMedis::whereDate('tanggal_periksa', today())->count();
        $kunjunganKemarin = RekamMedis::whereDate('tanggal_periksa', today()->subDay())->count();

        $persenKunjungan = 0;
        if ($kunjunganKemarin > 0) {
            $persenKunjungan = (($kunjunganHariIni - $kunjunganKemarin) / $kunjunganKemarin) * 100;
        }

        // ===============================
        // 🔥 RATA-RATA WAKTU HARI INI
        // ===============================
        $rataHariIni = Pasien::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->get()
            ->map(fn($p) => Carbon::parse($p->created_at)->diffInMinutes($p->updated_at));

        // ===============================
        // 🔥 RATA-RATA WAKTU KEMARIN
        // ===============================
        $rataKemarin = Pasien::whereDate('created_at', today()->subDay())
            ->where('status', 'selesai')
            ->get()
            ->map(fn($p) => Carbon::parse($p->created_at)->diffInMinutes($p->updated_at));

        $rataRataHariIni = $rataHariIni->count() ? round($rataHariIni->avg()) : 0;
        $rataRataKemarin = $rataKemarin->count() ? round($rataKemarin->avg()) : 0;

        // ===============================
        // 🔥 PERSEN PERUBAHAN WAKTU
        // ===============================
        $persenWaktu = 0;
        if ($rataRataKemarin > 0) {
            $persenWaktu = (($rataRataHariIni - $rataRataKemarin) / $rataRataKemarin) * 100;
        }

        // 🔥 WAJIB ADA INI
        $obatMenipis = Obat::where('stok', '<=', 20)
            ->orderBy('stok', 'asc')
            ->get();

        // Pastikan view tersedia di folder: resources/views/{role}/dashboard/index.blade.php
        return view('.dashboard.index', compact(
            'rekamMedisData',
            'totalPasien',
            'pasienBaruBulanIni',
            'jumlahKunjunganHariIni',
            'totalMahasiswa',
            'totalDosen',
            'totalKaryawan',
            'totalLainnyaKategori',
            'totalMenungguKonfirmasi',
            'totalTerdaftar',
            'totalDiperiksa',
            'totalMenungguObat',
            'totalSelesai',
            'pasienAktif',
            'pasienAktifHariIni',
            'persenPerubahan',
            'kunjunganHarian',
            'kunjunganMingguan',
            'kunjunganBulanan',
            'rataRataWaktu',
            'aktivitas',
            'kunjunganHariIni',
            'persenKunjungan',
            'rataRataHariIni',
            'persenWaktu',
            'obatMenipis',
        ));
    }

    
}
