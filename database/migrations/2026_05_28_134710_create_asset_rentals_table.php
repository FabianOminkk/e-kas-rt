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
        Schema::create('asset_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('jumlah_pinjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->text('keperluan')->nullable();
            $table->integer('biaya_sewa')->default(0);
            $table->boolean('is_priority')->default(false); // true jika peminjam adalah warga aktif kas
            $table->string('status')->default('menunggu'); // menunggu, disetujui, ditolak, selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_rentals');
    }
};
