<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\JadwalKlinik;
use App\Models\TimMedis;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwal = JadwalDokter::with(['dokter', 'poli'])->get();
        $dokters = User::where('position_id', 2)->get();
        $polis   = Poli::all();

        return view('jadwal_dokter.index', compact('jadwal', 'dokters', 'polis'));
    }

    public function create()
    {
        // ambil dokter saja (misal position_id = 2)
        $dokters = User::where('position_id', 2)->get();
        $polis   = Poli::all();

        return view('jadwal_dokter.create', compact('dokters', 'polis'));
    }

    public function store(Request $request)
    {
        foreach ($request->hari as $hari) {
            JadwalDokter::create([
                'dokter_id' => $request->dokter_id,
                'poli' => $request->poli,
                'hari' => $hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);
        }

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        $dokters = User::where('position_id', 2)->get();
        $polis   = Poli::all();

        return view('jadwal_dokter.edit', compact('jadwal', 'dokters', 'polis'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::findOrFail($id);

        $request->validate([
            'dokter_id'   => 'required|exists:users,id',
            'poli'        => 'required|exists:poli,id',
            'hari'        => 'required|array|min:1',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal->update([
            'dokter_id'   => $request->dokter_id,
            'poli'        => $request->poli,
            'hari'        => implode(', ', $request->hari),
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('jadwal_dokter.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        JadwalDokter::destroy($id);

        return redirect()->route('jadwal_dokter.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function landing()
    {
        $jadwal = JadwalDokter::with(['dokter', 'poli'])->get();
        $jadwalKlinik = JadwalKlinik::all();
        $timMedis = TimMedis::all();

        return view('index', compact('jadwal', 'jadwalKlinik', 'timMedis'));
    }
}