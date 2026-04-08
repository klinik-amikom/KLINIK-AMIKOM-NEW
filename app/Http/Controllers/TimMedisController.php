<?php

namespace App\Http\Controllers;

use App\Models\TimMedis;
use App\Models\User;
use Illuminate\Http\Request;

class TimMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TimMedis::with('user')->get();
        $users = User::whereIn('position_id', [2, 3])->get();

        return view('tim_medis.index', compact('data', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'deskripsi' => 'required',
            'gambar' => 'required|image'
        ]);

        // 🔥 Validasi user harus dokter/apoteker
        $user = User::where('id', $request->user_id)
            ->whereIn('position_id', [2, 3])
            ->firstOrFail();

        $gambar = $request->file('gambar')->store('tim_medis', 'public');

        TimMedis::create([
            'user_id' => $user->id,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimMedis $timMedis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimMedis $timMedis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $timMedis = TimMedis::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'deskripsi' => 'required',
        ]);

        // 🔥 Validasi hanya dokter/apoteker
        $user = User::where('id', $request->user_id)
            ->whereIn('position_id', [2, 3])
            ->firstOrFail();

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('tim_medis', 'public');
            $timMedis->gambar = $gambar;
        }

        $timMedis->update([
            'user_id' => $user->id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $timMedis = TimMedis::findOrFail($id);
        $timMedis->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
