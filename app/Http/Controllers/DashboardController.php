<?php
namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Obat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama sesuai dengan role user yang login.
     */
    public function index(Request $request)
    {
        // ===============================
        // 🔥 FILTER STATUS (TAMBAHAN)
        // ===============================
        $statusFilter = $request->status;

        // 1. Ambil data rekam medis untuk chart kunjungan (1 tahun terakhir)
        $rekamMedisQuery = RekamMedis::where('tanggal_periksa', '>=', now()->subYear());

        if ($statusFilter && $statusFilter != 'menunggu_konfirmasi') {
            $rekamMedisQuery->whereHas('pasien', function ($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            });
        }

        $rekamMedisData = $rekamMedisQuery
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        // ===============================
        // 🔥 KHUSUS MENUNGGU KONFIRMASI (DARI PASIEN)
        // ===============================
        if (in_array($statusFilter, ['menunggu_konfirmasi', 'terdaftar'])) {
            $dataPasien = Pasien::where('status', $statusFilter)->get();

            return view('pasien.index', compact('dataPasien'));
        }

        // Total pasien (unique dari rekam medis)
        $totalPasien = RekamMedis::distinct('pasien_id')->count('pasien_id');

        // Pasien baru bulan ini
        $pasienBaruBulanIni = RekamMedis::whereYear('tanggal_periksa', now()->year)
            ->whereMonth('tanggal_periksa', now()->month)
            ->distinct('pasien_id')
            ->count('pasien_id');

        // Statistik Kunjungan Hari Ini
        $jumlahKunjunganHariIni = RekamMedis::whereDate('tanggal_periksa', now()->toDateString())->count();

        // Statistik kategori pasien
        $pasienByKategori = RekamMedis::join('pasien_periksa', 'rekam_medis.pasien_id', '=', 'pasien_periksa.id')
            ->join('master_identity', 'pasien_periksa.identity_id', '=', 'master_identity.id')
            ->select('master_identity.identity_type', DB::raw('COUNT(DISTINCT pasien_periksa.id) as total'))
            ->groupBy('master_identity.identity_type')
            ->pluck('total', 'identity_type')
            ->toArray();

        $pasienByKategori = array_change_key_case($pasienByKategori, CASE_LOWER);

        $totalMahasiswa = $pasienByKategori['mahasiswa'] ?? 0;
        $totalDosen     = $pasienByKategori['dosen'] ?? 0;
        $totalKaryawan  = $pasienByKategori['karyawan'] ?? 0;
        $totalKaryawanBuma  = $pasienByKategori['karyawan_buma'] ?? 0;

        $totalLainnyaKategori = 0;
        foreach ($pasienByKategori as $kategori => $count) {
            if (! in_array($kategori, ['mahasiswa', 'dosen', 'karyawan', 'karyawan_buma'])) {
                $totalLainnyaKategori += $count;
            }
        }

        $role  = auth()->user()->role;

        $statusHariIni = Pasien::select('status', DB::raw('COUNT(*) as total'))
            ->whereDate('updated_at', today())
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalMenungguKonfirmasi    = $statusHariIni['menunggu_konfirmasi'] ?? 0;
        $totalMenungguPemeriksaan   = $statusHariIni['menunggu_pemeriksaan'] ?? 0;
        $totalTerdaftar             = $statusHariIni['terdaftar'] ?? 0;
        $totalDiperiksa             = $statusHariIni['diperiksa'] ?? 0;
        $totalMenungguObat          = $statusHariIni['menunggu_obat'] ?? 0;
        $totalSelesai               = $statusHariIni['selesai'] ?? 0;

        $pasienAktif = Pasien::whereDate('created_at', today())
            ->where('status', '!=', 'selesai')
            ->count();

        $pasienAktifHariIni = Pasien::whereDate('created_at', today())
            ->where('status', '!=', 'selesai')
            ->count();

        $pasienAktifKemarin = Pasien::whereDate('created_at', today()->subDay())
            ->where('status', '!=', 'selesai')
            ->count();

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

        $aktivitas = Pasien::with('identity')
            ->whereDate('created_at', today())
            ->latest()
            ->take(10)
            ->get();

        $kunjunganHariIni = RekamMedis::whereDate('tanggal_periksa', today())->count();
        $kunjunganKemarin = RekamMedis::whereDate('tanggal_periksa', today()->subDay())->count();

        $persenKunjungan = 0;
        if ($kunjunganKemarin > 0) {
            $persenKunjungan = (($kunjunganHariIni - $kunjunganKemarin) / $kunjunganKemarin) * 100;
        }

        $rataHariIni = Pasien::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->get()
            ->map(fn($p) => Carbon::parse($p->created_at)->diffInMinutes($p->updated_at));

        $rataKemarin = Pasien::whereDate('created_at', today()->subDay())
            ->where('status', 'selesai')
            ->get()
            ->map(fn($p) => Carbon::parse($p->created_at)->diffInMinutes($p->updated_at));

        $rataRataHariIni = $rataHariIni->count() ? round($rataHariIni->avg()) : 0;
        $rataRataKemarin = $rataKemarin->count() ? round($rataKemarin->avg()) : 0;

        $persenWaktu = 0;
        if ($rataRataKemarin > 0) {
            $persenWaktu = (($rataRataHariIni - $rataRataKemarin) / $rataRataKemarin) * 100;
        }

        $obatMenipis = Obat::where('stok', '<=', 20)
            ->orderBy('stok', 'asc')
            ->get();

        return view('.dashboard.index', compact(
            'rekamMedisData',
            'totalPasien',
            'pasienBaruBulanIni',
            'jumlahKunjunganHariIni',
            'totalMahasiswa',
            'totalDosen',
            'totalKaryawan',
            'totalKaryawanBuma',
            'totalLainnyaKategori',
            'totalMenungguKonfirmasi',
            'totalMenungguPemeriksaan',
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