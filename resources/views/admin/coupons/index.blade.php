@extends('layouts.admin')

@section('title', 'Gestionar Cupones')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Cupones</h1>
        <p class="text-gray-500 text-sm mt-1">Crea y administra códigos promocionales para tus clientes.</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
        <i class="fas fa-plus"></i> Nuevo Cupón
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
                    <th class="px-6 py-4">Código</th>
                    <th class="px-6 py-4">Valor</th>
                    <th class="px-6 py-4 text-center">Uso</th>
                    <th class="px-6 py-4 text-center">Vence</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($coupons as $coupon)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#0d0d0d] border border-white/10 rounded-xl flex items-center justify-center text-[#FF2121]">
                                    <i class="fas fa-ticket-alt text-sm"></i>
                                </div>
                                <span class="font-black text-white font-mono uppercase tracking-widest">{{ $coupon->code }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white font-bold font-mono">
                                @if($coupon->type === 'percent')
                                    {{ number_format($coupon->value, 0) }}%
                                @else
                                    ${{ number_format($coupon->value, 2) }}
                                @endif
                            </span>
                            <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">Mín: ${{ number_format($coupon->min_purchase, 0) }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-xs font-black text-gray-400 font-mono">
                                    {{ $coupon->usage_count }} / {{ $coupon->usage_limit ?: '∞' }}
                                </span>
                                <div class="w-20 h-1.5 bg-[#0d0d0d] rounded-full overflow-hidden border border-white/10">
                                    <div class="h-full bg-[#FF2121] rounded-full" style="width: {{ $coupon->usage_limit ? min(($coupon->usage_count / $coupon->usage_limit * 100), 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($coupon->expires_at)
                                <span class="text-xs font-bold {{ $coupon->expires_at->isPast() ? 'text-rose-400' : 'text-gray-400' }}">
                                    {{ $coupon->expires_at->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-xs font-black text-emerald-400 italic">Nunca</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro?')">
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
                                    <i class="fas fa-ticket-alt text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">No hay cupones</p>
                                <p class="text-sm text-gray-600 mt-1">Crea tu primer código promocional.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection