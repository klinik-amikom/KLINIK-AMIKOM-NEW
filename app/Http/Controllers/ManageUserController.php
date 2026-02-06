<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    /**
     * Tampilkan halaman kelola user
     */
    public function index()
    {
        $users = User::with('position') // ambil nama position
            ->orderBy('name', 'asc')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Hapus user (soft delete)
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // ❗ cegah admin hapus akun sendiri
            if (auth()->id() === $user->id) {
                return redirect()
                    ->route('users.index')
                    ->with('error', 'Anda tidak dapat menghapus akun sendiri');
            }

            $user->delete();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Gagal menghapus user');
        }
    }
}
