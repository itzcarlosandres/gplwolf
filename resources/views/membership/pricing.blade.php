@extends('layouts.frontend')

@section('meta_title', 'Planes de Membresía Premium - GPLWolf')
@section('meta_description', 'Únete al club GPLWolf y descarga más de 5,000 temas y plugins premium de WordPress con descargas ilimitadas, actualizaciones automáticas y 100% seguros.')

@section('content')
<div class="relative overflow-hidden bg-[#050505] text-white pb-20 font-sans" x-data="pricingPage()">
    <!-- Background Effects -->
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[150px] -z-10 animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-yellow-500/5 rounded-full blur-[180px] -z-10"></div>
    <div class="absolute top-[30%] right-0 w-[400px] h-[400px] bg-pink-600/5 rounded-full blur-[130px] -z-10 animate-[float_8s_ease-in-out_infinite]"></div>

    <!-- Limited Time Sticky Alert Banner -->
    <div class="bg-gradient-to-r from-red-600 via-pink-600 to-amber-500 text-white text-xs md:text-sm py-3 px-4 text-center font-black relative z-50 tracking-wider shadow-lg shadow-red-600/20">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-center items-center gap-2">
            <span class="flex items-center gap-1.5 animate-bounce sm:animate-none">
                ⚡ ¡OFERTA DE BIENVENIDA! 10% DE DESCUENTO EXTRA EN CUALQUIER PLAN:
            </span>
            <span class="bg-white/20 px-2 py-0.5 rounded font-mono font-bold text-white tracking-widest text-xs uppercase border border-white/30">
                OFERTA10
            </span>
            <span class="text-white/90 text-xs sm:text-sm font-medium">
                Se aplica automáticamente al dar clic. Expira en:
            </span>
            <span class="font-mono text-yellow-300 font-black text-sm tracking-widest bg-black/30 px-3 py-0.5 rounded border border-yellow-500/20" x-text="timerDisplay">
                14:59
            </span>
        </div>
    </div>

    <!-- Main Header -->
    <div class="max-w-7xl mx-auto px-6 pt-16 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/10 border border-red-500/20 text-xs font-black uppercase text-red-500 tracking-widest mb-6 animate-pulse">
            👑 Acceso Ilimitado
        </span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black tracking-tighter text-white mb-6 leading-none">
            Impulsa tus Sitios Web con<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-amber-500 drop-shadow-sm">Membresía Premium</span>
        </h1>
        <p class="text-gray-400 max-w-2xl mx-auto text-base md:text-lg leading-relaxed mb-12">
            Descarga miles de themes y plugins premium de WordPress con licencia GPL original, archivos 100% limpios y actualizaciones automáticas.
        </p>

        <!-- Design Selector -->
        <div class="max-w-2xl mx-auto mb-16 px-6 relative z-40">
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
        <div x-show="activeDesign === 'cyberglow'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left">
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
        <div x-show="activeDesign === 'minimalist'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left">
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
        <div x-show="activeDesign === 'nordic'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left">
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
        <div x-show="activeDesign === 'bento'" class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl mx-auto items-stretch text-left">
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
        <div x-show="activeDesign === 'gradients'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left">
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
            @endforelse
        </div>
    </div>

    <!-- Value Propositions Section -->
    <section class="max-w-7xl mx-auto px-6 mt-32">
        <div class="text-center mb-16">
            <span class="text-red-500 font-bold uppercase tracking-widest text-xs mb-3 block">✓ Beneficios GPLWolf</span>
            <h2 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-4">Todo lo que Necesitas para tu Negocio</h2>
            <p class="text-gray-500 max-w-lg mx-auto text-sm">Ahorra miles de dólares en suscripciones individuales de plugins y temas de WordPress.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(239,68,68,0.15)]">
                    <i class="fas fa-shield-virus"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">100% Libre de Malware</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Escaneamos y auditamos cada archivo periódicamente para garantizar que no contengan código malicioso ni virus.
                </p>
            </div>
            
            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(245,158,11,0.15)]">
                    <i class="fas fa-sync-alt animate-spin-slow"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Actualizaciones de por Vida</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Accede a las últimas actualizaciones de tus plugins favoritos de manera inmediata. Subimos versiones nuevas todos los días.
                </p>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
                    <i class="fas fa-plug"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Plugin de Auto-Actualización</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Usa nuestro plugin oficial para conectar tu WordPress y actualizar temas y plugins directamente desde el escritorio.
                </p>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(59,130,246,0.15)]">
                    <i class="fas fa-infinity"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Licencia GPL Ilimitada</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Usa los productos en tantos sitios web como desees. El software GPL no está limitado por dominios.
                </p>
            </div>
        </div>
    </section>

    <!-- Comparison Matrix Table -->
    <section class="max-w-4xl mx-auto px-6 mt-32">
        <div class="text-center mb-16">
            <span class="text-[#FF2121] font-bold uppercase tracking-widest text-xs mb-3 block">⚡ Comparativa de Ahorro</span>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-white mb-4">¿Por qué Elegir una Membresía?</h2>
            <p class="text-gray-500 text-sm">Hacemos los números simples para tu bolsillo.</p>
        </div>

        <div class="bg-white/[0.02] border border-white/[0.06] rounded-[32px] overflow-hidden shadow-2xl backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-white/[0.06] bg-white/[0.02]">
                            <th class="p-6 text-sm font-black uppercase text-gray-400 tracking-wider">Beneficios & Recursos</th>
                            <th class="p-6 text-sm font-black uppercase text-red-500 tracking-wider text-center">Compra de Plugin Único</th>
                            <th class="p-6 text-sm font-black uppercase text-white tracking-wider text-center bg-red-600/15">Membresía Premium</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04] text-sm">
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Descargas instantáneas</td>
                            <td class="p-6 text-center text-gray-500">Solo 1 producto</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5">Acceso a +5,000 archivos</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Actualizaciones automáticas con Plugin</td>
                            <td class="p-6 text-center text-red-500"><i class="fas fa-times-circle"></i> No disponible</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5"><i class="fas fa-check-circle"></i> Incluido</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Uso en sitios ilimitados</td>
                            <td class="p-6 text-center text-emerald-400"><i class="fas fa-check-circle"></i> Sí</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5"><i class="fas fa-check-circle"></i> Sí</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Soporte Técnico de instalación</td>
                            <td class="p-6 text-center text-gray-500">Limitado</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5">Soporte Prioritario 24/7</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Solicitar actualizaciones / nuevos recursos</td>
                            <td class="p-6 text-center text-red-500"><i class="fas fa-times-circle"></i> No</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5"><i class="fas fa-check-circle"></i> Sí, ilimitadas</td>
                        </tr>
                        <tr class="bg-white/[0.01]">
                            <td class="p-6 font-black text-white text-base">Costo Promedio Estimado</td>
                            <td class="p-6 text-center text-gray-400 font-bold text-base">$30 - $80 por plugin</td>
                            <td class="p-6 text-center text-yellow-400 font-black text-xl bg-red-600/10">Un solo pago mínimo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="max-w-3xl mx-auto px-6 mt-32">
        <div class="text-center mb-16">
            <span class="text-red-500 font-bold uppercase tracking-widest text-xs mb-3 block">❓ Preguntas Frecuentes</span>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-white mb-4">¿Tienes alguna duda?</h2>
            <p class="text-gray-500 text-sm">Resolvemos tus inquietudes de inmediato.</p>
        </div>

        <div class="space-y-4">
            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 1 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 1 ? null : 1">
                    <span>¿Qué tipo de licencia tienen los archivos?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 1 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 1" x-transition>
                    Todos los plugins y temas de WordPress distribuidos en GPLWolf poseen una licencia pública general (GPL). Esto significa que son 100% legales para descargar, modificar y usar en tantos dominios como consideres oportuno.
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 2 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 2 ? null : 2">
                    <span>¿Son originales y limpios los plugins?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 2 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 2" x-transition>
                    Sí, absolutamente. Descargamos los archivos directamente de los autores originales y los distribuimos tal cual, sin modificaciones (sin nulled scripts, sin virus ni anuncios). Todos los archivos pasan por análisis de virus recurrentes.
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 3 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 3 ? null : 3">
                    <span>¿Cómo se actualizan los complementos?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 3 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 3" x-transition>
                    Puedes actualizarlos manualmente descargándolos del panel de GPLWolf y resubiéndolos en tu sitio, o bien instalar nuestro plugin oficial de GPLWolf. Este te permite actualizar de forma automatizada con un solo clic desde tu propio panel de administración de WordPress.
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 4 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 4 ? null : 4">
                    <span>¿Hay límites de descarga diaria?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 4 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 4" x-transition>
                    Los límites de descarga dependen del plan seleccionado. El plan Básico está limitado a 5 descargas diarias para prevenir abusos, mientras que el plan Pro cuenta con descargas ilimitadas o límites muy altos definidos en tu panel.
                </div>
            </div>
            
            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 5 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 5 ? null : 5">
                    <span>¿Existe política de reembolso?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 5 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 5" x-transition>
                    Sí, ofrecemos una garantía de reembolso de 7 días. Si alguno de los archivos descargados presenta problemas técnicos demostrables que nuestro equipo de soporte no pueda resolver, te reembolsaremos la totalidad de tu suscripción.
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Symbols & Payment Badges -->
    <div class="max-w-7xl mx-auto px-6 mt-32 text-center">
        <p class="text-xs font-black text-gray-500 uppercase tracking-[0.25em] mb-8">Pago 100% Seguro y Encriptado</p>
        <div class="flex flex-wrap justify-center items-center gap-8 opacity-45 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-500">
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-paypal"></i> PayPal</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-stripe"></i> Stripe</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-visa"></i> Visa</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-mastercard"></i> MasterCard</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-bitcoin"></i> Cripto/Binance</span>
        </div>
    </div>
</div>

<script>
    function pricingPage() {
        return {
            activeFaq: 1,       // active FAQ index
            timer: 15 * 60,     // 15 minutes in seconds
            timerDisplay: '15:00',
            activeDesign: 'cyberglow',

            init() {
                // Initialize Countdown Timer
                const interval = setInterval(() => {
                    if (this.timer <= 0) {
                        // Reset timer back to 15m to maintain fake urgency
                        this.timer = 15 * 60;
                    }
                    this.timer--;
                    const minutes = Math.floor(this.timer / 60);
                    const seconds = this.timer % 60;
                    this.timerDisplay = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                }, 1000);
            }
        }
    }
</script>

<style>
    .animate-spin-slow {
        animation: spin 8s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endsection
