@extends('layouts.admin')

@section('title', 'Nuevo Producto')

@section('content')
<style>
    /* Modern Glowing Inputs */
    .modern-input {
        background-color: rgba(13, 13, 16, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .modern-input:hover {
        border-color: rgba(255, 255, 255, 0.15);
    }
    .modern-input:focus {
        border-color: rgba(245, 27, 27, 0.5) !important;
        box-shadow: 0 0 20px rgba(245, 27, 27, 0.15);
        background-color: rgba(13, 13, 16, 0.9);
    }
    
    .modern-input-amber:focus {
        border-color: rgba(245, 158, 11, 0.5) !important;
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.15);
        background-color: rgba(13, 13, 16, 0.9);
    }

    /* Animated Dashed Borders for Dropzones */
    .dropzone-animated-thumb {
        background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='24' ry='24' stroke='rgba(255, 255, 255, 0.08)' stroke-width='2' stroke-dasharray='10%2c 10' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
        transition: all 0.3s ease;
    }
    .dropzone-animated-thumb:hover {
        background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='24' ry='24' stroke='rgba(245, 27, 27, 0.5)' stroke-width='2' stroke-dasharray='10%2c 6' stroke-dashoffset='15' stroke-linecap='square'/%3e%3c/svg%3e");
        background-color: rgba(245, 27, 27, 0.02);
    }

    .dropzone-animated-zip {
        background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='24' ry='24' stroke='rgba(255, 255, 255, 0.08)' stroke-width='2' stroke-dasharray='10%2c 10' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
        transition: all 0.3s ease;
    }
    .dropzone-animated-zip:hover {
        background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='24' ry='24' stroke='rgba(16, 185, 129, 0.5)' stroke-width='2' stroke-dasharray='10%2c 6' stroke-dashoffset='15' stroke-linecap='square'/%3e%3c/svg%3e");
        background-color: rgba(16, 185, 129, 0.02);
    }

    /* Premium Checkbox Cards */
    .checkbox-card {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.05);
        background-color: rgba(255, 255, 255, 0.02);
    }
    .checkbox-card:hover {
        border-color: rgba(255, 255, 255, 0.1);
        background-color: rgba(255, 255, 255, 0.04);
    }
    .checkbox-card input[type="checkbox"]:checked + label::before {
        transform: scale(1);
    }
</style>

