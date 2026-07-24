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
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 ml-1">Nuevo Archivo .ZIP (Opcional)</label>
                    <div class="relative bg-gray-900/50 border-2 border-dashed border-white/5 rounded-2xl p-8 text-center group-hover:border-emerald-500/40 transition-all">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-600 mb-2 group-hover:text-emerald-400 transition-colors"></i>
                        <input type="file" name="product_file" accept=".zip" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <p class="text-xs text-gray-500">Únicamente formato .ZIP (Máx. 500MB)</p>
                    </div>
                    @if($product->product_file)
                        <div class="mt-4 flex items-center gap-3 bg-emerald-500/5 p-3 rounded-xl border border-emerald-500/10">
                            <i class="fas fa-file-archive text-emerald-500"></i>
                            <span class="text-[10px] text-emerald-500 uppercase font-black">Archivo cargado</span>
                        </div>
                    @endif
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