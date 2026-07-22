@extends('layouts.admin')

@section('title', 'Gestión de Órdenes')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Órdenes</h1>
        <p class="text-gray-500 text-sm mt-1">Administra ventas, facturación y estados de entrega.</p>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5">
        <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Total Órdenes</h3>
        <p class="text-2xl font-black text-white">{{ number_format($stats['total_orders']) }}</p>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5">
        <h3 class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">Pendientes</h3>
        <p class="text-2xl font-black text-amber-500">{{ number_format($stats['pending_orders']) }}</p>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5">
        <h3 class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1">Completadas</h3>
        <p class="text-2xl font-black text-emerald-500">{{ number_format($stats['completed_orders']) }}</p>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5">
        <h3 class="text-[10px] font-black text-[#FF2121] uppercase tracking-widest mb-1">Ingresos Totales</h3>
        <p class="text-2xl font-black text-[#FF2121] font-mono tracking-tighter">${{ number_format($stats['total_revenue'], 2) }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6 mb-8">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ID, email, nombre..." class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-600">
        </div>
        <div>
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Estado</label>
            <select name="status" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                <option value="" class="bg-[#0d0d0d] uppercase">Todos</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="bg-[#0d0d0d] uppercase">Pendiente</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }} class="bg-[#0d0d0d] uppercase">Procesando</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }} class="bg-[#0d0d0d] uppercase">Completada</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }} class="bg-[#0d0d0d] uppercase">Cancelada</option>
            </select>
        </div>
        <div class="md:col-span-2 flex items-end gap-3">
            <button type="submit" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
                <i class="fas fa-filter"></i> Aplicar
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 text-gray-300 rounded-xl text-xs font-black transition-all border border-white/10">
                Limpiar
            </a>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">ID / Fecha</th>
                    <th class="px-6 py-4">Cliente</th>
                    <th class="px-6 py-4 text-center">Items</th>
                    <th class="px-6 py-4 text-center">Total</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($orders as $order)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-mono text-[#FF2121] font-bold group-hover:text-[#FF2121]">#{{ $order->order_number }}</div>
                            <div class="text-[10px] text-gray-500 font-medium mt-0.5 uppercase tracking-tighter">{{ $order->created_at->format('M j, Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-500 font-mono">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-black text-gray-400 bg-white/5 px-2.5 py-1 rounded-md">{{ $order->items->count() }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-white font-mono">${{ number_format($order->total, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'completed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'pending'   => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'cancelled' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    'processing'=> 'bg-[#FF2121]/10 text-[#FF2121] border-[#FF2121]/20',
                                ];
                                $currentClass = $statusClasses[$order->status] ?? 'bg-gray-500/10 text-gray-400 border-white/5';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $currentClass }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.orders.show', $order) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all" title="Ver Detalles">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de ELIMINAR esta orden?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all" title="Eliminar Orden">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select onchange="if(confirm('¿Cambiar estado de la orden?')) this.form.submit()" name="status" class="text-[10px] font-black uppercase tracking-wider bg-[#0d0d0d] border border-white/10 rounded-lg px-2 py-1.5 text-gray-400 focus:outline-none focus:border-[#FF2121] transition-colors cursor-pointer">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>PEND.</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>PROC.</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>COMPL.</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>CANC.</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center text-gray-500">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fas fa-receipt text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">Sin órdenes</p>
                                <p class="text-sm text-gray-600 mt-1">Las ventas aparecerán aquí.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="px-6 py-4 bg-white/[0.02] border-t border-white/5">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection