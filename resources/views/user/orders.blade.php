@extends('layouts.user')

@section('title', 'Mis Compras')

@section('content')
<div class="space-y-10 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-white leading-tight">Mis Compras</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Historial completo de tus transacciones.</p>
        </div>
    </div>

    <div class="glass rounded-[40px] border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">
                        <th class="px-8 py-6">Pedido</th>
                        <th class="px-8 py-6">Fecha</th>
                        <th class="px-8 py-6 text-center">Productos</th>
                        <th class="px-8 py-6 text-right">Total</th>
                        <th class="px-8 py-6 text-center">Estado</th>
                        <th class="px-8 py-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @forelse($orders as $order)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-6">
                                <span class="font-bold text-white">#{{ substr($order->id, 0, 8) }}</span>
                            </td>
                            <td class="px-8 py-6 text-gray-400">
                                {{ $order->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex justify-center -space-x-3">
                                    @foreach($order->items->take(3) as $item)
                                        <div class="w-8 h-8 rounded-lg bg-gray-900 border-2 border-[#030712] flex items-center justify-center text-[10px] text-white overflow-hidden shadow-lg" title="{{ $item->product_name }}">
                                            @if($item->product && $item->product->thumbnail)
                                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                                            @elseif($item->membership_plan_id)
                                                <div class="w-full h-full bg-[#F51B1B] flex items-center justify-center text-[8px] font-black italic">VIP</div>
                                            @else
                                                <i class="fas fa-box text-gray-700"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <div class="w-8 h-8 rounded-lg bg-[#F51B1B] border-2 border-[#030712] flex items-center justify-center text-[8px] font-black text-white shadow-lg">
                                            +{{ $order->items->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right font-black text-white text-lg">
                                ${{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest border {{ $order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($order->status === 'pending' && $order->payment_method === 'manual')
                                        <a href="{{ route('user.orders.show', $order) }}" class="px-4 py-2 bg-amber-500/10 hover:bg-amber-500 text-amber-500 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-amber-500/20">
                                            Pagar Ahora <i class="fas fa-money-bill-transfer ml-2"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('user.orders.show', $order) }}" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all hover:bg-white/10" title="Ver Detalles">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="opacity-20 flex flex-col items-center">
                                    <i class="fas fa-shopping-bag text-6xl mb-6"></i>
                                    <p class="text-xl font-black uppercase tracking-widest">No tienes compras todavía</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</div>
@endsection