<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('admin.products.index') }}" class="mr-4 w-11 h-11 bg-gray-900/60 rounded-2xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-900 transition-all border border-white/5 shadow-lg shadow-black/20">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight bg-gradient-to-r from-white via-gray-100 to-gray-400 bg-clip-text text-transparent">Nuevo Producto</h1>
            <p class="text-gray-400 text-xs mt-1">Lanza un nuevo recurso digital al marketplace.</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    @csrf
    
    <!-- Error Display -->
    @if ($errors->any())
        <div id="error-container" class="lg:col-span-3 bg-rose-500/10 border border-rose-500/20 text-rose-400 p-5 rounded-2xl mb-2 flex items-start gap-3 shadow-lg shadow-rose-950/20">
            <i class="fas fa-exclamation-circle mt-0.5 text-lg"></i>
            <div>
                <h4 class="font-bold mb-1">Por favor corrige los siguientes errores:</h4>
                <ul id="error-list" class="list-disc list-inside text-sm font-semibold opacity-90 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    
    <!-- Left Column: Content -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Basic Info Card -->
        <div class="bg-gray-900/40 backdrop-blur-xl p-8 rounded-3xl border border-white/[0.05] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#F51B1B]/5 blur-[100px] rounded-full pointer-events-none"></div>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4 border-b border-white/5 pb-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-3">
                    <div class="bg-[#F51B1B]/10 p-2 rounded-xl border border-[#F51B1B]/20">
                        <i class="fas fa-info-circle text-[#F51B1B] text-sm"></i>
                    </div>
                    Información Básica
                </h2>
                
                <button type="button" 
                        id="generateSeoContent" 
                        class="px-4 py-2.5 bg-[#F51B1B]/10 hover:bg-[#F51B1B] text-[#F51B1B] hover:text-white border border-[#F51B1B]/20 font-extrabold text-[10px] uppercase tracking-wider rounded-xl transition-all shadow-lg hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap self-start sm:self-auto">
                    <i class="fas fa-sparkles text-[10px]"></i>
                    <span>Generar con IA</span>
                </button>
            </div>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2.5 ml-1">Nombre del Producto</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full modern-input rounded-2xl px-5 py-4 text-white focus:outline-none placeholder:text-gray-700 text-sm shadow-inner" placeholder="Ej: OceanWP Pro Bundle">
                    <div id="duplicate-warning" class="mt-2.5 bg-rose-500/10 border border-rose-500/20 text-rose-400 p-3 rounded-xl flex items-center gap-2 text-xs font-semibold" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Este producto ya existe en el sistema (evita duplicarlo).</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2.5 ml-1">Descripción Corta</label>
                    <textarea name="description" required rows="3" class="w-full modern-input rounded-2xl px-5 py-4 text-white focus:outline-none placeholder:text-gray-700 resize-none text-sm shadow-inner" placeholder="Breve resumen que aparecerá en los listados...">{{ old('description') }}</textarea>
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-2.5 ml-1">
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Descripción Completa (HTML)</label>
                        <span class="text-[9px] font-bold text-gray-600 bg-white/5 border border-white/5 px-2 py-0.5 rounded">Soporta HTML</span>
                    </div>
                    <textarea name="full_description" rows="10" class="w-full modern-input rounded-2xl px-5 py-4 text-white focus:outline-none placeholder:text-gray-700 font-mono text-xs leading-relaxed shadow-inner" placeholder="Detalles técnicos, características clave, guías de uso...">{{ old('full_description') }}</textarea>
                </div>
            </div>

            <!-- SEO AI Assistant inline controls -->
            <div class="mt-6 pt-6 border-t border-white/5 space-y-4">
                <div class="relative z-10">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">
                        Keywords Objetivo (Opcional - se auto-generan)
                    </label>
                    <input type="text" 
                           id="seoKeywords" 
                           placeholder="Ej: asaptheme, premium plugin (separa con comas)"
                           class="w-full modern-input rounded-2xl px-5 py-3 text-xs focus:outline-none placeholder:text-gray-700 shadow-inner">
                </div>
                
                <!-- Loading State -->
                <div id="aiLoadingState" class="hidden bg-[#F51B1B]/5 border border-[#F51B1B]/15 rounded-2xl p-5 relative z-10 animate-pulse">
                    <div class="flex items-center gap-4 text-[#F51B1B]">
                        <div class="w-10 h-10 rounded-xl bg-[#F51B1B]/10 flex items-center justify-center border border-[#F51B1B]/20">
                            <i class="fas fa-circle-notch fa-spin text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-white">Generando contenido SEO optimizado...</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">Analizando palabras clave e implementando enlazado interno. Espera 10-15s.</p>
                        </div>
                    </div>
                </div>
                
                <!-- SEO Score -->
                <div id="seoScoreDisplay" class="hidden bg-gray-950/60 border border-white/5 rounded-2xl p-5 relative z-10">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-white/5">
                        <h4 class="font-bold text-sm text-white flex items-center gap-2">
                            <i class="fas fa-chart-line text-[#F51B1B]"></i>
                            Análisis SEO
                        </h4>
                        <div class="flex items-center gap-1.5 bg-gray-900 px-3.5 py-1.5 rounded-xl border border-white/5">
                            <div class="text-2xl font-black leading-none" id="seoScoreValue">0</div>
                            <span class="text-gray-500 text-xs">/100</span>
                        </div>
                    </div>
                    <div id="seoChecks" class="space-y-2.5 text-xs"></div>
                </div>
                
                <!-- Rate Limit Notice -->
                <div id="rateLimitNotice" class="hidden bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 text-amber-400 text-xs flex items-center gap-3 relative z-10">
                    <i class="fas fa-clock text-base"></i>
                    <span>Espera <span id="countdown" class="font-mono font-bold text-sm">3</span> segundos antes de volver a solicitar contenido con IA.</span>
                </div>
            </div>
        </div>

        <!-- Product Files Card -->
        <div class="bg-gray-900/40 backdrop-blur-xl p-8 rounded-3xl border border-white/[0.05] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-64 h-64 bg-emerald-500/5 blur-[100px] rounded-full pointer-events-none"></div>
            
            <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-3">
                <div class="bg-emerald-500/10 p-2 rounded-xl border border-emerald-500/20">
                    <i class="fas fa-folder-open text-emerald-400 text-sm"></i>
                </div>
                Archivos del Producto
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thumbnail Dropzone -->
                <div class="group relative flex flex-col">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Imagen Principal (Thumbnail)</label>
                    <div id="thumbnail-dropzone" class="relative dropzone-animated-thumb bg-gray-950/60 rounded-2xl p-8 text-center h-44 flex flex-col items-center justify-center cursor-pointer transition-all border border-transparent overflow-hidden">
                        <div id="thumbnail-placeholder" class="pointer-events-none">
                            <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-105 transition-transform">
                                <i class="fas fa-image text-gray-500 group-hover:text-[#F51B1B] transition-colors"></i>
                            </div>
                            <p class="text-xs font-bold text-white">Subir Imagen</p>
                            <p class="text-[9px] text-gray-500 mt-1">JPG, PNG o WEBP (Máx. 5MB)</p>
                        </div>
                        <img id="thumbnail-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                        <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    </div>
                </div>
                
                <!-- ZIP Dropzone -->
                <div class="group relative flex flex-col">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Archivo Principal (.ZIP)</label>
                    <div id="resumable-drop" class="relative dropzone-animated-zip bg-gray-950/60 rounded-2xl p-8 text-center h-44 flex flex-col items-center justify-center cursor-pointer transition-all border border-transparent">
                        <div id="file-wrapper" class="pointer-events-none flex flex-col items-center justify-center w-full">
                            <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                                <i id="file-icon" class="fas fa-file-archive text-gray-500 group-hover:text-emerald-400 transition-colors"></i>
                            </div>
                            <div id="file-info" class="w-full">
                                <p class="text-xs font-bold text-white">Subir Archivo ZIP Principal</p>
                                <p class="text-[9px] text-gray-500 mt-1">Arrastra aquí tu zip o haz click</p>
                                <p class="text-[8px] text-emerald-500/80 font-bold uppercase tracking-wider mt-1.5">Soporta +10GB (Fragmentado)</p>
                            </div>
                        </div>
                        <button type="button" id="resumable-browse" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"></button>
                    </div>
                    
                    <!-- Progress Bar for Chunked Upload -->
                    <div id="chunk-progress-container" class="hidden mt-4 bg-gray-950/40 border border-white/5 p-4 rounded-2xl shadow-inner">
                        <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-2">
                            <span id="chunk-status">Subiendo archivo...</span>
                            <span id="chunk-percent" class="font-mono text-white text-xs">0%</span>
                        </div>
                        <div class="w-full bg-gray-900 rounded-full h-2 overflow-hidden border border-white/5">
                            <div id="chunk-bar" class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full w-0 transition-all duration-300 relative">
                                <div class="absolute inset-0 bg-white/25 animate-pulse"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input to store the final backend path -->
                    <input type="hidden" name="uploaded_file_path" id="uploaded_file_path">
                </div>
            </div>

            <!-- Second Extra File (.ZIP) & Label -->
            <div class="mt-6 pt-6 border-t border-white/5 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div class="group relative flex flex-col">
                    <label class="block text-[10px] font-black text-amber-500 uppercase tracking-widest mb-3 ml-1 flex items-center gap-1.5">
                        <i class="fas fa-file-zipper"></i>
                        Paquete de Actualización / Archivo Adicional (.ZIP) (Opcional)
                    </label>
                    <div class="relative bg-gray-950/60 border-2 border-dashed border-white/10 hover:border-amber-500/40 rounded-2xl p-6 text-center h-36 flex flex-col items-center justify-center cursor-pointer transition-all">
                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-600 group-hover:text-amber-400 mb-2 transition-colors"></i>
                        <p class="text-xs font-bold text-white">Subir Paquete Adicional</p>
                        <p class="text-[9px] text-gray-500 mt-0.5">Únicamente formato .ZIP</p>
                        <input type="file" name="update_package_file" accept=".zip" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">
                        Nombre / Etiqueta del Archivo Adicional
                    </label>
                    <input type="text" 
                           name="extra_file_name" 
                           value="{{ old('extra_file_name', 'Paquete de Actualización (.ZIP)') }}"
                           placeholder="Ej: Paquete de Actualización, Templates & Addons, Child Theme"
                           class="w-full modern-input rounded-2xl px-5 py-4 text-xs text-white focus:outline-none placeholder:text-gray-700 shadow-inner">
                    <p class="text-[9px] text-gray-500 ml-1">Si subes este 2do archivo, al hacer clic en "Descargar" se desplegará el popup con ambas opciones para el usuario.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Settings -->
    <div class="space-y-8">
        
        <!-- Categorization Card -->
        <div class="bg-gray-900/40 backdrop-blur-xl p-8 rounded-3xl border border-white/[0.05] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-amber-500/5 blur-[80px] rounded-full pointer-events-none"></div>
            
            <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-3">
                <div class="bg-amber-500/10 p-2 rounded-xl border border-amber-500/20">
                    <i class="fas fa-tags text-amber-500 text-sm"></i>
                </div>
                Ajustes & Taxonomía
            </h2>
            
            <div class="space-y-6">
                <!-- Category Select -->
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2.5 ml-1">Elegir Categoría</label>
                    <select name="category_id" required class="w-full bg-gray-950/60 border border-white/10 rounded-2xl px-4 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#F51B1B]/50 transition-all text-sm">
                        <option value="" disabled {{ !old('category_id') ? 'selected' : '' }} class="bg-gray-950">Seleccionar categoría...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="bg-gray-950">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Badge Select -->
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2.5 ml-1">Insignia (Badge)</label>
                    <select name="badge" class="w-full bg-gray-950/60 border border-white/10 rounded-2xl px-4 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#F51B1B]/50 transition-all text-sm">
                        <option value="" class="bg-gray-955">Ninguna insignia</option>
                        <option value="Más Vendido" class="bg-gray-955">🔥 Más Vendido</option>
                        <option value="Trending" class="bg-gray-955">⚡ Trending</option>
                        <option value="Popular" class="bg-gray-955">⭐️ Popular</option>
                        <option value="Nuevo" class="bg-gray-955">✨ Nuevo</option>
                        <option value="Licencia" class="bg-gray-955 font-bold text-amber-500">🔑 Licencia (Premium)</option>
                    </select>
                </div>
                
                <!-- Hidden field auto-populated by category -->
                <input type="hidden" name="type" id="product-type" value="theme">
                
                <!-- Price Input -->
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2.5 ml-1">Precio Unitario ($)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-[#F51B1B] font-bold text-sm">$</span>
                        <input type="number" name="price" step="0.01" required value="{{ old('price', '0.00') }}" class="w-full modern-input rounded-2xl pl-9 pr-5 py-4 text-white focus:outline-none font-mono font-bold text-base shadow-inner">
                    </div>
                </div>

                <!-- Reward Points & Multiplier -->
                <div class="grid grid-cols-2 gap-4 pt-5 border-t border-white/5">
                    <div>
                        <label class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Puntos Fijos</label>
                        <input type="number" min="0" name="reward_points" value="{{ old('reward_points', '0') }}" class="w-full modern-input rounded-2xl px-4 py-3 text-white focus:outline-none font-mono text-xs shadow-inner">
                        <span class="text-[8px] text-gray-600 mt-1.5 block leading-tight">Deja 0 para calcular automático</span>
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Multiplicador</label>
                        <input type="number" step="0.1" min="1" name="points_multiplier" value="{{ old('points_multiplier', '1.0') }}" class="w-full modern-input-amber modern-input rounded-2xl px-4 py-3 text-white focus:outline-none font-mono text-xs shadow-inner">
                        <span class="text-[8px] text-gray-600 mt-1.5 block leading-tight">Ej: 1.5 = +50% Puntos</span>
                    </div>
                </div>

                <!-- Version Input -->
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2.5 ml-1">Versión de Lanzamiento</label>
                    <input type="text" name="version" required value="{{ old('version', '1.0.0') }}" class="w-full modern-input rounded-2xl px-5 py-3.5 text-white focus:outline-none font-mono text-xs shadow-inner">
                </div>

                <!-- Publish Switch Card -->
                <div class="checkbox-card flex items-center justify-between p-4.5 rounded-2xl cursor-pointer hover:bg-white/[0.04] transition-all group border border-white/5 relative">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#F51B1B]/10 flex items-center justify-center border border-[#F51B1B]/20 text-[#F51B1B] text-xs">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-white block">Publicar recurso</span>
                            <span class="text-[9px] text-gray-500 block mt-0.5">Visible en la tienda</span>
                        </div>
                    </div>
                    <div class="relative flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="is_active" checked class="w-6 h-6 text-[#F51B1B] bg-gray-950 border-white/10 rounded-lg focus:ring-[#F51B1B] focus:ring-offset-gray-950 transition-all cursor-pointer">
                    </div>
                </div>

                <!-- License Switch Card -->
                <div class="checkbox-card flex items-center justify-between p-4.5 rounded-2xl cursor-pointer hover:bg-white/[0.04] transition-all group border border-white/5 relative">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20 text-amber-500 text-xs">
                            <i class="fas fa-key"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-white block">Licencia Oficial</span>
                            <span class="text-[9px] text-gray-500 block mt-0.5">Recurso legal / activado</span>
                        </div>
                    </div>
                    <div class="relative flex items-center">
                        <input type="hidden" name="is_license" value="0">
                        <input type="checkbox" name="is_license" value="1" id="is_license" class="w-6 h-6 text-amber-500 bg-gray-955 border-white/10 rounded-lg focus:ring-amber-500 focus:ring-offset-gray-955 transition-all cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Publish Button -->
        <button type="submit" class="w-full bg-[#F51B1B] hover:bg-[#FF2121] text-white py-5 rounded-3xl font-extrabold text-sm uppercase tracking-widest transition-all duration-300 shadow-xl shadow-[#F51B1B]/20 hover:scale-[1.01] active:scale-95 group relative overflow-hidden flex items-center justify-center gap-2">
            <span class="relative z-10 flex items-center gap-2">
                <span>Publicar Producto</span> 
                <i class="fas fa-paper-plane text-xs group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
        </button>
    </div>
</form>

<!-- Progress Overlay -->
<div id="upload-overlay" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center">
    <div class="bg-gray-950 border border-white/10 p-8 rounded-3xl w-full max-w-md shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#F51B1B]/10 blur-3xl rounded-full -mr-16 -mt-16"></div>
        
        <h3 class="text-lg font-bold text-white mb-1.5 relative z-10 flex items-center gap-2">
            <i class="fas fa-cloud-upload-alt text-[#F51B1B]"></i>
            <span>Subiendo Producto...</span>
        </h3>
        <p class="text-gray-400 text-xs mb-6 relative z-10 leading-relaxed">Por favor espera, estamos procesando los archivos. No cierres esta pestaña.</p>
        
        <div class="w-full bg-gray-900 border border-white/5 rounded-full h-3.5 overflow-hidden relative">
            <div id="progress-bar" class="bg-gradient-to-r from-[#FF2121] to-[#F51B1B] h-full w-0 transition-all duration-300 ease-out relative">
                 <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
            </div>
        </div>
        <div class="flex justify-between text-[10px] font-bold mt-2 text-gray-500 uppercase tracking-widest">
            <span id="progress-text" class="font-mono text-white text-xs">0%</span>
            <span>Guardando datos...</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var r = new Resumable({
            target: '{{ route('admin.products.upload.chunk') }}',
            query: { _token: '{{ csrf_token() }}' },
            fileType: ['zip', 'rar', '7z'],
            chunkSize: 2 * 1024 * 1024, // 2MB chunk size to avoid php.ini limits
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1
        });

        if (!r.support) {
            alert('Tu navegador no soporta subidas resumibles.');
        } else {
            var dropElement = document.getElementById('resumable-drop');
            var browseElement = document.getElementById('resumable-browse');
            
            r.assignBrowse(browseElement);
            r.assignDrop(dropElement);

            r.on('fileAdded', function(file) {
                 // Show file info
                document.getElementById('file-icon').className = 'fas fa-spinner fa-spin text-2xl text-emerald-400 mb-3 transition-all';
                document.getElementById('file-info').innerHTML = `
                    <p class="text-sm text-white font-bold truncate px-4">${file.fileName}</p>
                    <p class="text-[9px] text-gray-400 font-mono mt-1">Preparando subida de fragmentos...</p>
                `;
                document.getElementById('chunk-progress-container').classList.remove('hidden');
                r.upload(); // Auto start
            });

            r.on('fileProgress', function(file) {
                var percent = Math.floor(file.progress() * 100);
                document.getElementById('chunk-bar').style.width = percent + '%';
                document.getElementById('chunk-percent').innerText = percent + '%';
            });

            r.on('fileSuccess', function(file, message) {
                var response = JSON.parse(message);
                document.getElementById('uploaded_file_path').value = response.path;
                
                // Visual Success
                document.getElementById('file-icon').className = 'fas fa-check-circle text-2xl text-emerald-400 mb-3 transition-all';
                document.getElementById('file-info').innerHTML = `
                    <p class="text-sm text-white font-bold truncate px-4">${file.fileName}</p>
                    <p class="text-[9px] text-emerald-400 font-bold uppercase tracking-wider mt-1">¡Subida Completada!</p>
                `;
                document.getElementById('chunk-status').innerText = 'Completado';
                document.getElementById('chunk-bar').className = 'bg-emerald-500 h-full w-full';
            });

            r.on('fileError', function(file, message) {
                document.getElementById('file-icon').className = 'fas fa-times-circle text-2xl text-rose-500 mb-3 transition-all';
                document.getElementById('chunk-status').innerText = 'Error en subida';
                document.getElementById('chunk-status').className = 'text-rose-500';
            });
        }
    });
