<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\ManageUserController;
use Illuminate\Support\Facades\Route;

// ==================================================
// 1. PUBLIC ROUTES (TANPA LOGIN)
// ==================================================
Route::get('/', function () {
    return view("index");
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// FORM PENDAFTARAN PASIEN (PUBLIC)
Route::get('/profile/basic-details', [ProfileController::class, 'showBasicDetailsForm'])
    ->name('profile.basic-details.form');

Route::post('/profile/basic-details', [ProfileController::class, 'storeBasicDetails'])
    ->name('profile.basic-details.store');

// AUTO FILL IDENTITAS BERDASARKAN NIK (PUBLIC)
Route::get('/cek-nik/{nik}', [ProfileController::class, 'cekNik'])
    ->name('cek.nik');

// Registrasi Pasien Umum
Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
Route::get('/pasien/download-pdf/{id}', [PasienController::class, 'downloadPDF'])
    ->name('pasien.download.pdf');
Route::get('/pasien', function () {
    $pasien = null;
    $linkWA = null;

    if (session()->has('pasien_id')) {
        $pasien = \App\Models\Pasien::with('identity')
            ->find(session('pasien_id'));

        if ($pasien) {
            $linkWA = 'https://wa.me/62xxxx?text=Nomor%20Antrian%20' . $pasien->kode_pasien;
        }
    }

    return view('profile.basic-details', compact('pasien', 'linkWA'));
})->name('pasien.form');


// ==================================================
// 2. AUTHENTICATED ROUTES (WAJIB LOGIN)
// ==================================================
// Group khusus admin (opsional)
Route::prefix('users')->name('users.')->group(function () {

    Route::get('/', [ManageUserController::class, 'index'])->name('index');

    Route::get('/create', [ManageUserController::class, 'create'])->name('create');
    Route::post('/', [ManageUserController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [ManageUserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ManageUserController::class, 'update'])->name('update');

    Route::delete('/{id}', [ManageUserController::class, 'destroy'])
        ->name('destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- SHARED SERVICES ---
    Route::post('user/{id}/reset-password', [UserController::class, 'resetPassword'])
        ->name('user.reset-password');

    // ================= ADMIN =================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.admin.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.admin.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.admin.store');
        Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.admin.edit');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.admin.update');
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.admin.destroy');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('admin', UserController::class)->parameters(['admin' => 'id']);
        Route::resource('dokter', UserController::class)->parameters(['dokter' => 'id']);
        Route::resource('apoteker', UserController::class)->parameters(['apoteker' => 'id']);

        Route::get('pasien/identity/{number}', [PasienController::class, 'getIdentity'])
            ->name('pasien.getIdentity');

        Route::resource('pasien', PasienController::class);
        Route::resource('obat', ObatController::class);
        Route::resource('rekammedis', RekamMedisController::class)->except(['edit', 'create']);

        Route::get('/rekam-medis/export/pdf', [RekamMedisController::class, 'exportPDF'])
            ->name('rekam-medis.export.pdf');

        Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])
            ->name('rekam-medis.export.excel');
    });

    // ================= DOKTER =================
    Route::prefix('dokter')->name('dokter.')->middleware('role:dokter')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('pasien/identity/{number}', [PasienController::class, 'getIdentity'])
            ->name('pasien.getIdentity');

        Route::resource('pasien', PasienController::class);
        Route::resource('obat', ObatController::class);
        Route::resource('rekammedis', RekamMedisController::class)->except(['edit', 'create']);

        Route::get('/rekam-medis/export/pdf', [RekamMedisController::class, 'exportPDF'])
            ->name('rekam-medis.export.pdf');

        Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])
            ->name('rekam-medis.export.excel');
    });

    // ================= APOTEKER =================
    Route::prefix('apoteker')->name('apoteker.')->middleware('role:apoteker')->group(function () {
        Route::get('/dashboard', [ApotekerController::class, 'index'])->name('dashboard');

        Route::resource('pasien', PasienController::class);
        Route::resource('obat', ObatController::class);
        Route::resource('rekammedis', RekamMedisController::class)
            ->names('rekam_medis')
            ->except(['edit', 'create']);

        Route::patch('/rekam-medis/{id}/validasi', [RekamMedisController::class, 'validasi'])
            ->name('rekam-medis.validasi');

        Route::get('/rekam-medis/export/pdf', [RekamMedisController::class, 'exportPDF'])
            ->name('rekam-medis.export.pdf');

        Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])
            ->name('rekam-medis.export.excel');
    });
});
