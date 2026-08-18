@extends('layouts.frontend')

@section('title', 'Resultados de búsqueda para: ' . $query)

@section('content')
<div class="min-h-screen bg-[#0a0a0b] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search Header -->
        <div class="mb-12">
            <h1 class="text-3xl md:text-4xl font-black text-white mb-4">
                Resultados para <span class="text-[#FF2121]">"{{ $query }}"</span>
            </h1>
            <p class="text-gray-400">
                Se han encontrado {{ $products->total() }} productos que coinciden con tu búsqueda.
            </p>
        </div>

        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group relative bg-[#121214] border border-white/5 rounded-2xl overflow-hidden hover:border-[#FF2121]/30 transition-all duration-300">
                        <!-- Thumbnail -->
                        <div class="aspect-video relative overflow-hidden">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-900">
                                    <i class="fas fa-image text-3xl text-gray-700"></i>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5 items-start">
                                @if($product->badge)
                                    @php
                                        $badges = [
                                            'Más Vendido' => ['color' => 'amber', 'icon' => 'fa-crown'],
                                            'Mas Vendido' => ['color' => 'amber', 'icon' => 'fa-crown'],
                                            'Trending' => ['color' => 'rose', 'icon' => 'fa-fire'],
                                            'Popular' => ['color' => 'blue', 'icon' => 'fa-star'],
                                            'Nuevo' => ['color' => 'emerald', 'icon' => 'fa-bolt'],
                                            'Nuevo Producto' => ['color' => 'emerald', 'icon' => 'fa-bolt'],
                                            'Licencia' => ['color' => 'yellow', 'icon' => 'fa-key'],
                                        ];
                                        $badgeData = $badges[$product->badge] ?? ['color' => 'gray', 'icon' => 'fa-tag'];
                                        $color = $badgeData['color'];
                                        $icon = $badgeData['icon'];
                                    @endphp
                                    <span class="flex items-center gap-1.5 text-[9px] font-black text-{{ $color }}-400 bg-gray-900/90 backdrop-blur-md px-2.5 py-1 rounded-xl shadow-lg uppercase tracking-wider border border-{{ $color }}-500/50 shadow-black/50 leading-none">
                                        <i class="fas {{ $icon }} text-[8px]"></i>
                                        {{ $product->badge }}
                                    </span>
                                @endif

                                @if($product->is_recently_updated)
                                    <x-badge-updated size="xs" />
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                                <span>{{ $product->category->name }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-700"></span>
                                <span>v{{ $product->version }}</span>
                            </div>
                            
                            <h3 class="text-white font-bold mb-3 group-hover:text-[#FF2121] transition-colors line-clamp-1">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="flex items-center justify-between">
                                <div class="text-xl font-black text-white">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="px-4 py-2 bg-[#F51B1B] hover:bg-[#F51B1B] text-white text-xs font-bold rounded-lg transition-colors">
                                    Ver Detalle
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->appends(['q' => $query])->links() }}
            </div>
        @else
            <!-- No Results State -->
            <div class="py-20 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-900 mb-6">
                    <i class="fas fa-search-minus text-4xl text-gray-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">No encontramos lo que buscas</h2>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">
                    Intenta buscar con otros términos o explora nuestras categorías principales.
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#F51B1B] hover:bg-[#F51B1B] text-white font-bold rounded-xl transition-all">
                    <i class="fas fa-home"></i>
                    Volver al Inicio
                </a>
            </div>
        @endif
    </div>
</div>

<style>
@keyframes shimmer {
    100% { left: 200%; }
}
.animate-spin-slow {
    animation: spin 3s linear infinite;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection