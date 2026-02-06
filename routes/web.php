<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekerController; // Controller baru sudah di-import
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageUserController;

// --- 1. Public Routes ---
Route::get('/', function () { return view("index"); });
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Registrasi Pasien Umum
Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
Route::get('/pasien/download-pdf/{id}', [PasienController::class, 'downloadPDF'])->name('pasien.download.pdf');

// --- 2. Authenticated Routes ---
Route::middleware(['auth'])->group(function () {

    // --- SHARED SERVICES (RESET PASSWORD) ---
    Route::post('user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');



Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/users', [ManageUserController::class, 'index'])
        ->name('users.index');

    Route::delete('/users/{id}', [ManageUserController::class, 'destroy'])
        ->name('users.destroy');
});

// GROUP ADMIN
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Akun User (PENTING: Perhatikan penamaan .names)
    // Mengarahkan route('admin.index') ke UserController untuk role admin
    Route::resource('admin', UserController::class)
          ->parameters(['admin' => 'id'])
          ->names([
              'index' => 'index', // Ini akan menjadi admin.index
          ]);
          
    Route::resource('dokter', UserController::class)->parameters(['dokter' => 'id']);
    
    // Perbaikan: Tambahkan names agar sidebar apoteker admin.apoteker.index jalan
    Route::resource('apoteker', UserController::class)->parameters(['apoteker' => 'id']);

    // Manajemen Data Medis
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('rekammedis', RekamMedisController::class)->except(['edit', 'create']);
    
        // Fitur Export
        Route::get('/rekam-medis/export/pdf', [RekamMedisController::class, 'exportPDF'])->name('rekam-medis.export.pdf');
        Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])->name('rekam-medis.export.excel');
    });

    // GROUP DOKTER
    Route::prefix('dokter')->name('dokter.')->middleware('role:dokter')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('pasien', PasienController::class);
        Route::resource('obat', ObatController::class);
        Route::resource('rekammedis', RekamMedisController::class)->except(['edit', 'create']);

        Route::get('/rekam-medis/export/pdf', [RekamMedisController::class, 'exportPDF'])->name('rekam-medis.export.pdf');
        Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])->name('rekam-medis.export.excel');
    });

    // GROUP APOTEKER
    Route::prefix('apoteker')->name('apoteker.')->middleware('role:apoteker')->group(function () {
        // PERBAIKAN: Menggunakan ApotekerController dan memberikan alias 'index'
        Route::get('/dashboard', [ApotekerController::class, 'index'])->name('dashboard');
        Route::get('/', [ApotekerController::class, 'index'])->name('index'); 

        Route::resource('pasien', PasienController::class);
        Route::resource('obat', ObatController::class);
        Route::resource('rekammedis', RekamMedisController::class)->names('rekam_medis')->except(['edit', 'create']);
        
        // Fitur Khusus: Validasi Resep oleh Apoteker
        Route::patch('/rekam-medis/{id}/validasi', [RekamMedisController::class, 'validasi'])->name('rekam-medis.validasi');

        Route::get('/rekam-medis/export/pdf', [RekamMedisController::class, 'exportPDF'])->name('rekam-medis.export.pdf');
        Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])->name('rekam-medis.export.excel');
    });

    // --- 3. Profile & Shared Services ---
    Route::get('/profile/basic-details', [ProfileController::class, 'showBasicDetailsForm'])->name('profile.basic-details.form');
    Route::post('/profile/basic-details', [ProfileController::class, 'storeBasicDetails'])->name('profile.basic-details.store');
});