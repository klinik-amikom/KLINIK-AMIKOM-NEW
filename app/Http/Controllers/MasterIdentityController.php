<?php

namespace App\Http\Controllers;

use App\Models\MasterIdentity;
use Illuminate\Http\Request;

class MasterIdentityController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->search;
        $kategori = $request->kategori;
        $start    = $request->start_date;
        $end      = $request->end_date;

        $data = MasterIdentity::query()

            // 🔍 SEARCH
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('identity_number', 'like', "%{$search}%")
                        ->orWhere('identity_type', 'like', "%{$search}%");
                });
            })

            // 📌 FILTER KATEGORI
            ->when($kategori, function ($query) use ($kategori) {
                $query->where('identity_type', $kategori);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('master-identity.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identity_number' => 'required|unique:master_identity,identity_number,NULL,id,deleted_at,NULL',
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan,karyawan_buma',
            'name'            => 'required',
            'birth_date'      => 'nullable|date',
            'gender'          => 'required|in:L,P',
            'no_telp'         => 'nullable',
            'email'           => 'nullable|email',
            'address'         => 'required',
        ]);

        MasterIdentity::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $data = MasterIdentity::findOrFail($id);

        $request->validate([
            'identity_number' => 'required|unique:master_identity,identity_number,' . $id . ',id,deleted_at,NULL',
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan,karyawan_buma',
            'name'            => 'required',
            'birth_date'      => 'nullable|date',
            'gender'          => 'required|in:L,P',
            'no_telp'         => 'nullable',
            'email'           => 'nullable|email',
            'address'         => 'required',
        ]);

        $data->update($request->all());

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = MasterIdentity::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
