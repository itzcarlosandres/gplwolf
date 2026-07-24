<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - 5 Diseños Ultra Minimalistas | GPLWolf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF2121',
                        secondary: '#F51B1B',
                        accent: '#f59e0b',
                        dark: '#050505',
                        zinc: {
                            950: '#08080a',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #050505; }
        
        /* Design 5 Blob animation */
        @keyframes blob-orbit {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -40px) scale(1.2); }
            66% { transform: translate(-20px, 20px) scale(0.8); }
        }
        .blob-anim {
            animation: blob-orbit 8s infinite ease-in-out;
        }
    </style>
</head>
<body class="text-gray-300 min-h-screen pb-32" x-data="{ activeDesign: 'invisible' }">

    <!-- Header Section -->
    <div class="py-16 text-center max-w-4xl mx-auto px-6">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-bold uppercase text-gray-400 tracking-widest mb-6">
            ✦ Galería Curada - Edición Minimalista
        </span>
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white tracking-tighter leading-none mb-6">
            Diseños <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-400 via-white to-gray-400">Ultra-Minimalistas</span>
        </h1>
        <p class="text-gray-500 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
            Propuestas que se alejan de los formatos genéricos, basadas en la tipografía, el espacio negativo y micro-interacciones sutiles de alta gama.
        </p>
    </div>

    <!-- Design Switcher Tabs -->
    <div class="max-w-4xl mx-auto mb-16 px-6 relative z-50">
        <div class="bg-white/5 border border-white/5 p-1 rounded-2xl flex flex-wrap justify-between items-center gap-1 backdrop-blur-md">
            <button @click="activeDesign = 'invisible'" :class="activeDesign === 'invisible' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                1. Invisible Ink
            </button>
            <button @click="activeDesign = 'zeroframe'" :class="activeDesign === 'zeroframe' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                2. Zero Frame Overlay
            </button>
            <button @click="activeDesign = 'swiss'" :class="activeDesign === 'swiss' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                3. Swiss Grid
            </button>
            <button @click="activeDesign = 'drawer'" :class="activeDesign === 'drawer' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                4. Slim Drawer List
            </button>
            <button @click="activeDesign = 'liquid'" :class="activeDesign === 'liquid' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                5. Liquid blob accent
            </button>
        </div>
    </div>

    @php
        $products = \App\Models\Product::where('is_active', true)
            ->whereNull('deleted_at')
            ->limit(6)
            ->get()
            ->map(function($p) {
                return [
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'type' => $p->type,
                    'price' => $p->price,
                    'rating' => $p->rating,
                    'reviews' => $p->reviews_count,
                    'downloads' => $p->downloads_count,
                    'badge' => $p->badge,
                    'version' => $p->version,
                    'thumb' => $p->thumbnail ? asset('storage/' . $p->thumbnail) : null,
                ];
            });
    @endphp

    <!-- ============================================ -->
    <!-- DISEÑO 1: INVISIBLE INK -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'invisible'" class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($products as $index => $p)
            <div class="relative bg-transparent group flex flex-col justify-between py-6 border-b border-white/5 hover:border-white/20 transition-all duration-500">
                <div>
                    <!-- Index Number -->
                    <span class="font-mono text-[10px] text-gray-600 block mb-6 tracking-widest">[ 0{{ $index + 1 }} ]</span>
                    
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">{{ $p['type'] }}</span>
                        <span class="w-1 h-1 bg-white/10 rounded-full"></span>
                        <span class="text-[9px] text-gray-500 font-bold">v{{ $p['version'] }}</span>
                    </div>

                    <h3 class="text-white text-lg font-medium leading-snug line-clamp-1 group-hover:translate-x-2 transition-transform duration-300">
                        {{ $p['name'] }}
                    </h3>
                </div>

                <div class="flex items-center justify-between mt-8 pt-4">
                    <span class="text-base font-medium text-gray-400">${{ number_format($p['price'], 2) }}</span>
                    <button class="text-xs font-bold text-gray-400 group-hover:text-white transition-colors flex items-center gap-1">
                        Obtener <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 2: ZERO FRAME OVERLAY -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'zeroframe'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $p)
            <div class="relative aspect-square rounded-2xl overflow-hidden group shadow-lg shadow-black/20 bg-zinc-950 flex items-center justify-center">
                <!-- Greyscale thumbnail background -->
                @if($p['thumb'])
                    <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover grayscale opacity-45 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                @else
                    <i class="fas fa-cube text-zinc-900 text-6xl"></i>
                @endif

                <!-- Zero-frame Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 p-6 flex flex-col justify-end">
                    <div class="backdrop-blur-md bg-white/5 border border-white/10 rounded-2xl p-4 flex flex-col justify-between">
                        <div>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1">{{ $p['type'] }}</span>
                            <h3 class="text-white font-bold text-sm leading-snug line-clamp-1 mb-2">{{ $p['name'] }}</h3>
                        </div>
                        <div class="flex items-center justify-between border-t border-white/5 pt-3 mt-1">
                            <span class="text-sm font-black text-white">${{ number_format($p['price'], 2) }}</span>
                            <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider">Ver más</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 3: SWISS GRID -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'swiss'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="border-t border-l border-white/10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($products as $p)
            <div class="border-r border-b border-white/10 p-8 hover:bg-white/[0.01] transition-colors group flex flex-col justify-between min-h-[260px]">
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-[9px] font-black uppercase text-gray-500 tracking-wider">/ {{ $p['type'] }}</span>
                        <span class="text-[9px] font-mono text-gray-500">v{{ $p['version'] }}</span>
                    </div>

                    <h3 class="text-white font-semibold text-lg leading-tight mb-4 group-hover:text-gray-400 transition-colors">
                        {{ $p['name'] }}
                    </h3>
                </div>

                <div class="flex items-end justify-between">
                    <div>
                        <span class="text-[9px] text-gray-600 block uppercase tracking-widest mb-1">Precio Fijo</span>
                        <span class="text-xl font-bold text-white">${{ number_format($p['price'], 2) }}</span>
                    </div>
                    
                    <button class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-white group-hover:bg-white group-hover:text-black transition-all">
                        <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 4: SLIM DRAWER LIST -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'drawer'" class="max-w-5xl mx-auto px-6" style="display: none;" x-data="{ expandedId: null }">
        <div class="space-y-4">
            @foreach($products as $index => $p)
            <div class="bg-[#0a0a0c] border border-white/[0.04] rounded-2xl overflow-hidden transition-all duration-300"
                 :class="expandedId === {{ $index }} ? 'border-white/20 shadow-lg' : ''">
                <!-- Trigger Bar -->
                <div @click="expandedId = expandedId === {{ $index }} ? null : {{ $index }}" 
                     class="px-6 py-5 flex items-center justify-between cursor-pointer group">
                    <div class="flex items-center gap-6 min-w-0">
                        <span class="font-mono text-xs text-gray-600">0{{ $index + 1 }}</span>
                        <span class="text-[9px] font-black text-gray-500 border border-white/10 px-2 py-0.5 rounded uppercase tracking-wider">{{ $p['type'] }}</span>
                        <h3 class="text-white font-medium text-sm sm:text-base truncate group-hover:text-gray-300 transition-colors">{{ $p['name'] }}</h3>
                    </div>
                    <div class="flex items-center gap-6 shrink-0">
                        <span class="text-sm font-bold text-gray-400">${{ number_format($p['price'], 2) }}</span>
                        <i class="fas fa-chevron-down text-[10px] text-gray-500 transition-transform duration-300" :class="expandedId === {{ $index }} ? 'rotate-180' : ''"></i>
                    </div>
                </div>

                <!-- Expanding Drawer -->
                <div x-show="expandedId === {{ $index }}" x-transition class="px-6 pb-6 border-t border-white/[0.02] pt-4 bg-white/[0.01]">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                        <div class="md:col-span-3">
                            <p class="text-xs text-gray-400 leading-relaxed max-w-2xl">
                                Accede de forma instantánea al código fuente oficial de este recurso de WordPress, 100% libre de modificaciones y verificado contra malware.
                            </p>
                            <div class="flex items-center gap-4 mt-4">
                                <span class="text-[10px] text-gray-500">Versión activa: <strong class="text-gray-300">v{{ $p['version'] }}</strong></span>
                                <span class="text-gray-700">•</span>
                                <span class="text-[10px] text-gray-500">Valoración media: <strong class="text-gray-300">{{ $p['rating'] ?: '5.0' }} / 5</strong></span>
                            </div>
                        </div>
                        <div class="md:col-span-1 text-right">
                            <button class="w-full py-2.5 px-4 bg-white text-black rounded-xl text-xs font-black uppercase tracking-wider hover:bg-gray-200 transition-colors">
                                Obtener copia
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 5: LIQUID BLOB ACCENT -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'liquid'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $p)
            <div class="relative bg-zinc-950 border border-white/5 rounded-3xl p-6 overflow-hidden hover:border-white/20 transition-all duration-500 group flex flex-col justify-between min-h-[220px]">
                <!-- Liquid Blob Orbiting Behind -->
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-red-600/10 rounded-full blur-3xl blob-anim opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <span class="text-[8px] font-black text-gray-500 uppercase tracking-widest border border-white/5 px-2 py-0.5 rounded">{{ $p['type'] }}</span>
                        <span class="text-[10px] font-mono text-gray-600">v{{ $p['version'] }}</span>
                    </div>

                    <h3 class="text-white text-base font-semibold leading-snug line-clamp-2">
                        {{ $p['name'] }}
                    </h3>
                </div>

                <div class="relative z-10 flex items-center justify-between border-t border-white/5 pt-4 mt-6">
                    <span class="text-lg font-black text-white">${{ number_format($p['price'], 2) }}</span>
                    <button class="w-9 h-9 rounded-full bg-white text-black flex items-center justify-center hover:scale-110 transition-all">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Page Footer -->
    <div class="py-24 text-center">
        <p class="text-gray-600 text-xs font-medium">Diseñados cuidando el espaciado tipográfico, sin marcos pesados ni efectos innecesarios.</p>
    </div>

</body>
</html>