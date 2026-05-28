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
    
        
    
        /* --- TV Glitch & Static Runyek-Runyek Effect --- */
        .tv-glitch-container {
            position: relative;
            background: #022c22;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.4);
            border: 1.5px solid rgba(52, 211, 153, 0.4);
        }
        .tv-logo {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            opacity: 0;
            animation: tv-logo-init 4.5s cubic-bezier(0.15, 0.85, 0.35, 1) forwards,
                       tv-glitch-subtle 5s infinite 4.5s;
        }
        .tv-static-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: 0.18;
            background-image: url("data:image/svg+xml;utf8,<svg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'><filter id='noiseFilter'><feTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/></filter><rect width='100%' height='100%' filter='url(%23noiseFilter)'/></svg>");
            animation: tv-static-noise 0.1s steps(4) infinite;
            mix-blend-mode: color-dodge;
        }
        .tv-scanlines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(
                rgba(18, 16, 16, 0) 40%, 
                rgba(0, 0, 0, 0.15) 60%
            );
            background-size: 100% 3px;
            z-index: 2;
            opacity: 0.4;
        }

        /* --- CRT TV Turn-On Power Effect --- */
        .tv-turn-on-overlay {
            position: absolute;
            inset: 0;
            background: #000000;
            z-index: 10;
            pointer-events: none;
            animation: tv-screen-on 1.6s cubic-bezier(0.15, 0.85, 0.35, 1) forwards;
        }

        .tv-turn-on-overlay::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: #ffffff;
            box-shadow: 0 0 12px 2px #ffffff, 0 0 20px 4px #10b981;
            transform: scaleX(0);
            transform-origin: center;
            opacity: 0;
            animation: tv-beam-on 1.6s cubic-bezier(0.15, 0.85, 0.35, 1) forwards;
        }

        @keyframes tv-screen-on {
            0% {
                background: #000000;
                opacity: 1;
            }
            30% {
                background: #000000;
                opacity: 1;
            }
            /* TV screen flash open */
            35% {
                background: #ffffff;
                opacity: 1;
            }
            40% {
                background: #10b981;
                filter: brightness(2) contrast(1.5);
                opacity: 1;
            }
            60% {
                background: rgba(16, 185, 129, 0.2);
                opacity: 1;
            }
            100% {
                background: transparent;
                opacity: 0;
                visibility: hidden;
            }
        }

        @keyframes tv-beam-on {
            0% {
                transform: translateY(-50%) scaleX(0) scaleY(1);
                opacity: 0;
            }
            5% {
                transform: translateY(-50%) scaleX(0.01) scaleY(1);
                opacity: 1;
            }
            /* The horizontal beam shoots across */
            25% {
                transform: translateY(-50%) scaleX(1) scaleY(1);
                opacity: 1;
            }
            /* The beam pops open vertically */
            30% {
                transform: translateY(-50%) scaleX(1) scaleY(12);
                opacity: 1;
                background: #ffffff;
            }
            /* Fades and vanishes into the main screen flash */
            35% {
                transform: translateY(-50%) scaleX(1) scaleY(30);
                opacity: 0.8;
            }
            40% {
                transform: translateY(-50%) scaleX(1) scaleY(0);
                opacity: 0;
            }
            100% {
                transform: translateY(-50%) scaleX(1) scaleY(0);
                opacity: 0;
            }
        }

        @keyframes tv-static-noise {
            0% { transform: translate(0,0) scale(1); }
            10% { transform: translate(-1%, -1%) scale(1.1); }
            20% { transform: translate(1%, 2%) scale(1); }
            30% { transform: translate(-2%, -2%) scale(1.2); }
            40% { transform: translate(1%, 3%) scale(1.1); }
            50% { transform: translate(-1%, 1%) scale(1); }
            60% { transform: translate(2%, -1%) scale(1.2); }
            70% { transform: translate(-2%, 2%) scale(1.1); }
            80% { transform: translate(1%, -3%) scale(1); }
            90% { transform: translate(-1%, 2%) scale(1.2); }
            100% { transform: translate(0,0) scale(1.1); }
        }
        @keyframes tv-logo-init {
            0% {
                opacity: 0;
                transform: scaleY(0.01) scaleX(0);
                filter: invert(1) hue-rotate(180deg) brightness(2) contrast(2);
            }
            11% {
                opacity: 0;
                transform: scaleY(0.01) scaleX(0);
                filter: invert(1) hue-rotate(180deg) brightness(2) contrast(2);
            }
            /* Pop open right when the TV beam expands */
            12% {
                opacity: 1;
                transform: scale(1.35) skew(8deg);
                filter: invert(1) hue-rotate(180deg) brightness(2) contrast(2);
            }
            20% {
                opacity: 1;
                transform: scale(0.92) translate(-3px, 2px) skew(-5deg);
                filter: invert(0.85) hue-rotate(120deg) brightness(1.4) contrast(1.7);
            }
            32% {
                opacity: 1;
                transform: scale(1.06) translate(2px, -1px) skew(3deg);
                filter: invert(0.65) hue-rotate(80deg) brightness(1.2) contrast(1.4);
            }
            45% {
                opacity: 1;
                transform: scale(0.97) skew(-2deg);
                filter: invert(0.4) hue-rotate(40deg) brightness(1.1) contrast(1.2);
            }
            60% {
                opacity: 1;
                transform: scale(1.02) skew(1deg);
                filter: invert(0.18) hue-rotate(15deg) brightness(1) contrast(1.1);
            }
            80% {
                opacity: 1;
                transform: scale(1) skew(0deg);
                filter: invert(0.05) hue-rotate(5deg) brightness(1) contrast(1);
            }
            100% {
                opacity: 1;
                transform: scale(1) skew(0deg);
                filter: invert(0) hue-rotate(0deg) brightness(1) contrast(1);
            }
        }

        @keyframes tv-glitch-subtle {
            0%, 92%, 96%, 100% {
                transform: translate(0, 0) skew(0deg) scale(1);
                filter: brightness(1) contrast(1) hue-rotate(0deg) invert(0);
            }
            94% {
                transform: translate(-1.5px, 0.8px) skew(-2deg) scale(1.03);
                filter: brightness(1.2) contrast(1.15) hue-rotate(180deg) invert(0.9);
            }
            98% {
                transform: translate(1.5px, -0.8px) skew(1.5deg) scale(0.97);
                filter: brightness(0.85) contrast(1.2) hue-rotate(-15deg) invert(0.05);
            }
        }
    
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
                    <div class="tv-glitch-container relative overflow-hidden shadow-lg border border-emerald-500/20 w-16 h-16 rounded-2xl">
                        <img src="{{ asset('images/abikun.png') }}" alt="Logo" class="tv-logo w-full h-full object-cover">
                        <div class="tv-static-overlay"></div>
                        <div class="tv-scanlines"></div>
                        <div class="tv-turn-on-overlay"></div>
                    </div>
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