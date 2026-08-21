@extends('layouts.admin')

@section('title', 'Blog — Gestión de Artículos')

@section('content')

<div x-data="{
    seoModal: false,
    seoTitle: @js($seoSettings['blog_seo_title'] ?? ''),
    seoDesc: @js($seoSettings['blog_seo_description'] ?? ''),
    seoKeys: @js($seoSettings['blog_seo_keywords'] ?? '')
}">

{{-- Header --}}
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
            <div class="w-9 h-9 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-newspaper text-[#FF2121] text-sm"></i>
            </div>
            Gestión del Blog
        </h1>
        <p class="text-gray-500 text-sm mt-1 ml-12">Crea, edita y publica artículos con ayuda de IA.</p>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <button type="button" @click="seoModal = true"
                class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#FF2121]/30 rounded-xl text-xs font-black text-gray-300 hover:text-white transition-all flex items-center gap-2">
            <i class="fas fa-search text-emerald-400"></i> Configuración SEO
        </button>
        <a href="{{ route('blog.index') }}" target="_blank"
           class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs font-black text-gray-300 hover:text-white transition-all flex items-center gap-2">
            <i class="fas fa-external-link-alt text-gray-500"></i> Ver Blog
        </a>
        <a href="{{ route('admin.blog.create') }}"
           class="px-4 py-2.5 bg-[#FF2121] hover:bg-[#e01d1d] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#FF2121]/20 flex items-center gap-2">
            <i class="fas fa-plus"></i> Nuevo Artículo
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#111] border border-white/5 rounded-2xl p-4">
        <div class="text-[10px] font-black text-gray-600 uppercase tracking-widest mb-1">Total</div>
        <div class="text-2xl font-black text-white">{{ $stats['total'] }}</div>
    </div>
    <div class="bg-[#111] border border-white/5 rounded-2xl p-4">
        <div class="text-[10px] font-black text-gray-600 uppercase tracking-widest mb-1">Publicados</div>
        <div class="text-2xl font-black text-emerald-400">{{ $stats['published'] }}</div>
    </div>
    <div class="bg-[#111] border border-white/5 rounded-2xl p-4">
        <div class="text-[10px] font-black text-gray-600 uppercase tracking-widest mb-1">Borradores</div>
        <div class="text-2xl font-black text-amber-400">{{ $stats['drafts'] }}</div>
    </div>
    <div class="bg-[#111] border border-white/5 rounded-2xl p-4">
        <div class="text-[10px] font-black text-gray-600 uppercase tracking-widest mb-1">Vistas totales</div>
        <div class="text-2xl font-black text-[#FF2121]">{{ number_format($stats['views']) }}</div>
    </div>
</div>

