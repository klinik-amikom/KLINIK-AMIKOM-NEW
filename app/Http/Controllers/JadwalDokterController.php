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
        $data = $request->all();

        $data['hari_praktik'] = implode(', ', $request->hari_praktik);

        $data['jam_praktik'] = $request->jam_mulai . ' - ' . $request->jam_selesai;

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

        $data = $request->all();

        $data['hari_praktik'] = implode(', ', $request->hari_praktik);

        $data['jam_praktik'] = $request->jam_mulai . ' - ' . $request->jam_selesai;

        $jadwal->update($data);

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
        
        return view('index', compact('jadwal', 'jadwalKlinik'));
    }
}
