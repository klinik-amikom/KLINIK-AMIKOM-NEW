<?php

namespace App\Http\Controllers;

use App\Models\MasterIdentity;
use Illuminate\Http\Request;

class MasterIdentityController extends Controller
{
    public function index()
    {
        $data = MasterIdentity::latest()->paginate(10);

        return view('master-identity.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identity_number' => 'required|unique:master_identity',
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan',
            'name'            => 'required',
            'birth_date'      => 'nullable|date',
            'gender'          => 'required|in:L,P',
            'no_telp'         => 'nullable',
            'email'           => 'nullable|email',
            'address'         => 'required',
        ]);

        MasterIdentity::create($request->all());

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $data = MasterIdentity::findOrFail($id);

        $request->validate([
            'identity_number' => 'required|unique:master_identity,identity_number,' . $id,
            'identity_type'   => 'required|in:mahasiswa,dosen,karyawan',
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