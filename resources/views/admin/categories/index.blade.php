@extends('layouts.admin')

@section('title', 'Gestionar Categorías')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Categorías</h1>
        <p class="text-gray-500 text-sm mt-1">Administra las etiquetas de organización de tus productos.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
        <i class="fas fa-plus"></i> Nueva Categoría
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-bold flex items-center gap-3">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Categoría</th>
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4 text-center">Productos</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($categories as $category)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#0d0d0d] border border-white/10 rounded-xl flex items-center justify-center">
                                    <i class="{{ $category->icon ?? 'fas fa-tag' }} text-[#FF2121] text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-white group-hover:text-[#FF2121] transition-colors">{{ $category->name }}</span>
                                    @if($category->exclude_from_membership)
                                    <span class="ml-2 px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        Exclusiva
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-[#0d0d0d] border border-white/[0.06] px-2.5 py-1 rounded-lg text-gray-400 font-mono">{{ $category->slug }}</code>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-black text-gray-400 bg-white/5 px-2.5 py-1 rounded-md">{{ $category->products_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($category->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Activa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Inactiva
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres eliminar esta categoría?')">
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
                                    <i class="fas fa-tags text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">No hay categorías</p>
                                <p class="text-sm text-gray-600 mt-1">Crea tu primera categoría.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($categories->hasPages())
<div class="mt-6">
    {{ $categories->links() }}
</div>
@endif
@endsection