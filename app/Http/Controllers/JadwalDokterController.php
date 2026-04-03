<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\JadwalKlinik;
use App\Models\TimMedis;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwal = JadwalDokter::all();
        return view('jadwal_dokter.index', compact('jadwal'));
    }

    public function create()
    {
        return view('jadwal_dokter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required',
            'hari' => 'required|array|min:1',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $data = $request->all();

        $data['hari'] = implode(', ', $request->input('hari', []));

        $data['jam_mulai'] = $request->jam_mulai;
        $data['jam_selesai'] = $request->jam_selesai;

        $data['poli'] = 'Umum';

        JadwalDokter::create($data);

        return redirect()->route('jadwal_dokter.index')
            ->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        return view('jadwal_dokter.edit', compact('jadwal'));
    }

public function update(Request $request, $id)
{
    $jadwal = JadwalDokter::findOrFail($id);

    $request->validate([
        'nama_dokter' => 'required',
        'hari' => 'required|array|min:1',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
    ]);

    $jadwal->update([
        'nama_dokter' => $request->nama_dokter,
        'hari' => implode(', ', $request->hari),
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'poli' => 'Umum',
    ]);

    return redirect()->route('jadwal_dokter.index')
        ->with('success', 'Data berhasil diupdate');
}

    public function destroy($id)
    {
        JadwalDokter::destroy($id);
        return redirect()->route('jadwal_dokter.index');
    }

    public function landing()
    {
        $jadwal = JadwalDokter::all();
        $jadwalKlinik = JadwalKlinik::all();
        $timMedis = TimMedis::all();

        return view('index', compact('jadwal', 'jadwalKlinik', 'timMedis'));
    }
}
