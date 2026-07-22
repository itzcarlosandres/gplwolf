<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - 5 Productos Designs Pro | CaletaWP</title>
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

        /* Design 1: Premium Card */
        .premium-card {
            background: linear-gradient(180deg, #0d0d0d 0%, #0a0a0a 100%);
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .premium-card:hover {
            border-color: rgba(255, 33, 33, 0.3);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), 0 0 30px -10px rgba(255, 33, 33, 0.2);
            transform: translateY(-4px);
        }
        .premium-card:hover .premium-image { transform: scale(1.08); }
        .premium-image { transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }

        /* Design 2: Editorial Card */
        .editorial-card { background: #0a0a0a; border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.3s ease; }
        .editorial-card:hover { border-color: rgba(255, 33, 33, 0.2); transform: translateY(-2px); }
        .editorial-card:hover .editorial-img { filter: brightness(1.1) contrast(1.05); }
        .editorial-img { transition: all 0.5s ease; }

        /* Design 3: Bento Card */
        .bento-card { background: #0d1425; border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.4s ease; }
        .bento-card:hover { border-color: rgba(255, 33, 33, 0.3); box-shadow: 0 10px 30px -5px rgba(255, 33, 33, 0.15); }

        /* Design 4: Magazine */
        .magazine-card { background: #0a0a0a; border: 1px solid rgba(255, 255, 255, 0.06); transition: all 0.4s ease; }
        .magazine-card:hover { border-color: rgba(245, 158, 11, 0.3); }
        .magazine-card:hover .magazine-img { transform: scale(1.05); }
        .magazine-img { transition: transform 0.6s ease; }

        /* Design 5: Compact List */
        .compact-row { background: #0a0a0a; border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.3s ease; }
        .compact-row:hover { background: #0d1425; border-color: rgba(255, 33, 33, 0.2); }

        /* Animations */
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent); background-size: 200% 100%; animation: shimmer 3s infinite; }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-[#050505] text-gray-300">

    <!-- Selector -->
    <div class="fixed left-0 top-1/2 -translate-y-1/2 z-[60] flex flex-col gap-2 pl-4">
        <a href="#d1" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Premium">1</a>
        <a href="#d2" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Editorial">2</a>
        <a href="#d3" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Bento">3</a>
        <a href="#d4" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Magazine">4</a>
        <a href="#d5" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Compact">5</a>
    </div>

    <div class="py-12 text-center">
        <h1 class="text-4xl font-black text-white mb-3">5 Diseños de Productos Pro</h1>
        <p class="text-gray-500 text-sm font-medium">Diseños profesionales para tu marketplace</p>
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
    <!-- DISEÑO 1: PREMIUM CARD -->
    <!-- ============================================ -->
    <div id="d1" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-[#FF2121]/20 text-[#FF2121] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#FF2121]/20">Diseño 1 — Premium Card</span>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $p)
                <div class="premium-card rounded-2xl overflow-hidden group">
                    <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-[#FF2121]/30 to-[#F51B1B]/20">
                        @if($p['thumb'])
                            <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="premium-image w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent"></div>
                        @if($p['badge'])
                        <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg text-[10px] font-black uppercase tracking-wider border border-white/20 text-white">
                            <i class="fas fa-crown text-amber-400 text-[8px]"></i> {{ $p['badge'] }}
                        </div>
                        @endif
                        <div class="absolute top-3 right-3 px-2.5 py-1 bg-black/60 backdrop-blur-md rounded-lg text-[10px] font-bold text-white border border-white/10">
                            v{{ $p['version'] }}
                        </div>
                        <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between">
                            <span class="px-2.5 py-1 bg-[#FF2121]/90 backdrop-blur-sm rounded-md text-[10px] font-black uppercase tracking-wider text-white">
                                {{ $p['type'] }}
                            </span>
                            <div class="flex items-center gap-1 px-2.5 py-1 bg-black/60 backdrop-blur-md rounded-md text-[10px] font-bold text-amber-400 border border-white/10">
                                <i class="fas fa-star text-[8px]"></i>
                                <span>{{ $p['rating'] ?: '5.0' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-white font-bold text-base mb-2 line-clamp-1 group-hover:text-[#FF2121] transition-colors">{{ $p['name'] }}</h3>
                        <div class="flex items-center gap-3 text-[11px] text-gray-500 mb-4">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-download text-[10px]"></i>
                                <span>{{ number_format($p['downloads']) }}</span>
                            </div>
                            <div class="w-1 h-1 bg-gray-700 rounded-full"></div>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-comment text-[10px]"></i>
                                <span>{{ $p['reviews'] }}</span>
                            </div>
                            <div class="w-1 h-1 bg-gray-700 rounded-full"></div>
                            <div class="flex items-center gap-1 text-emerald-400">
                                <i class="fas fa-shield-halved text-[10px]"></i>
                                <span>GPL</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-white/5">
                            <div>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Desde</span>
                                <span class="text-2xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="w-9 h-9 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition-all border border-white/5">
                                    <i class="far fa-heart text-sm"></i>
                                </button>
                                <button class="px-4 py-2.5 gradient-bg rounded-lg text-white text-xs font-black uppercase tracking-wider shadow-lg shadow-[#FF2121]/20 hover:scale-105 transition-all">
                                    Ver más
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 2: EDITORIAL -->
    <!-- ============================================ -->
    <div id="d2" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-[#F51B1B]/20 text-[#F51B1B] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#F51B1B]/20">Diseño 2 — Editorial</span>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $p)
                <div class="editorial-card rounded-xl overflow-hidden group">
                    <div class="flex">
                        <div class="w-32 h-32 flex-shrink-0 relative overflow-hidden bg-gradient-to-br from-[#FF2121]/40 to-[#F51B1B]/20">
                            @if($p['thumb'])
                                <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="editorial-img w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 p-4 flex flex-col justify-between min-w-0">
                            <div>
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="text-[9px] font-black text-[#FF2121] uppercase tracking-widest">{{ $p['type'] }}</span>
                                    @if($p['badge'])
                                    <span class="text-[9px] font-bold text-amber-400">• {{ $p['badge'] }}</span>
                                    @endif
                                </div>
                                <h3 class="text-white font-bold text-sm leading-tight mb-1 line-clamp-2 group-hover:text-[#FF2121] transition-colors">{{ $p['name'] }}</h3>
                                <div class="flex items-center gap-2 text-[10px] text-gray-500">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-star text-amber-400 text-[8px]"></i>
                                        <span class="text-amber-400 font-bold">{{ $p['rating'] ?: '5.0' }}</span>
                                    </div>
                                    <span>•</span>
                                    <span>v{{ $p['version'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-lg font-black text-white">${{ number_format($p['price'], 2) }}</span>
                                <button class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center text-white hover:scale-110 transition-all shadow-md shadow-[#FF2121]/30">
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 3: BENTO GRID -->
    <!-- ============================================ -->
    <div id="d3" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-emerald-500/20">Diseño 3 — Bento Grid</span>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($products->take(2) as $p)
                <div class="bento-card md:col-span-2 rounded-2xl overflow-hidden group">
                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-emerald-900/30 to-[#F51B1B]/20">
                        @if($p['thumb'])
                            <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0d1425] via-[#0d1425]/40 to-transparent"></div>
                        <div class="absolute top-3 left-3 flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-white/10 backdrop-blur-md rounded text-[9px] font-black uppercase tracking-wider text-white border border-white/20">{{ $p['type'] }}</span>
                            @if($p['badge'])
                            <span class="px-2 py-0.5 bg-emerald-500/20 backdrop-blur-md rounded text-[9px] font-black uppercase tracking-wider text-emerald-400 border border-emerald-500/30">{{ $p['badge'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-white font-bold text-lg mb-1 line-clamp-1 group-hover:text-emerald-400 transition-colors">{{ $p['name'] }}</h3>
                        <div class="flex items-center gap-3 text-[11px] text-gray-500 mb-4">
                            <div class="flex items-center gap-1 text-amber-400">
                                <i class="fas fa-star text-[9px]"></i>
                                <span class="font-bold">{{ $p['rating'] ?: '5.0' }}</span>
                            </div>
                            <span>•</span>
                            <span>{{ number_format($p['downloads']) }} downloads</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                            <button class="px-4 py-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 rounded-lg text-emerald-400 text-[10px] font-black uppercase tracking-wider transition-all">
                                Ver detalles
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                @foreach($products->skip(2)->take(4) as $p)
                <div class="bento-card rounded-2xl overflow-hidden group">
                    <div class="relative h-32 overflow-hidden bg-gradient-to-br from-[#FF2121]/30 to-[#F51B1B]/20">
                        @if($p['thumb'])
                            <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0d1425] to-transparent"></div>
                        <div class="absolute top-2 left-2 px-1.5 py-0.5 bg-black/60 backdrop-blur-md rounded text-[8px] font-black uppercase tracking-wider text-white">{{ $p['type'] }}</div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-white font-bold text-sm leading-tight mb-2 line-clamp-2 group-hover:text-[#FF2121] transition-colors">{{ $p['name'] }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-black text-white">${{ number_format($p['price'], 2) }}</span>
                            <div class="flex items-center gap-1 text-amber-400 text-[10px] font-bold">
                                <i class="fas fa-star text-[8px]"></i>
                                <span>{{ $p['rating'] ?: '5.0' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 4: MAGAZINE -->
    <!-- ============================================ -->
    <div id="d4" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-amber-500/20 text-amber-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-amber-500/20">Diseño 4 — Magazine</span>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $p)
                <div class="magazine-card rounded-xl overflow-hidden group">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-amber-900/20 to-orange-900/10">
                        @if($p['thumb'])
                            <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="magazine-img w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent"></div>
                        <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
                            <span class="text-[10px] font-black text-amber-400 uppercase tracking-[0.2em]">№ {{ $loop->iteration }}</span>
                            <div class="w-8 h-8 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white">
                                <i class="fas fa-bookmark text-[10px]"></i>
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest">{{ $p['type'] }}</span>
                                <span class="w-1 h-1 bg-gray-600 rounded-full"></span>
                                <span class="text-[10px] text-gray-400">v{{ $p['version'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-white text-xl font-black leading-tight mb-3 line-clamp-2 group-hover:text-amber-400 transition-colors">{{ $p['name'] }}</h3>
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-white/5">
                            <div class="flex items-center gap-1 text-amber-400 text-xs">
                                <i class="fas fa-star text-[10px]"></i>
                                <span class="font-black">{{ $p['rating'] ?: '5.0' }}</span>
                            </div>
                            <span class="text-gray-700">•</span>
                            <span class="text-[11px] text-gray-500">{{ number_format($p['downloads']) }} ventas</span>
                            <span class="text-gray-700">•</span>
                            <span class="text-[11px] text-emerald-400 font-bold">GPL</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider block">Precio</span>
                                <span class="text-3xl font-black text-white">${{ number_format($p['price'], 2) }}</span>
                            </div>
                            <button class="w-11 h-11 rounded-full bg-amber-500 hover:bg-amber-400 flex items-center justify-center text-black shadow-lg shadow-amber-500/30 transition-all hover:scale-110">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- DISEÑO 5: COMPACT TABLE -->
    <!-- ============================================ -->
    <div id="d5" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-pink-500/20 text-pink-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-pink-500/20">Diseño 5 — Compact Table</span>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="rounded-xl overflow-hidden border border-white/5">
                <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-white/[0.02] text-[10px] font-black uppercase tracking-wider text-gray-500 border-b border-white/5">
                    <div class="col-span-1">#</div>
                    <div class="col-span-5">Producto</div>
                    <div class="col-span-2">Tipo</div>
                    <div class="col-span-1 text-center">Rating</div>
                    <div class="col-span-1 text-center">v</div>
                    <div class="col-span-2 text-right">Precio</div>
                </div>
                @foreach($products as $p)
                <div class="compact-row grid grid-cols-12 gap-4 px-6 py-4 items-center border-b border-white/5 last:border-0 group">
                    <div class="col-span-1 text-[10px] font-black text-gray-500">{{ $loop->iteration }}</div>
                    <div class="col-span-5 flex items-center gap-3 min-w-0">
                        <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 bg-gradient-to-br from-[#FF2121]/40 to-[#F51B1B]/20 border border-white/5">
                            @if($p['thumb'])
                                <img src="{{ $p['thumb'] }}" alt="{{ $p['name'] }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-white font-bold text-sm truncate group-hover:text-[#FF2121] transition-colors">{{ $p['name'] }}</h3>
                            <div class="flex items-center gap-2 mt-0.5">
                                @if($p['badge'])
                                <span class="text-[9px] font-black text-amber-400 uppercase tracking-wider">{{ $p['badge'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <span class="text-[10px] font-black text-[#FF2121] uppercase tracking-wider">{{ $p['type'] }}</span>
                    </div>
                    <div class="col-span-1 text-center">
                        <div class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-500/10 border border-amber-500/20 rounded text-amber-400 text-[10px] font-bold">
                            <i class="fas fa-star text-[8px]"></i>
                            <span>{{ $p['rating'] ?: '5.0' }}</span>
                        </div>
                    </div>
                    <div class="col-span-1 text-center text-[10px] text-gray-500 font-bold">v{{ $p['version'] }}</div>
                    <div class="col-span-2 text-right flex items-center justify-end gap-3">
                        <span class="text-lg font-black text-white">${{ number_format($p['price'], 2) }}</span>
                        <button class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all shadow-md shadow-[#FF2121]/30">
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-20 text-center">
        <p class="text-gray-600 text-sm">Selecciona el que más te guste para CaletaWP</p>
    </div>

</body>
</html>