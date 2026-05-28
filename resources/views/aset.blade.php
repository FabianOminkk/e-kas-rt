<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris & Penyewaan Aset | {{ auth()->user()->role }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2 family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link class="rounded-full" rel="icon" type="image/png" href="{{ asset('images/abikun.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <a href="{{ route('asset.index') }}" class="flex items-center gap-4 px-3 py-3 bg-emerald-500 text-[#022c22] rounded-xl shadow-lg transition-all">
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
                    <a href="{{ route('warga.index') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-users"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Data Warga</span>
                    </a>
                    <a href="{{ route('asset.index') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('asset.index') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all shadow-lg">
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
                        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">ASET RT</h2>
                        <p class="text-emerald-500/40 text-[10px] font-bold uppercase tracking-[0.4em]">Inventaris Komunal & Penyewaan</p>
                    </div>
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                        <div class="flex gap-3">
                            <button onclick="bukaModalAset()" class="px-5 py-3 bg-emerald-500 text-[#022c22] text-xs font-black uppercase rounded-xl shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-plus-circle"></i> Tambah Aset
                            </button>
                        </div>
                    @endif
                </div>

                {{-- TABS MENU --}}
                <div class="flex border-b border-white/10 mb-8 gap-6">
                    <button onclick="gantiTab('katalog')" id="tab-btn-katalog" class="pb-4 text-sm font-black uppercase tracking-wider text-emerald-400 border-b-2 border-emerald-500 transition-all">
                        <i class="fa-solid fa-warehouse mr-1.5"></i> Katalog Aset
                    </button>
                    <button onclick="gantiTab('penyewaan')" id="tab-btn-penyewaan" class="pb-4 text-sm font-black uppercase tracking-wider text-white/40 hover:text-white transition-all">
                        <i class="fa-solid fa-list-check mr-1.5"></i> 
                        {{ auth()->user()->role == 'warga' ? 'Penyewaan Saya' : 'Kelola Penyewaan' }}
                    </button>
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                        <button onclick="gantiTab('depresiasi')" id="tab-btn-depresiasi" class="pb-4 text-sm font-black uppercase tracking-wider text-white/40 hover:text-white transition-all">
                            <i class="fa-solid fa-calculator mr-1.5"></i> Laporan Buku Kas & Servis
                        </button>
                    @endif
                </div>

                {{-- ========================================== --}}
                {{-- TAB PANEL 1: KATALOG ASET --}}
                {{-- ========================================== --}}
                <div id="panel-katalog" class="tab-panel space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($assets as $aset)
                            <div class="glass-card rounded-3xl p-6 border border-white/5 hover:border-emerald-500/20 transition-all duration-300 shadow-2xl flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="text-[9px] font-black font-mono tracking-widest px-2.5 py-1 bg-white/5 text-white/60 border border-white/5 rounded-md uppercase">
                                            {{ $aset->kode_aset }}
                                        </span>
                                        @if($aset->status === 'Baik')
                                            <span class="text-[9px] font-black tracking-widest px-2.5 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-md uppercase">Baik</span>
                                        @elseif($aset->status === 'Rusak')
                                            <span class="text-[9px] font-black tracking-widest px-2.5 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded-md uppercase">Rusak</span>
                                        @else
                                            <span class="text-[9px] font-black tracking-widest px-2.5 py-1 bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 rounded-md uppercase">Servis</span>
                                        @endif
                                    </div>

                                    <h4 class="text-lg font-black text-white uppercase tracking-tight mb-2">{{ $aset->nama }}</h4>
                                    <p class="text-xs text-white/50 leading-relaxed mb-4 min-h-[40px]">{{ $aset->deskripsi ?? 'Aset komunal RT untuk keperluan warga.' }}</p>
                                    
                                    {{-- LIFESPAN PROGRESS BAR --}}
                                    <div class="mb-4">
                                        <div class="flex justify-between text-[9px] font-bold text-white/40 uppercase tracking-widest mb-1.5">
                                            <span>Est. Sisa Umur</span>
                                            <span>{{ 100 - $aset->lifespan_percentage }}% (Est. {{ $aset->estimasi_umur - Carbon\Carbon::parse($aset->tanggal_beli)->diffInYears(Carbon\Carbon::now()) }} thn lagi)</span>
                                        </div>
                                        <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: {{ 100 - $aset->lifespan_percentage }}%"></div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 pt-3 border-t border-white/5 text-xs text-white/70">
                                        <div>
                                            <span class="text-[8px] font-bold text-white/30 uppercase tracking-widest block">Total Stok</span>
                                            <span class="font-bold text-white">{{ $aset->jumlah }} Unit</span>
                                        </div>
                                        <div>
                                            <span class="text-[8px] font-bold text-white/30 uppercase tracking-widest block">Harga Sewa</span>
                                            <span class="font-bold text-emerald-400">Rp {{ number_format($aset->harga_sewa, 0, ',', '.') }}/hari</span>
                                        </div>
                                    </div>

                                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                                        <div class="pt-3 mt-3 border-t border-white/5 grid grid-cols-2 gap-3 text-xs text-white/50">
                                            <div>
                                                <span class="text-[8px] font-bold text-white/30 uppercase tracking-widest block">Harga Beli Kas</span>
                                                <span class="font-mono font-bold">Rp {{ number_format($aset->harga_beli, 0, ',', '.') }}</span>
                                            </div>
                                            <div>
                                                <span class="text-[8px] font-bold text-white/30 uppercase tracking-widest block">Nilai Buku Saat Ini</span>
                                                <span class="font-mono font-bold text-purple-400">Rp {{ number_format($aset->current_value, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="pt-5 mt-4 border-t border-white/5 flex gap-2">
                                    @if(auth()->user()->role == 'warga')
                                        <button onclick="sewaAset('{{ $aset->id }}', '{{ $aset->nama }}', '{{ $aset->harga_sewa }}', {{ auth()->user()->isRajinBayarKas() ? 'true' : 'false' }})" class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-400 text-[#022c22] font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md">
                                            <i class="fa-solid fa-key"></i> Ajukan Sewa
                                        </button>
                                    @else
                                        <button onclick="editAset('{{ $aset->id }}', '{{ $aset->kode_aset }}', '{{ addslashes($aset->nama) }}', '{{ addslashes($aset->deskripsi) }}', '{{ $aset->jumlah }}', '{{ $aset->harga_beli }}', '{{ $aset->tanggal_beli->format('Y-m-d') }}', '{{ $aset->estimasi_umur }}', '{{ $aset->harga_sewa }}', '{{ $aset->status }}', '{{ $aset->jadwal_maintenance ? $aset->jadwal_maintenance->format('Y-m-d') : '' }}', '{{ $aset->biaya_maintenance }}')" class="flex-1 py-2 bg-blue-500/10 border border-blue-500/30 text-blue-400 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                        @if(auth()->user()->role == 'admin')
                                            <form action="{{ route('asset.destroy', $aset->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset komunal ini secara permanen?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-full py-2 bg-red-500/10 border border-red-500/30 text-red-500 font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-red-500 hover:text-white transition-all flex items-center justify-center gap-1">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 bg-white/5 border border-white/5 rounded-3xl text-center">
                                <i class="fa-regular fa-folder-open text-4xl text-white/20 mb-3"></i>
                                <p class="text-white/40 text-xs font-black uppercase tracking-widest">Belum ada aset terdaftar</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- TAB PANEL 2: KELOLA/LOG PENYEWAAN --}}
                {{-- ========================================== --}}
                <div id="panel-penyewaan" class="tab-panel hidden space-y-6">
                    <div class="glass-card rounded-3xl p-6 border border-white/5 shadow-2xl">
                        <h4 class="text-emerald-400 font-black text-xs uppercase tracking-widest mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left"></i> Log & Status Penyewaan Aset
                        </h4>

                        <div class="space-y-4">
                            @forelse($rentals as $rental)
                                <div class="p-4 bg-white/5 border border-white/5 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-white/10 transition-all">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-lg">
                                            <i class="fa-solid fa-box-open"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h5 class="text-sm font-black text-white uppercase">{{ $rental->asset->nama ?? 'Aset' }}</h5>
                                                @if($rental->is_priority)
                                                    <span class="text-[8px] font-black bg-purple-500/20 text-purple-400 border border-purple-500/30 px-1.5 py-0.5 rounded-md uppercase tracking-wider">
                                                        <i class="fa-solid fa-award"></i> Prioritas Warga Kas
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-[10px] text-white/50 leading-relaxed uppercase font-mono">
                                                Sewa: {{ $rental->jumlah_pinjam }} Unit | {{ $rental->tanggal_pinjam->format('d M Y') }} s/d {{ $rental->tanggal_kembali->format('d M Y') }}
                                            </p>
                                            <p class="text-[10px] text-white/40 leading-relaxed uppercase mt-0.5">
                                                Penyewa: <span class="font-bold text-white/70">{{ $rental->user->name ?? 'Warga' }}</span> | Keperluan: "{{ $rental->keperluan }}"
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between md:justify-end gap-4 border-t md:border-t-0 border-white/5 pt-3 md:pt-0">
                                        <div class="text-left md:text-right">
                                            <span class="text-[8px] font-bold text-white/30 uppercase tracking-widest block">Biaya Sewa</span>
                                            @if($rental->biaya_sewa == 0)
                                                <span class="text-xs font-black text-emerald-400 uppercase tracking-wide">Rp 0 (GRATIS/KAS)</span>
                                            @else
                                                <span class="text-xs font-black text-white font-mono">Rp {{ number_format($rental->biaya_sewa, 0, ',', '.') }}</span>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-2">
                                            @if($rental->status === 'menunggu')
                                                <span class="px-3 py-1.5 bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 text-[9px] font-black rounded-lg uppercase tracking-wider">Menunggu</span>
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                                                    <form action="{{ route('asset.sewa.setuju', $rental->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-4 py-2 bg-emerald-500 text-[#022c22] text-[9px] font-black rounded-lg hover:bg-emerald-400 shadow-md uppercase">Setujui</button>
                                                    </form>
                                                    <form action="{{ route('asset.sewa.tolak', $rental->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-4 py-2 bg-red-500/10 border border-red-500/30 text-red-500 text-[9px] font-black rounded-lg hover:bg-red-500 hover:text-white uppercase">Tolak</button>
                                                    </form>
                                                @endif
                                            @elseif($rental->status === 'disetujui')
                                                <span class="px-3 py-1.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[9px] font-black rounded-lg uppercase tracking-wider">Dipinjam</span>
                                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                                                    <form action="{{ route('asset.sewa.kembali', $rental->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="px-4 py-2 bg-purple-500 text-white text-[9px] font-black rounded-lg hover:bg-purple-400 shadow-md uppercase">Kembalikan</button>
                                                    </form>
                                                @endif
                                            @elseif($rental->status === 'ditolak')
                                                <span class="px-3 py-1.5 bg-red-500/10 text-red-500 border border-red-500/20 text-[9px] font-black rounded-lg uppercase tracking-wider">Ditolak</span>
                                            @else
                                                <span class="px-3 py-1.5 bg-white/5 text-white/50 border border-white/5 text-[9px] font-black rounded-lg uppercase tracking-wider">Selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-white/20 italic uppercase text-center py-8">Belum ada riwayat sewa</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- TAB PANEL 3: BUKU KAS & DEPRESIASI --}}
                {{-- ========================================== --}}
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
                    <div id="panel-depresiasi" class="tab-panel hidden space-y-6">
                        {{-- METRICS SUMMARY CARD --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="glass-card rounded-3xl p-6 border-l-4 border-blue-500 overflow-hidden shadow-2xl">
                                <p class="text-[9px] text-blue-400/60 font-black uppercase tracking-wider">Total Pembelian Aset (Kas)</p>
                                <h3 class="text-2xl font-black text-white mt-1 font-mono">Rp {{ number_format($totalHargaBeli, 0, ',', '.') }}</h3>
                            </div>
                            <div class="glass-card rounded-3xl p-6 border-l-4 border-purple-500 overflow-hidden shadow-2xl">
                                <p class="text-[9px] text-purple-400/60 font-black uppercase tracking-wider">Estimasi Nilai Buku Saat Ini</p>
                                <h3 class="text-2xl font-black text-white mt-1 font-mono">Rp {{ number_format($totalNilaiSekarang, 0, ',', '.') }}</h3>
                            </div>
                            <div class="glass-card rounded-3xl p-6 border-l-4 border-red-500 overflow-hidden shadow-2xl">
                                <p class="text-[9px] text-red-400/60 font-black uppercase tracking-wider">Akumulasi Depresiasi Penyusutan</p>
                                <h3 class="text-2xl font-black text-white mt-1 font-mono">Rp {{ number_format($totalDepresiasi, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        {{-- DETAILED ASSETS MAINTENANCE & DEPRECIATION TABLE --}}
                        <div class="glass-card rounded-3xl p-8 shadow-2xl overflow-x-auto">
                            <h4 class="text-purple-400 font-black text-xs uppercase tracking-widest mb-6 flex items-center gap-2">
                                <i class="fa-solid fa-list-ol"></i> Laporan Audit Depresiasi & Jadwal Maintenance Aset RT
                            </h4>

                            <table class="w-full text-center text-xs">
                                <thead>
                                    <tr class="text-white/30 uppercase tracking-wider border-b border-white/5 whitespace-nowrap">
                                        <th class="pb-4">Aset</th>
                                        <th class="pb-4">Tgl Pembelian</th>
                                        <th class="pb-4">Harga Pembelian (Kas)</th>
                                        <th class="pb-4">Umur Est. (Tahun)</th>
                                        <th class="pb-4">Penyusutan Tahunan</th>
                                        <th class="pb-4">Nilai Buku Sekarang</th>
                                        <th class="pb-4">Jadwal Servis Berikutnya</th>
                                        <th class="pb-4">Est. Dana Servis (Kas)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-white/60">
                                    @foreach($assets as $aset)
                                        <tr class="border-b border-white/5 hover:bg-white/[0.02]">
                                            <td class="py-4 font-bold text-white text-left">{{ $aset->nama }} ({{ $aset->kode_aset }})</td>
                                            <td class="py-4 font-mono">{{ $aset->tanggal_beli->format('d M Y') }}</td>
                                            <td class="py-4 font-mono text-white/80">Rp {{ number_format($aset->harga_beli, 0, ',', '.') }}</td>
                                            <td class="py-4">{{ $aset->estimasi_umur }} Tahun</td>
                                            <td class="py-4 font-mono text-red-400/80">Rp {{ number_format($aset->harga_beli / $aset->estimasi_umur, 0, ',', '.') }}/thn</td>
                                            <td class="py-4 font-mono text-purple-400 font-bold">Rp {{ number_format($aset->current_value, 0, ',', '.') }}</td>
                                            <td class="py-4 font-bold text-center">
                                                @if($aset->jadwal_maintenance)
                                                    @if($aset->jadwal_maintenance->isPast())
                                                        <span class="text-red-500"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $aset->jadwal_maintenance->format('d M Y') }} (Lewat Jadwal)</span>
                                                    @else
                                                        <span class="text-yellow-400"><i class="fa-regular fa-calendar-check mr-1"></i> {{ $aset->jadwal_maintenance->format('d M Y') }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-white/30">-</span>
                                                @endif
                                            </td>
                                            <td class="py-4 font-mono font-bold text-emerald-400">Rp {{ number_format($aset->biaya_maintenance, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </main>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL TAMBAH / EDIT ASET (ADMIN) --}}
    {{-- ========================================== --}}
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bendahara')
        <div id="modal-aset" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4">
            <div class="glass-card w-full max-w-xl rounded-[2rem] p-8 border border-emerald-500/30 shadow-2xl flex flex-col relative">
                <button onclick="tutupModalAset()" class="absolute top-6 right-6 text-white/30 hover:text-white transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
                <h3 id="modal-title" class="text-emerald-400 font-black text-xl uppercase tracking-tighter mb-6 italic">Daftarkan Aset Baru</h3>
                
                <form id="form-aset" method="POST" action="{{ route('asset.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Kode Aset</label>
                            <input type="text" name="kode_aset" id="input-kode-aset" required placeholder="AST-XXX" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Nama Barang</label>
                            <input type="text" name="nama" id="input-nama" required placeholder="Nama komunal" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Deskripsi Aset</label>
                        <textarea name="deskripsi" id="input-deskripsi" placeholder="Tuliskan spesifikasi barang..." rows="2" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Jumlah Stok</label>
                            <input type="number" name="jumlah" id="input-jumlah" required min="1" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Harga Beli Kas</label>
                            <input type="number" name="harga_beli" id="input-harga-beli" required min="0" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Est. Umur (Tahun)</label>
                            <input type="number" name="estimasi_umur" id="input-estimasi-umur" required min="1" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Harga Sewa Warga (Per Hari)</label>
                            <input type="number" name="harga_sewa" id="input-harga-sewa" required min="0" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Tanggal Pembelian</label>
                            <input type="date" name="tanggal_beli" id="input-tanggal-beli" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white" style="color-scheme: dark;">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-white/5">
                        <div class="sm:col-span-1">
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Kondisi Aset</label>
                            <select name="status" id="input-status" class="w-full bg-[#020617] border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Servis">Servis</option>
                            </select>
                        </div>
                        <div class="sm:col-span-1">
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Jadwal Servis</label>
                            <input type="date" name="jadwal_maintenance" id="input-jadwal-maintenance" class="w-full bg-white/5 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white" style="color-scheme: dark;">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1.5">Est. Biaya Servis</label>
                            <input type="number" name="biaya_maintenance" id="input-biaya-maintenance" class="w-full bg-white/5 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-400 text-[#022c22] font-black text-xs uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-emerald-500/20 mt-6">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Data Aset
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- MODAL PENYEWAAN BARU (WARGA) --}}
    {{-- ========================================== --}}
    @if(auth()->user()->role == 'warga')
        <div id="modal-sewa" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4">
            <div class="glass-card w-full max-w-md rounded-[2rem] p-8 border border-emerald-500/30 shadow-2xl flex flex-col relative animate-fade-in">
                <button onclick="tutupModalSewa()" class="absolute top-6 right-6 text-white/30 hover:text-white transition-all"><i class="fa-solid fa-xmark text-lg"></i></button>
                <h3 class="text-emerald-400 font-black text-xl uppercase tracking-tighter mb-4 italic flex items-center gap-2">
                    <i class="fa-solid fa-key text-lg"></i> Formulir Sewa Aset
                </h3>
                
                {{-- KAS ELIGIBILITY STATUS ALERT CARD --}}
                <div id="sewa-benefit-card" class="p-3 mb-4 rounded-xl text-center border">
                    <!-- Dynamic check: rajin vs non-rajin -->
                </div>

                <form method="POST" action="{{ route('asset.sewa.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="asset_id" id="sewa-asset-id">

                    <div>
                        <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1">Aset yang Dipinjam</label>
                        <input type="text" id="sewa-asset-nama" readonly class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white/80 font-bold uppercase">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1">Jumlah Sewa</label>
                            <input type="number" name="jumlah_pinjam" required min="1" value="1" id="sewa-jumlah" oninput="hitungEstimasiBiaya()" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1">Estimasi Biaya</label>
                            <div class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-emerald-400 font-black" id="sewa-estimasi-tampilan">Rp 0</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_pinjam" required id="sewa-tgl-pinjam" min="{{ date('Y-m-d') }}" onchange="hitungEstimasiBiaya()" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white" style="color-scheme: dark;">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" required id="sewa-tgl-kembali" min="{{ date('Y-m-d') }}" onchange="hitungEstimasiBiaya()" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white" style="color-scheme: dark;">
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-emerald-500 uppercase tracking-widest block mb-1">Keperluan Acara</label>
                        <textarea name="keperluan" required placeholder="Contoh: Acara khitanan, syukuran keluarga, dsb." rows="2" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-400 text-[#022c22] font-black text-xs uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-emerald-500/20 mt-6">
                        <i class="fa-solid fa-share mr-1"></i> Ajukan Penyewaan Aset
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- SCRIPTS --}}
    <script>
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
        });

        // TAB NAVIGATION LOGIC
        function gantiTab(tabName) {
            // Sembunyikan semua panel
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            
            // Nonaktifkan semua button tab style
            document.getElementById('tab-btn-katalog').className = "pb-4 text-sm font-black uppercase tracking-wider text-white/40 hover:text-white transition-all";
            document.getElementById('tab-btn-penyewaan').className = "pb-4 text-sm font-black uppercase tracking-wider text-white/40 hover:text-white transition-all";
            
            const btnDepresiasi = document.getElementById('tab-btn-depresiasi');
            if (btnDepresiasi) {
                btnDepresiasi.className = "pb-4 text-sm font-black uppercase tracking-wider text-white/40 hover:text-white transition-all";
            }

            // Aktifkan panel terpilih
            document.getElementById('panel-' + tabName).classList.remove('hidden');
            
            // Aktifkan button tab style terpilih
            document.getElementById('tab-btn-' + tabName).className = "pb-4 text-sm font-black uppercase tracking-wider text-emerald-400 border-b-2 border-emerald-500 transition-all";
        }

        // ================= ASSET MODAL LOGIC (ADMIN) =================
        const modalAset = document.getElementById('modal-aset');
        
        function bukaModalAset() {
            if (!modalAset) return;
            document.getElementById('modal-title').textContent = 'Daftarkan Aset Baru';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('form-aset').action = "{{ route('asset.store') }}";
            document.getElementById('form-aset').reset();
            
            modalAset.classList.remove('hidden');
            modalAset.classList.add('flex');
        }

        function editAset(id, kode, nama, deskripsi, jumlah, hargaBeli, tglBeli, estimasiUmur, hargaSewa, status, jadwalMaint, biayaMaint) {
            if (!modalAset) return;
            document.getElementById('modal-title').textContent = 'Edit Data Aset RT';
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('form-aset').action = `/aset/${id}`;
            
            document.getElementById('input-kode-aset').value = kode;
            document.getElementById('input-nama').value = nama;
            document.getElementById('input-deskripsi').value = deskripsi;
            document.getElementById('input-jumlah').value = jumlah;
            document.getElementById('input-harga-beli').value = hargaBeli;
            document.getElementById('input-tanggal-beli').value = tglBeli;
            document.getElementById('input-estimasi-umur').value = estimasiUmur;
            document.getElementById('input-harga-sewa').value = hargaSewa;
            document.getElementById('input-status').value = status;
            document.getElementById('input-jadwal-maintenance').value = jadwalMaint;
            document.getElementById('input-biaya-maintenance').value = biayaMaint;

            modalAset.classList.remove('hidden');
            modalAset.classList.add('flex');
        }

        function tutupModalAset() {
            if (modalAset) {
                modalAset.classList.add('hidden');
                modalAset.classList.remove('flex');
            }
        }

        // ================= RENTAL MODAL LOGIC (WARGA) =================
        const modalSewa = document.getElementById('modal-sewa');
        let selectedHargaSewa = 0;
        let isUserRajinBayarKas = false;

        function sewaAset(id, nama, hargaSewa, isRajin) {
            if (!modalSewa) return;
            selectedHargaSewa = parseInt(hargaSewa, 10);
            isUserRajinBayarKas = isRajin;

            document.getElementById('sewa-asset-id').value = id;
            document.getElementById('sewa-asset-nama').value = nama;
            document.getElementById('sewa-jumlah').value = 1;
            
            // Set default date range
            const hariIni = new Date().toISOString().split('T')[0];
            document.getElementById('sewa-tgl-pinjam').value = hariIni;
            document.getElementById('sewa-tgl-kembali').value = hariIni;

            const benefitCard = document.getElementById('sewa-benefit-card');
            if (isRajin) {
                benefitCard.className = "p-3 mb-4 rounded-xl text-center border border-purple-500/20 bg-purple-500/10 text-purple-400 text-[10px] font-black uppercase tracking-wider";
                benefitCard.innerHTML = '<i class="fa-solid fa-award text-sm mr-1"></i> FASILITAS PRIORITAS KAS: Anda berhak meminjam aset secara GRATIS (Diskon 100%) & antrean diprioritaskan.';
            } else {
                benefitCard.className = "p-3 mb-4 rounded-xl text-center border border-yellow-500/20 bg-yellow-500/10 text-yellow-500 text-[10px] font-black uppercase tracking-wider";
                benefitCard.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-sm mr-1"></i> Biaya sewa normal berlaku. Bayar lunas Kas RT Anda untuk mendapatkan fasilitas prioritas gratis!';
            }

            hitungEstimasiBiaya();
            modalSewa.classList.remove('hidden');
            modalSewa.classList.add('flex');
        }

        function hitungEstimasiBiaya() {
            if (!modalSewa) return;
            const jumlahInput = parseInt(document.getElementById('sewa-jumlah').value, 10) || 1;
            const tglPinjamVal = document.getElementById('sewa-tgl-pinjam').value;
            const tglKembaliVal = document.getElementById('sewa-tgl-kembali').value;

            if (isUserRajinBayarKas) {
                document.getElementById('sewa-estimasi-tampilan').textContent = 'Rp 0 (GRATIS)';
                return;
            }

            if (tglPinjamVal && tglKembaliVal) {
                const t1 = new Date(tglPinjamVal);
                const t2 = new Date(tglKembaliVal);
                const bedaWaktu = Math.abs(t2 - t1);
                const durasiHari = Math.ceil(bedaWaktu / (1000 * 60 * 60 * 24)) + 1;
                
                const totalBiaya = selectedHargaSewa * jumlahInput * durasiHari;
                document.getElementById('sewa-estimasi-tampilan').textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
            } else {
                document.getElementById('sewa-estimasi-tampilan').textContent = 'Rp 0';
            }
        }

        function tutupModalSewa() {
            if (modalSewa) {
                modalSewa.classList.add('hidden');
                modalSewa.classList.remove('flex');
            }
        }

        // ================= GENERAL COMMON LOGIC =================
        function toggleTheme() {
            const html = document.documentElement;
            const isLight = html.classList.toggle('light-mode');
            const newTheme = isLight ? 'light' : 'dark';
            localStorage.setItem('theme', newTheme);
            updateToggleButtonUI(newTheme);
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
