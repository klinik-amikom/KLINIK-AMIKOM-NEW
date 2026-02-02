<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Add UNSIGNED constraints to columns that should never be negative.
     * This prevents invalid data like negative stock or negative quantity.
     */
    public function up(): void
    {
        // Change stok column in obat table to UNSIGNED
        DB::statement('ALTER TABLE obat MODIFY stok INT UNSIGNED NOT NULL DEFAULT 0');

        // Change jumlah column in resep_obat table to UNSIGNED
        DB::statement('ALTER TABLE resep_obat MODIFY jumlah INT UNSIGNED NOT NULL DEFAULT 1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to signed integers
        DB::statement('ALTER TABLE obat MODIFY stok INT NOT NULL');
        DB::statement('ALTER TABLE resep_obat MODIFY jumlah INT NOT NULL');
    }
};