</script>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const overlay = document.getElementById('upload-overlay');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    
    const uploadedPath = document.getElementById('uploaded_file_path').value;

    if (uploadedPath) {
        // Mostrar overlay cosmético
        overlay.classList.remove('hidden');
        progressBar.style.width = '100%';
        progressText.innerText = '100%';
        document.getElementById('progress-text').innerText = 'Guardando datos...';
    }
});

// Thumbnail Preview
document.getElementById('thumbnail-input').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('thumbnail-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            const placeholder = document.getElementById('thumbnail-placeholder');
            if(placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(this.files[0]);
    }
});

// Auto-detect product type from category
document.querySelector('select[name="category_id"]').addEventListener('change', function() {
    const categoryText = this.options[this.selectedIndex]?.text.toLowerCase() || '';
    const typeField = document.getElementById('product-type');
    
    if (categoryText.includes('plugin')) {
        typeField.value = 'plugin';
    } else if (categoryText.includes('gpl') || categoryText.includes('gratis') || categoryText.includes('free')) {
        typeField.value = 'gpl';
    } else if (categoryText.includes('premium')) {
        typeField.value = 'premium';
    } else {
        typeField.value = 'theme'; // Default
    }
});

// ============================================
// AI CONTENT GENERATOR
// ============================================

