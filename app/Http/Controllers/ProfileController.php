<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'string'],
            'agama' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'status_tinggal' => ['nullable', 'string'],
            'foto_profil_base64' => ['nullable', 'string'], 
        ]);

        // ================= JURUS BASE64 DB SAVING =================
        if ($request->filled('foto_profil_base64')) {
            // Hapus file foto lama di local storage jika bukan base64 (opsional & aman)
            if ($user->foto_profil && !str_starts_with($user->foto_profil, 'data:image') && file_exists(public_path('profil/' . $user->foto_profil))) {
                @unlink(public_path('profil/' . $user->foto_profil));
            }
            
            // Simpan langsung string base64 ke database
            $user->foto_profil = $request->foto_profil_base64;
        }
        // ==========================================================

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->agama = $request->agama;
        $user->alamat = $request->alamat;
        $user->status_tinggal = $request->status_tinggal;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profil Berhasil Diperbarui!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus foto profil sebelum akun dihapus jika bukan base64
        if ($user->foto_profil && !str_starts_with($user->foto_profil, 'data:image') && file_exists(public_path('profil/' . $user->foto_profil))) {
            @unlink(public_path('profil/' . $user->foto_profil));
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}