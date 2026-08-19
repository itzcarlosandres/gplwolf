@extends('layouts.admin')

@section('title', 'Gestor de Actualizaciones')

@section('content')
<div x-data="updateManager()" class="max-w-7xl mx-auto space-y-8 font-sans">
    
    <!-- Top Header Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#111111] via-[#161616] to-[#0d0d0d] border border-white/10 rounded-3xl p-6 md:p-8 shadow-2xl">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#FF2121]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#FF2121] to-[#F51B1B] flex items-center justify-center text-white text-2xl shadow-xl shadow-[#FF2121]/30">
                    <i class="fas fa-rocket"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Gestor de Actualizaciones</h1>
                    <p class="text-sm text-gray-400 mt-1">Despliega nuevas versiones de productos de forma rápida y envía notificaciones a los clientes.</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-xs font-bold text-gray-300 flex items-center gap-2">
                    <i class="fas fa-layer-group text-[#FF2121]"></i>
                    Catálogo Activo
                </span>
                @if(isset($pendingRequests) && count($pendingRequests) > 0)
                    <span class="px-4 py-2 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs font-bold text-amber-400 flex items-center gap-2 animate-pulse">
                        <i class="fas fa-bell"></i>
                        {{ count($pendingRequests) }} Solicitudes Pendientes
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- ==============================================
         STEP 1: PRODUCT SELECTION & SEARCH
         ============================================== -->
    <div x-show="step === 'search'" x-transition:enter="transition ease-out duration-300" class="space-y-8">
        
        <!-- Search Input Bar -->
        <div class="bg-[#111111] border border-white/10 rounded-2xl p-6 shadow-xl space-y-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-black text-white">Buscar Producto a Actualizar</h2>
                    <p class="text-xs text-gray-400">Escribe el nombre o plugin para filtrar la lista en tiempo real.</p>
                </div>
                <div class="w-full md:w-96 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                    <input type="text" 
                           x-model="searchQuery"
                           @input.debounce.300ms="performSearch"
                           placeholder="Buscar por nombre..." 
                           class="w-full bg-[#1a1a1a] border border-white/10 rounded-xl py-3 pl-11 pr-10 text-sm font-bold text-white placeholder-gray-500 focus:outline-none focus:border-[#FF2121] focus:ring-2 focus:ring-[#FF2121]/20 transition-all">
                    <button x-show="searchQuery.length > 0" @click="searchQuery = ''; performSearch()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Pending Requests Section (If any) -->
        @if(isset($pendingRequests) && count($pendingRequests) > 0)
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-black uppercase tracking-wider text-amber-400 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> Productos Solicitados por Usuarios
                </h3>
                <span class="text-xs text-gray-500 font-medium">Haz clic en uno para actualizarlo</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($pendingRequests as $p)
                <div @click="selectProduct({
                        id: {{ $p->id }},
                        name: '{{ addslashes($p->name) }}',
                        version: '{{ $p->version }}',
                        category: '{{ addslashes($p->category->name ?? 'General') }}',
                        image: '{{ $p->thumbnail ? asset('storage/' . $p->thumbnail) : '' }}'
                     })" 
                     class="group bg-[#111111] border border-amber-500/30 hover:border-amber-400 rounded-2xl p-4 transition-all duration-300 hover:-translate-y-1 cursor-pointer shadow-lg hover:shadow-amber-500/10 flex items-center justify-between">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex-shrink-0 relative">
                            @if($p->thumbnail)
                                <img src="{{ asset('storage/' . $p->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-500 text-lg"><i class="fas fa-box"></i></div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-white truncate group-hover:text-amber-400 transition-colors">{{ $p->name }}</h4>
                            <div class="flex items-center gap-2 text-xs text-gray-400 mt-0.5">
                                <span>v{{ $p->version }}</span>
                                <span>•</span>
                                <span class="text-amber-400 font-bold">{{ $p->requests_count }} {{ $p->requests_count == 1 ? 'solicitud' : 'solicitudes' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-black transition-all shrink-0">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Search Results Grid / Recent Products Grid -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-400" x-text="searchQuery.length >= 2 ? 'Resultados de Búsqueda' : 'Productos Recientes'"></h3>
                <span x-show="isLoading" class="text-xs text-[#FF2121] font-bold flex items-center gap-1.5">
                    <i class="fas fa-circle-notch fa-spin text-xs"></i> Buscando...
                </span>
            </div>

            <!-- Loading Skeleton -->
            <div x-show="isLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <template x-for="i in 6" :key="i">
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-4 animate-pulse flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/5 rounded-xl"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-4 bg-white/5 rounded w-3/4"></div>
                            <div class="h-3 bg-white/5 rounded w-1/2"></div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Products Cards Grid -->
            <div x-show="!isLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Search Results -->
                <template x-for="item in searchResults" :key="item.id">
                    <div @click="selectProduct(item)" 
                         class="group bg-[#111111] border border-white/10 hover:border-[#FF2121]/50 rounded-2xl p-4 transition-all duration-300 hover:-translate-y-1 cursor-pointer shadow-lg hover:shadow-[#FF2121]/10 flex items-center justify-between">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex-shrink-0 relative">
                                <template x-if="item.image">
                                    <img :src="item.image" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                </template>
                                <template x-if="!item.image">
                                    <div class="w-full h-full flex items-center justify-center text-gray-500 text-lg"><i class="fas fa-box"></i></div>
                                </template>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-white truncate group-hover:text-[#FF2121] transition-colors" x-text="item.name"></h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                    <span x-text="item.category"></span>
                                    <span>•</span>
                                    <span class="font-mono text-gray-300">v<span x-text="item.version"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 text-gray-400 flex items-center justify-center group-hover:bg-[#FF2121] group-hover:text-white group-hover:border-[#FF2121] transition-all shrink-0">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                    </div>
                </template>
            </div>

            <!-- No Results State -->
            <div x-show="!isLoading && searchQuery.length >= 2 && searchResults.length === 0" class="bg-[#111111] border border-white/10 rounded-2xl p-12 text-center text-gray-500">
                <i class="fas fa-search text-3xl text-gray-600 mb-3"></i>
                <p class="text-sm font-bold text-white">No se encontraron productos coincidentes</p>
                <p class="text-xs text-gray-500 mt-1">Intenta con otra palabra clave en el buscador superior.</p>
            </div>
        </div>
    </div>

    <!-- ==============================================
         STEP 2: UPDATE FORM & DEPLOYMENT
         ============================================== -->
    <div x-show="step === 'form'" x-transition:enter="transition ease-out duration-300" class="space-y-6">
        
        <!-- Action Top Bar -->
        <div class="flex items-center justify-between bg-[#111111] border border-white/10 rounded-2xl p-4 px-6">
            <button @click="resetFlow()" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs font-bold text-gray-300 hover:text-white transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Cambiar Producto
            </button>
            <div class="flex items-center gap-2 text-xs font-bold text-gray-400">
                <span>Producto Seleccionado:</span>
                <span class="text-white font-black" x-text="product?.name"></span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left Card: Selected Product Info & Console -->
            <div class="bg-[#111111] border border-white/10 rounded-3xl p-6 space-y-6 shadow-xl sticky top-6">
                <div class="text-center space-y-4">
                    <div class="w-24 h-24 rounded-2xl bg-white/5 border border-white/10 mx-auto overflow-hidden relative shadow-2xl">
                        <template x-if="product?.image">
                            <img :src="product.image" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!product?.image">
                            <div class="w-full h-full flex items-center justify-center text-3xl text-gray-500"><i class="fas fa-box"></i></div>
                        </template>
                    </div>

                    <div>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#FF2121]/10 text-[#FF2121] border border-[#FF2121]/20 text-[10px] font-black uppercase tracking-wider" x-text="product?.category"></span>
                        <h3 class="text-xl font-black text-white mt-2 leading-tight" x-text="product?.name"></h3>
                    </div>
                </div>

                <div class="border-t border-b border-white/5 py-4 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Versión Actual</span>
                        <span class="font-mono font-bold text-white bg-white/5 px-2 py-0.5 rounded border border-white/10" x-text="'v' + (product?.version || '1.0.0')"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Nueva Versión</span>
                        <span class="font-mono font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20" x-text="'v' + (form.version_number || '1.0.0')"></span>
                    </div>
                </div>

                <!-- Live Upload Console -->
                <div x-show="uploading || uploadComplete" x-transition class="bg-black/60 rounded-2xl p-4 border border-white/10 space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="uppercase tracking-wider text-[10px]" :class="uploadComplete ? 'text-emerald-400' : 'text-[#FF2121]'" x-text="uploadComplete ? 'Completado' : 'Subiendo...'"></span>
                        <span class="font-mono text-gray-400" x-text="`${Math.round(progress)}%`"></span>
                    </div>

                    <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#FF2121] to-emerald-400 transition-all duration-150" :style="`width: ${progress}%`"></div>
                    </div>

                    <div class="font-mono text-[10px] text-gray-500 space-y-1 pt-1">
                        <p class="text-emerald-500">> Transfiriendo archivo .ZIP...</p>
                        <p x-show="progress > 40">> Registrando versión en BD...</p>
                        <p x-show="progress > 80">> Generando notificaciones a usuarios...</p>
                        <p x-show="uploadComplete" class="text-white font-bold text-xs pt-1">> ¡Despliegue finalizado con éxito!</p>
                    </div>
                </div>
            </div>

            <!-- Right Main Form -->
            <div class="lg:col-span-2 bg-[#111111] border border-white/10 rounded-3xl p-6 md:p-8 space-y-6 shadow-xl">
                <div class="border-b border-white/5 pb-4">
                    <h3 class="text-lg font-black text-white">Detalles de la Nueva Versión</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Define la nueva versión y adjunta el paquete ejecutable en formato ZIP.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Version Number & Bumper -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black tracking-widest text-gray-400">Número de Versión</label>
                        <div class="relative">
                            <input type="text" x-model="form.version_number" class="w-full bg-[#1a1a1a] border border-white/10 focus:border-[#FF2121] rounded-xl py-3 px-4 text-white font-mono font-bold focus:outline-none transition-all">
                            <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">
                                <button type="button" @click="incrementVersion('major')" class="px-1.5 py-0.5 rounded bg-green-500/10 text-green-400 text-[9px] font-bold border border-green-500/20 hover:bg-green-500/20 transition">Major</button>
                                <button type="button" @click="incrementVersion('minor')" class="px-1.5 py-0.5 rounded bg-[#FF2121]/10 text-[#FF2121] text-[9px] font-bold border border-[#FF2121]/20 hover:bg-[#FF2121]/20 transition">Minor</button>
                                <button type="button" @click="incrementVersion('patch')" class="px-1.5 py-0.5 rounded bg-gray-500/10 text-gray-400 text-[9px] font-bold border border-gray-500/20 hover:bg-gray-500/20 transition">Patch</button>
                            </div>
                        </div>
                    </div>

                    <!-- Release Date -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black tracking-widest text-gray-400">Fecha de Lanzamiento</label>
                        <input type="date" x-model="form.released_at" class="w-full bg-[#1a1a1a] border border-white/10 focus:border-[#FF2121] rounded-xl py-3 px-4 text-white font-bold focus:outline-none transition-all [color-scheme:dark]">
                    </div>
                </div>

                <!-- Dropzone File Upload (Main + Optional Extra) -->
                <div class="space-y-4">
                    <!-- Main Version ZIP -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black tracking-widest text-gray-400">Archivo Principal de la Versión (.ZIP)</label>
                        <div class="relative w-full h-36 border-2 border-dashed rounded-2xl flex flex-col items-center justify-center transition-all duration-300 cursor-pointer overflow-hidden group"
                             :class="fileSelected ? 'border-emerald-500 bg-emerald-500/5' : 'border-white/10 bg-[#1a1a1a]/40 hover:border-[#FF2121]/50 hover:bg-[#1a1a1a]'"
                             @click="$refs.fileInput.click()">
                            
                            <input x-ref="fileInput" type="file" class="hidden" accept=".zip" @change="handleFileSelect">
                            
                            <div x-show="!fileSelected && !uploading" class="text-center p-4">
                                <div class="w-10 h-10 mx-auto rounded-xl bg-[#FF2121]/10 text-[#FF2121] group-hover:bg-[#FF2121] group-hover:text-white flex items-center justify-center mb-2 transition-all">
                                    <i class="fas fa-file-archive text-lg"></i>
                                </div>
                                <p class="text-xs font-bold text-white">Haz clic o arrastra tu archivo .ZIP Principal aquí</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">Soporta archivos de hasta 500 MB</p>
                            </div>

                            <div x-show="fileSelected && !uploading" class="text-center p-4">
                                <div class="w-10 h-10 mx-auto rounded-xl bg-emerald-500 text-white flex items-center justify-center mb-2 shadow-lg shadow-emerald-500/20">
                                    <i class="fas fa-check text-lg"></i>
                                </div>
                                <p class="text-xs font-bold text-white" x-text="fileName"></p>
                                <p class="text-[10px] text-emerald-400 font-bold mt-0.5">Archivo principal listo para subir</p>
                            </div>
                        </div>
                    </div>

                    <!-- Second Extra File (.ZIP) & Label (Optional) -->
                    <div class="p-4 bg-[#141416] border border-white/5 rounded-2xl space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                            <!-- Extra ZIP Upload -->
                            <div class="space-y-1.5">
                                <label class="text-[10px] uppercase font-black tracking-widest text-amber-400 flex items-center gap-1.5">
                                    <i class="fas fa-file-zipper"></i>
                                    Paquete Adicional (.ZIP) (Opcional)
                                </label>
                                <div class="relative w-full h-24 border-2 border-dashed rounded-xl flex flex-col items-center justify-center transition-all duration-300 cursor-pointer overflow-hidden group"
                                     :class="extraFileSelected ? 'border-amber-500 bg-amber-500/5' : 'border-white/10 bg-[#1a1a1a]/40 hover:border-amber-500/50'"
                                     @click="$refs.extraFileInput.click()">
                                    
                                    <input x-ref="extraFileInput" type="file" class="hidden" accept=".zip" @change="handleExtraFileSelect">
                                    
                                    <div x-show="!extraFileSelected" class="text-center p-2">
                                        <i class="fas fa-cloud-arrow-up text-gray-500 group-hover:text-amber-400 text-base mb-1 transition-colors"></i>
                                        <p class="text-[11px] font-bold text-gray-300">Subir 2do .ZIP</p>
                                    </div>

                                    <div x-show="extraFileSelected" class="text-center p-2">
                                        <i class="fas fa-check-circle text-amber-400 text-base mb-1"></i>
                                        <p class="text-[11px] font-bold text-white truncate max-w-[160px]" x-text="extraFileName"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Extra File Label -->
                            <div class="space-y-1.5">
                                <label class="text-[10px] uppercase font-black tracking-widest text-gray-400">Nombre / Etiqueta del 2do Archivo</label>
                                <input type="text" 
                                       x-model="form.extra_file_name" 
                                       placeholder="Ej: Paquete de Actualización (.ZIP)" 
                                       class="w-full bg-[#1a1a1a] border border-white/10 focus:border-amber-500 rounded-xl py-3 px-3 text-xs text-white focus:outline-none transition-all">
                                <p class="text-[9px] text-gray-500">Si se sube, el cliente verá un popup interactivo para elegir qué archivo descargar.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button @click="uploadFile" 
                            :disabled="uploading || uploadComplete || !fileSelected"
                            class="w-full py-4 rounded-xl font-black uppercase tracking-wider text-white shadow-xl transition-all relative overflow-hidden group disabled:opacity-50 disabled:cursor-not-allowed text-xs"
                            :class="uploadComplete ? 'bg-emerald-600' : 'bg-gradient-to-r from-[#FF2121] to-[#F51B1B] hover:opacity-90 active:scale-[0.99]'">
                        
                        <span x-show="!uploading && !uploadComplete" class="flex items-center justify-center gap-2">
                            <i class="fas fa-rocket"></i> Publicar y Notificar a Clientes
                        </span>
                        
                        <span x-show="uploading" class="flex items-center justify-center gap-2">
                            <i class="fas fa-circle-notch fa-spin"></i> Subiendo Paquete...
                        </span>

                        <span x-show="uploadComplete" class="flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> ¡Publicado Correctamente!
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateManager() {
        const defaultRecent = @json($recentProducts ?? []);
        return {
            step: 'search',
            searchQuery: '',
            searchResults: defaultRecent,
            isLoading: false,
            product: null,
            uploading: false,
            uploadComplete: false,
            progress: 0,
            fileSelected: false,
            fileName: '',
            file: null,
            extraFileSelected: false,
            extraFileName: '',
            extraFile: null,
            form: {
                version_number: '',
                released_at: new Date().toISOString().split('T')[0],
                changelog: '- NEW: ',
                extra_file_name: 'Paquete de Actualización (.ZIP)'
            },

            performSearch() {
                if(this.searchQuery.length < 2) {
                    this.searchResults = defaultRecent;
                    return;
                }
                
                this.isLoading = true;
                
                fetch(`{{ route('admin.api.products.search') }}?q=${encodeURIComponent(this.searchQuery)}`)
                    .then(r => r.json())
                    .then(data => {
                        this.searchResults = data;
                        this.isLoading = false;
                    })
                    .catch(() => {
                        this.isLoading = false;
                        this.searchResults = [];
                    });
            },

            selectProductFromBlade(productObj) {
                this.selectProduct(productObj);
            },

            selectProduct(item) {
                this.product = item;
                if(item.version) {
                    const parts = item.version.split('.');
                    if(parts.length >= 3) {
                        parts[2] = parseInt(parts[2]) + 1;
                        this.form.version_number = parts.join('.');
                    } else {
                        this.form.version_number = item.version + '.1';
                    }
                } else {
                    this.form.version_number = '1.0.0';
                }

                if (item.extra_file_name) {
                    this.form.extra_file_name = item.extra_file_name;
                } else {
                    this.form.extra_file_name = 'Paquete de Actualización (.ZIP)';
                }
                
                this.step = 'form';
                this.searchQuery = '';
            },

            resetFlow() {
                this.step = 'search';
                this.product = null;
                this.searchResults = defaultRecent;
                this.resetForm();
            },
            
            resetForm() {
                this.fileSelected = false;
                this.fileName = '';
                this.file = null;
                this.extraFileSelected = false;
                this.extraFileName = '';
                this.extraFile = null;
                this.uploading = false;
                this.uploadComplete = false;
                this.progress = 0;
            },

            handleFileSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    this.file = file;
                    this.fileSelected = true;
                    this.fileName = file.name;
                }
            },

            handleExtraFileSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    this.extraFile = file;
                    this.extraFileSelected = true;
                    this.extraFileName = file.name;
                }
            },

            appendLog(type) {
                this.form.changelog += `\n- ${type}: `;
            },
            
            incrementVersion(type) {
                 const parts = this.form.version_number.split('.').map(Number);
                 if (parts.length < 3) while(parts.length < 3) parts.push(0);
                 
                 if (type === 'major') { parts[0]++; parts[1]=0; parts[2]=0; }
                 if (type === 'minor') { parts[1]++; parts[2]=0; }
                 if (type === 'patch') { parts[2]++; }
                 
                 this.form.version_number = parts.join('.');
            },

            uploadFile() {
                if (!this.file || !this.product) return;
                
                this.uploading = true;
                this.progress = 0;
                
                const formData = new FormData();
                formData.append('product_id', this.product.id);
                formData.append('version_number', this.form.version_number);
                formData.append('released_at', this.form.released_at);
                formData.append('changelog', this.form.changelog);
                formData.append('version_file', this.file);
                if (this.extraFile) {
                    formData.append('update_package_file', this.extraFile);
                }
                if (this.form.extra_file_name) {
                    formData.append('extra_file_name', this.form.extra_file_name);
                }
                formData.append('_token', '{{ csrf_token() }}');

                const xhr = new XMLHttpRequest();
                
                xhr.upload.addEventListener("progress", (event) => {
                    if (event.lengthComputable) {
                        const percentComplete = (event.loaded / event.total) * 100;
                        this.progress = percentComplete;
                    }
                });

                xhr.addEventListener("load", () => {
                   if (xhr.status === 200) {
                       this.progress = 100;
                       this.uploading = false;
                       this.uploadComplete = true;
                       setTimeout(() => {
                           window.location.reload(); 
                       }, 1500);
                   } else {
                       alert('Error al subir: ' + xhr.responseText);
                       this.uploading = false;
                   }
                });
                
                xhr.addEventListener("error", () => {
                    alert("Error de red al subir el archivo.");
                    this.uploading = false;
                });

                xhr.open("POST", "{{ route('admin.updates.manager.store') }}");
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send(formData);
            }
        }
    }
</script>
@endsection