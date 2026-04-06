<?php

namespace App\Http\Controllers;

use App\Models\MasterIdentity;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Mail\NotifikasiAntrian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PasienController extends Controller
{

    public function index(Request $request)
    {
        $search      = $request->search;
        $start       = $request->start_date;
        $end         = $request->end_date;
        $poli        = $request->poli;
        $status      = $request->status;
        $lihatSemua  = $request->lihat_semua;

        // Ambil data pasien dengan relasi identity
        $data = Pasien::with('identity')
            // 🔍 FILTER SEARCH
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_pasien', 'like', "%{$search}%")
                    ->orWhereHas('identity', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('identity_number', 'like', "%{$search}%");
                    });
                });
            })
            // 📅 FILTER TANGGAL
            ->when(!$lihatSemua, function ($query) {
                $query->whereDate('visit_date', now());
            })

            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('visit_date', [$start, $end]);
            })

            ->when($start && !$end, function ($query) use ($start) {
                $query->whereDate('visit_date', '>=', $start);
            })

            ->when(!$start && $end, function ($query) use ($end) {
                $query->whereDate('visit_date', '<=', $end);
            })

            // 📌 FILTER STATUS
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            // 🔽 SORT DESC berdasarkan tanggal kunjungan
            ->orderBy('visit_date', 'desc')
            // 📄 PAGINATION
            ->paginate(10)
            ->withQueryString();

        return view('pasien.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identity_number' => 'required|digits:16',
            'nama_pasien'     => 'required|string|max:255',
            'tanggal_lahir'   => 'required|date',
            'no_telp'         => 'required|string|max:20',
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan,karyawan_buma',
            'gender'          => 'required|in:L,P',
            'alamat'          => 'required|string',
            'poli'            => 'required|exists:poli,id',
        ]);

        // 🔎 Cek identity
        $identity = MasterIdentity::where('identity_number', $request->identity_number)->first();

        if (!$identity) {
            return back()->with('error', 'NIK tidak terdaftar sebagai civitas AMIKOM.');
        }

        // 🔢 Generate kode pasien
        $lastPasien = Pasien::orderBy('id', 'desc')->first();

        $newNumber = ($lastPasien && $lastPasien->kode_pasien)
            ? (int) substr($lastPasien->kode_pasien, 1) + 1
            : 1;

        $kodePasien = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // ⏰ Setup
        $now        = Carbon::now();
        $durasi     = 15;
        $jamBuka    = 8;
        $jamTutup   = 15;

        /**
         * 🎯 Tentukan tanggal awal
         */
        if ($now->hour >= $jamTutup) {
            $tanggalKunjungan = Carbon::tomorrow();
        } else {
            $tanggalKunjungan = Carbon::today();
        }

        $foundSlot = null;

        /**
         * 🔁 Cari slot kosong (maks 7 hari ke depan biar aman)
         */
        for ($i = 0; $i < 7; $i++) {

            $tanggal = $tanggalKunjungan->copy()->addDays($i);

            $start = $tanggal->copy()->setTime($jamBuka, 0);
            $end   = $tanggal->copy()->setTime($jamTutup, 0);

            // Ambil semua jam yang sudah terisi
            $booked = Pasien::whereDate('visit_date', $tanggal)
                ->where('poli', $request->poli)
                ->pluck('estimasi_jam')
                ->map(fn($item) => Carbon::parse($item)->format('H:i'))
                ->toArray();

            // Tentukan mulai dari sekarang (kalau hari ini)
            $currentTime = $tanggal->isToday()
                ? max($now, $start)
                : $start;

            // Bulatkan ke slot 15 menit
            $menit = $currentTime->minute;
            $sisa  = ($durasi - ($menit % $durasi)) % $durasi;

            $slot = $currentTime->copy()->addMinutes($sisa)->second(0);

            // Loop slot per 15 menit
            while ($slot < $end) {

                if (!in_array($slot->format('H:i'), $booked)) {
                    $foundSlot = $slot;
                    $tanggalKunjungan = $tanggal;
                    break 2; // keluar dari 2 loop
                }

                $slot->addMinutes($durasi);
            }
        }

        /**
         * ❌ Kalau tidak dapat slot
         */
        if (!$foundSlot) {
            return back()->with('error', 'Antrian penuh untuk beberapa hari ke depan.');
        }

        $estimasiJam = $foundSlot;

        /**
         * 🔢 Generate nomor antrian
         */
        $prefix = $request->poli == 1 ? 'PU' : 'PG';

        $jumlah = Pasien::whereDate('visit_date', $tanggalKunjungan)
            ->where('poli', $request->poli)
            ->count() + 1;

        $noAntrian = $prefix . '-' . str_pad($jumlah, 3, '0', STR_PAD_LEFT);

        /**
         * 💾 Simpan
         */
        $pasien = Pasien::create([
            'identity_id'  => $identity->id,
            'kode_pasien'  => $kodePasien,
            'poli'         => $request->poli,
            'queue_number' => $noAntrian,
            'estimasi_jam' => $estimasiJam,
            'visit_date'   => $tanggalKunjungan,
            'status'       => 'menunggu_konfirmasi',
        ]);

        /**
         * 📧 Email
         */
        if ($identity->email) {
            Mail::to($identity->email)->send(new NotifikasiAntrian($pasien));
        }

        $pasien->load('identity');

        /**
         * 🔐 Redirect
         */
        if (auth()->check()) {
            $role = auth()->user()->role;

            return redirect()
                ->route($role . '.pasien.index')
                ->with('success', 'Pasien berhasil ditambahkan.');
        }

        return redirect()
            ->route('pasien.form')
            ->with('success', 'Pendaftaran berhasil')
            ->with('pasien_id', $pasien->id);
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);

        $pasien->delete(); // karena pakai SoftDeletes

        $role = auth()->user()->role;

        return redirect()
            ->route($role . '.pasien.index')
            ->with('success', 'Pasien berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'identity_number' => 'required|digits:16',
            'nama_pasien'     => 'required|string|max:255',
            'tanggal_lahir'   => 'required|date',
            'no_telp'         => 'required|string|max:20',
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan,karyawan_buma',
            'gender'          => 'required|in:L,P',
            'alamat'          => 'required|string',
            'poli'            => 'required|exists:poli,id',
            'status'          => 'required',
        ]);

        $pasien = Pasien::with('identity')->findOrFail($id);

        if (! $pasien->identity) {
            return back()->with('error', 'Identity tidak ditemukan.');
        }

        // ✅ Update identity lengkap
        $pasien->identity->update([
            'identity_number' => $request->identity_number,
            'name'            => $request->nama_pasien,
            'birth_date'      => $request->tanggal_lahir,
            'no_telp'         => $request->no_telp,
            'identity_type'   => $request->identity_type,
            'gender'          => $request->gender,
            'address'         => $request->alamat,
        ]);

        // ✅ Update pasien
        $pasien->update([
            'poli'   => $request->poli,
            'status' => $request->status,
        ]);

        $role = auth()->user()->role;

        return redirect()
            ->route($role . '.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    // 🔍 API cek NIK
    public function cekNik($nik)
    {
        $identity = MasterIdentity::where('identity_number', $nik)->first();

        if (! $identity) {
            return response()->json([
                'status' => false,
            ]);
        }

        return response()->json([
            'status' => true,
            'data'   => $identity,
        ]);
    }

    public function downloadPDF($id)
    {
        $pasien = Pasien::with('identity')->findOrFail($id);

        $pdf = Pdf::loadView('profile.bukti-pendaftaran-pdf', compact('pasien'));

        return $pdf->download(
            'bukti-pendaftaran-' . $pasien->kode_pasien . '.pdf'
        );
    }

    public function form()
    {
        $pasien = session('pasien_id')
            ? \App\Models\Pasien::with('identity')->find(session('pasien_id'))
            : null;

        return view('profile.basic-details', compact('pasien'));
    }

    public function show($id)
    {
        $pasien = Pasien::with('identity')->findOrFail($id);

        $role = auth()->user()->role;

        return view('pasien.show', compact('pasien', 'role'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        // ❌ Cegah jika sudah dikonfirmasi
        if ($pasien->status !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Pasien sudah dikonfirmasi.');
        }

        DB::transaction(function () use ($pasien, $request) {

            // 🔄 Ubah status pasien
            $pasien->update([
                'status'        => 'terdaftar',
                'tensi'         => $request->tensi,
                'berat_badan'   => $request->berat_badan,
                'tinggi_badan'  => $request->tinggi_badan,
                'keluhan'       => $request->keluhan,
            ]);

            // 🔢 Generate kode rekam medis
            $lastRekam = RekamMedis::withTrashed()
                ->orderBy('id', 'desc')
                ->first();

            $newNumber = $lastRekam
                ? (int) substr($lastRekam->kode_rekam_medis, 2) + 1
                : 1;

            $kodeRekam = 'RM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            // 💾 Insert ke rekam medis
            RekamMedis::create([
                'kode_rekam_medis' => $kodeRekam,
                'pasien_id'        => $pasien->id,
                'dokter_id'        => 1, // sementara default (nanti bisa dinamis)
                'tanggal_periksa'  => Carbon::today(),
                'diagnosis'        => '-',
                'status'           => 'menunggu_pemeriksaan',
            ]);
        });

        $role = auth()->user()->role;

        return redirect()
            ->route($role . '.pasien.index')
            ->with('success', 'Pasien berhasil dikonfirmasi dan masuk ke rekam medis.');
    }
}
