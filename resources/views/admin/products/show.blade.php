@extends('layouts.admin')

@section('title', 'Detalle de Producto: ' . $product->name)

@section('content')
<style>
    .prose h2 { margin-top: 1.5rem !important; margin-bottom: 0.75rem !important; font-weight: 800; font-size: 1.25rem; color: white !important; }
    .prose h3 { margin-top: 1.25rem !important; margin-bottom: 0.5rem !important; font-weight: 700; font-size: 1.1rem; color: white !important; }
    .prose p { margin-bottom: 1rem !important; color: #94a3b8 !important; }
    .prose ul { list-style-type: disc !important; padding-left: 1.25rem !important; margin-bottom: 1.25rem !important; color: #94a3b8 !important; }
    .prose li { margin-bottom: 0.4rem !important; color: #94a3b8 !important; }
    .prose a { color: #FF2121 !important; font-weight: 700; text-decoration: underline; }
    .prose a:hover { color: white !important; }
</style>
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('admin.products.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">{{ $product->name }}</h1>
            <p class="text-gray-400 mt-1">ID: #{{ $product->id }} • Publicado el {{ optional($product->created_at)->format('d/m/Y') ?? 'N/A' }}</p>
        </div>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.products.edit', $product) }}" class="bg-[#F51B1B] hover:bg-[#FF2121] text-white px-6 py-2.5 rounded-xl font-bold transition-all duration-200 flex items-center shadow-lg shadow-[#F51B1B]/20">
            <i class="fas fa-edit mr-2"></i> Editar Producto
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    <!-- Left Column: Details -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Overview Card -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <div class="flex items-start justify-between mb-8">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="bg-[#FF2121]/20 p-2 rounded-lg"><i class="fas fa-info-circle text-[#FF2121] text-sm"></i></div>
                    Vista General
                </h2>
                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $product->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20' }}">
                    {{ $product->is_active ? 'Publicado' : 'Borrador' }}
                </span>
            </div>
            
            <div class="prose prose-invert max-w-none text-gray-300">
                <h4 class="text-white">Descripción Corta:</h4>
                <p class="mb-6">{{ $product->description }}</p>
                
                <h4 class="text-white">Descripción Completa:</h4>
                <div class="bg-gray-900/50 p-6 rounded-2xl border border-white/5 font-sans">
                    {!! $product->full_description !!}
                </div>
            </div>
        </div>

        <!-- Versions Card -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl" x-data="{ showModal: false }">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="bg-amber-500/20 p-2 rounded-lg"><i class="fas fa-code-branch text-amber-500 text-sm"></i></div>
                    Historial de Versiones
                </h2>
                <button @click="showModal = true" class="bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                    <i class="fas fa-plus mr-2"></i> Nueva Versión
                </button>
            </div>
            
            <div class="space-y-4">
                @forelse($product->versions as $version)
                    <div class="p-6 bg-gray-900/30 rounded-2xl border border-white/5 group hover:bg-gray-900/50 transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-sm font-mono font-bold text-[#FF2121] mr-4 border border-white/5 shadow-inner">
                                    V{{ $version->version_number }}
                                </div>
                                <div>
                                    <p class="text-white font-bold text-lg">Versión {{ $version->version_number }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">{{ $version->released_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right mr-4 hidden md:block">
                                    <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mb-1 text-opacity-50">Tamaño</p>
                                    <p class="text-xs font-mono text-gray-300">{{ $version->formatted_size }}</p>
                                </div>
                                <a href="{{ asset('storage/' . $version->file_path) }}" class="w-10 h-10 bg-[#FF2121]/10 text-[#FF2121] rounded-xl flex items-center justify-center hover:bg-[#FF2121] hover:text-white transition-all shadow-lg shadow-[#FF2121]/10">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @if($version->changelog)
                            <div class="mt-4 pt-4 border-t border-white/5 text-gray-400 text-sm leading-relaxed italic">
                                "{!! nl2br(e($version->changelog)) !!}"
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-16 opacity-30">
                        <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-dashed border-gray-700">
                            <i class="fas fa-history text-3xl"></i>
                        </div>
                        <p class="text-lg font-medium">No hay versiones registradas.</p>
                        <p class="text-sm mt-1">Acomoda la primera versión de este producto.</p>
                    </div>
                @endforelse
            </div>

            <!-- Modal for New Version -->
            <div x-show="showModal" 
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="display: none;">
                
                <div class="flex items-center justify-center min-h-screen px-4 py-12">
                    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="showModal = false"></div>
                    
                    <div class="relative bg-[#0d0d0d] w-full max-w-xl rounded-[40px] border border-white/10 shadow-3xl p-10 overflow-hidden transform transition-all"
                         @click.stop>
                        
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#F51B1B]/10 blur-[100px] rounded-full"></div>

                        <div class="flex justify-between items-center mb-8 relative z-10">
                            <h3 class="text-2xl font-black text-white">Nueva Versión</h3>
                            <button @click="showModal = false" class="text-gray-500 hover:text-white transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form action="{{ route('admin.products.versions.store', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
                            @csrf
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Número de Versión</label>
                                    <input type="text" name="version_number" required placeholder="Ej: 2.1.0"
                                        class="w-full bg-gray-900 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Fecha de Lanzamiento</label>
                                    <input type="date" name="released_at" value="{{ date('Y-m-d') }}" required
                                        class="w-full bg-gray-900 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Archivo de la Versión (.ZIP)</label>
                                <div class="relative group">
                                    <div class="relative bg-gray-900 border-2 border-dashed border-white/10 rounded-2xl p-6 text-center group-hover:border-[#FF2121]/40 transition-all">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-600 mb-2"></i>
                                        <input type="file" name="version_file" accept=".zip" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <p class="text-xs text-gray-500">Únicamente formato .ZIP</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Notas de Versión (Changelog)</label>
                                <textarea name="changelog" rows="4" 
                                    class="w-full bg-gray-900 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all resize-none"
                                    placeholder="¿Qué hay de nuevo en esta versión?"></textarea>
                            </div>

                            <button type="submit" class="w-full py-5 gradient-bg text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-[#F51B1B]/20 hover:scale-[1.02] active:scale-95 transition-all">
                                Publicar Versión <i class="fas fa-rocket ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Stats & Meta -->
    <div class="space-y-8">
        <!-- Main Stats -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <div class="text-center mb-8">
                <div class="text-[10px] font-black text-[#FF2121] uppercase tracking-[0.2em] mb-2">Precio del Producto</div>
                <div class="text-5xl font-black text-white tracking-tighter">
                    @if($product->price == 0)
                        FREE
                    @else
                        <span class="text-2xl text-[#FF2121] mr-1">$</span>{{ number_format($product->price, 2) }}
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-white/5 text-center">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Descargas</p>
                    <p class="text-xl font-bold text-white">{{ number_format($product->downloads_count) }}</p>
                </div>
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-white/5 text-center">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Ventas</p>
                    <p class="text-xl font-bold text-white">{{ number_format($product->orderItems->count()) }}</p>
                </div>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5">Clasificación</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-500 uppercase">Categoría:</span>
                    <span class="text-xs font-bold text-[#FF2121] uppercase bg-[#FF2121]/10 px-2.5 py-1 rounded-lg border border-[#FF2121]/20">{{ $product->category->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-500 uppercase">Versión Actual:</span>
                    <span class="text-xs font-bold text-white uppercase">V{{ $product->version }}</span>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5">Imagen Principal</h3>
            <div class="rounded-2xl overflow-hidden border border-white/10 bg-gray-900 aspect-video flex items-center justify-center">
                @if($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-image text-3xl text-gray-800"></i>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection