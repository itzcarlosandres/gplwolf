<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow"> 
    
    <!-- Performance Hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Dynamic Favicon -->
    @if(isset($globalSettings['site_favicon']))
        <link rel="icon" href="{{ \Illuminate\Support\Str::startsWith($globalSettings['site_favicon'], 'ui/') ? asset($globalSettings['site_favicon']) : asset('storage/' . $globalSettings['site_favicon']) }}">
    @endif

    <title>@yield('meta_title', $globalSettings['home_meta_title'] ?? ($globalSettings['site_name'] ?? 'WP Marketplace'))</title>
    <meta name="description" content="@yield('meta_description', $globalSettings['home_meta_description'] ?? 'Descarga los mejores Themes y Plugins Premium para WordPress.')">
    <meta name="keywords" content="@yield('meta_keywords', $globalSettings['home_meta_keywords'] ?? '')">
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $globalSettings['site_name'] ?? 'WP Marketplace' }}">
    <meta property="og:title" content="@yield('meta_title', $globalSettings['home_meta_title'] ?? ($globalSettings['site_name'] ?? 'WP Marketplace'))">
    <meta property="og:description" content="@yield('meta_description', $globalSettings['home_meta_description'] ?? 'Themes y Plugins Premium para WordPress.')">
    <meta property="og:image" content="@yield('meta_image', isset($globalSettings['site_og_image']) ? (\Illuminate\Support\Str::startsWith($globalSettings['site_og_image'], 'ui/') ? asset($globalSettings['site_og_image']) : asset('storage/' . $globalSettings['site_og_image'])) : asset('images/og-default.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('meta_title', $globalSettings['home_meta_title'] ?? ($globalSettings['site_name'] ?? 'WP Marketplace'))">
    <meta property="twitter:description" content="@yield('meta_description', $globalSettings['home_meta_description'] ?? 'Themes y Plugins Premium para WordPress.')">
    <meta property="twitter:image" content="@yield('meta_image', isset($globalSettings['site_og_image']) ? (\Illuminate\Support\Str::startsWith($globalSettings['site_og_image'], 'ui/') ? asset($globalSettings['site_og_image']) : asset('storage/' . $globalSettings['site_og_image'])) : asset('images/og-default.jpg'))">
    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    
    <!-- Non-Blocking Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ 'https://fonts.googleapis.com/css2?family=' . str_replace(' ', '+', $globalSettings['site_font'] ?? 'Outfit') . ':wght@300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="{{ 'https://fonts.googleapis.com/css2?family=' . str_replace(' ', '+', $globalSettings['site_font'] ?? 'Outfit') . ':wght@300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    </noscript>

    <style>
        /* Removed @import to prevent blocking */
        
        html {
            scroll-behavior: smooth;
        }
    </style>
    
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
                        blue: { 500: '#FF2121', 600: '#F51B1B' }
                    }
                }
            }
        }
    </script>
        
    </script>

    <style>
        body {
            font-family: '{{ $globalSettings['site_font'] ?? 'Outfit' }}', sans-serif;
            /* background-color removed to use Tailwind class */
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%);
        }

        .glass {
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes text-shine-sweep {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .text-shimmer-red-yellow {
            background: linear-gradient(90deg, #FF2121 0%, #f59e0b 50%, #FF2121 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: text-shine-sweep 3s linear infinite;
            display: inline-block;
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 33, 33, 0.2);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes footer-logo-shine {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        @keyframes footer-logo-pulse {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 33, 33, 0.25), 0 0 40px rgba(255, 33, 33, 0.15); transform: scale(1); }
            50% { box-shadow: 0 0 30px rgba(255, 33, 33, 0.4), 0 0 60px rgba(255, 33, 33, 0.25); transform: scale(1.03); }
        }

        .gradient-text {
            background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Animated horizontal line */
        .animated-line {
            background: linear-gradient(90deg, transparent 0%, rgba(255, 33, 33, 0.1) 35%, rgba(255, 33, 33, 0.6) 50%, rgba(255, 33, 33, 0.1) 65%, transparent 100%);
            background-size: 200% 100%;
            animation: line-slide 3s linear infinite;
        }

        @keyframes text-shine-sweep {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .text-shimmer-white {
            background: linear-gradient(90deg, #f59e0b 0%, #ffffff 45%, #ffffff 55%, #f59e0b 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: text-shine-sweep 3.5s ease-in-out infinite;
        }

        @keyframes line-slide {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }

        /* Animated recommended badge */
        .animated-badge {
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }
        .animated-badge::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.35) 50%, transparent 100%);
            background-size: 200% 100%;
            animation: badge-shine 2.5s ease-in-out infinite;
        }

        @keyframes badge-shine {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }

        /* Fusion Pro Design System - Optimized */
        .card-fusion {
            background: #0a0a0a;
            border-radius: 35px;
            position: relative;
            padding: 2px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
            height: 317px; /* Altura solicitada */
        }
        .card-fusion::before {
            content: '';
            position: absolute;
            inset: -100%;
            background: conic-gradient(from 0deg, transparent, #FF2121, #F51B1B, #FF2121, transparent);
            animation: rotate_border 6s linear infinite;
        }
        @keyframes rotate_border {
            to { transform: rotate(360deg); }
        }
        .card-fusion:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(255, 33, 33, 0.15);
        }
        .card-fusion-inner {
            background: #0a0a0a;
            border-radius: 33px;
            padding: 20px;
            height: 100%;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .img-fusion {
            background: linear-gradient(135deg, rgba(255, 33, 33, 0.05) 0%, rgba(245, 27, 27, 0.05) 100%);
            border-radius: 24px;
            height: 140px;
            position: relative;
            border: 1px solid rgba(255,255,255,0.03);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        .fusion-bubble {
            position: absolute;
            border-radius: 50%;
            filter: blur(15px);
            opacity: 0.3;
            animation: float-bubble 4s ease-in-out infinite;
        }
        @keyframes float-bubble {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(8px, -12px); }
        }
        @keyframes cart-pop {
            0% { transform: scale(1); }
            40% { transform: scale(1.4) rotate(-10deg); box-shadow: 0 0 20px rgba(255, 33, 33, 0.6); }
            60% { transform: scale(1.1) rotate(5deg); }
            80% { transform: scale(1.2) rotate(-3deg); }
            100% { transform: scale(1); }
        }
        .animate-cart-pop {
            animation: cart-pop 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
        }

        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0d0d0d;
        }
        ::-webkit-scrollbar-thumb {
            background: #1a1a1a;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #312e81;
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Neon Pulse Styles */
        .neon-card {
            background: #0d0d0d;
            border-radius: 40px;
            position: relative;
            z-index: 1;
        }

        .neon-border {
            position: absolute;
            inset: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .neon-border rect {
            fill: none;
            stroke: #FF2121;
            stroke-width: 2;
            rx: 40;
            stroke-dasharray: 400;
            stroke-dashoffset: 400;
            transition: all 0.6s ease;
        }

        .neon-card:hover .neon-border rect {
            stroke-dashoffset: 0;
            stroke: #F51B1B;
            filter: drop-shadow(0 0 8px #F51B1B);
        }

        .pulsing-dot {
            width: 8px;
            height: 8px;
            background: #FF2121;
            border-radius: 50%;
            position: relative;
        }

        .pulsing-dot::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: #FF2121;
            opacity: 0.4;
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(3); opacity: 0; }
        }

        .price-big {
            line-height: 1;
            font-weight: 900;
            background: linear-gradient(to bottom, #fff, #444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-neon {
            background: #111;
            border: 1px solid #333;
            transition: all 0.4s;
        }

        .btn-neon:hover {
            border-color: #FF2121;
            color: #FF2121;
            box-shadow: 0 0 20px rgba(255, 33, 33, 0.2);
        }

        .featured-neon {
            background: #111;
            border: 2px solid #FF2121;
            box-shadow: 0 0 30px rgba(255, 33, 33, 0.1);
        }

        /* Bento Grid */
        .bento-card { background: #0d1425; border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.4s ease; }
        .bento-card:hover { border-color: rgba(255, 33, 33, 0.3); box-shadow: 0 10px 30px -5px rgba(255, 33, 33, 0.15); }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>
    <style>
        /* Performance Opts */
        body { text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @yield('extra_css')
    <!-- Custom Header Code -->
    {!! $globalSettings['site_header_code'] ?? '' !!}
</head>
<body class="bg-[#050505] text-gray-300 antialiased overflow-x-hidden selection:bg-[#FF2121]/30 selection:text-white" x-data="{ mobileMenu: false, mobileSearch: false, topbarClosed: localStorage.getItem('topbar_closed') === 'true' }">
    
    @php
        $topbarEnabled = \App\Models\Setting::where('key', 'topbar_enabled')->value('value') ?? '0';
        $topbarText = \App\Models\Setting::where('key', 'topbar_text')->value('value') ?? '';
        $topbarLink = \App\Models\Setting::where('key', 'topbar_link')->value('value') ?? '';
        $topbarLinkText = \App\Models\Setting::where('key', 'topbar_link_text')->value('value') ?? '';
        $topbarBgColor = \App\Models\Setting::where('key', 'topbar_bg_color')->value('value') ?? '#FF2121';
    @endphp

    <!-- Toast Notifications Container -->
    <div id="notification-container" class="fixed top-8 right-8 z-[9999] space-y-4 max-w-md pointer-events-none"></div>

    <!-- Top Bar Promocional -->
    @if($topbarEnabled == '1')
    <div x-show="!topbarClosed" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="-translate-y-full"
         class="relative z-50 py-3 text-white text-center overflow-hidden"
         style="background: linear-gradient(135deg, {{ $topbarBgColor }} 0%, {{ $topbarBgColor }}dd 100%);">
        
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 flex items-center justify-between gap-4">
            <div class="flex-1 flex items-center justify-center gap-3">
                <span class="text-sm font-bold tracking-wide">{{ $topbarText }}</span>
                @if($topbarLink && $topbarLinkText)
                <a href="{{ $topbarLink }}" class="px-4 py-1.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg text-xs font-black uppercase tracking-widest transition-all hover:scale-105">
                    {{ $topbarLinkText }} →
                </a>
                @endif
            </div>
            
            <!-- Close Button -->
            <button @click="topbarClosed = true; localStorage.setItem('topbar_closed', 'true')" 
                    class="w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-lg transition-all group">
                <i class="fas fa-times text-sm group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Navigation — Command Bar -->
    @php
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
    @endphp
    <nav class="sticky top-0 z-50 bg-[#0a0a0a] border-b border-white/5">
        <div class="mx-4 md:mx-8 lg:mx-12 pt-4 pb-3">
            <!-- Command Bar Capsule -->
            <div class="max-w-5xl mx-auto px-2 py-2 bg-[#111111] border border-white/10 rounded-2xl shadow-2xl shadow-black/40 transition-all duration-500">
            <div class="flex items-center justify-between gap-4 px-2">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-white font-black text-lg tracking-tight shrink-0 group">
                    @if(($globalSettings['site_identity_type'] ?? 'logo') === 'logo' && isset($globalSettings['site_logo']))
                        <img src="{{ \Illuminate\Support\Str::startsWith($globalSettings['site_logo'], 'ui/') ? asset($globalSettings['site_logo']) : asset('storage/' . $globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'WP Marketplace' }}" class="h-8 w-auto hover:scale-105 transition-transform">
                    @else
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center text-sm text-white shadow-lg shadow-[#F51B1B]/40 group-hover:scale-110 transition-transform">
                            <i class="{{ $globalSettings['site_icon'] ?? 'fas fa-store' }}"></i>
                        </div>
                        <span class="hidden sm:block">{{ $globalSettings['site_name'] ?? 'CaletaWP' }}</span>
                    @endif
                </a>

                <!-- Centered Search Bar -->
                <div class="hidden md:block flex-1 max-w-md relative" x-data="{ searchOpen: false, searchQuery: '', searchResults: [], loading: false }" @click.away="searchOpen = false" @keydown.window.prevent.cmd.k="$refs.searchInput.focus()" @keydown.window.prevent.ctrl.k="$refs.searchInput.focus()">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                        <input 
                            x-ref="searchInput"
                            type="text" 
                            x-model="searchQuery"
                            @input.debounce.300ms="
                                if (searchQuery.length >= 2) {
                                    loading = true;
                                    fetch('{{ route('search.live') }}?q=' + encodeURIComponent(searchQuery))
                                        .then(r => r.json())
                                        .then(data => {
                                            searchResults = data;
                                            searchOpen = true;
                                            loading = false;
                                        });
                                } else {
                                    searchResults = [];
                                    searchOpen = false;
                                }
                            "
                            @focus="if(searchQuery.length >= 2) searchOpen = true"
                            placeholder="Buscar themes, plugins..."
                            class="w-full bg-white/5 border border-white/10 rounded-xl pl-9 pr-16 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all"
                        >
                        <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-500 bg-white/5 px-2 py-0.5 rounded-md border border-white/10 cursor-pointer hover:text-white" @click="$refs.searchInput.focus()" x-show="!loading" title="Atajo de teclado: Ctrl + K o Cmd + K">⌘K</span>
                        <svg x-show="loading" class="animate-spin h-4 w-4 text-[#FF2121] absolute right-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    <!-- Results Dropdown -->
                    <div 
                        x-show="searchOpen && searchResults.length > 0"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full mt-2 w-full glass border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                        style="display: none;"
                    >
                        <div class="p-2 space-y-1 max-h-96 overflow-y-auto">
                            <template x-for="product in searchResults" :key="product.id">
                                <a :href="product.url" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all group">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 flex-shrink-0">
                                        <img x-show="product.thumbnail" :src="product.thumbnail" :alt="product.name" class="w-full h-full object-cover">
                                        <div x-show="!product.thumbnail" class="w-full h-full flex items-center justify-center text-white/40">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-white font-bold text-sm truncate group-hover:text-[#FF2121] transition-colors" x-text="product.name"></p>
                                        <p class="text-gray-500 text-xs" x-text="product.type"></p>
                                    </div>
                                    <div class="text-[#FF2121] font-black text-sm">
                                        $<span x-text="product.price"></span>
                                    </div>
                                </a>
                            </template>
                        </div>
                        <div class="border-t border-white/10 p-3 bg-white/5">
                            <a :href="'{{ route('search.index') }}?q=' + encodeURIComponent(searchQuery)" class="text-[#FF2121] text-sm font-bold hover:text-[#FF2121] transition-colors flex items-center justify-center gap-2">
                                Ver todos los resultados
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <!-- No Results -->
                    <div 
                        x-show="searchOpen && searchQuery.length >= 2 && searchResults.length === 0 && !loading"
                        x-transition
                        class="absolute top-full mt-2 w-full glass border border-white/10 rounded-2xl shadow-2xl p-6 text-center z-50"
                        style="display: none;"
                    >
                        <i class="fas fa-search text-4xl text-gray-600 mb-3"></i>
                        <p class="text-gray-400 text-sm">No se encontraron resultados</p>
                    </div>
                </div>

                <!-- Nav Links with Neutral Icons -->
                <div class="hidden lg:flex items-center gap-1.5">
                    <a href="{{ route('products.index') }}" class="group flex items-center px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition-all rounded-xl hover:bg-white/5 {{ request()->routeIs('products.index') ? 'text-white bg-white/5' : '' }}">
                        <i class="fas fa-cubes text-[11px] mr-1.5 text-gray-500 group-hover:text-gray-200 transition-colors"></i>
                        Productos
                    </a>
                    <a href="{{ route('updates.index') }}" class="group flex items-center px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition-all rounded-xl hover:bg-white/5 {{ request()->routeIs('updates.index') ? 'text-white bg-white/5' : '' }}">
                        <i class="fas fa-bolt text-[11px] mr-1.5 text-gray-500 group-hover:text-gray-200 transition-colors"></i>
                        Novedades
                    </a>
                    <a href="{{ route('membership.pricing') }}" class="group flex items-center px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition-all rounded-xl hover:bg-white/5 {{ request()->routeIs('membership.pricing') ? 'text-white bg-white/5' : '' }}">
                        <i class="fas fa-crown text-[11px] mr-1.5 text-gray-500 group-hover:text-gray-200 transition-colors"></i>
                        Planes
                    </a>
                    <a href="{{ route('user.support.index') }}" class="group flex items-center px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition-all rounded-xl hover:bg-white/5 {{ request()->routeIs('user.support.index') ? 'text-white bg-white/5' : '' }}">
                        <i class="fas fa-headset text-[11px] mr-1.5 text-gray-500 group-hover:text-gray-200 transition-colors"></i>
                        Soporte
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2 shrink-0">
                    <!-- Mobile Search Trigger -->
                    <button @click="mobileSearch = true" class="md:hidden w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white transition">
                        <i class="fas fa-search text-xs"></i>
                    </button>

                    <!-- Carrito con Badge Counter -->
                    @php
                        $cartCount = is_array(session('cart')) ? array_sum(array_column(session('cart'), 'quantity')) : 0;
                    @endphp
                    <a href="{{ route('cart.index') }}" title="Carrito de compras" class="relative flex items-center justify-center w-9 h-9 md:w-10 md:h-10 rounded-xl bg-white/5 border border-white/10 hover:bg-[#FF2121]/10 hover:border-[#FF2121]/30 text-gray-300 hover:text-white transition-all duration-300 group shadow-sm hover:shadow-[0_0_12px_rgba(255,33,33,0.2)]">
                        <i class="fas fa-shopping-cart text-xs md:text-sm text-gray-300 group-hover:text-[#FF2121] transition-colors"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 bg-[#FF2121] text-white text-[9px] font-black rounded-full flex items-center justify-center border-2 border-[#111111] shadow-lg animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="hidden md:flex items-center gap-2 bg-white/5 border border-white/10 pl-1.5 pr-3 py-1.5 rounded-xl hover:bg-white/10 transition-all group">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff&bold=true" class="w-6 h-6 rounded-lg shadow-lg">
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-300 group-hover:text-white">Cuenta</span>
                        </a>
                    @else
                        <!-- Login Soft Pop -->
                        <a href="{{ route('login') }}" class="px-3.5 py-2 bg-[#FF2121]/10 hover:bg-[#FF2121] text-white border border-[#FF2121]/30 hover:border-[#FF2121] rounded-xl text-xs font-bold transition-all duration-300 shadow-sm hover:shadow-[0_0_18px_rgba(255,33,33,0.4)] hover:scale-105 flex items-center gap-1.5 group">
                            <i class="fas fa-sign-in-alt text-xs text-[#FF2121] group-hover:text-white transition-colors"></i>
                            <span>Ingresar</span>
                        </a>

                        <!-- Register / Unirse -->
                        <a href="{{ route('register') }}" class="hidden sm:flex px-4 py-2 gradient-bg rounded-xl text-xs font-black text-white transition hover:scale-105 shadow-lg shadow-[#F51B1B]/20">Unirse</a>
                    @endauth

                    <!-- Mobile Trigger -->
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:text-white transition">
                        <i class="fas fa-bars-staggered" x-show="!mobileMenu"></i>
                        <i class="fas fa-times" x-show="mobileMenu"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Category chips floating below -->
        <div class="max-w-5xl mx-auto mt-3 flex items-center justify-center gap-2 overflow-x-auto no-scrollbar px-4 hidden md:flex">
            <a href="{{ route('products.index') }}" class="shrink-0 px-3 py-1.5 {{ request()->routeIs('products.index') || request()->routeIs('home') ? 'bg-[#F51B1B] text-white border-[#FF2121] shadow-lg shadow-[#F51B1B]/25' : 'bg-[#0a0a0a]/90 text-gray-400 border-white/10 hover:bg-[#0a0a0a] hover:text-white' }} rounded-lg text-[10px] font-black uppercase tracking-widest border transition-all">
                <i class="fas fa-fire text-[8px] mr-1"></i> Todos
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" class="shrink-0 px-3 py-1.5 {{ request()->routeIs('categories.show') && request()->route('category')->slug ?? '' === $cat->slug ? 'bg-[#F51B1B] text-white border-[#FF2121] shadow-lg shadow-[#F51B1B]/25' : 'bg-[#0a0a0a]/90 text-gray-400 border-white/10 hover:bg-[#0a0a0a] hover:text-white' }} rounded-lg text-[10px] font-black uppercase tracking-widest border transition-all">
                    <i class="{{ $cat->icon ?? 'fas fa-tag' }} text-[8px] mr-1"></i> {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden absolute top-full left-0 right-0 mt-3 mx-4 bg-[#0a0a0a]/95 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 space-y-6 shadow-2xl z-[100]">
            
            <!-- Mobile Search -->
            <div class="md:hidden relative" x-data="{ searchQuery: '', searchResults: [], loading: false, searchOpen: false }" @click.away="searchOpen = false">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        @input.debounce.300ms="
                            if (searchQuery.length >= 2) {
                                loading = true;
                                fetch('{{ route('search.live') }}?q=' + encodeURIComponent(searchQuery))
                                    .then(r => r.json())
                                    .then(data => { searchResults = data; searchOpen = true; loading = false; });
                            } else { searchResults = []; searchOpen = false; }
                        "
                        placeholder="Buscar..."
                        class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-2xl text-white text-sm placeholder-gray-500 focus:border-[#FF2121] transition-all pr-12"
                    >
                    <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                </div>
                <div x-show="searchOpen && searchResults.length > 0" class="mt-3 space-y-2" style="display: none;">
                    <template x-for="product in searchResults" :key="product.id">
                        <a :href="product.url" class="flex items-center gap-3 p-3 bg-white/5 rounded-xl">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 flex-shrink-0 overflow-hidden">
                                <img x-show="product.thumbnail" :src="product.thumbnail" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-bold text-sm truncate" x-text="product.name"></p>
                                <span class="text-[#FF2121] font-black text-xs" x-text="'$' + product.price"></span>
                            </div>
                        </a>
                    </template>
                </div>
            </div>

            <!-- Mobile Category Pills -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.index') }}" class="px-3 py-1.5 bg-[#FF2121]/10 text-[#FF2121] border border-[#FF2121]/20 text-[10px] font-black uppercase tracking-widest rounded-lg">
                    <i class="fas fa-fire text-[8px] mr-1"></i> Todos
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" class="px-3 py-1.5 bg-white/5 text-gray-400 border border-white/10 text-[10px] font-black uppercase tracking-widest rounded-lg">
                        <i class="{{ $cat->icon ?? 'fas fa-tag' }} text-[8px] mr-1"></i> {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="h-px bg-white/5"></div>

            <a href="{{ route('updates.index') }}" class="flex items-center gap-4 text-base font-black uppercase tracking-[0.2em] text-gray-400 active:text-white transition-colors group">
                <i class="fas fa-magic text-amber-500/50 group-active:text-amber-500"></i>
                Actualizaciones
            </a>
            <a href="{{ route('membership.pricing') }}" class="flex items-center gap-4 text-base font-black uppercase tracking-[0.2em] {{ request()->routeIs('membership.pricing') ? 'text-white' : 'text-gray-400' }} active:text-white transition-colors group">
                <i class="fas fa-crown text-yellow-500/50 group-active:text-yellow-500"></i>
                Membresías
            </a>
            <a href="{{ route('user.support.index') }}" class="flex items-center gap-4 text-base font-black uppercase tracking-[0.2em] text-gray-400 active:text-white transition-colors group">
                <i class="fas fa-headset text-[#FF2121]/50 group-active:text-[#FF2121]"></i>
                Soporte
            </a>
            <a href="{{ route('cart.index') }}" class="flex items-center justify-between text-base font-black uppercase tracking-[0.2em] text-gray-400 active:text-white transition-colors group">
                <div class="flex items-center gap-4">
                    <i class="fas fa-shopping-cart text-[#FF2121]/50 group-active:text-[#FF2121]"></i>
                    Carrito
                </div>
                @if($cartCount > 0)
                    <span class="px-2.5 py-0.5 bg-[#FF2121] text-white text-[10px] font-black rounded-full shadow-md">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
            
            <div class="h-px bg-white/5"></div>

            @auth
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 text-base font-black uppercase tracking-[0.2em] text-gray-400 active:text-white transition-colors group">
                    <i class="fas fa-user-circle text-[#FF2121]/50 group-active:text-[#FF2121]"></i>
                    Mi Cuenta
                </a>
            @else
                <div class="grid grid-cols-1 gap-4 pt-2">
                    <a href="{{ route('login') }}" class="w-full py-4 bg-white/5 rounded-2xl text-xs font-black uppercase tracking-widest text-white border border-white/10 text-center">Login</a>
                    <a href="{{ route('register') }}" class="w-full py-4 gradient-bg rounded-2xl text-xs font-black uppercase tracking-widest text-white text-center shadow-lg">Unirse ahora</a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
    <div class="max-w-7xl mx-auto px-6 mt-4">
        @if(session('success'))
            <div class="p-4 bg-[#FF2121]/10 border border-[#FF2121]/20 text-[#FF2121] rounded-2xl flex items-center gap-3 animate-slide-in">
                <i class="fas fa-check-circle"></i>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl flex items-center gap-3 animate-slide-in">
                <i class="fas fa-exclamation-circle"></i>
                <span class="text-sm font-bold">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    @endif

    <main id="main-content" class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer — Bento Grid Premium -->
    <footer class="relative bg-[#080808] border-t border-white/[0.06] overflow-hidden">
        <!-- Ambient glows -->
        <div class="absolute top-0 left-0 w-[500px] h-[400px] bg-[#FF2121]/5 rounded-full blur-[150px] pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[400px] h-[300px] bg-amber-500/5 rounded-full blur-[150px] pointer-events-none"></div>
        <div class="absolute top-0 inset-x-0 h-px animated-line"></div>

        <div class="relative max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Brand Card -->
                <div class="md:col-span-2 group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#FF2121]/5 to-[#F51B1B]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-[#FF2121]/20" style="background: linear-gradient(90deg, #FF2121 0%, #F51B1B 25%, #FF2121 50%, #F51B1B 75%, #FF2121 100%); background-size: 200% auto; animation: footer-logo-shine 6s linear infinite, footer-logo-pulse 4s ease-in-out infinite;">
                                    <i class="{{ $globalSettings['site_icon'] ?? 'fas fa-bolt' }} text-lg"></i>
                                </div>
                                <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-white">{{ $globalSettings['site_name'] ?? 'WP' }} <span class="gradient-text">Market</span></a>
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed max-w-md">
                                {{ $globalSettings['site_description'] ?? 'La plataforma líder en recursos premium para WordPress. Themes, plugins y herramientas de marketing optimizadas.' }}
                            </p>
                            <div class="flex gap-3 mt-6">
                                <a href="#" aria-label="Twitter" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-twitter text-sm"></i></a>
                                <a href="#" aria-label="Discord" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-discord text-sm"></i></a>
                                <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-instagram text-sm"></i></a>
                                <a href="#" aria-label="YouTube" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-youtube text-sm"></i></a>
                            </div>
                        </div>
                </div>

                <!-- Stats Card -->
                <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#FF2121]/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121] mb-4">
                                <i class="fas fa-chart-line text-sm"></i>
                            </div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Catálogo</h4>
                            <p class="text-3xl font-black text-white">{{ number_format($productsCount ?? 0) }}+</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-4">Productos premium activos</p>
                    </div>
                </div>

                <!-- Navigation Card -->
                <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#FF2121]/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121] mb-5">
                            <i class="fas fa-compass text-sm"></i>
                        </div>
                        <h4 class="text-xs font-black uppercase tracking-widest text-white mb-5">Navegación</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('products.index') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-box-open text-xs text-gray-600 group-hover/item:text-[#FF2121] transition"></i> Productos</a></li>
                            <li><a href="{{ route('pages.rewards') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-crown text-xs text-gray-600 group-hover/item:text-[#FF2121] transition"></i> Programa VIP</a></li>
                            <li><a href="{{ route('pages.plugin') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-plug text-xs text-gray-600 group-hover/item:text-[#FF2121] transition"></i> Plugin Oficial</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-rose-500/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="w-10 h-10 bg-rose-500/10 border border-rose-500/20 rounded-xl flex items-center justify-center text-rose-400 mb-5">
                            <i class="fas fa-life-ring text-sm"></i>
                        </div>
                        <h4 class="text-xs font-black uppercase tracking-widest text-white mb-5">Ayuda</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('pages.help') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-question-circle text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Centro de Ayuda</a></li>
                            <li><a href="{{ route('pages.terms') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-file-contract text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Términos</a></li>
                            <li><a href="{{ route('pages.refund') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-undo-alt text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Reembolso</a></li>
                            @auth
                                <li><a href="{{ route('user.support.index') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-ticket-alt text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Mis Tickets</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>

                <!-- Newsletter Card -->
                <div class="md:col-span-2 group relative bg-gradient-to-br from-[#FF2121]/10 via-[#FF2121]/10 to-amber-500/10 border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-[#FF2121]/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="text-sm font-black uppercase tracking-widest text-white mb-1">Newsletter</h4>
                                <p class="text-gray-400 text-sm">Nuevos productos y actualizaciones directo a tu email.</p>
                            </div>
                            <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-amber-400">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                        </div>
                        <form class="flex gap-2">
                            <input type="email" placeholder="tu@email.com" class="flex-1 bg-[#080808]/60 border border-white/10 rounded-2xl px-5 py-3.5 text-sm text-white placeholder:text-gray-600 focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
                            <button type="button" class="px-6 py-3.5 gradient-bg hover:opacity-90 text-white rounded-2xl text-xs font-black uppercase tracking-wider transition-all shadow-lg shadow-[#FF2121]/20">Suscribir</button>
                        </form>
                    </div>
                </div>

                <!-- Trust Card -->
                <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#FF2121]/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121] shrink-0">
                                <i class="fas fa-shield-alt text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">Pago Seguro</p>
                                <p class="text-xs text-gray-500 mt-1">PayPal, tarjetas y cripto</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121] shrink-0">
                                <i class="fas fa-headset text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">Soporte 24/7</p>
                                <p class="text-xs text-gray-500 mt-1">Atención rápida y personalizada</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121] shrink-0">
                                <i class="fas fa-bolt text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">Entrega Inmediata</p>
                                <p class="text-xs text-gray-500 mt-1">Descarga automática tras compra</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-white/[0.06] flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[11px] font-black text-gray-600 uppercase tracking-widest">© {{ date('Y') }} {{ $globalSettings['site_name'] ?? 'WP Marketplace' }}. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6 text-[11px] font-black text-gray-600 uppercase tracking-widest">
                    <a href="{{ route('pages.terms') }}" class="hover:text-white transition">Términos</a>
                    <a href="{{ route('pages.refund') }}" class="hover:text-white transition">Reembolso</a>
                    <a href="#" class="hover:text-white transition">Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    @yield('extra_js')
    @stack('scripts')
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"], a[href*="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Si el enlace es una ancla interna o contiene un ancla a la página actual
                if (href.startsWith('#') || href.includes(window.location.pathname + '#')) {
                    const targetId = href.split('#')[1];
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        e.preventDefault();
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>

    <!-- Toast Notifications System -->
    @auth
    <script>
        // Sonido de notificación
        function playNotificationSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                if (audioContext.state === 'suspended') {
                    audioContext.resume();
                }
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 800;
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.3);
                
                // Segundo tono
                setTimeout(() => {
                    const osc2 = audioContext.createOscillator();
                    const gain2 = audioContext.createGain();
                    osc2.connect(gain2);
                    gain2.connect(audioContext.destination);
                    osc2.frequency.value = 1000;
                    osc2.type = 'sine';
                    gain2.gain.setValueAtTime(0.2, audioContext.currentTime);
                    gain2.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
                    osc2.start(audioContext.currentTime);
                    osc2.stop(audioContext.currentTime + 0.2);
                }, 100);
            } catch (e) {
                console.warn('Audio play failed', e);
            }
        }

        // Sistema de notificaciones
        let lastNotificationId = 0;
        let shownNotifications = new Set();

        function showToast(notification) {
            // Evitar mostrar la misma notificación dos veces
            if (shownNotifications.has(notification.id)) return;
            shownNotifications.add(notification.id);

            // Asegurar que el contenedor existe
            let container = document.getElementById('notification-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notification-container';
                container.className = 'fixed top-8 right-8 z-[9999] space-y-4 max-w-md pointer-events-none';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto transform transition-all duration-300 ease-out';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(400px)';
            
            toast.innerHTML = `
                <div class="glass p-6 rounded-3xl shadow-2xl border-l-4 border-[#FF2121] backdrop-blur-xl">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#FF2121] to-[#F51B1B] rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-[#F51B1B]/30">
                            <i class="fas ${notification.icon} text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-sm font-black text-white">${notification.title}</h4>
                                <button onclick="this.closest('.transform').remove()" class="text-gray-500 hover:text-white transition ml-2">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mb-3">${notification.message}</p>
                            <div class="flex gap-2">
                                ${notification.link ? `
                                    <a href="${notification.link}" class="px-4 py-2 bg-[#F51B1B] hover:bg-[#F51B1B] text-white text-xs font-bold rounded-xl transition-all">
                                        Ver Ahora
                                    </a>
                                ` : ''}
                                <button onclick="markAsRead(${notification.id}, this)" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white text-xs font-bold rounded-xl transition-all">
                                    Marcar como leída
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(toast);
            
            // Animar entrada
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateX(0)';
            }, 10);
            
            // Auto-cerrar después de 8 segundos
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 300);
            }, 8000);
        }

        function markAsRead(notificationId, button) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                button.closest('.transform').style.opacity = '0';
                button.closest('.transform').style.transform = 'translateX(400px)';
                setTimeout(() => button.closest('.transform').remove(), 300);
            });
        }

        function checkForNewNotifications() {
            fetch('/notifications/unread')
                .then(response => response.json())
                .then(data => {
                    if (data.notifications && data.notifications.length > 0) {
                        const newNotifications = data.notifications.filter(n => n.id > lastNotificationId);
                        
                        if (newNotifications.length > 0) {
                            playNotificationSound();
                            newNotifications.forEach((notification, index) => {
                                setTimeout(() => {
                                    showToast(notification);
                                }, index * 300);
                            });
                            lastNotificationId = Math.max(...data.notifications.map(n => n.id));
                        }
                    }
                })
                .catch(e => console.error('Error checking notifications', e));
        }

        // Verificar notificaciones
        document.addEventListener('DOMContentLoaded', () => {
             checkForNewNotifications();
             setInterval(checkForNewNotifications, 30000);
        });
    </script>
    @endauth

    @yield('extra_js')
    @stack('scripts')
    @stack('styles')
    @stack('schema')

    <!-- Mobile Search Overlay (Root Position Fix) -->
    <div x-show="mobileSearch" 
         @keydown.window.escape="mobileSearch = false"
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed inset-0 z-[9999] bg-[#050505] flex flex-col"
         x-data="{ searchQuery: '', searchResults: [], loading: false, hasSearched: false }"
    >
        <!-- Header -->
        <div class="p-4 border-b border-white/5 bg-[#050505] shrink-0">
            <div class="flex items-center gap-3">
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        @input.debounce.300ms="
                            if (searchQuery.length >= 2) {
                                loading = true;
                                hasSearched = true;
                                fetch('{{ route('search.live') }}?q=' + encodeURIComponent(searchQuery))
                                    .then(r => r.json())
                                    .then(data => {
                                        searchResults = data;
                                        loading = false;
                                    })
                                    .catch(() => { loading = false; });
                            } else {
                                searchResults = [];
                                loading = false;
                                hasSearched = false;
                            }
                        "
                        autofocus
                        placeholder="Buscar recursos..."
                        class="w-full bg-white/5 border border-white/10 rounded-2xl pl-11 pr-4 py-3 text-white text-base focus:ring-1 focus:ring-[#FF2121] outline-none"
                    >
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" x-show="!loading"></i>
                    <i class="fas fa-spinner fa-spin absolute left-4 top-1/2 -translate-y-1/2 text-[#FF2121]" x-show="loading"></i>
                </div>
                <button @click="mobileSearch = false; searchQuery = ''; searchResults = []; hasSearched = false" class="text-xs font-black uppercase text-gray-400 px-2 shrink-0">
                    Cerrar
                </button>
            </div>
        </div>

        <!-- Scrollable List -->
        <div class="flex-1 overflow-y-auto px-4 py-4">
            <!-- Loading -->
            <div x-show="loading" class="flex flex-col items-center justify-center py-20">
                <div class="w-8 h-8 border-4 border-[#F51B1B]/20 border-t-[#F51B1B] rounded-full animate-spin mb-4"></div>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Buscando...</p>
            </div>

            <!-- Results -->
            <div x-show="!loading && searchResults.length > 0" class="space-y-3">
                <template x-for="product in searchResults" :key="product.id">
                    <a :href="product.url" class="flex items-center gap-3 p-3 bg-white/[0.03] border border-white/5 rounded-2xl active:bg-white/10 transition-colors">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                            <img x-show="product.thumbnail" :src="product.thumbnail" class="w-full h-full object-cover">
                            <div x-show="!product.thumbnail" class="w-full h-full flex items-center justify-center text-white/10">
                                <i class="fas fa-box text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-[13px] font-bold text-white truncate" x-text="product.name"></h4>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[9px] font-black text-gray-500 uppercase tracking-wider" x-text="product.type"></span>
                                <span class="text-[#FF2121] font-black text-[11px]" x-text="'$' + product.price"></span>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-800 text-[10px]"></i>
                    </a>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && hasSearched && searchResults.length === 0" class="py-20 text-center">
                <i class="fas fa-search-minus text-2xl text-gray-700 mb-4"></i>
                <h3 class="text-white font-black text-lg">Sin resultados</h3>
                <p class="text-gray-500 text-xs mt-1">Prueba con otras palabras</p>
            </div>

            <!-- Welcome -->
            <div x-show="!loading && !hasSearched" class="py-20 text-center opacity-40">
                <i class="fas fa-magnifying-glass text-4xl text-gray-600 mb-6"></i>
                <p class="text-gray-600 text-[10px] font-black uppercase tracking-[0.2em] leading-relaxed px-10">
                    Encuentra temas y plugins premium
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div x-show="!loading && searchResults.length > 0" class="p-4 bg-[#050505] border-t border-white/5 shrink-0">
            <a :href="'{{ route('search.index') }}?q=' + encodeURIComponent(searchQuery)" class="w-full py-4 gradient-bg rounded-2xl text-white text-[11px] font-black uppercase tracking-widest text-center block">
                Ver todos los resultados
            </a>
        </div>
    </div>
</body>
</html>