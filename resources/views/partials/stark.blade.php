<!-- ==============================================
     OPCIÓN 2: STARK MINIMAL (Limpio & Corporativo)
     ============================================== -->
<div class="relative min-h-[85vh] flex items-center justify-center bg-[#09090b] border-b border-white/10 overflow-hidden">

    <!-- Grid lines -->
    <div class="absolute inset-0 opacity-20" 
         style="background-image: linear-gradient(#333 1px, transparent 1px), linear-gradient(90deg, #333 1px, transparent 1px); background-size: 30px 30px;">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#09090b] via-transparent to-transparent"></div>

    <div class="relative w-full max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center z-10 py-12">
        
        <!-- Left Text -->
        <div class="text-left">
            <h1 class="text-5xl lg:text-7xl font-bold text-white mb-6 leading-none">
                {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-gray-500">$1</span>', e($settings['hero_title'] ?? 'Crea sin [G]Limites[/G]')) !!}
            </h1>
            <p class="text-lg text-gray-400 mb-10 border-l-4 border-white/20 pl-6">
                {{ $settings['hero_description'] ?? 'Descargas directas, actualizaciones automáticas y soporte prioridad. Todo en un solo lugar.' }}
            </p>
            
            <div class="flex gap-4">
                <a href="{{ route('products.index') }}" class="px-8 py-3 bg-white text-black font-semibold rounded hover:bg-gray-200 transition">
                    Explorar
                </a>
            </div>
        </div>

        <!-- Right Grid (The 4 Buttons as Primary Visual) -->
        <div class="grid grid-cols-2 gap-4">
            
            <!-- Recursos Card -->
            <a href="{{ route('products.index') }}" class="bg-[#18181b] p-6 rounded-xl border border-white/5 hover:border-white/20 transition-all group hover:-translate-y-1 block">
                <div class="w-12 h-12 bg-[#27272a] rounded-lg flex items-center justify-center mb-4 group-hover:bg-white group-hover:text-black transition-colors duration-300">
                    <i class="fas fa-folder-open text-xl"></i>
                </div>
                <h3 class="text-white font-bold text-lg">Recursos</h3>
                <p class="text-gray-500 text-sm mt-1">Biblioteca completa</p>
            </a>

            <!-- Soporte Card -->
            <a href="#" class="bg-[#18181b] p-6 rounded-xl border border-white/5 hover:border-white/20 transition-all group hover:-translate-y-1 block">
                <div class="w-12 h-12 bg-[#27272a] rounded-lg flex items-center justify-center mb-4 group-hover:bg-white group-hover:text-black transition-colors duration-300">
                    <i class="fas fa-life-ring text-xl"></i>
                </div>
                <h3 class="text-white font-bold text-lg">Soporte</h3>
                <p class="text-gray-500 text-sm mt-1">Ayuda 24/7</p>
            </a>

            <!-- Update Card -->
            <a href="#" class="bg-[#18181b] p-6 rounded-xl border border-white/5 hover:border-white/20 transition-all group hover:-translate-y-1 relative block">
                @if(($updatesCount ?? 0) > 0)
                <span class="absolute top-4 right-4 bg-gray-800 text-white text-xs px-2 py-1 rounded">{{ $updatesCount ?? 0 }}</span>
                @endif
                <div class="w-12 h-12 bg-[#27272a] rounded-lg flex items-center justify-center mb-4 group-hover:bg-white group-hover:text-black transition-colors duration-300">
                    <i class="fas fa-bolt text-xl"></i>
                </div>
                <h3 class="text-white font-bold text-lg">Update</h3>
                <p class="text-gray-500 text-sm mt-1">
                     {{ ($updatesCount ?? 0) > 0 ? ($updatesCount . ' pendientes') : 'Todo actualizado' }}
                </p>
            </a>

            <!-- Puntos Card -->
            <a href="#" class="bg-[#18181b] p-6 rounded-xl border border-white/5 hover:border-white/20 transition-all group hover:-translate-y-1 block">
                <div class="w-12 h-12 bg-[#27272a] rounded-lg flex items-center justify-center mb-4 group-hover:bg-white group-hover:text-black transition-colors duration-300">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <h3 class="text-white font-bold text-lg">
                    @auth {{ number_format(auth()->user()->points) }} @else Login @endauth
                </h3>
                <p class="text-gray-500 text-sm mt-1">Mis Puntos</p>
            </a>
        </div>
    </div>
</div>