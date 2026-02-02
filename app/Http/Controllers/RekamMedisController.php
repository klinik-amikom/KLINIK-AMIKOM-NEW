<?php

namespace App\Http\Controllers;

use App\Exports\RekamMedisExport;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekamMedisController extends Controller
{
    /**
     * Helper untuk menentukan prefix folder view berdasarkan role user.
     * Mengasumsikan struktur folder: views/admin/..., views/dokter/..., views/apoteker/...
     */
    private function getViewPath($viewName)
    {
        $role = auth()->user()->role; // Uses getRoleAttribute() from User model
        return $role . '.rekam_medis.' . $viewName;
    }

    /**
     * Helper untuk redirect kembali ke index sesuai role.
     */
    private function redirectIndex()
    {
        $role = auth()->user()->role; // Uses getRoleAttribute() from User model
        return redirect()->route($role . '.rekammedis.index');
    }

    public function index(Request $request)
    {
        $pencarian = $request->query('cari');

        $dataRekamMedis = RekamMedis::with(['pasien', 'user', 'obat'])
            ->when($pencarian, function ($query, $pencarian) {
                $query->where('kode_rekam_medis', 'like', '%' . $pencarian . '%')
                    ->orWhereHas('pasien', function ($q) use ($pencarian) {
                        $q->where('nama_pasien', 'like', '%' . $pencarian . '%');
                    })
                    ->orWhere('diagnosis', 'like', '%' . $pencarian . '%');
            })
            ->get();

        $pasiens = Pasien::all();
        $dokters = User::whereHas('position', function ($q) {
            $q->where('code', 'DOK');
        })->get();
        $obats = Obat::all();

        return view($this->getViewPath('index'), compact(
            'dataRekamMedis',
            'pencarian',
            'pasiens',
            'dokters',
            'obats'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_periksa' => 'required|date',
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:users,id',
            'obat_id' => 'required|exists:obat,id',
            'diagnosis' => 'nullable|string',
            'resep' => 'nullable|string',
            'tgl_ambil_obat' => 'nullable|date',
            'jumlah_obat' => 'nullable|numeric|min:1',
        ]);

        // Generate kode otomatis
        $lastRecord = RekamMedis::latest('id')->first();
        $nextNumber = $lastRecord ? $lastRecord->id + 1 : 1;
        $kodeRekamMedis = 'RM' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        RekamMedis::create([
            'kode_rekam_medis' => $kodeRekamMedis,
            'tanggal_periksa' => $request->tanggal_periksa,
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'diagnosis' => $request->diagnosis,
            'catatan' => $request->resep, // Using catatan field from new schema
            'status' => 'menunggu_pemeriksaan',
        ]);

        // Logic Tambahan dari Controller Dokter: Update status pasien
        $pasien = Pasien::find($request->pasien_id);
        if ($pasien) {
            $pasien->status = 'diperiksa';
            $pasien->save();
        }

        return $this->redirectIndex()->with('success', 'Data rekam medis berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $rekam = RekamMedis::findOrFail($id);

        $request->validate([
            'tanggal_periksa' => 'required|date',
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:users,id',
            'obat_id' => 'required|exists:obat,id',
            'diagnosis' => 'nullable|string',
            'resep' => 'nullable|string',
            'tgl_ambil_obat' => 'nullable|date',
            'jumlah_obat' => 'nullable|numeric|min:1',
        ]);

        $rekam->update([
            'tanggal_periksa' => $request->tanggal_periksa,
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'diagnosis' => $request->diagnosis,
            'catatan' => $request->resep, // Using catatan field from new schema
        ]);

        // Pastikan status pasien terupdate
        $pasien = Pasien::find($request->pasien_id);
        if ($pasien && $pasien->status !== 'diperiksa') {
            $pasien->status = 'diperiksa';
            $pasien->save();
        }

        return $this->redirectIndex()->with('success', 'Data rekam medis berhasil diperbarui!');
    }

    public function show($id)
    {
        $rekam = RekamMedis::with(['pasien', 'user', 'obat'])->findOrFail($id);
        return view($this->getViewPath('show'), compact('rekam'));
    }

    public function destroy($id)
    {
        $rekam = RekamMedis::findOrFail($id);
        $rekam->delete();

        return $this->redirectIndex()->with('success', 'Data rekam medis berhasil dihapus!');
    }

    public function exportPDF()
    {
        $rekamMedis = RekamMedis::all();
        // PDF tetap menggunakan folder view role masing-masing sesuai logic awal Anda
        $pdf = Pdf::loadView($this->getViewPath('report_pdf'), compact('rekamMedis'));
        return $pdf->download('rekam_medis.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new RekamMedisExport, 'rekam_medis.xlsx');
    }

    public function validasi($id)
    {
        try {
            $rekamMedis = RekamMedis::findOrFail($id);
            $rekamMedis->status = 'diobati';
            $rekamMedis->save();

            $rekamMedis->pasien->status = 'diobati';
            $rekamMedis->pasien->save();

            return redirect()->back()->with('success', 'Status berhasil divalidasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat validasi.');
        }
    }
}