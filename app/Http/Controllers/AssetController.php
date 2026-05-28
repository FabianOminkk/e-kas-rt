<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetRental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Menampilkan halaman Inventaris & Penyewaan Aset.
     */
    public function index()
    {
        $user = Auth::user();
        $assets = Asset::all();
        $rentals = [];

        // Inisialisasi summary keuangan buku kas depresiasi
        $totalHargaBeli = 0;
        $totalNilaiSekarang = 0;
        $totalDepresiasi = 0;

        if ($user->role === 'admin' || $user->role === 'bendahara') {
            // Urutkan pengajuan penyewaan 'menunggu' yang bertatus 'is_priority' (warga rajin) ke paling atas
            $rentals = AssetRental::with(['asset', 'user'])
                ->orderByRaw("
                    CASE 
                        WHEN status = 'menunggu' AND is_priority = 1 THEN 1
                        WHEN status = 'menunggu' AND is_priority = 0 THEN 2
                        ELSE 3
                    END ASC
                ")
                ->latest()
                ->get();

            // Hitung buku kas depresiasi aset komunal
            $totalHargaBeli = Asset::sum('harga_beli');
            $totalNilaiSekarang = Asset::get()->sum('current_value');
            $totalDepresiasi = $totalHargaBeli - $totalNilaiSekarang;

        } else {
            // Warga hanya melihat riwayat penyewaannya sendiri
            $rentals = AssetRental::where('user_id', $user->id)
                ->with('asset')
                ->latest()
                ->get();
        }

        return view('aset', compact('assets', 'rentals', 'totalHargaBeli', 'totalNilaiSekarang', 'totalDepresiasi'));
    }

    /**
     * Menyimpan data aset baru (Admin/Bendahara).
     */
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Otoritas tidak mencukupi.');
        }

        $validated = $request->validate([
            'kode_aset' => 'required|string|unique:assets,kode_aset',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_beli' => 'required|date',
            'estimasi_umur' => 'required|integer|min:1',
            'harga_sewa' => 'required|numeric|min:0',
            'jadwal_maintenance' => 'nullable|date',
            'biaya_maintenance' => 'nullable|numeric|min:0'
        ]);

        try {
            Asset::create([
                'kode_aset' => $validated['kode_aset'],
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'jumlah' => $validated['jumlah'],
                'harga_beli' => $validated['harga_beli'],
                'tanggal_beli' => $validated['tanggal_beli'],
                'estimasi_umur' => $validated['estimasi_umur'],
                'harga_sewa' => $validated['harga_sewa'],
                'status' => 'Baik',
                'jadwal_maintenance' => $validated['jadwal_maintenance'] ?? null,
                'biaya_maintenance' => $validated['biaya_maintenance'] ?? 0
            ]);

            return back()->with('success', 'Aset komunal baru berhasil didaftarkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan aset: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data aset (Admin/Bendahara).
     */
    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Otoritas tidak mencukupi.');
        }

        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'kode_aset' => 'required|string|unique:assets,kode_aset,' . $id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_beli' => 'required|date',
            'estimasi_umur' => 'required|integer|min:1',
            'harga_sewa' => 'required|numeric|min:0',
            'status' => 'required|string',
            'jadwal_maintenance' => 'nullable|date',
            'biaya_maintenance' => 'nullable|numeric|min:0'
        ]);

        try {
            $asset->update($validated);
            return back()->with('success', 'Data aset berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah data aset: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus aset (Admin).
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Hanya Admin utama yang boleh menghapus aset RT.');
        }

        try {
            $asset = Asset::findOrFail($id);
            $asset->delete();
            return back()->with('success', 'Aset komunal berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus aset: ' . $e->getMessage());
        }
    }

    /**
     * Mengirimkan permintaan sewa aset baru (Warga).
     */
    public function storeSewa(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string'
        ]);

        $asset = Asset::findOrFail($validated['asset_id']);
        $user = Auth::user();

        // Hitung total hari sewa
        $tglPinjam = Carbon::parse($validated['tanggal_pinjam']);
        $tglKembali = Carbon::parse($validated['tanggal_kembali']);
        $durasiHari = $tglPinjam->diffInDays($tglKembali) + 1;

        // Cek bentrok stok fisik barang
        $inUse = AssetRental::where('asset_id', $asset->id)
            ->whereIn('status', ['disetujui'])
            ->sum('jumlah_pinjam');

        if (($asset->jumlah - $inUse) < $validated['jumlah_pinjam']) {
            return back()->with('error', 'Gagal! Stok barang tidak mencukupi untuk disewa pada tanggal tersebut.');
        }

        // Terapkan diskon/prioritas berdasarkan status keaktifan bayar kas
        $isRajin = $user->isRajinBayarKas();
        $biayaSewa = 0;

        if ($isRajin) {
            // Warga rajin iuran: GRATIS (Diskon 100%) & PRIORITAS UTAMA
            $biayaSewa = 0;
            $isPriority = true;
        } else {
            // Warga non-aktif: Membayar sewa penuh & TANPA PRIORITAS
            $biayaSewa = $asset->harga_sewa * $validated['jumlah_pinjam'] * $durasiHari;
            $isPriority = false;
        }

        try {
            AssetRental::create([
                'asset_id' => $asset->id,
                'user_id' => $user->id,
                'jumlah_pinjam' => $validated['jumlah_pinjam'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'keperluan' => $validated['keperluan'],
                'biaya_sewa' => $biayaSewa,
                'is_priority' => $isPriority,
                'status' => 'menunggu'
            ]);

            $pesanSuccess = 'Permintaan sewa berhasil dikirim!';
            if ($isRajin) {
                $pesanSuccess .= ' Anda mendapatkan fasilitas GRATIS sewa & Prioritas karena aktif membayar Kas RT.';
            }

            return back()->with('success', $pesanSuccess);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengajukan penyewaan: ' . $e->getMessage());
        }
    }

    /**
     * Menyetujui konfirmasi sewa (Admin/Bendahara).
     */
    public function setujuSewa($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Otoritas tidak mencukupi.');
        }

        try {
            $rental = AssetRental::findOrFail($id);
            $asset = Asset::findOrFail($rental->asset_id);

            // Cek ketersediaan stok fisik sekali lagi sebelum approve
            $inUse = AssetRental::where('asset_id', $asset->id)
                ->where('status', 'disetujui')
                ->sum('jumlah_pinjam');

            if (($asset->jumlah - $inUse) < $rental->jumlah_pinjam) {
                return back()->with('error', 'Gagal! Stok barang saat ini tidak mencukupi untuk persetujuan sewa.');
            }

            $rental->update(['status' => 'disetujui']);
            return back()->with('success', 'Penyewaan aset disetujui! Barang siap dipinjam.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses persetujuan: ' . $e->getMessage());
        }
    }

    /**
     * Menolak konfirmasi sewa (Admin/Bendahara).
     */
    public function tolakSewa($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Otoritas tidak mencukupi.');
        }

        try {
            $rental = AssetRental::findOrFail($id);
            $rental->update(['status' => 'ditolak']);
            return back()->with('success', 'Pengajuan penyewaan ditolak.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak penyewaan: ' . $e->getMessage());
        }
    }

    /**
     * Menyelesaikan/mengembalikan aset sewa (Admin/Bendahara).
     */
    public function kembaliSewa($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Otoritas tidak mencukupi.');
        }

        try {
            $rental = AssetRental::findOrFail($id);
            $rental->update(['status' => 'selesai']);
            return back()->with('success', 'Penyewaan selesai! Barang telah dikembalikan ke inventaris RT dengan selamat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyelesaikan pengembalian: ' . $e->getMessage());
        }
    }
}
