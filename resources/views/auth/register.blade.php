<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta | WP Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;400;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #121f40; color: white; }
        button { background-color: #FF2121; }
        button:hover { background-color: #F51B1B; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .gradient-bg { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); }
    </style>
</head>
<body class="bg-[#121f40] min-h-screen flex items-center justify-center p-6 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
    
    <div class="max-w-md w-full relative">
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-[#F51B1B]/20 blur-[100px] rounded-full animate-pulse"></div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-[#F51B1B]/20 blur-[100px] rounded-full animate-pulse delay-700"></div>

        <div class="glass p-10 rounded-[48px] border-white/5 shadow-2xl relative z-10 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-2xl font-black tracking-tighter mb-8 group text-white hover:opacity-90 transition">
                @if(isset($globalSettings['site_logo']) && $globalSettings['site_logo'])
                    <img src="{{ Storage::url($globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'WP Marketplace' }}" class="h-14 w-auto object-contain">
                @else
                    <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center text-sm shadow-xl shadow-[#F51B1B]/20 text-white">WP</div>
                    <span>{{ $globalSettings['site_name'] ?? 'WP MARKET' }}</span>
                @endif
            </a>

            <h1 class="text-3xl font-black text-white mb-2">Únete hoy</h1>
            <p class="text-gray-500 text-sm font-bold uppercase tracking-widest mb-10">Crea tu cuenta gratuita de WP Market</p>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl text-rose-400 text-xs font-bold list-none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <div class="text-left">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 ml-1">Nombre Completo</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-gray-600"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-12 py-4 text-white placeholder:text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-bold">
                    </div>
                </div>

                <div class="text-left">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 ml-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-gray-600"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-12 py-4 text-white placeholder:text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-bold">
                    </div>
                </div>

                <div class="text-left">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 ml-1">Contraseña</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-gray-600"></i>
                        <input type="password" name="password" required autocomplete="new-password"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-12 py-4 text-white placeholder:text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-bold">
                    </div>
                </div>

                <div class="text-left">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 ml-1">Confirmar Contraseña</label>
                    <div class="relative">
                        <i class="fas fa-shield-alt absolute left-5 top-1/2 -translate-y-1/2 text-gray-600"></i>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-12 py-4 text-white placeholder:text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-bold">
                    </div>
                </div>

                <button type="submit" class="w-full py-5 gradient-bg text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-[#F51B1B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                    Comenzar ahora <i class="fas fa-rocket ml-2"></i>
                </button>
            </form>

            <div class="mt-10 pt-10 border-t border-white/5">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}" class="text-[#FF2121] hover:text-white transition ml-2">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>