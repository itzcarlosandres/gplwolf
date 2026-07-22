<!-- ==============================================
     OPCIÓN 4: MINIMALIST STARK (Minimalista & Tipografía Gigante)
     ============================================== -->
<div class="relative min-h-[88vh] flex items-center justify-center bg-[#09090b] overflow-hidden border-b border-white/5 py-24">
    <!-- Subtle linear background glow -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-gradient-to-b from-[#FF2121]/15 via-transparent to-transparent blur-[120px]"></div>
    </div>

    <div class="relative w-full max-w-6xl mx-auto px-6 text-center z-10">

        <!-- Top pill -->
        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/[0.04] border border-white/10 text-xs font-semibold text-gray-300 mb-10 hover:border-[#FF2121]/40 transition-colors">
            <span class="w-1.5 h-1.5 rounded-full bg-[#FF2121]"></span>
            <span>Edición GPLWolf 2026</span>
            <span class="text-gray-500">|</span>
            <span class="text-amber-400 font-bold">GPL v3.0</span>
        </div>

        <!-- Huge Stark Typography -->
        <h1 class="{{ $settings['hero_title_size'] ?? 'text-6xl md:text-8xl' }} font-black text-white mb-8 tracking-tighter leading-[0.92]">
            {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="underline decoration-[#FF2121] decoration-wavy underline-offset-8 text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-100 to-gray-300">$1</span>', e($settings['hero_title'] ?? 'Simplicidad & [G]Potencia[/G] Total')) !!}
        </h1>

        <!-- Subtitle -->
        <p class="text-xl md:text-2xl text-gray-400 max-w-2xl mx-auto mb-14 font-light leading-relaxed">
            {{ $settings['hero_description'] ?? 'Descargas directas y limpias sin ataduras ni suscripciones forzosas. Tu biblioteca WordPress centralizada.' }}
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap justify-center items-center gap-5 mb-20">
            @auth
            <a href="{{ route('products.index') }}" class="px-10 py-5 bg-white text-black font-extrabold text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-100 hover:scale-105 transition-all shadow-2xl">
                Ver Catálogo
            </a>
            @else
            <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-black font-extrabold text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-100 hover:scale-105 transition-all shadow-2xl">
                Crear Cuenta Gratis
            </a>
            @endauth

            <a href="#planes" class="px-10 py-5 bg-white/5 hover:bg-white/10 text-white font-extrabold text-xs uppercase tracking-[0.2em] rounded-2xl border border-white/10 transition-all">
                Planes Ilimitados
            </a>
        </div>

        <!-- Clean Feature Strip -->
        <div class="pt-10 border-t border-white/5 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto text-left">
            <div class="flex items-start gap-3">
                <i class="fas fa-check text-[#FF2121] mt-1 text-sm"></i>
                <div>
                    <h5 class="text-xs font-bold text-white uppercase tracking-wider">Sin Malware</h5>
                    <p class="text-[11px] text-gray-500">Archivos 100% originales</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-bolt text-amber-400 mt-1 text-sm"></i>
                <div>
                    <h5 class="text-xs font-bold text-white uppercase tracking-wider">Velocidad Máxima</h5>
                    <p class="text-[11px] text-gray-500">Servidores de alta tasa</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-arrows-rotate text-[#F51B1B] mt-1 text-sm"></i>
                <div>
                    <h5 class="text-xs font-bold text-white uppercase tracking-wider">Auto Updates</h5>
                    <p class="text-[11px] text-gray-500">Sincronización en 1-click</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-shield text-emerald-400 mt-1 text-sm"></i>
                <div>
                    <h5 class="text-xs font-bold text-white uppercase tracking-wider">Licencia GPL</h5>
                    <p class="text-[11px] text-gray-500">Uso ilimitado de sitios</p>
                </div>
            </div>
        </div>
    </div>
</div>