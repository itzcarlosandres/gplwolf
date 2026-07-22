@extends('layouts.frontend')

@section('title', 'Explorar Productos | WP Marketplace')

@section('content')
<!-- Header Section -->
<section class="relative overflow-hidden border-b border-white/5 bg-[#0a0a0a]">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#F51B1B]/5 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#F51B1B]/5 rounded-full blur-[120px]"></div>
    
    <div class="max-w-7xl mx-auto px-6 py-16 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-lg text-[10px] font-black uppercase tracking-widest text-[#FF2121] mb-4">
                    <i class="fas fa-cubes text-[10px]"></i>
                    {{ $products->total() ?? 0 }} Productos disponibles
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-3">{{ $sectionTitle }}</h1>
                <p class="text-gray-500 text-base font-medium max-w-xl">Descubre themes, plugins y herramientas premium para llevar tus proyectos WordPress al siguiente nivel.</p>
            </div>
            
            <!-- Sort & View -->
            <div class="flex items-center gap-3">
                <div class="relative">
                    <select name="sort" onchange="window.location.href=this.value" class="appearance-none bg-[#080808] border border-white/[0.08] rounded-xl pl-10 pr-10 py-3 text-white text-sm font-bold focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
                        @php
                            $currentSort = request('sort', 'latest');
                            $sortOptions = [
                                route('products.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) => 'Más recientes',
                                route('products.index', array_merge(request()->except('sort'), ['sort' => 'popular'])) => 'Más populares',
                                route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) => 'Precio: menor a mayor',
                                route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) => 'Precio: mayor a menor',
                                route('products.index', array_merge(request()->except('sort'), ['sort' => 'rating'])) => 'Mejor valorados',
                            ];
                        @endphp
                        @foreach($sortOptions as $url => $label)
                            <option value="{{ $url }}" {{ $currentSort === array_search($url, $sortOptions) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-sort absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                    <i class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs pointer-events-none"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="py-12">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar -->
        <aside class="w-full lg:w-72 flex-shrink-0">
            <div class="lg:sticky lg:top-24 space-y-6">
                <!-- Categories -->
                <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-white/[0.06]">
                        <h4 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-layer-group text-[#FF2121] text-xs"></i>
                            Categorías
                        </h4>
                    </div>
                    <div class="p-2">
                        @php
                            $reqCategory = request('category');
                            $routeCategory = request()->route('category');
                            if (is_object($reqCategory)) {
                                $currentCategory = $reqCategory->slug;
                            } elseif ($reqCategory) {
                                $currentCategory = $reqCategory;
                            } elseif (is_object($routeCategory)) {
                                $currentCategory = $routeCategory->slug;
                            } else {
                                $currentCategory = null;
                            }
                        @endphp
                        <a href="{{ route('products.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all mb-1 {{ !$currentCategory ? 'bg-gradient-to-r from-[#FF2121]/20 to-[#F51B1B]/10 border border-[#FF2121]/30' : 'hover:bg-white/[0.03] border border-transparent' }}">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 flex items-center justify-center">
                                <i class="fas fa-th-large text-[#FF2121] text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold {{ !$currentCategory ? 'text-white' : 'text-gray-400' }} transition">Todas las Categorías</span>
                                    <span class="text-[10px] font-black text-gray-500 bg-white/5 px-2 py-0.5 rounded-md">{{ App\Models\Product::count() }}</span>
                                </div>
                            </div>
                        </a>

                        @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="flex items-center gap-3 p-3 rounded-xl transition-all mb-1 {{ $currentCategory == $category->slug ? 'bg-gradient-to-r from-[#FF2121]/20 to-[#F51B1B]/10 border border-[#FF2121]/30' : 'hover:bg-white/[0.03] border border-transparent' }}">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center">
                                <i class="fas {{ $category->icon ?? ($category->slug == 'plugins' ? 'fa-plug' : ($category->slug == 'temas' ? 'fa-palette' : 'fa-folder')) }} text-[#FF2121] text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold {{ $currentCategory == $category->slug ? 'text-white' : 'text-gray-400' }} transition">{{ $category->name }}</span>
                                    <span class="text-[10px] font-black text-gray-500 bg-white/5 px-2 py-0.5 rounded-md">{{ $category->products_count ?? 0 }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Top Popular -->
                <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-white/[0.06]">
                        <h4 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-fire text-amber-400 text-xs"></i>
                            {{ $sidebarTitle }}
                        </h4>
                    </div>
                    <div class="p-3">
                        @foreach($sidebarProducts as $index => $topProduct)
                        <a href="{{ route('products.show', $topProduct->slug) }}" class="flex items-center gap-3 group cursor-pointer p-2 rounded-xl hover:bg-white/[0.03] transition-all mb-1">
                            <div class="relative w-12 h-12 rounded-lg flex-shrink-0 overflow-hidden bg-gradient-to-br from-gray-800 to-gray-900 border border-white/10">
                                @if($topProduct->thumbnail)
                                    <img src="{{ asset('storage/' . $topProduct->thumbnail) }}" alt="{{ $topProduct->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas {{ $topProduct->type === 'theme' ? 'fa-palette' : 'fa-plug' }} text-gray-600 text-xs"></i>
                                    </div>
                                @endif
                                <div class="absolute top-0 left-0 w-5 h-5 bg-gradient-to-br from-amber-500 to-orange-500 rounded-br-lg flex items-center justify-center">
                                    <span class="text-[9px] font-black text-white">{{ $index + 1 }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="text-sm font-bold text-white truncate group-hover:text-[#FF2121] transition leading-tight">{{ $topProduct->name }}</h5>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] text-gray-500">{{ $topProduct->category->name ?? 'General' }}</span>
                                    @if($topProduct->price > 0)
                                        <span class="text-[10px] text-emerald-400 font-bold">${{ number_format($topProduct->price, 2) }}</span>
                                    @else
                                        <span class="text-[10px] text-emerald-400 font-bold">GRATIS</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Membership Banner -->
                <div class="bg-gradient-to-br from-[#F51B1B]/20 via-[#F51B1B]/20 to-[#F51B1B]/20 rounded-2xl p-6 border border-[#F51B1B]/30 relative overflow-hidden group cursor-pointer hover:scale-[1.02] transition-transform duration-300" onclick="window.location.href='{{ route('home') }}#planes'">
                <div class="absolute inset-0 bg-gradient-to-r from-[#FF2121]/10 to-[#F51B1B]/10 animate-pulse"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#FF2121] to-[#F51B1B] flex items-center justify-center mb-4 shadow-lg shadow-[#F51B1B]/20">
                        <i class="fas fa-crown text-white text-xl"></i>
                    </div>
                    <h5 class="text-base font-black text-white mb-2">¡Hazte Premium!</h5>
                    <p class="text-xs text-gray-400 leading-relaxed mb-4">Acceso ilimitado a todos los productos, descargas directas y soporte prioritario.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-[#F51B1B] font-black">Desde $6.99/mes</span>
                        <i class="fas fa-arrow-right text-[#F51B1B] group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <section class="flex-1" id="catalogo-productos">
            <!-- Active Filters -->
            @php
                $requestCategory = request('category');
                $routeCategory = request()->route('category');
                if (is_object($requestCategory)) {
                    $activeCategorySlug = $requestCategory->slug;
                } elseif ($requestCategory) {
                    $activeCategorySlug = $requestCategory;
                } elseif (is_object($routeCategory)) {
                    $activeCategorySlug = $routeCategory->slug;
                } else {
                    $activeCategorySlug = null;
                }
            @endphp
            @if($activeCategorySlug || request('search'))
            <div class="flex items-center gap-2 mb-6 flex-wrap">
                <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Filtros activos:</span>
                @if($activeCategorySlug)
                    @php $activeCategory = $categories->firstWhere('slug', $activeCategorySlug); @endphp
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-lg text-xs font-bold text-[#FF2121]">
                        {{ $activeCategory->name ?? ucfirst($activeCategorySlug) }}
                        <a href="{{ route('products.index') }}" class="hover:text-white"><i class="fas fa-times"></i></a>
                    </span>
                @endif
                @if(request('search'))
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-lg text-xs font-bold text-[#FF2121]">
                        "{{ request('search') }}"
                        <a href="{{ route('products.index', request()->except('search')) }}" class="hover:text-white"><i class="fas fa-times"></i></a>
                    </span>
                @endif
            </div>
            @endif

            <!-- Membership Promo Banner -->
            <a href="{{ route('home') }}#planes" class="block w-full mb-6 px-4 py-3 bg-gradient-to-r from-amber-500/10 via-yellow-500/10 to-amber-500/10 border border-amber-500/20 rounded-2xl hover:border-amber-500/40 transition-all group">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                            <i class="fas fa-crown text-amber-400 text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-black text-white truncate">Acceso ilimitado a todos los productos</p>
                            <p class="text-xs text-gray-400 truncate">Desde $6.99/mes · Descargas sin límites · Updates incluidos</p>
                        </div>
                    </div>
                    <span class="shrink-0 px-4 py-2 bg-amber-500 hover:bg-amber-400 text-black text-xs font-black uppercase tracking-wider rounded-xl transition-colors">
                        Ver Membresías <i class="fas fa-arrow-right ml-1"></i>
                    </span>
                </div>
            </a>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @forelse($products as $index => $product)
                <div class="group bg-[#0a0a0a] rounded-2xl overflow-hidden border border-white/[0.06] hover:border-[#FF2121]/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#FF2121]/5">
                    <!-- Image -->
                    <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-[#FF2121]/30 to-[#F51B1B]/20">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                 alt="{{ $product->name }}" 
                                 loading="{{ $index < 6 ? 'eager' : 'lazy' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas {{ $product->type === 'theme' ? 'fa-palette' : 'fa-plug' }} text-6xl text-white/20"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-gray-900/90 backdrop-blur-md border border-white/20 rounded-lg text-[9px] font-black uppercase tracking-wider text-white shadow-md">
                                {{ $product->type }}
                            </span>
                            @if($product->badge)
                                @php
                                    $badgeBg = match($product->badge) {
                                        'Más Vendido' => 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-500/30 border-amber-300/40',
                                        'Trending' => 'bg-gradient-to-r from-rose-500 to-pink-600 shadow-rose-500/30 border-rose-400/40',
                                        'Popular' => 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-blue-500/30 border-blue-400/40',
                                        default => 'bg-gradient-to-r from-[#FF2121] to-[#F51B1B] shadow-[#FF2121]/40 border-red-400/40',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 {{ $badgeBg }} text-white rounded-lg text-[9px] font-black uppercase tracking-wider shadow-lg border">
                                    {{ $product->badge }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Hover overlay -->
                        <div class="absolute inset-0 bg-[#F51B1B]/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    
                    <!-- Content -->
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-500/10 border border-emerald-500/20 rounded text-emerald-400 text-[9px] font-bold">
                                <i class="fas fa-code-branch text-[7px]"></i>
                                v{{ $product->version }}
                            </span>
                            @if($product->updated_at->gt(now()->subHours(48)))
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded text-[#FF2121] text-[9px] font-bold">
                                    <i class="fas fa-sync-alt text-[7px]"></i>
                                    Actualizado
                                </span>
                            @endif
                        </div>
                        
                        <a href="{{ route('products.show', $product->slug) }}">
                            <h3 class="text-base font-bold text-white mb-2 line-clamp-1 group-hover:text-[#FF2121] transition-colors">{{ $product->name }}</h3>
                        </a>
                        
                        <p class="text-xs text-gray-500 mb-4 line-clamp-2 leading-relaxed">{{ $product->short_description ?? 'Producto premium de alta calidad para WordPress' }}</p>
                        
                        <!-- Meta -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-white/[0.06]">
                            <div class="flex items-center gap-3 text-[10px] text-gray-500 font-bold">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-star text-amber-400 text-[8px]"></i>
                                    {{ $product->rating ?: '5.0' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-download text-[8px]"></i>
                                    {{ number_format($product->downloads_count ?? 0) }}
                                </span>
                            </div>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ $product->category->name ?? 'General' }}</span>
                        </div>
                        
                        <!-- Price & Action -->
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                @if($product->price > 0)
                                    <span class="text-xl font-black text-white">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="text-xl font-black text-emerald-400">GRATIS</span>
                                @endif
                            </div>
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2.5 gradient-bg hover:opacity-90 text-white text-xs font-black uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all hover:scale-105 flex items-center gap-2">
                                    <i class="fas fa-cart-plus"></i>
                                    Añadir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-[#0a0a0a] border border-white/[0.06] rounded-2xl">
                    <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-box-open text-4xl text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-2">No se encontraron productos</h3>
                    <p class="text-sm text-gray-500 mb-6">Prueba con otros filtros o términos de búsqueda.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl text-sm">
                        <i class="fas fa-undo"></i> Ver todos los productos
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-12">
                {{ $products->fragment('catalogo-productos')->links() }}
            </div>
            @endif
        </section>
    </div>
</main>
@endsection