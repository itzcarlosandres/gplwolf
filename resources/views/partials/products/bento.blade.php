<!-- ==============================================
     BENTO GRID — Premium Mixed Layout
     ============================================== -->
@php
    $total = $products->count();
    $featuredCount = min(2, $total);
    $remainingCount = max(0, $total - $featuredCount);
    $featured = $products->take($featuredCount);
    $remaining = $products->skip($featuredCount)->take($remainingCount);
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <!-- Featured large cards (2 cols each) -->
    @foreach($featured as $p)
    <div class="bento-card md:col-span-2 rounded-2xl overflow-hidden group">
        <a href="{{ route('products.show', $p->slug) }}" class="block">
            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-[#FF2121]/30 to-[#F51B1B]/20">
                @if($p->thumbnail)
                    <img src="{{ asset('storage/' . $p->thumbnail) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d1425] via-[#0d1425]/40 to-transparent"></div>
                <div class="absolute top-3 left-3 flex items-center gap-2">
                    <span class="px-2.5 py-1 bg-gray-900/90 backdrop-blur-md rounded-lg text-[9px] font-black uppercase tracking-wider text-white border border-white/20 shadow-md">{{ $p->type }}</span>
                    @if($p->badge)
                    @php
                        $badgeBg = match($p->badge) {
                            'Más Vendido' => 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-500/30 border-amber-300/40',
                            'Trending' => 'bg-gradient-to-r from-rose-500 to-pink-600 shadow-rose-500/30 border-rose-400/40',
                            'Popular' => 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-blue-500/30 border-blue-400/40',
                            default => 'bg-gradient-to-r from-[#FF2121] to-[#F51B1B] shadow-[#FF2121]/40 border-red-400/40',
                        };
                    @endphp
                    <span class="px-2.5 py-1 {{ $badgeBg }} backdrop-blur-md rounded-lg text-[9px] font-black uppercase tracking-wider text-white border shadow-lg">{{ $p->badge }}</span>
                    @endif
                    @if($p->is_recently_updated)
                        <x-badge-updated size="xs" />
                    @endif
                </div>
            </div>
            <div class="p-5">
                <h3 class="text-white font-bold text-lg mb-1 line-clamp-1 group-hover:text-[#FF2121] transition-colors">{{ $p->name }}</h3>
                <div class="flex items-center gap-3 text-[11px] text-gray-500 mb-4">
                    <div class="flex items-center gap-1 text-emerald-400 font-bold bg-emerald-500/10 border border-emerald-500/20 px-1.5 py-0.5 rounded text-[9px]">
                        <i class="fas fa-code-branch text-[8px]"></i>
                        <span>v{{ $p->version }}</span>
                    </div>
                    <span>•</span>
                    <span>{{ number_format($p->downloads_count) }} downloads</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-black text-white">${{ number_format($p->price, 2) }}</span>
                    <span class="px-4 py-2 bg-[#FF2121]/10 border border-[#FF2121]/30 rounded-lg text-[#FF2121] text-[10px] font-black uppercase tracking-wider">
                        Ver detalles
                    </span>
                </div>
            </div>
        </a>
    </div>
    @endforeach

    <!-- Small cards (1 col each) -->
    @foreach($remaining as $p)
    <div class="bento-card rounded-2xl overflow-hidden group">
        <a href="{{ route('products.show', $p->slug) }}" class="block">
            <div class="relative h-32 overflow-hidden bg-gradient-to-br from-[#FF2121]/30 to-[#F51B1B]/20">
                @if($p->thumbnail)
                    <img src="{{ asset('storage/' . $p->thumbnail) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d1425] to-transparent"></div>
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-gray-900/90 backdrop-blur-md rounded-md text-[8px] font-black uppercase tracking-wider text-white border border-white/20 shadow-md">{{ $p->type }}</div>
            </div>
            <div class="p-4">
                <h3 class="text-white font-bold text-sm leading-tight mb-2 line-clamp-2 group-hover:text-[#FF2121] transition-colors">{{ $p->name }}</h3>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-black text-white">${{ number_format($p->price, 2) }}</span>
                    <div class="flex items-center gap-1 text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-1.5 py-0.5 rounded text-[9px] font-bold">
                        <i class="fas fa-code-branch text-[8px]"></i>
                        <span>v{{ $p->version }}</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@if($remainingCount === 0 && $featuredCount > 0)
    <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach($featured as $p)
        <div class="bento-card rounded-2xl overflow-hidden group md:hidden">
            <a href="{{ route('products.show', $p->slug) }}" class="block">
                <div class="relative h-32 overflow-hidden bg-gradient-to-br from-[#FF2121]/30 to-[#F51B1B]/20">
                    @if($p->thumbnail)
                        <img src="{{ asset('storage/' . $p->thumbnail) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d1425] to-transparent"></div>
                    <div class="absolute top-2 left-2 px-2 py-0.5 bg-gray-900/90 backdrop-blur-md rounded-md text-[8px] font-black uppercase tracking-wider text-white border border-white/20 shadow-md">{{ $p->type }}</div>
                </div>
                <div class="p-4">
                    <h3 class="text-white font-bold text-sm leading-tight mb-2 line-clamp-2 group-hover:text-[#FF2121] transition-colors">{{ $p->name }}</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-black text-white">${{ number_format($p->price, 2) }}</span>
                        <div class="flex items-center gap-1 text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-1.5 py-0.5 rounded text-[9px] font-bold">
                            <i class="fas fa-code-branch text-[8px]"></i>
                            <span>v{{ $p->version }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
@endif