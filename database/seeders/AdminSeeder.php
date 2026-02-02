<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'Admin',
            'username'=>'admin',
            'password' => Hash::make('password'),
            'kode' => 'ADM001',
            'level'=>'admin',
            'no_telp'=>'0812345678',
            'alamat'=>'lorem ipsum'
        ]);
    }
}
