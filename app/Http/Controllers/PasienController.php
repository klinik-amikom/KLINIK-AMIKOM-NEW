<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\MasterIdentity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Exception;

class PasienController extends Controller
{
    /**
     * Helper untuk menentukan path view berdasarkan role user.
     */
    /**
     * Helper untuk menentukan path view berdasarkan role user.
     */
    private function getViewPath($viewName)
    {
        // Cukup arahkan ke folder pasien
        return 'pasien.' . $viewName;
    }

    /**
     * Helper untuk redirect kembali ke index sesuai role.
     */
    private function redirectIndex()
    {
        $user = auth()->user();
        
        // Pastikan kolom ini sesuai dengan database (role / level)
        $role = $user->role ?? $user->level; 

        if (!$role) {
            return redirect()->route('login'); // Keamanan jika session hilang
        }

        return redirect()->route($role . '.pasien.index');
    }

    /**
     * AJAX Endpoint untuk auto-fill data identitas
     */
    public function getIdentity($number)
    {
        $identity = MasterIdentity::where('identity_number', $number)->first();
        return response()->json($identity);
    }

    public function index()
    {
        // Menggunakan with('identity') untuk menghindari N+1 query problem
        $data = Pasien::with('identity')->latest()->get();
        return view($this->getViewPath('index'), compact('data'));
    }

    public function show($id)
    {
        $pasien = Pasien::with('identity')->findOrFail($id);
        return view($this->getViewPath('show'), compact('pasien'));
    }

    public function downloadPDF($id)
    {
        $pasien = Pasien::with('identity')->findOrFail($id);
        $pdf = Pdf::loadView('profile.bukti-pendaftaran-pdf', compact('pasien'));
        return $pdf->download('bukti-pendaftaran-' . $pasien->kode_pasien . '.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'identity_number' => 'required|string|max:20',
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan',
            'nama_pasien'     => 'required|string|max:100',
            'gender'          => 'required|in:L,P',
            'alamat'          => 'required|string',
            'poli'            => 'required|in:Poli Umum,Poli Gigi',
            // no_telp tidak ada di skema master_identity Anda, 
            // jika ingin disimpan, sebaiknya tambahkan kolom di master_identity.
        ]);

        try {
            DB::beginTransaction();

            // 1. Logika Update atau Create Master Identity
            $identity = MasterIdentity::updateOrCreate(
                ['identity_number' => $request->identity_number],
                [
                    'identity_type' => $request->identity_type,
                    'name'          => $request->nama_pasien,
                    'gender'        => $request->gender,
                    'address'       => $request->alamat,
                ]
            );

            // 2. Generate kode pasien otomatis
            $lastKode = Pasien::selectRaw('MAX(CAST(SUBSTRING(kode_pasien, 2) AS UNSIGNED)) AS max_kode')
                        ->first()->max_kode;
            $newPasienNumber = $lastKode ? $lastKode + 1 : 1;
            $newKodePasien   = 'P' . str_pad($newPasienNumber, 3, '0', STR_PAD_LEFT);

            // 3. Simpan data Pasien
            $pasien = Pasien::create([
                'identity_id' => $identity->id,
                'kode_pasien' => $newKodePasien,
                'poli'        => $request->poli,
                'status'      => 'menunggu_konfirmasi',
            ]);

            DB::commit();

            if (auth()->check()) {
                return $this->redirectIndex()->with('success', 'Data pasien berhasil ditambahkan!');
            }

            // Integrasi WA (Opsional)
            $pesan = "Halo *{$identity->name}*, pendaftaran berhasil!\n📌 *Kode:* {$pasien->kode_pasien}\n🏥 *Poli:* {$pasien->poli}";
            $linkWA = 'https://wa.me/628xxx?text=' . urlencode($pesan);

            return view('profile.basic-details', compact('pasien', 'linkWA'));

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // PasienController.php - Bagian Update
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'nama_pasien'   => 'required|string|max:100',
            'identity_type' => 'required|in:mahasiswa,dosen,karyawan',
            'gender'        => 'required|in:L,P',
            'alamat'        => 'required|string',
            'poli'          => 'required|in:Poli Umum,Poli Gigi',
            'status'        => 'required|in:menunggu_konfirmasi,terdaftar,selesai',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update data Identitas (Master Data)
            $pasien->identity->update([
                'name'          => $request->nama_pasien,
                'identity_type' => $request->identity_type,
                'gender'        => $request->gender,
                'address'       => $request->alamat,
            ]);

            // 2. Update data Pasien (Transaksi/Pendaftaran)
            $pasien->update([
                'poli'   => $request->poli,
                'status' => $request->status,
            ]);

            DB::commit();
            return $this->redirectIndex()->with('success', 'Data pasien berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete(); // Ini akan memicu SoftDeletes jika aktif di model

        return $this->redirectIndex()->with('success', 'Data pasien berhasil dihapus!');
    }
}