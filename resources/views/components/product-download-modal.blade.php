@props(['product', 'modalId' => null])

@php
    $modalId = $modalId ?? ('download-modal-' . $product->id);
    $files = $product->getDownloadFiles();
@endphp

@if(count($files) > 1)
<div x-data="{ open: false }" 
     @open-download-modal-{{ $product->id }}.window="open = true"
     @keydown.escape.window="open = false"
     class="relative">
    
    <!-- Modal Backdrop & Dialog -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         style="display: none;">
        
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-black/80 backdrop-blur-md transition-opacity" @click="open = false"></div>

        <!-- Modal Content Box -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative w-full max-w-lg bg-[#0d0d0f] border border-white/15 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/80 overflow-hidden z-10">
            
            <!-- Neon Glow Background Accent -->
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-[#FF2121]/15 blur-3xl rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-emerald-500/10 blur-3xl rounded-full pointer-events-none"></div>

            <!-- Header -->
            <div class="flex items-start justify-between mb-6 pb-4 border-b border-white/10 relative z-10">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-lg shadow-emerald-500/10">
                        <i class="fas fa-cloud-arrow-down text-xl"></i>
                    </div>
                    <div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-[#FF2121] bg-[#FF2121]/10 px-2 py-0.5 rounded border border-[#FF2121]/20 inline-block mb-1">
                            Seleccionar Descarga
                        </span>
                        <h3 class="text-lg font-black text-white leading-tight line-clamp-1">
                            {{ $product->name }}
                        </h3>
                        <p class="text-xs text-gray-400 font-medium mt-0.5">
                            Versión actual: <span class="text-emerald-400 font-bold">v{{ $product->version ?? '1.0.0' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Close Button -->
                <button @click="open = false" 
                        type="button"
                        class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white border border-white/10 flex items-center justify-center transition-all">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <!-- Download Options List -->
            <div class="space-y-3.5 relative z-10">
                @foreach($files as $index => $file)
                    <div class="group bg-white/[0.03] hover:bg-white/[0.07] border border-white/10 hover:border-white/20 rounded-2xl p-4 sm:p-4.5 transition-all duration-300 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-11 h-11 rounded-xl {{ $file['type'] === 'main' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }} border flex items-center justify-center shrink-0 shadow-inner group-hover:scale-105 transition-transform">
                                <i class="fas {{ $file['icon'] }} text-lg"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                    <span class="text-xs font-bold text-white group-hover:text-emerald-400 transition-colors">
                                        {{ $file['title'] }}
                                    </span>
                                    <span class="text-[8px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded border {{ $file['badge_color'] }}">
                                        {{ $file['badge'] }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-gray-400 truncate">
                                    {{ $file['subtitle'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Download Action Button -->
                        <a href="{{ $file['download_url'] }}" 
                           @click="setTimeout(() => open = false, 1500)"
                           class="shrink-0 px-4 py-2.5 {{ $file['type'] === 'main' ? 'bg-emerald-600 hover:bg-emerald-500 shadow-emerald-600/20' : 'bg-amber-500 hover:bg-amber-400 text-gray-950 shadow-amber-500/20' }} text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-lg hover:scale-105 active:scale-95 flex items-center gap-1.5 font-sans">
                            <i class="fas fa-download text-[10px]"></i>
                            <span>Descargar</span>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Footer Note -->
            <div class="mt-6 pt-4 border-t border-white/5 text-center text-[10px] text-gray-500 font-medium">
                <i class="fas fa-shield-halved text-emerald-400 mr-1"></i>
                Descargas 100% libres de virus, código original verificado.
            </div>
        </div>
    </div>
</div>
@endif
