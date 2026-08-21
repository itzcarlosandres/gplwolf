@extends('layouts.frontend')

@section('meta_title', $post->seo_title . ' — ' . ($globalSettings['site_name'] ?? 'GPLWolf'))
@section('meta_description', $post->seo_description)
@section('meta_keywords', $post->meta_keywords)
@section('canonical', route('blog.show', $post->slug))

@push('head')
{{-- Open Graph --}}
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $post->seo_title }}">
<meta property="og:description" content="{{ $post->seo_description }}">
@if($post->thumbnail)
<meta property="og:image" content="{{ $post->thumbnail_url }}">
@endif
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
<meta property="article:author" content="{{ $post->author->name }}">

{{-- JSON-LD Schema --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "headline": "{{ addslashes($post->title) }}",
  "description": "{{ addslashes($post->seo_description) }}",
  "datePublished": "{{ $post->published_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ $post->author->name }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ $globalSettings['site_name'] ?? 'GPLWolf' }}"
  }
  @if($post->thumbnail)
  ,"image": "{{ $post->thumbnail_url }}"
  @endif
}
</script>
@endpush

@section('content')
<div x-data="articlePage()" x-init="init()">

{{-- Reading progress bar --}}
<div class="fixed top-0 left-0 h-0.5 bg-[#FF2121] shadow-[0_0_8px_#FF2121] z-[9999] transition-all duration-100"
     :style="'width:' + progress + '%'"></div>

