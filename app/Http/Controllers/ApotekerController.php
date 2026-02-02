<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Obat;
use App\Models\Pasien;

class ApotekerController extends Controller
{
    public function index()
    {
        // 1. Ambil data rekam medis untuk chart kunjungan (1 tahun terakhir)
        $rekamMedisData = RekamMedis::where('tanggal_periksa', '>=', now()->subYear())
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        // 2. Statistik User & Obat
        $totalDokterAktif = User::whereHas('position', function ($q) {
            $q->where('code', 'DOK');
        })->count();

        $totalAdmin = User::whereHas('position', function ($q) {
            $q->where('code', 'ADM');
        })->count();

        $totalJenisObat = Obat::count();

        $dokterBaruBulanIni = User::whereHas('position', function ($q) {
            $q->where('code', 'DOK');
        })
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // 3. Statistik Kunjungan Hari Ini
        $jumlahKunjunganHariIni = RekamMedis::whereDate('tanggal_periksa', today())->count();

        // 4. Statistik Pasien berdasarkan identity_type dari master_identity
        $pasienByKategori = Pasien::join('master_identity', 'pasien.identity_id', '=', 'master_identity.id')
            ->select('master_identity.identity_type', DB::raw('count(*) as total'))
            ->groupBy('master_identity.identity_type')
            ->pluck('total', 'identity_type')
            ->toArray();

        // Normalisasi key menjadi lowercase untuk keamanan pengecekan
        $pasienByKategori = array_change_key_case($pasienByKategori, CASE_LOWER);

        $totalMahasiswa = $pasienByKategori['mahasiswa'] ?? 0;
        $totalDosen = $pasienByKategori['dosen'] ?? 0;
        $totalKaryawan = $pasienByKategori['karyawan'] ?? 0;

        // Hitung kategori lainnya
        $totalLainnyaKategori = 0;
        foreach ($pasienByKategori as $kategori => $count) {
            if (!in_array($kategori, ['mahasiswa', 'dosen', 'karyawan'])) {
                $totalLainnyaKategori += $count;
            }
        }

        // 5. Get list of apoteker users for the table
        $users = User::whereHas('position', function ($q) {
            $q->where('code', 'APT');
        })->with(['position', 'identity'])->get();

        // Return ke view khusus dashboard apoteker
        return view('apoteker.index', compact(
            'rekamMedisData',
            'totalDokterAktif',
            'dokterBaruBulanIni',
            'totalAdmin',
            'totalJenisObat',
            'jumlahKunjunganHariIni',
            'totalMahasiswa',
            'totalDosen',
            'totalKaryawan',
            'totalLainnyaKategori',
            'users'
        ));
    }
}