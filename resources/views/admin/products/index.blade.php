@extends('layouts.admin')

@section('title', 'Gestión de Productos')

@section('content')
<!-- Header -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Gestión de Productos</h1>
        <p class="text-gray-500 text-sm mt-1">Administra themes, plugins y recursos digitales.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.updates.manager') }}" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-emerald-500/30 rounded-xl text-xs font-black text-gray-300 hover:text-white transition-all flex items-center gap-2">
            <i class="fas fa-rocket text-emerald-500"></i> Lanzar Versión
        </a>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
            <i class="fas fa-plus"></i> Nuevo Producto
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#111111] border border-white/5 rounded-2xl p-4">
        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Total</div>
        <div class="text-2xl font-black text-white">{{ $products->total() }}</div>
    </div>
    <div class="bg-[#111111] border border-white/5 rounded-2xl p-4">
        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Activos</div>
        <div class="text-2xl font-black text-emerald-400">{{ \App\Models\Product::where('is_active', true)->count() }}</div>
    </div>
    <div class="bg-[#111111] border border-white/5 rounded-2xl p-4">
        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Gratis</div>
        <div class="text-2xl font-black text-[#FF2121]">{{ \App\Models\Product::where('price', 0)->count() }}</div>
    </div>
    <div class="bg-[#111111] border border-white/5 rounded-2xl p-4">
        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Descargas</div>
        <div class="text-2xl font-black text-white">{{ number_format(\App\Models\Product::sum('downloads_count')) }}</div>
    </div>
</div>

<!-- Filters Bar -->
<div class="bg-[#111111] border border-white/5 rounded-2xl p-4 mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..." class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl pl-9 pr-4 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
        </div>
        <div class="flex gap-3">
            <select name="type" class="bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-[#FF2121]/50 transition-all min-w-[130px]">
                <option value="" class="bg-[#0d0d0d]">Todos los tipos</option>
                <option value="theme" {{ request('type') == 'theme' ? 'selected' : '' }} class="bg-[#0d0d0d]">Theme</option>
                <option value="plugin" {{ request('type') == 'plugin' ? 'selected' : '' }} class="bg-[#0d0d0d]">Plugin</option>
                <option value="gpl" {{ request('type') == 'gpl' ? 'selected' : '' }} class="bg-[#0d0d0d]">GPL</option>
                <option value="premium" {{ request('type') == 'premium' ? 'selected' : '' }} class="bg-[#0d0d0d]">Premium</option>
            </select>
            <select name="status" class="bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-[#FF2121]/50 transition-all min-w-[130px]">
                <option value="" class="bg-[#0d0d0d]">Todos los estados</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }} class="bg-[#0d0d0d]">Activo</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }} class="bg-[#0d0d0d]">Inactivo</option>
            </select>
            <button type="submit" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-gray-300 hover:text-white transition-all text-sm font-bold">
                <i class="fas fa-filter mr-1"></i> Filtrar
            </button>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4 font-black">Producto</th>
                    <th class="px-6 py-4 font-black">Categoría</th>
                    <th class="px-6 py-4 text-center font-black">Precio</th>
                    <th class="px-6 py-4 text-center font-black">Versión</th>
                    <th class="px-6 py-4 text-center font-black">Estado</th>
                    <th class="px-6 py-4 text-right font-black">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($products as $product)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-[#0d0d0d] border border-white/10 rounded-xl flex items-center justify-center text-[#FF2121] font-bold shrink-0">
                                    @if($product->thumbnail)
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-xl">
                                    @else
                                        {{ substr($product->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-white group-hover:text-[#FF2121] transition-colors flex items-center gap-2">
                                        <span>{{ $product->name }}</span>
                                        @if($product->is_best_seller)
                                            <span class="px-1.5 py-0.5 bg-amber-500/20 border border-amber-500/40 text-amber-400 text-[9px] font-black rounded uppercase tracking-wider shrink-0" title="Destacado en Más Comprados">🔥 Más Comprado</span>
                                        @endif
                                        @if($product->is_popular)
                                            <span class="px-1.5 py-0.5 bg-sky-500/20 border border-sky-500/40 text-sky-400 text-[9px] font-black rounded uppercase tracking-wider shrink-0" title="Destacado en Populares">⭐ Popular</span>
                                        @endif
                                    </div>
                                    <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wider flex items-center mt-0.5">
                                        <i class="fas fa-download mr-1.5"></i> {{ number_format($product->downloads_count) }} descargas
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-white/5 border border-white/10 rounded-lg text-xs font-bold text-gray-300 uppercase tracking-wide">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-bold font-mono">
                            @if($product->price == 0)
                                <span class="text-emerald-400">FREE</span>
                            @else
                                <span class="text-white">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 rounded-lg bg-[#0d0d0d] border border-white/10 text-[10px] font-mono font-bold text-gray-400">{{ $product->version ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Activo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.products.show', $product) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all" title="Ver Detalles">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>

                                <!-- Quick Toggle: Más Comprado -->
                                <form action="{{ route('admin.products.toggle-best-seller', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all {{ $product->is_best_seller ? 'text-amber-400 bg-amber-500/20 border border-amber-500/40' : 'text-gray-500 hover:text-amber-400 hover:bg-amber-500/10' }}" title="{{ $product->is_best_seller ? 'Desmarcar Más Comprado' : 'Marcar como Más Comprado' }}">
                                        <i class="fas fa-fire text-xs"></i>
                                    </button>
                                </form>

                                <!-- Quick Toggle: Popular -->
                                <form action="{{ route('admin.products.toggle-popular', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all {{ $product->is_popular ? 'text-sky-400 bg-sky-500/20 border border-sky-500/40' : 'text-gray-500 hover:text-sky-400 hover:bg-sky-500/10' }}" title="{{ $product->is_popular ? 'Desmarcar Popular' : 'Marcar como Popular' }}">
                                        <i class="fas fa-star text-xs"></i>
                                    </button>
                                </form>

                                <a href="{{ route('admin.products.edit', $product) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all" title="Eliminar">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center text-gray-500">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fas fa-box-open text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">No hay productos</p>
                                <p class="text-sm text-gray-600 mt-1">Crea tu primer producto para empezar.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="px-6 py-4 bg-[#0d0d0d]/30 border-t border-white/5">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection