@extends('layouts.frontend')

@section('meta_title', 'Demostración de Diseños de Membresía - GPLWolf')
@section('meta_description', 'Explora los 5 diseños exclusivos y premium para la sección de planes de membresía.')

@section('content')
<div class="relative overflow-hidden bg-[#050505] text-white pb-32 font-sans pt-12" x-data="pricingDemoPage()">
    <!-- Background Effects -->
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[150px] -z-10 animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-yellow-500/5 rounded-full blur-[180px] -z-10"></div>

    <!-- Demo Main Header -->
    <div class="max-w-7xl mx-auto px-6 pt-16 text-center mb-16">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/10 border border-red-500/20 text-xs font-black uppercase text-red-500 tracking-widest mb-6">
            🛠️ Galería de Componentes / Demos
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter text-white mb-6 leading-none">
            Diseños de <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-amber-500">Membresía Premium</span>
        </h1>
        <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
            Explora las 5 propuestas interactivas de UX/UI limpia y moderna para tus planes de precios. Haz clic en las opciones para cambiar el diseño al vuelo.
        </p>
    </div>

    <!-- Design Selector -->
    <div class="max-w-3xl mx-auto mb-16 px-6 relative z-40">
        <p class="text-center text-xs text-gray-500 font-bold uppercase tracking-[0.2em] mb-4">Elige el Estilo Visual que Prefieras</p>
        <div class="bg-white/5 border border-white/10 p-1.5 rounded-2xl flex flex-wrap justify-between items-center gap-1.5 backdrop-blur-md">
            <button @click="activeDesign = 'cyberglow'" :class="activeDesign === 'cyberglow' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                1. Cyber Glow
            </button>
            <button @click="activeDesign = 'minimalist'" :class="activeDesign === 'minimalist' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                2. Minimal Glass
            </button>
            <button @click="activeDesign = 'nordic'" :class="activeDesign === 'nordic' ? 'bg-white text-black shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                3. Nordic Light
            </button>
            <button @click="activeDesign = 'bento'" :class="activeDesign === 'bento' ? 'bg-emerald-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                4. Bento Grid
            </button>
            <button @click="activeDesign = 'gradients'" :class="activeDesign === 'gradients' ? 'bg-purple-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
                5. Gradients
            </button>
        </div>
    </div>

    <!-- Plans Grid 1: Cyber Glow (Default) -->
    <div x-show="activeDesign === 'cyberglow'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left px-6">
        @forelse($plans as $plan)
            @php
                $isFeatured = $plan->is_featured;
                $originalPrice = (float) $plan->price;
                $discountedPrice = round($originalPrice * 0.90, 2);
            @endphp
            <div class="relative bg-gradient-to-b from-white/[0.04] to-transparent border rounded-[36px] p-8 flex flex-col justify-between transition-all duration-500 transform hover:-translate-y-2 group
                {{ $isFeatured ? 'border-red-500/40 shadow-2xl shadow-red-500/10' : 'border-white/[0.06] hover:border-white/20' }}">

                @if($isFeatured)
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-red-600 to-amber-500 text-white text-[10px] font-black uppercase px-5 py-1.5 rounded-full tracking-widest shadow-lg border border-red-500/30 animate-[pulse_2s_infinite]">
                        ★ MÁS RECOMENDADO ★
                    </div>
                @endif

                <div>
                    <div class="mb-8">
                        <span class="text-xs font-black uppercase tracking-widest {{ $isFeatured ? 'text-red-500' : 'text-gray-500' }}">
                            {{ $plan->name }}
                        </span>
                        <p class="text-gray-400 text-xs mt-1">{{ $plan->description ?? 'Acceso a los mejores recursos.' }}</p>
                    </div>

                    <div class="mb-8 p-6 bg-white/[0.02] border border-white/[0.04] rounded-2xl relative overflow-hidden">
                        <div class="absolute top-2 right-4 text-xs font-semibold text-gray-500 line-through">
                            ${{ number_format($originalPrice, 2) }}
                        </div>
                        
                        <div class="flex items-baseline gap-1">
                            <span class="text-5xl font-black tracking-tight text-white">
                                ${{ number_format($discountedPrice, 2) }}
                            </span>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">
                                / @if($plan->duration === 'monthly') mes @elseif($plan->duration === 'yearly') año @else unico @endif
                            </span>
                        </div>
                        
                        <div class="text-[10px] text-emerald-400 font-black uppercase tracking-wider mt-2 flex items-center gap-1">
                            <i class="fas fa-check-circle"></i> ¡Ahorras ${{ number_format($originalPrice - $discountedPrice, 2) }} hoy!
                        </div>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-[9px] text-emerald-400"></i>
                            </div>
                            <span class="text-sm text-gray-300">
                                <strong>{{ $plan->daily_download_limit ?: 'Descargas ilimitadas' }}</strong> descargas diarias
                            </span>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-[9px] text-emerald-400"></i>
                            </div>
                            <span class="text-sm text-gray-300">
                                Conecta hasta <strong>{{ $plan->sites_limit ?: 'Sitios ilimitados' }}</strong> webs con el plugin oficial
                            </span>
                        </div>

                        @if($plan->reward_points > 0)
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-[9px] text-emerald-400"></i>
                            </div>
                            <span class="text-sm text-gray-300">
                                🎁 Recibe <strong>+{{ $plan->reward_points }} puntos VIP</strong> de regalo
                            </span>
                        </div>
                        @endif

                        @foreach($plan->benefits ?? [] as $benefit)
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-check text-[9px] text-emerald-400"></i>
                                </div>
                                <span class="text-sm text-gray-300 leading-relaxed">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <form action="{{ route('membership.add', $plan) }}?offer=1" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="offer" value="1">
                    <button type="submit" class="w-full relative group py-4 px-6 rounded-2xl font-black text-sm uppercase tracking-wider text-white shadow-xl overflow-hidden transition-all duration-300 hover:scale-[1.03] active:scale-[0.97]
                        {{ $isFeatured 
                            ? 'bg-gradient-to-r from-red-600 to-amber-500 shadow-red-500/20' 
                            : 'bg-white/5 border border-white/10 hover:bg-white/10' }}">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/15 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        <span class="flex items-center justify-center gap-2">
                            Activar Ahora <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes de membresía activos disponibles en este momento.</div>
        @endforelse
    </div>

    <!-- Plans Grid 2: Minimalist Glass -->
    <div x-show="activeDesign === 'minimalist'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left px-6">
        @forelse($plans as $plan)
            @php
                $isFeatured = $plan->is_featured;
                $originalPrice = (float) $plan->price;
                $discountedPrice = round($originalPrice * 0.90, 2);
            @endphp
            <div class="backdrop-blur-md bg-white/[0.02] border border-white/10 rounded-3xl p-8 flex flex-col justify-between hover:border-white/20 transition-all duration-300">
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-sm font-bold tracking-wider text-gray-300">{{ $plan->name }}</span>
                        @if($isFeatured)
                            <span class="px-2.5 py-0.5 rounded-full bg-[#FF2121]/10 border border-[#FF2121]/20 text-[10px] font-bold text-[#FF2121]">Recomendado</span>
                        @endif
                    </div>
                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-white">${{ number_format($discountedPrice, 2) }}</span>
                            <span class="text-gray-500 text-xs">/ @if($plan->duration === 'monthly') mes @elseif($plan->duration === 'yearly') año @else unico @endif</span>
                        </div>
                        <span class="text-[10px] text-gray-500 line-through mt-1 block">Antes: ${{ number_format($originalPrice, 2) }}</span>
                    </div>
                    
                    <p class="text-gray-400 text-xs mb-8">{{ $plan->description ?? 'Acceso ilimitado a nuestros recursos.' }}</p>

                    <div class="space-y-3.5 mb-8 border-t border-white/5 pt-6">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check text-xs text-[#FF2121]"></i>
                            <span class="text-sm text-gray-300"><strong>{{ $plan->daily_download_limit ?: 'Descargas ilimitadas' }}</strong> diarias</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check text-xs text-[#FF2121]"></i>
                            <span class="text-sm text-gray-300">Conecta <strong>{{ $plan->sites_limit ?: 'Sitios ilimitados' }}</strong> webs</span>
                        </div>
                        @if($plan->reward_points > 0)
                            <div class="flex items-center gap-3">
                                <i class="fas fa-gift text-xs text-[#FF2121]"></i>
                                <span class="text-sm text-gray-300"><strong>+{{ $plan->reward_points }} puntos VIP</strong></span>
                            </div>
                        @endif
                        @foreach($plan->benefits ?? [] as $benefit)
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check text-xs text-[#FF2121]"></i>
                                <span class="text-sm text-gray-300">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <form action="{{ route('membership.add', $plan) }}?offer=1" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold text-xs uppercase tracking-widest transition-all duration-300
                        {{ $isFeatured ? 'bg-[#FF2121] hover:bg-[#F51B1B] text-white shadow-lg shadow-[#FF2121]/20' : 'border border-white/10 text-white hover:bg-white/5' }}">
                        Suscribirse
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes de membresía activos disponibles en este momento.</div>
        @endforelse
    </div>

    <!-- Plans Grid 3: Nordic Light -->
    <div x-show="activeDesign === 'nordic'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left px-6">
        @forelse($plans as $plan)
            @php
                $isFeatured = $plan->is_featured;
                $originalPrice = (float) $plan->price;
                $discountedPrice = round($originalPrice * 0.90, 2);
            @endphp
            <div class="bg-white border border-gray-100 rounded-[30px] p-8 flex flex-col justify-between shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-[1.01]">
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-xs font-black uppercase tracking-wider text-gray-400">{{ $plan->name }}</span>
                        @if($isFeatured)
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-[9px] font-black uppercase tracking-widest text-emerald-600 border border-emerald-200">Popular</span>
                        @endif
                    </div>
                    <div class="mb-6">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-gray-900">${{ number_format($discountedPrice, 2) }}</span>
                            <span class="text-gray-400 text-xs">/ @if($plan->duration === 'monthly') mes @elseif($plan->duration === 'yearly') año @else unico @endif</span>
                        </div>
                        <span class="text-[10px] text-gray-400 line-through mt-1 block">Normal: ${{ number_format($originalPrice, 2) }}</span>
                    </div>
                    
                    <p class="text-gray-500 text-xs leading-relaxed mb-6">{{ $plan->description ?? 'Acceso a los mejores recursos premium de WordPress.' }}</p>

                    <div class="space-y-3.5 mb-8 border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-[9px] text-gray-800"></i>
                            </div>
                            <span class="text-sm text-gray-700"><strong>{{ $plan->daily_download_limit ?: 'Descargas ilimitadas' }}</strong> descargas/día</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-[9px] text-gray-800"></i>
                            </div>
                            <span class="text-sm text-gray-700">Conecta <strong>{{ $plan->sites_limit ?: 'Sitios ilimitados' }}</strong> webs</span>
                        </div>
                        @if($plan->reward_points > 0)
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-amber-50 flex items-center justify-center shrink-0">
                                    <i class="fas fa-gift text-[9px] text-amber-600"></i>
                                </div>
                                <span class="text-sm text-gray-700"><strong>+{{ $plan->reward_points }} puntos VIP</strong></span>
                            </div>
                        @endif
                        @foreach($plan->benefits ?? [] as $benefit)
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                    <i class="fas fa-check text-[9px] text-gray-800"></i>
                                </div>
                                <span class="text-sm text-gray-700">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <form action="{{ route('membership.add', $plan) }}?offer=1" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-4 px-6 rounded-2xl font-black text-xs uppercase tracking-wider text-center transition-all duration-300
                        {{ $isFeatured ? 'bg-gray-900 hover:bg-black text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-800' }}">
                        Comenzar Ahora
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes de membresía activos disponibles en este momento.</div>
        @endforelse
    </div>

    <!-- Plans Grid 4: Bento Grid -->
    <div x-show="activeDesign === 'bento'" class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl mx-auto items-stretch text-left px-6">
        @forelse($plans as $plan)
            @php
                $isFeatured = $plan->is_featured;
                $originalPrice = (float) $plan->price;
                $discountedPrice = round($originalPrice * 0.90, 2);
            @endphp
            <div class="bg-gray-950 border border-white/5 rounded-3xl p-6 flex flex-col justify-between hover:border-emerald-500/20 transition-all duration-300">
                <div class="space-y-4">
                    <!-- Bento Block 1: Name & Badge -->
                    <div class="bg-white/[0.02] border border-white/[0.04] p-5 rounded-2xl flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-black uppercase text-emerald-400 tracking-wider">Plan</span>
                            <h4 class="text-base font-bold text-white">{{ $plan->name }}</h4>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                            <i class="fas fa-gem text-xs"></i>
                        </div>
                    </div>

                    <!-- Bento Block 2: Price -->
                    <div class="bg-white/[0.02] border border-white/[0.04] p-5 rounded-2xl relative overflow-hidden">
                        <span class="text-[10px] font-black uppercase text-gray-500 tracking-wider">Inversión</span>
                        <div class="flex items-baseline gap-1 mt-1">
                            <span class="text-3xl font-extrabold text-white">${{ number_format($discountedPrice, 2) }}</span>
                            <span class="text-gray-500 text-[10px] uppercase font-bold">/ @if($plan->duration === 'monthly') mes @elseif($plan->duration === 'yearly') año @else unico @endif</span>
                        </div>
                        <span class="text-[9px] text-rose-400 mt-1 block">Ahorras 10% de inmediato</span>
                    </div>

                    <!-- Bento Block 3: Features checklist -->
                    <div class="bg-white/[0.01] border border-white/[0.02] p-5 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2.5 text-xs text-gray-300">
                            <i class="fas fa-cloud-download-alt text-emerald-400"></i>
                            <span><strong>{{ $plan->daily_download_limit ?: 'Descargas ilimitadas' }}</strong> descargas/día</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs text-gray-300">
                            <i class="fas fa-network-wired text-emerald-400"></i>
                            <span>Soporta <strong>{{ $plan->sites_limit ?: 'Sitios ilimitados' }}</strong> sitios</span>
                        </div>
                        @foreach($plan->benefits ?? [] as $benefit)
                            <div class="flex items-center gap-2.5 text-xs text-gray-300">
                                <i class="fas fa-circle-notch text-[8px] text-emerald-400"></i>
                                <span class="truncate text-xs">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Bento Block 4: Action Button -->
                <form action="{{ route('membership.add', $plan) }}?offer=1" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-black font-black text-xs uppercase tracking-wider rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/10">
                        Comenzar Plan →
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes de membresía activos disponibles en este momento.</div>
        @endforelse
    </div>

    <!-- Plans Grid 5: Gradient Cards -->
    <div x-show="activeDesign === 'gradients'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left px-6">
        @forelse($plans as $plan)
            @php
                $isFeatured = $plan->is_featured;
                $originalPrice = (float) $plan->price;
                $discountedPrice = round($originalPrice * 0.90, 2);
            @endphp
            <div class="rounded-3xl p-8 flex flex-col justify-between transition-all duration-300 hover:scale-[1.02]
                {{ $isFeatured 
                    ? 'bg-gradient-to-br from-red-600 via-purple-700 to-indigo-950 text-white shadow-2xl border-0' 
                    : 'bg-gradient-to-br from-white/[0.03] to-white/[0.01] border border-white/5 text-gray-300' }}">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <span class="text-xs font-black uppercase tracking-widest {{ $isFeatured ? 'text-white' : 'text-purple-400' }}">{{ $plan->name }}</span>
                    @if($isFeatured)
                        <span class="px-2 py-0.5 rounded-full bg-white/20 text-[9px] font-black uppercase tracking-wider text-white">Recomendado</span>
                    @endif
                </div>

                <div class="mb-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-extrabold text-white">${{ number_format($discountedPrice, 2) }}</span>
                        <span class="text-xs {{ $isFeatured ? 'text-white/70' : 'text-gray-500' }}">/ @if($plan->duration === 'monthly') mes @elseif($plan->duration === 'yearly') año @else unico @endif</span>
                    </div>
                    <span class="text-[10px] line-through mt-1 block {{ $isFeatured ? 'text-white/50' : 'text-gray-500' }}">Normal: ${{ number_format($originalPrice, 2) }}</span>
                </div>

                <p class="text-xs mb-8 {{ $isFeatured ? 'text-white/80' : 'text-gray-400' }}">{{ $plan->description ?? 'Acceso ilimitado a todos los recursos premium.' }}</p>

                <div class="space-y-3.5 mb-8 border-t {{ $isFeatured ? 'border-white/10' : 'border-white/5' }} pt-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-xs {{ $isFeatured ? 'text-white' : 'text-purple-400' }}"></i>
                        <span class="text-sm"><strong>{{ $plan->daily_download_limit ?: 'Descargas ilimitadas' }}</strong> diarias</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-xs {{ $isFeatured ? 'text-white' : 'text-purple-400' }}"></i>
                        <span class="text-sm">Conecta hasta <strong>{{ $plan->sites_limit ?: 'Sitios ilimitados' }}</strong> webs</span>
                    </div>
                    @if($plan->reward_points > 0)
                        <div class="flex items-center gap-3">
                            <i class="fas fa-gift text-xs {{ $isFeatured ? 'text-white' : 'text-purple-400' }}"></i>
                            <span class="text-sm"><strong>+{{ $plan->reward_points }} puntos VIP</strong></span>
                        </div>
                    @endif
                    @foreach($plan->benefits ?? [] as $benefit)
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check text-xs {{ $isFeatured ? 'text-white' : 'text-purple-400' }}"></i>
                            <span class="text-sm">{{ $benefit }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('membership.add', $plan) }}?offer=1" method="POST">
                @csrf
                <button type="submit" class="w-full py-4 px-6 rounded-2xl font-black text-xs uppercase tracking-wider transition-all duration-300
                    {{ $isFeatured ? 'bg-white hover:bg-gray-100 text-black shadow-lg' : 'bg-purple-600 hover:bg-purple-500 text-white shadow-lg shadow-purple-600/20' }}">
                    Empezar Ahora
                </button>
            </form>
        </div>
        @empty
            <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes de membresía activos disponibles en este momento.</div>
        @endforelse
    </div>
</div>

<script>
    function pricingDemoPage() {
        return {
            activeDesign: 'cyberglow',
        }
    }
</script>
@endsection
