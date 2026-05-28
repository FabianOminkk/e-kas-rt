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
    
        
    
        /* --- Neon Broken Lamp Short-Circuit Effect --- */
        .neon-lamp-container {
            position: relative;
            background: #022c22;
            overflow: hidden;
            border: 1.5px solid rgba(52, 211, 153, 0.4);
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.4);
            animation: neon-glow-flicker 8s infinite linear;
        }
        .neon-logo-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            animation: neon-logo-flicker 8s infinite linear;
        }

        @keyframes neon-logo-flicker {
            /* 0% - 15%: Stable normal */
            0%, 15% {
                opacity: 1;
                filter: brightness(1) drop-shadow(0 0 5px rgba(52, 211, 153, 0.5));
            }
            /* 15.1%: Sudden drop to black (starts from dark) */
            15.1% {
                opacity: 0.05;
                filter: brightness(0.1) drop-shadow(0 0 0px transparent);
            }
            /* 15.3%: Blinding instant flash (instantly bright) */
            15.3% {
                opacity: 1;
                filter: brightness(2) drop-shadow(0 0 15px rgba(52, 211, 153, 0.9));
            }
            /* 15.5%: Return to normal */
            15.5% {
                opacity: 1;
                filter: brightness(1) drop-shadow(0 0 5px rgba(52, 211, 153, 0.5));
            }
            /* 15.6% - 30%: Stable normal */
            15.6%, 30% {
                opacity: 1;
                filter: brightness(1);
            }
            /* 30.1% - 34%: Hum/buzz at dim (starts from dim) */
            30.1% {
                opacity: 0.65;
                filter: brightness(0.6) drop-shadow(0 0 2px rgba(52, 211, 153, 0.2));
            }
            34% {
                opacity: 0.75;
                filter: brightness(0.7) drop-shadow(0 0 3px rgba(52, 211, 153, 0.3));
            }
            /* 34.1%: Snap off */
            34.1% {
                opacity: 0.02;
                filter: brightness(0.05);
            }
            /* 34.3%: Snap on bright */
            34.3% {
                opacity: 0.95;
                filter: brightness(1.6);
            }
            /* 34.5%: Snap off */
            34.5% {
                opacity: 0.08;
                filter: brightness(0.1);
            }
            /* 34.7%: Snap normal */
            34.7% {
                opacity: 1;
                filter: brightness(1);
            }
            /* 34.8% - 55%: Stable normal */
            34.8%, 55% {
                opacity: 1;
            }
            /* 55.1%: Instantly dark */
            55.1% {
                opacity: 0.1;
                filter: brightness(0.15);
            }
            /* 55.5%: Slowly recover from dark to normal */
            58% {
                opacity: 0.8;
                filter: brightness(0.8);
            }
            58.1% {
                opacity: 1;
                filter: brightness(1);
            }
            /* 58.2% - 75%: Stable normal */
            58.2%, 75% {
                opacity: 1;
            }
            /* 75.1% - 80%: Dim humming (stays dim for a bit) */
            75.1% {
                opacity: 0.55;
                filter: brightness(0.5) drop-shadow(0 0 1px rgba(52, 211, 153, 0.1));
            }
            80% {
                opacity: 0.65;
                filter: brightness(0.6) drop-shadow(0 0 2px rgba(52, 211, 153, 0.2));
            }
            /* 80.1%: Spark/Flash instantly bright */
            80.1% {
                opacity: 1;
                filter: brightness(1.8) drop-shadow(0 0 12px rgba(52, 211, 153, 0.8));
            }
            80.3% {
                opacity: 0.4;
                filter: brightness(0.4);
            }
            80.5% {
                opacity: 1;
                filter: brightness(1);
            }
            /* 80.6% - 92%: Stable normal */
            80.6%, 92% {
                opacity: 1;
            }
            /* 92.1% - 92.6%: Ultra fast rapid firing flickers */
            92.1% { opacity: 0.1; }
            92.2% { opacity: 0.9; }
            92.3% { opacity: 0.05; }
            92.4% { opacity: 0.95; }
            92.5% { opacity: 0.15; }
            92.6% { opacity: 1; }
            /* 92.7% - 100%: Stable normal */
            92.7%, 100% {
                opacity: 1;
                filter: brightness(1);
            }
        }

        @keyframes neon-glow-flicker {
            0%, 15%, 15.5%, 30%, 34.7%, 55%, 58.1%, 75%, 80.5%, 92%, 92.6%, 100% {
                box-shadow: 0 0 20px rgba(52, 211, 153, 0.4);
                border-color: rgba(52, 211, 153, 0.4);
            }
            15.1%, 34.1%, 34.5%, 55.1%, 92.1%, 92.3%, 92.5% {
                box-shadow: 0 0 2px rgba(52, 211, 153, 0.05);
                border-color: rgba(52, 211, 153, 0.15);
            }
            15.3%, 34.3%, 80.1% {
                box-shadow: 0 0 35px rgba(52, 211, 153, 0.8);
                border-color: rgba(52, 211, 153, 0.8);
            }
            30.1%, 34%, 75.1%, 80% {
                box-shadow: 0 0 8px rgba(52, 211, 153, 0.2);
                border-color: rgba(52, 211, 153, 0.25);
            }
            58% {
                box-shadow: 0 0 12px rgba(52, 211, 153, 0.3);
                border-color: rgba(52, 211, 153, 0.35);
            }
        }
    
    </style>
</head>
<body class="antialiased">
    
    <div class="cyber-bg">
        <!-- High-Performance Canvas for Ambient Rain Effect -->
        <canvas id="rain-canvas" style="position: absolute; inset: 0; pointer-events: none; z-index: 2;"></canvas>

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

                // --- Cinematic Falling Rain Canvas System ---
                const canvas = document.getElementById('rain-canvas');
                if (canvas) {
                    const ctx = canvas.getContext('2d');
                    let width = canvas.width = window.innerWidth;
                    let height = canvas.height = window.innerHeight;
                    
                    window.addEventListener('resize', () => {
                        width = canvas.width = window.innerWidth;
                        height = canvas.height = window.innerHeight;
                    });
                    
                    const rainCount = 140;
                    const raindrops = [];
                    
                    for (let i = 0; i < rainCount; i++) {
                        raindrops.push({
                            x: Math.random() * width,
                            y: Math.random() * height - height,
                            length: Math.random() * 25 + 15,
                            speed: Math.random() * 15 + 15,
                            opacity: Math.random() * 0.12 + 0.04,
                            weight: Math.random() * 1 + 0.5
                        });
                    }
                    
                    function animateRain() {
                        ctx.clearRect(0, 0, width, height);
                        
                        for (let i = 0; i < rainCount; i++) {
                            const r = raindrops[i];
                            ctx.beginPath();
                            ctx.strokeStyle = `rgba(52, 211, 153, ${r.opacity})`;
                            ctx.lineWidth = r.weight;
                            ctx.moveTo(r.x, r.y);
                            ctx.lineTo(r.x + 1, r.y + r.length);
                            ctx.stroke();
                            
                            r.y += r.speed;
                            r.x += 1;
                            
                            if (r.y > height) {
                                r.y = -r.length;
                                r.x = Math.random() * width;
                                r.speed = Math.random() * 15 + 15;
                            }
                        }
                        requestAnimationFrame(animateRain);
                    }
                    animateRain();
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
                    <div class="neon-lamp-container relative overflow-hidden shadow-lg w-16 h-16 rounded-2xl flex items-center justify-center">
                        <img src="{{ asset('images/abikun.png') }}" alt="Logo" class="neon-logo-img w-full h-full object-cover">
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