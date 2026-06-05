<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dompet Saya | {{ auth()->user()->role }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
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
        
        .digital-wallet-card { background: linear-gradient(135deg, #10b981 0%, #064e3b 100%); box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4); }
        
        .sidebar-container { width: 80px; transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1); z-index: 50; }
        .sidebar-container:hover { width: 280px; }
        .sidebar-text { opacity: 0; white-space: nowrap; transition: opacity 0.3s ease; pointer-events: none; }
        .sidebar-container:hover .sidebar-text { opacity: 1; pointer-events: auto; }
        
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        .modal-bg { background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(10px); }
        
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
        
        {{-- SIDEBAR KIRI --}}
        @include('layouts.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto bg-[#020617] p-8 relative z-10">
            <div class="max-w-5xl mx-auto">
                
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">DOMPET SAYA</h2>
                        <p class="text-emerald-500/40 text-[10px] font-bold uppercase tracking-[0.4em]">KELOLA KEUANGAN KAS ANDA</p>
                    </div>
                </div>

                {{-- OVERVIEW & DIGITAL CARD --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    
                    {{-- KARTU DIGITAL --}}
                    <div class="lg:col-span-2 digital-wallet-card rounded-[2rem] p-8 relative overflow-hidden flex flex-col justify-between animate-fade-in">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
                        <div class="relative z-10 flex justify-between items-start mb-8">
                            <div>
                                <p class="text-emerald-100/70 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Total Kontribusi {{ now()->year }}</p>
                                <h3 class="text-4xl font-black text-white tracking-tighter">Rp {{ number_format($totalTerbayarTahunIni ?? 0, 0, ',', '.') }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-md">
                                <i class="fa-solid fa-shield-halved text-white text-xl"></i>
                            </div>
                        </div>

                        <div class="relative z-10 flex justify-between items-end">
                            <div>
                                <p class="text-emerald-100/50 text-[10px] uppercase font-bold tracking-widest mb-1">Nama Pemilik</p>
                                <p class="text-white font-black tracking-widest uppercase">{{ auth()->user()->name }}</p>
                            </div>
                            <button onclick="bukaModalBayar()" class="px-6 py-3 bg-[#020617] text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-white hover:text-[#020617] transition-all shadow-xl">
                                <i class="fa-solid fa-plus mr-2"></i> Bayar Kas
                            </button>
                        </div>
                    </div>

                    {{-- PROGRESS TAHUNAN --}}
                    <div class="glass-card rounded-[2rem] p-8 flex flex-col justify-center animate-fade-in">
                        <h4 class="text-emerald-400 font-black text-xs uppercase tracking-widest mb-6 text-center">Progress Iuran {{ now()->year }}</h4>
                        
                        @php
                            $persentase = ($bulanLunas ?? 0) / 12 * 100;
                        @endphp
                        
                        <div class="relative w-32 h-32 mx-auto mb-4 flex items-center justify-center rounded-full bg-[#020617] border-8 border-white/5">
                            <svg class="absolute inset-0 w-full h-full transform -rotate-90">
                                <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="8" fill="transparent" class="text-emerald-500" stroke-dasharray="{{ 2 * 3.14 * 56 }}" stroke-dashoffset="{{ (2 * 3.14 * 56) - ((2 * 3.14 * 56) * $persentase / 100) }}"></circle>
                            </svg>
                            <div class="text-center">
                                <p class="text-2xl font-black text-white">{{ $bulanLunas ?? 0 }}<span class="text-sm text-white/40">/12</span></p>
                                <p class="text-[8px] text-emerald-500 font-bold uppercase tracking-widest">Bulan</p>
                            </div>
                        </div>
                        <p class="text-center text-[10px] text-white/50 italic">Anda telah melunasi {{ round($persentase) }}% iuran wajib tahun ini.</p>
                    </div>

                </div>

                {{-- RIWAYAT TRANSAKSI --}}
                <div class="glass-card rounded-3xl p-8 animate-fade-in">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-emerald-400 font-black text-lg uppercase tracking-tighter flex items-center gap-3">
                            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi Anda
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                {{-- HEADER TABEL: Semua rata tengah (text-center) --}}
                                <tr class="text-emerald-200/20 text-[10px] uppercase tracking-[0.2em] border-b border-white/5">
                                    <th class="pb-4 text-center">Bulan / Tahun</th>
                                    <th class="pb-4 text-center">Tanggal Bayar</th>
                                    <th class="pb-4 text-center">Nominal</th>
                                    <th class="pb-4 text-center">Status</th>
                                    <th class="pb-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-white/80 text-sm">
                                @forelse($riwayatPembayaran ?? [] as $riwayat)
                                <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-all">
                                    
                                    {{-- KOLOM BULAN/TAHUN: Diubah jadi justify-center agar ikon & teks rata tengah --}}
                                    <td class="py-5 font-bold uppercase tracking-widest text-xs text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <div class="w-8 h-8 rounded-lg {{ $riwayat->status == 'lunas' ? 'bg-emerald-500/20 text-emerald-400' : ($riwayat->status == 'ditolak' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400') }} flex items-center justify-center">
                                                <i class="fa-solid {{ $riwayat->status == 'lunas' ? 'fa-check' : ($riwayat->status == 'ditolak' ? 'fa-xmark' : 'fa-hourglass-half') }}"></i>
                                            </div>
                                            Bulan {{ $riwayat->bulan }} - {{ $riwayat->tahun }}
                                        </div>
                                    </td>
                                    
                                    <td class="py-5 text-center text-xs text-white/50">{{ $riwayat->created_at->format('d M Y') }}</td>
                                    <td class="py-5 text-center font-black">Rp {{ number_format($riwayat->nominal, 0, ',', '.') }}</td>
                                    <td class="py-5 text-center">
                                        @if($riwayat->status == 'lunas')
                                            <span class="px-3 py-1.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-black rounded-md border border-emerald-500/30 uppercase">Berhasil</span>
                                        @elseif($riwayat->status == 'menunggu')
                                            <span class="px-3 py-1.5 bg-yellow-500/20 text-yellow-400 text-[9px] font-black rounded-md border border-yellow-500/30 uppercase">Diproses</span>
                                        @else
                                            <span class="px-3 py-1.5 bg-red-500/20 text-red-400 text-[9px] font-black rounded-md border border-red-500/30 uppercase">Ditolak</span>
                                        @endif
                                    </td>
                                    
                                    {{-- KOLOM AKSI: Diubah dari text-right jadi text-center --}}
                                    <td class="py-5 text-center">
                                        <button onclick="lihatBukti('{{ asset('storage/' . $riwayat->bukti_transfer) }}')" class="px-4 py-2 bg-blue-500/10 text-blue-400 text-[9px] font-black uppercase rounded-lg border border-blue-500/30 hover:bg-blue-500 hover:text-white transition-all">
                                            Lihat Struk
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-receipt text-2xl text-white/20"></i>
                                        </div>
                                        <p class="text-white/40 uppercase font-black tracking-widest text-[10px]">Belum ada riwayat transaksi</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    {{-- MODAL PEMBAYARAN KAS & QRIS --}}
    <div id="modalBayar" class="fixed inset-0 z-[100] hidden items-center justify-center modal-bg px-4 py-8">
        <div class="glass-card w-full max-w-md rounded-[2.5rem] p-8 border border-emerald-500/30 max-h-full overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-emerald-400 font-black text-xl uppercase italic tracking-tighter">Pembayaran Kas</h3>
                <button onclick="tutupModalBayar()" class="text-white/40 hover:text-red-500 transition-colors text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div class="mb-6 space-y-3">
                <p class="text-[10px] font-black text-white/50 uppercase tracking-widest mb-2">Metode Pembayaran:</p>
                
                {{-- OPSI QRIS --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-3 flex items-center gap-4 hover:bg-white/10 transition-all group">
                    <div class="w-14 h-10 bg-white rounded-lg flex items-center justify-center p-1 shadow-lg">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <p class="text-sm font-black text-white tracking-widest">QRIS PAYMENT</p>
                    </div>
                    <button type="button" onclick="tampilkanQris()" class="ml-auto text-[9px] font-black bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-3 py-2 rounded-lg hover:bg-emerald-500 hover:text-[#020617] transition-all uppercase">
                        Buka QR
                    </button>
                </div>

                {{-- BCA --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-3 flex items-center gap-4 hover:bg-white/10 transition-all group">
                    <div class="w-14 h-10 bg-white rounded-lg flex items-center justify-center p-2 shadow-lg">
                        <img src="{{ asset('images/bca.png') }}" alt="BCA" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <p class="text-sm font-black text-white tracking-widest">1234 5678 90</p>
                        <p class="text-[8px] text-white/60 uppercase font-bold">a.n Kas RT (Bpk. Fabian)</p>
                    </div>
                    <button type="button" onclick="salinTeks('1234567890')" class="ml-auto text-white/20 hover:text-blue-400 p-2 transition-colors"><i class="fa-regular fa-copy"></i></button>
                </div>
            </div>

            <form action="{{ route('pembayaran.store') ?? '#' }}" method="POST" enctype="multipart/form-data" class="space-y-4"> 
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Bulan Kas</label>
                        <select name="bulan" required class="w-full bg-[#020617] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 transition-all text-white">
                            <option value="{{ now()->month }}">{{ now()->format('F') }} (Saat Ini)</option>
                            <option value="{{ now()->addMonth()->month }}">Bulan Depan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Nominal (Rp)</label>
                        <input type="number" name="nominal" value="100000" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 transition-all text-white">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">Upload Bukti Transfer</label>
                    <input type="file" name="bukti_transfer" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 transition-all text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500 hover:file:text-white">
                </div>
                <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-[#022c22] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition-all">Kirim Bukti Pembayaran</button>
            </form>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = localStorage.getItem('theme') || 'dark';
            updateToggleButtonUI(currentTheme);

            @if(session('success'))
                Swal.fire({ icon: 'success', title: '<span class="text-white font-black uppercase italic">BERHASIL!</span>', text: {!! json_encode(session('success')) !!}, background: '#020617', confirmButtonColor: '#10b981', customClass: { popup: 'glass-card border border-emerald-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-[#020617]' } });
            @endif
            @if(session('error'))
                Swal.fire({ icon: 'error', title: '<span class="text-white font-black uppercase italic">GAGAL!</span>', text: {!! json_encode(session('error')) !!}, background: '#020617', confirmButtonColor: '#ef4444', customClass: { popup: 'glass-card border border-red-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3' } });
            @endif
        });

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

        function bukaModalBayar() { const modal = document.getElementById('modalBayar'); modal.classList.remove('hidden'); modal.classList.add('flex'); }
        function tutupModalBayar() { const modal = document.getElementById('modalBayar'); modal.classList.add('hidden'); modal.classList.remove('flex'); }
        function salinTeks(teks) { navigator.clipboard.writeText(teks).then(() => { Swal.fire({ icon: 'success', title: '<span class="text-white font-black uppercase italic">TERSALIN!</span>', text: 'Nomor tujuan berhasil disalin.', timer: 1500, showConfirmButton: false, background: '#020617', customClass: { popup: 'glass-card border border-emerald-500/30 rounded-3xl' } }); }); }
        
        function lihatBukti(url) { 
            Swal.fire({ 
                title: '<span class="text-white text-xs font-black uppercase tracking-widest">Struk Pembayaran</span>', 
                imageUrl: url, 
                imageAlt: 'Bukti', 
                background: '#020617', 
                confirmButtonColor: '#10b981', 
                confirmButtonText: 'TUTUP', 
                customClass: { popup: 'glass-card border border-white/10 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-[#020617]' } 
            }); 
        }

        function tampilkanQris() {
            Swal.fire({
                title: '<span class="text-white text-lg font-black uppercase tracking-widest italic">Scan QRIS Ini</span>',
                html: '<p class="text-white/60 text-xs mb-4 uppercase font-bold tracking-widest">Kas RT - Bpk. Fabian</p>',
                imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg',
                imageWidth: 200, imageHeight: 200, imageAlt: 'QRIS Pembayaran', background: '#020617', confirmButtonColor: '#10b981', confirmButtonText: 'SAYA SUDAH SCAN & BAYAR',
                customClass: { popup: 'glass-card border border-emerald-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-[#020617]', image: 'bg-white p-4 rounded-2xl' }
            });
        }

        function confirmLogout(e) {
            e.preventDefault(); 
            Swal.fire({
                title: '<span class="text-white font-black uppercase italic">LOGOUT?</span>', text: "Yakin anda ingin keluar dari sistem?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#1e293b', confirmButtonText: 'YA, KELUAR', cancelButtonText: 'BATAL', background: '#020617',
                customClass: { popup: 'glass-card border border-red-500/30 rounded-3xl', confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3', cancelButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-white' }
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('logout-form').submit(); }
            });
        }
    </script>
</body>
</html>