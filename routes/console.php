<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Artisan::command('generate:warga', function () {
    $this->info('Memperbarui NIK warga yang sudah ada...');
    
    // Update NIK untuk warga yang sudah terdaftar tapi NIK-nya kosong
    $existingWargas = User::where('role', 'warga')->whereNull('nik')->get();
    $updatedCount = 0;
    foreach ($existingWargas as $w) {
        $nik = '3275' . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
        while (User::where('nik', $nik)->exists()) {
            $nik = '3275' . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
        }
        $w->update(['nik' => $nik]);
        $updatedCount++;
    }
    $this->info("Berhasil memperbarui NIK {$updatedCount} warga lama.");

    $this->info('Memulai pembuatan 100 warga Indonesia random baru...');
    
    // Lists of names
    $maleFirstNames = ['Budi', 'Bambang', 'Joko', 'Hendra', 'Agus', 'Slamet', 'Adi', 'Susilo', 'Rudi', 'Wawan', 'Anton', 'Asep', 'Cecep', 'Dedi', 'Eko', 'Heri', 'Iwan', 'Kurniawan', 'Mulyadi', 'Nanang', 'Roni', 'Sigit', 'Ujang', 'Yanto', 'Yusuf', 'Aditya', 'Agung', 'Ahmad', 'Anwar', 'Arif', 'Bagus', 'Cahyo', 'Dani', 'Dwi', 'Faisal', 'Fajar', 'Guntur', 'Hari', 'Ihsan', 'Indra', 'Lukman', 'Maulana', 'Nugroho', 'Pratama', 'Ridwan', 'Saputra', 'Setiawan', 'Taufik', 'Wahyu', 'Rian', 'Bayu', 'Riza', 'Fikri', 'Hafiz', 'Surya', 'Tegar', 'Dimas', 'Reza', 'Rian', 'Fadli', 'Gilang', 'Rendra', 'Andre'];
    $femaleFirstNames = ['Sumarti', 'Ani', 'Siti', 'Rini', 'Dewi', 'Sri', 'Evi', 'Indah', 'Maria', 'Kartika', 'Ningsih', 'Lestari', 'Mega', 'Yuni', 'Dian', 'Fitri', 'Lilis', 'Ratna', 'Sari', 'Utami', 'Wulandari', 'Amalia', 'Anisa', 'Astuti', 'Cahyani', 'Damayanti', 'Farida', 'Gita', 'Haryati', 'Imas', 'Julia', 'Kusuma', 'Latifah', 'Maulida', 'Novita', 'Nurhasanah', 'Oktaviani', 'Permata', 'Rahmawati', 'Safitri', 'Suci', 'Tantri', 'Windasari', 'Yuliana', 'Rina', 'Novi', 'Santi', 'Ayu', 'Eka', 'Puspita', 'Intan', 'Fitria', 'Niken', 'Ratih', 'Putri', 'Siska', 'Diana', 'Ester', 'Maya'];
    
    $lastNames = ['Pratama', 'Saputra', 'Setiawan', 'Kurniawan', 'Wibowo', 'Nugroho', 'Hidayat', 'Lestari', 'Putri', 'Sari', 'Indah', 'Utami', 'Wijaya', 'Sanjaya', 'Budiman', 'Gunawan', 'Sutrisno', 'Hariyanto', 'Kusuma', 'Raharjo', 'Santoso', 'Subagyo', 'Susanto', 'Wahyudi', 'Yulianto', 'Fadilah', 'Siregar', 'Nasution', 'Ginting', 'Simanjuntak', 'Lubis', 'Sinaga', 'Harahap', 'Tanjung', 'Pohan', 'Pasaribu', 'Hasibuan', 'Sucipto', 'Hartono', 'Purnama', 'Kuswanto', 'Hidayatullah', 'Rahman', 'Sholeh'];

    $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 'Makassar', 'Yogyakarta', 'Palembang', 'Denpasar', 'Malang', 'Bogor', 'Tangerang', 'Bekasi', 'Solo', 'Cirebon', 'Banjarmasin', 'Pontianak', 'Samarinda', 'Manado', 'Ambon', 'Kupang', 'Mataram', 'Jayapura', 'Padang', 'Pekanbaru', 'Batam', 'Jambi', 'Bengkulu', 'Bandar Lampung', 'Pangkalpinang'];
    $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'];
    $streets = ['Jl. Mawar', 'Jl. Melati', 'Jl. Anggrek', 'Jl. Kamboja', 'Jl. Flamboyan', 'Jl. Dahlia', 'Jl. Cempaka', 'Jl. Kenanga', 'Jl. Sudirman', 'Jl. Gatot Subroto', 'Jl. MH Thamrin', 'Jl. Diponegoro', 'Jl. Gajah Mada', 'Jl. Hayam Wuruk', 'Gg. Kelinci', 'Gg. Damai', 'Gg. Bakti', 'Jl. Pahlawan', 'Jl. Merdeka', 'Jl. Pemuda'];
    $maritalStatuses = ['belum_menikah', 'sudah_menikah'];
    $stayStatuses = ['Pemilik', 'Sewa', 'Kos'];

    $count = 0;
    $generatedNames = [];

    while ($count < 100) {
        $gender = rand(0, 1) === 0 ? 'Laki-laki' : 'Perempuan';
        
        if ($gender === 'Laki-laki') {
            $firstName = $maleFirstNames[array_rand($maleFirstNames)];
        } else {
            $firstName = $femaleFirstNames[array_rand($femaleFirstNames)];
        }
        
        $lastName = $lastNames[array_rand($lastNames)];
        
        // Ensure name is fully random and reasonable
        $fullName = $firstName . ' ' . $lastName;
        
        // Skip duplicate names to keep it realistic
        if (in_array($fullName, $generatedNames)) {
            continue;
        }
        
        $generatedNames[] = $fullName;
        
        // Generate unique email based on name
        $emailBase = strtolower(str_replace(' ', '.', $fullName));
        $email = $emailBase . rand(10, 999) . '@kasrt.id';
        
        // Make sure email doesn't exist
        while (User::where('email', $email)->exists()) {
            $email = $emailBase . rand(1000, 9999) . '@kasrt.id';
        }
        
        // Birthdate (between 17 and 70 years ago)
        $ageYears = rand(17, 70);
        $birthDate = now()->subYears($ageYears)->subDays(rand(0, 365))->format('Y-m-d');
        
        // Phone number starting with '08' and fully numeric
        $phoneNum = '08' . rand(11, 29) . rand(10000000, 99999999);
        
        // Address
        $address = $streets[array_rand($streets)] . ' No. ' . rand(1, 150) . ', RT ' . sprintf('%02d', rand(1, 10)) . '/RW ' . sprintf('%02d', rand(1, 5));
        
        // Generate NIK starting with 3275 (16 digits)
        $nik = '3275' . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
        while (User::where('nik', $nik)->exists()) {
            $nik = '3275' . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
        }

        // Create User
        User::create([
            'nik' => $nik,
            'name' => $fullName,
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => 'warga',
            'alamat' => $address,
            'tanggal_lahir' => $birthDate,
            'jenis_kelamin' => $gender,
            'no_telp' => $phoneNum,
            'agama' => $religions[array_rand($religions)],
            'tempat_lahir' => $cities[array_rand($cities)],
            'status_pernikahan' => $maritalStatuses[array_rand($maritalStatuses)],
            'status_tinggal' => $stayStatuses[array_rand($stayStatuses)],
            'foto_profil' => null
        ]);
        
        $count++;
    }

    $this->info("Berhasil membuat {$count} warga Indonesia baru secara random!");
})->purpose('Membuat 100 warga Indonesia random untuk testing');