{{-- ══ ARTICLE HEADER ═════════════════════════════════════════════════════ --}}
<div class="bg-[#0f0f0f] border-b border-white/[0.04] relative overflow-hidden">
    <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-[#FF2121] to-transparent"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#FF2121]/[0.04] blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-3xl mx-auto px-6 py-12 relative">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 mb-6 text-[11px] font-semibold text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-[#FF2121] transition-colors"><i class="fas fa-home"></i></a>
            <span class="text-gray-700">/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-[#FF2121] transition-colors">Blog</a>
            @if($post->category)
                <span class="text-gray-700">/</span>
                <a href="{{ route('blog.index', ['categoria' => $post->category]) }}" class="hover:text-[#FF2121] transition-colors">{{ $post->category }}</a>
            @endif
        </nav>

        {{-- Category badge --}}
        @if($post->category)
            <a href="{{ route('blog.index', ['categoria' => $post->category]) }}"
               class="inline-flex items-center gap-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-full px-3 py-1 text-[10px] font-black text-[#FF2121] uppercase tracking-widest mb-4 hover:bg-[#FF2121]/15 transition-colors">
                <i class="fas fa-tag text-[8px]"></i> {{ $post->category }}
            </a>
        @endif

        {{-- Title --}}
        <h1 class="text-3xl lg:text-4xl font-black text-white leading-tight tracking-tight mb-4">
            {{ $post->title }}
        </h1>

        @if($post->excerpt)
            <p class="text-gray-400 text-base leading-relaxed mb-6">{{ $post->excerpt }}</p>
        @endif

        {{-- Meta row --}}
        <div class="flex items-center gap-4 flex-wrap">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-[#FF2121] rounded-full flex items-center justify-center text-white font-black text-sm">
                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-[10px] text-gray-600 font-semibold">Publicado por</div>
                    <div class="text-[12px] text-white font-black">{{ $post->author->name }}</div>
                </div>
            </div>
            <div class="w-px h-8 bg-white/[0.06]"></div>
            <span class="text-[11px] text-gray-500 font-semibold flex items-center gap-1.5">
                <i class="fas fa-calendar text-[#FF2121]"></i>
                {{ $post->published_at->format('d M Y') }}
            </span>
            <div class="w-px h-8 bg-white/[0.06]"></div>
            <span class="text-[11px] text-gray-500 font-semibold flex items-center gap-1.5">
                <i class="fas fa-clock text-[#FF2121]"></i>
                {{ $post->reading_time }} min de lectura
            </span>
            <div class="w-px h-8 bg-white/[0.06]"></div>
            <span class="text-[11px] text-gray-500 font-semibold flex items-center gap-1.5">
                <i class="fas fa-eye text-[#FF2121]"></i>
                {{ number_format($post->views_count) }} vistas
            </span>
        </div>
    </div>
</div>

{{-- ══ ARTICLE LAYOUT ══════════════════════════════════════════════════════ --}}
<section class="bg-[#0a0a0a] py-12">
    <div class="max-w-[1100px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-[1fr_268px] gap-12 items-start">

        {{-- ── Content ── --}}
        <div>
            {{-- Thumbnail --}}
            @if($post->thumbnail)
                <div class="rounded-2xl overflow-hidden mb-10 border border-white/[0.06] aspect-video">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Prose / Article Body --}}
            <article class="blog-prose">
                {!! $post->body !!}
            </article>

            {{-- Tags --}}
            @if($post->tags_list)
                <div class="mt-10 pt-8 border-t border-white/[0.06]">
                    <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest mb-3">
                        <i class="fas fa-tags text-[#FF2121] mr-1"></i> Tags
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags_list as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                               class="text-[11px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-3 py-1.5 rounded-lg hover:border-[#FF2121]/30 hover:text-[#FF2121] transition-all">
                                {{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Share --}}
            <div class="mt-8 pt-8 border-t border-white/[0.06]">
                <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest mb-4">
                    <i class="fas fa-share-alt text-[#FF2121] mr-1"></i> Compartir artículo
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}"
                       target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-[12px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-4 py-2.5 rounded-xl hover:border-[#1d9bf0]/40 hover:text-[#1d9bf0] hover:-translate-y-0.5 transition-all">
                        <i class="fab fa-twitter"></i> Twitter/X
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}"
                       target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-[12px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-4 py-2.5 rounded-xl hover:border-[#25d366]/40 hover:text-[#25d366] hover:-translate-y-0.5 transition-all">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                       target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-[12px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-4 py-2.5 rounded-xl hover:border-white/20 hover:text-white hover:-translate-y-0.5 transition-all">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<i class=\'fas fa-check\'></i> ¡Copiado!'; this.classList.add('border-[#FF2121]/40','text-[#FF2121]')"
                            class="flex items-center gap-2 text-[12px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-4 py-2.5 rounded-xl hover:border-[#FF2121]/40 hover:text-[#FF2121] hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-link"></i> Copiar enlace
                    </button>
                </div>
            </div>
        </div>

        {{-- ── Sidebar ── --}}
        <aside class="hidden lg:block sticky top-20 space-y-4">

            {{-- Table of Contents --}}
            <div class="bg-white/[0.025] border border-white/[0.06] rounded-2xl p-5" x-show="toc.length > 0">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i class="fas fa-list text-[#FF2121]"></i> Contenido
                </p>
                <ul class="space-y-0.5">
                    <template x-for="(item, i) in toc" :key="i">
                        <li>
                            <a :href="'#' + item.id"
                               :class="[
                                   item.level === 3 ? 'pl-5 text-[10px]' : 'text-[11px]',
                                   activeSection === item.id ? 'text-[#FF2121] bg-[#FF2121]/[0.06]' : 'text-gray-500 hover:text-white hover:bg-white/[0.03]'
                               ]"
                               class="flex items-center gap-2 px-2 py-1.5 rounded-lg transition-all font-semibold"
                               x-text="item.text">
                            </a>
                        </li>
                    </template>
                </ul>
            </div>

            {{-- Reading time card --}}
            <div class="bg-[#FF2121]/[0.06] border border-[#FF2121]/15 rounded-2xl p-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-[#FF2121] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-white text-sm"></i>
                </div>
                <div>
                    <div class="text-[9px] text-[#FF2121] font-black uppercase tracking-wider">Tiempo de lectura</div>
                    <div class="text-white font-black text-xl">{{ $post->reading_time }} min</div>
                </div>
            </div>

            {{-- Tags --}}
            @if($post->tags_list)
                <div class="bg-white/[0.025] border border-white/[0.06] rounded-2xl p-5">
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">
                        <i class="fas fa-tags text-[#FF2121] mr-1"></i> Tags
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags_list as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                               class="text-[10px] font-bold text-gray-500 bg-white/[0.03] border border-white/[0.06] px-2.5 py-1 rounded-lg hover:border-[#FF2121]/30 hover:text-[#FF2121] transition-all">
                                {{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Back to blog --}}
            <a href="{{ route('blog.index') }}"
               class="flex items-center gap-2 text-[11px] font-bold text-gray-500 bg-white/[0.025] border border-white/[0.06] rounded-xl px-4 py-3 hover:text-white hover:border-white/10 transition-all">
                <i class="fas fa-arrow-left text-[#FF2121]"></i> Volver al blog
            </a>
        </aside>

    </div>
</section>

{{-- ══ RELATED POSTS ═══════════════════════════════════════════════════════ --}}
@if($related->count() > 0)
<section class="bg-[#0a0a0a] border-t border-white/[0.04] py-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-1 h-6 bg-[#FF2121] rounded-full"></div>
            <h2 class="text-xl font-black text-white">Artículos Relacionados</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($related as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}"
                   class="group bg-white/[0.025] border border-white/[0.06] rounded-2xl overflow-hidden hover:border-white/[0.12] hover:-translate-y-1 transition-all">
                    <div class="aspect-video relative overflow-hidden">
                        @if($rel->thumbnail)
                            <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-900 to-gray-800 flex items-center justify-center">
                                <i class="fas fa-newspaper text-2xl text-white/10"></i>
                            </div>
                        @endif
                        @if($rel->category)
                            <span class="absolute top-2 left-2 text-[9px] font-black text-gray-300 bg-black/60 backdrop-blur-sm border border-white/10 px-2 py-0.5 rounded">
                                {{ $rel->category }}
                            </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-white font-black text-[13px] leading-snug mb-2 group-hover:text-[#FF2121] transition-colors line-clamp-2">
                            {{ $rel->title }}
                        </h3>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-gray-600"><i class="fas fa-clock mr-1"></i>{{ $rel->reading_time }} min</span>
                            <i class="fas fa-arrow-right text-[#FF2121] text-[10px]"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

</div>{{-- /x-data --}}

{{-- ══ Blog prose styles ════════════════════════════════════════════════════ --}}
<style>
.blog-prose h2 {
    font-size: 1.3rem; font-weight: 900; color: white; letter-spacing: -.4px;
    margin: 2.5rem 0 1rem; padding-bottom: .75rem; border-bottom: 1px solid rgba(255,255,255,.06);
    display: flex; align-items: center; gap: .6rem;
}
.blog-prose h2::before {
    content: ''; display: block; width: 3px; height: 1.2rem;
    background: #FF2121; border-radius: 2px; flex-shrink: 0;
}
.blog-prose h3 { font-size: 1.05rem; font-weight: 800; color: rgba(255,255,255,.9); margin: 1.8rem 0 .75rem; }
.blog-prose p { font-size: .9375rem; color: #999; line-height: 1.85; margin-bottom: 1.25rem; }
.blog-prose strong { color: white; font-weight: 700; }
.blog-prose em { color: #bbb; font-style: italic; }
.blog-prose a { color: #FF2121; text-decoration: underline; text-underline-offset: 3px; }
.blog-prose a:hover { color: #ff4444; }
.blog-prose ul { margin: 1rem 0 1.5rem; padding: 0; list-style: none; display: flex; flex-direction: column; gap: .6rem; }
.blog-prose ul li {
    display: flex; align-items: flex-start; gap: .75rem; font-size: .875rem; color: #999; line-height: 1.7;
    padding: .75rem 1rem; background: rgba(255,255,255,.025); border: 1px solid rgba(255,255,255,.06); border-radius: .75rem;
}
.blog-prose ul li::before { content: '→'; color: #FF2121; font-weight: 900; flex-shrink: 0; margin-top: 1px; }
.blog-prose ol { margin: 1rem 0 1.5rem; padding-left: 1.5rem; }
.blog-prose ol li { font-size: .875rem; color: #999; line-height: 1.7; margin-bottom: .5rem; }
.blog-prose blockquote {
    border-left: 3px solid #FF2121; padding: 1rem 1.25rem;
    background: rgba(255,33,33,.06); border-radius: 0 .75rem .75rem 0;
    margin: 1.5rem 0; font-size: .9375rem; color: rgba(255,255,255,.8); font-style: italic;
}
.blog-prose code {
    background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: .4rem;
    padding: 2px 8px; font-size: .78rem; color: #f87171; font-family: 'Courier New', monospace;
}
.blog-prose pre {
    background: #111; border: 1px solid #222; border-radius: .75rem;
    padding: 1.25rem; margin: 1.5rem 0; overflow-x: auto;
}
.blog-prose pre code { background: none; border: none; padding: 0; color: #e2e8f0; font-size: .8rem; }
.blog-prose img { border-radius: .75rem; border: 1px solid rgba(255,255,255,.06); max-width: 100%; }
.blog-prose hr { border: none; border-top: 1px solid rgba(255,255,255,.06); margin: 2rem 0; }
</style>

@push('scripts')
<script>
function articlePage() {
    return {
        progress: 0,
        toc: [],
        activeSection: null,
        init() {
            // Reading progress
            window.addEventListener('scroll', () => {
                const el = document.documentElement;
                const scrollTop = el.scrollTop || document.body.scrollTop;
                const docHeight = el.scrollHeight - el.clientHeight;
                this.progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            });

            // Build TOC from headings in article
            const headings = document.querySelectorAll('.blog-prose h2, .blog-prose h3');
            headings.forEach((h, i) => {
                const id = h.id || 'section-' + i;
                h.id = id;
                this.toc.push({ id, text: h.innerText.replace('→', '').trim(), level: h.tagName === 'H2' ? 2 : 3 });
            });

            // Active section observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) this.activeSection = e.target.id;
                });
            }, { rootMargin: '-20% 0% -75% 0%' });

            headings.forEach(h => observer.observe(h));
        }
    }
}
</script>
@endpush

@endsection
