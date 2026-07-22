@extends('layouts.admin')

@section('title', 'Planes de Membresía')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Planes de Membresía</h1>
        <p class="text-gray-500 text-sm mt-1">Configura y gestiona los niveles de suscripción de tu plataforma.</p>
    </div>
    <a href="{{ route('admin.membership-plans.create') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
        <i class="fas fa-plus"></i> Nuevo Plan
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total</h3>
            <p class="text-2xl font-black text-white mt-1">{{ $plans->count() }}</p>
        </div>
        <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121]">
            <i class="fas fa-layer-group text-lg"></i>
        </div>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Activos</h3>
            <p class="text-2xl font-black text-emerald-400 mt-1">{{ $plans->where('is_active', true)->count() }}</p>
        </div>
        <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400">
            <i class="fas fa-check-circle text-lg"></i>
        </div>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Suscriptores</h3>
            <p class="text-2xl font-black text-amber-500 mt-1">{{ $plans->sum('memberships_count') }}</p>
        </div>
        <div class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-center justify-center text-amber-500">
            <i class="fas fa-users text-lg"></i>
        </div>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-[#F51B1B] uppercase tracking-widest">Top Plan</h3>
            <p class="text-sm font-black text-[#F51B1B] mt-1 truncate max-w-[120px]">{{ $plans->sortByDesc('memberships_count')->first()->name ?? 'N/A' }}</p>
        </div>
        <div class="w-10 h-10 bg-[#F51B1B]/10 border border-[#F51B1B]/20 rounded-xl flex items-center justify-center text-[#F51B1B]">
            <i class="fas fa-star text-lg"></i>
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Plan</th>
                    <th class="px-6 py-4 text-center">Precio</th>
                    <th class="px-6 py-4 text-center">Duración</th>
                    <th class="px-6 py-4 text-center">Usuarios</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($plans as $plan)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#0d0d0d] border border-white/10 rounded-xl flex items-center justify-center text-[#FF2121]">
                                    <i class="fas fa-id-badge"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-white group-hover:text-[#FF2121] transition-colors">{{ $plan->name }}</div>
                                    <div class="text-[10px] text-gray-500 font-mono tracking-tighter">{{ $plan->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-white font-mono">${{ number_format($plan->price, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs text-gray-300 font-medium">{{ $plan->duration_days }} días</span>
                            <span class="text-[10px] font-black uppercase tracking-wider text-gray-500 bg-white/5 px-2 py-0.5 rounded-md ml-2">{{ $plan->duration }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-black text-gray-400 bg-white/5 px-2.5 py-1 rounded-md">{{ $plan->memberships_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                @if($plan->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Inactivo
                                    </span>
                                @endif
                                @if($plan->is_featured)
                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-amber-500/10 text-amber-500 border border-amber-500/20">Destacado</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.membership-plans.show', $plan) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all" title="Ver">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.membership-plans.edit', $plan) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.membership-plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este plan?')">
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
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center text-gray-500">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fas fa-crown text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">Sin planes</p>
                                <p class="text-sm text-gray-600 mt-1">Crea tu primer plan de membresía.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection