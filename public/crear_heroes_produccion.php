<?php
/**
 * SCRIPT PARA CREAR ARCHIVOS DE HEROES EN PRODUCCIÓN
 * 
 * INSTRUCCIONES:
 * 1. Sube este archivo a la raíz de tu proyecto en producción
 * 2. Accede a: https://tudominio.com/crear_heroes_produccion.php
 * 3. Una vez creados los archivos, ELIMINA este archivo por seguridad
 */

// Definir la ruta base
$basePath = __DIR__ . '/resources/views/partials/heroes';

// Crear el directorio si no existe
if (!is_dir($basePath)) {
    mkdir($basePath, 0755, true);
    echo "✅ Directorio creado: $basePath<br><br>";
} else {
    echo "ℹ️ El directorio ya existe: $basePath<br><br>";
}

// Contenido de aurora.blade.php
$auroraContent = <<<'BLADE'
<!-- ==============================================
     OPCIÓN 1: AURORA GLASS (Elegante & Fluido)
     ============================================== -->
<div class="relative min-h-[90vh] flex items-center justify-center overflow-hidden border-b border-white/10 bg-[#020617]">
    
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-[-10%] left-[20%] w-[500px] h-[500px] bg-[#F51B1B]/20 rounded-full blur-[120px] mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[20%] w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-[120px] mix-blend-screen animate-pulse delay-1000"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-6 z-10 flex flex-col items-center text-center">
        
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md text-sm font-medium text-white mb-8 hover:bg-white/10 transition cursor-pointer">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            Nueva Versión Disponible v2.5
        </div>

        <h1 class="text-6xl md:text-8xl font-black tracking-tight mb-8 leading-tight">
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
                <div class="text-3xl mb-3 text-[#FF2121] group-hover:scale-110 transition-transform duration-300">
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
BLADE;

// Contenido de cyber.blade.php
$cyberContent = <<<'BLADE'
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
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#F51B1B]/10 to-transparent rounded-full blur-3xl group-hover:bg-[#F51B1B]/20 transition-all duration-700"></div>
            
            <h1 class="text-5xl lg:text-7xl font-black text-white leading-tight mb-6 z-10">
                 {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="bg-clip-text text-transparent bg-gradient-to-r from-[#FF2121] to-[#F51B1B]">$1</span>', e($settings['hero_title'] ?? 'Todo en Uno. [G]Épico.[/G]')) !!}
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
            <a href="{{ route('products.index') }}" class="flex-1 bg-[#0f0f11] rounded-[2rem] border border-white/5 p-6 flex flex-col items-center justify-center hover:bg-[#151518] hover:border-[#F51B1B]/30 transition-all group cursor-pointer relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-[#F51B1B]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
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
                    <div class="absolute -top-2 -right-2 bg-[#F51B1B] text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#1a1a1d]">{{ $updatesCount ?? 0 }}</div>
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
BLADE;

// Contenido de stark.blade.php
$starkContent = <<<'BLADE'
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
BLADE;

// Crear los archivos
$files = [
    'aurora.blade.php' => $auroraContent,
    'cyber.blade.php' => $cyberContent,
    'stark.blade.php' => $starkContent
];

echo "<h2>Creando archivos de heroes...</h2>";

foreach ($files as $filename => $content) {
    $filepath = $basePath . '/' . $filename;
    
    if (file_put_contents($filepath, $content)) {
        echo "✅ Archivo creado exitosamente: <strong>$filename</strong><br>";
    } else {
        echo "❌ Error al crear: <strong>$filename</strong><br>";
    }
}

echo "<br><h2 style='color: green;'>✅ ¡Proceso completado!</h2>";
echo "<p><strong>IMPORTANTE:</strong> Ahora elimina este archivo (crear_heroes_produccion.php) por seguridad.</p>";
echo "<p>Los archivos fueron creados en: <code>$basePath</code></p>";
echo "<br><a href='/' style='padding: 10px 20px; background: #FF2121; color: white; text-decoration: none; border-radius: 8px;'>Ir al Home</a>";