@extends('layouts.admin')

@section('title', 'Marcas de Confianza')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Marcas de Confianza</h1>
        <p class="text-gray-500 text-sm mt-1">Gestiona las marcas que aparecen en el slider de la home.</p>
    </div>
    <a href="{{ route('admin.brands.create') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
        <i class="fas fa-plus"></i> Nueva Marca
    </a>
</div>

<div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Orden</th>
                    <th class="px-6 py-4">Marca</th>
                    <th class="px-6 py-4">Icono</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($brands as $brand)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-xs font-black text-gray-500 bg-white/5 px-2.5 py-1 rounded-md">{{ $brand->sort_order }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-white group-hover:text-[#FF2121] transition-colors">{{ $brand->name }}</div>
                            <div class="text-[10px] text-gray-500 mt-0.5">{{ $brand->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center">
                                <i class="{{ $brand->icon ?? 'fas fa-cube' }} text-gray-400 text-sm"></i>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($brand->is_active)
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Activo</span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-rose-500/10 text-rose-400 border border-rose-500/20">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta marca?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all" title="Eliminar">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center text-gray-500">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fas fa-cube text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">No hay marcas</p>
                                <p class="text-sm text-gray-600 mt-1">Crea tu primera marca de confianza.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection