@forelse($updates as $update)
    <div class="update-item p-5 md:p-6 flex flex-col md:flex-row items-center justify-between gap-5 transition-all duration-300 hover:bg-white/[0.02] group border-b border-white/[0.04] last:border-0" data-id="{{ $update->id }}">
        <div class="flex flex-col md:flex-row items-center gap-5 w-full">
            <!-- Product Thumbnail -->
            <div class="w-14 h-14 bg-[#111111] rounded-xl border border-white/10 flex items-center justify-center relative overflow-hidden flex-shrink-0">
                @if($update->product->thumbnail)
                    <img src="{{ asset('storage/' . $update->product->thumbnail) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <i class="fab fa-wordpress text-xl text-[#FF2121]"></i>
                @endif
            </div>

            <!-- Content Area -->
            <div class="flex-1 text-center md:text-left min-w-0">
                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3 mb-2">
                    <h4 class="text-white font-black text-base md:text-lg group-hover:text-[#FF2121] transition-colors truncate">
                        {{ $update->product->name }}
                    </h4>
                    <span class="inline-flex items-center px-2.5 py-1 bg-[#FF2121]/10 text-[#FF2121] text-[10px] font-black uppercase rounded-lg border border-[#FF2121]/20 w-fit mx-auto md:mx-0">
                        v{{ $update->version_number }}
                    </span>
                </div>
                
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt text-[#FF2121]/50"></i> {{ $update->released_at ? $update->released_at->diffForHumans() : $update->created_at->diffForHumans() }}</span>
                    <span class="w-1 h-1 bg-white/10 rounded-full"></span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-tag text-[#FF2121]/50"></i> {{ $update->product->type === 'theme' ? 'Tema' : 'Plugin' }}</span>
                    <span class="w-1 h-1 bg-white/10 rounded-full hidden md:inline"></span>
                    <span class="hidden md:flex items-center gap-1.5 text-emerald-400/80 line-clamp-1 max-w-xs">
                        <i class="fas fa-check text-emerald-500/50"></i> {!! strip_tags(Str::limit($update->changelog, 60)) !!}
                    </span>
                </div>
            </div>

            <!-- Action Area -->
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('products.show', $update->product->slug) }}" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-black text-gray-400 hover:text-white uppercase tracking-wider transition-all">
                    Ver Detalles
                </a>
                
                @php
                    $userHasProduct = auth()->check() && in_array($update->product->id, $purchasedProductIds ?? []);
                @endphp

                @if($userHasProduct)
                    <a href="{{ route('version.download', $update->id) }}" class="w-9 h-9 gradient-bg rounded-xl flex items-center justify-center text-white hover:scale-105 active:scale-95 transition-all" title="Descargar Actualización">
                        <i class="fas fa-arrow-down text-xs"></i>
                    </a>
                @else
                    <a href="{{ route('products.show', $update->product->slug) }}" class="w-9 h-9 bg-[#111111] border border-white/10 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:border-[#FF2121]/50 hover:bg-[#F51B1B] transition-all" title="Comprar para descargar">
                        <i class="fas fa-shopping-cart text-xs"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="p-16 md:p-24 text-center">
        <div class="w-16 h-16 bg-[#111111] border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-history text-2xl text-gray-600"></i>
        </div>
        <p class="text-gray-400 font-bold text-sm mb-1">No hay actualizaciones registradas aún.</p>
        <p class="text-gray-600 text-xs">Vuelve pronto para ver las últimas versiones.</p>
    </div>
@endforelse