@extends('layouts.frontend')

@section('meta_title', 'Licencias Oficiales y Legales - GPLWolf')
@section('meta_description', 'Adquiere claves de activación y licencias de desarrollador oficiales para tus plugins y temas favoritos de WordPress. Actualizaciones automáticas y soporte directo.')

@section('content')
<div class="relative overflow-hidden bg-[#050505] text-white pb-32 font-sans">
    <!-- Background Orb Glows -->
    <div class="absolute top-0 left-1/3 w-[600px] h-[600px] bg-amber-500/5 rounded-full blur-[160px] -z-10 animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-red-600/5 rounded-full blur-[140px] -z-10"></div>

    <!-- Main Header -->
    <div class="max-w-7xl mx-auto px-6 pt-24 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-xs font-black uppercase text-amber-500 tracking-widest mb-6">
            🔑 Activación Oficial Directa
        </span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black tracking-tighter text-white mb-6 leading-none">
            Adquiere <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-yellow-200 to-amber-500 drop-shadow-sm">Licencias Oficiales</span><br>
            de Desarrollador
        </h1>
        <p class="text-gray-400 max-w-2xl mx-auto text-base md:text-lg leading-relaxed mb-16">
            Consigue claves de activación originales y licencias reseller para actualizar de forma automática en 1-clic directo desde tu escritorio de WordPress.
        </p>

        <!-- Comparison Table / Matrix -->
        <div class="max-w-4xl mx-auto bg-[#0a0a0c] border border-white/[0.06] rounded-[32px] p-6 md:p-8 mb-20 text-left relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <i class="fas fa-balance-scale text-amber-500"></i> ¿Cuál es la diferencia con GPL regular?
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- GPL Regular -->
                <div class="p-6 bg-white/[0.01] border border-white/[0.04] rounded-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500">
                            <i class="fas fa-download text-sm"></i>
                        </div>
                        <h4 class="text-white font-bold text-sm">Descarga GPL Regular</h4>
                    </div>
                    <ul class="space-y-3 text-xs text-gray-500">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-[10px]"></i> Código 100% libre e ilimitado</li>
                        <li class="flex items-center gap-2"><i class="fas fa-times text-red-500 text-[10px]"></i> Actualizaciones manuales vía zip</li>
                        <li class="flex items-center gap-2"><i class="fas fa-times text-red-500 text-[10px]"></i> Sin soporte del desarrollador original</li>
                        <li class="flex items-center gap-2"><i class="fas fa-times text-red-500 text-[10px]"></i> Sin acceso a plantillas en la nube/API</li>
                    </ul>
                </div>

                <!-- Licencia Oficial -->
                <div class="p-6 bg-amber-500/[0.02] border border-amber-500/20 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-amber-500 text-black text-[8px] font-black uppercase px-3 py-1 rounded-bl-xl tracking-widest">Recomendado</div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                            <i class="fas fa-key text-sm"></i>
                        </div>
                        <h4 class="text-white font-bold text-sm">Licencia Oficial / Activación API</h4>
                    </div>
                    <ul class="space-y-3 text-xs text-gray-300">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-amber-500 text-[10px]"></i> Código 100% original con clave</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-amber-500 text-[10px]"></i> Actualizaciones automáticas en 1-clic</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-amber-500 text-[10px]"></i> Acceso a bibliotecas y templates de la nube</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-amber-500 text-[10px]"></i> Soporte y garantía oficial de GPLWolf</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <h3 class="text-2xl font-black text-white text-left tracking-tight mb-8 flex items-center gap-3">
            <i class="fas fa-key text-amber-500"></i> Licencias Oficiales Disponibles
        </h3>

        @if($products->isEmpty())
            <div class="py-16 text-center bg-[#0a0a0c] border border-white/[0.06] rounded-[32px] max-w-xl mx-auto">
                <i class="fas fa-folder-open text-gray-600 text-4xl mb-4"></i>
                <p class="text-gray-400 font-bold">No hay licencias oficiales disponibles de momento.</p>
                <p class="text-gray-600 text-xs mt-1">Estamos negociando nuevas alianzas, regresa pronto.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="group relative bg-[#0a0a0c] border border-white/[0.06] hover:border-amber-500/40 rounded-[32px] p-6 flex flex-col justify-between transition-all duration-500 hover:shadow-[0_0_30px_rgba(245,158,11,0.05)] cursor-pointer block">
                    <div>
                        <!-- Image & Badges -->
                        <div class="relative w-full aspect-video rounded-2xl bg-zinc-950/50 border border-white/5 overflow-hidden mb-6 flex items-center justify-center">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <i class="fas {{ $product->type === 'theme' ? 'fa-palette' : 'fa-plug' }} text-4xl text-gray-700"></i>
                            @endif
                            <div class="absolute top-3 left-3 bg-amber-500 text-black text-[9px] font-black uppercase px-2.5 py-1 rounded-xl shadow-lg leading-none border border-amber-400/20">
                                Licencia Oficial
                            </div>
                        </div>

                        <!-- Product details -->
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">{{ $product->type }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-white/10"></span>
                            <span class="text-[9px] text-gray-500 font-mono">v{{ $product->version }}</span>
                        </div>

                        <h3 class="text-white font-bold text-lg leading-snug line-clamp-1 group-hover:text-amber-500 transition-colors">
                            {{ $product->name }}
                        </h3>
                        <p class="text-gray-500 text-xs mt-2 line-clamp-2 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    <!-- Footer Details & Buy -->
                    <div class="border-t border-white/5 pt-4 mt-6 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] text-gray-600 block uppercase tracking-wider">Pago único</span>
                            <span class="text-xl font-black text-white">${{ number_format($product->price, 2) }}</span>
                        </div>

                        <form action="{{ route('cart.add', $product) }}" method="POST" class="inline" onclick="event.stopPropagation();">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-black rounded-xl text-xs font-black uppercase tracking-wider transition-all shadow-lg shadow-amber-500/10 flex items-center gap-1.5">
                                <i class="fas fa-shopping-cart text-[10px]"></i> Comprar
                            </button>
                        </form>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
