<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ObatController extends Controller
{
    /**
     * Helper untuk menentukan path view berdasarkan role user.
     */
    private function getViewPath($viewName)
    {
        $role = auth()->user()->level; // Pastikan 'level' sesuai dengan kolom di tabel users Anda
        return $role . '.obat.' . $viewName;
    }

    /**
     * Helper untuk redirect kembali ke index sesuai role.
     */
    private function redirectIndex()
    {
        $role = auth()->user()->level;
        return redirect()->route($role . '.obat.index');
    }

    public function index()
    {
        try {
            // Mengambil data obat dengan pengurutan numerik pada kode_obat
            $dataObat = Obat::orderByRaw("CAST(SUBSTRING(kode_obat, 2) AS UNSIGNED) ASC")
            ->paginate(10)
            ->withQueryString();
            return view($this->getViewPath('index'), compact('dataObat'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'kode_obat'          => 'required|string|max:10|unique:obat,kode_obat',
                'nama_obat'          => 'required|string|max:100|min:2', // Sesuai dengan name di blade
                'stok'               => 'required|integer|min:0',
                'tanggal_kadaluarsa' => 'required|date',
                'deskripsi'          => 'nullable|string',
            ]);

            DB::beginTransaction();

            Obat::create([
                // Jika user mengosongkan kode_obat di view, gunakan generate otomatis
                'kode_obat'          => $request->kode_obat ?? $this->generateKodeObat(),
                'nama_obat'          => $validatedData['nama_obat'],
                'stok'               => $validatedData['stok'],
                'tanggal_kadaluarsa' => $validatedData['tanggal_kadaluarsa'],
                'deskripsi'          => $validatedData['deskripsi'],
            ]);

            DB::commit();

            return $this->redirectIndex()->with('success', 'Data obat berhasil ditambahkan.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal, silakan periksa kembali data.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $obat = Obat::findOrFail($id);

            $validatedData = $request->validate([
                'kode_obat'          => ['required', 'string', 'max:10', Rule::unique('obat')->ignore($obat->id)],
                'nama_obat'          => 'required|string|max:100|min:2',
                'stok'               => 'required|integer|min:0',
                'tanggal_kadaluarsa' => 'required|date',
                'deskripsi'          => 'nullable|string',
            ]);

            DB::beginTransaction();

            $obat->update([
                'kode_obat'          => $validatedData['kode_obat'],
                'nama_obat'          => $validatedData['nama_obat'],
                'stok'               => $validatedData['stok'],
                'tanggal_kadaluarsa' => $validatedData['tanggal_kadaluarsa'],
                'deskripsi'          => $validatedData['deskripsi'],
            ]);

            DB::commit();

            return $this->redirectIndex()->with('success', 'Data obat berhasil diperbarui.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $obat = Obat::findOrFail($id);

            DB::beginTransaction();
            $obat->forceDelete();
            DB::commit();

            return $this->redirectIndex()->with('success', 'Data obat berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Generate Kode Obat Otomatis (Format: O0001)
     */
    private function generateKodeObat()
    {
        $lastObat = Obat::where('kode_obat', 'LIKE', 'O%')
            ->orderByRaw("CAST(SUBSTRING(kode_obat, 2) AS UNSIGNED) DESC")
            ->first();

        $lastNumber = 0;
        if ($lastObat && preg_match('/O(\d+)/', $lastObat->kode_obat, $match)) {
            $lastNumber = (int) $match[1];
        }

        return 'O' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}