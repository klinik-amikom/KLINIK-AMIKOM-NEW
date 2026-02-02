<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Create jadwal_dokter table for doctor scheduling management.
     */
    public function up(): void
    {
        Schema::create('jadwal_dokter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dokter_id');
            $table->enum('hari', [
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            ]);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('poli', ['Poli Umum', 'Poli Gigi']);
            $table->unsignedInteger('kuota')->default(20);
            $table->timestamps();

            // Indexes
            $table->index('hari');
            $table->index('poli');

            // Foreign key
            $table->foreign('dokter_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_dokter');
    }
};
