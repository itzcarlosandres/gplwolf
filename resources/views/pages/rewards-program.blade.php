@extends('layouts.frontend')

@section('title', 'Programa de Recompensas y Membresías')

@section('content')
<!-- Hero Section -->
<div class="relative bg-[#050505] overflow-hidden pt-32 pb-20">
    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
    <div class="absolute top-0 right-0 w-1/2 h-full bg-[#F51B1B]/10 skew-x-12 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-amber-600/10 blur-3xl"></div>

    <div class="relative z-10 container mx-auto px-6 text-center">
        <span class="inline-block mb-6 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-amber-500/10">
            Comunidad VIP
        </span>
        <h1 class="text-5xl md:text-7xl font-black text-white mb-8 tracking-tighter leading-none">
            Gana más.<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-400 to-amber-200">Construye mejor.</span>
        </h1>
        <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
            Únete a nuestro programa exclusivo. Obtén puntos por cada descarga, desbloquea niveles superiores y accede a recompensas premium diseñadas para creadores ambiciosos.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#planes" class="px-8 py-4 bg-white text-black font-black uppercase tracking-widest hover:bg-amber-400 transition-colors clip-path-polygon text-xs md:text-sm">
                Ver Membresías
            </a>
            <a href="#puntos" class="px-8 py-4 bg-transparent border border-white/20 text-white font-black uppercase tracking-widest hover:bg-white/5 transition-colors text-xs md:text-sm">
                Cómo Funciona
            </a>
        </div>
    </div>
</div>

<!-- Points System Explanation -->
<div id="puntos" class="bg-[#0d0d0d] py-24 border-y border-white/5 relative">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4 tracking-tight">Sistema de Puntos</h2>
            <p class="text-gray-400">Cada acción cuenta. Acumula puntos y canjéalos por productos reales.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Step 1 -->
            <div class="bg-gray-900/50 border border-white/5 p-8 rounded-3xl relative overflow-hidden group hover:border-[#FF2121]/30 transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#FF2121]/10 rounded-full blur-2xl group-hover:bg-[#FF2121]/20 transition-all"></div>
                <div class="w-12 h-12 bg-[#FF2121]/20 rounded-xl flex items-center justify-center mb-6 text-[#FF2121] text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-download"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">1. Descarga & Compra</h3>
                <p class="text-sm text-gray-500">Gana puntos automáticamente con cada compra o descarga de recursos. Sube de nivel para ganar multiplicadores.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-gray-900/50 border border-white/5 p-8 rounded-3xl relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
                <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center mb-6 text-emerald-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-coins"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">2. Acumula</h3>
                <p class="text-sm text-gray-500">Tus puntos nunca expiran mientras seas miembro activo. Revisa tu saldo en tiempo real desde tu dashboard.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-gray-900/50 border border-white/5 p-8 rounded-3xl relative overflow-hidden group hover:border-amber-500/30 transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all"></div>
                <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center mb-6 text-amber-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-gift"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">3. Canjea</h3>
                <p class="text-sm text-gray-500">Usa tus puntos para obtener descuentos directos o productos exclusivos totalmente gratis.</p>
            </div>
        </div>
    </div>
</div>

