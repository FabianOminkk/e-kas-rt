<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database & Demografi Warga | {{ auth()->user()->role }}</title>
    
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

        .leaf-scene { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
        .leaf-item { position: absolute; background: radial-gradient(circle at 30% 30%, #34d399, #059669); clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); opacity: 0.6; filter: blur(1px); }
        
        @keyframes falling { 
            0% { transform: translateY(-10vh) rotate(0deg); opacity: 0; } 
            15% { opacity: 0.7; } 
            85% { opacity: 0.7; } 
            100% { transform: translateY(110vh) rotate(360deg); opacity: 0; } 
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
        html.light-mode .text-white,
        html.light-mode .text-white\/90,
        html.light-mode .text-white\/80,
        html.light-mode .text-white\/70 {
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
        html.light-mode .text-purple-400 {
            color: #7c3aed !important;
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
        html.light-mode .text-white\/40,
        html.light-mode .text-white\/50,
        html.light-mode .text-white\/60,
        html.light-mode .text-white\/30 {
            color: #64748b !important;
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
        html.light-mode .glass-card {
            box-shadow: 0 4px 20px -2px rgba(16, 24, 40, 0.05), 0 2px 12px -4px rgba(16, 24, 40, 0.03) !important;
        }
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
    
        
    </style>
</head>
<body class="antialiased relative z-10">

    <div class="leaf-scene" id="leaf-scene"></div>

    <div class="flex h-screen w-full overflow-hidden relative">
        
        {{-- SIDEBAR --}}
        <aside class="sidebar-container glass-sidebar flex flex-col p-4 group relative z-50">
            <div class="mb-10 flex items-center gap-4 overflow-hidden px-2">
                <img src="{{ asset('images/abikun.png') }}" alt="Logo" class="min-w-[40px] w-10 h-10 rounded-xl object-cover shadow-lg border border-emerald-500/20">
                <div class="sidebar-text">
                    <h1 class="text-xl font-black tracking-tighter uppercase text-emerald-400 leading-none">Kas RT</h1>
                    <p class="text-white text-[8px] font-bold uppercase tracking-[0.3em]">Managed By Fabian</p>
                </div>
            </div>

            <nav class="flex-1 space-y-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                    <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-house"></i></div>
                    <span class="sidebar-text text-xs font-black uppercase tracking-widest">Dashboard</span>
                </a>
                
                @if(auth()->user()->role == 'warga')
                    <a href="{{ route('asset.index') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Inventaris Aset</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Ubah Profil</span>
                    </a>
                    <a href="{{ url('/dompet') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-wallet"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Dompet Saya</span>
                    </a>
                @else
                    <a href="{{ route('warga.index') }}" class="flex items-center gap-4 px-3 py-3 bg-emerald-500 text-[#022c22] rounded-xl shadow-lg transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-users"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Data Warga</span>
                    </a>
                    <a href="{{ route('asset.index') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Inventaris Aset</span>
                    </a>
                    <a href="{{ route('dashboard') }}#mading-informasi" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-bullhorn"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Announcement</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Setting Profil</span>
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
        <main class="flex-1 overflow-y-auto bg-[#020617] p-8 scroll-smooth relative z-10">
            <div class="max-w-[96rem] mx-auto w-full px-4 md:px-6">
                
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">DATA WARGA</h2>
                        <p class="text-emerald-500/40 text-[10px] font-bold uppercase tracking-[0.4em]">Demografi & Database Warga RT</p>
                    </div>
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                        <div class="flex gap-3">
                            <button onclick="toggleModal()" class="px-5 py-3 bg-emerald-500 text-[#022c22] text-xs font-black uppercase rounded-xl shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-user-plus"></i> Tambah Warga
                            </button>
                        </div>
                    @endif
                </div>

                {{-- ========================================== --}}
                {{-- SECTION 1: DEMOGRAFI WARGA (PIE CHART) --}}
                {{-- ========================================== --}}
                <div id="data-keseluruhan" class="glass-card rounded-3xl p-8 mb-8 border border-purple-500/10 shadow-2xl">
                    <h3 class="text-purple-400 font-black text-xl uppercase tracking-tighter mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-chart-pie text-lg"></i> Analisis Demografi Usia Warga
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        {{-- PIE CHART CONTAINER --}}
                        <div class="lg:col-span-5 flex flex-col items-center justify-center p-6 bg-white/5 border border-white/5 rounded-2xl relative">
                            <div class="w-full max-w-[280px] h-[280px] relative">
                                <canvas id="chartDemografi"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest">
                                    <i class="fa-solid fa-info-circle mr-1"></i> Berdasarkan Tanggal Lahir Terdaftar
                                </p>
                            </div>
                        </div>

                        {{-- DEMOGRAPHIC STATS DETAILS --}}
                        <div class="lg:col-span-7 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- BAYI --}}
                                <div class="p-4 bg-white/5 border border-white/5 hover:border-amber-500/20 rounded-2xl flex items-center justify-between transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 shadow-inner">
                                            <i class="fa-solid fa-baby text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-white uppercase">Bayi</p>
                                            <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider">&lt; 12 Bulan</p>
                                        </div>
                                    </div>
                                    <span class="px-3.5 py-1.5 bg-amber-500/10 text-amber-500 text-xs font-black rounded-lg border border-amber-500/20 shadow-md">
                                        {{ $demographics['bayi'] }} Orang
                                    </span>
                                </div>

                                {{-- ANAK --}}
                                <div class="p-4 bg-white/5 border border-white/5 hover:border-pink-500/20 rounded-2xl flex items-center justify-between transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-500 shadow-inner">
                                            <i class="fa-solid fa-child text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-white uppercase">Anak-Anak</p>
                                            <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider">&lt; 17 Tahun</p>
                                        </div>
                                    </div>
                                    <span class="px-3.5 py-1.5 bg-pink-500/10 text-pink-500 text-xs font-black rounded-lg border border-pink-500/20 shadow-md">
                                        {{ $demographics['anak'] }} Orang
                                    </span>
                                </div>

                                {{-- REMAJA --}}
                                <div class="p-4 bg-white/5 border border-white/5 hover:border-emerald-500/20 rounded-2xl flex items-center justify-between transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 shadow-inner">
                                            <i class="fa-solid fa-user-graduate text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-white uppercase">Remaja</p>
                                            <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider">&lt; 30 Tahun</p>
                                        </div>
                                    </div>
                                    <span class="px-3.5 py-1.5 bg-emerald-500/10 text-emerald-400 text-xs font-black rounded-lg border border-emerald-500/20 shadow-md">
                                        {{ $demographics['remaja'] }} Orang
                                    </span>
                                </div>

                                {{-- DEWASA --}}
                                <div class="p-4 bg-white/5 border border-white/5 hover:border-blue-500/20 rounded-2xl flex items-center justify-between transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 shadow-inner">
                                            <i class="fa-solid fa-user-tie text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-white uppercase">Dewasa</p>
                                            <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider">30 - 60 Tahun</p>
                                        </div>
                                    </div>
                                    <span class="px-3.5 py-1.5 bg-blue-500/10 text-blue-400 text-xs font-black rounded-lg border border-blue-500/20 shadow-md">
                                        {{ $demographics['dewasa'] }} Orang
                                    </span>
                                </div>
                            </div>

                            {{-- LANSIA --}}
                            <div class="p-4 bg-white/5 border border-white/5 hover:border-purple-500/20 rounded-2xl flex items-center justify-between transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400 shadow-inner">
                                        <i class="fa-solid fa-person-cane text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-white uppercase">Lansia</p>
                                        <p class="text-[9px] text-white/40 uppercase font-bold tracking-wider">&gt; 60 Tahun</p>
                                    </div>
                                </div>
                                <span class="px-3.5 py-1.5 bg-purple-500/10 text-purple-400 text-xs font-black rounded-lg border border-purple-500/20 shadow-md">
                                    {{ $demographics['lansia'] }} Orang
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- SECTION 2: DATABASE WARGA --}}
                {{-- ========================================== --}}
                <div id="database-warga" class="glass-card rounded-3xl p-8 shadow-2xl">
                    <h3 class="text-emerald-400 font-black text-xl uppercase tracking-tighter mb-6 flex items-center gap-3"><i class="fa-solid fa-users text-lg"></i> Direktori / Database Warga</h3>
                    
                    <div class="overflow-x-auto hidden md:block">
                        <table class="w-full text-center text-xs">
                            <thead>
                                <tr class="text-white/30 uppercase tracking-wider border-b border-white/5 whitespace-nowrap">
                                    <th class="pb-4 text-center pl-4 w-12">No.</th>
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
                            <tbody class="text-white/60">
                                @foreach($dataWarga as $warga)
                                <tr class="border-b border-white/5 hover:bg-white/[0.02]">
                                    <td class="py-4 text-center font-mono text-xs text-white/40 pl-4 w-12">{{ $loop->iteration }}</td>
                                    <td class="py-4 text-left whitespace-nowrap pl-4">
                                        <div class="flex items-center gap-3">
                                            @if($warga->foto_profil)
                                                <img src="{{ asset('profil/' . $warga->foto_profil) }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-emerald-500/50 shadow-md">
                                            @else
                                                <div class="w-9 h-9 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-xs font-black uppercase shadow-md">
                                                    {{ substr($warga->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="flex flex-col">
                                                <span class="font-bold text-white text-sm leading-tight">{{ $warga->name }}</span>
                                                <span class="font-mono text-[10px] text-white/40 tracking-wider mt-0.5">NIK: {{ $warga->nik ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-xs whitespace-nowrap">
                                        @if($warga->jenis_kelamin === 'Laki-laki')
                                            <span class="px-2.5 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded-md font-semibold">Laki-laki</span>
                                        @elseif($warga->jenis_kelamin === 'Perempuan')
                                            <span class="px-2.5 py-1 bg-pink-500/10 text-pink-400 border border-pink-500/20 rounded-md font-semibold">Perempuan</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-white/10 text-white/50 rounded-md font-semibold">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-left whitespace-nowrap text-white/80">
                                        @if($warga->tempat_lahir)
                                            {{ $warga->tempat_lahir }}, 
                                        @endif
                                        {{ $warga->tanggal_lahir ? $warga->tanggal_lahir->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 font-mono text-white/80 whitespace-nowrap">{{ $warga->no_telp }}</td>
                                    <td class="py-4 text-white/80 whitespace-nowrap capitalize">{{ $warga->agama ?? '-' }}</td>
                                    <td class="py-4 text-left text-white/80">
                                        <div class="font-semibold text-white">{{ $warga->alamat }}</div>
                                        <div class="mt-1">
                                            @if($warga->status_tinggal === 'Kos')
                                                <span class="text-[9px] px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded-md font-bold uppercase tracking-wider">KOS</span>
                                            @elseif($warga->status_tinggal === 'Pemilik' || $warga->status_tinggal === 'Sewa')
                                                <span class="text-[9px] px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded-md font-bold uppercase tracking-wider">RUMAH</span>
                                            @else
                                                <span class="text-[9px] px-2 py-0.5 bg-white/10 text-white/50 rounded-md font-bold uppercase tracking-wider">Belum Set</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        @if($warga->status_pernikahan === 'sudah_menikah')
                                            <span class="px-2.5 py-1 bg-purple-500/20 text-purple-400 rounded-md font-black uppercase text-[9px] tracking-wider">SUDAH MENIKAH</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-slate-500/20 text-slate-400 rounded-md font-black uppercase text-[9px] tracking-wider">BELUM MENIKAH</span>
                                        @endif
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        @php
                                            $iuranBulanIni = $warga->iurans->first();
                                            $status = $iuranBulanIni ? $iuranBulanIni->status : 'belum_bayar';
                                        @endphp
                                        @if($status === 'lunas')
                                            <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[9px] font-black rounded-md uppercase tracking-wider">LUNAS</span>
                                        @elseif($status === 'menunggu')
                                            <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-[9px] font-black rounded-md uppercase tracking-wider">DIPROSES</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-500/20 text-red-400 text-[9px] font-black rounded-md uppercase tracking-wider">BELUM BAYAR</span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        <div class="flex justify-center gap-3">
                                            <button onclick="bukaModalEditWarga('{{ $warga->id }}', '{{ $warga->nik }}', '{{ addslashes($warga->name) }}', '{{ $warga->email }}', '{{ $warga->no_telp }}', '{{ $warga->tanggal_lahir ? $warga->tanggal_lahir->format('Y-m-d') : '' }}', '{{ $warga->jenis_kelamin }}', '{{ addslashes($warga->agama) }}', '{{ addslashes($warga->alamat) }}', '{{ addslashes($warga->tempat_lahir) }}', '{{ $warga->status_tinggal }}', '{{ $warga->status_pernikahan }}')" class="text-blue-500/70 hover:text-blue-400 transition-all"><i class="fa-solid fa-pen-to-square text-sm"></i></button>
                                            <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini secara permanen?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500/70 hover:text-red-400 transition-all"><i class="fa-solid fa-trash text-sm"></i></button>
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
                        <div class="mobile-warga-card group relative glass-card rounded-2xl p-4 border border-white/5 transition-all duration-300 hover:border-emerald-500/30 hover:bg-emerald-950/10 cursor-pointer overflow-hidden" onclick="toggleMobileWargaDrawer('{{ $warga->id }}')">
                            <!-- Card Header (Always Visible) -->
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    @if($warga->foto_profil)
                                        <img src="{{ asset('profil/' . $warga->foto_profil) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-emerald-500/50 shadow-md">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-xs font-black uppercase shadow-md">
                                            {{ substr($warga->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col">
                                        <span class="font-bold text-white text-sm leading-tight">{{ $loop->iteration }}. {{ $warga->name }}</span>
                                        <span class="font-mono text-[9px] text-white/40 tracking-wider mt-0.5">NIK: {{ $warga->nik ?? '-' }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    @php
                                        $iuranBulanIni = $warga->iurans->first();
                                        $status = $iuranBulanIni ? $iuranBulanIni->status : 'belum_bayar';
                                    @endphp
                                    @if($status === 'lunas')
                                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[8px] font-black rounded-md uppercase tracking-wider">LUNAS</span>
                                    @elseif($status === 'menunggu')
                                        <span class="px-2.5 py-0.5 bg-yellow-500/20 text-yellow-400 text-[8px] font-black rounded-md uppercase tracking-wider">DIPROSES</span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-red-500/20 text-red-400 text-[8px] font-black rounded-md uppercase tracking-wider">BELUM BAYAR</span>
                                    @endif
                                    
                                    <!-- Chevron Indicator -->
                                    <i class="fa-solid fa-chevron-down text-white/40 text-[10px] transition-transform duration-300" id="chevron-mobile-{{ $warga->id }}"></i>
                                </div>
                            </div>

                            <!-- Card Content (Collapsible Drawer) -->
                            <div class="mobile-warga-drawer overflow-hidden max-h-0 opacity-0 transition-all duration-500 ease-in-out" id="drawer-mobile-{{ $warga->id }}">
                                <div class="mt-4 pt-4 border-t border-white/5 space-y-3 text-xs text-white/70">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <span class="text-[8px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Gender</span>
                                            @if($warga->jenis_kelamin === 'Laki-laki')
                                                <span class="text-blue-400 font-semibold"><i class="fa-solid fa-mars mr-1"></i> Laki-laki</span>
                                            @elseif($warga->jenis_kelamin === 'Perempuan')
                                                <span class="text-pink-400 font-semibold"><i class="fa-solid fa-venus mr-1"></i> Perempuan</span>
                                            @else
                                                <span class="text-white/50">-</span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-[8px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Agama</span>
                                            <span class="text-white font-semibold capitalize">{{ $warga->agama ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="col-span-2">
                                            <span class="text-[8px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Tempat, Tgl Lahir</span>
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
                                            <span class="text-[8px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">No. Telp</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $warga->no_telp) }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 transition-all font-mono font-semibold flex items-center gap-1">
                                                <i class="fa-brands fa-whatsapp text-sm"></i> {{ $warga->no_telp }}
                                            </a>
                                        </div>
                                        <div>
                                            <span class="text-[8px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Status Pernikahan</span>
                                            @if($warga->status_pernikahan === 'sudah_menikah')
                                                <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded-md font-black uppercase text-[8px] tracking-wider inline-block">SUDAH MENIKAH</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-slate-500/20 text-slate-400 rounded-md font-black uppercase text-[8px] tracking-wider inline-block">BELUM MENIKAH</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <span class="text-[8px] font-bold text-emerald-400/50 uppercase tracking-widest block mb-0.5">Alamat & Tinggal</span>
                                        <div class="font-bold text-white">{{ $warga->alamat }}</div>
                                        <div class="mt-1">
                                            @if($warga->status_tinggal === 'Kos')
                                                <span class="text-[8px] px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded-md font-black uppercase tracking-wider">KOS</span>
                                            @elseif($warga->status_tinggal === 'Pemilik' || $warga->status_tinggal === 'Sewa')
                                                <span class="text-[8px] px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded-md font-black uppercase tracking-wider">RUMAH</span>
                                            @else
                                                <span class="text-[8px] px-2 py-0.5 bg-white/10 text-white/50 rounded-md font-black uppercase tracking-wider">Belum Set</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex gap-2 pt-3 border-t border-white/5" onclick="event.stopPropagation()">
                                        <button onclick="bukaModalEditWarga('{{ $warga->id }}', '{{ $warga->nik }}', '{{ addslashes($warga->name) }}', '{{ $warga->email }}', '{{ $warga->no_telp }}', '{{ $warga->tanggal_lahir ? $warga->tanggal_lahir->format('Y-m-d') : '' }}', '{{ $warga->jenis_kelamin }}', '{{ addslashes($warga->agama) }}', '{{ addslashes($warga->alamat) }}', '{{ addslashes($warga->tempat_lahir) }}', '{{ $warga->status_tinggal }}', '{{ $warga->status_pernikahan }}')" class="flex-1 py-2 bg-blue-500/10 border border-blue-500/30 text-blue-400 hover:bg-blue-500 hover:text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 shadow-lg">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                                        </button>
                                        <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="flex-1 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full py-2 bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 shadow-lg">
                                                <i class="fa-solid fa-trash text-xs"></i> Hapus
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
        </main>
    </div>

    {{-- MODAL TAMBAH WARGA --}}
    <div id="modalTambahWarga" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4 py-8 overflow-y-auto">
        <div class="glass-card w-full max-w-lg rounded-[2.5rem] p-8 border border-emerald-500/30 my-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-emerald-400 font-black text-xl uppercase italic tracking-tighter">Tambah Warga Baru</h3>
                <button onclick="toggleModal()" class="text-white/40 hover:text-red-500 transition-colors text-lg"><i class="fa-solid fa-xmark"></i></button>
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
                <button onclick="tutupModalEditWarga()" class="text-white/40 hover:text-red-500 transition-colors text-lg"><i class="fa-solid fa-xmark"></i></button>
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

    {{-- SCRIPTS --}}
    <script>
        let chartDemografi = null;

        document.addEventListener('DOMContentLoaded', function() {
            const leafContainer = document.getElementById('leaf-scene');
            if(leafContainer) {
                for (let i = 0; i < 15; i++) {
                    let leaf = document.createElement('div');
                    leaf.className = 'leaf-item';
                    leaf.style.width = Math.random() * 15 + 10 + 'px';
                    leaf.style.height = Math.random() * 15 + 10 + 'px';
                    leaf.style.left = Math.random() * 100 + 'vw';
                    leaf.style.animation = `falling ${Math.random() * 5 + 5}s linear infinite`;
                    leaf.style.animationDelay = `${Math.random() * 5}s`;
                    leafContainer.appendChild(leaf);
                }
            }

            @if(session('success'))
                Swal.fire({ 
                    icon: 'success', title: '<span class="text-white font-black uppercase italic">BERHASIL!</span>', text: {!! json_encode(session('success')) !!}, background: '#020617', confirmButtonColor: '#10b981', customClass: { popup: 'glass-card border border-emerald-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-[#020617]' } 
                });
            @endif

            @if(session('error'))
                Swal.fire({ 
                    icon: 'error', title: '<span class="text-white font-black uppercase italic">GAGAL!</span>', text: {!! json_encode(session('error')) !!}, background: '#020617', confirmButtonColor: '#ef4444', customClass: { popup: 'glass-card border border-red-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3' } 
                });
            @endif

            // --- CHART DEMOGRAFI WARGA ---
            const ctxDemografi = document.getElementById('chartDemografi').getContext('2d');
            const isLightThemeOnLoad = document.documentElement.classList.contains('light-mode');
            const initialLabelColor = isLightThemeOnLoad ? '#0f172a' : 'rgba(255, 255, 255, 0.7)';

            chartDemografi = new Chart(ctxDemografi, {
                type: 'pie',
                data: {
                    labels: ['Bayi (< 12 bln)', 'Anak (< 17 thn)', 'Remaja (< 30 thn)', 'Dewasa (30-60 thn)', 'Lansia (> 60 thn)'],
                    datasets: [{
                        data: [
                            {{ $demographics['bayi'] }},
                            {{ $demographics['anak'] }},
                            {{ $demographics['remaja'] }},
                            {{ $demographics['dewasa'] }},
                            {{ $demographics['lansia'] }}
                        ],
                        backgroundColor: [
                            '#f59e0b', // Amber (Bayi)
                            '#ec4899', // Pink (Anak)
                            '#10b981', // Emerald (Remaja)
                            '#3b82f6', // Blue (Dewasa)
                            '#8b5cf6'  // Purple (Lansia)
                        ],
                        borderWidth: 2,
                        borderColor: isLightThemeOnLoad ? '#ffffff' : '#020617'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: initialLabelColor,
                                font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 },
                                padding: 15
                            }
                        }
                    }
                }
            });

            // Trigger theme update on load
            const currentTheme = localStorage.getItem('theme') || 'dark';
            updateChartsForTheme(currentTheme);

            // Automatically open add modal if requested in URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('add') === 'true') {
                toggleModal();
            }
        });

        // ================= MODAL WARGA LOGIC =================
        const modalTambahWarga = document.getElementById('modalTambahWarga');
        const modalEditWarga = document.getElementById('modalEditWarga');

        function toggleModal() {
            if (!modalTambahWarga) return;
            modalTambahWarga.classList.toggle('hidden');
            modalTambahWarga.classList.toggle('flex');
        }

        function bukaModalEditWarga(id, nik, name, email, no_telp, tanggal_lahir, jenis_kelamin, agama, alamat, tempat_lahir, status_tinggal, status_pernikahan) {
            if (!modalEditWarga) return;
            document.getElementById('formEditWarga').action = `/warga/${id}`;
            document.getElementById('edit_warga_nik').value = nik;
            document.getElementById('edit_warga_name').value = name;
            document.getElementById('edit_warga_email').value = email;
            document.getElementById('edit_warga_no_telp').value = no_telp;
            document.getElementById('edit_warga_tanggal_lahir').value = tanggal_lahir;
            document.getElementById('edit_warga_jenis_kelamin').value = jenis_kelamin;
            document.getElementById('edit_warga_agama').value = agama;
            document.getElementById('edit_warga_alamat').value = alamat;
            document.getElementById('edit_warga_tempat_lahir').value = tempat_lahir;
            document.getElementById('edit_warga_status_tinggal').value = status_tinggal;
            document.getElementById('edit_warga_status_pernikahan').value = status_pernikahan;

            modalEditWarga.classList.remove('hidden');
            modalEditWarga.classList.add('flex');
        }

        function tutupModalEditWarga() {
            if (modalEditWarga) {
                modalEditWarga.classList.add('hidden');
                modalEditWarga.classList.remove('flex');
            }
        }

        function toggleMobileWargaDrawer(id) {
            const drawer = document.getElementById('drawer-mobile-' + id);
            const chevron = document.getElementById('chevron-mobile-' + id);
            const card = drawer.closest('.mobile-warga-card');
            
            if (drawer.classList.contains('max-h-0')) {
                drawer.classList.remove('max-h-0', 'opacity-0');
                drawer.classList.add('max-h-[500px]', 'opacity-100');
                chevron.classList.add('rotate-180');
                card.classList.add('active-drawer');
            } else {
                drawer.classList.add('max-h-0', 'opacity-0');
                drawer.classList.remove('max-h-[500px]', 'opacity-100');
                chevron.classList.remove('rotate-180');
                card.classList.remove('active-drawer');
            }
        }

        // ================= GENERAL COMMON LOGIC =================
        function toggleTheme() {
            const html = document.documentElement;
            const isLight = html.classList.toggle('light-mode');
            const newTheme = isLight ? 'light' : 'dark';
            localStorage.setItem('theme', newTheme);
            updateToggleButtonUI(newTheme);
            updateChartsForTheme(newTheme);
        }

        function updateChartsForTheme(theme) {
            if (chartDemografi) {
                const isLight = theme === 'light';
                const labelColor = isLight ? '#0f172a' : 'rgba(255, 255, 255, 0.7)';
                chartDemografi.options.plugins.legend.labels.color = labelColor;
                chartDemografi.data.datasets[0].borderColor = isLight ? '#ffffff' : '#020617';
                chartDemografi.update();
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

        function confirmLogout(e) {
            e.preventDefault(); 
            Swal.fire({
                title: '<span class="text-white font-black uppercase italic">LOGOUT?</span>',
                text: "Yakin anda ingin keluar dari sistem?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#1e293b',
                confirmButtonText: 'YA, KELUAR',
                cancelButtonText: 'BATAL',
                background: '#020617',
                customClass: { popup: 'glass-card border border-red-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3', cancelButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-white' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>
</html>