{{-- Filters --}}
<div class="bg-[#111] border border-white/[0.06] rounded-2xl p-4 mb-6 flex flex-wrap gap-3 items-center">
    <form method="GET" action="{{ route('admin.blog.index') }}" class="flex flex-wrap gap-3 items-center w-full">
        {{-- Status tabs --}}
        <div class="flex gap-1">
            @foreach(['all' => 'Todos', 'published' => 'Publicados', 'draft' => 'Borradores', 'scheduled' => 'Programados'] as $val => $label)
                <button type="submit" name="status" value="{{ $val }}"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-black transition-all
                               {{ ($status ?? 'all') === $val ? 'bg-[#FF2121]/10 border border-[#FF2121]/25 text-[#FF2121]' : 'text-gray-500 hover:text-white' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
        <div class="h-5 w-px bg-white/[0.06]"></div>
        {{-- Category filter --}}
        <select name="category" onchange="this.form.submit()"
                class="bg-[#161616] border border-white/10 rounded-xl px-3 py-1.5 text-[11px] text-gray-300 focus:outline-none focus:border-[#FF2121]/40">
            <option class="bg-[#161616] text-gray-200 py-1" value="">Todas las categorías</option>
            @foreach($categories as $cat)
                <option class="bg-[#161616] text-gray-200 py-1" value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        {{-- Search --}}
        <div class="relative flex-1 min-w-[200px]">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-[11px]"></i>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar artículo..."
                   class="w-full bg-white/5 border border-white/10 rounded-xl pl-8 pr-4 py-1.5 text-[11px] text-white placeholder:text-gray-600 focus:outline-none focus:border-[#FF2121]/40">
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bg-[#111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/[0.06]">
                <th class="text-left px-5 py-3 text-[10px] font-black text-gray-600 uppercase tracking-widest">Artículo</th>
                <th class="text-left px-3 py-3 text-[10px] font-black text-gray-600 uppercase tracking-widest hidden md:table-cell">Categoría</th>
                <th class="text-left px-3 py-3 text-[10px] font-black text-gray-600 uppercase tracking-widest hidden lg:table-cell">Estado</th>
                <th class="text-left px-3 py-3 text-[10px] font-black text-gray-600 uppercase tracking-widest hidden lg:table-cell">Vistas</th>
                <th class="text-left px-3 py-3 text-[10px] font-black text-gray-600 uppercase tracking-widest hidden xl:table-cell">Fecha</th>
                <th class="text-right px-5 py-3 text-[10px] font-black text-gray-600 uppercase tracking-widest">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/[0.04]">
            @forelse($posts as $post)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    {{-- Title + thumb --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 border border-white/[0.06]">
                                @if($post->thumbnail)
                                    <img src="{{ $post->thumbnail_url }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-white/[0.03] flex items-center justify-center">
                                        <i class="fas fa-newspaper text-gray-700 text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="font-black text-white text-[13px] leading-snug truncate max-w-[240px] group-hover:text-[#FF2121] transition-colors">
                                    {{ $post->title }}
                                </p>
                                @if($post->featured)
                                    <span class="text-[8px] font-black text-amber-400 uppercase tracking-wider">
                                        <i class="fas fa-star"></i> Destacado
                                    </span>
                                @endif
                                <p class="text-[10px] text-gray-600 mt-0.5">{{ $post->reading_time }} min · /blog/{{ $post->slug }}</p>
                            </div>
                        </div>
                    </td>
                    {{-- Category --}}
                    <td class="px-3 py-4 hidden md:table-cell">
                        <span class="text-[10px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-2 py-1 rounded">
                            {{ $post->category ?? '—' }}
                        </span>
                    </td>
                    {{-- Status --}}
                    <td class="px-3 py-4 hidden lg:table-cell">
                        @if($post->status === 'published')
                            <span class="inline-flex items-center gap-1 text-[10px] font-black text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-lg">
                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Publicado
                            </span>
                        @elseif($post->status === 'scheduled')
                            <span class="inline-flex items-center gap-1 text-[10px] font-black text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2.5 py-1 rounded-lg">
                                <i class="fas fa-clock text-[8px]"></i> Programado
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-black text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-lg">
                                <i class="fas fa-pen text-[8px]"></i> Borrador
                            </span>
                        @endif
                    </td>
                    {{-- Views --}}
                    <td class="px-3 py-4 hidden lg:table-cell">
                        <span class="text-[12px] font-black text-gray-400">{{ number_format($post->views_count) }}</span>
                    </td>
                    {{-- Date --}}
                    <td class="px-3 py-4 hidden xl:table-cell">
                        <span class="text-[11px] text-gray-600">
                            {{ $post->published_at ? $post->published_at->format('d M Y') : 'Sin publicar' }}
                        </span>
                    </td>
                    {{-- Actions --}}
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center gap-2 justify-end">
                            {{-- Publish toggle --}}
                            <form action="{{ route('admin.blog.publish', $post) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-8 h-8 rounded-lg text-[11px] flex items-center justify-center transition-all
                                               {{ $post->status === 'published'
                                                   ? 'bg-emerald-500/10 text-emerald-400 hover:bg-amber-500/10 hover:text-amber-400 border border-emerald-500/20'
                                                   : 'bg-white/[0.04] text-gray-500 hover:bg-emerald-500/10 hover:text-emerald-400 border border-white/[0.06]' }}"
                                        title="{{ $post->status === 'published' ? 'Despublicar' : 'Publicar' }}">
                                    <i class="fas {{ $post->status === 'published' ? 'fa-eye-slash' : 'fa-globe' }}"></i>
                                </button>
                            </form>
                            {{-- Edit --}}
                            <a href="{{ route('admin.blog.edit', $post) }}"
                               class="w-8 h-8 bg-white/[0.04] border border-white/[0.06] rounded-lg flex items-center justify-center text-[11px] text-gray-500 hover:text-white hover:border-white/10 transition-all">
                                <i class="fas fa-pen"></i>
                            </a>
                            {{-- View --}}
                            @if($post->status === 'published')
                                <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                   class="w-8 h-8 bg-white/[0.04] border border-white/[0.06] rounded-lg flex items-center justify-center text-[11px] text-gray-500 hover:text-[#FF2121] hover:border-[#FF2121]/20 transition-all">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                            {{-- Delete --}}
                            <form action="{{ route('admin.blog.destroy', $post) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este artículo?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 bg-white/[0.04] border border-white/[0.06] rounded-lg flex items-center justify-center text-[11px] text-gray-500 hover:text-rose-400 hover:border-rose-500/20 hover:bg-rose-500/5 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 bg-white/[0.03] border border-white/[0.06] rounded-2xl flex items-center justify-center">
                                <i class="fas fa-newspaper text-gray-700 text-lg"></i>
                            </div>
                            <p class="text-gray-600 text-sm">No hay artículos todavía.</p>
                            <a href="{{ route('admin.blog.create') }}"
                               class="text-[#FF2121] text-xs font-black hover:underline">
                                <i class="fas fa-plus mr-1"></i> Crear el primer artículo
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($posts->hasPages())
        <div class="px-5 py-4 border-t border-white/[0.06]">
            {{ $posts->links() }}
        </div>
    @endif
</div>

{{-- ══ MODAL: CONFIGURACIÓN SEO DEL BLOG ════════════════════════════════════ --}}
<div x-show="seoModal"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
     style="display: none;">

    <div @click.away="seoModal = false"
         class="bg-[#111111] border border-white/10 rounded-3xl p-6 sm:p-8 max-w-xl w-full shadow-2xl space-y-6 relative max-h-[90vh] overflow-y-auto">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400">
                    <i class="fas fa-search text-base"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">SEO de la Página Principal del Blog</h3>
                    <p class="text-xs text-gray-500">Configura el título y descripción que Google mostrará para <span class="text-gray-300">/blog</span></p>
                </div>
            </div>
            <button type="button" @click="seoModal = false" class="text-gray-500 hover:text-white transition-colors w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white/5">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.blog.seo.update') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Meta Title --}}
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider">
                        Título SEO (Meta Title)
                    </label>
                    <span class="text-[10px] font-bold"
                          :class="seoTitle.length >= 45 && seoTitle.length <= 65 ? 'text-emerald-400' : 'text-amber-400'"
                          x-text="seoTitle.length + ' / 60 chars (ideal: 50-60)'"></span>
                </div>
                <input type="text" name="blog_seo_title" x-model="seoTitle" maxlength="80" required
                       class="w-full bg-[#161616] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 transition-colors"
                       placeholder="Ej: Blog de WordPress, Plugins y Temas GPL — GPLWolf">
            </div>

            {{-- Meta Description --}}
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider">
                        Descripción SEO (Meta Description)
                    </label>
                    <span class="text-[10px] font-bold"
                          :class="seoDesc.length >= 135 && seoDesc.length <= 160 ? 'text-emerald-400' : 'text-amber-400'"
                          x-text="seoDesc.length + ' / 160 chars (ideal: 140-160)'"></span>
                </div>
                <textarea name="blog_seo_description" x-model="seoDesc" rows="3" maxlength="180" required
                          class="w-full bg-[#161616] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 transition-colors resize-none"
                          placeholder="Ej: Explora los mejores tutoriales, guías y recursos sobre WordPress, plugins y temas GPL premium. Aprende a optimizar tu sitio web."></textarea>
            </div>

            {{-- Meta Keywords --}}
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2">
                    Palabras Clave SEO (Keywords)
                </label>
                <input type="text" name="blog_seo_keywords" x-model="seoKeys"
                       class="w-full bg-[#161616] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 transition-colors"
                       placeholder="blog wordpress, tutoriales wordpress, plugins gpl, temas wordpress">
            </div>

            {{-- Live Google Search Preview --}}
            <div class="p-4 bg-[#0a0a0a] border border-white/10 rounded-2xl space-y-1">
                <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                    <i class="fab fa-google text-blue-400"></i> Vista previa en Google (SERP)
                </p>
                <div class="text-[#8ab4f8] text-sm font-medium hover:underline cursor-pointer truncate"
                     x-text="seoTitle || 'Título del Blog'"></div>
                <div class="text-[#4caf50] text-[11px] font-mono">https://gplwolf.com/blog</div>
                <div class="text-[#bdc1c6] text-xs leading-relaxed line-clamp-2"
                     x-text="seoDesc || 'Descripción del blog para motores de búsqueda...'"></div>
            </div>

            {{-- Modal Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                <button type="button" @click="seoModal = false"
                        class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-xl text-xs font-black transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-2.5 bg-[#FF2121] hover:bg-[#e01d1d] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#FF2121]/20 flex items-center gap-2">
                    <i class="fas fa-save"></i> Guardar Configuración SEO
                </button>
            </div>
        </form>
    </div>
</div>

</div>{{-- /x-data --}}

@endsection
