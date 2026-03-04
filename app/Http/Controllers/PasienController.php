<?php
namespace App\Http\Controllers;

use App\Models\MasterIdentity;
use App\Mail\NotifikasiAntrian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Pasien;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PasienController extends Controller
{

    public function index()
    {
        $data = Pasien::with('identity')->get();

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

        // 🔎 Cek apakah identity sudah ada
        $identity = MasterIdentity::where('identity_number', $request->identity_number)->first();

        // 🆕 Jika belum ada → buat baru
        if (! $identity) {
            $identity = MasterIdentity::create([
                'identity_number' => $request->identity_number,
                'name'            => $request->nama_pasien,
                'birth_date'      => $request->tanggal_lahir,
                'no_telp'         => $request->no_telp,
                'identity_type'   => $request->identity_type,
                'gender'          => $request->gender,
                'address'         => $request->alamat,
            ]);
        }

        // 🔢 Generate kode pasien otomatis
        $lastPasien = Pasien::with('identity')
            ->orderBy('id', 'desc')
            ->first();

        $newNumber = $lastPasien
            ? (int) substr($lastPasien->kode_pasien, 1) + 1
            : 1;

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
            ->route('admin.pasien.index')
            ->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);

        $pasien->delete(); // karena pakai SoftDeletes

        return redirect()
            ->route('admin.pasien.index')
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

        return redirect()
            ->route('admin.pasien.index')
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

        $linkWA = $pasien
            ? 'https://wa.me/62xxxx?text=Nomor%20Antrian%20' . $pasien->kode_pasien
            : null;

        return view('profile.basic-details', compact('pasien', 'linkWA'));
    }

}
