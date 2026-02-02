<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Fix foreign key constraints to include proper ON DELETE and ON UPDATE actions.
     * This ensures data integrity when parent records are modified or deleted.
     * 
     * NOTE: Uses raw SQL to handle both Laravel naming (pasien_identity_id_foreign) 
     * and SQL import naming (pasien_ibfk_1)
     */
    public function up(): void
    {
        // Fix pasien foreign keys
        // Drop existing constraint (handles both naming conventions)
        DB::statement('ALTER TABLE pasien DROP FOREIGN KEY pasien_ibfk_1');

        Schema::table('pasien', function (Blueprint $table) {
            $table->foreign('identity_id')
                ->references('id')
                ->on('master_identity')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Fix rekam_medis foreign keys
        DB::statement('ALTER TABLE rekam_medis DROP FOREIGN KEY rekam_medis_ibfk_1');
        DB::statement('ALTER TABLE rekam_medis DROP FOREIGN KEY rekam_medis_ibfk_2');

        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->foreign('pasien_id')
                ->references('id')
                ->on('pasien')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('dokter_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        // Fix resep_obat foreign keys
        DB::statement('ALTER TABLE resep_obat DROP FOREIGN KEY resep_obat_ibfk_1');
        DB::statement('ALTER TABLE resep_obat DROP FOREIGN KEY resep_obat_ibfk_2');

        Schema::table('resep_obat', function (Blueprint $table) {
            $table->foreign('rekam_medis_id')
                ->references('id')
                ->on('rekam_medis')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('obat_id')
                ->references('id')
                ->on('obat')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        // Fix users foreign keys
        DB::statement('ALTER TABLE users DROP FOREIGN KEY users_ibfk_1');
        DB::statement('ALTER TABLE users DROP FOREIGN KEY users_ibfk_2');

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('identity_id')
                ->references('id')
                ->on('master_identity')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original foreign keys without ON DELETE/UPDATE
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropForeign(['identity_id']);
            $table->foreign('identity_id')->references('id')->on('master_identity');
        });

        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropForeign(['pasien_id']);
            $table->dropForeign(['dokter_id']);
            $table->foreign('pasien_id')->references('id')->on('pasien');
            $table->foreign('dokter_id')->references('id')->on('users');
        });

        Schema::table('resep_obat', function (Blueprint $table) {
            $table->dropForeign(['rekam_medis_id']);
            $table->dropForeign(['obat_id']);
            $table->foreign('rekam_medis_id')->references('id')->on('rekam_medis');
            $table->foreign('obat_id')->references('id')->on('obat');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['identity_id']);
            $table->dropForeign(['position_id']);
            $table->foreign('identity_id')->references('id')->on('master_identity');
            $table->foreign('position_id')->references('id')->on('positions');
        });
    }
};
