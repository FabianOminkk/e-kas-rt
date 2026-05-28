<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_aset',
        'nama',
        'deskripsi',
        'jumlah',
        'harga_beli',
        'tanggal_beli',
        'estimasi_umur',
        'harga_sewa',
        'status',
        'jadwal_maintenance',
        'biaya_maintenance'
    ];

    protected $casts = [
        'tanggal_beli' => 'date',
        'jadwal_maintenance' => 'date',
    ];

    /**
     * Relasi ke tabel asset_rentals.
     */
    public function rentals()
    {
        return $this->hasMany(AssetRental::class, 'asset_id');
    }

    /**
     * Dynamic Attribute: Menghitung Nilai Aset Terdepresiasi (Straight-Line Depreciation).
     */
    public function getCurrentValueAttribute()
    {
        $tanggalBeli = Carbon::parse($this->tanggal_beli);
        $yearsElapsed = $tanggalBeli->diffInYears(Carbon::now());
        
        if ($yearsElapsed >= $this->estimasi_umur) {
            // Nilai sisa (salvage value) diset 5% dari harga beli
            return (int) ($this->harga_beli * 0.05);
        }

        $depresiasiPerTahun = $this->harga_beli / $this->estimasi_umur;
        $totalDepresiasi = $depresiasiPerTahun * $yearsElapsed;
        
        return (int) ($this->harga_beli - $totalDepresiasi);
    }

    /**
     * Dynamic Attribute: Menghitung Persentase Umur Aset yang Sudah Berjalan.
     */
    public function getLifespanPercentageAttribute()
    {
        $tanggalBeli = Carbon::parse($this->tanggal_beli);
        $yearsElapsed = $tanggalBeli->diffInYears(Carbon::now());
        
        if ($yearsElapsed >= $this->estimasi_umur) {
            return 100;
        }

        return (int) (($yearsElapsed / $this->estimasi_umur) * 100);
    }
}
