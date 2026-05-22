<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAS RT | Financial Elite</title>
    <link class="rounded-full" rel="icon" type="image/png" href="{{ asset('images/abikun.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; background-color: #022c22; }

        .cyber-bg {
            position: relative;
            width: 100%;
            height: 100vh;
            background: linear-gradient(-45deg, #022c22, #052e16, #064e3b, #022c22);
            background-size: 400% 400%;
            animation: drift 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes drift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fall {
            0% { transform: translateY(-15vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.7; }
            90% { opacity: 0.7; }
            100% { transform: translateY(115vh) rotate(720deg); opacity: 0; }
        }

        .dollar-particle {
            position: absolute;
            color: #fbbf24;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(251, 191, 36, 0.4);
            pointer-events: none;
            z-index: 5;
            animation: fall linear infinite;
            top: 0;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            z-index: 20;
            width: 100%;
            max-width: 380px;
            padding: 2.5rem;
            border-radius: 35px;
        }

        .neon-logo {
            animation: neonPulse 4s ease-in-out infinite;
            color: #34d399;
        }

        @keyframes neonPulse {
            0%, 100% { filter: drop-shadow(0 0 5px rgba(52, 211, 153, 0.5)); transform: translateY(0); }
            50% { filter: drop-shadow(0 0 15px rgba(52, 211, 153, 0.8)); transform: translateY(-8px); }
        }

        /* Animasi Muncul untuk Notifikasi */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .notif-animate { animation: slideIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="antialiased">
    
    <div class="cyber-bg">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.querySelector('.cyber-bg');
                const particleCount = 40;
                for (let i = 0; i < particleCount; i++) {
                    const dollar = document.createElement('div');
                    dollar.className = 'dollar-particle';
                    dollar.innerText = '$';
                    dollar.style.left = Math.random() * 100 + 'vw';
                    const duration = Math.random() * 4 + 4; 
                    dollar.style.animationDuration = duration + 's';
                    dollar.style.animationDelay = Math.random() * 8 + 's';
                    dollar.style.fontSize = (Math.random() * 10 + 20) + 'px';
                    container.appendChild(dollar);
                }
            });
        </script>

        <div class="glass-card">
            @if(session('success'))
            <div class="notif-animate mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">System Message</p>
                    <p class="text-[9px] text-emerald-500/70 font-bold uppercase">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="notif-animate mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-2xl flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-red-500/20 flex items-center justify-center text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-red-400 uppercase tracking-widest">Error Detected</p>
                    <p class="text-[9px] text-red-500/70 font-bold uppercase">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            <div class="text-center mb-8">
                <div class="inline-block mb-3 neon-logo">
                    <img src="{{ asset('images/abikun.png') }}" alt="Logo" class="w-16 h-16 rounded-2xl object-cover shadow-lg border border-emerald-500/20">
                </div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight uppercase">Kas <span class="text-emerald-400">RT</span></h1>
                <p class="text-emerald-200/40 text-[8px] font-bold uppercase tracking-[0.4em] mt-1 italic">Financial Elite</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-emerald-400/70 uppercase tracking-widest px-1">Masukkan Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="w-full px-5 py-3.5 bg-white/5 border border-white/10 rounded-2xl text-white text-sm outline-none focus:border-emerald-500 focus:bg-white/10 transition-all placeholder-white/20"
                        placeholder="example@mail.com">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-emerald-400/70 uppercase tracking-widest px-1">Masukkan Password</label>
                    <input type="password" name="password" required 
                        class="w-full px-5 py-3.5 bg-white/5 border border-white/10 rounded-2xl text-white text-sm outline-none focus:border-emerald-500 focus:bg-white/10 transition-all"
                        placeholder="••••••••">
                </div>

                <button type="submit" class="w-full py-4 mt-2 bg-emerald-500 hover:bg-emerald-400 text-[#022c22] font-black rounded-2xl shadow-lg shadow-emerald-500/20 transition-all transform active:scale-95 uppercase text-[10px] tracking-widest">
                    Submit Access
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-white/30 font-bold uppercase tracking-widest">
                    Belum terdaftar sebagai warga? 
                </p>
                <a href="{{ route('register') }}" class="inline-block mt-2 text-emerald-400 hover:text-emerald-300 font-black text-[11px] uppercase tracking-wider border-b border-emerald-400/30 pb-1 transition-all">
                    Klik disini untuk Register
                </a>
            </div>

            <div class="mt-10 pt-6 border-t border-white/5">
                <p class="text-[9px] text-white/20 font-bold uppercase tracking-[0.4em] text-center">
                    ARCHITECTURE BY FABIAN TAMFAN
                </p>
            </div>
        </div>
    </div>

</body>
</html>