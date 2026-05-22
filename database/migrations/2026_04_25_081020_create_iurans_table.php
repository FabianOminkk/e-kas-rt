<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iurans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (Warga yang membayar iuran)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Detail waktu dan jumlah pembayaran iuran
            $table->integer('bulan');
            $table->year('tahun');
            $table->integer('nominal');
            
            // File bukti transfer dan status persetujuan (menunggu, lunas, belum_bayar)
            $table->string('bukti_transfer')->nullable();
            $table->string('status')->default('menunggu');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};