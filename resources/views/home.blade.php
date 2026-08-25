    @extends('layouts.frontend')



    @section('content')
        <!-- Hero Section -->
        <!-- Hero Section -->
        @php
            $heroStyle = request('hero') ?? ($settings['hero_style'] ?? 'circles');
        @endphp

        @if($heroStyle === 'circles')
            @includeIf('partials.heroes.circles')
        @elseif($heroStyle === 'stark')
            @includeIf('partials.heroes.stark')
        @elseif($heroStyle === 'cyber')
            @includeIf('partials.heroes.cyber')
        @elseif($heroStyle === 'split')
            @includeIf('partials.heroes.split')
        @else
            @includeIf('partials.heroes.aurora')
        @endif

        <!-- Trusted Brands & Promos Slider -->
        @if($homeBrandsEnabled && $brands->count() > 0)
        <section class="relative py-12 md:py-16 bg-[#0a0a0a] border-b border-white/[0.04] overflow-hidden">
            <!-- Sliding Neon Line divider -->
            <div class="absolute top-0 left-0 w-full h-px animated-line"></div>
            <div class="max-w-7xl mx-auto px-6 mb-8">
                <p class="text-center text-xs font-black text-gray-500 uppercase tracking-[0.2em]">{{ $homeBrandsTitle ?? 'Marcas de Confianza' }}</p>
            </div>
            
            <div class="relative">
                <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-[#0a0a0a] to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-[#0a0a0a] to-transparent z-10 pointer-events-none"></div>
                
                <div class="flex items-center gap-8 brands-marquee">
                    @foreach([$brands, $brands] as $brandGroup)
                        <div class="flex items-center gap-8 shrink-0" {{ $loop->index === 1 ? 'aria-hidden="true"' : '' }}>
                            @foreach($brandGroup as $brand)
                                @if($brand->is_promo)
                                    <!-- Promo / Ad Item -->
                                    <a href="{{ $brand->link_url ?: route('membership.claim-trial') }}" 
                                       class="flex items-center gap-3 px-5 py-2.5 rounded-xl shrink-0 transition-all duration-300 transform hover:scale-105 shadow-lg group/promo
                                       @if($brand->highlight_color === 'red')
                                           bg-gradient-to-r from-red-600/20 to-pink-600/10 border border-red-500/40 text-red-300 shadow-red-500/10 hover:border-red-400
                                       @elseif($brand->highlight_color === 'emerald')
                                           bg-gradient-to-r from-emerald-600/20 to-teal-600/10 border border-emerald-500/40 text-emerald-300 shadow-emerald-500/10 hover:border-emerald-400
                                       @elseif($brand->highlight_color === 'blue')
                                           bg-gradient-to-r from-blue-600/20 to-indigo-600/10 border border-blue-500/40 text-blue-300 shadow-blue-500/10 hover:border-blue-400
                                       @elseif($brand->highlight_color === 'purple')
                                           bg-gradient-to-r from-purple-600/20 to-pink-600/10 border border-purple-500/40 text-purple-300 shadow-purple-500/10 hover:border-purple-400
                                       @else
                                           bg-gradient-to-r from-amber-500/20 to-yellow-500/10 border border-amber-500/40 text-amber-300 shadow-amber-500/10 hover:border-amber-400
                                       @endif">
                                        <div class="w-8 h-8 rounded-lg bg-black/40 border border-white/10 flex items-center justify-center text-sm group-hover/promo:rotate-12 transition-transform">
                                            <i class="{{ $brand->icon ?? 'fas fa-bolt' }}"></i>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-black whitespace-nowrap">{{ $brand->name }}</span>
                                            @if($brand->badge_text)
                                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded bg-gradient-to-r from-red-600 to-amber-500 text-white shadow-sm animate-pulse">
                                                    {{ $brand->badge_text }}
                                                </span>
                                            @endif
                                        </div>
                                        <i class="fas fa-arrow-right text-[10px] opacity-70 group-hover/promo:translate-x-1 transition-transform"></i>
                                    </a>
                                @else
                                    <!-- Standard Brand Item -->
                                    @if($brand->link_url)
                                        <a href="{{ $brand->link_url }}" class="flex items-center gap-3 px-6 py-3 bg-white/[0.03] border border-white/[0.06] rounded-xl shrink-0 hover:bg-white/[0.08] hover:border-white/20 transition-all">
                                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                                                <i class="{{ $brand->icon ?? 'fas fa-cube' }} text-gray-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-bold text-gray-300 whitespace-nowrap">{{ $brand->name }}</span>
                                        </a>
                                    @else
                                        <div class="flex items-center gap-3 px-6 py-3 bg-white/[0.03] border border-white/[0.06] rounded-xl shrink-0 hover:bg-white/[0.06] transition-colors">
                                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                                                <i class="{{ $brand->icon ?? 'fas fa-cube' }} text-gray-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-bold text-gray-300 whitespace-nowrap">{{ $brand->name }}</span>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Products Section -->
        <section id="productos" class="pt-12 md:pt-16 pb-20 md:pb-24 bg-[#0a0a0a]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-full mb-4">
                            <i class="fas fa-fire text-[#FF2121] text-[10px]"></i>
                            <span class="text-[10px] font-black text-[#FF2121] uppercase tracking-widest">Destacados</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-2">{{ $settings['home_featured_title'] ?? 'Lo más Vendido' }}</h2>
                        <p class="text-gray-500 text-sm">{{ $settings['home_featured_description'] ?? 'Explora nuestras últimas novedades premium para WordPress.' }}</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="group flex items-center gap-2 px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#FF2121]/30 rounded-xl text-white text-sm font-bold transition-all">
                        Ver Todos
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                @if($homeProductsStyle === 'list')
                    <div class="space-y-4">
                        @forelse($products as $index => $product)
                        <div class="group relative">
                            <!-- Hover Glow Backdrop -->
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] rounded-2xl blur opacity-0 group-hover:opacity-75 transition duration-500"></div>
                             
                            <div class="relative bg-[#0c0c0c] rounded-xl p-4 flex items-center gap-6 border border-white/5 hover:border-transparent transition-all">
                                <!-- Rank Badge -->
                                <div class="absolute -left-3 -top-3 w-8 h-8 flex items-center justify-center bg-[#F51B1B] text-white font-black text-sm rounded-lg shadow-lg rotate-12 z-10 border border-white/20">
                                    #{{ $index + 1 }}
                                </div>

                                <!-- Points on Hover Badge (List View) -->
                                @php
                                    $pointsPerCurrency = \App\Models\Setting::where('key', 'points_per_currency')->value('value') ?? 1;
                                    $pts = ($product->reward_points > 0) 
                                            ? $product->reward_points 
                                            : floor($product->price * $pointsPerCurrency * ($product->points_multiplier ?? 1));
                                @endphp
                                @if($pts > 0)
                                    <div class="absolute top-3 right-3 z-20 px-2.5 py-1 bg-gray-900/90 backdrop-blur-md rounded-xl border border-amber-400/50 flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg shadow-black/50">
                                        <i class="fas fa-coins text-amber-300 text-[10px] drop-shadow-md"></i>
                                        <span class="text-xs font-black text-amber-300 leading-none drop-shadow-sm">+{{ $pts }} Pts</span>
                                    </div>
                                @endif

                                <!-- Image with Neon Border -->
                                <a href="{{ route('products.show', $product->slug) }}" class="w-20 h-20 flex-shrink-0 rounded-xl bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 p-2 border border-white/10 relative overflow-hidden group-hover:scale-105 transition-transform">
                                    <div class="absolute inset-0 bg-[#FF2121]/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="w-full h-full bg-[#1a1a1a] rounded-lg flex items-center justify-center relative z-10 overflow-hidden">
                                        @if($product->thumbnail)
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="{{ $index < 2 ? 'eager' : 'lazy' }}">
                                        @else
                                            <i class="fas {{ $product->type === 'theme' ? 'fa-palette' : 'fa-plug' }} text-3xl text-white"></i>
                                        @endif
                                    </div>
                                </a>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                        <span class="text-[9px] font-black text-white bg-gray-800/90 border border-white/20 uppercase tracking-wider px-2 py-0.5 rounded-md shadow-sm">{{ ucfirst($product->type) }}</span>
                                         
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-900 border border-emerald-500/40 rounded text-emerald-400 text-[9px] font-bold flex-shrink-0 shadow-sm">
                                            <i class="fas fa-code-branch text-[7px]"></i>
                                            v{{ $product->version }}
                                        </span>

                                        @if($product->badge)
                                            @php
                                                $badgeBg = match($product->badge) {
                                                    'Más Vendido', 'Mas Vendido' => 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-500/30 border-amber-300/40',
                                                    'Trending' => 'bg-gradient-to-r from-rose-500 to-pink-600 shadow-rose-500/30 border-rose-400/40',
                                                    'Popular' => 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-blue-500/30 border-blue-400/40',
                                                    'Nuevo', 'Nuevo Producto' => 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-emerald-500/30 border-emerald-400/40',
                                                    'Licencia', 'Licencia (Premium)' => 'bg-gradient-to-r from-yellow-500 to-amber-600 shadow-yellow-500/30 border-amber-300/40',
                                                    default => 'bg-gradient-to-r from-[#FF2121] to-[#F51B1B] shadow-[#FF2121]/40 border-red-400/40',
                                                };
                                            @endphp
                                            <span class="text-[9px] font-black text-white {{ $badgeBg }} px-2 py-0.5 rounded-md ml-1 shadow-md uppercase tracking-wider border">{{ $product->badge }}</span>
                                        @endif

                                        @if($product->is_recently_updated)
                                            <x-badge-updated size="xs" class="ml-2" />
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <h3 class="text-xl font-bold text-white group-hover:text-[#FF2121] transition-colors truncate">{{ $product->name }}</h3>
                                    </a>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="flex items-center gap-1 text-emerald-400 text-[10px] font-black uppercase tracking-wider bg-emerald-500/10 border border-emerald-500/20 px-1.5 py-0.5 rounded-md">
                                            <i class="fas fa-code-branch text-[8px]"></i>
                                            <span>v{{ $product->version }}</span>
                                        </div>
                                        <span class="text-xs text-gray-400 truncate">{{ $product->short_description ?? '' }}</span>
                                    </div>
                                </div>
                                
                                <!-- Meta & Action -->
                                <div class="flex items-center gap-6 px-4 border-l border-white/5">
                                    <div class="text-right">
                                        @if($product->price > 0)
                                            @if($product->sale_price && $product->sale_price < $product->price)
                                                <div class="flex flex-col items-end">
                                                    <span class="text-xs text-rose-400 line-through decoration-rose-500 font-bold opacity-70">
                                                        ${{ number_format($product->price, 2) }}
                                                    </span>
                                                    <div class="text-lg font-black text-white text-shadow-neon text-[#FF2121]">
                                                        ${{ number_format($product->sale_price, 2) }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-lg font-black text-white text-shadow-neon">${{ number_format($product->price, 2) }}</div>
                                            @endif
                                        @else
                                            <div class="text-lg font-black text-[#FF2121] text-shadow-neon">GRATIS</div>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-[#F51B1B] hover:bg-[#FF2121] text-white shadow-lg shadow-[#F51B1B]/30 flex items-center justify-center transition-all hover:scale-110 active:scale-95">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                No hay productos.
                            </div>
                        @endforelse
                    </div>
                @elseif($homeProductsStyle === 'minimalist')
                    {{-- Bloques Minimalistas --}}
                    <div class="grid grid-cols-2 sm:grid-cols-{{ min(($homeGridColumns ?? 6) - 2, 3) }} md:grid-cols-{{ min(($homeGridColumns ?? 6) - 1, 4) }} lg:grid-cols-{{ $homeGridColumns ?? 6 }} gap-6">
                        @forelse($products as $index => $product)
                        <div class="group relative bg-[#0c0c0c] border border-white/[0.06] rounded-2xl p-4 flex flex-col justify-between hover:border-[#FF2121]/40 transition-all duration-300 premium-glow h-full min-h-[220px]">
                            <div class="w-full flex flex-col items-center text-center">
                                <!-- Version Badge (Top-left corner) -->
                                <span class="absolute top-2 left-2 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[7px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded leading-none shadow-sm shadow-amber-500/5">
                                    v{{ $product->version }}
                                </span>

                                <!-- Badge de Estado (Top corner) -->
                                @if($product->badge)
                                    @php
                                        $badges = [
                                            'Más Vendido' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'Mas Vendido' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'Trending' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'Popular' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'Nuevo' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'Nuevo Producto' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'Licencia' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                        ];
                                        $badgeClass = $badges[$product->badge] ?? 'bg-white/5 text-white/50 border-white/10';
                                    @endphp
                                    <span class="absolute top-2 right-2 {{ $badgeClass }} border text-[7px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded leading-none">
                                        {{ $product->badge }}
                                    </span>
                                @endif

                                <!-- Image Container -->
                                <a href="{{ route('products.show', $product->slug) }}" class="relative w-14 h-14 rounded-2xl bg-white/5 border border-white/5 overflow-hidden flex items-center justify-center mb-3 transition-all group-hover:border-[#FF2121]/30 group-hover:bg-[#FF2121]/5 mt-4">
                                    @if($product->thumbnail)
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-300" loading="{{ $index < 2 ? 'eager' : 'lazy' }}">
                                    @else
                                        <i class="fas {{ $product->type === 'theme' ? 'fa-palette' : 'fa-plug' }} text-xl text-gray-400 group-hover:text-[#FF2121] transition-colors"></i>
                                    @endif
                                </a>

                                <!-- Title -->
                                <a href="{{ route('products.show', $product->slug) }}" class="block w-full">
                                    <h3 class="text-sm font-bold text-white tracking-tight group-hover:text-[#FF2121] transition-colors line-clamp-2 min-h-[2.25rem] leading-snug">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <!-- Subtitle / Category -->
                                <p class="text-[10px] text-gray-500 mt-1 truncate w-full">
                                    {{ $product->category->name ?? ucfirst($product->type) }}
                                </p>
                            </div>

                            <!-- Bottom Row: Price (left) and Add button (right) at the same level -->
                            <div class="w-full flex items-center justify-between gap-2 mt-4 pt-3 border-t border-white/[0.04]">
                                <!-- Price (Left) -->
                                <div class="text-left shrink-0">
                                    @if($product->price > 0)
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <div class="flex flex-col">
                                                <span class="text-[9px] text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                                <span class="text-white text-xs font-black leading-none">${{ number_format($product->sale_price, 2) }}</span>
                                            </div>
                                        @else
                                            <span class="text-white text-xs font-black leading-none">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    @else
                                        <span class="text-[#FF2121] font-black text-[10px] uppercase tracking-wider leading-none">Gratis</span>
                                    @endif
                                </div>

                                <!-- Add to Cart Button (Right) -->
                                <div class="flex-grow max-w-[90px]">
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-1.5 px-2 rounded-lg bg-[#F51B1B] hover:bg-[#FF2121] text-white text-[9px] font-black uppercase tracking-wider flex items-center justify-center gap-1 transition-all hover:scale-105 active:scale-95 shadow-md shadow-[#F51B1B]/10">
                                            <i class="fas fa-shopping-cart text-[8px]"></i>
                                            Añadir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                No hay productos.
                            </div>
                        @endforelse
                    </div>
                @elseif($homeProductsStyle === 'two_columns')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
                        
                        <!-- Columna 1: Últimos Plugins (5 ítems) -->
                        <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-500/10 blur-3xl rounded-full pointer-events-none"></div>

                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-lg shadow-emerald-500/20">
                                        <i class="fas fa-plug text-base"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-white tracking-tight">Últimos Plugins</h3>
                                        <p class="text-xs text-gray-500 font-medium">Los complementos agregados recientemente</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase tracking-wider rounded-lg">Nuevos</span>
                            </div>

                            <div class="space-y-3.5">
                                @forelse($latestPlugins as $index => $item)
                                    <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-emerald-500/30 transition-all duration-300 group/item">
                                        <div class="flex items-center gap-3.5 min-w-0">
                                            <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-emerald-400 group-hover/item:border-emerald-500/40">
                                                #{{ $index + 1 }}
                                            </span>
                                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                                @if($item->thumbnail)
                                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-emerald-500/20 to-teal-600/20 flex items-center justify-center text-white/50 text-xs">
                                                        <i class="fas fa-plug"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ route('products.show', $item->slug) }}" class="text-sm font-bold text-white group-hover/item:text-emerald-400 transition-colors truncate block">
                                                    {{ $item->name }}
                                                </a>
                                                <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                                                    <span class="text-[9px] font-black uppercase tracking-wider text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">v{{ $item->version }}</span>
                                                    @if($item->badge)
                                                        @php
                                                            $itemBadgeBg = match($item->badge) {
                                                                'Más Vendido', 'Mas Vendido' => 'bg-amber-500/15 text-amber-400 border-amber-500/30',
                                                                'Trending' => 'bg-rose-500/15 text-rose-400 border-rose-500/30',
                                                                'Popular' => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
                                                                'Nuevo', 'Nuevo Producto' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
                                                                'Licencia', 'Licencia (Premium)' => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
                                                                default => 'bg-[#FF2121]/15 text-[#FF2121] border-[#FF2121]/30',
                                                            };
                                                        @endphp
                                                        <span class="text-[8.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded border {{ $itemBadgeBg }} leading-none">{{ $item->badge }}</span>
                                                    @endif
                                                    @if($item->is_recently_updated)
                                                        <x-badge-updated size="xs" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 shrink-0 ml-4">
                                            <span class="text-xs font-black text-white font-mono shrink-0">${{ number_format($item->price, 2) }}</span>
                                            <form action="{{ route('cart.add', $item) }}" method="POST" class="shrink-0">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-emerald-500 text-gray-300 hover:text-white border border-white/10 hover:border-emerald-500 transition-all flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-cart-plus text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-500 text-center py-4">No hay plugins recientes.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Columna 2: Últimos Temas (5 ítems) -->
                        <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-purple-500/10 blur-3xl rounded-full pointer-events-none"></div>

                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-purple-400 shadow-lg shadow-purple-500/20">
                                        <i class="fas fa-palette text-base"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-white tracking-tight">Últimos Temas</h3>
                                        <p class="text-xs text-gray-500 font-medium">Plantillas y diseños agregados recientemente</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-purple-500/10 border border-purple-500/30 text-purple-400 text-[10px] font-black uppercase tracking-wider rounded-lg">Nuevos</span>
                            </div>

                            <div class="space-y-3.5">
                                @forelse($latestThemes as $index => $item)
                                    <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-purple-500/30 transition-all duration-300 group/item">
                                        <div class="flex items-center gap-3.5 min-w-0">
                                            <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-purple-400 group-hover/item:border-purple-500/40">
                                                #{{ $index + 1 }}
                                            </span>
                                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                                @if($item->thumbnail)
                                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-purple-500/20 to-indigo-600/20 flex items-center justify-center text-white/50 text-xs">
                                                        <i class="fas fa-palette"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ route('products.show', $item->slug) }}" class="text-sm font-bold text-white group-hover/item:text-purple-400 transition-colors truncate block">
                                                    {{ $item->name }}
                                                </a>
                                                <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                                                    <span class="text-[9px] font-black uppercase tracking-wider text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded border border-purple-500/20">v{{ $item->version }}</span>
                                                    @if($item->badge)
                                                        @php
                                                            $itemBadgeBg = match($item->badge) {
                                                                'Más Vendido', 'Mas Vendido' => 'bg-amber-500/15 text-amber-400 border-amber-500/30',
                                                                'Trending' => 'bg-rose-500/15 text-rose-400 border-rose-500/30',
                                                                'Popular' => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
                                                                'Nuevo', 'Nuevo Producto' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
                                                                'Licencia', 'Licencia (Premium)' => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
                                                                default => 'bg-[#FF2121]/15 text-[#FF2121] border-[#FF2121]/30',
                                                            };
                                                        @endphp
                                                        <span class="text-[8.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded border {{ $itemBadgeBg }} leading-none">{{ $item->badge }}</span>
                                                    @endif
                                                    @if($item->is_recently_updated)
                                                        <x-badge-updated size="xs" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 shrink-0 ml-4">
                                            <span class="text-xs font-black text-white font-mono shrink-0">${{ number_format($item->price, 2) }}</span>
                                            <form action="{{ route('cart.add', $item) }}" method="POST" class="shrink-0">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-purple-500 text-gray-300 hover:text-white border border-white/10 hover:border-purple-500 transition-all flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-cart-plus text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-500 text-center py-4">No hay temas recientes.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    @if($templateKits->count() > 0 || $otherResources->count() > 0)
                        <!-- Otros Recursos y Kits de Plantillas (2 Columnas) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                            
                            <!-- Columna Izquierda: Kits de Plantillas -->
                            <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-40 h-40 bg-amber-500/10 blur-3xl rounded-full pointer-events-none"></div>

                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400 shadow-lg shadow-amber-500/20">
                                            <i class="fas fa-cubes text-base"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-white tracking-tight">Kits de Plantillas</h3>
                                            <p class="text-xs text-gray-500 font-medium">Elementor Kits y maquetaciones web completas</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-400 text-[10px] font-black uppercase tracking-wider rounded-lg">Kits</span>
                                </div>

                                <div class="space-y-3.5">
                                    @forelse($templateKits as $index => $item)
                                        <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-amber-500/30 transition-all duration-300 group/item">
                                            <div class="flex items-center gap-3.5 min-w-0">
                                                <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-amber-400 group-hover/item:border-amber-500/40">
                                                    #{{ $index + 1 }}
                                                </span>
                                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                                    @if($item->thumbnail)
                                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                                    @else
                                                        <div class="w-full h-full bg-gradient-to-br from-amber-500/20 to-yellow-600/20 flex items-center justify-center text-white/50 text-xs">
                                                            <i class="fas fa-cubes"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <a href="{{ route('products.show', $item->slug) }}" class="text-sm font-bold text-white group-hover/item:text-amber-400 transition-colors truncate block">
                                                        {{ $item->name }}
                                                    </a>
                                                    <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                                                        <span class="text-[9px] font-black uppercase tracking-wider text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20 whitespace-nowrap">v{{ $item->version }}</span>
                                                        @if($item->badge)
                                                            @php
                                                                $itemBadgeBg = match($item->badge) {
                                                                    'Más Vendido', 'Mas Vendido' => 'bg-amber-500/15 text-amber-400 border-amber-500/30',
                                                                    'Trending' => 'bg-rose-500/15 text-rose-400 border-rose-500/30',
                                                                    'Popular' => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
                                                                    'Nuevo', 'Nuevo Producto' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
                                                                    'Licencia', 'Licencia (Premium)' => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
                                                                    default => 'bg-[#FF2121]/15 text-[#FF2121] border-[#FF2121]/30',
                                                                };
                                                            @endphp
                                                            <span class="text-[8.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded border {{ $itemBadgeBg }} leading-none">{{ $item->badge }}</span>
                                                        @endif
                                                        @if($item->is_recently_updated)
                                                            <x-badge-updated size="xs" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3 shrink-0 ml-4">
                                                <span class="text-xs font-black text-white font-mono shrink-0">${{ number_format($item->price, 2) }}</span>
                                                <form action="{{ route('cart.add', $item) }}" method="POST" class="shrink-0">
                                                    @csrf
                                                    <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-amber-500 text-gray-300 hover:text-white border border-white/10 hover:border-amber-500 transition-all flex items-center justify-center shadow-sm">
                                                        <i class="fas fa-cart-plus text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-500 text-center py-4">No hay kits de plantillas recientes.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Columna Derecha: Otras Categorías -->
                            <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-500/10 blur-3xl rounded-full pointer-events-none"></div>

                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 shadow-lg shadow-indigo-500/20">
                                            <i class="fas fa-folder-open text-base"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-black text-white tracking-tight">Otras Categorías</h3>
                                            <p class="text-xs text-gray-500 font-medium">Traducciones, complementos y recursos varios</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-[10px] font-black uppercase tracking-wider rounded-lg whitespace-nowrap">Otros Recursos</span>
                                </div>

                                <div class="space-y-3.5">
                                    @forelse($otherResources as $index => $item)
                                        <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-indigo-500/30 transition-all duration-300 group/item">
                                            <div class="flex items-center gap-3.5 min-w-0">
                                                <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-indigo-400 group-hover/item:border-indigo-500/40">
                                                    #{{ $index + 1 }}
                                                </span>
                                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                                    @if($item->thumbnail)
                                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                                    @else
                                                        <div class="w-full h-full bg-gradient-to-br from-indigo-500/20 to-purple-600/20 flex items-center justify-center text-white/50 text-xs">
                                                            <i class="fas fa-folder-open"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <a href="{{ route('products.show', $item->slug) }}" class="text-sm font-bold text-white group-hover/item:text-indigo-400 transition-colors truncate block">
                                                        {{ $item->name }}
                                                    </a>
                                                    <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                                                        <span class="text-[9px] font-black uppercase tracking-wider text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20 whitespace-nowrap">{{ $item->category->name ?? 'Recurso' }}</span>
                                                        <span class="text-[9px] font-black uppercase tracking-wider text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20 whitespace-nowrap">v{{ $item->version }}</span>
                                                        @if($item->badge)
                                                            @php
                                                                $itemBadgeBg = match($item->badge) {
                                                                    'Más Vendido', 'Mas Vendido' => 'bg-amber-500/15 text-amber-400 border-amber-500/30',
                                                                    'Trending' => 'bg-rose-500/15 text-rose-400 border-rose-500/30',
                                                                    'Popular' => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
                                                                    'Nuevo', 'Nuevo Producto' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
                                                                    'Licencia', 'Licencia (Premium)' => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
                                                                    default => 'bg-[#FF2121]/15 text-[#FF2121] border-[#FF2121]/30',
                                                                };
                                                            @endphp
                                                            <span class="text-[8.5px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded border {{ $itemBadgeBg }} leading-none">{{ $item->badge }}</span>
                                                        @endif
                                                        @if($item->is_recently_updated)
                                                            <x-badge-updated size="xs" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3 shrink-0 ml-4">
                                                <span class="text-xs font-black text-white font-mono shrink-0">${{ number_format($item->price, 2) }}</span>
                                                <form action="{{ route('cart.add', $item) }}" method="POST" class="shrink-0">
                                                    @csrf
                                                    <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-indigo-500 text-gray-300 hover:text-white border border-white/10 hover:border-indigo-500 transition-all flex items-center justify-center shadow-sm">
                                                        <i class="fas fa-cart-plus text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-500 text-center py-4">No hay otros recursos recientes.</p>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    @endif
                @elseif($homeProductsStyle === 'bento')
                    @includeIf('partials.products.bento')
                @elseif($homeProductsStyle === 'bauhaus')
                    {{-- Bauhaus Index --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($products as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="bg-[#0c0c0e] text-white border-2 border-[#FF2121] rounded-none p-6 flex flex-col justify-between min-h-[250px] hover:bg-[#FF2121] hover:text-black transition-colors duration-200 group relative block cursor-pointer">
                            <div>
                                <div class="flex justify-between items-start mb-6">
                                    <span class="text-[9px] font-black uppercase tracking-widest border-2 border-[#FF2121] px-2.5 py-1 bg-[#FF2121] text-white group-hover:bg-black group-hover:text-[#FF2121] group-hover:border-black transition-colors leading-none">
                                        {{ $product->category->name ?? 'RECURSO' }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        @if($product->badge)
                                            <span class="text-[9px] font-black uppercase tracking-widest border-2 border-white px-2 py-0.5 text-white group-hover:border-black group-hover:text-black transition-colors leading-none">
                                                {{ $product->badge }}
                                            </span>
                                        @endif
                                        @if($product->is_recently_updated)
                                            <x-badge-updated size="xs" />
                                        @endif
                                        <span class="text-xs font-mono font-bold text-gray-400 group-hover:text-black transition-colors">v{{ $product->version }}</span>
                                    </div>
                                </div>
                                <h3 class="text-xl font-black tracking-tight leading-tight line-clamp-2 uppercase font-mono">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-400 mt-2 line-clamp-2 group-hover:text-black/80 transition-colors font-sans">{{ $product->short_description ?? '' }}</p>
                            </div>
                            <div class="flex justify-between items-end border-t-2 border-[#FF2121] pt-4 mt-6">
                                <span class="text-2xl font-black font-mono tracking-tighter">{{ $product->formatted_price }}</span>
                                <span class="text-xs font-black uppercase tracking-widest underline decoration-2 underline-offset-4 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                    OBTENER <i class="fas fa-arrow-right text-[10px]"></i>
                                </span>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full py-12 text-center text-gray-500">
                            No hay productos.
                        </div>
                        @endforelse
                    </div>
                @else
                    {{-- Default Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-{{ min(($homeGridColumns ?? 6) - 2, 3) }} md:grid-cols-{{ min(($homeGridColumns ?? 6) - 1, 4) }} lg:grid-cols-{{ $homeGridColumns ?? 6 }} gap-6">
                        @forelse($products as $index => $product)
                        <div class="bg-gray-800/60 rounded-xl overflow-hidden border border-white/10 hover:border-[#FF2121]/50 transition-all group cursor-pointer">
                            <!-- Imagen Compacta Centrada -->
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="aspect-square bg-gradient-to-br from-[#FF2121]/10 to-[#F51B1B]/10 flex items-center justify-center text-4xl relative overflow-hidden">
                                    @if($product->thumbnail)
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                            alt="{{ $product->name }}" 
                                            loading="{{ $index < 2 ? 'eager' : 'lazy' }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20">
                                            <i class="fas {{ $product->type === 'theme' ? 'fa-palette' : 'fa-plug' }} text-5xl text-white/50"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Badge de Estado -->
                                    <div class="absolute top-3 left-3 z-30 flex flex-col gap-1.5 items-start">
                                        @if($product->badge)
                                            @php
                                                $badges = [
                                                    'Más Vendido' => ['bg' => 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-500/30 border-amber-300/40', 'icon' => 'fa-crown'],
                                                    'Mas Vendido' => ['bg' => 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-500/30 border-amber-300/40', 'icon' => 'fa-crown'],
                                                    'Trending' => ['bg' => 'bg-gradient-to-r from-rose-500 to-pink-600 shadow-rose-500/30 border-rose-400/40', 'icon' => 'fa-fire'],
                                                    'Popular' => ['bg' => 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-blue-500/30 border-blue-400/40', 'icon' => 'fa-star'],
                                                    'Nuevo' => ['bg' => 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-emerald-500/30 border-emerald-400/40', 'icon' => 'fa-bolt'],
                                                    'Nuevo Producto' => ['bg' => 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-emerald-500/30 border-emerald-400/40', 'icon' => 'fa-bolt'],
                                                    'Licencia' => ['bg' => 'bg-gradient-to-r from-yellow-500 to-amber-600 shadow-yellow-500/30 border-amber-300/40', 'icon' => 'fa-key'],
                                                    'Licencia (Premium)' => ['bg' => 'bg-gradient-to-r from-yellow-500 to-amber-600 shadow-yellow-500/30 border-amber-300/40', 'icon' => 'fa-key'],
                                                ];
                                                $badgeData = $badges[$product->badge] ?? ['bg' => 'bg-gradient-to-r from-[#FF2121] to-[#F51B1B] shadow-[#FF2121]/40 border-red-400/40', 'icon' => 'fa-tag'];
                                                $icon = $badgeData['icon'];
                                                $bg = $badgeData['bg'];
                                            @endphp
                                            <span class="flex items-center gap-1.5 text-[9px] font-black text-white {{ $bg }} backdrop-blur-md px-2.5 py-1 rounded-xl shadow-lg uppercase tracking-wider border leading-none">
                                                <i class="fas {{ $icon }} text-[8px]"></i>
                                                {{ $product->badge }}
                                            </span>
                                        @endif

                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            @php
                                                $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                                            @endphp
                                            <span class="flex items-center gap-1.5 text-[9px] font-black text-white bg-rose-600 px-2.5 py-1 rounded-xl shadow-lg uppercase tracking-wider border border-white/10 shadow-black/30 leading-none animate-pulse">
                                                <i class="fas fa-percent text-[8px]"></i>
                                                {{ $discount }}% OFF
                                            </span>
                                        @endif

                                        @if($product->is_recently_updated)
                                            <x-badge-updated size="sm" />
                                        @endif

                                        {{-- Mostrar puntos debajo del badge si el badge es largo (más de 8 caracteres) --}}
                                        @php
                                            $hasLongBadge = $product->badge && strlen($product->badge) > 8;
                                            $pointsPerCurrency = \App\Models\Setting::where('key', 'points_per_currency')->value('value') ?? 1;
                                            $pts = ($product->reward_points > 0) 
                                                    ? $product->reward_points 
                                                    : floor($product->price * $pointsPerCurrency * ($product->points_multiplier ?? 1));
                                        @endphp
                                         
                                        @if($hasLongBadge && $pts > 0)
                                            <span class="flex items-center gap-1.5 px-2.5 py-1 bg-gray-900/90 backdrop-blur-md rounded-xl border border-amber-400/50 shadow-lg shadow-black/50">
                                                <i class="fas fa-coins text-amber-300 text-[10px] drop-shadow-md"></i>
                                                <span class="text-xs font-black text-amber-300 leading-none drop-shadow-sm">+{{ $pts }} Pts</span>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Points on Hover Badge - Solo si NO hay badge largo --}}
                                    @if(!$hasLongBadge && $pts > 0)
                                        <div class="absolute top-3 right-3 z-30 px-2.5 py-1 bg-gray-900/90 backdrop-blur-md rounded-xl border border-amber-400/50 flex items-center gap-1.5 transform translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 shadow-lg shadow-black/50">
                                            <i class="fas fa-coins text-amber-300 text-[10px] drop-shadow-md"></i>
                                            <span class="text-xs font-black text-amber-300 leading-none drop-shadow-sm">+{{ $pts }} Pts</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            
                            <!-- Contenido -->
                            <div class="p-3">
                                <!-- Título con Versión al lado -->
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="flex-1 min-w-0">
                                        <h4 class="font-bold text-sm truncate group-hover:text-[#FF2121] transition-colors">
                                            {{ $product->name }}
                                        </h4>
                                    <i class="fas {{ $product->type === 'theme' ? 'fa-palette' : 'fa-plug' }} text-sm"></i>
                                    </a>
                                     
                                    <!-- Badge de Versión Rojo -->
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#FF2121]/20 border border-[#FF2121]/30 rounded text-[#FF2121] text-[9px] font-bold">
                                            <i class="fas fa-code-branch text-[7px]"></i>
                                            v{{ $product->version }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Precio y Botón -->
                                <div class="flex items-center justify-between mt-3">
                                    <div class="text-lg font-black">
                                        @if($product->price == 0)
                                            <span class="text-[#FF2121] text-sm">GRATIS</span>
                                        @elseif($product->sale_price && $product->sale_price < $product->price)
                                            <div class="flex flex-col items-start leading-none gap-0.5">
                                                <span class="text-[10px] text-rose-400 line-through decoration-rose-500 font-bold opacity-70">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                                <span class="text-[#FF2121] text-lg">
                                                    ${{ number_format($product->sale_price, 2) }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-white">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Botón de Carrito Rápido -->
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="w-7 h-7 bg-[#F51B1B] hover:bg-[#FF2121] rounded-lg flex items-center justify-center transition-all hover:scale-110">
                                            <i class="fas fa-cart-plus text-xs text-white"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-span-full py-16 text-center glass rounded-3xl border-dashed border-2 border-white/5">
                                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-300 font-bold">No hay productos disponibles.</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </section>

        <!-- Sección 2 Columnas: Más Comprados & Populares -->
        <section class="py-20 bg-[#050505] border-t border-white/5">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-12 md:mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-full mb-4">
                        <i class="fas fa-trophy text-[#FF2121] text-[10px]"></i>
                        <span class="text-[10px] font-black text-[#FF2121] uppercase tracking-widest">Favoritos</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-3">Los Preferidos de la Comunidad</h2>
                    <p class="text-gray-500 text-sm max-w-lg mx-auto">Explora los plugins y temas GPL más descargados y con mejores valoraciones de nuestra plataforma.</p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
                    
                    <!-- Columna 1: Más Comprados (5 ítems) -->
                    <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-[#FF2121]/10 blur-3xl rounded-full pointer-events-none"></div>

                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-[#FF2121]/20 border border-[#FF2121]/30 flex items-center justify-center text-[#FF2121] shadow-lg shadow-[#FF2121]/20">
                                    <i class="fas fa-fire text-base"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white tracking-tight">Más Comprados</h3>
                                    <p class="text-xs text-gray-500 font-medium">Los plugins y temas más adquiridos</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-[#FF2121]/10 border border-[#FF2121]/30 text-[#FF2121] text-[10px] font-black uppercase tracking-wider rounded-lg">Top 5</span>
                        </div>

                        <div class="space-y-3.5">
                            @foreach($bestSellers->take(5) as $index => $item)
                                <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-[#FF2121]/30 transition-all duration-300 group/item">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-[#FF2121] group-hover/item:border-[#FF2121]/40">
                                            #{{ $index + 1 }}
                                        </span>
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                            @if($item->thumbnail)
                                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 flex items-center justify-center text-white/50 text-xs">
                                                    <i class="fas {{ $item->type === 'theme' ? 'fa-palette' : 'fa-plug' }}"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('products.show', $item->slug) }}" class="text-sm font-bold text-white group-hover/item:text-[#FF2121] transition-colors truncate block">
                                                {{ $item->name }}
                                            </a>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400 bg-white/5 px-2 py-0.5 rounded border border-white/10">{{ $item->type }}</span>
                                                <span class="text-xs font-black text-white font-mono">${{ number_format($item->price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('cart.add', $item) }}" method="POST" class="shrink-0 ml-2">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-[#FF2121] text-gray-300 hover:text-white border border-white/10 hover:border-[#FF2121] transition-all flex items-center justify-center shadow-sm">
                                            <i class="fas fa-cart-plus text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Columna 2: Populares (5 ítems) -->
                    <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-sky-500/10 blur-3xl rounded-full pointer-events-none"></div>

                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-sky-500/20 border border-sky-500/30 flex items-center justify-center text-sky-400 shadow-lg shadow-sky-500/20">
                                    <i class="fas fa-star text-base"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white tracking-tight">Populares</h3>
                                    <p class="text-xs text-gray-500 font-medium">Los recursos mejor valorados por la comunidad</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-sky-500/10 border border-sky-500/30 text-sky-400 text-[10px] font-black uppercase tracking-wider rounded-lg">Top 5</span>
                        </div>

                        <div class="space-y-3.5">
                            @foreach($popularProducts->take(5) as $index => $item)
                                <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-sky-500/30 transition-all duration-300 group/item">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-sky-400 group-hover/item:border-sky-500/40">
                                            #{{ $index + 1 }}
                                        </span>
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                            @if($item->thumbnail)
                                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-sky-500/20 to-blue-600/20 flex items-center justify-center text-white/50 text-xs">
                                                    <i class="fas {{ $item->type === 'theme' ? 'fa-palette' : 'fa-plug' }}"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('products.show', $item->slug) }}" class="text-sm font-bold text-white group-hover/item:text-sky-400 transition-colors truncate block">
                                                {{ $item->name }}
                                            </a>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400 bg-white/5 px-2 py-0.5 rounded border border-white/10">{{ $item->type }}</span>
                                                <span class="text-xs font-black text-white font-mono">${{ number_format($item->price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('cart.add', $item) }}" method="POST" class="shrink-0 ml-2">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-sky-500 text-gray-300 hover:text-white border border-white/10 hover:border-sky-500 transition-all flex items-center justify-center shadow-sm">
                                            <i class="fas fa-cart-plus text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <!-- Plans Section -->
        <section id="planes" class="py-20 md:py-24 bg-[#080808] relative overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-[#FF2121]/5 blur-[120px] rounded-full pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative">
                <div class="text-center mb-12 md:mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-500/10 border border-amber-500/20 rounded-full mb-4">
                        <i class="fas fa-crown text-amber-400 text-[10px]"></i>
                        <span class="text-[10px] font-black text-amber-300 uppercase tracking-widest">Membresías</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-3">Elige tu Plan</h2>
                    <p class="text-gray-500 text-sm max-w-lg mx-auto">Obtén acceso ilimitado a toda nuestra biblioteca premium por una fracción del costo.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                    @forelse($plans as $plan)
                        @php
                            $featuredClass = $plan->is_featured ? 'border-[#FF2121]/30 shadow-lg shadow-[#FF2121]/10' : 'border-white/[0.06]';
                            $featuredOffset = $plan->is_featured ? 'md:-mt-4 md:mb-4' : '';
                        @endphp
                        <div class="relative bg-[#0a0a0a] border {{ $featuredClass }} rounded-2xl p-6 md:p-8 flex flex-col {{ $featuredOffset }}">
                            @if($plan->is_featured)
                                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] text-white text-[10px] font-black px-4 py-1.5 uppercase tracking-wider rounded-full shadow-lg animated-badge">
                                    Recomendado
                                </div>
                            @endif

                            <div class="mb-6">
                                <h3 class="text-sm font-black {{ $plan->is_featured ? 'text-[#FF2121]' : 'text-gray-400' }} uppercase tracking-widest mb-4">{{ $plan->name }}</h3>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-4xl md:text-5xl font-black text-white">${{ $plan->price == (int)$plan->price ? number_format($plan->price, 0) : number_format($plan->price, 2) }}</span>
                                    <span class="text-gray-500 text-xs font-bold">/ {{ $plan->duration }}</span>
                                </div>
                            </div>

                            <div class="space-y-3 mb-8 flex-1">
                                @foreach($plan->benefits ?? [] as $benefit)
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full {{ $plan->is_featured ? 'bg-[#FF2121]/20' : 'bg-white/5' }} flex items-center justify-center shrink-0 mt-0.5">
                                            <i class="fas fa-check text-[10px] {{ $plan->is_featured ? 'text-[#FF2121]' : 'text-gray-500' }}"></i>
                                        </div>
                                        <span class="text-sm text-gray-400 leading-relaxed">{{ $benefit }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <form action="{{ route('membership.add', $plan) }}" method="POST">
                                @csrf
                                @php
                                    $buttonClass = $plan->is_featured 
                                        ? 'bg-[#F51B1B] hover:bg-[#FF2121] text-white shadow-lg shadow-[#F51B1B]/20' 
                                        : 'bg-white/5 hover:bg-white/10 border border-white/10 text-white';
                                @endphp
                                <button type="submit" class="w-full py-3.5 rounded-xl font-black text-sm transition-all {{ $buttonClass }}">
                                    Activar Ahora
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes disponibles.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section id="categorias" class="py-20 md:py-24 bg-[#080808] relative overflow-hidden">
            <!-- Split background: solid left + animated dots right -->
            <div class="absolute inset-0 split-dots-bg"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="mb-10">
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-2">Explorar por categoría</h2>
                    <p class="text-gray-500 text-sm">Encuentra exactamente lo que necesitas.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="group relative bg-[#0a0a0a] border border-white/[0.06] hover:border-white/20 rounded-2xl p-5 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#FF2121]/5 {{ $category->products_count > 0 ? 'category-pulse' : '' }}">
                            <div class="w-12 h-12 rounded-xl bg-white/5 group-hover:bg-[#FF2121]/10 flex items-center justify-center mb-4 transition-colors duration-300">
                                <i class="{{ $category->icon ?? 'fas fa-folder' }} text-xl text-gray-400 group-hover:text-[#FF2121] transition-colors duration-300"></i>
                            </div>
                            <h3 class="text-sm font-black text-white mb-1 line-clamp-1 group-hover:text-[#FF2121] transition-colors">{{ $category->name }}</h3>
                            <span class="text-xs text-gray-500">{{ $category->products_count }} {{ $category->products_count === 1 ? 'producto' : 'productos' }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>



        @php
            $orgSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $settings['site_name'] ?? 'WP Marketplace',
                'url' => route('home'),
                'logo' => isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('images/logo-default.png'),
                'description' => $settings['site_description'] ?? 'Themes y Plugins Premium para WordPress'
            ];
        @endphp
        <script type="application/ld+json">
            {!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <style>
        @keyframes shimmer {
            100% { left: 200%; }
        }
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Split animated dots background */
        .split-dots-bg {
            background: linear-gradient(135deg, #0a0a0a 0%, #0a0a0a 50%, #080808 50%, #080808 100%);
        }
        .split-dots-bg::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 32px 32px;
            animation: dots-drift 20s linear infinite;
            opacity: 0.6;
        }
        .split-dots-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 1px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(255, 33, 33, 0.3), transparent);
            transform: translateX(-50%);
        }
        @keyframes dots-drift {
            0% { background-position: 0 0; }
            100% { background-position: 32px 32px; }
        }

        /* Brands marquee slider */
        .brands-marquee {
            animation: marquee-scroll 30s linear infinite;
        }
        .brands-marquee:hover {
            animation-play-state: paused;
        }
        @keyframes marquee-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .animated-line {
            background: linear-gradient(90deg, transparent 0%, rgba(255, 33, 33, 0.15) 35%, rgba(255, 33, 33, 0.8) 50%, rgba(255, 33, 33, 0.15) 65%, transparent 100%);
            background-size: 200% 100%;
            animation: line-slide 3s linear infinite;
        }
        @keyframes line-slide {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }

        /* Category pulse for categories with products */
        .category-pulse {
            position: relative;
        }
        .category-pulse::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(255, 33, 33, 0.3), transparent, rgba(255, 33, 33, 0.2));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
            filter: blur(8px);
        }
        .category-pulse:hover::before {
            opacity: 1;
            animation: category-glow 2s ease-in-out infinite;
        }
        @keyframes category-glow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        </style>
    @endsection