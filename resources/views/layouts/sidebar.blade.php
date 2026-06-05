<aside class="sidebar-container glass-sidebar flex flex-col p-4 group">
    <div class="mb-10 flex items-center gap-4 overflow-hidden px-2">
        <img src="{{ asset('images/abikun.png') }}" alt="Logo" class="min-w-[40px] w-10 h-10 rounded-xl object-cover shadow-lg border border-emerald-500/20">
        <div class="sidebar-text">
            <h1 class="text-xl font-black tracking-tighter uppercase text-emerald-400 leading-none">Kas RT</h1>
            <p class="text-white text-[8px] font-bold uppercase tracking-[0.3em]">Managed By Fabian</p>
        </div>
    </div>

    <nav class="flex-1 space-y-3">
        <a href="{{ request()->routeIs('dashboard') ? '#dashboard-top' : route('dashboard') }}" id="nav-dashboard" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('dashboard') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl shadow-lg transition-all {{ request()->routeIs('dashboard') ? 'nav-scroll-link' : '' }}">
            <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-house"></i></div>
            <span class="sidebar-text text-xs font-black uppercase tracking-widest">Dashboard</span>
        </a>
        
        @if(auth()->user()->role == 'warga')
            <a href="{{ route('asset.index') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('asset.index') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all">
                <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-boxes-stacked"></i></div>
                <span class="sidebar-text text-xs font-black uppercase tracking-widest">Inventaris Aset</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('profile.edit') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all">
                <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                <span class="sidebar-text text-xs font-black uppercase tracking-widest">Ubah Profil</span>
            </a>
            <a href="{{ route('dompet.index') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('dompet.index') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all">
                <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-wallet"></i></div>
                <span class="sidebar-text text-xs font-black uppercase tracking-widest">Dompet Saya</span>
            </a>
        @else
            <a href="{{ route('warga.index') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('warga.index') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all">
                <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-users"></i></div>
                <span class="sidebar-text text-xs font-black uppercase tracking-widest">Data Warga</span>
            </a>
            <a href="{{ route('asset.index') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('asset.index') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all">
                <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-boxes-stacked"></i></div>
                <span class="sidebar-text text-xs font-black uppercase tracking-widest">Inventaris Aset</span>
            </a>
            <a href="{{ request()->routeIs('dashboard') ? '#mading-informasi' : route('dashboard') . '#mading-informasi' }}" class="flex items-center gap-4 px-3 py-3 text-emerald-200/50 hover:bg-white/5 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'nav-scroll-link' : '' }}">
                <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-bullhorn"></i></div>
                <span class="sidebar-text text-xs font-black uppercase tracking-widest">Announcement</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-3 py-3 {{ request()->routeIs('profile.edit') ? 'bg-emerald-500 text-[#022c22]' : 'text-emerald-200/50 hover:bg-white/5' }} rounded-xl transition-all">
                <div class="min-w-[24px] flex justify-center"><i class="fa-solid fa-user-gear"></i></div>
                <span class="sidebar-text text-xs font-black uppercase tracking-widest">Setting Profil</span>
            </a>
        @endif
    </nav>

    <div class="mt-auto pt-6 border-t border-white/5 overflow-hidden">
        <div class="flex items-center gap-4 mb-6 px-1">
            @if(auth()->user()->foto_profil)
                <img src="{{ str_starts_with(auth()->user()->foto_profil, 'data:image') ? auth()->user()->foto_profil : asset('profil/' . auth()->user()->foto_profil) }}" alt="Avatar" class="min-w-[40px] w-10 h-10 rounded-full object-cover border-2 border-emerald-500/50 shadow-lg">
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