let rateLimitActive = false;
let countdownInterval = null;

const seoBtn = document.getElementById('generateSeoContent');
if (seoBtn) {
    seoBtn.addEventListener('click', async function() {
    // Check rate limit
    if (rateLimitActive) {
        return;
    }
    
    const productName = document.querySelector('input[name="name"]').value;
    const categorySelect = document.querySelector('select[name="category_id"]');
    const categoryText = categorySelect.options[categorySelect.selectedIndex]?.text || '';
    
    // Detect type from category name or default to 'theme'
    let productType = 'theme';
    if (categoryText.toLowerCase().includes('plugin')) {
        productType = 'plugin';
    }
    
    const keywords = document.getElementById('seoKeywords').value
        .split(',')
        .map(k => k.trim())
        .filter(k => k);
    
    if (!productName) {
        alert('Por favor ingresa el nombre del producto primero');
        return;
    }
    
    // Show loading
    document.getElementById('aiLoadingState').classList.remove('hidden');
    document.getElementById('seoScoreDisplay').classList.add('hidden');
    this.disabled = true;
    
    try {
        const response = await fetch('{{ route("admin.ai.generate.seo") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_name: productName,
                product_type: productType,
                keywords: keywords,
                features: []
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Fill fields
            document.querySelector('textarea[name="description"]').value = data.content.short_description;
            document.querySelector('textarea[name="full_description"]').value = data.content.full_description;
            
            // Show SEO Score
            displaySeoScore(data.seo_score);
            
            // Show success notification
            showNotification('¡Contenido SEO generado exitosamente!', 'success');
            
            // Start rate limit
            startRateLimit();
        } else {
            showNotification(data.message || 'Error al generar contenido', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error al generar contenido. Verifica tu API key de Gemini.', 'error');
    } finally {
        document.getElementById('aiLoadingState').classList.add('hidden');
        this.disabled = false;
    }
});
} // End if(seoBtn)

// Display SEO Score
function displaySeoScore(score) {
    const scoreDisplay = document.getElementById('seoScoreDisplay');
    const scoreValue = document.getElementById('seoScoreValue');
    const checksContainer = document.getElementById('seoChecks');
    
    scoreValue.textContent = score.total;
    
    // Color based on score
    if (score.total >= 80) {
        scoreValue.className = 'text-2xl font-black text-green-400 leading-none';
    } else if (score.total >= 60) {
        scoreValue.className = 'text-2xl font-black text-yellow-400 leading-none';
    } else {
        scoreValue.className = 'text-2xl font-black text-red-400 leading-none';
    }
    
    // Display checks
    checksContainer.innerHTML = '';
    for (const [key, check] of Object.entries(score.checks)) {
        const checkEl = document.createElement('div');
        checkEl.className = 'flex items-center justify-between py-1.5 border-b border-white/[0.03] last:border-0';
        checkEl.innerHTML = `
            <span class="flex items-center gap-2">
                <i class="fas fa-${check.passed ? 'check-circle text-green-400' : 'times-circle text-rose-500'}"></i>
                <span class="text-gray-300 font-medium">${check.message}</span>
            </span>
            <span class="text-gray-500 font-mono">${check.points} pts</span>
        `;
        checksContainer.appendChild(checkEl);
    }
    
    scoreDisplay.classList.remove('hidden');
}

// Rate Limiting
function startRateLimit() {
    rateLimitActive = true;
    let seconds = 3;
    
    const notice = document.getElementById('rateLimitNotice');
    const countdownEl = document.getElementById('countdown');
    const button = document.getElementById('generateSeoContent');
    
    if (!button) return; // Safety check

    notice.classList.remove('hidden');
    button.disabled = true;
    
    countdownInterval = setInterval(() => {
        seconds--;
        countdownEl.textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(countdownInterval);
            notice.classList.add('hidden');
            button.disabled = false;
            rateLimitActive = false;
        }
    }, 1000);
}

// Notification Helper
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border flex items-center gap-3 animate-slide-in ${
        type === 'success' 
            ? 'bg-green-500/20 border-green-500/30 text-green-400' 
            : 'bg-rose-500/20 border-rose-500/30 text-rose-400'
    }`;
    
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span class="font-bold text-sm">${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Duplicate Name Check
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.querySelector('input[name="name"]');
    const warningDiv = document.getElementById('duplicate-warning');
    let debounceTimeout = null;

    if (nameInput && warningDiv) {
        nameInput.addEventListener('input', function () {
            clearTimeout(debounceTimeout);
            const nameValue = this.value.trim();

            if (nameValue.length < 3) {
                warningDiv.style.display = 'none';
                return;
            }

            debounceTimeout = setTimeout(function () {
                fetch(`/admin/products/check-duplicate?name=${encodeURIComponent(nameValue)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            warningDiv.style.display = 'flex';
                        } else {
                            warningDiv.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error al validar nombre duplicado:', error));
            }, 400);
        });
    }
});
</script>
@endsection