<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin Fabian',
            'email' => 'admin@kasrt.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Akun Bendahara
        User::create([
            'name' => 'Bendahara KAS',
            'email' => 'bendahara@kasrt.id',
            'password' => Hash::make('password123'),
            'role' => 'bendahara',
        ]);

        // 3. Akun Warga (Contoh)
        User::create([
            'name' => 'Bapak Budi',
            'email' => 'budi@kasrt.id',
            'password' => Hash::make('password123'),
            'role' => 'warga',
        ]);
    }
}