@extends('layouts.admin')

@section('title', 'Gestionar Suscripciones')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Suscripciones</h1>
        <p class="text-gray-500 text-sm mt-1">Administra accesos, límites y vigencia de las membresías activas.</p>
    </div>
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
                    <th class="px-6 py-4">Usuario</th>
                    <th class="px-6 py-4">Plan</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-center">Vence</th>
                    <th class="px-6 py-4 text-center">Extras</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($memberships as $membership)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#0d0d0d] border border-white/10 rounded-xl flex items-center justify-center text-[#FF2121]">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-white block">{{ $membership->user->name }}</span>
                                    <span class="text-[10px] text-gray-500 font-mono">{{ $membership->user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-white/5 text-gray-300 border border-white/10">
                                {{ $membership->plan->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'active' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'expired' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    'cancelled' => 'bg-gray-500/10 text-gray-400 border-white/5',
                                    'suspended' => 'bg-rose-600/20 text-rose-500 border-rose-500/30'
                                ];
                                $currentClass = $statusClasses[$membership->status] ?? $statusClasses['cancelled'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $currentClass }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $membership->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($membership->expires_at)
                                <span class="text-xs font-bold {{ $membership->expires_at->isPast() ? 'text-rose-400' : 'text-gray-400' }}">
                                    {{ $membership->expires_at->format('d/m/Y') }}
                                </span>
                                <p class="text-[10px] text-gray-600 mt-0.5 italic">{{ $membership->expires_at->diffForHumans() }}</p>
                            @else
                                <span class="text-xs font-black text-emerald-400 uppercase tracking-widest italic">De por vida</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-[#FF2121] font-black text-sm">+{{ $membership->extra_daily_downloads }}</span>
                            <p class="text-[10px] text-gray-600 uppercase font-black tracking-widest">Bonus/Día</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <form action="{{ route('admin.memberships.toggle-status', $membership) }}" method="POST" class="inline">
                                    @csrf
                                    @if($membership->status === 'active')
                                        <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all border-none cursor-pointer bg-transparent" title="Suspender/Bloquear Membresía">
                                            <i class="fas fa-ban text-xs"></i>
                                        </button>
                                    @else
                                        <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-emerald-400 hover:bg-emerald-400/10 rounded-lg transition-all border-none cursor-pointer bg-transparent" title="Activar/Desbloquear Membresía">
                                            <i class="fas fa-unlock text-xs"></i>
                                        </button>
                                    @endif
                                </form>
                                <a href="{{ route('admin.memberships.edit', $membership) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.memberships.destroy', $membership) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres eliminar esta suscripción? El usuario perderá el acceso.')">
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
                                    <i class="fas fa-id-card text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">No hay suscripciones</p>
                                <p class="text-sm text-gray-600 mt-1">Las membresías activas aparecerán aquí.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($memberships->hasPages())
<div class="mt-6">
    {{ $memberships->links() }}
</div>
@endif
@endsection