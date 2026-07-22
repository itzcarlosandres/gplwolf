<!-- ==============================================
     OPCIÓN 1: AURORA GLASS (Híbrido: Lite Móvil / Full Desktop)
     ============================================== -->
<div class="relative min-h-[60vh] md:min-h-[90vh] flex items-center justify-center overflow-hidden border-b border-white/10 bg-[#050505]">
    
    <!-- Mobile Background (Lite - Fast Load) -->
    <div class="absolute inset-0 bg-gradient-to-b from-[#F51B1B]/20 to-[#050505] md:hidden"></div>

    <!-- Desktop Background Elements (Heavy - Full Experience - Restored Original) -->
    <div class="absolute inset-0 hidden md:block">
        <div class="absolute top-[-10%] left-[20%] w-[500px] h-[500px] bg-[#F51B1B]/20 rounded-full blur-[120px] mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[20%] w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-[120px] mix-blend-screen animate-pulse delay-1000"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-6 z-10 flex flex-col items-center text-center">
        
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 backdrop-blur-md text-sm font-medium text-white mb-8 hover:bg-white/10 transition cursor-pointer">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            Nueva Versión Disponible v2.5
        </div>

        <h1 class="text-6xl md:text-8xl font-black tracking-tight mb-8 leading-tight">
            {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-shimmer-red-yellow">$1</span>', e($settings['hero_title'] ?? 'Recursos [G]Premium[/G]')) !!}
        </h1>

        <p class="text-xl text-gray-300 max-w-2xl mb-12 leading-relaxed">
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
            <!-- Recursos -->
            <a href="{{ route('products.index') }}" class="group bg-white/5 border border-white/10 hover:border-[#FF2121]/50 hover:bg-[#FF2121]/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300">
                <div class="text-3xl mb-3 text-[#FF2121] group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="font-bold text-gray-200">Recursos</span>
            </a>

            <!-- Soporte -->
            <a href="#" class="group bg-white/5 border border-white/10 hover:border-emerald-500/50 hover:bg-emerald-500/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300">
                <div class="text-3xl mb-3 text-emerald-400 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-headset"></i>
                </div>
                <span class="font-bold text-gray-200">Soporte</span>
            </a>

            <!-- Update -->
            <a href="#" class="group bg-white/5 border border-white/10 hover:border-[#F51B1B]/50 hover:bg-[#F51B1B]/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300 relative">
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

            <!-- Puntos -->
            <a href="#" class="group bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-orange-500/10 rounded-2xl p-4 flex flex-col items-center justify-center transition-all duration-300">
                <div class="text-3xl mb-3 text-orange-400 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-coins"></i>
                </div>
                <span class="font-bold text-gray-200">Puntos</span>
                <span class="text-[10px] text-orange-300/50">
                    @auth {{ number_format(auth()->user()->points) }} Pts @else Acceder @endauth
                </span>
            </a>
        </div>
    </div>
</div>