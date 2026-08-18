@extends('layouts.frontend')

@php
    $titleTemplate = $globalSettings['product_seo_title_template'] ?? 'Descargar %name% - Premium GPL';
    $descTemplate = $globalSettings['product_seo_desc_template'] ?? 'Descargar %name% - %description%';
    $nameWithVersion = $product->name . ' v' . $product->version;
    $seoTitle = str_replace(['%name%', '%version%'], [$nameWithVersion, $product->version], $titleTemplate);
    $cleanDesc = Str::limit(strip_tags($product->short_description ?? $product->description), 150);
    $seoDesc = str_replace(['%name%', '%description%', '%version%'], [$nameWithVersion, $cleanDesc, $product->version], $descTemplate);
    $metaImage = $product->thumbnail ? asset('storage/' . $product->thumbnail) : asset('images/og-default.jpg');
    $canonicalUrl = route('products.show', $product);
@endphp

@section('meta_title'){{ $seoTitle }}@endsection
@section('meta_description'){{ $seoDesc }}@endsection
@section('meta_image'){{ $metaImage }}@endsection
@section('canonical'){{ $canonicalUrl }}@endsection

@push('schema')
@php
$schemaData = [
    '@context' => 'https://schema.org/',
    '@type' => 'Product',
    'name' => $product->name,
    'image' => [$metaImage],
    'description' => Str::limit(strip_tags($product->description), 160),
    'sku' => (string) $product->id,
    'brand' => [
        '@type' => 'Brand',
        'name' => config('app.name', 'GPLWolf')
    ],
    'offers' => [
        '@type' => 'Offer',
        'url' => route('products.show', $product),
        'priceValidUntil' => date('Y-12-31', strtotime('+1 year')),
        'validFrom' => $product->created_at ? $product->created_at->format('Y-m-d') : date('Y-m-d'),
        'priceCurrency' => 'USD',
        'price' => (string) $product->price,
        'availability' => 'https://schema.org/InStock',
        'seller' => ['@type' => 'Organization', 'name' => config('app.name')],
        'shippingDetails' => [
            '@type' => 'OfferShippingDetails',
            'shippingRate' => [
                '@type' => 'MonetaryAmount',
                'value' => '0',
                'currency' => 'USD'
            ],
            'shippingDestination' => [
                '@type' => 'DefinedRegion',
                'addressCountry' => 'US'
            ],
            'deliveryTime' => [
                '@type' => 'ShippingDeliveryTime',
                'handlingTime' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => 0,
                    'maxValue' => 0,
                    'unitCode' => 'DAY'
                ],
                'transitTime' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => 0,
                    'maxValue' => 0,
                    'unitCode' => 'DAY'
                ]
            ]
        ],
        'hasMerchantReturnPolicy' => [
            '@type' => 'MerchantReturnPolicy',
            'applicableCountry' => 'US',
            'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
            'merchantReturnDays' => 30,
            'returnMethod' => 'https://schema.org/ReturnByMail',
            'returnFees' => 'https://schema.org/FreeReturn'
        ]
    ],
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => (string) ($product->rating > 0 ? $product->rating : 5),
        'reviewCount' => (string) ($product->reviews_count > 0 ? $product->reviews_count : 1)
    ]
];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('extra_css')
<style>
    .prose h1, .prose h2, .prose h3, .prose h4 { color: white !important; font-weight: 800; }
    .prose h2 { margin-top: 2rem !important; margin-bottom: 1rem !important; }
    .prose h3 { margin-top: 1.5rem !important; margin-bottom: 0.75rem !important; }
    .prose p { color: #94a3b8 !important; line-height: 1.8; margin-bottom: 1.25rem !important; }
    .prose ul { color: #94a3b8 !important; list-style-type: disc !important; padding-left: 1.25rem !important; margin-bottom: 1.5rem !important; }
    .prose li { color: #94a3b8 !important; margin-bottom: 0.5rem !important; line-height: 1.6; }
    .prose strong { color: white !important; }
    .prose a { color: #FF2121 !important; font-weight: 700; text-decoration: underline; transition: all 0.2s ease; }
    .prose a:hover { color: white !important; }
</style>
@endsection

@section('content')
@php
    $globalPointsEnabled = \App\Models\Setting::where('key', 'points_enabled')->value('value');
    $pointsPerCurrency = (int) (\App\Models\Setting::where('key', 'points_per_currency')->value('value') ?? 1);
    $potentialPoints = 0;
    $isBonus = false;
    $multiplier = 1.0;
    if ($globalPointsEnabled && $product->price > 0) {
        if ($product->reward_points > 0) {
            $potentialPoints = $product->reward_points;
        } else {
            $multiplier = (float) ($product->points_multiplier ?? 1.0);
            $potentialPoints = floor($product->price * $pointsPerCurrency * $multiplier);
            $isBonus = ($multiplier > 1.0);
        }
    }
@endphp

<!-- Hero Section -->
<header class="relative pt-10 pb-16 lg:pt-16 lg:pb-24 overflow-hidden bg-[#080808]">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#FF2121]/5 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#FF2121]/5 blur-[100px] rounded-full pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-6">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white transition">Inicio</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <a href="{{ route('products.index') }}" class="hover:text-white transition">Productos</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-gray-400 truncate max-w-[200px]">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">
            <!-- Product Image -->
            <div class="relative order-1 lg:order-1">
                <div class="relative bg-[#0a0a0a] rounded-3xl border border-white/[0.06] overflow-hidden shadow-2xl shadow-black/30 aspect-[4/3] group">
                    @if($product->thumbnail)
                        <img src="{{ \Illuminate\Support\Str::startsWith($product->thumbnail, ['ui/', 'http']) ? asset($product->thumbnail) : asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-8xl">
                            {{ $product->type === 'theme' ? '🎨' : '⚡' }}
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a]/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    @if($product->badge || $product->is_recently_updated)
                        <div class="absolute top-4 left-4 flex items-center gap-2 flex-wrap z-10">
                            @if($product->badge)
                                @php
                                    $badgeColor = match($product->badge) {
                                        'Más Vendido' => 'bg-amber-500',
                                        'Trending' => 'bg-rose-500',
                                        'Popular' => 'bg-[#FF2121]',
                                        'Nuevo' => 'bg-emerald-500',
                                        default => 'bg-gray-600',
                                    };
                                @endphp
                                <span class="{{ $badgeColor }} text-white text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg shadow-lg">
                                    {{ $product->badge }}
                                </span>
                            @endif
                            @if($product->is_recently_updated)
                                <x-badge-updated size="md" />
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="order-2 lg:order-2 space-y-6">
                <div class="flex items-center gap-3 flex-wrap">
                    <a href="{{ route('categories.show', $product->category->slug) }}" class="px-3 py-1 bg-[#FF2121]/10 text-[#FF2121] text-[10px] font-black uppercase tracking-widest rounded-lg border border-[#FF2121]/20 hover:bg-[#FF2121]/20 transition">
                        {{ $product->category->name ?? 'Recurso' }}
                    </a>
                    <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-lg border border-emerald-500/20">
                        <i class="fas fa-code-branch text-[8px] mr-1"></i> v{{ $product->version }}
                    </span>
                    @if($product->is_recently_updated)
                        <x-badge-updated size="md" />
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ $product->name }}
                </h1>

                <p class="text-base md:text-lg text-gray-400 leading-relaxed max-w-xl">
                    {{ $product->short_description ?? $product->description }}
                </p>

                <!-- Price & Actions -->
                <div class="flex flex-wrap items-center gap-6 pt-2">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Precio</span>
                        <div class="text-3xl font-black text-white">
                            @if($product->price == 0)
                                <span class="text-emerald-400">GRATIS</span>
                            @elseif($product->sale_price && $product->sale_price < $product->price)
                                <div class="flex items-center gap-2 leading-none">
                                    <span class="text-sm text-rose-400 line-through decoration-rose-500 font-bold opacity-70">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-emerald-400">${{ number_format($product->sale_price, 2) }}</span>
                                </div>
                            @else
                                <span>${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                    </div>

                    @if(isset($potentialPoints) && $potentialPoints > 0)
                        <div class="h-10 w-px bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Puntos</span>
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-black text-white flex items-center gap-1">
                                    <i class="fas fa-coins text-amber-400 text-sm"></i> +{{ $potentialPoints }}
                                </span>
                                @if(isset($isBonus) && $isBonus)
                                    <span class="bg-amber-500 text-[8px] font-black text-black px-1.5 py-0.5 rounded uppercase">
                                        x{{ $multiplier ?? 1 }} Bonus
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="h-10 w-px bg-white/10 hidden sm:block"></div>

                    <div class="flex-1 sm:flex-none">
                        @auth
                            @if(auth()->user()->canDownload($product))
                                <a href="{{ route('product.download', $product) }}" class="w-full sm:w-auto px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-sm rounded-xl transition-all shadow-lg shadow-emerald-600/30 uppercase tracking-wider flex items-center justify-center gap-2">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            @else
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 gradient-bg text-white font-black text-sm rounded-xl hover:opacity-90 transition-all shadow-lg shadow-[#F51B1B]/30 uppercase tracking-wider flex items-center justify-center gap-2">
                                        <i class="fas fa-shopping-cart"></i> Obtener
                                    </button>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 gradient-bg text-white font-black text-sm rounded-xl hover:opacity-90 transition-all shadow-lg shadow-[#F51B1B]/30 uppercase tracking-wider flex items-center justify-center gap-2">
                                    <i class="fas fa-shopping-cart"></i> Obtener
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>

                <!-- Update Request -->
                @auth
                    <div class="pt-2">
                        @if(isset($hasRequestedUpdate) && $hasRequestedUpdate)
                            <div class="bg-emerald-500/10 border border-emerald-500/20 p-4 rounded-xl flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-sm">Solicitud Enviada</h4>
                                    <p class="text-emerald-400/80 text-xs">Te avisaremos cuando haya una nueva versión.</p>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('product.request-update', $product) }}" method="POST" class="bg-[#0a0a0a] border border-white/[0.06] p-4 rounded-xl flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                                @csrf
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                                        <i class="fas fa-sync-alt text-xs"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-bold text-sm">¿Necesitas una nueva versión?</h4>
                                        <p class="text-gray-500 text-xs">Solicita un update y lo procesamos rápido.</p>
                                    </div>
                                </div>
                                <button type="submit" class="px-4 py-2 bg-[#F51B1B] hover:bg-[#FF2121] text-white text-xs font-black uppercase rounded-lg transition-colors">
                                    Solicitar
                                </button>
                            </form>
                        @endif
                    </div>
                @endauth

                <!-- Mini Info -->
                <div class="flex flex-wrap items-center gap-4 text-[10px] font-black text-gray-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5"><i class="fas fa-file-archive text-gray-600"></i> {{ $product->formatted_size }}</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-download text-gray-600"></i> {{ number_format($product->downloads_count) }} descargas</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-shield-alt text-gray-600"></i> GPL Licenciado</span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="py-16 lg:py-20 bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Description -->
            <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6 md:p-8">
                <h2 class="text-xl font-black text-white mb-6 flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#FF2121]/10 rounded-xl flex items-center justify-center border border-[#FF2121]/20">
                        <i class="fas fa-align-left text-[#FF2121] text-xs"></i>
                    </div>
                    Descripción del Producto
                </h2>
                
                <div class="relative" x-data="{ expanded: false }">
                    <div class="prose prose-invert max-w-none text-gray-400 transition-all duration-500 overflow-hidden" :class="{ 'max-h-[260px]': !expanded, 'max-h-[5000px]': expanded }" style="position: relative;">
                        {!! $product->full_description !!}
                        @if(strlen($product->full_description) > 500)
                            <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-[#111111] to-transparent flex items-end justify-center pb-0 transition-opacity duration-300" x-show="!expanded"></div>
                        @endif
                    </div>

                    @if(strlen($product->full_description) > 500)
                    <div class="flex justify-center mt-4">
                        <button @click="expanded = !expanded" class="px-5 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs font-black text-white transition-all flex items-center gap-2">
                            <span x-text="expanded ? 'Leer menos' : 'Leer descripción completa'"></span>
                            <i class="fas" :class="{ 'fa-chevron-up': expanded, 'fa-chevron-down': !expanded }"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>



            <!-- También te puede interesar -->
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6 md:p-8">
                <h3 class="text-xl font-black text-white mb-6 flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#FF2121]/10 rounded-xl flex items-center justify-center border border-[#FF2121]/20">
                        <i class="fas fa-layer-group text-[#FF2121] text-xs"></i>
                    </div>
                    También te puede interesar
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($relatedProducts->take(3) as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="group bg-[#0a0a0a] rounded-2xl overflow-hidden border border-white/[0.06] hover:border-[#FF2121]/30 transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-[#FF2121]/5 flex flex-col justify-between">
                        <div>
                            <div class="aspect-video overflow-hidden bg-gradient-to-br from-[#FF2121]/30 to-[#F51B1B]/20 relative">
                                @if($related->thumbnail)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($related->thumbnail, ['ui/', 'http']) ? asset($related->thumbnail) : asset('storage/' . $related->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy" alt="{{ $related->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl">
                                        {{ $related->type === 'theme' ? '🎨' : '⚡' }}
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="text-sm font-bold text-white mb-1.5 group-hover:text-[#FF2121] transition-colors line-clamp-1">{{ $related->name }}</h4>
                                <span class="text-[10px] font-black uppercase text-gray-500 bg-white/5 px-2 py-0.5 rounded border border-white/5">{{ $related->type }}</span>
                            </div>
                        </div>
                        <div class="px-4 pb-4 pt-3 flex justify-between items-center border-t border-white/5 mt-2">
                            <span class="text-[#FF2121] font-black text-sm font-mono">${{ number_format($related->price, 2) }}</span>
                            <span class="text-[9px] font-black uppercase text-gray-400 group-hover:text-white transition">Ver <i class="fas fa-arrow-right ml-0.5 group-hover:translate-x-0.5 transition-transform"></i></span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Version History -->
            @if($product->versions->count() > 0)
            <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6 md:p-8">
                <h2 class="text-xl font-black text-white mb-6 flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#FF2121]/10 rounded-xl flex items-center justify-center border border-[#FF2121]/20">
                        <i class="fas fa-history text-[#FF2121] text-xs"></i>
                    </div>
                    Historial de Versiones
                </h2>
                
                <div class="space-y-3">
                    @foreach($product->versions->take(5) as $version)
                        <div class="flex items-center justify-between p-4 bg-[#0a0a0a] rounded-xl border border-white/[0.04] hover:border-white/10 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#FF2121]/10 rounded-lg flex items-center justify-center text-[#FF2121] font-mono font-bold text-xs border border-[#FF2121]/20">
                                    v{{ $version->version_number }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white">Versión {{ $version->version_number }}</div>
                                    <div class="text-xs text-gray-500">{{ $version->released_at->format('d M, Y') }}</div>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $version->file_path) }}" class="w-9 h-9 bg-white/5 hover:bg-[#F51B1B] border border-white/10 rounded-lg text-gray-400 hover:text-white transition-all flex items-center justify-center" download>
                                <i class="fas fa-download text-xs"></i>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if($product->versions->count() > 5)
                    <div class="flex justify-center mt-4">
                        <p class="text-[10px] font-bold text-gray-600 uppercase tracking-wider bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
                            Mostrando las últimas 5 versiones
                        </p>
                    </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Popular Products -->
            @if($popularProducts->count() > 0)
            <div class="relative overflow-hidden rounded-3xl border border-white/[0.08] bg-gradient-to-b from-[#111111] to-[#0a0a0a] shadow-2xl shadow-black/40">
                <div class="absolute inset-x-0 top-0 h-px animated-line"></div>

                <!-- Header -->
                <div class="p-6 pb-5 border-b border-white/[0.06]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="absolute inset-0 bg-rose-500/30 blur-lg rounded-full"></div>
                                <div class="relative w-9 h-9 bg-gradient-to-br from-rose-500 to-orange-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-rose-500/25">
                                    <i class="fas fa-fire text-xs"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-white uppercase tracking-widest">Top Populares</h4>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">Los más descargados</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest bg-rose-500/10 border border-rose-500/20 px-2 py-1 rounded-lg">Top 5</span>
                    </div>
                </div>

                <!-- List -->
                <div class="p-2">
                    @foreach($popularProducts as $index => $popular)
                    <a href="{{ route('products.show', $popular->slug) }}" class="group flex items-center gap-4 p-3 rounded-2xl hover:bg-white/[0.04] transition-all duration-300 relative">
                        <!-- Rank -->
                        <div class="relative flex-shrink-0">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gradient-to-br from-[#FF2121]/40 to-[#F51B1B]/30 border border-white/[0.08] group-hover:border-white/20 group-hover:shadow-lg group-hover:shadow-[#FF2121]/10 transition-all duration-300">
                                @if($popular->thumbnail)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($popular->thumbnail, ['ui/', 'http']) ? asset($popular->thumbnail) : asset('storage/' . $popular->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy" alt="{{ $popular->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl">
                                        {{ $popular->type === 'theme' ? '🎨' : '⚡' }}
                                    </div>
                                @endif
                            </div>
                            <div class="absolute -top-1.5 -left-1.5 w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-black text-white border-2 shadow-lg
                                {{ $index === 0 ? 'bg-gradient-to-br from-amber-400 to-yellow-500 border-[#0c111f] shadow-amber-500/30' : ($index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-400 border-[#0c111f] shadow-gray-400/20' : ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600 border-[#0c111f] shadow-orange-500/20' : 'bg-[#1a2235] border-[#0c111f] text-gray-400')) }}">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <h5 class="text-sm font-bold text-white group-hover:text-[#FF2121] transition-colors line-clamp-1 leading-tight">{{ $popular->name }}</h5>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="text-[#FF2121] font-black text-sm">${{ number_format($popular->price, 2) }}</span>
                                <span class="text-[10px] text-gray-600 font-black">•</span>
                                <span class="text-[10px] text-gray-500 font-black uppercase tracking-wider"><i class="fas fa-download mr-1 text-gray-600"></i>{{ number_format($popular->downloads_count) }}</span>
                            </div>
                        </div>

                        <!-- Arrow -->
                        <div class="w-8 h-8 rounded-full border border-white/[0.08] flex items-center justify-center text-gray-600 group-hover:text-white group-hover:border-[#FF2121]/50 group-hover:bg-[#FF2121]/10 transition-all duration-300 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-white/[0.06] bg-white/[0.02]">
                    <a href="{{ route('products.index') }}" class="flex items-center justify-center gap-2 text-[11px] font-black text-gray-400 uppercase tracking-widest hover:text-white transition-colors group">
                        Ver todos los productos
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            @endif

            <!-- Membership Banner -->
            <a href="{{ route('membership.pricing') }}" class="block bg-gradient-to-br from-amber-500/10 to-yellow-500/10 border border-amber-500/20 rounded-2xl p-6 hover:border-amber-500/40 transition-all group">
                <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-crown text-amber-400 text-xl"></i>
                </div>
                <h4 class="text-white font-black mb-2">Hazte Premium</h4>
                <p class="text-gray-400 text-xs mb-4">Acceso ilimitado a todos los productos.</p>
                <div class="flex items-center justify-between">
                    <span class="text-amber-400 text-sm font-black">Desde $6.99/mes</span>
                    <i class="fas fa-arrow-right text-amber-400 text-sm group-hover:translate-x-1 transition-transform"></i>
                </div>
            </a>
        </div>
    </div>
</main>



<!-- Mobile Bottom Bar -->
<div class="fixed bottom-4 left-4 right-4 z-50 lg:hidden">
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl p-4 shadow-2xl shadow-black/80 flex items-center gap-4">
        <div class="flex flex-col min-w-[80px]">
            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-none mb-1">Total</span>
            <div class="text-xl font-black text-white leading-none">${{ number_format($product->price, 2) }}</div>
        </div>
        <div class="flex-1">
            @auth
                @if(auth()->user()->canDownload($product))
                    <a href="{{ route('product.download', $product) }}" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-sm rounded-xl transition-all shadow-lg uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Descargar
                    </a>
                @else
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3.5 gradient-bg text-white font-black text-sm rounded-xl hover:opacity-90 transition-all shadow-lg uppercase tracking-wider flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-cart"></i> Obtener
                        </button>
                    </form>
                @endif
            @else
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3.5 gradient-bg text-white font-black text-sm rounded-xl hover:opacity-90 transition-all shadow-lg uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-cart"></i> Obtener
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>
<div class="h-24 lg:hidden"></div>
@endsection