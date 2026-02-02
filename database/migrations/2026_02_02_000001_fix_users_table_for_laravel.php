<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Fix users table to be compatible with Laravel 11 authentication system.
     * - Add required Laravel auth columns: name, email, email_verified_at, remember_token
     * - Remove redundant gender column (already exists in master_identity)
     * - Migrate existing data to populate new columns
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add Laravel required columns
            $table->string('name')->after('identity_id');
            $table->string('email')->unique()->after('username');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->rememberToken()->after('password');
        });

        // Migrate data: populate name from master_identity
        DB::statement('
            UPDATE users u
            INNER JOIN master_identity mi ON u.identity_id = mi.id
            SET u.name = mi.name
        ');

        // Migrate data: generate email from username
        // You may want to customize this logic based on your requirements
        DB::statement("
            UPDATE users 
            SET email = CONCAT(username, '@klinik.amikom.ac.id')
            WHERE email = '' OR email IS NULL
        ");

        // Remove redundant gender column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back gender column
            $table->enum('gender', ['L', 'P'])->after('password');

            // Remove Laravel columns
            $table->dropColumn(['name', 'email', 'email_verified_at', 'remember_token']);
        });
    }
};
