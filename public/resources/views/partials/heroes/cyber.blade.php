<!-- ==============================================
     OPCIÓN 3: CYBER BENTO (Estilo App/Grid)
     ============================================== -->
<div class="relative min-h-[90vh] flex items-center justify-center bg-[#050505] overflow-hidden">
    
    <!-- Glows -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#F51B1B]/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-[#F51B1B]/20 rounded-full blur-[120px]"></div>

    <div class="relative w-full max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Main Large Block (Left) -->
        <div class="lg:col-span-3 bg-[#0f0f11] rounded-[2rem] border border-white/5 p-12 flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#FF2121]/10 to-transparent rounded-full blur-3xl group-hover:bg-[#FF2121]/20 transition-all duration-700"></div>
            
            <h1 class="text-5xl lg:text-7xl font-black text-white leading-tight mb-6 z-10">
                 {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="bg-clip-text text-transparent bg-gradient-to-r from-[#FF2121] to-pink-400">$1</span>', e($settings['hero_title'] ?? 'Todo en Uno. [G]Épico.[/G]')) !!}
            </h1>
            <p class="text-lg text-gray-400 mb-8 max-w-lg z-10">
                {{ $settings['hero_description'] ?? 'Plugins, temas y herramientas para desarrolladores. La colección más completa del mercado.' }}
            </p>
            <div class="flex gap-4 z-10">
                <a href="{{ route('products.index') }}" class="bg-white text-black px-8 py-4 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Explorar Todo
                </a>
            </div>
        </div>

        <!-- Vertical Stack (Right) -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            
            <!-- Recursos Box -->
            <a href="{{ route('products.index') }}" class="flex-1 bg-[#0f0f11] rounded-[2rem] border border-white/5 p-6 flex flex-col items-center justify-center hover:bg-[#151518] hover:border-[#FF2121]/30 transition-all group cursor-pointer relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-[#FF2121]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <!-- Animated Icon -->
                <div class="w-16 h-16 rounded-2xl bg-[#1a1a1d] text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-all duration-300 shadow-lg shadow-[#F51B1B]/20">
                    <i class="fas fa-cubes text-[#FF2121]"></i>
                </div>
                <div class="text-center z-10">
                    <h3 class="text-white font-bold text-xl">Recursos</h3>
                    <p class="text-xs text-gray-500 mt-1">Ver Catálogo</p>
                </div>
            </a>

            <!-- Soporte Box -->
            <a href="#" class="flex-1 bg-[#0f0f11] rounded-[2rem] border border-white/5 p-6 flex flex-col items-center justify-center hover:bg-[#151518] hover:border-emerald-500/30 transition-all group cursor-pointer relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 rounded-2xl bg-[#1a1a1d] text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-all duration-300 shadow-lg shadow-emerald-900/20">
                    <i class="fas fa-headset text-emerald-400"></i>
                </div>
                <div class="text-center z-10">
                    <h3 class="text-white font-bold text-xl">Soporte</h3>
                    <p class="text-xs text-gray-500 mt-1">Ayuda 24/7</p>
                </div>
            </a>

        </div>

        <!-- Bottom Horizontal Stack -->
        <div class="lg:col-span-4 grid grid-cols-2 gap-6">
             <!-- Update Box -->
             <a href="#" class="bg-[#0f0f11] rounded-[2rem] border border-white/5 p-6 flex items-center gap-6 hover:bg-[#151518] hover:border-[#FF2121]/30 transition-all group cursor-pointer relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-full bg-gradient-to-l from-[#FF2121]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 rounded-2xl bg-[#1a1a1d] text-white flex items-center justify-center text-2xl flex-shrink-0 group-hover:scale-110 transition-all duration-500 shadow-lg shadow-[#F51B1B]/20 relative">
                    <i class="fas fa-sync-alt text-[#FF2121]"></i>
                    @if(($updatesCount ?? 0) > 0)
                    <div class="absolute -top-2 -right-2 bg-[#FF2121] text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#1a1a1d]">{{ $updatesCount ?? 0 }}</div>
                    @endif
                </div>
                <div>
                    <h3 class="text-white font-bold text-xl">Updates</h3>
                    <p class="text-sm text-gray-400">
                         {{ ($updatesCount ?? 0) > 0 ? ($updatesCount . ' Nuevas versiones') : 'Todo al día' }}
                    </p>
                </div>
                <div class="ml-auto text-gray-600 group-hover:text-white group-hover:translate-x-2 transition-all">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Puntos Box -->
            <a href="#" class="bg-[#0f0f11] rounded-[2rem] border border-white/5 p-6 flex items-center gap-6 hover:bg-[#151518] hover:border-orange-500/30 transition-all group cursor-pointer relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-full bg-gradient-to-l from-orange-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 rounded-2xl bg-[#1a1a1d] text-white flex items-center justify-center text-2xl flex-shrink-0 group-hover:scale-110 transition-all duration-300 shadow-lg shadow-orange-900/20">
                    <i class="fas fa-gem text-orange-400"></i>
                </div>
                <div>
                    <h3 class="text-white font-bold text-xl">
                        @auth {{ number_format(auth()->user()->points) }} @else Login @endauth
                    </h3>
                    <p class="text-sm text-gray-400">Puntos Disponibles</p>
                </div>
                <div class="ml-auto text-gray-600 group-hover:text-white group-hover:translate-x-2 transition-all">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</div>