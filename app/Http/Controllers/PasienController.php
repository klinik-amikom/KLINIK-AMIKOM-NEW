<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    /**
     * Helper untuk menentukan path view berdasarkan role user.
     */
    private function getViewPath($viewName)
    {
        $role = auth()->user()->level; 
        return '.pasien.' . $viewName;
    }

    /**
     * Helper untuk redirect kembali ke index sesuai role.
     */
    private function redirectIndex()
    {
        $role = auth()->user()->level;
        return redirect()->route($role . '.pasien.index');
    }

    public function index()
    {
        $data = Pasien::all();
        return view($this->getViewPath('index'), compact('data'));
    }

    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view($this->getViewPath('show'), compact('pasien'));
    }

    public function downloadPDF($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pdf = Pdf::loadView('profile.bukti-pendaftaran-pdf', compact('pasien'));
        return $pdf->download('bukti-pendaftaran-' . $pasien->kode_pasien . '.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'   => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kel'     => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'required|string|max:500',
            'no_telp'       => 'required|string|max:20',
            'poli'          => 'required|in:Poli Umum,Poli Gigi',
            'kategori'      => 'required|in:Mahasiswa,Dosen,Karyawan',
        ]);

        // Generate kode pasien otomatis (Logika paling akurat)
        $lastKode = Pasien::selectRaw('MAX(CAST(SUBSTRING(kode_pasien, 2) AS UNSIGNED)) AS max_kode')->first()->max_kode;
        $newPasienNumber = $lastKode ? $lastKode + 1 : 1;
        $newKodePasien   = 'P' . str_pad($newPasienNumber, 3, '0', STR_PAD_LEFT);

        $pasien = Pasien::create([
            'kode_pasien'   => $newKodePasien,
            'nama_pasien'   => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kel'     => $request->jenis_kel,
            'alamat'        => $request->alamat,
            'no_telp'       => $request->no_telp,
            'poli'          => $request->poli,
            'kategori'      => $request->kategori,
            'status'        => 'terdaftar',
        ]);

        // Jika pendaftaran dilakukan oleh Publik (Tidak Login) atau Admin
        // Format pesan WhatsApp
        $pesan = "Halo *{$pasien->nama_pasien}*, pendaftaran Anda berhasil!\n\n" .
                 "📌 *Kode Pasien:* {$pasien->kode_pasien}\n" .
                 "🏥 *Poli:* {$pasien->poli}\n" .
                 "📅 *Tanggal Lahir:* {$pasien->tanggal_lahir}\n" .
                 "☎️ *No. Telp:* {$pasien->no_telp}\n\n" .
                 "Silakan datang ke klinik sesuai nomor antrian Anda. Terima kasih 🙏";

        $nomorWA = preg_replace('/^0/', '62', $pasien->no_telp);
        $linkWA = 'https://wa.me/' . $nomorWA . '?text=' . urlencode($pesan);

        // Jika user login, kembali ke index role masing-masing
        if (auth()->check()) {
            return $this->redirectIndex()->with('success', 'Data pasien berhasil ditambahkan!');
        }

        // Jika publik yang daftar (dari landing page), tampilkan halaman sukses & tombol WA
        return view('profile.basic-details', [
            'pasien' => $pasien,
            'linkWA' => $linkWA,
        ]);
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'nama_pasien'   => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kel'     => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'required|string|max:500',
            'no_telp'       => 'required|string|max:20',
            'poli'          => 'required|in:Poli Umum,Poli Gigi',
            'kategori'      => 'required|in:Mahasiswa,Dosen,Karyawan',
        ]);

        $pasien->update([
            'nama_pasien'   => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kel'     => $request->jenis_kel,
            'alamat'        => $request->alamat,
            'no_telp'       => $request->no_telp,
            'poli'          => $request->poli,
            'kategori'      => $request->kategori,
        ]);

        return $this->redirectIndex()->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return $this->redirectIndex()->with('success', 'Data pasien berhasil dihapus!');
    }
}