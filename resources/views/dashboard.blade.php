<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | {{ auth()->user()->role }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link class="rounded-full" rel="icon" type="image/png" href="{{ asset('images/abikun.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            if (savedTheme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>

    <style>
        :root {
            --bg-primary: #020617;
            --text-primary: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.4);
            --glass-sidebar: rgba(2, 44, 34, 0.8);
            --glass-card: rgba(255, 255, 255, 0.03);
            --border-color: rgba(255, 255, 255, 0.05);
            --sidebar-text-color: rgba(167, 243, 208, 0.5);
            --hover-bg: rgba(255, 255, 255, 0.05);
        }

        html.light-mode {
            --bg-primary: #f8fafc;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --glass-sidebar: rgba(240, 253, 250, 0.95);
            --glass-card: #ffffff;
            --border-color: rgba(226, 232, 240, 0.85);
            --sidebar-text-color: #047857;
            --hover-bg: rgba(16, 185, 129, 0.08);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-primary); 
            color: var(--text-primary); 
            margin: 0; 
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .glass-sidebar { 
            background: var(--glass-sidebar); 
            backdrop-filter: blur(20px); 
            border-right: 1px solid var(--border-color); 
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        
        .glass-card { 
            background: var(--glass-card); 
            backdrop-filter: blur(15px); 
            border: 1px solid var(--border-color); 
            position: relative; 
            z-index: 20; 
            transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .sidebar-container { width: 80px; transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); z-index: 50; }
        .sidebar-container:hover { width: 280px; }
        .sidebar-text { opacity: 0; white-space: nowrap; transition: opacity 0.3s ease; pointer-events: none; }
        .sidebar-container:hover .sidebar-text { opacity: 1; pointer-events: auto; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        .modal-bg { background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(8px); }
        
        /* Light Mode Specific Overrides */
        html.light-mode body {
            background-color: #f8fafc !important;
        }
        html.light-mode main {
            background-color: #f8fafc !important;
        }
        html.light-mode .text-white {
            color: #0f172a !important;
        }
        html.light-mode .bg-\[\#020617\] {
            background-color: #f8fafc !important;
        }
        html.light-mode .bg-slate-900, html.light-mode .bg-slate-950 {
            background-color: #ffffff !important;
        }
        html.light-mode .text-emerald-200\/50 {
            color: #047857 !important;
        }
        html.light-mode .text-emerald-400 {
            color: #059669 !important;
        }
        html.light-mode .sidebar-text p.text-white {
            color: #0f172a !important;
        }
        html.light-mode .sidebar-text p.text-emerald-500 {
            color: #059669 !important;
        }
        html.light-mode .border-white\/5, html.light-mode .border-white\/10 {
            border-color: rgba(226, 232, 240, 0.8) !important;
        }
        html.light-mode .text-white\/40, html.light-mode .text-white\/50, html.light-mode .text-white\/60, html.light-mode .text-emerald-200\/30 {
            color: #64748b !important;
        }
        html.light-mode .text-emerald-200\/80 {
            color: #047857 !important;
        }
        html.light-mode .bg-white\/5 {
            background-color: rgba(16, 185, 129, 0.08) !important;
        }
        html.light-mode .hover\:bg-white\/5:hover {
            background-color: rgba(16, 185, 129, 0.08) !important;
        }
        html.light-mode .hover\:bg-white\/10:hover {
            background-color: rgba(16, 185, 129, 0.12) !important;
        }
        html.light-mode .bg-emerald-500\/10 {
            background-color: rgba(16, 185, 129, 0.1) !important;
        }
        html.light-mode .bg-emerald-500\/20 {
            background-color: rgba(16, 185, 129, 0.15) !important;
        }
        html.light-mode .glass-card {
            box-shadow: 0 4px 20px -2px rgba(16, 24, 40, 0.05), 0 2px 12px -4px rgba(16, 24, 40, 0.03) !important;
        }
        html.light-mode tr.border-b {
            border-bottom-color: rgba(226, 232, 240, 0.8) !important;
        }
        html.light-mode tr:hover {
            background-color: rgba(16, 185, 129, 0.03) !important;
        }
        /* Mobile drawers in light mode */
        html.light-mode .border-emerald-500\/10 {
            border-color: rgba(16, 185, 129, 0.2) !important;
        }
        html.light-mode .bg-emerald-950\/20 {
            background-color: rgba(16, 185, 129, 0.05) !important;
        }
        html.light-mode .text-slate-400 {
            color: #475569 !important;
        }
        /* Inputs in modals */
        html.light-mode input, html.light-mode select, html.light-mode textarea {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }
        html.light-mode input:focus, html.light-mode select:focus, html.light-mode textarea:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
        }
        html.light-mode .modal-bg {
            background: rgba(15, 23, 42, 0.6) !important;
            backdrop-filter: blur(8px) !important;
        }
        html.light-mode .bg-slate-900\/90 {
            background-color: rgba(255, 255, 255, 0.95) !important;
            border-color: rgba(226, 232, 240, 0.8) !important;
        }
    </style>
</head>
<body class="antialiased">

    <div class="flex h-screen w-full overflow-hidden relative">
        
        {{-- SIDEBAR --}}
        <aside class="sidebar-container glass-sidebar flex flex-col p-4 group">
            <div class="mb-10 flex items-center gap-4 overflow-hidden px-2">
                <img src="{{ asset('images/abikun.png') }}" alt="Logo" class="min-w-[40px] w-10 h-10 rounded-xl object-cover shadow-lg border border-emerald-500/20">
                <div class="sidebar-text">
                    <h1 class="text-xl font-black tracking-tighter uppercase text-emerald-400 leading-none">Kas RT</h1>
                    <p class="text-white text-[8px] font-bold uppercase tracking-[0.3em]">Managed By Fabian</p>
                </div>
            </div>

            <nav class="flex-1 space-y-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('dashboard') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl shadow-lg transition-all">
                    <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-house"></i></div>
                    <span class="sidebar-text text-xs font-black uppercase tracking-widest">Dashboard</span>
                </a>
                
                @if(auth()->user()->role == 'warga')
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Ubah Profil</span>
                    </a>
                    <a href="{{ url('/dompet') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-wallet"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Dompet Saya</span>
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Setting Profil</span>
                    </a>
                    <a href="#database-warga" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-users"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Data Warga</span>
                    </a>
                @endif
            </nav>

            <div class="mt-auto pt-6 border-t border-white/5 overflow-hidden">
                <div class="flex items-center gap-4 mb-6 px-1">
                    @if(auth()->user()->foto_profil)
                        <img src="{{ asset('profil/' . auth()->user()->foto_profil) }}" alt="Avatar" class="min-w-[40px] w-10 h-10 rounded-full object-cover border-2 border-emerald-500/50 shadow-lg">
                    @else
                        <div class="min-w-[40px] h-10 rounded-full bg-emerald-500/20 border border-emerald-500/50 flex items-center justify-center text-emerald-400 font-black uppercase shadow-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="sidebar-text">
                        <p class="text-[10px] font-black text-white truncate uppercase">{{ auth()->user()->name }}</p>
                        <p class="text-[8px] text-emerald-500 font-bold uppercase">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                
                {{-- THEME TOGGLE BUTTON --}}
                <button type="button" onclick="toggleTheme()" class="theme-toggle-btn w-full flex items-center gap-4 px-3 py-3 mb-3 bg-white/5 border border-white/10 text-emerald-400 rounded-xl hover:bg-emerald-500 hover:text-white transition-all shadow-lg">
                    <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-moon theme-toggle-icon"></i></div>
                    <span class="sidebar-text text-[10px] font-black uppercase tracking-widest theme-toggle-text">Mode Gelap</span>
                </button>

                <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-4 px-3 py-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                    <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-right-from-bracket"></i></div>
                    <span class="sidebar-text text-[10px] font-black uppercase tracking-widest">Logout</span>
                </button>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;"> @csrf </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto bg-[#020617] p-8">
            <div class="max-w-[96rem] mx-auto w-full px-4 md:px-6">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">E-KAS</h2>
                        <p class="text-emerald-500/40 text-[10px] font-bold uppercase tracking-[0.4em]">ADA UNTUK KITA</p>
                    </div>
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                        <div class="flex gap-3">
                            <button onclick="bukaModalPengeluaran()" class="px-5 py-3 bg-red-500 text-white text-xs font-black uppercase rounded-xl shadow-lg hover:scale-105 hover:bg-red-600 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Pengeluaran
                            </button>
                            <button onclick="toggleModal()" class="px-5 py-3 bg-emerald-500 text-[#022c22] text-xs font-black uppercase rounded-xl shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-user-plus"></i> Warga
                            </button>
                        </div>
                    @endif
                </div>

                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                {{-- RINGKASAN KAS & LAPORAN --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    {{-- CARD PEMASUKAN --}}
                    <div class="glass-card rounded-3xl p-6 border-l-4 border-emerald-500 overflow-hidden shadow-2xl">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-[10px] text-emerald-400/60 font-black uppercase tracking-wider">Pemasukan Bulan Ini</p>
                                <h3 class="text-2xl font-black text-white mt-1">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 shadow-inner">
                                <i class="fa-solid fa-arrow-trend-up text-lg"></i>
                            </div>
                        </div>
                        <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider">Tahun Ini: Rp {{ number_format($pemasukanTahunIni, 0, ',', '.') }}</p>
                    </div>

                    {{-- CARD PENGELUARAN --}}
                    <div class="glass-card rounded-3xl p-6 border-l-4 border-red-500 overflow-hidden shadow-2xl">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-[10px] text-red-400/60 font-black uppercase tracking-wider">Pengeluaran Bulan Ini</p>
                                <h3 class="text-2xl font-black text-white mt-1">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-400 shadow-inner">
                                <i class="fa-solid fa-arrow-trend-down text-lg"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider">Tahun Ini: Rp {{ number_format($pengeluaranTahunIni, 0, ',', '.') }}</p>
                            <button onclick="bukaModalPengeluaran()" class="text-[9px] font-black text-red-400 hover:text-red-300 transition-all uppercase flex items-center gap-1">
                                <i class="fa-solid fa-plus"></i> Catat
                            </button>
                        </div>
                    </div>

                    {{-- CARD SALDO KAS --}}
                    <div class="glass-card rounded-3xl p-6 border-l-4 border-blue-500 overflow-hidden shadow-2xl">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-[10px] text-blue-400/60 font-black uppercase tracking-wider">Saldo Kas Saat Ini</p>
                                <h3 class="text-2xl font-black text-white mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 shadow-inner">
                                <i class="fa-solid fa-wallet text-lg"></i>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('laporan.cetak', ['format' => 'pdf']) }}" class="flex-1 py-2.5 bg-emerald-500 text-black text-[9px] font-black tracking-widest text-center uppercase rounded-xl hover:bg-emerald-400 transition-all flex items-center justify-center gap-1.5 shadow-lg shadow-emerald-500/20">
                                <i class="fa-solid fa-file-pdf text-xs"></i> PDF
                            </a>
                            <a href="{{ route('laporan.cetak', ['format' => 'doc']) }}" class="flex-1 py-2.5 bg-blue-600 text-white text-[9px] font-black tracking-widest text-center uppercase rounded-xl hover:bg-blue-500 transition-all flex items-center justify-center gap-1.5 shadow-lg shadow-blue-600/20">
                                <i class="fa-solid fa-file-word text-xs"></i> Word
                            </a>
                        </div>
                    </div>
                </div>

                {{-- GRAFIK REAL-TIME --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- GRAFIK BULANAN --}}
                    <div class="glass-card rounded-3xl p-6 border border-emerald-500/10 shadow-2xl">
                        <h4 class="text-xs font-black text-emerald-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-sm"></i> Cash Flow Bulanan (6 Bulan Terakhir)
                        </h4>
                        <div class="h-64 relative">
                            <canvas id="chartBulanan"></canvas>
                        </div>
                    </div>

                    {{-- GRAFIK TAHUNAN --}}
                    <div class="glass-card rounded-3xl p-6 border border-blue-500/10 shadow-2xl">
                        <h4 class="text-xs font-black text-blue-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-chart-bar text-sm"></i> Perbandingan Kas Tahunan
                        </h4>
                        <div class="h-64 relative">
                            <canvas id="chartTahunan"></canvas>
                        </div>
                    </div>
                </div>
                @endif


                {{-- NOTIFIKASI PERSETUJUAN (HANYA ADMIN) --}}
                @if(auth()->user()->role == 'bendahara' || auth()->user()->role == 'admin')
                <div class="glass-card rounded-3xl p-6 mb-8 border-l-4 border-yellow-500 animate-fade-in">
                    <h4 class="text-yellow-500 font-black text-xs uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left"></i> Menunggu Persetujuan Pembayaran
                    </h4>
                    <div class="space-y-3">
                        @forelse($pendingPayments ?? [] as $pembayaran)
                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-500/20 flex items-center justify-center text-yellow-500 text-xs">
                                        <i class="fa-solid fa-file-invoice-dollar"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-white uppercase">{{ $pembayaran->user->name ?? 'Warga' }}</p>
                                        <p class="text-[8px] text-white/40 uppercase">Bulan: {{ $pembayaran->bulan }} {{ $pembayaran->tahun }} - Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="lihatBukti('{{ asset('storage/' . $pembayaran->bukti_transfer) }}')" class="px-3 py-2 bg-blue-500/20 text-blue-400 text-[9px] font-black rounded-lg border border-blue-500/30 hover:bg-blue-500 hover:text-white transition-all uppercase">BUKTI</button>
                                    <form action="{{ route('pembayaran.setuju', $pembayaran->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-emerald-500 text-black text-[9px] font-black rounded-lg hover:bg-emerald-400 transition-all uppercase">SETUJU</button>
                                    </form>
                                    <form action="{{ route('pembayaran.tolak', $pembayaran->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-500 text-[9px] font-black rounded-lg border border-red-500/30 hover:bg-red-500 hover:text-white transition-all uppercase">TOLAK</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-[10px] text-white/20 italic uppercase text-center py-4">Tidak ada permintaan persetujuan baru</p>
                        @endforelse
                    </div>
                </div>
                @endif

                {{-- MADING INFORMASI --}}
                <div class="glass-card rounded-3xl p-8 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-blue-400 font-black text-xl uppercase tracking-tighter flex items-center gap-3">
                            <i class="fa-solid fa-bullhorn text-lg"></i> Mading Informasi RT
                        </h3>
                        
                        {{-- TOMBOL TAMBAH PENGUMUMAN (KHUSUS ADMIN) --}}
                        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                        <button onclick="bukaModalTambahMading()" class="px-5 py-2.5 bg-blue-500/10 border border-blue-500/30 text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-lg">
                            + Tambah Pengumuman
                        </button>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($announcements as $pengumuman)
                            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-all relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-16 h-16 bg-blue-500/10 rounded-bl-full flex justify-end items-start p-2"><i class="fa-solid fa-thumbtack text-blue-500 text-xs"></i></div>
                                
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-emerald-400 font-black text-sm uppercase tracking-widest w-3/4">{{ $pengumuman->judul }}</h4>
                                    
                                    {{-- AKSI EDIT & HAPUS (KHUSUS ADMIN) --}}
                                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                                    <div class="flex gap-2 relative z-10">
                                        <button onclick="bukaModalEditMading('{{ $pengumuman->id }}', '{{ addslashes($pengumuman->judul) }}', `{{ addslashes($pengumuman->isi) }}`)" class="text-emerald-500/70 hover:text-emerald-400 transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <form action="{{ route('announcement.destroy', $pengumuman->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500/70 hover:text-red-400 transition-all"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                <p class="text-white/70 text-xs leading-relaxed mb-4">{{ $pengumuman->isi }}</p>
                                <span class="text-white/30 text-[9px] font-bold uppercase tracking-widest"><i class="fa-regular fa-calendar mr-1"></i> {{ $pengumuman->created_at->format('d M Y') }}</span>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 text-center py-8 bg-white/5 border border-white/10 rounded-2xl">
                                <i class="fa-regular fa-folder-open text-3xl text-white/20 mb-3"></i>
                                <p class="text-white/40 text-xs font-bold uppercase tracking-widest">Belum Ada Pengumuman</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- DATABASE WARGA --}}
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                <div id="database-warga" class="glass-card rounded-3xl p-8 scroll-mt-8">
                    <h3 class="text-emerald-400 font-black text-xl uppercase tracking-tighter mb-6 flex items-center gap-3"><i class="fa-solid fa-users text-lg"></i> Database Warga RT</h3>
                    <div class="overflow-x-auto hidden md:block">
                        <table class="w-full text-center">
                            <thead>
                                <tr class="text-emerald-200/20 text-xs uppercase tracking-wider border-b border-white/5 whitespace-nowrap">
                                    <th class="pb-4 text-left pl-4">Warga / NIK</th>
                                    <th class="pb-4">Gender</th>
                                    <th class="pb-4 text-left">Tempat, Tgl Lahir</th>
                                    <th class="pb-4">No. Telp</th>
                                    <th class="pb-4">Agama</th>
                                    <th class="pb-4 text-left">Alamat & Tinggal</th>
                                    <th class="pb-4">Status Pernikahan</th>
                                    <th class="pb-4">Status Kas</th>
                                    <th class="pb-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-white/60 text-sm">
                                @foreach($dataWarga as $warga)
                                <tr class="border-b border-white/5 hover:bg-white/[0.02]">
                                    <td class="py-4 text-left whitespace-nowrap pl-4">
                                        <div class="flex items-center gap-3">
                                            @if($warga->foto_profil)
                                                <img src="{{ asset('profil/' . $warga->foto_profil) }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-emerald-500/50 shadow-md">
                                            @else
                                                <div class="w-9 h-9 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-sm font-black uppercase shadow-md">
                                                    {{ substr($warga->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="flex flex-col">
                                                <span class="font-bold text-white text-sm leading-tight">{{ $warga->name }}</span>
                                                <span class="font-mono text-xs text-white/40 tracking-wider mt-0.5">NIK: {{ $warga->nik ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-xs whitespace-nowrap">
                                        @if($warga->jenis_kelamin === 'Laki-laki')
                                            <span class="px-2.5 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded-md font-semibold text-xs">Laki-laki</span>
                                        @elseif($warga->jenis_kelamin === 'Perempuan')
                                            <span class="px-2.5 py-1 bg-pink-500/10 text-pink-400 border border-pink-500/20 rounded-md font-semibold text-xs">Perempuan</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-white/10 text-white/50 rounded-md font-semibold text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-left whitespace-nowrap text-sm text-white/80">
                                        @if($warga->tempat_lahir)
                                            {{ $warga->tempat_lahir }}, 
                                        @endif
                                        {{ $warga->tanggal_lahir ? $warga->tanggal_lahir->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 text-sm font-mono text-white/80 whitespace-nowrap">{{ $warga->no_telp }}</td>
                                    <td class="py-4 text-sm text-white/80 whitespace-nowrap capitalize">{{ $warga->agama ?? '-' }}</td>
                                    <td class="py-4 text-left text-sm text-white/80">
                                        <div class="font-semibold text-white">{{ $warga->alamat }}</div>
                                        <div class="mt-1">
                                            @if($warga->status_tinggal === 'Kos')
                                                <span class="text-[10px] px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded-md font-bold uppercase tracking-wider">KOS</span>
                                            @elseif($warga->status_tinggal === 'Pemilik' || $warga->status_tinggal === 'Sewa')
                                                <span class="text-[10px] px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded-md font-bold uppercase tracking-wider">RUMAH</span>
                                            @else
                                                <span class="text-[10px] px-2 py-0.5 bg-white/10 text-white/50 rounded-md font-bold uppercase tracking-wider">Belum Set</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 text-xs whitespace-nowrap">
                                        @if($warga->status_pernikahan === 'sudah_menikah')
                                            <span class="px-2.5 py-1 bg-purple-500/20 text-purple-400 rounded-md font-black uppercase text-[10px] tracking-wider">SUDAH MENIKAH</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-slate-500/20 text-slate-400 rounded-md font-black uppercase text-[10px] tracking-wider">BELUM MENIKAH</span>
                                        @endif
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        @php
                                            $iuranBulanIni = $warga->iurans->first();
                                            $status = $iuranBulanIni ? $iuranBulanIni->status : 'belum_bayar';
                                        @endphp
                                        @if($status === 'lunas')
                                            <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-black rounded-md uppercase tracking-wider">LUNAS</span>
                                        @elseif($status === 'menunggu')
                                            <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-[10px] font-black rounded-md uppercase tracking-wider">DIPROSES</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-500/20 text-red-400 text-[10px] font-black rounded-md uppercase tracking-wider">BELUM BAYAR</span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        <div class="flex justify-center gap-3">
                                            <button onclick="bukaModalEditWarga('{{ $warga->id }}', '{{ $warga->nik }}', '{{ addslashes($warga->name) }}', '{{ $warga->email }}', '{{ $warga->no_telp }}', '{{ $warga->tanggal_lahir ? $warga->tanggal_lahir->format('Y-m-d') : '' }}', '{{ $warga->jenis_kelamin }}', '{{ addslashes($warga->agama) }}', '{{ addslashes($warga->alamat) }}', '{{ addslashes($warga->tempat_lahir) }}', '{{ $warga->status_tinggal }}', '{{ $warga->status_pernikahan }}')" class="text-blue-500/70 hover:text-blue-400 transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini secara permanen?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500/70 hover:text-red-400 transition-all"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tampilan Warga Versi Mobile (Laci/Accordion Drawer) -->
                    <div class="block md:hidden space-y-4">
                        @foreach($dataWarga as $warga)
                        <div class="mobile-warga-card group relative glass-card rounded-2xl p-4 border border-white/5 transition-all duration-300 hover:border-emerald-500/30 hover:bg-emerald-950/10 cursor-pointer overflow-hidden" data-warga-id="{{ $warga->id }}">
                            <!-- Card Header (Always Visible) -->
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    @if($warga->foto_profil)
                                        <img src="{{ asset('profil/' . $warga->foto_profil) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-emerald-500/50 shadow-md">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-sm font-black uppercase shadow-md">
                                            {{ substr($warga->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col">
                                        <span class="font-bold text-white text-sm leading-tight">{{ $warga->name }}</span>
                                        <span class="font-mono text-[10px] text-white/40 tracking-wider mt-0.5">NIK: {{ $warga->nik ?? '-' }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    @php
                                        $iuranBulanIni = $warga->iurans->first();
                                        $status = $iuranBulanIni ? $iuranBulanIni->status : 'belum_bayar';
                                    @endphp
                                    @if($status === 'lunas')
                                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-black rounded-md uppercase tracking-wider">LUNAS</span>
                                    @elseif($status === 'menunggu')
                                        <span class="px-2.5 py-0.5 bg-yellow-500/20 text-yellow-400 text-[9px] font-black rounded-md uppercase tracking-wider">DIPROSES</span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-red-500/20 text-red-400 text-[9px] font-black rounded-md uppercase tracking-wider">BELUM BAYAR</span>
                                    @endif
                                    
                                    <!-- Chevron Indicator -->
                                    <i class="fa-solid fa-chevron-down text-white/40 text-xs transition-transform duration-300 group-hover:rotate-180 group-[.active-drawer]:rotate-180"></i>
                                </div>
                            </div>

                            <!-- Card Content (Collapsible Drawer) -->
                            <div class="mobile-warga-drawer overflow-hidden max-h-0 opacity-0 transition-all duration-500 ease-in-out group-hover:max-h-[500px] group-hover:opacity-100 group-[.active-drawer]:max-h-[500px] group-[.active-drawer]:opacity-100">
                                <div class="mt-4 pt-4 border-t border-white/5 space-y-3 text-xs text-white/70">
                                    <!-- Grid details -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <span class="text-[9px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Gender</span>
                                            @if($warga->jenis_kelamin === 'Laki-laki')
                                                <span class="text-blue-400 font-semibold"><i class="fa-solid fa-mars mr-1"></i> Laki-laki</span>
                                            @elseif($warga->jenis_kelamin === 'Perempuan')
                                                <span class="text-pink-400 font-semibold"><i class="fa-solid fa-venus mr-1"></i> Perempuan</span>
                                            @else
                                                <span class="text-white/50">-</span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-[9px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Agama</span>
                                            <span class="text-white font-semibold capitalize">{{ $warga->agama ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="col-span-2">
                                            <span class="text-[9px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Tempat, Tgl Lahir</span>
                                            <span class="text-white font-semibold">
                                                @if($warga->tempat_lahir)
                                                    {{ $warga->tempat_lahir }}, 
                                                @endif
                                                {{ $warga->tanggal_lahir ? $warga->tanggal_lahir->translatedFormat('d M Y') : '-' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <span class="text-[9px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">No. Telp</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $warga->no_telp) }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 transition-all font-mono font-semibold flex items-center gap-1">
                                                <i class="fa-brands fa-whatsapp text-sm"></i> {{ $warga->no_telp }}
                                            </a>
                                        </div>
                                        <div>
                                            <span class="text-[9px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Status Pernikahan</span>
                                            @if($warga->status_pernikahan === 'sudah_menikah')
                                                <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded-md font-black uppercase text-[9px] tracking-wider inline-block">SUDAH MENIKAH</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-slate-500/20 text-slate-400 rounded-md font-black uppercase text-[9px] tracking-wider inline-block">BELUM MENIKAH</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <span class="text-[9px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Alamat & Status Tinggal</span>
                                        <div class="text-white font-semibold">{{ $warga->alamat }}</div>
                                        <div class="mt-1">
                                            @if($warga->status_tinggal === 'Kos')
                                                <span class="text-[9px] px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded-md font-bold uppercase tracking-wider inline-block">KOS</span>
                                            @elseif($warga->status_tinggal === 'Pemilik' || $warga->status_tinggal === 'Sewa')
                                                <span class="text-[9px] px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded-md font-bold uppercase tracking-wider inline-block">RUMAH ({{ $warga->status_tinggal }})</span>
                                            @else
                                                <span class="text-[9px] px-2 py-0.5 bg-white/10 text-white/50 rounded-md font-bold uppercase tracking-wider inline-block">Belum Set</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="pt-4 border-t border-white/5 flex justify-end gap-3">
                                        <button onclick="bukaModalEditWarga('{{ $warga->id }}', '{{ $warga->nik }}', '{{ addslashes($warga->name) }}', '{{ $warga->email }}', '{{ $warga->no_telp }}', '{{ $warga->tanggal_lahir ? $warga->tanggal_lahir->format('Y-m-d') : '' }}', '{{ $warga->jenis_kelamin }}', '{{ addslashes($warga->agama) }}', '{{ addslashes($warga->alamat) }}', '{{ addslashes($warga->tempat_lahir) }}', '{{ $warga->status_tinggal }}', '{{ $warga->status_pernikahan }}')" class="px-4 py-2 bg-blue-500/10 border border-blue-500/30 text-blue-400 hover:bg-blue-500 hover:text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-1.5 shadow-lg">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                        <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-1.5 shadow-lg">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                </div>
                @endif
            </div>
        </main>
    </div>
    
    {{-- MODAL TAMBAH MADING --}}
    <div id="modalTambahMading" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4 py-8">
        <div class="glass-card w-full max-w-md rounded-[2.5rem] p-8 border border-blue-500/30">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-blue-400 font-black text-xl uppercase italic tracking-tighter">Tambah Pengumuman</h3>
                <button onclick="tutupModalTambahMading()" class="text-white/20 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('announcement.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest block mb-1">Judul Pengumuman</label>
                    <input type="text" name="judul" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-blue-500 text-white">
                </div>
                <div>
                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest block mb-1">Isi Pesan</label>
                    <textarea name="isi" required rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-blue-500 text-white"></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-widest rounded-2xl shadow-lg hover:scale-[1.02] transition-all">Posting Pengumuman</button>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT MADING --}}
    <div id="modalEditMading" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4 py-8">
        <div class="glass-card w-full max-w-md rounded-[2.5rem] p-8 border border-emerald-500/30">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-emerald-400 font-black text-xl uppercase italic tracking-tighter">Edit Pengumuman</h3>
                <button onclick="tutupModalEditMading()" class="text-white/20 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formEditMading" action="" method="POST" class="space-y-4">
                @csrf @method('PATCH')
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Judul Pengumuman</label>
                    <input type="text" id="edit_mading_judul" name="judul" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                </div>
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Isi Pesan</label>
                    <textarea id="edit_mading_isi" name="isi" required rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white"></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-[#022c22] font-black uppercase tracking-widest rounded-2xl shadow-lg hover:scale-[1.02] transition-all">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- MODAL TAMBAH PENGELUARAN --}}
    <div id="modalTambahPengeluaran" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4 py-8">
        <div class="glass-card w-full max-w-md rounded-[2.5rem] p-8 border border-red-500/30">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-red-400 font-black text-xl uppercase italic tracking-tighter">Catat Pengeluaran Kas</h3>
                <button onclick="tutupModalPengeluaran()" class="text-white/20 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('pengeluaran.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-red-400 uppercase tracking-widest block mb-1">Nama Pengeluaran / Keperluan</label>
                    <input type="text" name="judul" required placeholder="Contoh: Pembelian Sapu & Ember" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-red-500 text-white">
                </div>
                <div>
                    <label class="text-[10px] font-black text-red-400 uppercase tracking-widest block mb-1">Nominal (Rp)</label>
                    <input type="number" name="nominal" required min="0" placeholder="Contoh: 150000" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-red-500 text-white">
                </div>
                <div>
                    <label class="text-[10px] font-black text-red-400 uppercase tracking-widest block mb-1">Tanggal Keperluan</label>
                    <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-red-500 text-white">
                </div>
                <div>
                    <label class="text-[10px] font-black text-red-400 uppercase tracking-widest block mb-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" rows="3" placeholder="Opsional" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-red-500 text-white"></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-red-600 hover:bg-red-500 text-white font-black uppercase tracking-widest rounded-2xl shadow-lg hover:scale-[1.02] transition-all">Simpan Pengeluaran</button>
            </form>
        </div>
    </div>

    {{-- MODAL TAMBAH WARGA --}}
    <div id="modalTambahWarga" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4 py-8 overflow-y-auto">
        <div class="glass-card w-full max-w-lg rounded-[2.5rem] p-8 border border-emerald-500/30 my-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-emerald-400 font-black text-xl uppercase italic tracking-tighter">Tambah Warga Baru</h3>
                <button onclick="toggleModal()" class="text-white/20 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('warga.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" name="nik" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white" placeholder="Contoh: 32751927410182" pattern="[0-9]{12,16}">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Email</label>
                        <input type="email" name="email" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Password</label>
                        <input type="password" name="password" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Nomor Telepon</label>
                        <input type="text" name="no_telp" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white" placeholder="Contoh: Jakarta">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Agama</label>
                        <input type="text" name="agama" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white" placeholder="Contoh: Islam">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Alamat Rumah</label>
                        <input type="text" name="alamat" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white" placeholder="Contoh: Blok A No. 12">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Status Tempat Tinggal</label>
                        <select name="status_tinggal" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                            <option value="Pemilik">Pemilik Rumah (Rumah)</option>
                            <option value="Sewa">Sewa / Kontrak (Rumah)</option>
                            <option value="Kos">Ngekos (Kos)</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Status Pernikahan</label>
                        <select name="status_pernikahan" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                            <option value="belum_menikah">Belum Menikah</option>
                            <option value="sudah_menikah">Sudah Menikah</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-[#022c22] font-black uppercase tracking-widest rounded-2xl shadow-lg hover:scale-[1.02] transition-all mt-4">Daftarkan Warga</button>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT WARGA --}}
    <div id="modalEditWarga" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4 py-8 overflow-y-auto">
        <div class="glass-card w-full max-w-lg rounded-[2.5rem] p-8 border border-emerald-500/30 my-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-emerald-400 font-black text-xl uppercase italic tracking-tighter">Edit Data Warga</h3>
                <button onclick="tutupModalEditWarga()" class="text-white/20 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formEditWarga" action="" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" id="edit_warga_nik" name="nik" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white" placeholder="Contoh: 32751927410182" pattern="[0-9]{12,16}">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Nama Lengkap</label>
                        <input type="text" id="edit_warga_name" name="name" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Email</label>
                        <input type="email" id="edit_warga_email" name="email" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white" placeholder="******">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Nomor Telepon</label>
                        <input type="text" id="edit_warga_no_telp" name="no_telp" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Tempat Lahir</label>
                        <input type="text" id="edit_warga_tempat_lahir" name="tempat_lahir" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Tanggal Lahir</label>
                        <input type="date" id="edit_warga_tanggal_lahir" name="tanggal_lahir" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Jenis Kelamin</label>
                        <select id="edit_warga_jenis_kelamin" name="jenis_kelamin" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Agama</label>
                        <input type="text" id="edit_warga_agama" name="agama" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Alamat Rumah</label>
                        <input type="text" id="edit_warga_alamat" name="alamat" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Status Tempat Tinggal</label>
                        <select id="edit_warga_status_tinggal" name="status_tinggal" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                            <option value="Pemilik">Pemilik Rumah (Rumah)</option>
                            <option value="Sewa">Sewa / Kontrak (Rumah)</option>
                            <option value="Kos">Ngekos (Kos)</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Status Pernikahan</label>
                        <select id="edit_warga_status_pernikahan" name="status_pernikahan" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 text-white">
                            <option value="belum_menikah">Belum Menikah</option>
                            <option value="sudah_menikah">Sudah Menikah</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-[#022c22] font-black uppercase tracking-widest rounded-2xl shadow-lg hover:scale-[1.02] transition-all mt-4">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- SCRIPTS BAWAAN LAINNYA --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({ icon: 'success', title: '<span class="text-white font-black uppercase italic">BERHASIL!</span>', text: {!! json_encode(session('success')) !!}, background: '#020617', confirmButtonColor: '#10b981', customClass: { popup: 'glass-card border border-emerald-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-[#020617]' } });
            @endif
            @if(session('error'))
                Swal.fire({ icon: 'error', title: '<span class="text-white font-black uppercase italic">GAGAL!</span>', text: {!! json_encode(session('error')) !!}, background: '#020617', confirmButtonColor: '#ef4444', customClass: { popup: 'glass-card border border-red-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3' } });
            @endif

            // Controller Laci Warga Mobile (Hover & Click/Tap Toggle)
            const cards = document.querySelectorAll('.mobile-warga-card');
            cards.forEach(card => {
                // Click/Tap toggle
                card.addEventListener('click', function(e) {
                    // Jika klik pada tombol edit, hapus, form, atau link, hiraukan toggle drawer
                    if (e.target.closest('button') || e.target.closest('form') || e.target.closest('a')) {
                        return;
                    }
                    
                    const isOpen = card.classList.contains('active-drawer');
                    
                    // Tutup semua laci lain
                    cards.forEach(c => c.classList.remove('active-drawer'));
                    
                    // Toggle laci yang diklik
                    if (!isOpen) {
                        card.classList.add('active-drawer');
                    }
                });

                // Hover mouseenter & mouseleave untuk simulasi kursor di layar komputer / simulator
                card.addEventListener('mouseenter', function() {
                    // Tutup laci aktif lainnya jika ada yang diklik untuk menghindari tumpang tindih
                    cards.forEach(c => c.classList.remove('active-drawer'));
                    card.classList.add('active-drawer');
                });

                card.addEventListener('mouseleave', function() {
                    card.classList.remove('active-drawer');
                });
            });
        });

        // FUNGSI MADING
        function bukaModalTambahMading() {
            document.getElementById('modalTambahMading').classList.remove('hidden');
            document.getElementById('modalTambahMading').classList.add('flex');
        }
        function tutupModalTambahMading() {
            document.getElementById('modalTambahMading').classList.add('hidden');
            document.getElementById('modalTambahMading').classList.remove('flex');
        }
        
        function bukaModalEditMading(id, judul, isi) {
            document.getElementById('modalEditMading').classList.remove('hidden');
            document.getElementById('modalEditMading').classList.add('flex');
            document.getElementById('formEditMading').action = `/announcement/${id}`;
            document.getElementById('edit_mading_judul').value = judul;
            document.getElementById('edit_mading_isi').value = isi;
        }
        function tutupModalEditMading() {
            document.getElementById('modalEditMading').classList.add('hidden');
            document.getElementById('modalEditMading').classList.remove('flex');
        }

        // FUNGSI PENGELUARAN
        function bukaModalPengeluaran() {
            document.getElementById('modalTambahPengeluaran').classList.remove('hidden');
            document.getElementById('modalTambahPengeluaran').classList.add('flex');
        }
        function tutupModalPengeluaran() {
            document.getElementById('modalTambahPengeluaran').classList.add('hidden');
            document.getElementById('modalTambahPengeluaran').classList.remove('flex');
        }

        // FUNGSI WARGA (TAMBAH & EDIT)
        function toggleModal() {
            const modal = document.getElementById('modalTambahWarga');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function bukaModalEditWarga(id, nik, name, email, no_telp, tanggal_lahir, jenis_kelamin, agama, alamat, tempat_lahir, status_tinggal, status_pernikahan) {
            document.getElementById('modalEditWarga').classList.remove('hidden');
            document.getElementById('modalEditWarga').classList.add('flex');
            document.getElementById('formEditWarga').action = `/warga/${id}`;
            document.getElementById('edit_warga_nik').value = nik || '';
            document.getElementById('edit_warga_name').value = name;
            document.getElementById('edit_warga_email').value = email;
            document.getElementById('edit_warga_no_telp').value = no_telp;
            document.getElementById('edit_warga_tanggal_lahir').value = tanggal_lahir;
            document.getElementById('edit_warga_jenis_kelamin').value = jenis_kelamin;
            document.getElementById('edit_warga_agama').value = agama;
            document.getElementById('edit_warga_alamat').value = alamat;
            document.getElementById('edit_warga_tempat_lahir').value = tempat_lahir || '';
            document.getElementById('edit_warga_status_tinggal').value = status_tinggal || 'Pemilik';
            document.getElementById('edit_warga_status_pernikahan').value = status_pernikahan || 'belum_menikah';
        }
        function tutupModalEditWarga() {
            document.getElementById('modalEditWarga').classList.add('hidden');
            document.getElementById('modalEditWarga').classList.remove('flex');
        }

        // FUNGSI LIHAT BUKTI PERSATUJUAN
        function lihatBukti(url) {
            Swal.fire({
                title: '<span class="text-white font-black uppercase italic">BUKTI TRANSFER</span>',
                imageUrl: url,
                imageAlt: 'Bukti Transfer Pembayaran Kas',
                background: '#020617',
                confirmButtonColor: '#10b981',
                confirmButtonText: 'TUTUP',
                customClass: {
                    popup: 'glass-card border border-emerald-500/30 rounded-3xl',
                    confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-[#022c22]'
                }
            });
        }

        // LOGOUT
        function confirmLogout(e) {
            e.preventDefault(); 
            Swal.fire({
                title: '<span class="text-white font-black uppercase italic">LOGOUT?</span>', text: "Yakin anda ingin keluar dari sistem?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#1e293b', confirmButtonText: 'YA, KELUAR', cancelButtonText: 'BATAL', background: '#020617',
                customClass: { popup: 'glass-card border border-red-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3', cancelButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-white' }
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('logout-form').submit(); }
            });
        }

        // INHERIT DATA CHART DARI CONTROLLER
        let chartBulanan = null;
        let chartTahunan = null;

        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
        document.addEventListener('DOMContentLoaded', () => {
            const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
            const isLightThemeOnLoad = document.documentElement.classList.contains('light-mode');
            const initialLabelColor = isLightThemeOnLoad ? '#0f172a' : 'rgba(255, 255, 255, 0.7)';
            const initialGridColor = isLightThemeOnLoad ? 'rgba(0, 0, 0, 0.05)' : 'rgba(255, 255, 255, 0.05)';
            const initialTickColor = isLightThemeOnLoad ? '#64748b' : 'rgba(255, 255, 255, 0.5)';

            chartBulanan = new Chart(ctxBulanan, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: 'Pemasukan (Rp)',
                            data: {!! json_encode($chartPemasukan) !!},
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Pengeluaran (Rp)',
                            data: {!! json_encode($chartPengeluaran) !!},
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: initialLabelColor, font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 } }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: initialGridColor },
                            ticks: { color: initialTickColor, font: { size: 9 } }
                        },
                        y: {
                            grid: { color: initialGridColor },
                            ticks: {
                                color: initialTickColor,
                                font: { size: 9 },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            const ctxTahunan = document.getElementById('chartTahunan').getContext('2d');
            chartTahunan = new Chart(ctxTahunan, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartTahunLabels) !!},
                    datasets: [
                        {
                            label: 'Pemasukan (Rp)',
                            data: {!! json_encode($chartTahunanPemasukan) !!},
                            backgroundColor: '#3b82f6',
                            borderRadius: 8
                        },
                        {
                            label: 'Pengeluaran (Rp)',
                            data: {!! json_encode($chartTahunanPengeluaran) !!},
                            backgroundColor: '#ef4444',
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: initialLabelColor, font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 } }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: initialGridColor },
                            ticks: { color: initialTickColor, font: { size: 9 } }
                        },
                        y: {
                            grid: { color: initialGridColor },
                            ticks: {
                                color: initialTickColor,
                                font: { size: 9 },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });

        function updateChartsForTheme(theme) {
            if (chartBulanan && chartTahunan) {
                const isLight = theme === 'light';
                const labelColor = isLight ? '#0f172a' : 'rgba(255, 255, 255, 0.7)';
                const gridColor = isLight ? 'rgba(0, 0, 0, 0.05)' : 'rgba(255, 255, 255, 0.05)';
                const tickColor = isLight ? '#64748b' : 'rgba(255, 255, 255, 0.5)';
                
                chartBulanan.options.plugins.legend.labels.color = labelColor;
                chartBulanan.options.scales.x.grid.color = gridColor;
                chartBulanan.options.scales.x.ticks.color = tickColor;
                chartBulanan.options.scales.y.grid.color = gridColor;
                chartBulanan.options.scales.y.ticks.color = tickColor;
                chartBulanan.update();
                
                chartTahunan.options.plugins.legend.labels.color = labelColor;
                chartTahunan.options.scales.x.grid.color = gridColor;
                chartTahunan.options.scales.x.ticks.color = tickColor;
                chartTahunan.options.scales.y.grid.color = gridColor;
                chartTahunan.options.scales.y.ticks.color = tickColor;
                chartTahunan.update();
            }
        }
        @endif

        // TOGGLE CUSTOMER SERVICE POPOVER
        function toggleCSPopover() {
            const popover = document.getElementById('cs-popover');
            if (popover) popover.classList.toggle('hidden');
        }

        // TOGGLE THEME LOGIC
        function toggleTheme() {
            const html = document.documentElement;
            const isLight = html.classList.toggle('light-mode');
            const newTheme = isLight ? 'light' : 'dark';
            localStorage.setItem('theme', newTheme);
            
            updateToggleButtonUI(newTheme);
            
            if (typeof updateChartsForTheme === 'function') {
                updateChartsForTheme(newTheme);
            }
        }

        function updateToggleButtonUI(theme) {
            const icons = document.querySelectorAll('.theme-toggle-icon');
            const texts = document.querySelectorAll('.theme-toggle-text');
            const btns = document.querySelectorAll('.theme-toggle-btn');
            
            icons.forEach(icon => {
                if (theme === 'light') {
                    icon.className = 'fa-solid fa-sun text-amber-500 theme-toggle-icon';
                } else {
                    icon.className = 'fa-solid fa-moon text-emerald-400 theme-toggle-icon';
                }
            });
            
            texts.forEach(text => {
                text.textContent = theme === 'light' ? 'Mode Terang' : 'Mode Gelap';
            });
            
            btns.forEach(btn => {
                if (theme === 'light') {
                    btn.classList.add('bg-amber-500/10', 'border-amber-500/30', 'text-amber-500');
                    btn.classList.remove('bg-white/5', 'border-white/10', 'text-emerald-400');
                } else {
                    btn.classList.remove('bg-amber-500/10', 'border-amber-500/30', 'text-amber-500');
                    btn.classList.add('bg-white/5', 'border-white/10', 'text-emerald-400');
                }
            });
        }

        // Initialize UI on load
        document.addEventListener('DOMContentLoaded', () => {
            const currentTheme = localStorage.getItem('theme') || 'dark';
            updateToggleButtonUI(currentTheme);
            
            // Wait for charts to initialize before applying theme styles
            setTimeout(() => {
                if (typeof updateChartsForTheme === 'function') {
                    updateChartsForTheme(currentTheme);
                }
            }, 100);
        });
    </script>
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 font-sans">
        <!-- Popover Card (visible by default) -->
        <div id="cs-popover" class="glass-card w-80 rounded-3xl p-6 border border-emerald-500/20 shadow-2xl relative transition-all duration-300">
            <!-- Close Button -->
            <button onclick="toggleCSPopover()" class="absolute top-4 right-4 text-white/30 hover:text-white transition-all text-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
            
            <!-- Header -->
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Layanan Pelanggan (Beta)</span>
            </div>
            
            <!-- Text Message -->
            <p class="text-white/80 text-[11px] leading-relaxed mb-4">
                Website kami saat ini masih dalam tahap pengembangan (Beta). Kami sangat mengharapkan bantuanmu untuk memberikan kritik, saran, atau melaporkan kendala teknis agar kami bisa terus meningkatkan kualitas platform ini, silahkan hubungi whatsapp kami
            </p>
            
            <!-- CTA WA Button -->
            <a href="https://wa.me/6287797891082?text=Halo%20Admin%20E-KAS,%20saya%20ingin%20menyampaikan%20kritik/saran/kendala%20teknis..." target="_blank" class="w-full py-3 bg-[#10b981] hover:bg-[#059669] text-[#022c22] text-xs font-black uppercase tracking-wider rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 hover:scale-[1.02]">
                <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi WhatsApp Kami
            </a>
        </div>

        <!-- Pulsing Floating Action Button -->
        <button onclick="toggleCSPopover()" class="w-14 h-14 bg-[#10b981] hover:bg-[#059669] text-[#022c22] rounded-full shadow-2xl shadow-emerald-500/30 flex items-center justify-center text-2xl transition-all duration-300 hover:scale-110 active:scale-95 group relative">
            <!-- Pulsing outer ring -->
            <span class="absolute inset-0 rounded-full bg-[#10b981]/30 animate-ping -z-10"></span>
            <i class="fa-brands fa-whatsapp"></i>
            
            <!-- Tooltip (desktop only) -->
            <span class="absolute right-16 bg-[#022c22] text-emerald-400 border border-emerald-500/20 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none shadow-md hidden md:block">
                Customer Service
            </span>
        </button>
    </div>
</body>
</html>