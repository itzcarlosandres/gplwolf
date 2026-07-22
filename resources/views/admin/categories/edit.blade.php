@extends('layouts.admin')

@section('title', 'Editar Categoría')

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.categories.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Editar Categoría</h1>
        <p class="text-gray-400 mt-1">Actualiza la información de "{{ $category->name }}"</p>
    </div>
</div>

<form action="{{ route('admin.categories.update', $category) }}" method="POST" class="max-w-2xl">
    @csrf
    @method('PUT')
    
    <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[32px] border border-white/5 shadow-2xl space-y-6">
        <div>
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Nombre de la Categoría</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
            @error('name') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Icono FontAwesome (Opcional)</label>
            <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono">
        </div>

        <div class="space-y-4">
            <div class="flex items-center p-5 bg-[#FF2121]/5 rounded-2xl border border-[#FF2121]/10">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ $category->is_active ? 'checked' : '' }} class="w-6 h-6 text-[#FF2121] bg-gray-900 border-white/10 rounded-lg focus:ring-[#FF2121] transition-all">
                <label for="is_active" class="ml-4 text-sm font-bold text-[#FF2121]">Categoría Activa</label>
            </div>

            <div class="flex items-center p-5 bg-rose-500/5 rounded-2xl border border-rose-500/10">
                <input type="hidden" name="exclude_from_membership" value="0">
                <input type="checkbox" name="exclude_from_membership" value="1" id="exclude_from_membership" {{ $category->exclude_from_membership ? 'checked' : '' }} class="w-6 h-6 text-rose-500 bg-gray-900 border-white/10 rounded-lg focus:ring-rose-500 transition-all">
                <label for="exclude_from_membership" class="ml-4 text-sm font-bold text-rose-300">Excluir de Membresías (Solo Venta Individual)</label>
            </div>
        </div>

        <button type="submit" class="w-full gradient-bg text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-[#F51B1B]/30 hover:opacity-90 transition-all leading-none">
            Guardar Cambios <i class="fas fa-save ml-2"></i>
        </button>
    </div>
</form>
@endsection