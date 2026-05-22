<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI
    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'nominal',
        'bukti_transfer',
        'status',
    ];

    // Jika kamu sudah punya relasi ke model User sebelumnya, biarkan saja
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}