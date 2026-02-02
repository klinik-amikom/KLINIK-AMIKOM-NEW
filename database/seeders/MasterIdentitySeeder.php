<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seed master_identity untuk sample users:
     * - 1 Admin (karyawan)
     * - 2 Dokter (dosen)
     * - 1 Apoteker (karyawan)
     */
    public function run(): void
    {
        $identities = [
            // Admin
            [
                'identity_number' => '198501012010',
                'identity_type' => 'karyawan',
                'name' => 'Ahmad Fauzi',
                'gender' => 'L',
                'address' => 'Jl. Ringroad Utara, Yogyakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Dokter Umum
            [
                'identity_number' => '198203151998',
                'identity_type' => 'dosen',
                'name' => 'Dr. Siti Nurhaliza',
                'gender' => 'P',
                'address' => 'Jl. Kaliurang KM 14, Sleman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Dokter Gigi
            [
                'identity_number' => '198707202005',
                'identity_type' => 'dosen',
                'name' => 'drg. Budi Santoso',
                'gender' => 'L',
                'address' => 'Jl. Seturan Raya, Sleman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Apoteker
            [
                'identity_number' => '199001052015',
                'identity_type' => 'karyawan',
                'name' => 'Apt. Dewi Lestari',
                'gender' => 'P',
                'address' => 'Jl. Affandi, Yogyakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('master_identity')->insert($identities);

        $this->command->info('✅ Master identities seeded successfully!');
        $this->command->info('   - 1 Admin (karyawan)');
        $this->command->info('   - 2 Dokter (dosen)');
        $this->command->info('   - 1 Apoteker (karyawan)');
    }
}
