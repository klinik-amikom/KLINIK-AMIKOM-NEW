<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Add harga (price) column to obat table.
     */
    public function up(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->decimal('harga', 10, 2)->unsigned()->default(0)->after('stok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
};
