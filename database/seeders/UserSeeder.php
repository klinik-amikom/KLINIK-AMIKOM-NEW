<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seed users dengan 3 role:
     * - Admin: Full access ke sistem
     * - Dokter: Pemeriksaan dan resep (2 dokter: umum & gigi)
     * - Apoteker: Manajemen obat
     * 
     * Default password untuk semua user: "password"
     */
    public function run(): void
    {
        $users = [
            // Admin
            [
                'identity_id' => 1, // Ahmad Fauzi
                'name' => 'Ahmad Fauzi',
                'username' => 'admin',
                'email' => 'admin@klinik.amikom.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'position_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Dokter Umum
            [
                'identity_id' => 2, // Dr. Siti Nurhaliza
                'name' => 'Dr. Siti Nurhaliza',
                'username' => 'dr.siti',
                'email' => 'siti.nurhaliza@amikom.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'position_id' => 2, // Dokter
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Dokter Gigi
            [
                'identity_id' => 3, // drg. Budi Santoso
                'name' => 'drg. Budi Santoso',
                'username' => 'drg.budi',
                'email' => 'budi.santoso@amikom.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'position_id' => 2, // Dokter
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Apoteker
            [
                'identity_id' => 4, // Apt. Dewi Lestari
                'name' => 'Apt. Dewi Lestari',
                'username' => 'apt.dewi',
                'email' => 'dewi.lestari@klinik.amikom.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'position_id' => 3, // Apoteker
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);

        $this->command->info('✅ Users seeded successfully!');
        $this->command->newLine();
        $this->command->info('Login credentials (password: "password"):');
        $this->command->info('┌─────────────────────────────────────────────────┐');
        $this->command->info('│ Admin:                                          │');
        $this->command->info('│   Username: admin                               │');
        $this->command->info('│   Email: admin@klinik.amikom.ac.id              │');
        $this->command->info('├─────────────────────────────────────────────────┤');
        $this->command->info('│ Dokter Umum:                                    │');
        $this->command->info('│   Username: dr.siti                             │');
        $this->command->info('│   Email: siti.nurhaliza@amikom.ac.id            │');
        $this->command->info('├─────────────────────────────────────────────────┤');
        $this->command->info('│ Dokter Gigi:                                    │');
        $this->command->info('│   Username: drg.budi                            │');
        $this->command->info('│   Email: budi.santoso@amikom.ac.id              │');
        $this->command->info('├─────────────────────────────────────────────────┤');
        $this->command->info('│ Apoteker:                                       │');
        $this->command->info('│   Username: apt.dewi                            │');
        $this->command->info('│   Email: dewi.lestari@klinik.amikom.ac.id       │');
        $this->command->info('└─────────────────────────────────────────────────┘');
    }
}
