<?php
namespace App\Http\Controllers;

use App\Models\MasterIdentity;
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

        // 🔢 Generate kode pasien
        $lastPasien = Pasien::withTrashed()->orderBy('id', 'desc')->first();

        $newNumber = $lastPasien
            ? (int) substr($lastPasien->kode_pasien, 1) + 1
            : 1;

        $kodePasien = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // 💾 Simpan pasien
        $pasien = Pasien::create([
            'identity_id' => $identity->id,
            'kode_pasien' => $kodePasien,
            'poli'        => $request->poli,
            'status'      => 'menunggu_konfirmasi',
        ]);

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
}
