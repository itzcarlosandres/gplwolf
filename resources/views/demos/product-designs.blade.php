<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - 5 Nuevos Diseños de Productos | GPLWolf</title>
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
                        indigo: { 400: '#FF2121', 500: '#FF2121', 600: '#F51B1B' },
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); }
        .glass { background: rgba(10, 10, 10, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
        
        /* Custom Smooth Transitions */
        .transition-accordion {
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }
    </style>
</head>
<body class="bg-[#050505] text-gray-300 min-h-screen pb-32" x-data="{ activeDesign: 'glassmorphic' }">

    <!-- Header Section -->
    <div class="py-16 text-center max-w-4xl mx-auto px-6">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/10 border border-red-500/20 text-xs font-black uppercase text-red-500 tracking-widest mb-6">
            ✨ Nueva Galería de Productos
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tighter leading-none mb-6">
            5 Diseños de <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-amber-500">Productos Pro</span>
        </h1>
        <p class="text-gray-400 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
            Explora 5 propuestas de interfaces completamente nuevas, limpias y altamente interactivas para mostrar los recursos de tu marketplace.
        </p>
    </div>

    <!-- Design Switcher Tabs -->
    <div class="max-w-4xl mx-auto mb-16 px-6 relative z-50">
        <div class="bg-white/5 border border-white/10 p-1.5 rounded-2xl flex flex-wrap justify-between items-center gap-1.5 backdrop-blur-md">
            <button @click="activeDesign = 'glassmorphic'" :class="activeDesign === 'glassmorphic' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-3 px-4 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                1. Glassmorphic Glow
            </button>
            <button @click="activeDesign = 'split'" :class="activeDesign === 'split' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-3 px-4 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                2. Editorial Split
            </button>
            <button @click="activeDesign = 'cyberpunk'" :class="activeDesign === 'cyberpunk' ? 'bg-amber-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-3 px-4 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                3. Cyber Tech
            </button>
            <button @click="activeDesign = 'floating'" :class="activeDesign === 'floating' ? 'bg-emerald-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-3 px-4 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                4. Floating Shadow
            </button>
            <button @click="activeDesign = 'accordion'" :class="activeDesign === 'accordion' ? 'bg-purple-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-3 px-4 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                5. Expanding Slider
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
    <!-- DISEÑO 1: GLASSMORPHIC GLOW CARD -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'glassmorphic'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $p)
            <div class="backdrop-blur-xl bg-white/[0.02] border border-white/10 hover:border-red-500/30 rounded-3xl p-6 relative overflow-hidden transition-all duration-300 shadow-xl group">
                <!-- Radial Glow Background -->
                <div class="absolute -top-12 -right-12 w-24 h-24 bg-red-600/10 rounded-full blur-2xl group-hover:bg-red-500/20 transition-all duration-500"></div>

                <div class="relative aspect-[16/10] overflow-hidden bg-[#0d0d0d] rounded-2xl border border-white/5 mb-5 flex items-center justify-center">
                    @if($p['thumb'])
                        <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-red-600/10 flex items-center justify-center text-red-500 border border-red-500/20">
                            <i class="fas fa-cubes text-2xl"></i>
                        </div>
                    @endif
                    
                    @if($p['badge'])
                    <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-red-600/20 backdrop-blur-md border border-red-500/30 text-[9px] font-black uppercase text-red-400 tracking-wider">
                        {{ $p['badge'] }}
                    </div>
                    @endif
                </div>

                <div class="flex justify-between items-start gap-3 mb-3">
                    <div>
                        <span class="text-[10px] font-black text-red-500 uppercase tracking-widest block mb-1">{{ $p['type'] }}</span>
                        <h3 class="text-white font-bold text-base leading-snug line-clamp-1 group-hover:text-red-400 transition-colors">{{ $p['name'] }}</h3>
                    </div>
                    <div class="flex items-center gap-1 bg-white/5 border border-white/10 px-2 py-0.5 rounded-lg text-[10px] font-bold text-amber-400 shrink-0">
                        <i class="fas fa-star text-[8px]"></i>
                        <span>{{ $p['rating'] ?: '5.0' }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/5 mt-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <span class="text-[9px] text-gray-500 uppercase block tracking-wider">Versión</span>
                            <span class="text-xs font-bold text-gray-300">v{{ $p['version'] }}</span>
                        </div>
                        <div class="w-px h-6 bg-white/10"></div>
                        <div>
                            <span class="text-[9px] text-gray-500 uppercase block tracking-wider">Descargas</span>
                            <span class="text-xs font-bold text-gray-300">{{ number_format($p['downloads']) }}</span>
                        </div>
                    </div>
                    <button class="w-10 h-10 rounded-full bg-red-600 hover:bg-red-500 text-white flex items-center justify-center shadow-lg shadow-red-600/30 transition-all hover:scale-110">
                        <i class="fas fa-shopping-bag text-xs"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 2: EDITORIAL SPLIT CARD -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'split'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($products as $p)
            <div class="bg-zinc-950 border border-white/5 rounded-3xl p-5 hover:border-blue-500/30 transition-all duration-300 group">
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-6 items-center">
                    <div class="sm:col-span-2 relative aspect-[12/9] overflow-hidden bg-zinc-900 rounded-2xl border border-white/5 flex items-center justify-center">
                        @if($p['thumb'])
                            <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-code text-zinc-700 text-4xl"></i>
                        @endif
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-blue-600/20 border border-blue-500/30 text-[8px] font-black uppercase text-blue-400 tracking-wider">
                            {{ $p['type'] }}
                        </span>
                    </div>
                    <div class="sm:col-span-3 flex flex-col justify-between h-full min-w-0">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[9px] font-bold text-gray-500">v{{ $p['version'] }}</span>
                                <span class="w-1 h-1 bg-zinc-700 rounded-full"></span>
                                <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest">Seguro GPL</span>
                            </div>
                            <h3 class="text-white font-bold text-base leading-snug line-clamp-2 group-hover:text-blue-400 transition-colors mb-3">{{ $p['name'] }}</h3>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-white/5 mt-4">
                            <div>
                                <span class="text-[9px] text-gray-500 uppercase block tracking-wider">Precio Licencia</span>
                                <span class="text-xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                            </div>
                            <button class="px-4 py-2 rounded-xl border border-blue-500/30 text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all text-xs font-black uppercase tracking-wider">
                                Descargar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 3: CYBER TECH GRID -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'cyberpunk'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $p)
            <div class="bg-black border border-white/10 p-5 rounded-xl relative overflow-hidden transition-all duration-300 hover:border-amber-500/50 hover:shadow-[0_0_15px_rgba(245,158,11,0.15)] group">
                <!-- Tech Corners -->
                <div class="absolute w-2 h-2 border-t-2 border-l-2 border-amber-500 top-0 left-0"></div>
                <div class="absolute w-2 h-2 border-t-2 border-r-2 border-amber-500 top-0 right-0"></div>
                <div class="absolute w-2 h-2 border-b-2 border-l-2 border-amber-500 bottom-0 left-0"></div>
                <div class="absolute w-2 h-2 border-b-2 border-r-2 border-amber-500 bottom-0 right-0"></div>

                <div class="relative bg-zinc-950/60 p-4 border border-white/5 rounded-lg mb-4 flex items-center justify-between">
                    <span class="text-[10px] font-mono text-amber-500 tracking-wider">SYS_STATUS: // OK</span>
                    <span class="px-2 py-0.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-mono uppercase tracking-widest rounded">
                        {{ $p['type'] }}
                    </span>
                </div>

                <h3 class="text-white font-mono font-bold text-sm leading-snug line-clamp-1 mb-4 group-hover:text-amber-400 transition-colors uppercase tracking-tight">> {{ $p['name'] }}</h3>

                <div class="space-y-2 border-t border-b border-white/5 py-4 mb-4">
                    <div class="flex justify-between items-center text-[10px] font-mono">
                        <span class="text-gray-500">SHA256_VERIFICATION</span>
                        <span class="text-emerald-400 font-bold">VERIFIED_SECURE</span>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-mono">
                        <span class="text-gray-500">ACTIVE_RELEASES</span>
                        <span class="text-gray-300">v{{ $p['version'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-mono">
                        <span class="text-gray-500">SYSTEM_RATING</span>
                        <span class="text-amber-400">{{ $p['rating'] ?: '5.0' }} / 5.0</span>
                    </div>
                </div>

                <div class="flex justify-between items-center font-mono">
                    <span class="text-2xl font-black text-amber-400 font-mono">${{ number_format($p['price'], 2) }}</span>
                    <button class="px-4 py-2 bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-black border border-amber-500/30 rounded text-[10px] font-mono font-black uppercase tracking-wider transition-all">
                        DEPLOY
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 4: FLOATING SHADOW -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'floating'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $p)
            <div class="bg-zinc-900/60 rounded-3xl p-6 transition-all duration-500 hover:bg-zinc-900 hover:translate-y-[-8px] hover:shadow-[0_20px_50px_rgba(0,0,0,0.8),_0_0_20px_rgba(255,255,255,0.02)] border border-transparent hover:border-white/5 group">
                <div class="aspect-[16/10] overflow-hidden rounded-2xl mb-6 relative bg-zinc-950 flex items-center justify-center border border-white/5">
                    @if($p['thumb'])
                        <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-layer-group text-zinc-800 text-4xl"></i>
                    @endif
                    
                    <span class="absolute bottom-3 left-3 px-3 py-1 bg-black/60 backdrop-blur-md rounded-lg text-[9px] font-black uppercase text-emerald-400 tracking-widest border border-white/5">
                        {{ $p['type'] }}
                    </span>
                </div>

                <div class="space-y-2 mb-6">
                    <h3 class="text-white font-black text-lg leading-tight line-clamp-1 group-hover:text-emerald-400 transition-colors">{{ $p['name'] }}</h3>
                    <div class="flex items-center gap-3 text-xs text-gray-500 font-bold">
                        <span>v{{ $p['version'] }}</span>
                        <span>•</span>
                        <div class="flex items-center gap-1 text-amber-400">
                            <i class="fas fa-star text-[9px]"></i>
                            <span>{{ $p['rating'] ?: '5.0' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/5">
                    <span class="text-2xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                    <button class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 text-white flex items-center justify-center transition-all border border-white/10">
                        <i class="fas fa-download text-xs"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 5: EXPANDING ACCORDION SLIDER -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'accordion'" class="max-w-7xl mx-auto px-6" style="display: none;" x-data="{ expandedIndex: 0 }">
        <div class="hidden lg:flex gap-4 w-full min-h-[460px] items-stretch">
            @foreach($products as $index => $p)
            <div @mouseenter="expandedIndex = {{ $index }}" 
                 class="transition-accordion rounded-[32px] overflow-hidden border border-white/5 p-6 flex flex-col justify-between relative bg-zinc-950"
                 :class="expandedIndex === {{ $index }} ? 'flex-[2.5] border-purple-500/30 shadow-[0_0_30px_rgba(168,85,247,0.15)] bg-gradient-to-br from-zinc-950 via-zinc-950 to-purple-950/20' : 'flex-1 cursor-pointer hover:border-white/20'">
                
                <div>
                    <!-- Category & Status -->
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-[9px] font-black text-purple-400 uppercase tracking-widest">{{ $p['type'] }}</span>
                        <span x-show="expandedIndex === {{ $index }}" class="px-2.5 py-0.5 bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 rounded text-[9px] font-bold">100% OK</span>
                    </div>

                    <!-- Visual Accent when collapsed -->
                    <div x-show="expandedIndex !== {{ $index }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-gray-500 mb-6">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </div>

                    <!-- Layout when expanded -->
                    <div x-show="expandedIndex === {{ $index }}" class="flex gap-6 items-center mb-6">
                        <div class="w-32 h-20 rounded-2xl bg-zinc-900 overflow-hidden border border-white/5 flex-shrink-0 flex items-center justify-center">
                            @if($p['thumb'])
                                <img src="{{ $p['thumb'] }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-cubes text-zinc-700 text-2xl"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-white font-black text-xl leading-tight mb-2">{{ $p['name'] }}</h3>
                            <div class="flex items-center gap-3 text-xs text-gray-500 font-bold">
                                <span>v{{ $p['version'] }}</span>
                                <span>•</span>
                                <div class="flex items-center gap-1 text-amber-400">
                                    <i class="fas fa-star text-[9px]"></i>
                                    <span>{{ $p['rating'] ?: '5.0' }} ({{ $p['reviews'] }} reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="expandedIndex !== {{ $index }}" class="mt-4">
                        <h3 class="text-white font-bold text-sm truncate rotate-90 origin-left translate-x-2 whitespace-nowrap mt-8">{{ $p['name'] }}</h3>
                    </div>
                </div>

                <div x-show="expandedIndex === {{ $index }}" class="flex items-center justify-between pt-6 border-t border-white/5">
                    <div>
                        <span class="text-[9px] text-gray-500 uppercase block tracking-wider">Pago Seguro GPL</span>
                        <span class="text-3xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                    </div>
                    <button class="px-5 py-3 rounded-2xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-black uppercase tracking-wider shadow-lg shadow-purple-500/20 transition-all hover:scale-105">
                        Descargar Ahora
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Fallback Grid for Mobile & Tablets -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:hidden">
            @foreach($products as $p)
            <div class="bg-zinc-950 border border-white/5 rounded-3xl p-6 flex flex-col justify-between">
                <div>
                    <span class="text-[9px] font-black text-purple-400 uppercase tracking-widest block mb-2">{{ $p['type'] }}</span>
                    <h3 class="text-white font-black text-lg mb-4">{{ $p['name'] }}</h3>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-white/5">
                    <span class="text-2xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                    <button class="px-4 py-2 rounded-xl bg-purple-600 text-white text-xs font-black uppercase">
                        Descargar
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Page Footer / Selector Message -->
    <div class="py-24 text-center">
        <p class="text-gray-600 text-sm font-medium">Todos los componentes utilizan variables y datos reales de la base de datos.</p>
    </div>

</body>
</html>