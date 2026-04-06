<?php

namespace App\Http\Controllers;

use App\Models\JadwalKlinik;
use Illuminate\Http\Request;

class JadwalKlinikController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKlinik::all();
        return view('jadwal_klinik.index', compact('jadwal'));
    }

    public function create()
    {
        return view('jadwal_klinik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|array|min:1',
            'hari.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required_without:tutup',
            'jam_selesai' => 'required_without:tutup',
        ]);

        $hariString = implode(', ', $request->hari);

        if ($request->tutup) {
            $jam = 'TUTUP';
        } else {
            $jam = $request->jam_mulai . ' - ' . $request->jam_selesai;
        }

        JadwalKlinik::create([
            'hari' => $hariString,
            'jam_buka' => $jam
        ]);

        return redirect()->route('jadwal_klinik.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = JadwalKlinik::findOrFail($id);
        return view('jadwal_klinik.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKlinik::findOrFail($id);

        // Ambil array hari, default kosong
        $hari = $request->input('hari', []);
        $jadwal->hari = implode(', ', (array) $hari);

        // Jam praktik
        if ($request->tutup ?? false) {
            $jadwal->jam_buka = 'TUTUP';
        } else {
            $jadwal->jam_buka = $request->jam_mulai . ' - ' . $request->jam_selesai;
        }

        $jadwal->save();

        return redirect()->route('jadwal_klinik.index');
    }

    public function destroy($id)
    {
        JadwalKlinik::destroy($id);
        return redirect()->route('jadwal_klinik.index')
            ->with('success', 'Data berhasil dihapus');
    }

}

