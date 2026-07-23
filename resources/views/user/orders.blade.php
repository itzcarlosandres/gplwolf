@extends('layouts.user')

@section('title', 'Mis Compras - GPLWolf')

@section('content')
<div class="space-y-8 pb-20 text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black tracking-tight">Mis Compras</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-1.5">Historial completo y comprobantes de tus transacciones.</p>
        </div>
    </div>

    @php
        $statsOrders = Auth::user()->orders()->get();
        $totalSpent = $statsOrders->where('status', 'completed')->sum('total');
        $completedCount = $statsOrders->where('status', 'completed')->count();
        $pendingCount = $statsOrders->where('status', 'pending')->count();
    @endphp

    <!-- Stats summary bar -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="glass border border-white/5 rounded-3xl p-6 relative overflow-hidden group hover:border-[#FF2121]/30 transition-all duration-300">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-[#FF2121]/5 rounded-full blur-2xl group-hover:bg-[#FF2121]/15 transition-all"></div>
            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-gray-500 font-bold uppercase text-[9px] tracking-widest mb-1.5">Total Invertido</span>
                    <span class="text-3xl font-black text-white">${{ number_format($totalSpent, 2) }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>

        <div class="glass border border-white/5 rounded-3xl p-6 relative overflow-hidden group hover:border-[#FF2121]/30 transition-all duration-300">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-[#FF2121]/5 rounded-full blur-2xl group-hover:bg-[#FF2121]/15 transition-all"></div>
            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-gray-500 font-bold uppercase text-[9px] tracking-widest mb-1.5">Compras Completadas</span>
                    <span class="text-3xl font-black text-white">{{ $completedCount }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center text-xl">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <div class="glass border border-white/5 rounded-3xl p-6 relative overflow-hidden group hover:border-[#FF2121]/30 transition-all duration-300">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-[#FF2121]/5 rounded-full blur-2xl group-hover:bg-[#FF2121]/15 transition-all"></div>
            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-gray-500 font-bold uppercase text-[9px] tracking-widest mb-1.5">Pendiente de Aprobación</span>
                    <span class="text-3xl font-black text-white">{{ $pendingCount }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-xl">
                    <i class="fas fa-hourglass-half animate-pulse"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="glass rounded-[32px] border border-white/10 overflow-hidden shadow-2xl backdrop-blur-xl">
        
        <!-- Desktop Table view -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/10 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                        <th class="px-8 py-5">Nº Pedido</th>
                        <th class="px-8 py-5">Fecha de Compra</th>
                        <th class="px-8 py-5 text-center">Items Adquiridos</th>
                        <th class="px-8 py-5 text-right">Monto Total</th>
                        <th class="px-8 py-5 text-center">Estado del Pago</th>
                        <th class="px-8 py-5 text-right">Detalle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @forelse($orders as $order)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-5">
                                <span class="font-black text-white hover:text-[#FF2121] transition-colors">
                                    #{{ $order->order_number ?? substr($order->id, 0, 8) }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-gray-400 font-medium">
                                {{ $order->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-center -space-x-3">
                                    @foreach($order->items->take(4) as $item)
                                        <div class="w-9 h-9 rounded-xl bg-gray-900 border-2 border-[#09090b] flex items-center justify-center text-[10px] text-white overflow-hidden shadow-md group-hover:scale-105 transition-transform" title="{{ $item->product_name }}">
                                            @if($item->product && $item->product->thumbnail)
                                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                                            @elseif($item->membership_plan_id)
                                                <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-amber-600 flex items-center justify-center text-[9px] font-black text-black">VIP</div>
                                            @else
                                                <div class="w-full h-full bg-red-600/20 flex items-center justify-center text-red-500">
                                                    <i class="fas fa-cube text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 4)
                                        <div class="w-9 h-9 rounded-xl bg-[#FF2121] border-2 border-[#09090b] flex items-center justify-center text-[9px] font-black text-white shadow-md">
                                            +{{ $order->items->count() - 4 }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right font-black text-white text-base">
                                ${{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-8 py-5 text-center">
                                @if($order->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-[0_0_10px_rgba(16,185,129,0.1)]">
                                        <i class="fas fa-check-circle mr-1.5"></i> Completado
                                    </span>
                                @elseif($order->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20 shadow-[0_0_10px_rgba(245,158,11,0.1)]">
                                        <i class="fas fa-hourglass-half mr-1.5 animate-pulse"></i> Pendiente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20">
                                        <i class="fas fa-times-circle mr-1.5"></i> Cancelado
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2.5">
                                    @if($order->status === 'pending' && $order->payment_method === 'manual')
                                        <a href="{{ route('user.orders.show', $order) }}" class="px-4 py-2 bg-[#FF2121] hover:bg-red-500 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all duration-300 shadow-md shadow-red-500/20">
                                            Pagar Ahora <i class="fas fa-money-bill-transfer ml-1.5"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('user.orders.show', $order) }}" class="w-10 h-10 bg-white/5 border border-white/5 hover:border-white/20 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 hover:bg-white/10" title="Ver Detalles">
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <div class="opacity-40 flex flex-col items-center">
                                    <i class="fas fa-shopping-bag text-5xl text-gray-500 mb-4 animate-bounce"></i>
                                    <p class="text-lg font-black uppercase tracking-widest text-gray-400">No tienes compras registradas</p>
                                    <p class="text-xs text-gray-500 mt-2 font-medium">¡Explora nuestro catálogo y empieza a descargar recursos premium!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="block md:hidden divide-y divide-white/5">
            @forelse($orders as $order)
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-500">Nº Pedido</span>
                        <span class="font-black text-white">#{{ $order->order_number ?? substr($order->id, 0, 8) }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-500">Fecha</span>
                        <span class="text-gray-300 text-sm font-medium">{{ $order->created_at->format('d M, Y') }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-500">Monto Total</span>
                        <span class="text-white font-black text-base">${{ number_format($order->total, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-gray-500">Estado</span>
                        @if($order->status === 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Completado
                            </span>
                        @elseif($order->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                Pendiente
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20">
                                Cancelado
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <div class="flex -space-x-2">
                            @foreach($order->items->take(4) as $item)
                                <div class="w-8 h-8 rounded-lg bg-gray-900 border-2 border-[#09090b] flex items-center justify-center text-[10px] text-white overflow-hidden shadow-md" title="{{ $item->product_name }}">
                                    @if($item->product && $item->product->thumbnail)
                                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                                    @elseif($item->membership_plan_id)
                                        <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-amber-600 flex items-center justify-center text-[8px] font-black text-black">VIP</div>
                                    @else
                                        <i class="fas fa-cube text-xs text-gray-700"></i>
                                    @endif
                                </div>
                            @endforeach
                            @if($order->items->count() > 4)
                                <div class="w-8 h-8 rounded-lg bg-[#FF2121] border-2 border-[#09090b] flex items-center justify-center text-[8px] font-black text-white shadow-md">
                                    +{{ $order->items->count() - 4 }}
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            @if($order->status === 'pending' && $order->payment_method === 'manual')
                                <a href="{{ route('user.orders.show', $order) }}" class="px-3 py-1.5 bg-[#FF2121] text-white rounded-lg text-[9px] font-black uppercase tracking-wider shadow-md">
                                    Pagar
                                </a>
                            @endif
                            <a href="{{ route('user.orders.show', $order) }}" class="px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-black text-gray-300 hover:text-white">
                                Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500 italic">No tienes compras registradas.</div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</div>
@endsection