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

        // ================= JURUS ANTI SYMLINK ERROR =================
        if ($request->filled('foto_profil_base64')) {
            $image_parts = explode(";base64,", $request->foto_profil_base64);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = time() . '_profil.jpg';

            // Simpan langsung ke folder 'public/profil' di direktori projekmu
            $destinationPath = public_path('profil');

            // Bikin foldernya otomatis kalau belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Hapus foto lama JIKA ada
            if ($user->foto_profil && file_exists(public_path('profil/' . $user->foto_profil))) {
                unlink(public_path('profil/' . $user->foto_profil));
            }

            // Simpan file foto baru
            file_put_contents($destinationPath . '/' . $fileName, $image_base64);
            
            // Simpan nama file ke database
            $user->foto_profil = $fileName;
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

        // Hapus foto profil sebelum akun dihapus
        if ($user->foto_profil && file_exists(public_path('profil/' . $user->foto_profil))) {
            unlink(public_path('profil/' . $user->foto_profil));
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}