<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Add soft delete functionality to important tables.
     * This allows "deleting" records without actually removing them from the database.
     */
    public function up(): void
    {
        // Add soft deletes to master_identity
        Schema::table('master_identity', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to users
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to pasien
        Schema::table('pasien', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to rekam_medis
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to obat
        Schema::table('obat', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_identity', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('pasien', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('obat', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
