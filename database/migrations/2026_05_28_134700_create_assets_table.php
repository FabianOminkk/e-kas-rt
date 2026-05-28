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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->unique(); // AST-001, AST-002, dsb.
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah')->default(1);
            $table->integer('harga_beli');
            $table->date('tanggal_beli');
            $table->integer('estimasi_umur'); // dalam tahun
            $table->integer('harga_sewa'); // sewa per hari untuk warga non-aktif kas
            $table->string('status')->default('Baik'); // Baik, Rusak, Servis
            $table->date('jadwal_maintenance')->nullable(); // jadwal servis berikutnya
            $table->integer('biaya_maintenance')->default(0); // estimasi biaya servis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
