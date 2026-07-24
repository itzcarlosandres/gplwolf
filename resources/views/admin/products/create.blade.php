@extends('layouts.admin')

@section('title', 'Nuevo Producto')

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.products.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Nuevo Producto</h1>
        <p class="text-gray-400 mt-1">Lanza un nuevo recurso digital al marketplace.</p>
    </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    @csrf
    
    <!-- Error Display (Hidden by default, shown via JS) -->
    <div id="error-container" class="lg:col-span-3 hidden bg-rose-500/10 border border-rose-500/20 text-rose-500 p-4 rounded-2xl mb-2">
        <ul id="error-list" class="list-disc list-inside text-sm font-bold"></ul>
    </div>
    
    <!-- Left Column: Basic Info -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h2 class="text-xl font-bold text-white mb-8 flex items-center gap-3">
                <div class="bg-[#FF2121]/20 p-2 rounded-lg"><i class="fas fa-info-circle text-[#FF2121] text-sm"></i></div>
                Información Básica
            </h2>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Nombre del Producto</label>
                    <input type="text" name="name" required class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700" placeholder="Ej: OceanWP Pro Bundle">
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Descripción Corta</label>
                    <textarea name="description" required rows="3" class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700 resize-none" placeholder="Breve resumen que aparecerá en los listados..."></textarea>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Descripción Completa (HTML)</label>
                    <textarea name="full_description" rows="10" class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700 font-mono text-sm" placeholder="Detalles técnicos, características clave, guías de uso..."></textarea>
                </div>
            </div>
        </div>

        <!-- AI Content Generator Section -->
        <div class="bg-gradient-to-r from-[#FF2121]/10 to-[#F51B1B]/10 backdrop-blur-xl p-8 rounded-3xl border border-[#F51B1B]/20 shadow-2xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-3">
                        <div class="bg-[#F51B1B]/20 p-2 rounded-lg">
                            <i class="fas fa-sparkles text-[#F51B1B] text-sm"></i>
                        </div>
                        Generador de Contenido con IA
                        <span class="text-xs bg-gradient-to-r from-[#FF2121] to-[#F51B1B] px-3 py-1 rounded-full text-white font-black">SEO</span>
                    </h2>
                    <p class="text-gray-400 text-sm mt-2 md:ml-11">
                        Genera descripciones optimizadas para buscadores usando Gemini AI
                    </p>
                </div>
                <button type="button" 
                        id="generateSeoContent" 
                        class="px-6 py-3 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] hover:from-[#F51B1B] hover:to-[#FF2121] text-white font-bold rounded-xl transition-all shadow-lg shadow-[#F51B1B]/25 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
                    <i class="fas fa-magic"></i>
                    <span>Generar con IA</span>
                </button>
            </div>
            
            <!-- Keywords Input (Opcional) -->
            <div class="mb-4">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">
                    Keywords SEO (opcional - se auto-generan del título)
                    <span class="text-gray-600 font-normal text-xs ml-2">Separadas por comas</span>
                </label>
                <input type="text" 
                       id="seoKeywords" 
                       placeholder="Deja vacío para auto-generar desde el título del producto"
                       class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#F51B1B]/50 transition-all placeholder:text-gray-700">
            </div>
            
            <!-- Loading State -->
            <div id="aiLoadingState" class="hidden bg-[#F51B1B]/10 border border-[#F51B1B]/20 rounded-xl p-4">
                <div class="flex items-center gap-3 text-[#F51B1B]">
                    <div class="animate-spin">
                        <i class="fas fa-circle-notch text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold">Generando contenido SEO optimizado...</p>
                        <p class="text-xs text-gray-500 mt-1">Esto puede tomar 10-15 segundos</p>
                    </div>
                </div>
            </div>
            
            <!-- SEO Score (después de generar) -->
            <div id="seoScoreDisplay" class="hidden mt-4 bg-white/5 border border-white/10 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-white flex items-center gap-2">
                        <i class="fas fa-chart-line text-[#FF2121]"></i>
                        Score SEO
                    </h4>
                    <div class="flex items-center gap-2">
                        <div class="text-3xl font-black" id="seoScoreValue">0</div>
                        <span class="text-gray-500 text-sm">/100</span>
                    </div>
                </div>
                <div id="seoChecks" class="space-y-2 text-sm"></div>
            </div>
            
            <!-- Rate Limit Notice -->
            <div id="rateLimitNotice" class="hidden mt-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-3 text-yellow-400 text-sm">
                <i class="fas fa-clock mr-2"></i>
                Espera <span id="countdown" class="font-bold">3</span> segundos antes de generar otro contenido
            </div>
        </div>

        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h2 class="text-xl font-bold text-white mb-8 flex items-center gap-3">
                <div class="bg-emerald-500/20 p-2 rounded-lg"><i class="fas fa-file-archive text-emerald-400 text-sm"></i></div>
                Archivos del Producto
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-white">
                <div class="group relative">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 ml-1">Imagen Principal (Thumbnail)</label>
                    <div id="thumbnail-dropzone" class="relative bg-gray-900/50 border-2 border-dashed border-white/5 rounded-2xl p-8 text-center group-hover:border-[#FF2121]/40 transition-all overflow-hidden h-40 flex flex-col items-center justify-center">
                        <div id="thumbnail-placeholder" class="pointer-events-none">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-600 mb-2 group-hover:text-[#FF2121] transition-colors"></i>
                            <p class="text-xs text-gray-500">JPG, PNG o WEBP (Máx. 5MB)</p>
                        </div>
                        <img id="thumbnail-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                        <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    </div>
                </div>
                <div class="group relative">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 ml-1">Archivo del Producto (.ZIP)</label>
                    <div id="resumable-drop" class="relative bg-gray-900/50 border-2 border-dashed border-white/5 rounded-2xl p-8 text-center group-hover:border-emerald-500/40 transition-all h-40 flex flex-col items-center justify-center cursor-pointer">
                        <i id="file-icon" class="fas fa-file-archive text-3xl text-gray-600 mb-2 group-hover:text-emerald-400 transition-colors pointer-events-none"></i>
                        <div id="file-info" class="pointer-events-none w-full">
                            <p class="text-xs text-gray-500">Arrastra aquí o click para subir (Chunked)</p>
                            <p class="text-[10px] text-emerald-500/80 mt-1">Soporta archivos +10GB</p>
                        </div>
                        <!-- Botón oculto trigger para Resumable -->
                        <button type="button" id="resumable-browse" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"></button>
                    </div>
                    
                    <!-- Progress Bar for Chunked Upload -->
                    <div id="chunk-progress-container" class="hidden mt-4">
                        <div class="flex justify-between text-xs text-gray-400 mb-1">
                            <span id="chunk-status">Subiendo...</span>
                            <span id="chunk-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-800 rounded-full h-2 overflow-hidden">
                            <div id="chunk-bar" class="bg-emerald-500 h-full w-0 transition-all duration-200"></div>
                        </div>
                    </div>

                    <!-- Hidden input to store the final backend path -->
                    <input type="hidden" name="uploaded_file_path" id="uploaded_file_path">
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Settings -->
    <div class="space-y-8">
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h2 class="text-lg font-bold text-white mb-6 uppercase tracking-wider text-opacity-80">Categorización</h2>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Elegir Categoría</label>
                    <select name="category_id" required class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                        <option value="" disabled selected class="bg-gray-900">Seleccionar...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="bg-gray-900">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Insignia (Badge)</label>
                    <select name="badge" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                        <option value="" class="bg-gray-900">Ninguna</option>
                        <option value="Más Vendido" class="bg-gray-900">Más Vendido</option>
                        <option value="Trending" class="bg-gray-900">Trending</option>
                        <option value="Popular" class="bg-gray-900">Popular</option>
                        <option value="Nuevo" class="bg-gray-900">Nuevo</option>
                        <option value="Licencia" class="bg-gray-900 font-bold text-amber-500">Licencia (Premium)</option>
                    </select>
                </div>
                
                <!-- Hidden field auto-populated by category -->
                <input type="hidden" name="type" id="product-type" value="theme">
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Precio Unitario ($)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#FF2121] font-bold">$</span>
                        <input type="number" name="price" step="0.01" required value="0.00" class="w-full bg-gray-900/50 border border-white/10 rounded-xl pl-8 pr-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/5">
                    <div>
                        <label class="block text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Puntos Fijos (Manual)</label>
                        <input type="number" min="0" name="reward_points" value="0" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all font-mono text-xs">
                        <span class="text-[8px] text-gray-500 mt-1 block">Deja 0 para usar auto</span>
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Bonus Multiplicador</label>
                        <input type="number" step="0.1" min="1" name="points_multiplier" value="1.0" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all font-mono text-xs">
                        <span class="text-[8px] text-gray-500 mt-1 block">Ej: 1.5 = +50%</span>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Versión</label>
                    <input type="text" name="version" required value="1.0.0" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono text-xs">
                </div>

                <div class="flex items-center p-4 bg-[#FF2121]/10 rounded-2xl border border-[#FF2121]/20 group cursor-pointer hover:bg-[#FF2121]/15 transition-all">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" checked class="w-6 h-6 text-[#FF2121] bg-gray-900 border-white/10 rounded-lg focus:ring-[#FF2121] focus:ring-offset-gray-900 transition-all cursor-pointer">
                    <label for="is_active" class="ml-4 text-sm font-bold text-[#FF2121] cursor-pointer">Publicar inmediatamente</label>
                </div>

                <div class="flex items-center p-4 bg-amber-500/10 rounded-2xl border border-amber-500/20 group cursor-pointer hover:bg-amber-500/15 transition-all">
                    <input type="hidden" name="is_license" value="0">
                    <input type="checkbox" name="is_license" value="1" id="is_license" class="w-6 h-6 text-amber-500 bg-gray-900 border-white/10 rounded-lg focus:ring-amber-500 focus:ring-offset-gray-900 transition-all cursor-pointer">
                    <label for="is_license" class="ml-4 text-sm font-bold text-amber-400 cursor-pointer">🔑 Licencia Oficial / Legal</label>
                </div>


            </div>
        </div>

        <button type="submit" class="w-full bg-[#F51B1B] hover:bg-[#FF2121] text-white py-5 rounded-3xl font-black text-xl uppercase tracking-widest transition-all duration-300 shadow-2xl shadow-[#F51B1B]/40 group relative overflow-hidden">
            <span class="relative z-10">Publicar Producto <i class="fas fa-paper-plane ml-2 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i></span>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
        </button>
    </div>
</form>

<!-- Progress Overlay -->
<div id="upload-overlay" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center">
    <div class="bg-gray-900 border border-white/10 p-8 rounded-3xl w-full max-w-md shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#FF2121]/20 blur-3xl rounded-full -mr-16 -mt-16"></div>
        
        <h3 class="text-xl font-bold text-white mb-2 relative z-10">Subiendo Producto...</h3>
        <p class="text-gray-400 text-sm mb-6 relative z-10">Por favor espera, estamos procesando los archivos. No cierres esta ventana.</p>
        
        <div class="w-full bg-gray-800 rounded-full h-4 overflow-hidden relative">
            <div id="progress-bar" class="bg-gradient-to-r from-[#FF2121] to-[#F51B1B] h-full w-0 transition-all duration-300 ease-out relative">
                 <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
            </div>
        </div>
        <div class="flex justify-between text-xs font-bold mt-2 text-gray-500 uppercase tracking-widest">
            <span id="progress-text">0%</span>
            <span>Subiendo...</span>
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
                document.getElementById('file-icon').className = 'fas fa-spinner fa-spin text-3xl text-[#FF2121] mb-2 transition-all';
                document.getElementById('file-info').innerHTML = `
                    <p class="text-sm text-white font-bold truncate px-4">${file.fileName}</p>
                    <p class="text-[10px] text-gray-400 font-mono mt-1">Preparando subida...</p>
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
                document.getElementById('file-icon').className = 'fas fa-check-circle text-3xl text-emerald-400 mb-2 transition-all';
                document.getElementById('file-info').innerHTML = `
                    <p class="text-sm text-white font-bold truncate px-4">${file.fileName}</p>
                    <p class="text-[10px] text-emerald-500 font-mono mt-1">¡Subida Completada!</p>
                `;
                document.getElementById('chunk-status').innerText = 'Completado';
                document.getElementById('chunk-bar').className = 'bg-emerald-500 h-full w-full';
            });

            r.on('fileError', function(file, message) {
                document.getElementById('file-icon').className = 'fas fa-times-circle text-3xl text-red-500 mb-2 transition-all';
                document.getElementById('chunk-status').innerText = 'Error en subida';
                document.getElementById('chunk-status').className = 'text-red-500';
            });
        }
    });
</script>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    // Si ya se subió el archivo (chunked) o no hay archivo nuevo que subir, deja pasar el submit normal.
    // Opcional: Podrías mantener el AJAX si prefieres, pero el problema original (tamaño) ya se resolvió antes de esto.
    
    // Si quisieras mantener la UI de "Cargando..."
    const overlay = document.getElementById('upload-overlay');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    
    // Si hay un archivo subido vía Resumable, el input hidden 'uploaded_file_path' tendrá valor.
    // Si no, y es create, quizás bloquear? O quizás es solo editar texto.
    
    // Simular UI de carga rápida solo para feedback visual
    // e.preventDefault(); (Opcional, si quieres AJAX real, descomenta y usa fetch)
    // Pero como el archivo pesado YA subió, el POST será ligero.
    
    // Validar si falta el archivo (si es create y no subió nada)
    const uploadedPath = document.getElementById('uploaded_file_path').value;
    if (!uploadedPath && document.querySelector('input[name="_method"]')?.value !== 'PUT') {
        // Es CREATE y no hay archivo
        // alert('Por favor sube el archivo del producto primero.');
        // e.preventDefault();
        // return;
    }

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

// File Name Preview (Obsoleto por Resumable.js - Eliminado)

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
        scoreValue.className = 'text-3xl font-black text-green-400';
    } else if (score.total >= 60) {
        scoreValue.className = 'text-3xl font-black text-yellow-400';
    } else {
        scoreValue.className = 'text-3xl font-black text-red-400';
    }
    
    // Display checks
    checksContainer.innerHTML = '';
    for (const [key, check] of Object.entries(score.checks)) {
        const checkEl = document.createElement('div');
        checkEl.className = 'flex items-center justify-between';
        checkEl.innerHTML = `
            <span class="flex items-center gap-2">
                <i class="fas fa-${check.passed ? 'check-circle text-green-400' : 'times-circle text-red-400'}"></i>
                <span class="text-gray-300">${check.message}</span>
            </span>
            <span class="text-gray-500">${check.points} pts</span>
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
            : 'bg-red-500/20 border-red-500/30 text-red-400'
    }`;
    
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span class="font-bold">${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}
</script>
@endsection