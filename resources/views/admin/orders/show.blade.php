@extends('layouts.admin')

@section('title', 'Orden #' . $order->order_number)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('admin.orders.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Orden #{{ $order->order_number }}</h1>
            <p class="text-gray-400 mt-1">Realizada el {{ $order->created_at->format('d M, Y \a \l\a\s H:i') }}</p>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center gap-3">
            @csrf
            @method('PATCH')
            <select name="status" class="bg-gray-800 border border-white/10 rounded-xl px-4 py-2.5 text-xs font-bold text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-[#FF2121]">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Procesando</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completada</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Reembolsada</option>
            </select>
            <button type="submit" class="bg-[#F51B1B] hover:bg-[#FF2121] text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                Actualizar
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    <!-- Left: Order Details & Items -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Status Banner -->
        <div class="p-6 rounded-3xl border {{ $order->status === 'completed' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-amber-500/10 border-amber-500/20 text-amber-400' }} flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fas {{ $order->status === 'completed' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-none uppercase tracking-widest">Estado: {{ $order->status }}</h3>
                    <p class="text-xs opacity-70 mt-1">La orden se encuentra actualmente en estado {{ $order->status }}.</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase opacity-60">ID Transacción</p>
                <p class="font-mono text-xs">{{ $order->transaction_id ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-white/5 bg-white/[0.02]">
                <h2 class="text-xl font-bold text-white">Items de la Orden</h2>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-900/40 text-gray-500 text-[10px] uppercase font-bold tracking-widest border-b border-white/5">
                    <tr>
                        <th class="px-8 py-4">Producto</th>
                        <th class="px-8 py-4 text-center">Precio</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @foreach($order->items as $item)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-900 rounded-xl flex items-center justify-center text-xl mr-4 border border-white/5">
                                        @if($item->product && $item->product->type === 'theme') 🎨 @elseif($item->product) ⚡ @else 👑 @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ $item->product_name }}</p>
                                        <p class="text-[10px] text-gray-500 font-mono uppercase tracking-tighter">
                                            {{ $item->membership_plan_id ? 'PLAN ID: ' . $item->membership_plan_id : 'SKU: PD-' . $item->product_id }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center text-white font-mono font-bold">
                                ${{ number_format($item->price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Summary -->
            <div class="p-8 bg-black/20 border-t border-white/5 space-y-3">
                <div class="flex justify-between items-center text-gray-400 text-sm">
                    <span>Subtotal</span>
                    <span class="font-mono text-white">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-400 text-sm">
                    <span>Impuestos (0%)</span>
                    <span class="font-mono text-white">${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-white/5">
                    <span class="text-white font-bold uppercase tracking-widest text-xs">Total Facturado</span>
                    <span class="text-2xl font-black text-[#FF2121] font-mono">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Customer & Actions -->
    <div class="space-y-8">
        <!-- Customer Info -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5">Información del Cliente</h3>
            <div class="flex items-center mb-6">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&background=6366f1&color=fff&bold=true" class="w-14 h-14 rounded-2xl ring-4 ring-[#FF2121]/10">
                <div class="ml-4">
                    <p class="font-bold text-white text-lg leading-tight">{{ $order->user->name }}</p>
                    <p class="text-xs text-gray-500 font-mono">{{ $order->user->email }}</p>
                </div>
            </div>
            <div class="space-y-4">
                <a href="{{ route('admin.users.show', $order->user) }}" class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl border border-white/5 hover:bg-[#F51B1B]/10 hover:border-[#FF2121]/30 transition-all group">
                    <span class="text-xs font-bold text-gray-400 group-hover:text-[#FF2121]">Ver Perfil</span>
                    <i class="fas fa-chevron-right text-[10px] text-gray-600 group-hover:text-[#FF2121]"></i>
                </a>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5">Pago y Notas</h3>
            <div class="space-y-6">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Método de Pago</p>
                    <div class="flex items-center gap-2 text-white font-bold">
                        <i class="fas {{ $order->payment_method === 'manual' ? 'fa-money-bill-transfer' : 'fab fa-stripe' }} text-xl text-[#FF2121]"></i>
                        {{ strtoupper($order->payment_method ?? 'Stripe') }}
                    </div>
                </div>

                @if($order->payment_proof)
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Comprobante de Pago</p>
                    <div class="rounded-2xl border border-white/10 overflow-hidden aspect-video relative group mb-3">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-full object-cover">
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg text-[10px] font-black text-white uppercase tracking-widest border border-white/10">Ver Pantalla Completa</span>
                        </a>
                    </div>
                    @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-black uppercase text-[10px] tracking-widest rounded-xl transition-all shadow-lg shadow-emerald-600/20 active:scale-95">
                            Aprobar Pago <i class="fas fa-check-circle ml-2"></i>
                        </button>
                    </form>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Notas del Cliente (Pago)</p>
                    <p class="text-xs text-gray-400 leading-relaxed bg-black/20 p-4 rounded-xl border border-white/5">
                        {{ $order->payment_notes ?? 'Sin observaciones de pago.' }}
                    </p>
                </div>
                @endif

                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Notas de la Orden</p>
                    <p class="text-xs text-gray-400 leading-relaxed italic">
                        {{ $order->notes ?? 'Sin notas adicionales.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection