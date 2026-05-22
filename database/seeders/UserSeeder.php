<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Akun untuk Ketua RT (Admin)
    User::create([
        'name' => 'Ketua RT Fabian',
        'email' => 'admin@kasrt.id',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'alamat' => 'Blok A No. 1',
        'agama' => 'Islam',
        'jenis_kelamin' => 'Laki-laki',
        'tanggal_lahir' => '1990-01-01',
    ]);

    // Akun untuk Bendahara
    User::create([
        'name' => 'Bendahara Keuangan',
        'email' => 'bendahara@kasrt.id',
        'password' => Hash::make('password123'),
        'role' => 'bendahara',
        'alamat' => 'Blok B No. 5',
        'agama' => 'Islam',
        'jenis_kelamin' => 'Perempuan',
        'tanggal_lahir' => '1992-05-10',
    ]);

    // Akun untuk Warga
    User::create([
        'name' => 'Warga Teladan',
        'email' => 'warga@kasrt.id',
        'password' => Hash::make('password123'),
        'role' => 'warga',
        'alamat' => 'Blok C No. 12',
        'agama' => 'Kristen',
        'jenis_kelamin' => 'Laki-laki',
        'tanggal_lahir' => '1995-08-20',
    ]);
}
}