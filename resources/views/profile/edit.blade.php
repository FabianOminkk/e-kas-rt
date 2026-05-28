<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Profil | {{ auth()->user()->role }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- CSS Cropper.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    
    <link class="rounded-full" rel="icon" type="image/png" href="{{ asset('images/abikun.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- JS Cropper.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

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
        
        .modal-bg { background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(10px); }
        
        .sidebar-container { width: 80px; transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); z-index: 50; }
        .sidebar-container:hover { width: 280px; }
        .sidebar-text { opacity: 0; white-space: nowrap; transition: opacity 0.3s ease; pointer-events: none; }
        .sidebar-container:hover .sidebar-text { opacity: 1; pointer-events: auto; }
        
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        
        /* Cropper adjustments */
        .cropper-view-box, .cropper-face { border-radius: 50%; }
        .cropper-line, .cropper-point { display: none !important; }

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
        html.light-mode .text-white\/30,
        html.light-mode .text-emerald-200\/20,
        html.light-mode .text-emerald-200\/30,
        html.light-mode .text-emerald-200\/50,
        html.light-mode .text-emerald-100\/70,
        html.light-mode .text-emerald-100\/50 {
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
        html.light-mode .text-yellow-500\/80 {
            color: #b45309 !important;
        }
        html.light-mode .bg-yellow-500\/10 {
            background-color: rgba(245, 158, 11, 0.08) !important;
            border-color: rgba(245, 158, 11, 0.2) !important;
        }
        /* Inputs in modals & forms */
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

    <div class="leaf-scene" id="leaf-scene"></div>

    <div class="flex h-screen w-full overflow-hidden relative">
        
        {{-- SIDEBAR KIRI --}}
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
                    <a href="{{ route('asset.index') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Inventaris Aset</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('profile.edit') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all shadow-lg">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Ubah Profil</span>
                    </a>
                    <a href="{{ route('dompet.index') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-wallet"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Dompet Saya</span>
                    </a>
                @else
                    <a href="{{ route('warga.index') }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all">
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
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('profile.edit') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all shadow-lg">
                        <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                        <span class="sidebar-text text-xs font-black uppercase tracking-widest">Setting Profil</span>
                    </a>
                @endif
            </nav>

            <div class="mt-auto pt-6 border-t border-white/5 overflow-hidden">
                <div class="flex items-center gap-4 mb-6 px-1">
                    
                    {{-- AREA FOTO SIDEBAR (SUDAH DIPERBAIKI) --}}
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
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto bg-[#020617] p-8 relative z-10">
            <div class="max-w-4xl mx-auto">
                
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">Setting Profil</h2>
                        <p class="text-emerald-500/40 text-[10px] font-bold uppercase tracking-[0.4em]">SesuaiKAN DATA DIRI ANDA</p>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-8 animate-fade-in shadow-2xl">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- INPUT RAHASIA UNTUK BASE64 --}}
                        <input type="hidden" name="foto_profil_base64" id="foto_profil_base64">

                        {{-- AREA FOTO PROFIL (SUDAH DIPERBAIKI) --}}
                        <div class="flex flex-col items-center justify-center p-6 bg-white/5 border border-white/10 rounded-2xl mb-6">
                            <div class="relative w-32 h-32 mb-4 group">
                                <img id="preview-img" src="{{ $user->foto_profil ? asset('profil/' . $user->foto_profil) : '' }}" 
                                     alt="Foto Profil" 
                                     class="{{ $user->foto_profil ? '' : 'hidden' }} w-full h-full object-cover rounded-full border-4 border-emerald-500/50 shadow-lg transition-all group-hover:border-emerald-400">
                                
                                <div id="default-icon" class="{{ $user->foto_profil ? 'hidden' : 'flex' }} w-full h-full bg-[#020617] rounded-full border-4 border-emerald-500/50 items-center justify-center shadow-lg transition-all group-hover:border-emerald-400">
                                    <i class="fa-solid fa-user text-4xl text-emerald-500/50"></i>
                                </div>
                                
                                <label for="foto_profil" class="absolute bottom-0 right-0 bg-emerald-500 text-[#022c22] p-2.5 rounded-full cursor-pointer hover:scale-110 transition-transform shadow-lg z-10">
                                    <i class="fa-solid fa-camera"></i>
                                </label>
                            </div>
                            <input type="file" id="foto_profil" name="foto_profil" class="hidden" accept="image/jpeg, image/png, image/jpg" onchange="triggerCropModal(this)">
                            
                            <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest text-center mt-2" id="file-name">Upload foto (Maks 2MB)</p>
                            
                            <p class="text-[9px] font-bold text-yellow-500/80 uppercase tracking-[0.2em] text-center mt-2 bg-yellow-500/10 px-3 py-1 rounded-full border border-yellow-500/20">
                                <i class="fa-solid fa-circle-info mr-1"></i> Foto harus rapih dan jelas
                            </p>
                        </div>

                        {{-- DATA AKUN --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-regular fa-id-badge mr-1"></i> Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-regular fa-envelope mr-1"></i> Email / Username</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                            </div>
                        </div>

                        {{-- DATA KEPENDUDUKAN --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-white/10">
                            <div>
                                <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-phone mr-1"></i> No. WhatsApp / Telp</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" placeholder="08..." 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-calendar-days mr-1"></i> Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') : '') }}" 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white" style="color-scheme: dark;">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-venus-mars mr-1"></i> Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                                    <option value="" disabled {{ !$user->jenis_kelamin ? 'selected' : '' }}>Pilih...</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-hands-praying mr-1"></i> Agama</label>
                                <input type="text" name="agama" value="{{ old('agama', $user->agama) }}" 
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-house-user mr-1"></i> Status Tinggal</label>
                                <select name="status_tinggal" class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                                    <option value="" disabled {{ !$user->status_tinggal ? 'selected' : '' }}>Pilih...</option>
                                    <option value="Pemilik" {{ old('status_tinggal', $user->status_tinggal) == 'Pemilik' ? 'selected' : '' }}>Pemilik Rumah</option>
                                    <option value="Sewa" {{ old('status_tinggal', $user->status_tinggal) == 'Sewa' ? 'selected' : '' }}>Sewa / Kontrak</option>
                                    <option value="Kos" {{ old('status_tinggal', $user->status_tinggal) == 'Kos' ? 'selected' : '' }}>Ngekos</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-map-location-dot mr-1"></i> Alamat Lengkap / Blok Rumah</label>
                            <textarea name="alamat" rows="2" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        {{-- UBAH PASSWORD --}}
                        <div class="pt-4 mt-4 border-t border-white/10">
                            <p class="text-[10px] font-bold text-yellow-500 uppercase tracking-widest mb-4">
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i> Kosongkan password di bawah ini jika tidak ingin mengubahnya
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-lock mr-1"></i> Password Baru</label>
                                    <input type="password" name="password" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-2"><i class="fa-solid fa-key mr-1"></i> Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-all text-white">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full py-4 bg-emerald-500 text-[#022c22] font-black text-sm uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition-all">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL CROPPER.JS --}}
    <div id="crop-modal" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4">
        <div class="glass-card w-full max-w-lg rounded-[2rem] p-6 border border-emerald-500/30 shadow-2xl flex flex-col">
            <h3 class="text-emerald-400 font-black text-lg uppercase tracking-widest mb-4 text-center">Sesuaikan Foto</h3>
            
            <div class="w-full bg-black/50 rounded-xl overflow-hidden" style="height: 350px;">
                <img id="image-to-crop" src="" class="max-w-full hidden">
            </div>

            <div class="flex gap-4 mt-6">
                <button type="button" onclick="closeCropModal()" class="flex-1 py-3 bg-red-500/10 text-red-400 border border-red-500/30 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">
                    Batal
                </button>
                <button type="button" onclick="applyCrop()" class="flex-1 py-3 bg-emerald-500 text-[#022c22] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-400 shadow-lg shadow-emerald-500/20 transition-all">
                    Terapkan Foto
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = localStorage.getItem('theme') || 'dark';
            updateToggleButtonUI(currentTheme);

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

            @if($errors->any())
                let errorHtml = '<ul class="text-left list-disc pl-4 text-xs">';
                @foreach($errors->all() as $error)
                    errorHtml += '<li>{{ $error }}</li>';
                @endforeach
                errorHtml += '</ul>';
                Swal.fire({ 
                    icon: 'error', title: '<span class="text-white font-black uppercase italic">GAGAL!</span>', html: errorHtml, background: '#020617', confirmButtonColor: '#ef4444', customClass: { popup: 'glass-card border border-red-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3' } 
                });
            @endif
        });

        // ================= CROPPER JS LOGIC =================
        let cropper;
        const cropModal = document.getElementById('crop-modal');
        const imageToCrop = document.getElementById('image-to-crop');

        function triggerCropModal(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageToCrop.src = e.target.result;
                    imageToCrop.classList.remove('hidden');
                    
                    cropModal.classList.remove('hidden');
                    cropModal.classList.add('flex');

                    if (cropper) { cropper.destroy(); }
                    
                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 1, 
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.8,
                        restore: false,
                        guides: false,
                        center: false,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function closeCropModal() {
            cropModal.classList.add('hidden');
            cropModal.classList.remove('flex');
            document.getElementById('foto_profil').value = ''; 
            if (cropper) { cropper.destroy(); }
        }

        function applyCrop() {
            if (!cropper) return;
            
            const canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500,
            });

            const base64data = canvas.toDataURL('image/jpeg', 0.9);

            const previewImg = document.getElementById('preview-img');
            const defaultIcon = document.getElementById('default-icon');
            if(defaultIcon) { defaultIcon.classList.add('hidden'); defaultIcon.classList.remove('flex'); }
            previewImg.src = base64data;
            previewImg.classList.remove('hidden');

            document.getElementById('foto_profil_base64').value = base64data;
            document.getElementById('file-name').innerHTML = '<span class="text-emerald-500"><i class="fa-solid fa-check"></i> Foto siap disimpan!</span>';

            cropModal.classList.add('hidden');
            cropModal.classList.remove('flex');
            if (cropper) { cropper.destroy(); }
        }
        // ====================================================

        // TOGGLE THEME LOGIC
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