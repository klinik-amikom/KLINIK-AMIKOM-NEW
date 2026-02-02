<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->enum('kategori',['mahasiswa','dosen','karyawan'])->after('no_telp');
            $table->enum('status',['terdaftar','diperiksa','diobati','selesai'])->default('terdaftar');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->drop('kategori');
            $table->drop('status');
        });
    }
};
