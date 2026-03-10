<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use App\Models\MasterIdentity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display list of users based on role (admin, dokter, apoteker).
     */
    public function index(Request $request)
    {
        // Detect role from URL segment
        $segment = $request->segment(2); // 'admin', 'dokter', or 'apoteker'
        $role = in_array($segment, ['admin', 'dokter', 'apoteker']) ? $segment : 'admin';

        try {
            // Map role to position code
            $positionCode = ['admin' => 'ADM', 'dokter' => 'DOK', 'apoteker' => 'APT'][$role];

            // Get users with this position
            $users = User::whereHas('identity', function ($q) use ($role) {
                $q->where('name', ucfirst($role));
            })
                ->with('identity')
                ->orderBy('created_at', 'desc')
                ->get();


            return view("{$role}.index", compact('users', 'role'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Gagal memuat data {$role}: " . $e->getMessage());
        }
    }

    public function create()
    {
        $identities = MasterIdentity::all();

        return view('users.create', compact('identities'));
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $role = $request->role; // From hidden input in form

        try {
            $rules = [
                'identity_id' => 'required|exists:master_identities,id',
                'name' => 'required|string|max:255|min:2',
                'username' => 'required|string|unique:users,username|max:255|min:3',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8|confirmed',
                'position_id' => 'required|exists:positions,id',
            ];

            $validatedData = $request->validate($rules, $this->customMessages());

            DB::beginTransaction();

            User::create([
                'identity_id' => $validatedData['identity_id'],
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'position_id' => $validatedData['position_id'],
                'email_verified_at' => now(),
            ]);

            DB::commit();

            return redirect()->route("admin.{$role}.index")->with('success', ucfirst($role) . ' berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update user data.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $rules = [
                'position_id' => 'required|exists:positions,id',
                'name' => 'required|string|max:255|min:2',
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    'min:3',
                    Rule::unique('users')->ignore($user->id)
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
            ];

            if ($request->filled('password')) {
                $rules['password'] = 'required|string|min:8|confirmed';
            }

            $validatedData = $request->validate($rules);

            DB::beginTransaction();

            $updateData = [
                'position_id' => $validatedData['position_id'],
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($validatedData['password']);
            }

            $user->update($updateData);

            DB::commit();

            return redirect()->route('admin.admin.index')
                ->with('success', 'User berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Delete user.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $role = $user->role;

            // Cegah admin hapus akun sendiri
            if (auth()->id() === $user->id) {
                return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
            }

            \DB::beginTransaction();

            $userName = $user->name;

            $user->forceDelete(); // Hard delete, permanen

            \DB::commit();

            return redirect()->route("admin.{$role}.index")
                ->with('success', "{$role} {$userName} berhasil dihapus permanen!");
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $request->validate([
                'new_password' => 'required|string|min:8|confirmed',
            ], [
                'new_password.required' => 'Password baru wajib diisi',
                'new_password.min' => 'Password minimal 8 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);

            $user->update(['password' => Hash::make($request->new_password)]);
            return redirect()->back()->with('success', 'Password berhasil direset!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show user details.
     */
    public function show($id)
    {
        try {
            $user = User::with(['position', 'identity'])->findOrFail($id);
            return view('admin.users.show', compact('user'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $identities = MasterIdentity::all();

        return view('users.edit', compact(
            'user',
            'identities'
        ));
    }

    /**
     * Custom validation messages.
     */
    private function customMessages()
    {
        return [
            'identity_id.required' => 'Identity wajib dipilih',
            'identity_id.exists' => 'Identity tidak valid',
            'name.required' => 'Nama lengkap wajib diisi',
            'name.min' => 'Nama minimal 2 karakter',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'username.min' => 'Username minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'position_id.required' => 'Position wajib dipilih',
            'position_id.exists' => 'Position tidak valid',
        ];
    }
}
