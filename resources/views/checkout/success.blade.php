@extends('layouts.frontend')

@section('title', 'Orden Confirmada - ' . ($globalSettings['site_name'] ?? 'WP Marketplace'))

@section('content')
<main class="py-20 max-w-5xl mx-auto px-6">
    <h1 class="text-4xl font-black text-white mb-12 tracking-tight flex items-center gap-4">
        <i class="fas fa-check-circle text-[#FF2121]"></i> Orden Confirmada
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Confirmation + Items -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Confirmation Card -->
            <div class="glass p-8 rounded-[32px] border-white/5 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/10 blur-[50px] rounded-full"></div>

                <div class="relative flex items-start gap-5">
                    <div class="w-16 h-16 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 shrink-0">
                        <i class="fas fa-check text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-white mb-2">¡Gracias por tu compra!</h2>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Tu orden <span class="text-white font-mono font-black">#{{ $order->order_number }}</span> ha sido procesada correctamente.
                            @if($order->status === 'completed')
                                Ya puedes descargar tus productos desde tu panel.
                            @else
                                Te enviaremos un email cuando el pago sea confirmado.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @php
                $hasLicense = $order->items->contains(function($item) {
                    return $item->product && $item->product->is_license;
                });
            @endphp

            @if($hasLicense)
                <!-- License Activation Notice -->
                <div class="p-8 bg-amber-500/10 border border-amber-500/20 rounded-[32px] relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/10 blur-[50px] rounded-full"></div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 rounded-2xl flex items-center justify-center text-amber-500 shrink-0 text-lg">
                                <i class="fas fa-key"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-base mb-1">🔑 Tu compra incluye una Licencia Oficial</h3>
                                <p class="text-gray-400 text-xs leading-relaxed">
                                    Para activar tu licencia original, por favor crea un Ticket de Soporte indicando el producto y la URL del sitio web donde deseas activarlo.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('user.support.create') }}" class="px-5 py-3 bg-amber-500 hover:bg-amber-600 text-black text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-amber-500/10 shrink-0">
                            Solicitar Activación <i class="fas fa-ticket-alt ml-1.5"></i>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Items -->
            <div>
                <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] mb-6">Productos Adquiridos</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="glass p-6 rounded-[32px] border-white/5 flex items-center gap-6">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-900 border border-white/10 flex-shrink-0 flex items-center justify-center gradient-bg text-3xl">
                                @if($item->product && $item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas {{ $item->product_type === 'membership' ? 'fa-crown' : 'fa-box' }} text-white text-2xl"></i>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-white truncate">{{ $item->product_name }}</h3>
                                <div class="flex items-center gap-4 text-sm font-bold uppercase tracking-widest mt-1">
                                    <span class="text-[#FF2121]">{{ $item->product_type === 'membership' ? 'Membresía' : $item->product_type }}</span>
                                    <span class="text-gray-600 font-mono text-xs">Cant: {{ $item->quantity }}</span>
                                </div>
                            </div>

                            <div class="text-right shrink-0">
                                <div class="text-xl font-black text-white font-mono">${{ number_format($item->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Summary + Actions -->
        <div class="space-y-8">
            <div class="glass p-8 rounded-[40px] border-[#FF2121]/20 shadow-2xl shadow-[#F51B1B]/10 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#FF2121]/10 blur-[50px] rounded-full"></div>

                <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] pb-6 border-b border-white/5 mb-6">Resumen de Orden</h3>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center text-sm font-bold">
                        <span class="text-gray-500 uppercase">Subtotal</span>
                        <span class="text-white font-mono font-black">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-gray-500 uppercase">Descuento</span>
                            <span class="text-emerald-400 font-mono font-black">-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center text-sm font-bold">
                        <span class="text-gray-500 uppercase">Impuestos</span>
                        <span class="text-white font-mono font-black">${{ number_format($order->tax, 2) }}</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-black text-white uppercase tracking-tighter">Total</span>
                        <span class="text-3xl font-black text-[#FF2121] font-mono tracking-tighter">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                @if($order->status === 'pending')
                    <a href="{{ route('user.orders.show', $order) }}" class="block w-full py-5 bg-amber-500 text-white font-black text-center rounded-2xl shadow-xl shadow-amber-500/30 hover:opacity-90 transition-all uppercase tracking-[0.2em] text-xs">
                        Subir Comprobante <i class="fas fa-file-invoice ml-2"></i>
                    </a>
                @else
                    <a href="{{ route('user.downloads') }}" class="block w-full py-5 gradient-bg text-white font-black text-center rounded-2xl shadow-xl shadow-[#F51B1B]/30 hover:opacity-90 transition-all uppercase tracking-[0.2em] text-xs">
                        Ir a mis Descargas <i class="fas fa-download ml-2"></i>
                    </a>
                @endif
            </div>

            <div class="bg-[#F51B1B]/10 p-6 rounded-3xl border border-[#FF2121]/10 text-center">
                <div class="text-[#FF2121] mb-3"><i class="fas fa-shield-halved text-2xl"></i></div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed">
                    Pago Seguro & <br> Actualizaciones Garantizadas
                </p>
            </div>

            <div class="flex items-center justify-center gap-4 text-[11px] font-black text-gray-500 uppercase tracking-widest">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Inicio</a>
                <span>•</span>
                <a href="{{ route('user.orders.show', $order) }}" class="hover:text-white transition-colors">Ver Orden</a>
                <span>•</span>
                <a href="{{ auth()->check() ? route('user.support.index') : '#' }}" class="hover:text-white transition-colors">Soporte</a>
            </div>
        </div>
    </div>
</main>
@endsection
