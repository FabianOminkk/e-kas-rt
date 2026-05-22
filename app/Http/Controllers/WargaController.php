<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User di-import

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Biasanya untuk menampilkan halaman daftar warga khusus (jika ada)
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Email tidak boleh dobel
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'required|string',
        ]);

        // 2. Simpan data ke database tabel users
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'), // Set password default untuk warga
            'role' => 'warga', // Otomatis jadikan role-nya 'warga'
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
        ]);

        // 3. Redirect kembali ke halaman dengan pesan sukses (memancing SweetAlert)
        return redirect()->back()->with('success', 'Data warga baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data warga berdasarkan ID, lalu hapus
        $warga = User::findOrFail($id);
        $warga->delete();

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Data warga berhasil dihapus!');
    }
}