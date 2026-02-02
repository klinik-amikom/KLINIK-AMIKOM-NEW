<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Add timestamps to tables that don't have them.
     * This is required for Laravel Eloquent models to work properly.
     */
    public function up(): void
    {
        // Add timestamps to positions table
        Schema::table('positions', function (Blueprint $table) {
            $table->timestamps();
        });

        // Add timestamps to resep_obat table
        Schema::table('resep_obat', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('resep_obat', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
