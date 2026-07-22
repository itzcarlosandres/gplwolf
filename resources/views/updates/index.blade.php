@extends('layouts.frontend')

@section('title', 'Últimas Actualizaciones - WP Marketplace')

@section('content')
<section class="relative py-16 md:py-20 overflow-hidden min-h-screen bg-[#080808]">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 -z-10 w-[500px] h-[500px] bg-[#FF2121]/5 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -z-10 w-[400px] h-[400px] bg-[#FF2121]/5 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-full mb-4">
                    <span class="w-1.5 h-1.5 bg-[#FF2121] rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-[#FF2121]">Monitoreo en tiempo real</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-2">
                    Últimas <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF2121] to-[#F51B1B]">Actualizaciones</span>
                </h1>
                <p class="text-gray-500 text-sm font-medium">Mantén tus proyectos al día con las versiones más recientes.</p>
            </div>
            
            <a href="{{ route('membership.pricing') }}" class="shrink-0 inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-amber-500/10 to-yellow-500/10 border border-amber-500/20 rounded-xl hover:border-amber-500/40 transition-all group">
                <i class="fas fa-crown text-amber-400 text-sm"></i>
                <span class="text-xs font-black text-white">Membresía desde $6.99/mes</span>
                <i class="fas fa-arrow-right text-amber-400 text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Updates List -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden shadow-xl shadow-black/20">
            <div id="updates-list">
                @include('updates.partials.list', ['updates' => $updates])
            </div>
        </div>

        <!-- Load More Section -->
        @if($updates->hasMorePages())
            <div class="text-center mt-8">
                <button id="load-more" data-url="{{ $updates->nextPageUrl() }}" class="px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#FF2121]/30 rounded-xl text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition-all active:scale-95 group">
                    <span class="group-hover:tracking-[0.2em] transition-all duration-300">Cargar más historial</span>
                    <i class="fas fa-spinner fa-spin ml-2 hidden" id="loader"></i>
                </button>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more');
        const updatesList = document.getElementById('updates-list');
        const loader = document.getElementById('loader');

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                
                loader.classList.remove('hidden');
                this.disabled = true;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const temp = document.createElement('div');
                    temp.innerHTML = html;
                    
                    const newItems = temp.querySelectorAll('.update-item');
                    newItems.forEach(item => {
                        updatesList.appendChild(item);
                    });

                    const urlObj = new URL(url);
                    const currentPage = parseInt(urlObj.searchParams.get('page'));
                    urlObj.searchParams.set('page', currentPage + 1);
                    const nextUrl = urlObj.toString();
                    
                    this.setAttribute('data-url', nextUrl);
                    
                    if (newItems.length < 10) {
                        this.parentElement.remove();
                    }

                    loader.classList.add('hidden');
                    this.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading more updates:', error);
                    loader.classList.add('hidden');
                    this.disabled = false;
                });
            });
        }
    });
</script>
@endpush