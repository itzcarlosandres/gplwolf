@extends('layouts.admin')

@section('title', 'Editar: ' . $post->title)

@section('content')
<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.blog.index') }}"
       class="w-9 h-9 bg-white/[0.04] border border-white/[0.06] rounded-xl flex items-center justify-center text-gray-500 hover:text-white hover:border-white/10 transition-all">
        <i class="fas fa-arrow-left text-xs"></i>
    </a>
    <div>
        <h1 class="text-xl font-black text-white tracking-tight">Editar Artículo</h1>
        <p class="text-gray-600 text-xs mt-0.5 truncate max-w-xs">{{ $post->title }}</p>
    </div>
    @if($post->status === 'published')
        <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
           class="ml-auto text-[10px] font-black text-[#FF2121] flex items-center gap-1 hover:underline">
            <i class="fas fa-external-link-alt"></i> Ver publicado
        </a>
    @endif
</div>

<form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data"
      x-data="blogEditor()" x-init="init()"
      class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-20">
    @csrf
    @method('PUT')

    @if(isset($errors) && $errors->any())
        <div class="lg:col-span-3 bg-rose-500/10 border border-rose-500/20 rounded-2xl p-4 flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-rose-400 mt-0.5"></i>
            <ul class="text-rose-400 text-sm space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- ── LEFT: Content ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Title --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-6">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Título</label>
            <input type="text" name="title" x-model="titleVal" @input="slugEdited || updateSlug()"
                   class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-4 py-3 text-white text-lg font-black placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40 transition-colors" required>
            <div class="mt-2 flex items-center gap-2">
                <span class="text-[10px] text-gray-700">URL:</span>
                <span class="text-[10px] text-gray-500 font-mono">/blog/<span x-text="slugPreview"></span></span>
                <button type="button" @click="slugEdited=true; slugPreview=prompt('Editar slug:',slugPreview)||slugPreview"
                        class="text-[9px] text-[#FF2121] hover:underline ml-1">Editar</button>
                <input type="hidden" name="slug" :value="slugPreview">
            </div>
        </div>

        {{-- Excerpt --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-6">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">
                Extracto <span class="text-gray-700 normal-case font-normal" x-text="'(' + excerptVal.length + '/500)'"></span>
            </label>
            <textarea name="excerpt" rows="2" maxlength="500" x-model="excerptVal"
                      class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-4 py-3 text-white text-sm placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40 resize-none">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        {{-- IA Panel --}}
        <div class="bg-gradient-to-br from-[#FF2121]/[0.05] to-transparent border border-[#FF2121]/15 rounded-2xl p-5">
            <div class="flex items-center justify-between cursor-pointer" @click="aiOpen = !aiOpen">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-[#FF2121] rounded-lg flex items-center justify-center">
                        <i class="fas fa-magic text-white text-[10px]"></i>
                    </div>
                    <div>
                        <p class="text-white font-black text-sm">Regenerar con IA</p>
                        <p class="text-gray-600 text-[10px]">Gemini genera el artículo completo + SEO</p>
                    </div>
                </div>
                <button type="button"
                        class="text-[10px] font-black text-[#FF2121] flex items-center gap-1.5 bg-[#FF2121]/10 px-2.5 py-1 rounded-lg border border-[#FF2121]/20">
                    <span x-text="aiOpen ? 'Ocultar' : 'Abrir Asistente'"></span>
                    <i class="fas fa-chevron-down transition-transform" :class="aiOpen ? 'rotate-180' : ''"></i>
                </button>
            </div>
            <div x-show="aiOpen" x-transition class="mt-4 pt-4 border-t border-[#FF2121]/10 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[9px] font-black text-gray-600 uppercase mb-1 block">Tema</label>
                        <input type="text" x-model="ai.topic" :placeholder="titleVal || 'Tema del artículo'"
                               class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-600 uppercase mb-1 block">Keywords</label>
                        <input type="text" x-model="ai.keywords"
                               class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-600 uppercase mb-1 block">Tono</label>
                        <select x-model="ai.tone" class="w-full bg-[#161616] border border-white/10 rounded-xl px-3 py-2 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                            <option class="bg-[#161616] text-gray-200 py-1" value="informativo">Informativo</option>
                            <option class="bg-[#161616] text-gray-200 py-1" value="tutorial">Tutorial</option>
                            <option class="bg-[#161616] text-gray-200 py-1" value="comparativa">Comparativa</option>
                            <option class="bg-[#161616] text-gray-200 py-1" value="opinion">Opinión</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-600 uppercase mb-1 block">Palabras</label>
                        <select x-model="ai.wordCount" class="w-full bg-[#161616] border border-white/10 rounded-xl px-3 py-2 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                            <option class="bg-[#161616] text-gray-200 py-1" value="400">~400</option>
                            <option class="bg-[#161616] text-gray-200 py-1" value="700" selected>~700</option>
                            <option class="bg-[#161616] text-gray-200 py-1" value="1000">~1000</option>
                            <option class="bg-[#161616] text-gray-200 py-1" value="1500">~1500</option>
                        </select>
                    </div>
                </div>
                <button type="button" @click="generateAi()" :disabled="aiLoading || (!ai.topic && !titleVal)"
                        class="w-full bg-[#FF2121] text-white font-black text-xs py-2.5 rounded-xl hover:bg-[#e01d1d] transition-all disabled:opacity-50 flex items-center justify-center gap-2 shadow-lg shadow-[#FF2121]/20">
                    <i class="fas fa-magic" :class="aiLoading?'animate-spin':''"></i>
                    <span x-text="aiLoading ? 'Generando con Gemini AI...' : 'Regenerar Contenido con IA'"></span>
                </button>
                <div x-show="aiError" class="text-rose-400 text-xs bg-rose-500/10 border border-rose-500/20 rounded-xl p-3" x-text="aiError"></div>
                <div x-show="aiSuccess" class="text-emerald-400 text-xs bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-3"><i class="fas fa-check mr-1"></i> Contenido regenerado con IA.</div>
            </div>
        </div>

        {{-- Editor --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="border-b border-white/[0.06] px-4 py-3 flex items-center gap-2 flex-wrap bg-white/[0.02]">
                <span class="text-[10px] font-black text-gray-600 uppercase tracking-widest mr-2">Contenido</span>
                <template x-for="btn in toolbar" :key="btn.cmd+btn.val">
                    <button type="button" @click="execCmd(btn.cmd, btn.val)"
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] text-gray-500 hover:text-white hover:bg-white/[0.06] transition-all" :title="btn.label">
                        <i :class="btn.icon"></i>
                    </button>
                </template>
                <div class="ml-auto flex items-center gap-2">
                    <span class="text-[10px] text-gray-600">Score SEO:</span>
                    <span class="text-[12px] font-black" :class="seoScore>=80?'text-emerald-400':seoScore>=50?'text-amber-400':'text-rose-400'" x-text="seoScore+'/100'"></span>
                </div>
            </div>
            <div id="editor" contenteditable="true" x-ref="editor" @input="onEditorChange()"
                 class="min-h-[400px] p-6 text-gray-300 focus:outline-none blog-prose-editor"
                 style="line-height:1.8;font-size:15px;">
                {!! old('body', $post->body) !!}
            </div>
            <input type="hidden" name="body" x-ref="bodyInput" value="{{ old('body', $post->body) }}">
        </div>

        {{-- SEO Checks --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5" x-show="Object.keys(seoChecks).length > 0">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3"><i class="fas fa-chart-line text-[#FF2121] mr-1"></i> Análisis SEO</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <template x-for="(check, key) in seoChecks" :key="key">
                    <div class="flex items-center gap-2 text-[11px] p-2 bg-white/[0.02] rounded-lg">
                        <i class="fas text-[10px]" :class="check.passed?'fa-check-circle text-emerald-400':'fa-times-circle text-rose-400'"></i>
                        <span class="text-gray-500" x-text="check.message"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Settings ── --}}
    <div class="space-y-5">

        {{-- Publish --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Estado</p>
            <div class="space-y-3 mb-4">
                @foreach(['draft'=>['Borrador','fa-pen','text-amber-400'],'published'=>['Publicado','fa-globe','text-emerald-400'],'scheduled'=>['Programado','fa-clock','text-blue-400']] as $val=>[$label,$icon,$color])
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="{{ $val }}"
                               {{ old('status', $post->status) === $val ? 'checked' : '' }} class="accent-[#FF2121]">
                        <span class="flex items-center gap-2 text-sm font-bold text-gray-400">
                            <i class="fas {{ $icon }} {{ $color }} text-[11px]"></i> {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="mb-4">
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Fecha de publicación</label>
                <input type="datetime-local" name="published_at"
                       value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
            </div>
            <label class="flex items-center gap-2.5 cursor-pointer mb-4">
                <input type="checkbox" name="featured" value="1" {{ old('featured', $post->featured) ? 'checked' : '' }} class="accent-[#FF2121]">
                <span class="text-xs font-bold text-gray-400"><i class="fas fa-star text-amber-400 mr-1"></i> Destacado</span>
            </label>
            <button type="submit" class="w-full bg-[#FF2121] hover:bg-[#e01d1d] text-white font-black text-sm py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>

        {{-- Thumbnail --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5" x-data="{thumb: '{{ $post->thumbnail ? $post->thumbnail_url : "" }}'}">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3"><i class="fas fa-image text-[#FF2121] mr-1"></i> Imagen de Portada</p>
            <div class="relative aspect-video rounded-xl overflow-hidden border-2 border-dashed border-white/[0.06] hover:border-[#FF2121]/30 transition-colors cursor-pointer"
                 @click="$refs.thumbInput.click()">
                <template x-if="thumb">
                    <img :src="thumb" class="w-full h-full object-cover">
                </template>
                <template x-if="!thumb">
                    <div class="w-full h-full flex flex-col items-center justify-center gap-2">
                        <i class="fas fa-cloud-arrow-up text-2xl text-gray-700"></i>
                        <span class="text-[10px] text-gray-600">Clic para cambiar imagen</span>
                    </div>
                </template>
                <input x-ref="thumbInput" type="file" name="thumbnail" accept="image/*" class="hidden"
                       @change="const f=$event.target.files[0]; if(f) { const r=new FileReader(); r.onload=e=>thumb=e.target.result; r.readAsDataURL(f); }">
            </div>
            @if($post->thumbnail)
                <p class="text-[9px] text-gray-700 mt-2">Dejar vacío para mantener la imagen actual.</p>
            @endif
        </div>

        {{-- Category & Tags --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5 space-y-4">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Taxonomía</p>
            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Categoría</label>
                <input type="text" name="category" x-model="catVal" list="category-list-edit"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                <datalist id="category-list-edit">
                    @foreach(['WordPress','SEO','Tutoriales','Plugins','Temas','WooCommerce','Elementor','Seguridad','Rendimiento','Noticias'] as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Tags (separadas por coma)</label>
                <input type="text" name="tags" x-model="tagsVal"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
                <div class="flex flex-wrap gap-1.5 mt-2" x-show="tagsVal">
                    <template x-for="tag in tagsVal.split(',').map(t=>t.trim()).filter(t=>t)" :key="tag">
                        <span class="text-[9px] font-bold text-gray-400 bg-white/[0.04] border border-white/[0.06] px-2 py-0.5 rounded" x-text="tag"></span>
                    </template>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="bg-[#111] border border-white/[0.06] rounded-2xl p-5 space-y-4">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest"><i class="fas fa-search text-[#FF2121] mr-1"></i> SEO</p>
            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">
                    Meta Title <span class="normal-case font-normal text-gray-700" x-text="'('+metaTitleVal.length+'/70)'"></span>
                </label>
                <input type="text" name="meta_title" x-model="metaTitleVal" maxlength="70"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">
                    Meta Description <span class="normal-case font-normal text-gray-700" x-text="'('+metaDescVal.length+'/160)'"></span>
                </label>
                <textarea name="meta_description" x-model="metaDescVal" rows="3" maxlength="160"
                          class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:border-[#FF2121]/40 resize-none">{{ old('meta_description', $post->meta_description) }}</textarea>
                <div class="mt-1 h-1 bg-white/[0.04] rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all"
                         :class="metaDescVal.length>=140&&metaDescVal.length<=160?'bg-emerald-500':metaDescVal.length>160?'bg-rose-500':'bg-amber-500'"
                         :style="'width:'+Math.min(100,(metaDescVal.length/160)*100)+'%'"></div>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-600 uppercase tracking-widest mb-2">Keywords</label>
                <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}"
                       class="w-full bg-white/[0.04] border border-white/[0.06] rounded-xl px-3 py-2.5 text-white text-xs focus:outline-none focus:border-[#FF2121]/40">
            </div>
        </div>

    </div>
</form>

<style>
.blog-prose-editor h2 { font-size:1.3rem; font-weight:900; color:white; margin:1.5rem 0 .75rem; border-bottom:1px solid rgba(255,255,255,.06); padding-bottom:.5rem; }
.blog-prose-editor h3 { font-size:1.05rem; font-weight:800; color:rgba(255,255,255,.9); margin:1.2rem 0 .5rem; }
.blog-prose-editor p { color:#999; margin-bottom:1rem; }
.blog-prose-editor strong { color:white; }
.blog-prose-editor ul { list-style:disc; padding-left:1.5rem; margin:.75rem 0; color:#999; }
.blog-prose-editor blockquote { border-left:3px solid #FF2121; padding:.75rem 1rem; background:rgba(255,33,33,.06); margin:1rem 0; color:rgba(255,255,255,.8); font-style:italic; border-radius:0 .5rem .5rem 0; }
</style>

<script>
window.blogEditor = function() {
    return {
        titleVal: @js(old('title', $post->title)),
        slugPreview: @js(old('slug', $post->slug)),
        excerptVal: @js(old('excerpt', $post->excerpt ?? '')),
        catVal: @js(old('category', $post->category ?? '')),
        tagsVal: @js(old('tags', is_array($post->tags) ? implode(', ', $post->tags) : ($post->tags ?? ''))),
        metaTitleVal: @js(old('meta_title', $post->meta_title ?? '')),
        metaDescVal: @js(old('meta_description', $post->meta_description ?? '')),
        slugEdited: false,
        aiOpen: false, aiLoading: false, aiError: '', aiSuccess: false,
        seoScore: 0, seoChecks: {},
        ai: { topic: '', keywords: '', tone: 'informativo', wordCount: '700' },
        toolbar: [
            { cmd:'formatBlock', val:'h2',    icon:'fas fa-heading',       label:'H2' },
            { cmd:'formatBlock', val:'h3',    icon:'fas fa-h3',            label:'H3' },
            { cmd:'bold',        val:null,    icon:'fas fa-bold',          label:'Negrita' },
            { cmd:'italic',      val:null,    icon:'fas fa-italic',        label:'Cursiva' },
            { cmd:'insertUnorderedList', val:null, icon:'fas fa-list-ul',  label:'Lista' },
            { cmd:'formatBlock', val:'blockquote', icon:'fas fa-quote-right', label:'Cita' },
            { cmd:'createLink',  val:'prompt',icon:'fas fa-link',          label:'Enlace' },
            { cmd:'removeFormat',val:null,    icon:'fas fa-remove-format', label:'Limpiar' },
        ],
        init() {
            this.$nextTick(() => {
                if (this.$refs.editor) {
                    this.$refs.bodyInput.value = this.$refs.editor.innerHTML;
                    this.calcSeoScore();
                }
            });
        },
        updateSlug() {
            if (!this.slugEdited) this.slugPreview = this.toSlug(this.titleVal);
        },
        toSlug(str) {
            if (!str) return '';
            return str.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-');
        },
        execCmd(cmd, val) {
            if (cmd==='createLink') { const u=prompt('URL:'); if(u) document.execCommand('createLink',false,u); }
            else document.execCommand(cmd, false, val||null);
            this.$refs.editor.focus(); this.onEditorChange();
        },
        onEditorChange() {
            this.$refs.bodyInput.value = this.$refs.editor.innerHTML;
            this.calcSeoScore();
        },
        calcSeoScore() {
            const html = this.$refs.editor ? this.$refs.editor.innerHTML : '';
            const text = this.$refs.editor ? (this.$refs.editor.innerText || '') : '';
            const wc = text.trim().split(/\s+/).filter(w=>w).length;
            const c = {};
            let t = 0;
            const h2 = (html.match(/<h2/gi)||[]).length;
            c.h2={passed:h2>=2,message:h2+' H2',points:h2>=2?20:h2*10}; t+=c.h2.points;
            c.length={passed:wc>=400&&wc<=1500,message:wc+' palabras',points:wc>=400&&wc<=1500?25:wc>=200?12:5}; t+=c.length.points;
            const s=(html.match(/<strong/gi)||[]).length;
            c.bold={passed:s>=4&&s<=12,message:s+' negritas',points:s>=4&&s<=12?15:s>0?8:0}; t+=c.bold.points;
            const l=(html.match(/<ul/gi)||[]).length;
            c.lists={passed:l>=1,message:l+' lista(s)',points:l>=2?20:l>=1?10:0}; t+=c.lists.points;
            const bq=(html.match(/<blockquote/gi)||[]).length;
            c.blockquote={passed:bq>=1,message:bq+' cita(s)',points:bq>=1?10:0}; t+=c.blockquote.points;
            const mdLen = this.metaDescVal ? this.metaDescVal.length : 0;
            c.metaDesc={passed:mdLen>=120&&mdLen<=160,message:'Meta: '+mdLen+' ch',points:mdLen>=120&&mdLen<=160?10:5}; t+=c.metaDesc.points;
            this.seoChecks=c; this.seoScore=Math.min(100,t);
        },
        async generateAi() {
            const topic = this.ai.topic || this.titleVal;
            if (!topic) {
                this.aiError = 'Por favor escribe el tema o título del artículo primero.';
                return;
            }
            this.aiLoading=true; this.aiError=''; this.aiSuccess=false;
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                const res = await fetch('{{ route("admin.blog.ai.generate") }}', {
                    method:'POST',
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json',
                        'X-CSRF-TOKEN':token
                    },
                    body:JSON.stringify({topic,keywords:this.ai.keywords,tone:this.ai.tone,word_count:parseInt(this.ai.wordCount || 700)})
                });
                const data = await res.json();
                if (data.success) {
                    const c=data.content;
                    this.titleVal=c.title; this.slugPreview=c.slug; this.excerptVal=c.excerpt;
                    this.catVal=c.category; this.tagsVal=(c.tags||[]).join(', ');
                    this.metaTitleVal=c.meta_title; this.metaDescVal=c.meta_description;
                    this.$refs.editor.innerHTML=c.body; this.$refs.bodyInput.value=c.body;
                    this.onEditorChange(); this.aiSuccess=true; this.aiOpen=false;
                } else { this.aiError=data.message||'Error al generar contenido.'; }
            } catch(e) { this.aiError='Error: '+e.message; }
            finally { this.aiLoading=false; }
        }
    };
};
</script>

@endsection
