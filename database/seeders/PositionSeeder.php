<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seed positions/roles untuk sistem klinik:
     * - Admin: Mengelola sistem, user management, laporan
     * - Dokter: Melakukan pemeriksaan, menulis resep
     * - Apoteker: Mengelola obat, memberikan obat sesuai resep
     */
    public function run(): void
    {
        $positions = [
            [
                'position' => 'Admin',
                'code' => 'ADM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position' => 'Dokter',
                'code' => 'DOK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position' => 'Apoteker',
                'code' => 'APT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('positions')->insert($positions);

        $this->command->info('✅ Positions seeded successfully!');
        $this->command->info('   - Admin (ADM)');
        $this->command->info('   - Dokter (DOK)');
        $this->command->info('   - Apoteker (APT)');
    }
}
