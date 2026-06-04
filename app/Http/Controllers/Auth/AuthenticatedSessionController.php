<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses permintaan login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Jalankan proses autentikasi (cek email & password)
        $request->authenticate();

        // 2. Regenerasi session untuk keamanan
        $request->session()->regenerate();

        /**
         * 3. Redirect ke Dashboard dengan pesan sukses.
         * Pesan ini akan ditangkap oleh notifikasi estetik yang kita buat di dashboard.
         */
        return redirect()->intended(route('dashboard', absolute: false))
            ->with('success', 'Selamat Datang Kembali, ' . Auth::user()->name . '!');
    }

    /**
     * Memproses Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout!');
    }
}