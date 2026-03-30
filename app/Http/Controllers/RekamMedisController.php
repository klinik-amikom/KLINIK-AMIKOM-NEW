<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekamMedisExport;
use Carbon\Carbon;

class RekamMedisController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->cari;
        $status = $request->status;

        // ✅ FORMAT TANGGAL (AMAN)
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->format('Y-m-d')
            : null;

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->format('Y-m-d')
            : null;

        $dataRekamMedis = RekamMedis::with(['pasien.identity', 'dokter', 'resepObat.obat'])

            // 🔍 SEARCH (WAJIB DI GROUPING)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_rekam_medis', 'like', "%{$search}%")
                        ->orWhereHas('pasien.identity', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%")
                                ->orWhere('identity_number', 'like', "%{$search}%");
                        })
                        ->orWhere('diagnosis', 'like', "%{$search}%");
                });
            })

            // 📅 FILTER TANGGAL
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_periksa', [$start, $end]);
            })

            ->when($start && !$end, function ($query) use ($start) {
                $query->whereDate('tanggal_periksa', '>=', $start);
            })

            ->when(!$start && $end, function ($query) use ($end) {
                $query->whereDate('tanggal_periksa', '<=', $end);
            })

            // ✅ FILTER STATUS (INI YANG DITAMBAHKAN)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })

            // 🔽 SORTING
            ->orderBy('tanggal_periksa', 'desc')

            // ✅ PAGINATION + SIMPAN QUERY
            ->paginate(10)
            ->withQueryString();

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

        $rekamMedis = RekamMedis::with(['pasien.identity', 'dokter', 'resepObat.obat'])
            ->when($mulai && $selesai, function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_periksa', [$mulai, $selesai]);
            })
            ->orderBy('tanggal_periksa', 'desc')
            ->get();

        $pdf = Pdf::loadView('rekam_medis.report_pdf', compact('rekamMedis', 'mulai', 'selesai'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('rekam_medis.pdf');
    }

    public function exportExcel(Request $request)
    {
        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        $data = RekamMedis::with(['pasien.identity', 'dokter', 'resepObat.obat'])
            ->when($mulai && $selesai, function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_periksa', [$mulai, $selesai]);
            })
            ->get();

        return Excel::download(new RekamMedisExport($data), 'rekam_medis.xlsx');
    }
}
