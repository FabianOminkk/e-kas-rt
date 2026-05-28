<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'user_id',
        'jumlah_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keperluan',
        'biaya_sewa',
        'is_priority',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'is_priority' => 'boolean'
    ];

    /**
     * Relasi ke tabel users (Penyewa).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke tabel assets (Barang yang disewa).
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
