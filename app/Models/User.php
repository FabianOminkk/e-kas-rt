<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Iuran;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi (Mass Assignment).
     * Pastikan 'telepon' sudah masuk di sini.
     */
    protected $fillable = [
        'nik',             // Tambahan
        'name',
        'email',
        'password',
        'role',            // Tambahan
        'alamat',          // Tambahan
        'tanggal_lahir',   // Tambahan
        'jenis_kelamin',   // Tambahan
        'no_telp',         // Tambahan
        'agama',           // Tambahan
        'tempat_lahir',    // Tambahan
        'status_pernikahan', // Tambahan
        'status_tinggal',   // Tambahan
        'foto_profil',     // Tambahan
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date', // Sebaiknya di-cast ke date agar mudah diatur formatnya
        ];
    }

    /**
     * Relasi ke tabel iurans.
     */
    public function iurans()
    {
        return $this->hasMany(Iuran::class, 'user_id');
    }

    /**
     * Relasi ke tabel asset_rentals.
     */
    public function assetRentals()
    {
        return $this->hasMany(AssetRental::class, 'user_id');
    }

    /**
     * Helper: Menentukan apakah warga ini rajin membayar kas tahun ini.
     * Syarat rajin: Warga sudah lunas kas sampai bulan berjalan atau minimal sudah membayar 4 bulan lunas di tahun ini.
     */
    public function isRajinBayarKas()
    {
        if ($this->role !== 'warga') {
            return false;
        }

        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Hitung berapa bulan di tahun berjalan yang sudah LUNAS
        $monthsPaidCount = $this->iurans()
            ->where('tahun', $currentYear)
            ->where('status', 'lunas')
            ->count();

        // Dianggap rajin jika iurannya lunas minimal sebanyak bulan berjalan,
        // atau jika sudah lunas setidaknya 4 bulan.
        return $monthsPaidCount >= $currentMonth || $monthsPaidCount >= 4;
    }

    /**
     * Fungsi pembantu untuk cek status bulan ini.
     * Digunakan untuk notifikasi jatuh tempo atau status LUNAS di dashboard.
     */
    public function statusIuranBulanIni()
    {
        return $this->iurans()
            ->where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->first();
    }
}