<?php
namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekamMedisExport;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $pencarian = $request->query('cari');

        $dataRekamMedis = RekamMedis::with(['pasien.identity', 'dokter', 'resepObat.obat'])
            ->when($pencarian, function ($query, $pencarian) {
                $query->where('kode_rekam_medis', 'like', "%$pencarian%")
                    ->orWhereHas('pasien', function ($q) use ($pencarian) {
                        $q->where('nama_pasien', 'like', "%$pencarian%");
                    })
                    ->orWhere('diagnosis', 'like', "%$pencarian%");
            })
            ->orderBy('tanggal_periksa', 'desc')
            ->get();

        return view('rekam_medis.index', compact('dataRekamMedis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_periksa' => 'required|date',
            'pasien_id'       => 'required|exists:pasien,id',
            'dokter_id'       => 'required|exists:users,id',
        ]);

        $last = RekamMedis::latest('id')->first();
        $next = $last ? $last->id + 1 : 1;
        $kode = 'RM' . str_pad($next, 3, '0', STR_PAD_LEFT);

        RekamMedis::create([
            'kode_rekam_medis' => $kode,
            'tanggal_periksa'  => $request->tanggal_periksa,
            'pasien_id'        => $request->pasien_id,
            'dokter_id'        => $request->dokter_id,
            'status'           => 'menunggu_pemeriksaan',
        ]);

        return redirect()->route('rekammedis.index')
            ->with('success', 'Rekam medis berhasil dibuat.');
    }

    public function show($id)
    {
        $rekam = RekamMedis::with([
            'dokter',
            'pasien.identity',
            'resepObat.obat',
        ])->findOrFail($id);

        $obats = \App\Models\Obat::all();

        return view('rekam_medis.show', compact('rekam', 'obats'));
    }

    public function update(Request $request, $id)
    {
        $rekam = RekamMedis::with('pasien')->findOrFail($id);

        $request->validate([
            'diagnosis'    => 'required|string',
            'obat_id'      => 'required|array|min:1',
            'obat_id.*'    => 'exists:obat,id',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'integer|min:1',
            'aturan_pakai' => 'nullable|array',
        ]);

        // Update diagnosis & status rekam medis
        $rekam->update([
            'diagnosis' => $request->diagnosis,
            'status'    => 'menunggu_obat',
        ]);

        // Update status pasien
        $rekam->pasien->update([
            'status' => 'menunggu_obat',
        ]);

        // Hapus resep lama
        $rekam->resepObat()->delete();

        // Insert resep baru
        foreach ($request->obat_id as $i => $obatId) {
            $rekam->resepObat()->create([
                'obat_id'      => $obatId,
                'jumlah'       => $request->jumlah[$i],
                'aturan_pakai' => $request->aturan_pakai[$i] ?? null,
            ]);
        }

        return redirect()->route('rekammedis.index')
            ->with('success', 'Pemeriksaan selesai, pasien menunggu obat.');
    }

    public function destroy($id)
    {
        RekamMedis::findOrFail($id)->delete();

        return redirect()->route('rekammedis.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function mulaiPeriksa($id)
    {
        $rekam = RekamMedis::with('pasien')->findOrFail($id);

        $rekam->update([
            'status' => 'diperiksa',
        ]);

        $rekam->pasien->update([
            'status' => 'diperiksa',
        ]);

        return back()->with('success', 'Pasien mulai diperiksa.');
    }

    public function selesai($id)
    {
        $rekam = RekamMedis::with('pasien')->findOrFail($id);

        $rekam->update([
            'status' => 'selesai',
        ]);

        $rekam->pasien->update([
            'status' => 'selesai',
        ]);

        return back()->with('success', 'Obat telah diberikan, pasien selesai.');
    }

    public function exportPDF(Request $request)
    {
        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        $rekamMedis = RekamMedis::with(['pasien.identity','dokter','resepObat.obat'])
            ->when($mulai && $selesai, function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_periksa', [$mulai, $selesai]);
            })
            ->orderBy('tanggal_periksa','desc')
            ->get();

        $pdf = Pdf::loadView('rekam_medis.report_pdf', compact('rekamMedis','mulai','selesai'))
            ->setPaper('a4','landscape');

        return $pdf->download('rekam_medis.pdf');
    }

    public function exportExcel(Request $request)
    {
        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        $data = RekamMedis::with(['pasien.identity','dokter','resepObat.obat'])
            ->when($mulai && $selesai, function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_periksa', [$mulai, $selesai]);
            })
            ->get();

        return Excel::download(new RekamMedisExport($data), 'rekam_medis.xlsx');
    }

}
