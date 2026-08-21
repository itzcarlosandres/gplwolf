@extends('layouts.frontend')

@section('meta_title', $seoTitle ?? 'Blog de WordPress, Plugins y Temas GPL — GPLWolf')
@section('meta_description', $seoDescription ?? 'Explora los mejores tutoriales, guías y recursos sobre WordPress, plugins y temas GPL premium. Aprende a optimizar y acelerar tu sitio web paso a paso.')
@section('meta_keywords', $seoKeywords ?? 'blog wordpress, tutoriales wordpress, plugins premium gpl, temas wordpress, elementor pro, woocommerce tips')

@section('content')

{{-- ══ HERO: Featured Post ══════════════════════════════════════════════════ --}}
@if($featured && !request('categoria') && !request('q'))
<section class="relative overflow-hidden bg-[#0a0a0a] border-b border-white/[0.04]">
    {{-- Glow --}}
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#FF2121]/[0.05] blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 py-12 lg:py-16 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        {{-- Text --}}
        <div class="space-y-5">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-full">
                <i class="fas fa-star text-[#FF2121] text-[9px]"></i>
                <span class="text-[10px] font-black text-[#FF2121] uppercase tracking-widest">Artículo Destacado</span>
            </div>

            @if($featured->category)
                <span class="inline-block text-[10px] font-black text-gray-500 uppercase tracking-widest bg-white/5 border border-white/10 rounded-lg px-3 py-1">
                    {{ $featured->category }}
                </span>
            @endif

            <h1 class="text-3xl lg:text-4xl font-black text-white leading-tight tracking-tight">
                {{ $featured->title }}
            </h1>

            @if($featured->excerpt)
                <p class="text-gray-400 text-base leading-relaxed">{{ $featured->excerpt }}</p>
            @endif

            <div class="flex items-center gap-4 text-[11px] text-gray-500 font-semibold flex-wrap">
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-calendar text-[#FF2121]"></i>
                    {{ $featured->published_at->diffForHumans() }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-clock text-[#FF2121]"></i>
                    {{ $featured->reading_time }} min de lectura
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-eye text-[#FF2121]"></i>
                    {{ number_format($featured->views_count) }} vistas
                </span>
            </div>

            <a href="{{ route('blog.show', $featured->slug) }}"
               class="inline-flex items-center gap-2 bg-[#FF2121] text-white font-black text-sm px-6 py-3 rounded-xl hover:bg-[#e01d1d] transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#FF2121]/25">
                Leer artículo <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        {{-- Thumbnail --}}
        <div class="hidden lg:block relative rounded-2xl overflow-hidden border border-white/[0.06] aspect-video shadow-2xl">
            @if($featured->thumbnail)
                <img src="{{ $featured->thumbnail_url }}"
                     alt="{{ $featured->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center"
                     style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 100%);">
                    <i class="fas fa-newspaper text-5xl text-white/10"></i>
                </div>
            @endif
            <div class="absolute top-4 left-4 bg-[#FF2121] text-white text-[9px] font-black px-3 py-1 rounded-lg uppercase tracking-wider">
                Destacado
            </div>
        </div>
    </div>
</section>
@endif

{{-- ══ FILTERS ════════════════════════════════════════════════════════════════ --}}
<div class="bg-[#0f0f0f] border-b border-white/[0.04] sticky top-0 z-30 backdrop-blur-sm">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center gap-2 overflow-x-auto py-3 scrollbar-none">
            <a href="{{ route('blog.index') }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-[11px] font-black transition-all
                      {{ !request('categoria') ? 'bg-[#FF2121]/10 border border-[#FF2121]/25 text-[#FF2121]' : 'text-gray-500 hover:text-white border border-transparent' }}">
                Todos
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['categoria' => $cat]) }}"
                   class="flex-shrink-0 px-4 py-1.5 rounded-full text-[11px] font-black transition-all
                          {{ request('categoria') === $cat ? 'bg-[#FF2121]/10 border border-[#FF2121]/25 text-[#FF2121]' : 'text-gray-500 hover:text-white border border-transparent hover:border-white/10' }}">
                    {{ $cat }}
                </a>
            @endforeach

            {{-- Search --}}
            <form method="GET" action="{{ route('blog.index') }}" class="ml-auto flex-shrink-0">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-[11px]"></i>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Buscar artículo..."
                           class="bg-white/5 border border-white/10 rounded-xl pl-8 pr-4 py-2 text-[11px] text-white placeholder:text-gray-600 focus:outline-none focus:border-[#FF2121]/40 w-48 transition-all">
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ GRID ════════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0a0a0a] py-12">
    <div class="max-w-6xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <p class="text-[11px] font-black text-gray-600 uppercase tracking-widest">
                @if(request('categoria'))
                    <i class="fas fa-tag text-[#FF2121] mr-1"></i> {{ request('categoria') }}
                @elseif(request('q'))
                    <i class="fas fa-search text-[#FF2121] mr-1"></i> "{{ request('q') }}"
                @else
                    <i class="fas fa-layer-group text-[#FF2121] mr-1"></i> Últimos artículos
                @endif
            </p>
            <span class="text-[10px] text-gray-600 bg-white/[0.03] border border-white/[0.06] px-3 py-1 rounded-full">
                {{ $posts->total() }} artículos
            </span>
        </div>

        @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}"
               class="group bg-white/[0.025] border border-white/[0.06] rounded-2xl overflow-hidden hover:border-white/[0.12] hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/40 transition-all duration-300 block">

                {{-- Thumbnail --}}
                <div class="relative aspect-video overflow-hidden">
                    @if($post->thumbnail)
                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="background: linear-gradient(135deg, #111827 0%, #1f2937 50%, #111827 100%);">
                            <i class="fas fa-newspaper text-3xl text-white/10"></i>
                        </div>
                    @endif

                    @if($post->category)
                        <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-sm border border-white/10 rounded-lg px-2 py-1 text-[9px] font-black text-gray-300 uppercase tracking-wider">
                            {{ $post->category }}
                        </div>
                    @endif

                    @if($post->featured)
                        <div class="absolute top-3 right-3 bg-[#FF2121] text-white text-[8px] font-black px-2 py-1 rounded-lg uppercase tracking-wider">
                            ★ Destacado
                        </div>
                    @endif
                </div>

                {{-- Body --}}
                <div class="p-5">
                    <h2 class="font-black text-white text-[15px] leading-snug tracking-tight mb-3 group-hover:text-[#FF2121] transition-colors line-clamp-2">
                        {{ $post->title }}
                    </h2>

                    @if($post->excerpt)
                        <p class="text-[12px] text-gray-500 leading-relaxed mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                    @endif

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 text-[10px] text-gray-600 font-semibold">
                            <span class="flex items-center gap-1"><i class="fas fa-clock"></i> {{ $post->reading_time }} min</span>
                            <span class="flex items-center gap-1"><i class="fas fa-eye"></i> {{ number_format($post->views_count) }}</span>
                            <span class="flex items-center gap-1"><i class="fas fa-calendar"></i> {{ $post->published_at->format('d M') }}</span>
                        </div>
                        <div class="w-7 h-7 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-lg flex items-center justify-center text-[#FF2121] text-[10px] group-hover:bg-[#FF2121] group-hover:text-white transition-all">
                            <i class="fas fa-arrow-right group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $posts->withQueryString()->links() }}
            </div>
        @endif

        @else
        {{-- Empty state --}}
        <div class="text-center py-24">
            <div class="w-16 h-16 bg-white/[0.03] border border-white/[0.06] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-newspaper text-2xl text-gray-700"></i>
            </div>
            <h3 class="text-white font-bold text-lg mb-2">No hay artículos</h3>
            <p class="text-gray-600 text-sm mb-6">
                @if(request('q'))
                    No encontramos artículos para "{{ request('q') }}"
                @else
                    Aún no hay artículos publicados en esta categoría.
                @endif
            </p>
            <a href="{{ route('blog.index') }}"
               class="inline-flex items-center gap-2 bg-white/[0.05] border border-white/10 text-gray-400 text-sm font-bold px-5 py-2.5 rounded-xl hover:text-white hover:border-white/20 transition-all">
                <i class="fas fa-arrow-left"></i> Ver todos los artículos
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ══ NEWSLETTER CTA ══════════════════════════════════════════════════════════ --}}
<section class="bg-[#0a0a0a] pb-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="relative rounded-3xl overflow-hidden border border-[#FF2121]/15 p-12 text-center"
             style="background: linear-gradient(135deg, rgba(255,33,33,0.05) 0%, rgba(255,33,33,0.02) 100%);">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-72 h-72 bg-[#FF2121]/[0.06] blur-[80px] rounded-full pointer-events-none"></div>
            <div class="relative">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-full mb-4">
                    <i class="fas fa-bell text-[#FF2121] text-[9px]"></i>
                    <span class="text-[10px] font-black text-[#FF2121] uppercase tracking-widest">Newsletter</span>
                </div>
                <h2 class="text-2xl font-black text-white mb-2">Recibe los mejores artículos de WordPress</h2>
                <p class="text-gray-500 text-sm mb-6">Tutoriales, noticias y recursos gratuitos directo a tu correo. Sin spam.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST"
                      class="flex gap-3 max-w-sm mx-auto">
                    @csrf
                    <input type="email" name="email" required placeholder="tu@correo.com"
                           class="flex-1 bg-white/[0.05] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder:text-gray-600 focus:outline-none focus:border-[#FF2121]/40 transition-colors">
                    <button type="submit"
                            class="bg-[#FF2121] text-white font-black text-sm px-5 py-3 rounded-xl hover:bg-[#e01d1d] transition-colors flex-shrink-0">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
                <p class="text-[10px] text-gray-700 mt-3">Sin spam · Cancela cuando quieras</p>
            </div>
        </div>
    </div>
</section>

@endsection
