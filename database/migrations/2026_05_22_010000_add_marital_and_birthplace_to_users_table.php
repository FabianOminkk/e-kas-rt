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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('users', 'status_pernikahan')) {
                $table->string('status_pernikahan')->nullable()->after('status_tinggal'); // 'belum_menikah', 'sudah_menikah'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tempat_lahir')) {
                $table->dropColumn('tempat_lahir');
            }
            if (Schema::hasColumn('users', 'status_pernikahan')) {
                $table->dropColumn('status_pernikahan');
            }
        });
    }
};
