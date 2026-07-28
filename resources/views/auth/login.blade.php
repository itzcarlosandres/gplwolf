<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | GPLWolf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); }
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        .input-group:focus-within label { color: #FF2121; }
        .input-group:focus-within i { color: #FF2121; }
        .input-group:focus-within input { border-color: #FF2121; box-shadow: 0 0 0 4px rgba(255, 33, 33, 0.1); }
        .shine { position: relative; overflow: hidden; }
        .shine::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: skewX(-25deg);
            transition: left 0.6s;
        }
        .shine:hover::after { left: 150%; }
    </style>
    @if(config('services.recaptcha.key'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</head>
<body class="bg-[#080808] text-gray-300 min-h-screen flex overflow-hidden">

    <!-- Left Side: Brand & Visual -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0a0a0a] flex-col justify-between p-12 overflow-hidden">
        <!-- Background effects -->
        <div class="floating-shape w-96 h-96 bg-[#F51B1B] top-[-10%] left-[-10%]"></div>
        <div class="floating-shape w-80 h-80 bg-[#F51B1B] bottom-[-10%] right-[-10%]" style="animation-delay: 2s"></div>
        <div class="floating-shape w-64 h-64 bg-[#F51B1B] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" style="animation-delay: 4s"></div>
        
        <!-- Dot pattern -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="relative z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-white group">
                @if(isset($globalSettings['site_logo']) && $globalSettings['site_logo'])
                    <img src="{{ Storage::url($globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'WP Marketplace' }}" class="h-10 w-auto object-contain">
                @else
                    <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center text-sm shadow-lg shadow-[#F51B1B]/30 font-black">WP</div>
                @endif
                <span class="text-xl font-black tracking-tight">{{ $globalSettings['site_name'] ?? 'WP MARKET' }}</span>
            </a>
        </div>

        <div class="relative z-10 max-w-md">
            <h2 class="text-4xl font-black text-white mb-6 leading-tight">
                El marketplace<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF2121] to-[#F51B1B]">más completo</span><br>
                para WordPress
            </h2>
            <p class="text-gray-500 text-base leading-relaxed mb-10">
                Accede a miles de themes, plugins y herramientas premium. Licencia GPL, descargas directas y actualizaciones automáticas.
            </p>

            <div class="flex items-center gap-4">
                <div class="flex -space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FF2121] to-[#F51B1B] border-2 border-[#0a0a0a] flex items-center justify-center text-white text-xs font-bold">C</div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F51B1B] to-pink-500 border-2 border-[#0a0a0a] flex items-center justify-center text-white text-xs font-bold">A</div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-[#FF2121] border-2 border-[#0a0a0a] flex items-center justify-center text-white text-xs font-bold">M</div>
                </div>
                <div class="text-sm">
                    <p class="text-white font-bold">+5,000 creadores</p>
                    <p class="text-gray-500 text-xs">confían en nosotros</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 flex items-center gap-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">
            <span class="flex items-center gap-2"><i class="fas fa-shield-halved text-emerald-400"></i> GPL</span>
            <span class="flex items-center gap-2"><i class="fas fa-sync text-[#FF2121]"></i> Updates</span>
            <span class="flex items-center gap-2"><i class="fas fa-headset text-[#F51B1B]"></i> Soporte</span>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 relative">
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 32px 32px;"></div>
        
        <div class="w-full max-w-md relative z-10">
            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center justify-center gap-3 mb-10">
                @if(isset($globalSettings['site_logo']) && $globalSettings['site_logo'])
                    <img src="{{ Storage::url($globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'WP Marketplace' }}" class="h-10 w-auto object-contain">
                @else
                    <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center text-sm shadow-lg shadow-[#F51B1B]/30 font-black text-white">WP</div>
                @endif
                <span class="text-xl font-black tracking-tight text-white">{{ $globalSettings['site_name'] ?? 'WP MARKET' }}</span>
            </div>

            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-white mb-2">Bienvenido de nuevo</h1>
                <p class="text-gray-500 text-sm font-medium">Ingresa tus credenciales para continuar</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl text-rose-400 text-sm font-bold list-none">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-2"><i class="fas fa-circle-exclamation text-xs"></i> {{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                @csrf
                
                <div class="input-group text-left">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1 transition-colors">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 transition-colors"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-12 py-4 text-white placeholder:text-gray-600 focus:outline-none transition-all font-bold text-sm">
                    </div>
                </div>

                <div class="input-group text-left">
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] transition-colors">Contraseña</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-[#FF2121] hover:text-white transition">¿Olvidaste?</a>
                    </div>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 transition-colors"></i>
                        <input type="password" name="password" required
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-12 py-4 text-white placeholder:text-gray-600 focus:outline-none transition-all font-bold text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between ml-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" id="remember" class="peer sr-only">
                            <div class="w-5 h-5 rounded-md bg-[#0a0a0a] border border-white/10 peer-checked:bg-[#FF2121] peer-checked:border-[#FF2121] transition-all flex items-center justify-center">
                                <i class="fas fa-check text-white text-[10px] opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400 group-hover:text-white transition-colors">Recordarme</span>
                    </label>
                </div>

                @if(config('services.recaptcha.key'))
                <div class="flex justify-center">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}" data-theme="dark"></div>
                </div>
                @endif

                <button type="submit" class="shine w-full py-4 gradient-bg text-white font-black uppercase tracking-widest rounded-xl shadow-xl shadow-[#F51B1B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-2">
                    Entrar ahora <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-[12px] font-medium text-gray-500">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" class="text-[#FF2121] hover:text-white font-bold transition">Regístrate gratis</a>
                </p>
            </div>

            @if(config('services.recaptcha.key'))
            <div class="mt-8 text-[9px] text-gray-600 text-center uppercase tracking-widest">
                Protegido por reCAPTCHA v2
            </div>
            @endif
        </div>
    </div>

</body>
</html>