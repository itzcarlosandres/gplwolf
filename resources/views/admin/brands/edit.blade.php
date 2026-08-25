@extends('layouts.admin')

@section('title', 'Editar: ' . $brand->name)

@section('content')
<div class="max-w-3xl" x-data="{ isPromo: {{ old('is_promo', $brand->is_promo ? 1 : 0) ? 'true' : 'false' }} }">
    <div class="mb-8">
        <a href="{{ route('admin.brands.index') }}" class="text-xs text-gray-500 hover:text-white flex items-center gap-1.5 mb-2 transition-colors">
            <i class="fas fa-arrow-left text-[10px]"></i> Volver a Marcas & Anuncios
        </a>
        <h1 class="text-2xl font-black text-white tracking-tight">Editar: {{ $brand->name }}</h1>
        <p class="text-gray-500 text-sm mt-1">Modifica los detalles, tipo o enlaces de este elemento en el carrusel.</p>
    </div>

    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6 sm:p-8 space-y-6 shadow-2xl">
        @csrf
        @method('PUT')

        {{-- Type Selector --}}
        <div class="p-4 rounded-xl bg-[#0d0d0d] border border-white/5 space-y-3">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Tipo de Elemento</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="relative flex items-center p-3.5 rounded-xl border cursor-pointer transition-all"
                       :class="!isPromo ? 'bg-white/10 border-white/30 text-white' : 'bg-white/[0.02] border-white/5 text-gray-400 hover:bg-white/[0.04]'">
                    <input type="radio" name="is_promo" value="0" x-model="isPromo" :value="false" class="sr-only">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm" :class="!isPromo ? 'text-white' : 'text-gray-500'">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div>
                            <div class="text-xs font-black">Marca de Confianza</div>
                            <div class="text-[10px] text-gray-500">Logo e icono estándar (WooCommerce, Elementor, etc.)</div>
                        </div>
                    </div>
                </label>

                <label class="relative flex items-center p-3.5 rounded-xl border cursor-pointer transition-all"
                       :class="isPromo ? 'bg-amber-500/15 border-amber-500/40 text-amber-300' : 'bg-white/[0.02] border-white/5 text-gray-400 hover:bg-white/[0.04]'">
                    <input type="radio" name="is_promo" value="1" x-model="isPromo" :value="true" class="sr-only">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center text-sm text-amber-400">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <div class="text-xs font-black">Anuncio / Promoción</div>
                            <div class="text-[10px] text-gray-500">Tarjeta destacada con badge y enlace (Trial 7 Días, Ofertas)</div>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Basic Fields --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest" x-text="isPromo ? 'Texto / Título de la Promoción *' : 'Nombre de la Marca *'">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $brand->name) }}" required 
                       :placeholder="isPromo ? 'ej. ⚡ Prueba 7 Días Gratis — 3 Descargas/Día' : 'ej. Elementor Pro'"
                       class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 transition-all">
                @error('name')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Icono (Clase FontAwesome)</label>
                <input type="text" name="icon" value="{{ old('icon', $brand->icon) }}" placeholder="fas fa-cube o fas fa-bolt" 
                       class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 transition-all">
                @error('icon')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Promo Specific Fields --}}
        <div class="space-y-6 pt-2 border-t border-white/[0.04]" x-show="isPromo" x-transition>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-amber-400 uppercase tracking-widest">Enlace de Destino (URL)</label>
                    <input type="text" name="link_url" value="{{ old('link_url', $brand->link_url) }}" 
                           placeholder="ej. /membresias/prueba-gratis o https://..." 
                           class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 transition-all">
                    <p class="text-[10px] text-gray-500">Al hacer clic en el anuncio, el visitante será dirigido a este enlace.</p>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-amber-400 uppercase tracking-widest">Texto del Badge (Opcional)</label>
                    <input type="text" name="badge_text" value="{{ old('badge_text', $brand->badge_text) }}" 
                           placeholder="ej. ⚡ TRIAL 7 DÍAS o 🔥 50% OFF" 
                           class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Color de Resalte</label>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                    @foreach(['amber' => 'Ámbar / Dorado', 'red' => 'Rojo Brillante', 'emerald' => 'Verde Éxito', 'blue' => 'Azul Pro', 'purple' => 'Púrpura VIP'] as $colorKey => $colorName)
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-white/10 bg-[#0d0d0d] cursor-pointer hover:border-white/30 transition-all text-xs font-bold">
                            <input type="radio" name="highlight_color" value="{{ $colorKey }}" {{ old('highlight_color', $brand->highlight_color ?? 'amber') === $colorKey ? 'checked' : '' }} class="text-[#FF2121] focus:ring-0">
                            <span class="text-gray-300 text-[11px]">{{ $colorName }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Status & Order --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-white/[0.04]">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Orden de Aparición</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $brand->sort_order) }}" min="0" 
                       class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 transition-all">
                @error('sort_order')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 h-full pt-6">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-[#0d0d0d] border border-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    <span class="ml-3 text-xs font-bold text-white">Activo en la Home</span>
                </label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-6 border-t border-white/[0.06]">
            <a href="{{ route('admin.brands.index') }}" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm font-bold text-gray-300 transition-all">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-sm font-black transition-all shadow-lg shadow-[#F51B1B]/20">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection