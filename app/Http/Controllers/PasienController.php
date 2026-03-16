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

    // 🔎 Cek apakah identity sudah ada
    $identity = MasterIdentity::where('identity_number', $request->identity_number)->first();

    // 🆕 Jika belum ada → buat baru
    if (!$identity) {
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
    $lastPasien = Pasien::orderBy('id','desc')->first();

    $newNumber = $lastPasien
        ? (int) substr($lastPasien->kode_pasien,1) + 1
        : 1;

    $kodePasien = 'P' . str_pad($newNumber,3,'0',STR_PAD_LEFT);

    // 🔢 Generate nomor antrian
    $prefix = $request->poli === 'Poli Umum' ? 'PU' : 'PG';

    $jumlahHariIni = Pasien::whereDate('created_at', today())
        ->where('poli', $request->poli)
        ->count() + 1;

    $noAntrian = $prefix . '-' . str_pad($jumlahHariIni,3,'0',STR_PAD_LEFT);

    // 💾 Simpan pasien
    $pasien = Pasien::create([
        'identity_id'  => $identity->id,
        'kode_pasien'  => $kodePasien,
        'poli'         => $request->poli,
        'queue_number' => $noAntrian,
        'status'       => 'menunggu_konfirmasi',
    ]);

    // 📧 Kirim email notifikasi (jika ada email)
    if($identity->email){
        Mail::to($identity->email)->send(new NotifikasiAntrian($pasien));
    }

    // load relasi identity
    $pasien->load('identity');

    // 🔐 Jika admin login
    if(auth()->check()){
        $role = auth()->user()->role;

        return redirect()
            ->route($role . '.pasien.index')
            ->with('success','Pasien berhasil ditambahkan.');
    }

    // 🌐 Jika pendaftaran publik
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

        $linkWA = $pasien
            ? 'https://wa.me/62xxxx?text=Nomor%20Antrian%20' . $pasien->kode_pasien
            : null;

        return view('profile.basic-details', compact('pasien', 'linkWA'));
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