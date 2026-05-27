<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Iuran; 
use App\Models\Announcement; 
use App\Models\Pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        
        $dataWarga = [];
        $announcements = Announcement::latest()->get(); 
        $tampilkanPengingat = false;
        $pendingPayments = []; 

        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];
        $chartTahunLabels = [];
        $chartTahunanPemasukan = [];
        $chartTahunanPengeluaran = [];

        $pemasukanBulanIni = 0;
        $pengeluaranBulanIni = 0;
        $pemasukanTahunIni = 0;
        $pengeluaranTahunIni = 0;
        $saldo = 0;

        if ($user->role === 'admin' || $user->role === 'bendahara') {
            
            // --- ALGORITMA SORTING DINAMIS WARGA LUNAS KE ATAS ---
            $bulanSekarang = now()->month;
            $tahunSekarang = now()->year;

            $dataWarga = User::where('role', 'warga')
                // Ambil data iuran khusus bulan dan tahun ini saja
                ->with(['iurans' => function($query) use ($bulanSekarang, $tahunSekarang) {
                    $query->where('bulan', $bulanSekarang)->where('tahun', $tahunSekarang);
                }])
                // Subquery untuk mengambil status iuran bulan ini untuk keperluan sorting (mencegah duplikasi join)
                ->addSelect([
                    'iuran_status' => Iuran::select('status')
                        ->whereColumn('user_id', 'users.id')
                        ->where('bulan', $bulanSekarang)
                        ->where('tahun', $tahunSekarang)
                        ->limit(1)
                ])
                ->orderByRaw("
                    CASE 
                        WHEN iuran_status = 'lunas' THEN 1 
                        WHEN iuran_status = 'menunggu' THEN 2 
                        ELSE 3 
                    END ASC
                ")
                ->get();
            // -----------------------------------------------------

            $pendingPayments = Iuran::with('user')
                ->where('status', 'menunggu') 
                ->latest()
                ->get();

            // --- REAL-TIME GRAPHIC PEMASUKAN vs PENGELUARAN (6 Bulan Terakhir) ---
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $chartLabels[] = $date->translatedFormat('M Y'); 
                
                $pemasukan = Iuran::where('status', 'lunas')
                    ->where('bulan', $date->month)
                    ->where('tahun', $date->year)
                    ->sum('nominal'); 
                
                $pengeluaran = Pengeluaran::whereMonth('tanggal', $date->month)
                    ->whereYear('tanggal', $date->year)
                    ->sum('nominal');
                
                $chartPemasukan[] = (int) $pemasukan;
                $chartPengeluaran[] = (int) $pengeluaran; 
            }

            // --- REAL-TIME GRAPHIC TAHUNAN ---
            for ($i = 3; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->year;
                $chartTahunLabels[] = (string) $year;
                
                $pemasukanTahunan = Iuran::where('status', 'lunas')
                    ->where('tahun', $year)
                    ->sum('nominal');

                $pengeluaranTahunan = Pengeluaran::whereYear('tanggal', $year)
                    ->sum('nominal');
                    
                $chartTahunanPemasukan[] = (int) $pemasukanTahunan;
                $chartTahunanPengeluaran[] = (int) $pengeluaranTahunan;
            }

            // --- RINGKASAN REAL-TIME UNTUK CARD ---
            $pemasukanBulanIni = (int) Iuran::where('status', 'lunas')
                ->where('bulan', now()->month)
                ->where('tahun', now()->year)
                ->sum('nominal');

            $pengeluaranBulanIni = (int) Pengeluaran::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('nominal');

            $pemasukanTahunIni = (int) Iuran::where('status', 'lunas')
                ->where('tahun', now()->year)
                ->sum('nominal');

            $pengeluaranTahunIni = (int) Pengeluaran::whereYear('tanggal', now()->year)
                ->sum('nominal');

            $saldo = $pemasukanTahunIni - $pengeluaranTahunIni;
        } 
        
        if ($user->role === 'warga') {
            $tampilkanPengingat = Iuran::where('user_id', $user->id)
                ->where('status', 'belum_bayar')
                ->exists();
        }

        return view('dashboard', [
            'dataWarga' => $dataWarga,
            'announcements' => $announcements,
            'tampilkanPengingat' => $tampilkanPengingat,
            'pendingPayments' => $pendingPayments,
            'chartLabels' => $chartLabels,
            'chartPemasukan' => $chartPemasukan,
            'chartPengeluaran' => $chartPengeluaran,
            'chartTahunLabels' => $chartTahunLabels,
            'chartTahunanPemasukan' => $chartTahunanPemasukan,
            'chartTahunanPengeluaran' => $chartTahunanPengeluaran,
            'pemasukanBulanIni' => $pemasukanBulanIni,
            'pengeluaranBulanIni' => $pengeluaranBulanIni,
            'pemasukanTahunIni' => $pemasukanTahunIni,
            'pengeluaranTahunIni' => $pengeluaranTahunIni,
            'saldo' => $saldo
        ]);
    }

    /**
     * Menampilkan Halaman Dompet Saya (Khusus Role Warga).
     */
    public function dompet(Request $request)
    {
        $user = $request->user();
        
        // Ambil semua riwayat pembayaran user ini, urutkan dari yang terbaru
        $riwayatPembayaran = Iuran::where('user_id', $user->id)
                                ->orderBy('tahun', 'desc')
                                ->orderBy('bulan', 'desc')
                                ->get();

        // Hitung total uang yang sudah dibayarkan tahun ini (status lunas)
        $totalTerbayarTahunIni = $riwayatPembayaran->where('tahun', now()->year)
                                                   ->where('status', 'lunas')
                                                   ->sum('nominal');

        // Hitung berapa bulan yang sudah lunas di tahun ini
        $bulanLunas = $riwayatPembayaran->where('tahun', now()->year)
                                        ->where('status', 'lunas')
                                        ->count();

        return view('dompet', compact('user', 'riwayatPembayaran', 'totalTerbayarTahunIni', 'bulanLunas'));
    }

    /**
     * Menambahkan data warga baru ke sistem (Khusus Admin/Bendahara).
     */
    public function storeWarga(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'nullable|string|min:12|max:16|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required', 
            'no_telp' => 'required|numeric', 
            'agama' => 'nullable',
            'tempat_lahir' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string',
            'status_tinggal' => 'nullable|string',
        ]);

        try {
            User::create([
                'nik' => $validated['nik'] ?? null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'alamat' => $validated['alamat'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_telp' => $validated['no_telp'],
                'agama' => $validated['agama'] ?? '-',
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'status_pernikahan' => $validated['status_pernikahan'] ?? null,
                'status_tinggal' => $validated['status_tinggal'] ?? null,
                'role' => 'warga',
            ]);

            // Sync total warga to GitHub README
            $this->syncTotalWargaToGitHub();

            return back()->with('success', 'Warga baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan warga: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data diri warga (Khusus Admin/Bendahara).
     */
    public function updateWarga(Request $request, $id)
    {
        $warga = User::findOrFail($id);

        $validated = $request->validate([
            'nik' => 'nullable|string|min:12|max:16|unique:users,nik,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6', 
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required', 
            'no_telp' => 'required|numeric', 
            'agama' => 'nullable',
            'tempat_lahir' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string',
            'status_tinggal' => 'nullable|string',
        ]);

        try {
            $warga->nik = $validated['nik'] ?? null;
            $warga->name = $validated['name'];
            $warga->email = $validated['email'];
            $warga->alamat = $validated['alamat'];
            $warga->tanggal_lahir = $validated['tanggal_lahir'];
            $warga->jenis_kelamin = $validated['jenis_kelamin'];
            $warga->no_telp = $validated['no_telp'];
            $warga->agama = $validated['agama'] ?? '-';
            $warga->tempat_lahir = $validated['tempat_lahir'] ?? null;
            $warga->status_pernikahan = $validated['status_pernikahan'] ?? null;
            $warga->status_tinggal = $validated['status_tinggal'] ?? null;
            
            if ($request->filled('password')) {
                $warga->password = Hash::make($validated['password']);
            }
            
            $warga->save();

            return back()->with('success', 'Data warga berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data warga secara permanen (Khusus Admin).
     */
    public function destroyWarga($id)
    {
        $warga = User::findOrFail($id);
        
        if ($warga->role !== 'warga') {
            return back()->with('error', 'Hanya data warga yang bisa dihapus!');
        }

        $warga->delete();

        // Sync total warga to GitHub README
        $this->syncTotalWargaToGitHub();
        
        return back()->with('success', 'Data warga berhasil dihapus!');
    }

    /**
     * Proses pengiriman/upload bukti transfer iuran kas (Oleh Warga).
     */
    public function storePembayaran(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer',
            'nominal' => 'required|numeric',
            'bukti_transfer' => 'required|file|image|max:2048', 
        ]);

        // Cegah warga membayar dua kali untuk bulan yang sama jika berstatus lunas atau menunggu
        $existing = Iuran::where('user_id', Auth::id())
            ->where('bulan', $request->bulan)
            ->where('tahun', now()->year)
            ->whereIn('status', ['lunas', 'menunggu'])
            ->first();

        if ($existing) {
            $statusText = $existing->status === 'lunas' ? 'LUNAS' : 'MENUNGGU PERSETUJUAN';
            return back()->with('error', "Pembayaran untuk bulan ini sudah ada dan berstatus: {$statusText}!");
        }

        $path = $request->file('bukti_transfer')->store('bukti_kas', 'public');

        Iuran::create([
            'user_id' => Auth::id(),
            'bulan' => $request->bulan,
            'tahun' => now()->year,
            'nominal' => $request->nominal,
            'bukti_transfer' => $path,
            'status' => 'menunggu', 
        ]);

        return back()->with('success', 'Bukti berhasil diupload! Menunggu persetujuan Admin.');
    }

    /**
     * Menyetujui konfirmasi iuran kas warga (Khusus Admin/Bendahara).
     */
    public function setujuPembayaran($id)
    {
        $pembayaran = Iuran::findOrFail($id);
        $pembayaran->update(['status' => 'lunas']); 

        return back()->with('success', 'Pembayaran disetujui! Kas RT telah bertambah.');
    }

    /**
     * Menolak konfirmasi iuran kas warga (Khusus Admin/Bendahara).
     */
    public function tolakPembayaran($id)
    {
        $pembayaran = Iuran::findOrFail($id);
        $pembayaran->update(['status' => 'belum_bayar']); 

        return back()->with('success', 'Pembayaran ditolak.');
    }

    /**
     * Mengunduh Laporan Keuangan format Dokumen Microsoft Word (.doc) atau PDF.
     */
    public function cetakLaporan(Request $request)
    {
        $format = $request->query('format', 'doc');
        
        $pemasukanBulanIni = Iuran::where('status', 'lunas')
            ->where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->sum('nominal');
            
        $pemasukanTahunIni = Iuran::where('status', 'lunas')
            ->where('tahun', now()->year)
            ->sum('nominal');
            
        $pengeluaranBulanIni = Pengeluaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');
            
        $pengeluaranTahunIni = Pengeluaran::whereYear('tanggal', now()->year)
            ->sum('nominal');
        
        $dataIuran = Iuran::with('user')
            ->where('status', 'lunas')
            ->where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->get();

        $dataPengeluaran = Pengeluaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->latest()
            ->get();
            
        $data = [
            'pemasukanBulanIni' => (int) $pemasukanBulanIni,
            'pemasukanTahunIni' => (int) $pemasukanTahunIni,
            'pengeluaranBulanIni' => (int) $pengeluaranBulanIni,
            'pengeluaranTahunIni' => (int) $pengeluaranTahunIni,
            'saldo' => (int) ($pemasukanTahunIni - $pengeluaranTahunIni),
            'dataIuran' => $dataIuran,
            'dataPengeluaran' => $dataPengeluaran
        ];

        if ($format === 'doc') {
            $html = view('laporan_cetak', $data)->render();
            return response($html)
                ->header('Content-Type', 'application/msword')
                ->header('Content-Disposition', 'attachment; filename="Laporan_Kas_RT_'.now()->format('F_Y').'.doc"');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('laporan_cetak', $data);
            return $pdf->download('Laporan_Kas_RT_'.now()->format('F_Y').'.pdf');
        }
        
        return back();
    }

    /**
     * Menyimpan data pengeluaran baru (Khusus Admin/Bendahara).
     */
    public function storePengeluaran(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Anda tidak memiliki otoritas akses untuk fitur ini.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        try {
            Pengeluaran::create($validated);
            return back()->with('success', 'Pengeluaran baru berhasil dicatat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat pengeluaran: ' . $e->getMessage());
        }
    }


    // =========================================================================
    // MODUL MANAJEMEN MADING INFORMASI RT (HANYA ADMIN & BENDAHARA)
    // =========================================================================

    /**
     * Membuat postingan informasi baru di Mading.
     */
    public function storeAnnouncement(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Anda tidak memiliki otoritas akses untuk fitur ini.');
        }
        
        $request->validate([
            'judul' => 'required|string|max:255', 
            'isi' => 'required|string'
        ]);
        
        // KITA UBAH BAGIAN INI (Jangan pakai $request->all())
        Announcement::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);
        
        return back()->with('success', 'Pengumuman baru berhasil diposting ke mading warga!');
    }

    /**
     * Mengubah isi informasi yang sudah terbit di Mading.
     */
    public function updateAnnouncement(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Anda tidak memiliki otoritas akses untuk mengubah fitur ini.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $pengumuman = Announcement::findOrFail($id);
        $pengumuman->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Informasi Mading berhasil diperbarui!');
    }

    /**
     * Menghapus secara permanen postingan informasi dari Mading.
     */
    public function destroyAnnouncement($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'bendahara'])) {
            return back()->with('error', 'Anda tidak memiliki otoritas akses untuk menghapus fitur ini.');
        }
        
        Announcement::findOrFail($id)->delete();
        
        return back()->with('success', 'Pengumuman berhasil dihapus dari mading warga!');
    }

    /**
     * Sinkronisasi jumlah warga ke README.md dan Push otomatis ke GitHub.
     */
    private function syncTotalWargaToGitHub()
    {
        try {
            $count = User::where('role', 'warga')->count();
            
            // 1. Update README.md
            $readmePath = base_path('README.md');
            if (file_exists($readmePath)) {
                $content = file_get_contents($readmePath);
                
                // Cari badge dan ganti nominalnya
                // Pola regex: /Total_Warga-\d+_Orang-purple/
                $pattern = '/Total_Warga-\d+_Orang-purple/';
                $replacement = 'Total_Warga-' . $count . '_Orang-purple';
                
                if (preg_match($pattern, $content)) {
                    $newContent = preg_replace($pattern, $replacement, $content);
                    file_put_contents($readmePath, $newContent);
                }
            }

            // 2. Jalankan perintah git push di background secara asynchronous
            $cwd = base_path();
            $commitMessage = "Auto-update: Total warga is now " . $count;
            
            // Menggunakan start /B di Windows agar tidak memblokir respon HTTP
            $command = 'git add README.md && git commit -m "' . $commitMessage . '" && start /B git push origin main';
            
            if (function_exists('exec')) {
                pclose(popen("cd /d " . escapeshellarg($cwd) . " && " . $command, "r"));
            }
        } catch (\Exception $e) {
            // Log error jika ada masalah, jangan memblokir UX utama
            logger()->error('Gagal melakukan sinkronisasi Git/GitHub: ' . $e->getMessage());
        }
    }
}