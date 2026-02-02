<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Create transaksi table for billing and payment management.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 20)->unique();
            $table->unsignedBigInteger('rekam_medis_id');
            $table->decimal('total_biaya', 10, 2)->unsigned()->default(0);
            $table->enum('metode_pembayaran', [
                'tunai',
                'transfer',
                'kartu_debit',
                'kartu_kredit',
                'asuransi'
            ])->default('tunai');
            $table->enum('status_pembayaran', [
                'belum_bayar',
                'lunas',
                'dibatalkan'
            ])->default('belum_bayar');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('rekam_medis_id')
                ->references('id')
                ->on('rekam_medis')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
