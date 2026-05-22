<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar Laravel mengizinkan penyimpanan data
    protected $fillable = [
        'judul',
        'isi'
    ];
}