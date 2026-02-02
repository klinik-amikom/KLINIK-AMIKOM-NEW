<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RekamMedis;
use App\Models\User;
use App\Models\Obat;
use App\Models\Pasien;

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

        // Normalisasi nama key kategori (mengubah ke lowercase untuk konsistensi pengecekan)
        $pasienByKategori = array_change_key_case($pasienByKategori, CASE_LOWER);

        $totalMahasiswa = $pasienByKategori['mahasiswa'] ?? 0;
        $totalDosen = $pasienByKategori['dosen'] ?? 0;
        $totalKaryawan = $pasienByKategori['karyawan'] ?? 0;

        // Hitung kategori lainnya yang tidak termasuk dalam 3 kategori utama
        $totalLainnyaKategori = 0;
        foreach ($pasienByKategori as $kategori => $count) {
            if (!in_array($kategori, ['mahasiswa', 'dosen', 'karyawan'])) {
                $totalLainnyaKategori += $count;
            }
        }

        // 5. Tentukan View berdasarkan role dari position
        $role = auth()->user()->role; // Uses getRoleAttribute() from User model 

        // Pastikan view tersedia di folder: resources/views/{role}/dashboard/index.blade.php
        return view('.dashboard.index', compact(
            'rekamMedisData',
            'totalDokterAktif',
            'dokterBaruBulanIni',
            'totalAdmin',
            'totalJenisObat',
            'jumlahKunjunganHariIni',
            'totalMahasiswa',
            'totalDosen',
            'totalKaryawan',
            'totalLainnyaKategori'
        ));
    }
}