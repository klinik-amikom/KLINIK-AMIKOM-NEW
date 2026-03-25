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
        $search = $request->search;

        $data = Pasien::with('identity')
            ->when($search, function ($query) use ($search) {
                $query->where('kode_pasien', 'like', "%$search%")
                    ->orWhereHas('identity', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('identity_number', 'like', "%$search%");
                    });
            })
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
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan',
            'gender'          => 'required|in:L,P',
            'alamat'          => 'required|string',
            'poli'            => 'required|in:Poli Umum,Poli Gigi',
        ]);

        // 🔎 Cek identity
        $identity = MasterIdentity::where('identity_number', $request->identity_number)->first();

        if (!$identity) {
            return back()->with('error', 'NIK tidak terdaftar sebagai civitas AMIKOM.');
        }

        // 🔢 Generate kode pasien
        $lastPasien = Pasien::orderBy('id','desc')->first();

        $newNumber = ($lastPasien && $lastPasien->kode_pasien)
            ? (int) substr($lastPasien->kode_pasien,1) + 1
            : 1;

        $kodePasien = 'P' . str_pad($newNumber,3,'0',STR_PAD_LEFT);

        // 🔢 Tentukan tanggal kunjungan (default hari ini)
        $tanggalKunjungan = Carbon::today();

        // ⏰ Jam operasional
        $jamBuka  = Carbon::parse($tanggalKunjungan)->setTime(8, 0);
        $jamTutup = Carbon::parse($tanggalKunjungan)->setTime(15, 0);

        // ⏱ durasi per pasien
        $durasi = 15;

        // 🔎 Ambil pasien terakhir di tanggal tersebut
        $lastPasienHariIni = Pasien::whereDate('visit_date', $tanggalKunjungan)
            ->where('poli', $request->poli) // 🔥 TAMBAHAN PENTING
            ->orderBy('estimasi_jam', 'desc')
            ->first();

        if (!$lastPasienHariIni) {
            // pasien pertama
            $waktuDaftar = now();

            $estimasiJam = $waktuDaftar->lt($jamBuka)
                ? $jamBuka
                : $waktuDaftar;
        } else {
            // pasien berikutnya
            $estimasiJam = Carbon::parse($lastPasienHariIni->estimasi_jam)
                ->addMinutes($durasi);
        }

        // 🔁 Jika melebihi jam operasional → pindah ke besok
        if ($estimasiJam->gt($jamTutup)) {

            $tanggalKunjungan = Carbon::tomorrow();

            $jamBukaBesok = Carbon::parse($tanggalKunjungan)->setTime(8, 0);

            $lastBesok = Pasien::whereDate('visit_date', $tanggalKunjungan)
                ->where('poli', $request->poli) // 🔥 WAJIB
                ->orderBy('estimasi_jam', 'desc')
                ->first();

            if (!$lastBesok) {
                $estimasiJam = $jamBukaBesok;
            } else {
                $estimasiJam = Carbon::parse($lastBesok->estimasi_jam)
                    ->addMinutes($durasi);
            }
        }

        // 🔢 Generate nomor antrian berdasarkan tanggal kunjungan
        $prefix = $request->poli === 'Poli Umum' ? 'PU' : 'PG';

        $jumlah = Pasien::whereDate('visit_date', $tanggalKunjungan)
            ->where('poli', $request->poli)
            ->count() + 1;

        $noAntrian = $prefix . '-' . str_pad($jumlah,3,'0',STR_PAD_LEFT);

        // 💾 Simpan pasien
        $pasien = Pasien::create([
            'identity_id'        => $identity->id,
            'kode_pasien'        => $kodePasien,
            'poli'               => $request->poli,
            'queue_number'       => $noAntrian,
            'estimasi_jam'       => $estimasiJam,
            'visit_date'         => $tanggalKunjungan,
            'status'             => 'menunggu_konfirmasi',
        ]);

        // 📧 Email
        if ($identity->email) {
            Mail::to($identity->email)->send(new NotifikasiAntrian($pasien));
        }

        $pasien->load('identity');

        // 🔐 Admin
        if (auth()->check()) {
            $role = auth()->user()->role;

            return redirect()
                ->route($role . '.pasien.index')
                ->with('success','Pasien berhasil ditambahkan.');
        }

        // 🌐 Publik
        return redirect()
            ->route('pasien.form')
            ->with('success','Pendaftaran berhasil')
            ->with('pasien_id',$pasien->id);
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
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan',
            'gender'          => 'required|in:L,P',
            'alamat'          => 'required|string',
            'poli'            => 'required|in:Poli Umum,Poli Gigi',
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

    public function konfirmasi($id)
    {
        $pasien = Pasien::findOrFail($id);

        // ❌ Cegah jika sudah dikonfirmasi
        if ($pasien->status !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Pasien sudah dikonfirmasi.');
        }

        DB::transaction(function () use ($pasien) {

            // 🔄 Ubah status pasien
            $pasien->update([
                'status' => 'terdaftar',
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