<!-- ==============================================
     OPCIÓN 1: AURORA GLASS (Elegante & Fluido) - v2 (Con Datos Reales)
     ============================================== -->
<div class="relative min-h-[90vh] flex items-center justify-center overflow-hidden border-b border-white/10 bg-[#050505]">
    
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-[-10%] left-[20%] w-[500px] h-[500px] bg-[#F51B1B]/20 rounded-full blur-[120px] mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[20%] w-[500px] h-[500px] bg-[#FF2121]/10 rounded-full blur-[120px] mix-blend-screen animate-pulse delay-1000"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-6 z-10 flex flex-col items-center text-center">

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md text-sm font-medium text-white mb-8 hover:bg-white/10 transition cursor-pointer">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF2121] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#F51B1B]"></span>
            </span>
            Desde 2020!
        </div>

        <h1 class="{{ $settings['hero_title_size'] ?? 'text-6xl md:text-8xl' }} font-black tracking-tight mb-8 leading-tight">
            {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF2121] to-[#F51B1B]">$1</span>', e($settings['hero_title'] ?? 'Recursos [G]Premium[/G]')) !!}
        </h1>

        <p class="text-xl text-white/70 max-w-2xl mb-12 leading-relaxed">
            {{ $settings['hero_description'] ?? 'La plataforma definitiva para creadores. Accede a miles de plugins, temas y scripts verificados.' }}
        </p>

        <!-- Main CTAs -->
        <div class="flex flex-wrap justify-center gap-4 mb-20">
            @auth
            <a href="{{ route('products.index') }}" class="px-8 py-4 bg-white text-black font-bold rounded-full hover:scale-105 transition-transform shadow-[0_0_30px_-5px_rgba(255,255,255,0.3)]">
                Empezar Ahora
            </a>
            @else
            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-black font-bold rounded-full hover:scale-105 transition-transform shadow-[0_0_30px_-5px_rgba(255,255,255,0.3)]">
                Crear Cuenta
            </a>
            @endauth
            <a href="#planes" class="px-8 py-4 bg-white/5 text-white font-bold rounded-full border border-white/10 hover:bg-white/10 transition-colors backdrop-blur-sm">
                Ver Planes
            </a>
        </div>

        <!-- THE 4 REQUIRED BUTTONS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full max-w-4xl">
            <!-- Recursos (Muestra total real) -->
            <a href="{{ route('products.index') }}" class="group bg-white/5 border border-white/10 hover:border-[#FF2121]/50 hover:bg-[#FF2121]/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300">
                <div class="text-3xl mb-3 text-[#FF2121] group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="font-bold text-gray-200">{{ number_format($productsCount ?? 0) }} Recursos</span>
                <span class="text-xs text-gray-500">Disponibles</span>
            </a>

            <!-- Soporte (Enlace a Tikets/Soporte) -->
            <a href="{{ route('user.support.index') }}" class="group bg-white/5 border border-white/10 hover:border-[#FF2121]/50 hover:bg-[#FF2121]/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300">
                <div class="text-3xl mb-3 text-[#FF2121] group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-headset"></i>
                </div>
                <span class="font-bold text-gray-200">Soporte</span>
                <span class="text-xs text-gray-500">Técnico 24/7</span>
            </a>

            <!-- Update (Enlace a Updates) -->
            <a href="{{ route('updates.index') }}" class="group bg-white/5 border border-white/10 hover:border-[#F51B1B]/50 hover:bg-[#F51B1B]/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300 relative">
                @if(($updatesCount ?? 0) > 0)
                <div class="absolute top-2 right-2 bg-[#F51B1B] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full animate-pulse">{{ $updatesCount ?? 0 }}</div>
                @endif
                <div class="text-3xl mb-3 text-[#F51B1B] group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-sync"></i>
                </div>
                <span class="font-bold text-gray-200">Updates</span>
                <span class="text-[10px] text-[#FF2121]/50">
                    {{ ($updatesCount ?? 0) > 0 ? ($updatesCount . ' Nuevos') : 'Al día' }}
                </span>
            </a>

            <!-- Puntos (Muestra Puntos de Usuario) -->
            <a href="{{ route('user.rewards') }}" class="group bg-white/5 border border-white/10 hover:border-[#F51B1B]/50 hover:bg-[#F51B1B]/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300">
                <div class="text-3xl mb-3 text-[#F51B1B] group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-coins"></i>
                </div>
                <span class="font-bold text-gray-200">
                    @auth {{ number_format(auth()->user()->points) }} Pts @else Acceder @endauth
                </span>
                <span class="text-xs text-gray-500">Mis Puntos</span>
            </a>
        </div>
    </div>
</div>