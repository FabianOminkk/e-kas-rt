<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Warga | KAS RT</title>
    <link class="rounded-full" rel="icon" type="image/png" href="{{ asset('images/abikun.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #022c22; }
        .glass-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .input-field { background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s; color: white; }
        .input-field:focus { border-color: #10b981; box-shadow: 0 0 10px rgba(16, 185, 129, 0.2); }
        /* Memperbaiki warna opsi dropdown agar terlihat di background gelap */
        select option { background-color: #022c22; color: white; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 py-10">
    <div class="glass-card w-full max-w-md rounded-[40px] p-10">
        <div class="flex flex-col items-center mb-8">
            <h1 class="text-3xl font-extrabold text-white italic">KAS <span class="text-emerald-400">RT</span></h1>
            <p class="text-[10px] text-emerald-500/60 font-bold uppercase tracking-[0.3em] mt-2">Registrasi Warga Baru</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4" onsubmit="this.querySelector('button[type=submit]').disabled=true; this.querySelector('button[type=submit]').innerText='REGISTERING...';">
            @csrf
            
            <div>
                <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none" placeholder="Nama sesuai KTP">
            </div>

            <div>
                <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none" placeholder="email@warga.com">
            </div>

            {{-- Menambahkan Input yang kurang dan menyesuaikan no_telp --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Tgl Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none">
                </div>
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">No. Telepon (WA)</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none" placeholder="0812xxxx">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Gender</label>
                    <select name="jenis_kelamin" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none">
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Agama</label>
                    <select id="agama_select" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none">
                        <option value="" disabled {{ !old('agama') ? 'selected' : '' }}>Pilih Agama</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        <option value="dll" {{ (old('agama') && !in_array(old('agama'), ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])) ? 'selected' : '' }}>Lainnya (dll)</option>
                    </select>
                    <input type="hidden" name="agama" id="agama_hidden" value="{{ old('agama') }}">
                </div>
            </div>

            <div id="agama_lainnya_wrapper" class="{{ (old('agama') && !in_array(old('agama'), ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])) ? '' : 'hidden' }}">
                <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Agama Lainnya</label>
                <input type="text" id="agama_lainnya" class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none" placeholder="Masukkan Agama Anda" value="{{ (old('agama') && !in_array(old('agama'), ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])) ? old('agama') : '' }}">
            </div>

            <div>
                <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Alamat Lengkap</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none" placeholder="Blok / No. Rumah">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Password</label>
                    <input type="password" name="password" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none" placeholder="********">
                </div>
                <div>
                    <label class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 block px-1">Konfirmasi</label>
                    <input type="password" name="password_confirmation" required class="input-field w-full px-5 py-3 rounded-2xl text-sm outline-none" placeholder="********">
                </div>
            </div>

            <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-[#022c22] font-black py-4 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-xs mt-6">
                DAFTAR SEKARANG
            </button>
        </form>

        <div class="mt-8 text-center border-t border-white/5 pt-6">
            <a href="{{ route('login') }}" class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest hover:underline">
                Sudah punya akun? Login disini
            </a>
            <p class="text-[9px] text-white/20 font-bold uppercase tracking-[0.4em] mt-6">ARCHITECTURE BY FABIAN TAMFAN</p>
        </div>
    </div>

    {{-- SCRIPT ERROR HANDLING & AGAMA LOGIC --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agamaSelect = document.getElementById('agama_select');
            const agamaLainnyaWrapper = document.getElementById('agama_lainnya_wrapper');
            const agamaLainnya = document.getElementById('agama_lainnya');
            const agamaHidden = document.getElementById('agama_hidden');

            function updateAgama() {
                if (agamaSelect.value === 'dll') {
                    agamaLainnyaWrapper.classList.remove('hidden');
                    agamaLainnya.required = true;
                    agamaHidden.value = agamaLainnya.value;
                } else {
                    agamaLainnyaWrapper.classList.add('hidden');
                    agamaLainnya.required = false;
                    agamaHidden.value = agamaSelect.value;
                }
            }

            agamaSelect.addEventListener('change', updateAgama);
            agamaLainnya.addEventListener('input', updateAgama);
            
            // Set initial state
            updateAgama();
        });

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: '<span class="text-white font-black uppercase italic">REGISTRASI GAGAL!</span>',
                html: `
                    <div class="text-left text-xs text-white/80 mb-3">Mohon periksa kembali data Anda:</div>
                    <ul class="text-left text-[10px] text-red-400 list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                background: '#022c22',
                confirmButtonColor: '#10b981',
                customClass: {
                    popup: 'border border-emerald-500/30 rounded-3xl',
                    confirmButton: 'rounded-xl font-black uppercase text-[10px] px-8 py-3 text-[#022c22]'
                }
            });
        @endif
    </script>
</body>
</html>