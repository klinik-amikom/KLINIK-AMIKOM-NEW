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
        Schema::create('tabel_rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rekam_medis', 5)->unique();
            $table->date('tanggal_periksa');
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('obat_id'); 
            $table->text('diagnosis');
            $table->text('resep');
            $table->date('tanggal_pengambilan');
            $table->integer('jumlah_obat');
            $table->timestamps();
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('obat_id')->references('id')->on('obat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_rekam_medis');
    }
};
