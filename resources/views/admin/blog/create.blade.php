@extends('layouts.admin')

@section('title', 'Nuevo Artículo')

@section('content')
<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.blog.index') }}"
       class="w-9 h-9 bg-white/[0.04] border border-white/[0.06] rounded-xl flex items-center justify-center text-gray-500 hover:text-white hover:border-white/10 transition-all">
        <i class="fas fa-arrow-left text-xs"></i>
    </a>
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Nuevo Artículo</h1>
        <p class="text-gray-600 text-xs mt-0.5">Usa IA para generar contenido optimizado para SEO</p>
    </div>
</div>

<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data"
      x-data="blogEditor()" x-init="init()"
      class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-20">
    @csrf

    @if(isset($errors) && $errors->any())
        <div class="lg:col-span-3 bg-rose-500/10 border border-rose-500/20 rounded-2xl p-4 flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-rose-400 mt-0.5"></i>
            <ul class="text-rose-400 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── LEFT: Content (2/3) ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Title --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-6">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">
                Título del artículo
            </label>
            <input type="text" name="title" id="post-title"
                   value="{{ old('title') }}"
                   placeholder="Ej: Cómo instalar Elementor Pro gratis en WordPress..."
                   x-model="titleVal"
                   @input="updateSlug()"
                   class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-4 py-3 text-white text-lg font-black placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40 transition-colors"
                   required>
            {{-- Slug preview --}}
            <div class="mt-2 flex items-center gap-2">
                <span class="text-[10px] text-gray-700">URL:</span>
                <span class="text-[10px] text-gray-500 font-mono">/blog/<span x-text="slugPreview" class="text-gray-400"></span></span>
                <input type="hidden" name="slug" :value="slugPreview">
            </div>
        </div>

        {{-- Excerpt --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-6">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">
                Extracto / Resumen
                <span class="ml-2 text-gray-700 normal-case font-normal">Máx. 160 caracteres</span>
            </label>
            <textarea name="excerpt" rows="2" maxlength="500"
                      x-model="excerptVal"
                      placeholder="Resumen breve del artículo para SEO y vista previa..."
                      class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-4 py-3 text-white text-sm placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40 transition-colors resize-none">{{ old('excerpt') }}</textarea>
            <p class="text-[10px] text-gray-700 mt-1" x-text="excerptVal.length + '/500 caracteres'"></p>
        </div>

        {{-- IA Generator --}}
        <div class="bg-gradient-to-br from-[#FF2121]/[0.06] to-transparent border border-[#FF2121]/15 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#FF2121] rounded-xl flex items-center justify-center">
                        <i class="fas fa-magic text-white text-xs"></i>
                    </div>
                    <div>
                        <p class="text-white font-black text-sm">Generar contenido con IA</p>
                        <p class="text-gray-600 text-[10px]">Gemini genera el artículo completo + SEO automáticamente</p>
                    </div>
                </div>
                <button type="button" @click="aiOpen = !aiOpen"
                        class="text-[10px] font-black text-[#FF2121] flex items-center gap-1">
                    <span x-text="aiOpen ? 'Ocultar' : 'Abrir'"></span>
                    <i class="fas fa-chevron-down transition-transform" :class="aiOpen ? 'rotate-180' : ''"></i>
                </button>
            </div>

            <div x-show="aiOpen" x-collapse class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Tema del artículo</label>
                        <input type="text" x-model="ai.topic"
                               placeholder="Ej: Mejores plugins SEO para WordPress 2026"
                               class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Keywords (separadas por coma)</label>
                        <input type="text" x-model="ai.keywords"
                               placeholder="Ej: plugins seo, yoast seo, rank math"
                               class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Tono</label>
                        <select x-model="ai.tone"
                                class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                            <option value="informativo">Informativo</option>
                            <option value="tutorial">Tutorial paso a paso</option>
                            <option value="comparativa">Comparativa</option>
                            <option value="opinion">Opinión experta</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Palabras objetivo</label>
                        <select x-model="ai.wordCount"
                                class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                            <option value="400">~400 palabras (rápido)</option>
                            <option value="700" selected>~700 palabras</option>
                            <option value="1000">~1000 palabras</option>
                            <option value="1500">~1500 palabras (largo)</option>
                        </select>
                    </div>
                </div>

                <button type="button" @click="generateAi()"
                        :disabled="aiLoading || !ai.topic"
                        class="w-full flex items-center justify-center gap-2 bg-[#FF2121] text-white font-black text-sm py-3 rounded-xl hover:bg-[#e01d1d] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-magic" :class="aiLoading ? 'animate-spin' : ''"></i>
                    <span x-text="aiLoading ? 'Generando con Gemini AI... (puede tardar ~30s)' : 'Generar Artículo Completo'"></span>
                </button>

                <div x-show="aiError" class="text-rose-400 text-xs bg-rose-500/10 border border-rose-500/20 rounded-xl p-3" x-text="aiError"></div>
                <div x-show="aiSuccess" class="text-emerald-400 text-xs bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-3">
                    <i class="fas fa-check mr-1"></i> ¡Contenido generado! Revisa y ajusta antes de publicar.
                </div>
            </div>
        </div>

        {{-- TipTap Editor --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="border-b border-white/[0.06] px-4 py-3 flex items-center gap-2 flex-wrap bg-white/[0.02]">
                <span class="text-[10px] font-black text-gray-600 uppercase tracking-widest mr-2">Contenido</span>

                {{-- Toolbar buttons --}}
                <template x-for="btn in toolbar" :key="btn.cmd">
                    <button type="button"
                            @click="execCmd(btn.cmd, btn.val)"
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] text-gray-500 hover:text-white hover:bg-white/[0.06] transition-all"
                            :title="btn.label">
                        <i :class="btn.icon"></i>
                    </button>
                </template>
                <div class="h-4 w-px bg-white/[0.06] mx-1"></div>

                {{-- SEO Score --}}
                <div class="ml-auto flex items-center gap-2">
                    <span class="text-[10px] text-gray-600">Score SEO:</span>
                    <span class="text-[12px] font-black"
                          :class="seoScore >= 80 ? 'text-emerald-400' : seoScore >= 50 ? 'text-amber-400' : 'text-rose-400'"
                          x-text="seoScore + '/100'"></span>
                </div>
            </div>

            {{-- Editable content area --}}
            <div id="editor"
                 contenteditable="true"
                 x-ref="editor"
                 @input="onEditorChange()"
                 class="min-h-[400px] p-6 text-gray-300 focus:outline-none blog-prose-editor"
                 style="line-height:1.8;font-size:15px;">
                {!! old('body') !!}
            </div>
            <input type="hidden" name="body" x-ref="bodyInput">
        </div>

        {{-- SEO Checks --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5" x-show="Object.keys(seoChecks).length > 0">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">
                <i class="fas fa-chart-line text-[#FF2121] mr-1"></i> Análisis SEO
            </p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <template x-for="(check, key) in seoChecks" :key="key">
                    <div class="flex items-center gap-2 text-[11px] p-2 bg-white/[0.02] rounded-lg">
                        <i class="fas text-[10px]"
                           :class="check.passed ? 'fa-check-circle text-emerald-400' : 'fa-times-circle text-rose-400'"></i>
                        <span class="text-gray-500" x-text="check.message"></span>
                    </div>
                </template>
            </div>
        </div>

    </div>

    {{-- ── RIGHT: Settings (1/3) ── --}}
    <div class="space-y-5">

        {{-- Publish box --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Estado & Publicación</p>

            <div class="space-y-3 mb-4">
                @foreach(['draft' => ['Borrador', 'fa-pen', 'text-amber-400'], 'published' => ['Publicado', 'fa-globe', 'text-emerald-400'], 'scheduled' => ['Programado', 'fa-clock', 'text-blue-400']] as $val => [$label, $icon, $color])
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="{{ $val }}"
                               {{ old('status', 'draft') === $val ? 'checked' : '' }}
                               class="accent-[#FF2121]">
                        <span class="flex items-center gap-2 text-sm font-bold text-gray-400">
                            <i class="fas {{ $icon }} {{ $color }} text-[11px]"></i> {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="mb-4">
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Fecha de publicación</label>
                <input type="datetime-local" name="published_at"
                       value="{{ old('published_at') }}"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
            </div>

            <label class="flex items-center gap-2.5 cursor-pointer mb-4">
                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="accent-[#FF2121]">
                <span class="text-xs font-bold text-gray-400"><i class="fas fa-star text-amber-400 mr-1"></i> Artículo Destacado</span>
            </label>

            <button type="submit"
                    class="w-full bg-[#FF2121] hover:bg-[#e01d1d] text-white font-black text-sm py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> Guardar Artículo
            </button>
        </div>

        {{-- Thumbnail --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5" x-data="{thumb:null}">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">
                <i class="fas fa-image text-[#FF2121] mr-1"></i> Imagen de Portada
            </p>
            <div class="relative aspect-video rounded-xl overflow-hidden border-2 border-dashed border-white/[0.06] hover:border-[#FF2121]/30 transition-colors cursor-pointer"
                 @click="$refs.thumbInput.click()">
                <template x-if="thumb">
                    <img :src="thumb" class="w-full h-full object-cover">
                </template>
                <template x-if="!thumb">
                    <div class="w-full h-full flex flex-col items-center justify-center gap-2">
                        <i class="fas fa-cloud-arrow-up text-2xl text-gray-700"></i>
                        <span class="text-[10px] text-gray-600">Clic para subir imagen</span>
                        <span class="text-[9px] text-gray-700">JPG, PNG · Máx. 4MB</span>
                    </div>
                </template>
                <input x-ref="thumbInput" type="file" name="thumbnail" accept="image/*" class="hidden"
                       @change="const f=$event.target.files[0]; if(f) { const r=new FileReader(); r.onload=e=>thumb=e.target.result; r.readAsDataURL(f); }">
            </div>
            <p class="text-[9px] text-gray-700 mt-2">Se guarda en almacenamiento local (sin R2)</p>
        </div>

        {{-- Category & Tags --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5 space-y-4">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Taxonomía</p>

            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Categoría</label>
                <input type="text" name="category" value="{{ old('category') }}"
                       x-model="catVal"
                       placeholder="WordPress, SEO, Elementor..."
                       list="category-list"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40">
                <datalist id="category-list">
                    @foreach(['WordPress','SEO','Tutoriales','Plugins','Temas','WooCommerce','Elementor','Seguridad','Rendimiento','Noticias'] as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Tags (separadas por coma)</label>
                <input type="text" name="tags" id="post-tags"
                       x-model="tagsVal"
                       value="{{ old('tags') }}"
                       placeholder="WordPress, GPL, Plugins Premium..."
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40">
                {{-- Tag chips preview --}}
                <div class="flex flex-wrap gap-1.5 mt-2" x-show="tagsVal">
                    <template x-for="tag in tagsVal.split(',').map(t=>t.trim()).filter(t=>t)" :key="tag">
                        <span class="text-[9px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-2 py-0.5 rounded" x-text="tag"></span>
                    </template>
                </div>
            </div>
        </div>

        {{-- SEO Box --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5 space-y-4">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                <i class="fas fa-search text-[#FF2121] mr-1"></i> SEO
            </p>

            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">
                    Meta Title <span class="normal-case font-normal text-gray-700" x-text="'(' + metaTitleVal.length + '/70)'"></span>
                </label>
                <input type="text" name="meta_title" x-model="metaTitleVal" maxlength="70"
                       value="{{ old('meta_title') }}"
                       placeholder="Dejar vacío para usar el título del artículo"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">
                    Meta Description <span class="normal-case font-normal text-gray-700" x-text="'(' + metaDescVal.length + '/160)'"></span>
                </label>
                <textarea name="meta_description" x-model="metaDescVal" rows="3" maxlength="160"
                          placeholder="Descripción para Google (140-160 caracteres ideal)..."
                          class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40 resize-none">{{ old('meta_description') }}</textarea>
                {{-- Visual length indicator --}}
                <div class="mt-1 h-1 bg-white/[0.04] rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all"
                         :class="metaDescVal.length >= 140 && metaDescVal.length <= 160 ? 'bg-emerald-500' : metaDescVal.length > 160 ? 'bg-rose-500' : 'bg-amber-500'"
                         :style="'width:' + Math.min(100, (metaDescVal.length/160)*100) + '%'"></div>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Keywords SEO</label>
                <input type="text" name="meta_keywords"
                       value="{{ old('meta_keywords') }}"
                       placeholder="wordpress, plugins, elementor pro..."
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40">
            </div>

            {{-- Google Preview --}}
            <div class="mt-2 p-3 bg-white/[0.02] border border-white/[0.06] rounded-xl" x-show="titleVal || metaDescVal">
                <p class="text-[9px] text-gray-600 uppercase tracking-widest mb-2">Vista previa en Google</p>
                <p class="text-[#8ab4f8] text-[13px] font-medium truncate" x-text="(metaTitleVal || titleVal) + ' — GPLWolf'"></p>
                <p class="text-[#4caf50] text-[10px]">gplwolf.com/blog/<span x-text="slugPreview"></span></p>
                <p class="text-[#bdc1c6] text-[11px] mt-0.5 line-clamp-2" x-text="metaDescVal || excerptVal"></p>
            </div>
        </div>

    </div>
</form>

{{-- Prose editor styles --}}
<style>
.blog-prose-editor h2 { font-size:1.3rem; font-weight:900; color:white; margin:1.5rem 0 .75rem; border-bottom:1px solid rgba(255,255,255,.06); padding-bottom:.5rem; }
.blog-prose-editor h3 { font-size:1.05rem; font-weight:800; color:rgba(255,255,255,.9); margin:1.2rem 0 .5rem; }
.blog-prose-editor p { color:#999; margin-bottom:1rem; }
.blog-prose-editor strong { color:white; }
.blog-prose-editor ul { list-style:disc; padding-left:1.5rem; margin:.75rem 0; color:#999; }
.blog-prose-editor blockquote { border-left:3px solid #FF2121; padding:.75rem 1rem; background:rgba(255,33,33,.06); margin:1rem 0; color:rgba(255,255,255,.8); font-style:italic; border-radius:0 .5rem .5rem 0; }
</style>

@push('scripts')
<script>
function blogEditor() {
    return {
        titleVal: '{{ old("title") }}',
        slugPreview: '{{ old("slug") }}',
        excerptVal: '{{ old("excerpt") }}',
        catVal: '{{ old("category") }}',
        tagsVal: '{{ old("tags") }}',
        metaTitleVal: '{{ old("meta_title") }}',
        metaDescVal: '{{ old("meta_description") }}',
        aiOpen: false,
        aiLoading: false,
        aiError: '',
        aiSuccess: false,
        seoScore: 0,
        seoChecks: {},
        ai: { topic: '', keywords: '', tone: 'informativo', wordCount: '700' },
        toolbar: [
            { cmd: 'formatBlock', val: 'h2',    icon: 'fas fa-heading',    label: 'H2' },
            { cmd: 'formatBlock', val: 'h3',    icon: 'fas fa-h3',         label: 'H3' },
            { cmd: 'bold',        val: null,     icon: 'fas fa-bold',       label: 'Negrita' },
            { cmd: 'italic',      val: null,     icon: 'fas fa-italic',     label: 'Cursiva' },
            { cmd: 'insertUnorderedList', val:null, icon:'fas fa-list-ul',  label: 'Lista' },
            { cmd: 'formatBlock', val: 'blockquote', icon:'fas fa-quote-right', label: 'Cita' },
            { cmd: 'createLink', val: 'prompt', icon: 'fas fa-link',       label: 'Enlace' },
            { cmd: 'removeFormat', val:null,    icon: 'fas fa-remove-format', label: 'Limpiar formato' },
        ],

        init() {
            if (this.titleVal) this.slugPreview = this.toSlug(this.titleVal);
        },

        updateSlug() {
            this.slugPreview = this.toSlug(this.titleVal);
        },

        toSlug(str) {
            return str.toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .trim().replace(/\s+/g, '-');
        },

        execCmd(cmd, val) {
            if (cmd === 'createLink') {
                const url = prompt('Ingresa la URL:');
                if (url) document.execCommand('createLink', false, url);
            } else {
                document.execCommand(cmd, false, val || null);
            }
            this.$refs.editor.focus();
            this.onEditorChange();
        },

        onEditorChange() {
            this.$refs.bodyInput.value = this.$refs.editor.innerHTML;
            this.calcSeoScore();
        },

        calcSeoScore() {
            const html = this.$refs.editor.innerHTML;
            const text = this.$refs.editor.innerText || '';
            const wordCount = text.trim().split(/\s+/).filter(w => w).length;
            const checks = {};
            let total = 0;

            // H2
            const h2 = (html.match(/<h2/gi) || []).length;
            checks.h2 = { passed: h2 >= 2, message: h2 + ' H2 ' + (h2>=2?'✓':'(mín. 2)'), points: h2>=2?20:(h2*10) };
            total += checks.h2.points;

            // Length
            checks.length = { passed: wordCount>=400&&wordCount<=1500, message: wordCount+' palabras', points: wordCount>=400&&wordCount<=1500?25:(wordCount>=200?12:5) };
            total += checks.length.points;

            // Strong
            const strong = (html.match(/<strong/gi) || []).length;
            checks.bold = { passed: strong>=4&&strong<=12, message: strong+' negritas', points: strong>=4&&strong<=12?15:(strong>0?8:0) };
            total += checks.bold.points;

            // Lists
            const lists = (html.match(/<ul/gi) || []).length;
            checks.lists = { passed: lists>=1, message: lists+' lista(s)', points: lists>=2?20:(lists>=1?10:0) };
            total += checks.lists.points;

            // Blockquote
            const bq = (html.match(/<blockquote/gi) || []).length;
            checks.blockquote = { passed: bq>=1, message: bq+' cita(s)', points: bq>=1?10:0 };
            total += checks.blockquote.points;

            // Meta desc
            checks.metaDesc = { passed: this.metaDescVal.length>=120&&this.metaDescVal.length<=160, message: 'Meta desc: '+this.metaDescVal.length+' chars', points: this.metaDescVal.length>=120&&this.metaDescVal.length<=160?10:5 };
            total += checks.metaDesc.points;

            this.seoChecks = checks;
            this.seoScore = Math.min(100, total);
        },

        async generateAi() {
            if (!this.ai.topic) return;
            this.aiLoading = true;
            this.aiError = '';
            this.aiSuccess = false;

            try {
                const res = await fetch('{{ route("admin.blog.ai.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        topic: this.ai.topic,
                        keywords: this.ai.keywords,
                        tone: this.ai.tone,
                        word_count: parseInt(this.ai.wordCount),
                    }),
                });

                const data = await res.json();

                if (data.success) {
                    const c = data.content;
                    this.titleVal     = c.title;
                    this.slugPreview  = c.slug;
                    this.excerptVal   = c.excerpt;
                    this.catVal       = c.category;
                    this.tagsVal      = (c.tags || []).join(', ');
                    this.metaTitleVal = c.meta_title;
                    this.metaDescVal  = c.meta_description;

                    // Inject body into editor
                    this.$refs.editor.innerHTML = c.body;
                    this.$refs.bodyInput.value  = c.body;
                    this.onEditorChange();

                    this.aiSuccess = true;
                    this.aiOpen    = false;
                } else {
                    this.aiError = data.message || 'Error desconocido';
                }
            } catch (e) {
                this.aiError = 'Error de conexión: ' + e.message;
            } finally {
                this.aiLoading = false;
            }
        }
    }
}
</script>
@endpush

@endsection
