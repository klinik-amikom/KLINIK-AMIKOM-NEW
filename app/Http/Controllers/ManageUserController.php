<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    /**
     * Tampilkan halaman kelola user
     */
    public function index()
    {
        $users = User::with('position', 'identity')
            ->orderBy('name', 'asc')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan halaman tambah user
     */
    public function create()
    {
        $role = 'user'; // untuk Blade create
        return view('users.create', compact('role'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:255|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'identity_id' => 'required|integer',
            'password'    => 'required|string|confirmed|min:6',
        ]);

        // ❗ Set position_id otomatis sesuai identity_id
        $positionId = match ($request->identity_id) {
            1 => 1, // Admin
            2 => 2, // Dokter
            3 => 3, // Apoteker
            4 => 4, // Admin Klinik
            default => 1, // fallback default Admin
        };

        User::create([
            'name'        => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'identity_id' => $request->identity_id,
            'position_id' => $positionId,
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    /**
     * Tampilkan halaman edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = 'user';
        return view('users.edit', compact('user', 'role'));
    }

    /**
     * Update data user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'identity_id' => 'required|integer',
            'password'    => 'nullable|string|confirmed|min:6',
        ]);

        $user->name        = $request->name;
        $user->username    = $request->username;
        $user->email       = $request->email;
        $user->identity_id = $request->identity_id;

        // ❗ Update position_id otomatis
        $user->position_id = match ($request->identity_id) {
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            default => $user->position_id,
        };

        // update password jika diisi
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Hapus user (soft delete)
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // cegah admin hapus akun sendiri
            if (auth()->id() === $user->id) {
                return redirect()
                    ->route('users.index')
                    ->with('error', 'Anda tidak dapat menghapus akun sendiri');
            }

            $user->delete(); // Hard delete, permanen

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dihapus permanen');
        } catch (\Exception $e) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
