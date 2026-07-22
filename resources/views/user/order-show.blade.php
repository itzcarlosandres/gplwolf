@extends('layouts.user')

@section('title', 'Detalles del Pedido #' . substr($order->id, 0, 8))

@section('content')
<div class="space-y-10 pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <a href="{{ route('user.orders') }}" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <h1 class="text-4xl font-black text-white leading-tight">Pedido #{{ substr($order->id, 0, 8) }}</h1>
            </div>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] ml-14">Realizado el {{ $order->created_at->format('d M, Y \a \l\a\s H:i') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] border {{ $order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                Estado: {{ strtoupper($order->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Products Card -->
            <div class="glass rounded-[40px] border-white/5 overflow-hidden">
                <div class="p-8 border-b border-white/5 bg-white/5">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-[#FF2121]"></i> Productos en este pedido
                    </h3>
                </div>
                <div class="divide-y divide-white/5">
                    @foreach($order->items as $item)
                        <div class="p-8 flex items-center justify-between group">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 bg-gray-900 rounded-2xl border border-white/10 flex items-center justify-center overflow-hidden">
                                    @if($item->product && $item->product->thumbnail)
                                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                                    @elseif($item->membership_plan_id)
                                        <div class="w-full h-full bg-[#F51B1B] flex items-center justify-center text-white text-xl font-black italic">VIP</div>
                                    @else
                                        <i class="fas fa-box text-gray-700 text-2xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-lg group-hover:text-[#FF2121] transition-colors uppercase">{{ $item->product_name }}</h4>
                                    <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">{{ $item->product_type }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-white font-black text-xl">${{ number_format($item->price, 2) }}</div>
                                <div class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">Cantidad: {{ $item->quantity }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Totals -->
                <div class="p-8 bg-black/20 border-t border-white/5 space-y-3">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-widest">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-white font-mono">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-lg font-black uppercase tracking-tighter italic">
                        <span class="text-white">Total Pagado</span>
                        <span class="text-[#FF2121] font-mono text-3xl">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions (Only if pending manual) -->
            @if($order->status === 'pending' && $order->payment_method === 'manual')
                <div class="glass p-10 rounded-[40px] border-amber-500/20 relative overflow-hidden">
                    <div class="absolute -top-20 -left-20 w-64 h-64 bg-amber-600/5 blur-[100px] rounded-full"></div>
                    
                    <h3 class="text-xl font-black text-white uppercase tracking-widest mb-8 flex items-center gap-3">
                        <i class="fas fa-money-bill-transfer text-amber-500"></i> Instrucciones de Pago Manual
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        @if($paymentSettings['manual_payment_bank'] ?? false)
                        <div class="space-y-3">
                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest block ml-1">Banco / Transferencia</span>
                            <div class="p-6 bg-white/5 border border-white/10 rounded-2xl text-sm font-mono text-gray-300 whitespace-pre-line leading-relaxed">{{ $paymentSettings['manual_payment_bank'] }}</div>
                        </div>
                        @endif

                        @if($paymentSettings['manual_payment_binance'] ?? false)
                        <div class="space-y-3">
                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest block ml-1">Binance Pay / Wallet</span>
                            <div class="p-6 bg-white/5 border border-white/10 rounded-2xl text-sm font-mono text-gray-300 whitespace-pre-line leading-relaxed">{{ $paymentSettings['manual_payment_binance'] }}</div>
                        </div>
                        @endif
                    </div>

                    <div class="p-6 bg-amber-500/5 border border-amber-500/10 rounded-3xl">
                        <p class="text-xs text-amber-200/70 font-medium leading-relaxed italic">
                            {{ $paymentSettings['manual_payment_instructions'] ?? 'Por favor realiza el pago y sube una captura de pantalla del comprobante usando el formulario de la derecha.' }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-10">
            <!-- Payment Proof Upload -->
            @if($order->status === 'pending' && $order->payment_method === 'manual')
                <div class="glass p-8 rounded-[40px] border-white/5 space-y-8 relative overflow-hidden">
                    @if($order->payment_proof)
                        <div class="text-center space-y-4">
                            <div class="w-20 h-20 bg-emerald-500/10 rounded-3xl flex items-center justify-center text-emerald-500 text-3xl mx-auto shadow-lg shadow-emerald-500/20">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <h4 class="text-xl font-black text-white uppercase">¡Comprobante Subido!</h4>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-loose">
                                Estamos revisando tu comprobante. Recibirás un correo cuando tu pedido sea completado y tus productos estén listos.
                            </p>
                            <div class="mt-6 border-2 border-white/5 rounded-2xl overflow-hidden aspect-video relative group">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg text-[10px] font-black text-white uppercase tracking-widest border border-white/10">Ver Pantalla Completa</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6">Subir Comprobante</h3>
                            <form action="{{ route('user.orders.upload-proof', $order) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Imagen del Pago</label>
                                    <div class="relative group">
                                        <input type="file" name="payment_proof" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="w-full bg-white/5 border-2 border-dashed border-white/10 rounded-2xl p-10 flex flex-col items-center justify-center group-hover:border-[#FF2121]/50 transition-all group-hover:bg-[#FF2121]/5">
                                            <i class="fas fa-cloud-arrow-up text-3xl text-gray-600 group-hover:text-[#FF2121] transition-colors mb-3"></i>
                                            <span class="text-[10px] font-black text-gray-500 group-hover:text-[#FF2121] transition-colors uppercase tracking-widest">Click para Seleccionar</span>
                                        </div>
                                    </div>
                                    <p class="text-[8px] text-gray-600 font-bold uppercase tracking-widest text-center mt-2">JPG, PNG o WEBP (Máx 2MB)</p>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Nota adicional</label>
                                    <textarea name="payment_notes" rows="2" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white text-xs placeholder:text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all resize-none" placeholder="Referencia u observaciones..."></textarea>
                                </div>

                                <button type="submit" class="w-full py-5 gradient-bg text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-[#F51B1B]/20 hover:scale-[1.02] active:scale-95 transition-all">
                                    Enviar para Revisión <i class="fas fa-paper-plane ml-2"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Help box -->
            <div class="glass p-8 rounded-[40px] border-white/5 text-center space-y-6">
                <div class="w-16 h-16 bg-white/5 rounded-3xl flex items-center justify-center text-gray-500 mx-auto">
                    <i class="fas fa-headset text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-2">¿Necesitas Ayuda?</h4>
                    <p class="text-xs text-gray-500 font-medium leading-relaxed">
                        Si tienes problemas con tu pago, contáctanos indicando el ID del pedido.
                    </p>
                </div>
                <a href="#" class="block w-full py-4 bg-white/5 hover:bg-white/10 text-white font-black uppercase text-[10px] tracking-widest rounded-2xl transition-all border border-white/10">
                    Soporte WP Market
                </a>
            </div>
        </div>
    </div>
</div>
@endsection