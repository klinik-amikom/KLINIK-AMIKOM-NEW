<?php
namespace App\Http\Controllers;

use App\Exports\RekamMedisExport;
use App\Models\Obat;
use App\Models\RekamMedis;
use App\Models\MasterIdentity;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RekamMedisController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->cari;
        $status = $request->status;
        $kategori = $request->kategori;

        // ✅ Ambil flag lihat semua
        $lihatSemua = $request->lihat_semua;

        // ✅ FORMAT TANGGAL (AMAN)
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->format('Y-m-d')
            : null;

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->format('Y-m-d')
            : null;

        $dataRekamMedis = RekamMedis::with(['pasien.identity', 'dokter', 'resepObat.obat'])

            // 🔍 SEARCH
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
            ->when(!$lihatSemua && $start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_periksa', [$start, $end]);
            })
            ->when(!$lihatSemua && $start && !$end, function ($query) use ($start) {
                $query->whereDate('tanggal_periksa', '>=', $start);
            })
            ->when(!$lihatSemua && !$start && !$end, function ($query) {
                $query->whereDate('tanggal_periksa', Carbon::today());
            })

            // ✅ FILTER STATUS
            ->when($status, function ($query, $status) {
                $query->whereHas('pasien', function ($q) use ($status) {
                    $q->where('status', $status);
                });
            })

            // ✅ FILTER KATEGORI (identity_type)
            ->when($kategori, function ($query) use ($kategori) {
                $query->whereHas('pasien.identity', function ($q) use ($kategori) {
                    $q->where('identity_type', $kategori);
                });
            })

            ->orderBy('tanggal_periksa', 'desc')
            ->paginate(10)
            ->withQueryString();

            $kategoriList = \App\Models\MasterIdentity::select('identity_type')
                ->distinct()
                ->pluck('identity_type');

        return view('rekam_medis.index', compact('dataRekamMedis', 'kategoriList'));
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
        DB::beginTransaction();

        try {
            $rekam = RekamMedis::with(['pasien', 'resepObat.obat'])->findOrFail($id);

            // ❗ Tambahan: cegah double klik
            if ($rekam->status === 'selesai') {
                return back()->with('error', 'Obat sudah diberikan sebelumnya.');
            }

            // ✅ Tambahan: kurangi stok obat
            foreach ($rekam->resepObat as $item) {
                $obat = $item->obat;

                if ($obat->stok < $item->jumlah) {
                    throw new \Exception("Stok {$obat->nama_obat} tidak mencukupi!");
                }

                $obat->decrement('stok', $item->jumlah);
            }

            // 🔹 LOGIC ASLI KAMU (TIDAK DIUBAH)
            $rekam->update([
                'status' => 'selesai',
            ]);

            $rekam->pasien->update([
                'status' => 'selesai',
            ]);

            DB::commit();

            return back()->with('success', 'Obat telah diberikan, stok diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function exportPDF(Request $request)
    {
        $mulai   = $request->tanggal_mulai;
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
        $mulai   = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        $data = RekamMedis::with(['pasien.identity', 'dokter', 'resepObat.obat'])
            ->when($mulai && $selesai, function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_periksa', [$mulai, $selesai]);
            })
            ->get();

        return Excel::download(new RekamMedisExport($data), 'rekam_medis.xlsx');
    }


    public function exportPerPasien($pasienId)
    {
        // Ambil semua rekam medis pasien
        $data = RekamMedis::with(['pasien.identity', 'dokter', 'resepObat.obat'])
            ->where('pasien_id', $pasienId)
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $pasien = $data->first()->pasien;

        $pdf = Pdf::loadView('rekam_medis.export_pasien', compact('data', 'pasien'));

        return $pdf->download('rekam-medis-' . $pasien->identity->name . '.pdf');
    }
}
