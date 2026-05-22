<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Mengarah ke file resources/views/auth/register.blade.php
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'alamat' => ['required', 'string'],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    // 1. Simpan data warga ke database
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role' => 'warga', 
    ]);

    event(new \Illuminate\Auth\Events\Registered($user));

    // 2. JANGAN LOGIN OTOMATIS (Hapus baris Auth::login)
    
    // 3. Langsung arahkan kembali ke Login dengan pesan notifikasi
    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login dengan akun Anda.');
}
}