<!-- Membership Tiers Section -->
<div id="planes" class="py-24 bg-[#050505] relative">
    <div class="container mx-auto px-6">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 uppercase tracking-tighter">Niveles de Membresía</h2>
            <p class="text-gray-400 max-w-xl mx-auto">Selecciona el plan que se adapte a tu ritmo de trabajo. Cancela cuando quieras.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 max-w-6xl mx-auto items-center">
            
            <!-- Basic Plan -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gray-800 rounded-3xl transform translate-y-2 opacity-50"></div>
                <div class="relative bg-[#0d0d0d] border border-white/10 rounded-3xl p-8 hover:border-white/20 transition-all">
                    <h3 class="text-lg font-bold text-gray-400 uppercase tracking-widest mb-4">Starter</h3>
                    <div class="text-4xl font-black text-white mb-6">$6.99<span class="text-lg text-gray-600 font-medium">/mes</span></div>
                    <ul class="space-y-4 mb-8 text-sm text-gray-400">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i> Acceso a Temas y Plugins</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i> Descargas de alta velocidad</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i> Acesso inmediato</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-4 rounded-xl bg-white/5 text-white font-bold text-center border border-white/10 hover:bg-white/10 transition-all uppercase text-xs tracking-widest">
                        Empezar
                    </a>
                </div>
            </div>

            <!-- Pro Plan (Destacado) -->
            <div class="relative group transform md:-translate-y-4 z-10">
                <div class="absolute -inset-1 bg-gradient-to-b from-[#FF2121] to-[#F51B1B] rounded-[26px] blur opacity-40 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="relative bg-[#0b1121] border border-white/10 rounded-3xl p-10 shadow-2xl">
                    <div class="absolute top-0 right-0 bg-[#F51B1B] text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-bl-xl rounded-tr-2xl">Recomendado</div>
                    
                    <h3 class="text-lg font-bold text-[#FF2121] uppercase tracking-widest mb-4">Professional</h3>
                    <div class="text-5xl font-black text-white mb-6">$59.99.<span class="text-lg text-gray-600 font-medium">/mes</span></div>
                    <p class="text-xs text-gray-500 mb-8 font-medium">Perfecto para freelancers y desarrolladores activos.</p>
                    
                    <ul class="space-y-5 mb-10 text-sm text-gray-300">
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-[#FF2121]"></i> 50 Descargas diarias</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-[#FF2121]"></i> Acceso Total (Themes & Plugins)</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check-circle text-[#FF2121]"></i> Updates Automáticos</li>
                        <li class="flex items-center gap-3"><i class="fas fa-star text-amber-400"></i> <span class="text-white font-bold">1.5x Puntos de Recompensa</span></li>
                    </ul>
                    
                    <a href="{{ route('register') }}" class="block w-full py-5 rounded-xl bg-[#F51B1B] hover:bg-[#FF2121] text-white font-black text-center shadow-lg shadow-[#F51B1B]/25 transition-all uppercase text-xs tracking-[0.15em]">
                        Obtener Acceso Pro
                    </a>
                </div>
            </div>

            <!-- Agency Plan -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gray-800 rounded-3xl transform translate-y-2 opacity-50"></div>
                <div class="relative bg-[#0d0d0d] border border-white/10 rounded-3xl p-8 hover:border-white/20 transition-all">
                    <h3 class="text-lg font-bold text-gray-400 uppercase tracking-widest mb-4">LifeTime</h3>
                    <div class="text-4xl font-black text-white mb-6">$150.99<span class="text-lg text-gray-600 font-medium">/mes</span></div>
                    <ul class="space-y-4 mb-8 text-sm text-gray-400">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i> Descargas Ilimitadas</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i> Licencia Comercial</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i> Soporte Prioritario 24/7</li>
                         <li class="flex items-center gap-3"><i class="fas fa-star text-amber-400"></i> <span class="text-white font-bold">2x Puntos de Recompensa</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-4 rounded-xl bg-white/5 text-white font-bold text-center border border-white/10 hover:bg-white/10 transition-all uppercase text-xs tracking-widest">
                        Contactar Ventas
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Exclusive Rewards Slider -->
<div class="py-24 bg-[#0d0d0d] border-t border-white/5 overflow-hidden">
    <div class="container mx-auto px-6" x-data="{ 
        interval: null,
        init() {
            this.startScroll();
        },
        startScroll() {
            this.interval = setInterval(() => {
                const slider = this.$refs.slider;
                if (slider.scrollLeft + slider.offsetWidth >= slider.scrollWidth) {
                    slider.scrollTo({left: 0, behavior: 'smooth'});
                } else {
                    slider.scrollLeft += 1;
                }
            }, 30);
        },
        stopScroll() {
            clearInterval(this.interval);
        },
        scrollLeft() { 
            this.$refs.slider.scrollBy({ left: -300, behavior: 'smooth' }) 
        },
        scrollRight() { 
            this.$refs.slider.scrollBy({ left: 300, behavior: 'smooth' }) 
        }
    }" @mouseenter="stopScroll()" @mouseleave="startScroll()">
        <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-6 relative z-10">
            <div>
                <h2 class="text-3xl font-black text-white mb-2">Recompensas Exclusivas</h2>
                <p class="text-gray-400 text-sm">Canjea tus puntos por las últimas novedades del catálogo.</p>
            </div>
            <div class="flex gap-2">
                <button @click="scrollLeft()" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center text-white transition-colors border border-white/10">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button @click="scrollRight()" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center text-white transition-colors border border-white/10">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        @php
            $latestRewards = \App\Models\Product::where('is_active', true)
                ->latest()
                ->take(10)
                ->get();
        @endphp

        <div class="relative -mx-6 px-6 md:px-0 md:mx-0">
            <!-- Fade Gradients for visual scrolling cues -->
            <div class="absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-[#0d0d0d] to-transparent z-10 md:hidden pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-8 bg-gradient-to-l from-[#0d0d0d] to-transparent z-10 md:hidden pointer-events-none"></div>

            <div x-ref="slider" class="flex gap-6 overflow-x-auto pb-8 scrollbar-hide">
                @foreach($latestRewards as $product)
                    @php
                        // Simulate points cost: Price * 100, or 500 if free/GPL
                        $pointsCost = $product->price > 0 ? (int)($product->price * 100) : 500;
                    @endphp
                    
                    <a href="{{ route('products.show', $product->slug) }}" class="flex-none w-[280px] snap-center group relative aspect-[4/5] bg-black rounded-3xl overflow-hidden border border-white/10 hover:border-[#FF2121]/50 transition-all duration-500">
                        <!-- Image -->
                        @if($product->thumbnail)
                             <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center opacity-60 group-hover:opacity-100 transition-all duration-700">
                                <i class="{{ $product->category->icon ?? 'fas fa-box' }} text-4xl text-gray-600 group-hover:text-[#FF2121] transition-colors"></i>
                            </div>
                        @endif
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/40 to-transparent opacity-90 group-hover:opacity-60 transition-opacity duration-500"></div>
                        
                        <!-- Content -->
                        <div class="absolute inset-x-0 bottom-0 p-6 translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <!-- Type Badge -->
                            <div class="mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 transform translate-y-2 group-hover:translate-y-0">
                                <span class="px-2 py-1 rounded-md bg-white/20 backdrop-blur-md text-[9px] font-black uppercase tracking-widest text-white border border-white/10">
                                    {{ $product->type ?? 'Recurso' }}
                                </span>
                            </div>

                            <h3 class="text-white font-bold text-lg leading-tight mb-2 line-clamp-2 group-hover:text-[#FF2121] transition-colors">
                                {{ $product->name }}
                            </h3>
                            
                            <div class="flex items-center gap-3">
                                <div class="text-amber-400 text-xs font-black bg-amber-500/10 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                    <i class="fas fa-gem mr-1.5"></i> {{ number_format($pointsCost) }} Pts
                                </div>
                                @if($product->rating > 0)
                                    <div class="flex items-center text-xs text-gray-400">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i> {{ $product->rating }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<style>
    .clip-path-polygon {
        clip-path: polygon(10% 0, 100% 0, 100% 100%, 0% 100%);
    }
</style>
@endsection