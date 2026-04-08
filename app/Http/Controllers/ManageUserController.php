<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MasterIdentity;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    public function index()
    {
        $users = User::with('position', 'identity')
            ->orderBy('name', 'asc')
            ->get();

        $identities = MasterIdentity::all();
        $positions  = Position::all();

        return view('users.index', compact('users', 'identities', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identity_id' => 'required|exists:master_identity,id',
            'position_id' => 'required|exists:positions,id',
            'username'    => 'required|string|max:255|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|confirmed|min:6',
        ]);

        // ambil data identity
        $identity = MasterIdentity::findOrFail($request->identity_id);

        User::create([
            'name'        => $identity->name,      
            'identity_id' => $identity->id,        
            'position_id' => $request->position_id,
            'username'    => $request->username,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'identity_id' => 'required|exists:master_identity,id',
            'position_id' => 'required|exists:positions,id',
            'username'    => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'password'    => 'nullable|string|min:6|confirmed',
        ]);

        // ambil identity
        $identity = MasterIdentity::findOrFail($request->identity_id);

        // update data
        $user->name        = $identity->name; // ✅ dari master_identity
        $user->username    = $request->username;
        $user->email       = $request->email;
        $user->identity_id = $identity->id;
        $user->position_id = $request->position_id; // ✅ dari select

        // update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak bisa hapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}