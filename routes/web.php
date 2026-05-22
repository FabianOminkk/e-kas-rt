<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Guest Routes (Halaman yang bisa diakses tanpa login)
Route::get('/', function () {
    return view('auth.login');
});

// 2. Authenticated Routes (Harus Login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dompet', [App\Http\Controllers\DashboardController::class, 'dompet'])->name('dompet.index');
// Route untuk Mading Informasi
Route::post('/announcement', [App\Http\Controllers\DashboardController::class, 'storeAnnouncement'])->name('announcement.store');
Route::patch('/announcement/{id}', [App\Http\Controllers\DashboardController::class, 'updateAnnouncement'])->name('announcement.update');
Route::delete('/announcement/{id}', [App\Http\Controllers\DashboardController::class, 'destroyAnnouncement'])->name('announcement.destroy');
    // --------------------------------------------------------
    // Dashboard & Manajemen Warga (Menggunakan DashboardController)
    // --------------------------------------------------------
    Route::controller(DashboardController::class)->group(function () {
        // Halaman Utama Dashboard
        Route::get('/dashboard', 'index')->name('dashboard');

        // CRUD Warga
        Route::post('/tambah-warga', 'storeWarga')->name('warga.store');
        Route::put('/warga/{id}', 'updateWarga')->name('warga.update');
        Route::delete('/warga/{id}', 'destroyWarga')->name('warga.destroy');
        
        // Pembayaran Iuran
        Route::post('/pembayaran/store', 'storePembayaran')->name('pembayaran.store');
        Route::patch('/pembayaran/{id}/setuju', 'setujuPembayaran')->name('pembayaran.setuju');
        Route::patch('/pembayaran/{id}/tolak', 'tolakPembayaran')->name('pembayaran.tolak');

        // Laporan
        Route::get('/laporan/cetak', 'cetakLaporan')->name('laporan.cetak');

        // Pencatatan Pengeluaran
        Route::post('/pengeluaran', 'storePengeluaran')->name('pengeluaran.store');
    });

    // --------------------------------------------------------
    // Profile Settings (Menggunakan ProfileController)
    // --------------------------------------------------------
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

});

// 3. Load Auth Routes (Login, Register, dsb)
require __DIR__.'/auth.php';