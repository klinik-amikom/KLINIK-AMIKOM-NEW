<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pasien;
use App\Models\MasterIdentity;
use App\Mail\NotifikasiAntrian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nik'  => 'required|digits:16',
            'poli' => 'required|in:Poli Umum,Poli Gigi',
        ]);

        // 🔎 Cari identity berdasarkan NIK
        $identity = MasterIdentity::where('identity_number', $request->nik)->first();

        if (!$identity) {
            return back()->with('error', 'NIK tidak ditemukan.');
        }

        // 🔢 Generate kode pasien otomatis
        $lastPasien = Pasien::with('identity')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastPasien) {
            $lastNumber = (int) substr($lastPasien->kode_pasien, 1);
            $newNumber  = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $kodePasien = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Tentukan prefix berdasarkan poli
        $prefix = $request->poli === 'Poli Umum' ? 'PU' : 'PG';

        // Hitung jumlah pasien hari ini berdasarkan poli
        $jumlahHariIni = Pasien::whereDate('created_at', today())
            ->where('poli', $request->poli)
            ->count() + 1;

        // Format nomor antrian (3 digit)
        $noAntrian = $prefix . '-' . str_pad($jumlahHariIni, 3, '0', STR_PAD_LEFT);

        // 💾 Simpan ke database
        $pasien = Pasien::create([
            'identity_id' => $identity->id,
            'kode_pasien' => $kodePasien,
            'poli'        => $request->poli,
            'queue_number' => $noAntrian,
            'status'      => 'menunggu_konfirmasi',
        ]);

        Mail::to($identity->email)->send(new NotifikasiAntrian($pasien));

        // Untuk ditampilkan di blade
        $pasien->load('identity');

        return redirect()
            ->route('pasien.form')
            ->with('success', 'Berhasil mendaftar')
            ->with('pasien_id', $pasien->id);

    }

    // 🔍 API cek NIK
    public function cekNik($nik)
    {
        $identity = MasterIdentity::where('nik', $nik)->first();

        if (!$identity) {
            return response()->json([
                'status' => false
            ]);
        }

        return response()->json([
            'status' => true,
            'data'   => $identity
        ]);
    }

    public function downloadPDF($id)
    {
        $pasien = Pasien::with('identity')->findOrFail($id);

        $pdf = Pdf::loadView('profile.bukti-pendaftaran-pdf', compact('pasien'));

        return $pdf->download(
            'bukti-pendaftaran-' . $pasien->kode_pasien . '.pdf');
    }

    public function form()
    {
        $pasien = session('pasien_id')
            ? \App\Models\Pasien::with('identity')->find(session('pasien_id'))
            : null;

        $linkWA = $pasien
            ? 'https://wa.me/62xxxx?text=Nomor%20Antrian%20' . $pasien->kode_pasien
            : null;

        return view('profile.basic-details', compact('pasien', 'linkWA'));
    }

}