@extends('layouts.admin')

@section('title', 'Configuración del Top Bar')

@section('content')
<div class="max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-white mb-2">Top Bar Promocional</h1>
        <p class="text-gray-400 text-sm">Configura el banner superior para anunciar promociones, cupones o noticias importantes.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm font-bold">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.topbar.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Activar/Desactivar -->
        <div class="glass p-8 rounded-[32px] border-white/5">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Activar Top Bar</h3>
                    <p class="text-sm text-gray-400">Mostrar el banner promocional en todas las páginas</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="topbar_enabled" value="1" {{ ($settings['topbar_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-14 h-7 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#F51B1B] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#F51B1B]"></div>
                </label>
            </div>
        </div>

        <!-- Texto del Banner -->
        <div class="glass p-8 rounded-[32px] border-white/5">
            <label class="block text-sm font-black text-white uppercase tracking-[0.2em] mb-4">Texto del Banner</label>
            <input type="text" name="topbar_text" value="{{ old('topbar_text', $settings['topbar_text'] ?? '') }}" 
                   placeholder="🎉 Usa el cupón WELCOME20 y obtén 20% de descuento"
                   class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-medium"
                   required>
            <p class="mt-2 text-xs text-gray-500">Usa emojis para hacerlo más atractivo 🎉 🔥 ⚡</p>
        </div>

        <!-- Enlace (Opcional) -->
        <div class="glass p-8 rounded-[32px] border-white/5">
            <label class="block text-sm font-black text-white uppercase tracking-[0.2em] mb-4">Enlace del Botón (Opcional)</label>
            <input type="text" name="topbar_link" value="{{ old('topbar_link', $settings['topbar_link'] ?? '') }}" 
                   placeholder="/checkout o https://ejemplo.com"
                   class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-medium">
            <p class="mt-2 text-xs text-gray-500">Deja vacío si no quieres mostrar un botón</p>
        </div>

        <!-- Texto del Botón -->
        <div class="glass p-8 rounded-[32px] border-white/5">
            <label class="block text-sm font-black text-white uppercase tracking-[0.2em] mb-4">Texto del Botón (Opcional)</label>
            <input type="text" name="topbar_link_text" value="{{ old('topbar_link_text', $settings['topbar_link_text'] ?? '') }}" 
                   placeholder="Comprar Ahora"
                   class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-medium">
        </div>

        <!-- Color de Fondo -->
        <div class="glass p-8 rounded-[32px] border-white/5">
            <label class="block text-sm font-black text-white uppercase tracking-[0.2em] mb-4">Color de Fondo</label>
            <div class="flex items-center gap-4">
                <input type="color" name="topbar_bg_color" value="{{ $settings['topbar_bg_color'] ?? '#FF2121' }}" 
                       class="w-20 h-12 rounded-xl cursor-pointer border-2 border-white/10"
                       required>
                <div class="flex-1">
                    <p class="text-sm text-gray-400">Selecciona el color de fondo del top bar</p>
                    <p class="text-xs text-gray-600 mt-1">Colores sugeridos: Azul (#FF2121), Verde (#10b981), Rojo (#ef4444)</p>
                </div>
            </div>
        </div>

        <!-- Vista Previa -->
        <div class="glass p-8 rounded-[32px] border-white/5">
            <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] mb-4">Vista Previa</h3>
            <div class="relative overflow-hidden rounded-2xl py-4 text-white text-center" 
                 style="background: linear-gradient(135deg, {{ $settings['topbar_bg_color'] ?? '#FF2121' }} 0%, {{ $settings['topbar_bg_color'] ?? '#F51B1B' }}dd 100%);">
                <div class="flex items-center justify-center gap-3">
                    <span class="text-sm font-bold">{{ $settings['topbar_text'] ?? 'Tu mensaje aquí' }}</span>
                    @if(($settings['topbar_link'] ?? '') && ($settings['topbar_link_text'] ?? ''))
                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-black uppercase">
                        {{ $settings['topbar_link_text'] }} →
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 py-4 gradient-bg text-white font-black uppercase tracking-widest rounded-2xl hover:opacity-90 transition-all shadow-xl shadow-[#F51B1B]/20">
                Guardar Cambios
            </button>
            <a href="{{ route('admin.dashboard') }}" class="px-8 py-4 glass text-white font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection