<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MasterIdentity;
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

        return view('users.index', compact('users', 'identities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:255|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'identity_id' => 'required|exists:master_identity,id',
            'password'    => 'required|string|confirmed|min:6',
        ]);

        // ambil identity
        $identity = MasterIdentity::findOrFail($request->identity_id);

        User::create([
            'name'        => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'identity_id' => $identity->id,
            'position_id' => $identity->position_id, // otomatis
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'identity_id' => 'required|exists:identities,id',
            'password'    => 'nullable|string|min:6|confirmed',
        ]);

        $identity = MasterIdentity::findOrFail($request->identity_id);

        $user->name        = $request->name;
        $user->username    = $request->username;
        $user->email       = $request->email;
        $user->identity_id = $identity->id;
        $user->position_id = $identity->position_id; // otomatis update

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
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