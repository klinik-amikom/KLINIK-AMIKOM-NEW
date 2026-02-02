<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Order penting:
     * 1. Positions (tidak ada dependency)
     * 2. MasterIdentity (tidak ada dependency)
     * 3. Users (depends on: positions, master_identity)
     */
    public function run(): void
    {
        $this->call([
            PositionSeeder::class,
            MasterIdentitySeeder::class,
            UserSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('🎉 All seeders completed successfully!');
        $this->command->info('You can now login with the credentials above.');
    }
}
