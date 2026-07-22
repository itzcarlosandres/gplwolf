@extends('layouts.admin')

@section('title', 'Nueva Marca')

@section('content')
<div class="max-w-2xl">
    <div class="mb-8">
        <h1 class="text-2xl font-black text-white tracking-tight">Nueva Marca</h1>
        <p class="text-gray-500 text-sm mt-1">Agrega una marca al slider de confianza.</p>
    </div>

    <form action="{{ route('admin.brands.store') }}" method="POST" class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
                @error('name')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Icono (clase FontAwesome)</label>
                <input type="text" name="icon" value="{{ old('icon', 'fas fa-cube') }}" placeholder="fas fa-cube" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
                @error('icon')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Orden</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
                @error('sort_order')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 h-full pt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-white/10 bg-[#0d0d0d] text-[#F51B1B] focus:ring-[#FF2121]/20">
                <label for="is_active" class="text-sm font-bold text-white cursor-pointer">Activo</label>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/[0.06]">
            <a href="{{ route('admin.brands.index') }}" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm font-bold text-gray-300 transition-all">Cancelar</a>
            <button type="submit" class="px-5 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-[#F51B1B]/20">Guardar Marca</button>
        </div>
    </form>
</div>
@endsection