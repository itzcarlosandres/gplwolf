@extends('layouts.admin')

@section('title', 'Editar Producto: ' . $product->name)

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.products.show', $product) }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Editar Producto</h1>
        <p class="text-gray-400 mt-1">Actualiza la información comercial y archivos de tu producto.</p>
    </div>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    @csrf
    @method('PUT')

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
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700">
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Descripción Corta</label>
                    <textarea name="description" required rows="3" class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700 resize-none">{{ old('description', $product->description) }}</textarea>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Descripción Completa (HTML)</label>
                    <textarea name="full_description" rows="10" class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700 font-mono text-sm">{{ old('full_description', $product->full_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h2 class="text-xl font-bold text-white mb-8 flex items-center gap-3">
                <div class="bg-emerald-500/20 p-2 rounded-lg"><i class="fas fa-file-archive text-emerald-400 text-sm"></i></div>
                Archivos del Producto
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-white">
                <div class="group relative">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 ml-1">Nueva Miniatura (Opcional)</label>
                    <div class="relative bg-gray-900/50 border-2 border-dashed border-white/5 rounded-2xl p-8 text-center group-hover:border-[#FF2121]/40 transition-all">
                        <i class="fas fa-image text-3xl text-gray-600 mb-2 group-hover:text-[#FF2121] transition-colors"></i>
                        <input type="file" name="thumbnail" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <p class="text-xs text-gray-500">Deja vacío para mantener la actual</p>
                    </div>
                    @if($product->thumbnail)
                        <div class="mt-4 flex items-center gap-3 bg-gray-900/50 p-3 rounded-xl border border-white/5">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-10 h-10 rounded-lg object-cover">
                            <span class="text-[10px] text-gray-500 uppercase font-black">Actual</span>
                        </div>
                    @endif
                </div>
                <div class="group relative">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 ml-1">Archivo Principal .ZIP (Opcional)</label>
                    <div class="relative bg-gray-900/50 border-2 border-dashed border-white/5 rounded-2xl p-8 text-center group-hover:border-emerald-500/40 transition-all">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-600 mb-2 group-hover:text-emerald-400 transition-colors"></i>
                        <input type="file" name="product_file" accept=".zip" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <p class="text-xs text-gray-500">Únicamente formato .ZIP (Máx. 500MB)</p>
                    </div>
                    @if($product->product_file)
                        <div class="mt-4 flex items-center gap-3 bg-emerald-500/5 p-3 rounded-xl border border-emerald-500/10">
                            <i class="fas fa-file-archive text-emerald-500"></i>
                            <span class="text-[10px] text-emerald-500 uppercase font-black">Archivo Principal Cargado</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Second Extra File (.ZIP) & Label -->
            <div class="mt-6 pt-6 border-t border-white/5 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div x-data="{ extraSelected: false, extraName: '', extraSize: '' }" class="group relative">
                    <label class="block text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-3 ml-1 flex items-center gap-1.5">
                        <i class="fas fa-file-zipper"></i>
                        Paquete de Actualización / Archivo Adicional (.ZIP) (Opcional)
                    </label>

                    <div class="relative rounded-2xl h-36 flex flex-col items-center justify-center cursor-pointer transition-all overflow-hidden border-2 border-dashed"
                         :class="extraSelected
                             ? 'border-amber-500 bg-amber-500/5'
                             : 'border-white/5 bg-gray-900/50 hover:border-amber-500/40'"
                         @click="$refs.extraInput.click()">

                        <!-- Idle -->
                        <div x-show="!extraSelected" class="flex flex-col items-center pointer-events-none">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                                <i class="fas fa-cloud-arrow-up text-lg"></i>
                            </div>
                            <p class="text-xs font-bold text-white">Subir nuevo paquete adicional</p>
                            <p class="text-[9px] text-gray-500 mt-0.5">Únicamente formato .ZIP</p>
                        </div>

                        <!-- Selected -->
                        <div x-show="extraSelected" class="flex flex-col items-center pointer-events-none px-4 text-center">
                            <div class="w-10 h-10 rounded-xl bg-amber-500 text-gray-900 flex items-center justify-center mb-2 shadow-lg shadow-amber-500/30">
                                <i class="fas fa-check text-lg font-black"></i>
                            </div>
                            <p class="text-xs font-black text-white truncate max-w-[200px]" x-text="extraName"></p>
                            <p class="text-[9px] text-amber-400 font-bold mt-0.5" x-text="extraSize"></p>
                            <p class="text-[8px] text-gray-500 mt-0.5">Clic para cambiar archivo</p>
                        </div>

                        <input x-ref="extraInput"
                               type="file" name="update_package_file" accept=".zip"
                               class="hidden"
                               @change="
                                   const f = $event.target.files[0];
                                   if (f) {
                                       extraSelected = true;
                                       extraName = f.name;
                                       const mb = f.size / (1024*1024);
                                       extraSize = mb >= 1 ? mb.toFixed(1) + ' MB' : (f.size/1024).toFixed(0) + ' KB';
                                   }
                               ">
                    </div>

                    <!-- Badge: new file selected -->
                    <div x-show="extraSelected" class="mt-2 flex items-center gap-2 px-3 py-1.5 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                        <i class="fas fa-file-zipper text-amber-400 text-[10px]"></i>
                        <span class="text-[10px] font-black text-amber-400 uppercase tracking-wider">Archivo listo para subir</span>
                    </div>

                    <!-- Badge: existing file loaded (only when no new file chosen) -->
                    @if($product->update_package_file)
                        <div x-show="!extraSelected" class="mt-2 flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                            <i class="fas fa-file-zipper text-emerald-400 text-[10px]"></i>
                            <span class="text-[10px] font-black text-emerald-400 uppercase tracking-wider">Paquete Adicional ya cargado — dejar vacío para mantener</span>
                        </div>
                    @endif
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">
                        Nombre / Etiqueta del Archivo Adicional
                    </label>
                    <input type="text" 
                           name="extra_file_name" 
                           value="{{ old('extra_file_name', $product->extra_file_name ?: 'Paquete de Actualización (.ZIP)') }}"
                           placeholder="Ej: Paquete de Actualización, Templates & Addons, Child Theme"
                           class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all">
                    <p class="text-[9px] text-gray-500 ml-1">Si existen 2 archivos, al hacer clic en "Descargar" se desplegará el popup con ambas opciones.</p>
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
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }} class="bg-gray-900">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Insignia (Badge)</label>
                    <select name="badge" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                        <option value="" {{ $product->badge == '' ? 'selected' : '' }} class="bg-gray-900">Ninguna</option>
                        <option value="Más Vendido" {{ $product->badge == 'Más Vendido' ? 'selected' : '' }} class="bg-gray-900">Más Vendido</option>
                        <option value="Trending" {{ $product->badge == 'Trending' ? 'selected' : '' }} class="bg-gray-900">Trending</option>
                        <option value="Popular" {{ $product->badge == 'Popular' ? 'selected' : '' }} class="bg-gray-900">Popular</option>
                        <option value="Nuevo" {{ $product->badge == 'Nuevo' ? 'selected' : '' }} class="bg-gray-900">Nuevo</option>
                        <option value="Licencia" {{ $product->badge == 'Licencia' ? 'selected' : '' }} class="bg-gray-900 font-bold text-amber-500">Licencia (Premium)</option>
                    </select>
                </div>
                
                <!-- Hidden field auto-populated by category -->
                <input type="hidden" name="type" id="product-type" value="{{ $product->type ?? 'theme' }}">
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Precio Unitario ($)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#FF2121] font-bold">$</span>
                        <input type="number" name="price" step="0.01" required value="{{ old('price', $product->price) }}" class="w-full bg-gray-900/50 border border-white/10 rounded-xl pl-8 pr-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/5">
                    <div>
                        <label class="block text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Puntos Fijos (Manual)</label>
                        <input type="number" min="0" name="reward_points" value="{{ old('reward_points', $product->reward_points) }}" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all font-mono text-xs">
                        <span class="text-[8px] text-gray-500 mt-1 block">Deja 0 para usar auto</span>
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Bonus Multiplicador</label>
                        <input type="number" step="0.1" min="1" name="points_multiplier" value="{{ old('points_multiplier', $product->points_multiplier ?? 1.0) }}" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all font-mono text-xs">
                        <span class="text-[8px] text-gray-500 mt-1 block">Ej: 1.5 = +50%</span>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Versión</label>
                    <input type="text" name="version" value="{{ old('version', $product->version) }}" required class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono text-xs">
                </div>

                <div class="flex items-center p-4 bg-[#FF2121]/10 rounded-2xl border border-[#FF2121]/20 group cursor-pointer hover:bg-[#FF2121]/15 transition-all">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ $product->is_active ? 'checked' : '' }} class="w-6 h-6 text-[#FF2121] bg-gray-900 border-white/10 rounded-lg focus:ring-[#FF2121] transition-all cursor-pointer">
                    <label for="is_active" class="ml-4 text-sm font-bold text-[#FF2121] cursor-pointer">Producto Activo</label>
                </div>

                <div class="flex items-center p-4 bg-amber-500/10 rounded-2xl border border-amber-500/20 group cursor-pointer hover:bg-amber-500/15 transition-all">
                    <input type="hidden" name="is_license" value="0">
                    <input type="checkbox" name="is_license" value="1" id="is_license" {{ $product->is_license ? 'checked' : '' }} class="w-6 h-6 text-amber-500 bg-gray-900 border-white/10 rounded-lg focus:ring-amber-500 transition-all cursor-pointer">
                    <label for="is_license" class="ml-4 text-sm font-bold text-amber-400 cursor-pointer">🔑 Licencia Oficial / Legal</label>
                </div>


            </div>
        </div>

        <button type="submit" class="w-full bg-[#F51B1B] hover:bg-[#FF2121] text-white py-5 rounded-3xl font-black text-xl uppercase tracking-widest transition-all duration-300 shadow-2xl shadow-[#F51B1B]/40 group">
            Guardar Cambios <i class="fas fa-save ml-2 group-hover:scale-110 transition-transform"></i>
        </button>
    </div>
</form>

<script>
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
</script>
@endsection