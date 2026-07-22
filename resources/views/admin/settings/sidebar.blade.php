@extends('layouts.admin')

@section('title', 'Configuración de Sidebar')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-white">Configuración de Sidebar</h1>
            <p class="text-gray-500 text-sm mt-1">Personaliza la barra lateral de los listados de productos.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Form settings -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-10 rounded-[40px] border border-white/5 shadow-2xl">
            <form action="{{ route('admin.settings.sidebar.update') }}" method="POST" class="space-y-8">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4 ml-1">Título de la Sección</label>
                    <input type="text" name="sidebar_title" value="{{ $settings['sidebar_title'] ?? 'Top Popular' }}" required
                        class="w-full bg-gray-900 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-bold">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4 ml-1">Tipo de Listado</label>
                    <select name="sidebar_type" class="w-full bg-gray-900 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-bold appearance-none">
                        <option value="popular" {{ ($settings['sidebar_type'] ?? '') == 'popular' ? 'selected' : '' }}>Más Populares (Descargas)</option>
                        <option value="best_seller" {{ ($settings['sidebar_type'] ?? '') == 'best_seller' ? 'selected' : '' }}>Más Vendidos (Badge: Más Vendido)</option>
                        <option value="top_rated" {{ ($settings['sidebar_type'] ?? '') == 'top_rated' ? 'selected' : '' }}>Mejor Valorados (Trending)</option>
                        <option value="most_viewed" {{ ($settings['sidebar_type'] ?? '') == 'most_viewed' ? 'selected' : '' }}>Más Vistos</option>
                        <option value="recent" {{ ($settings['sidebar_type'] ?? '') == 'recent' ? 'selected' : '' }}>Nuevos Lanzamientos</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4 ml-1">Cantidad a Mostrar (Límite)</label>
                    <input type="number" name="sidebar_limit" value="{{ $settings['sidebar_limit'] ?? 5 }}" min="1" max="10" required
                        class="w-full bg-gray-900 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121] transition-all font-bold">
                </div>

                <button type="submit" class="w-full py-5 gradient-bg text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-[#F51B1B]/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Guardar Cambios <i class="fas fa-save ml-2"></i>
                </button>
            </form>
        </div>

        <!-- Preview Mockup -->
        <div class="space-y-6">
            <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Vista Previa (Concepto)</h4>
            <div class="bg-gray-800/20 border border-white/5 rounded-[40px] p-8">
                <div class="space-y-6">
                    <h4 class="text-sm font-black text-white uppercase tracking-[0.2em] pb-4 border-b border-white/5 flex items-center gap-3">
                        <div class="w-2 h-2 bg-[#FF2121] rounded-full animate-pulse"></div>
                        {{ $settings['sidebar_title'] ?? 'Top Popular' }}
                    </h4>
                    
                    @for($i = 1; $i <= 3; $i++)
                    <div class="flex items-center gap-4 group">
                        <div class="w-12 h-12 bg-gray-900 rounded-xl border border-white/5 flex items-center justify-center text-lg font-black text-gray-700">
                            {{ $i }}
                        </div>
                        <div class="flex-1">
                            <div class="h-4 bg-white/5 rounded-full w-3/4 mb-2"></div>
                            <div class="h-2 bg-white/5 rounded-full w-1/2"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection