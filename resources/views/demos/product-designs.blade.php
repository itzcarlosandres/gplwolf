<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - 5 Diseños Exclusivos Minimalistas | GPLWolf</title>
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
                            900: '#121214',
                            950: '#0a0a0c',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #050505; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        /* Dot Matrix Background Pattern */
        .dot-matrix {
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 16px 16px;
        }
        
        /* Scanline Animation for Terminal Card */
        @keyframes scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }
        .scanline::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent, rgba(34, 197, 94, 0.05), transparent);
            animation: scanline 4s linear infinite;
            pointer-events: none;
        }
    </style>
</head>
<body class="text-gray-300 min-h-screen pb-32" x-data="{ activeDesign: 'terminal' }">

    <!-- Header Section -->
    <div class="py-16 text-center max-w-4xl mx-auto px-6">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-bold uppercase text-gray-400 tracking-widest mb-6">
            ✦ Galería de Conceptos Exclusivos
        </span>
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white tracking-tighter leading-none mb-6">
            Estéticas <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-400 via-white to-gray-400">No Convencionales</span>
        </h1>
        <p class="text-gray-500 text-xs md:text-sm max-w-xl mx-auto leading-relaxed">
            Una colección de 5 diseños de interfaz de usuario con fuerte personalidad técnica, artística e interactiva.
        </p>
    </div>

    <!-- Design Switcher Tabs -->
    <div class="max-w-4xl mx-auto mb-16 px-6 relative z-50">
        <div class="bg-white/5 border border-white/5 p-1 rounded-2xl flex flex-wrap justify-between items-center gap-1 backdrop-blur-md">
            <button @click="activeDesign = 'terminal'" :class="activeDesign === 'terminal' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                1. Terminal Dev
            </button>
            <button @click="activeDesign = 'bauhaus'" :class="activeDesign === 'bauhaus' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                2. Bauhaus Index
            </button>
            <button @click="activeDesign = 'specsheet'" :class="activeDesign === 'specsheet' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                3. Spec Sheet
            </button>
            <button @click="activeDesign = 'dotmatrix'" :class="activeDesign === 'dotmatrix' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                4. Dot Matrix Grid
            </button>
            <button @click="activeDesign = 'badge'" :class="activeDesign === 'badge' ? 'bg-white text-black font-black' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                5. Metallic Badge Row
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
    <!-- DISEÑO 1: TERMINAL DEV -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'terminal'" class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $p)
            <div class="bg-black border border-zinc-800 p-5 rounded-lg relative overflow-hidden transition-all duration-300 hover:border-green-500/40 hover:shadow-[0_0_15px_rgba(34,197,94,0.1)] group scanline">
                <div class="flex items-center justify-between border-b border-zinc-900 pb-3 mb-4">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-zinc-800 group-hover:bg-green-500 transition-colors"></span>
                        <span class="font-mono text-[10px] text-zinc-500 tracking-wider">GPLWOLF_SHELL</span>
                    </div>
                    <span class="font-mono text-[9px] text-green-500/80 uppercase">v{{ $p['version'] }}</span>
                </div>

                <div class="mb-4">
                    <span class="font-mono text-[9px] text-zinc-600 block mb-1">C:\> gplwolf install</span>
                    <h3 class="text-white font-mono font-bold text-sm leading-relaxed truncate group-hover:text-green-400 transition-colors">
                        {{ strtolower(str_replace(' ', '-', $p['name'])) }}.pkg
                    </h3>
                </div>

                <div class="bg-zinc-950 p-3 rounded font-mono text-[10px] text-zinc-500 border border-zinc-900/60 mb-5 space-y-1">
                    <div>TYPE: {{ strtoupper($p['type']) }}</div>
                    <div>SIZE: 1.42 MB</div>
                    <div>SECURITY: <span class="text-green-500">100% SAFE</span></div>
                </div>

                <div class="flex justify-between items-center pt-2 border-t border-zinc-900">
                    <span class="font-mono font-bold text-sm text-green-500">${{ number_format($p['price'], 2) }}</span>
                    <button class="px-3 py-1.5 border border-zinc-800 text-zinc-400 hover:border-green-500 hover:text-green-500 rounded font-mono text-[10px] uppercase transition-all">
                        RUN_DOWNLOAD
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 2: BAUHAUS INDEX -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'bauhaus'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $p)
            <div class="bg-white text-black border-2 border-black rounded-none p-6 flex flex-col justify-between min-h-[240px] hover:bg-gray-100 transition-colors duration-200 group">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <span class="text-[9px] font-black uppercase tracking-widest border-2 border-black px-2 py-0.5 bg-black text-white">
                            {{ $p['type'] }}
                        </span>
                        <span class="text-xs font-mono font-bold">v{{ $p['version'] }}</span>
                    </div>

                    <h3 class="font-extrabold text-xl leading-none tracking-tight mb-2 uppercase break-words">
                        {{ $p['name'] }}
                    </h3>
                </div>

                <div class="flex items-end justify-between border-t-2 border-black pt-4 mt-6">
                    <span class="text-2xl font-black">${{ number_format($p['price'], 2) }}</span>
                    <button class="bg-black text-white px-4 py-2 text-xs font-black uppercase tracking-widest hover:bg-[#FF2121] transition-colors border-2 border-black">
                        COMPRAR
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 3: SPEC SHEET -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'specsheet'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="space-y-4">
            @foreach($products as $p)
            <div class="bg-[#09090b] border-b border-zinc-800 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:bg-zinc-900/40 transition-colors group">
                <div class="flex items-center gap-6 min-w-0">
                    <div class="w-10 h-10 bg-zinc-950 border border-zinc-800 text-zinc-500 rounded-lg flex items-center justify-center text-xs font-bold shrink-0">
                        {{ substr($p['name'], 0, 2) }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[9px] font-black uppercase text-red-500 tracking-wider">{{ $p['type'] }}</span>
                            <span class="text-[10px] text-zinc-600">v{{ $p['version'] }}</span>
                        </div>
                        <h3 class="text-white font-bold text-base leading-snug truncate">{{ $p['name'] }}</h3>
                    </div>
                </div>

                <!-- Technical Specs grid -->
                <div class="grid grid-cols-3 gap-6 text-left shrink-0">
                    <div>
                        <span class="text-[9px] text-zinc-600 uppercase block tracking-wider">Descargas</span>
                        <span class="text-xs font-bold text-zinc-400">{{ number_format($p['downloads']) }}</span>
                    </div>
                    <div>
                        <span class="text-[9px] text-zinc-600 uppercase block tracking-wider">Licencia</span>
                        <span class="text-xs font-bold text-emerald-500">GNU / GPL</span>
                    </div>
                    <div>
                        <span class="text-[9px] text-zinc-600 uppercase block tracking-wider">Seguridad</span>
                        <span class="text-xs font-bold text-green-500">100% OK</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-6 shrink-0">
                    <span class="text-xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                    <button class="px-4 py-2 border border-zinc-800 text-zinc-300 rounded-lg text-xs font-bold hover:border-white hover:text-white transition-all">
                        Descargar
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 4: DOT MATRIX GRID -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'dotmatrix'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $p)
            <div class="dot-matrix bg-zinc-950 border border-zinc-900 rounded-2xl p-6 transition-all duration-300 hover:border-red-500/20 group relative overflow-hidden flex flex-col justify-between min-h-[230px]">
                <div>
                    <div class="flex justify-between items-center mb-6 relative z-10">
                        <span class="text-[8px] font-black uppercase tracking-widest bg-zinc-900 text-zinc-400 border border-zinc-800 px-2 py-0.5 rounded">
                            {{ $p['type'] }}
                        </span>
                        <span class="text-[10px] text-zinc-600 font-mono">v{{ $p['version'] }}</span>
                    </div>

                    <h3 class="text-white text-base font-medium leading-snug line-clamp-2 relative z-10">
                        {{ $p['name'] }}
                    </h3>
                </div>

                <div class="flex items-center justify-between border-t border-zinc-900/60 pt-4 mt-6 relative z-10">
                    <span class="text-xl font-extrabold text-white">${{ number_format($p['price'], 2) }}</span>
                    <button class="w-9 h-9 rounded-xl bg-white text-black flex items-center justify-center hover:scale-110 transition-all shadow-md">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 5: METALLIC BADGE ROW -->
    <!-- ============================================ -->
    <div x-show="activeDesign === 'badge'" class="max-w-7xl mx-auto px-6" style="display: none;">
        <div class="space-y-4">
            @foreach($products as $p)
            <div class="backdrop-blur-md bg-white/[0.01] border border-white/5 p-4 rounded-2xl hover:border-white/10 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group">
                <div class="flex items-center gap-4 min-w-0">
                    <!-- Metallic initials badge -->
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-zinc-800 via-zinc-900 to-zinc-950 border border-white/10 flex items-center justify-center font-black text-base text-transparent bg-clip-text bg-gradient-to-r from-gray-200 to-gray-500 shrink-0 shadow-lg">
                        {{ substr($p['name'], 0, 2) }}
                    </div>
                    <div class="min-w-0">
                        <span class="text-[8px] font-black text-[#FF2121] uppercase tracking-widest block mb-0.5">{{ $p['type'] }}</span>
                        <h3 class="text-white font-bold text-sm truncate group-hover:text-[#FF2121] transition-colors">{{ $p['name'] }}</h3>
                    </div>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-6 shrink-0">
                    <div class="text-right">
                        <span class="text-[9px] text-gray-600 block uppercase tracking-wider">v{{ $p['version'] }}</span>
                        <span class="text-base font-black text-white">${{ number_format($p['price'], 2) }}</span>
                    </div>
                    <button class="w-9 h-9 rounded-xl bg-white hover:bg-gray-100 flex items-center justify-center text-black shadow-md transition-all hover:scale-105">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Page Footer -->
    <div class="py-24 text-center">
        <p class="text-zinc-600 text-xs font-medium font-mono">CODE_LAYOUTS: 5 // LOAD_STATUS: COMPLETE</p>
    </div>

</body>
</html>