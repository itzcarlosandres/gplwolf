@extends('layouts.frontend')

@section('title', 'Finalizar Compra - WP Marketplace')

@section('extra_css')
<style>
    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: #FF2121 !important;
        box-shadow: 0 0 0 3px rgba(255, 33, 33, 0.1);
    }
</style>
@endsection

@section('content')
<main class="max-w-6xl mx-auto px-6 pb-24 pt-10 md:pt-16">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition">Inicio</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <a href="{{ route('cart.index') }}" class="hover:text-white transition">Carrito</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-gray-400">Checkout</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-2">Finalizar Compra</h1>
        <p class="text-gray-500 text-sm">Completa tu información para generar tus licencias.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-sm font-bold flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-10">
        <!-- Left: Checkout Form -->
        <div class="lg:col-span-3 space-y-6">
            <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Billing Info -->
                <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl p-6 space-y-5">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest pb-4 border-b border-white/[0.06] flex items-center gap-2">
                        <i class="fas fa-user-circle text-[#FF2121] text-xs"></i> Información de Contacto
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-wider">Nombre</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full bg-[#111111] border border-white/10 rounded-xl px-4 py-3 text-gray-400 font-bold text-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-wider">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full bg-[#111111] border border-white/10 rounded-xl px-4 py-3 text-gray-400 font-bold text-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-wider">Notas de Pedido <span class="text-gray-600">(Opcional)</span></label>
                        <textarea name="notes" rows="3" class="w-full bg-[#111111] border border-white/10 rounded-xl px-4 py-3 text-white text-sm transition-all focus:bg-[#121a2b] resize-none" placeholder="¿Algo que debamos saber?"></textarea>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl p-6 space-y-5" x-data="{ method: 'paypal' }">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest pb-4 border-b border-white/[0.06] flex items-center gap-2">
                        <i class="fas fa-credit-card text-[#FF2121] text-xs"></i> Método de Pago
                    </h3>
                    
                    <div class="space-y-3">
                        <!-- PayPal Option -->
                        <label :class="method === 'paypal' ? 'border-[#FF2121] bg-[#FF2121]/10' : 'border-white/10 bg-[#111111] hover:border-white/20'" class="relative flex items-center p-4 border rounded-xl cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="paypal" x-model="method" class="hidden">
                            <div class="w-5 h-5 rounded-full border-2 mr-4 flex items-center justify-center" :class="method === 'paypal' ? 'border-[#FF2121]' : 'border-gray-600'">
                                <div x-show="method === 'paypal'" class="w-2.5 h-2.5 rounded-full bg-[#FF2121]"></div>
                            </div>
                            <div class="flex-1">
                                <span class="block text-sm font-bold text-white">PayPal Checkout</span>
                                <span class="block text-xs text-gray-500">Pago rápido y seguro con tu cuenta o tarjeta</span>
                            </div>
                            <i class="fab fa-paypal text-[#FF2121] text-2xl"></i>
                        </label>

                        <!-- CoinPal Option -->
                        <label :class="method === 'coinpal' ? 'border-[#FF2121] bg-[#FF2121]/10' : 'border-white/10 bg-[#111111] hover:border-white/20'" class="relative flex items-center p-4 border rounded-xl cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="coinpal" x-model="method" class="hidden">
                            <div class="w-5 h-5 rounded-full border-2 mr-4 flex items-center justify-center" :class="method === 'coinpal' ? 'border-[#FF2121]' : 'border-gray-600'">
                                <div x-show="method === 'coinpal'" class="w-2.5 h-2.5 rounded-full bg-[#FF2121]"></div>
                            </div>
                            <div class="flex-1">
                                <span class="block text-sm font-bold text-white">Criptomonedas (CoinPal)</span>
                                <span class="block text-xs text-gray-500">Baja comisión con BTC, USDT, ETH y más</span>
                            </div>
                            <div class="flex gap-2 text-gray-500">
                                <i class="fab fa-bitcoin text-amber-500 text-xl"></i>
                                <i class="fas fa-coins text-[#FF2121] text-xl"></i>
                            </div>
                        </label>

                        <!-- Points Option -->
                        @php
                            $pointsEnabled = \App\Models\Setting::where('key', 'points_enabled')->value('value');
                            $conversionRate = (int) (\App\Models\Setting::where('key', 'points_conversion_rate')->value('value') ?? 100);
                            $userPoints = auth()->user()->points;
                            $pointsNeeded = ceil($total * $conversionRate);
                            $canPayWithPoints = $userPoints >= $pointsNeeded;
                        @endphp

                        @if($pointsEnabled)
                            <label :class="method === 'points' ? 'border-amber-500 bg-amber-500/10' : 'border-white/10 bg-[#111111] {{ $canPayWithPoints ? 'hover:border-white/20' : '' }}'" class="relative flex items-center p-4 border rounded-xl cursor-pointer transition-all {{ $canPayWithPoints ? '' : 'opacity-60' }}">
                                <input type="radio" name="payment_method" value="points" x-model="method" class="hidden" {{ $canPayWithPoints ? '' : 'disabled' }}>
                                <div class="w-5 h-5 rounded-full border-2 mr-4 flex items-center justify-center" :class="method === 'points' ? 'border-amber-500' : 'border-gray-600'">
                                    <div x-show="method === 'points'" class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                                </div>
                                <div class="flex-1">
                                    <span class="block text-sm font-bold text-white">Pagar con Mis Puntos</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-xs text-gray-500">Saldo: {{ number_format($userPoints) }} pts</span>
                                        @if(!$canPayWithPoints)
                                            <span class="text-[10px] font-bold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded">Necesitas: {{ number_format($pointsNeeded) }} pts</span>
                                        @else
                                            <span class="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded">Costará: {{ number_format($pointsNeeded) }} pts</span>
                                        @endif
                                    </div>
                                </div>
                                <i class="fas fa-gem text-amber-500 text-xl {{ $canPayWithPoints ? 'animate-pulse' : '' }}"></i>
                            </label>
                        @endif

                        <!-- Manual Payment Option -->
                        <label :class="method === 'manual' ? 'border-amber-500 bg-amber-500/10' : 'border-white/10 bg-[#111111] hover:border-white/20'" class="relative flex items-center p-4 border rounded-xl cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="manual" x-model="method" class="hidden">
                            <div class="w-5 h-5 rounded-full border-2 mr-4 flex items-center justify-center" :class="method === 'manual' ? 'border-amber-500' : 'border-gray-600'">
                                <div x-show="method === 'manual'" class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                            </div>
                            <div class="flex-1">
                                <span class="block text-sm font-bold text-white">Pago Manual / Transferencia</span>
                                <span class="block text-xs text-gray-500">Transferencia, Binance o PayPal Directo</span>
                            </div>
                            <i class="fas fa-money-bill-transfer text-gray-500 text-xl"></i>
                        </label>

                        <!-- Manual Payment Details Box -->
                        <div x-show="method === 'manual'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="p-5 bg-[#111111] rounded-xl border border-amber-500/20 space-y-4">
                            
                            <p class="text-[10px] font-black text-amber-400 uppercase tracking-wider flex items-center gap-2">
                                <i class="fas fa-info-circle"></i> Instrucciones de Pago
                            </p>
                            
                            @if($paymentSettings['manual_payment_bank'] ?? false)
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-wider">Banco / Transferencia</span>
                                <div class="p-3 bg-[#0a0a0a] rounded-lg text-xs font-mono text-gray-300 whitespace-pre-line border border-white/[0.04]">{{ $paymentSettings['manual_payment_bank'] }}</div>
                            </div>
                            @endif

                            @if($paymentSettings['manual_payment_binance'] ?? false)
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-wider">Binance Pay / Crypto</span>
                                <div class="p-3 bg-[#0a0a0a] rounded-lg text-xs font-mono text-gray-300 whitespace-pre-line border border-white/[0.04]">{{ $paymentSettings['manual_payment_binance'] }}</div>
                            </div>
                            @endif

                            @if($paymentSettings['manual_payment_paypal'] ?? false)
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-wider">PayPal Directo</span>
                                <div class="p-3 bg-[#0a0a0a] rounded-lg text-xs font-mono text-gray-300 whitespace-pre-line border border-white/[0.04]">{{ $paymentSettings['manual_payment_paypal'] }}</div>
                            </div>
                            @endif

                            <p class="text-xs text-gray-400 italic">
                                {{ $paymentSettings['manual_payment_instructions'] ?? 'Realiza el pago y sube tu comprobante en el siguiente paso.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 gradient-bg text-white font-black text-base rounded-xl shadow-lg shadow-[#F51B1B]/30 uppercase tracking-wider hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                    <span>Realizar Pedido</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>

        <!-- Right: Order Summary -->
        <div class="lg:col-span-2">
            <div class="lg:sticky lg:top-24 space-y-6">
                <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl p-6">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest pb-4 border-b border-white/[0.06] mb-5">Resumen de Compra</h3>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#111111] border border-white/10 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    @if(isset($item['thumbnail']) && $item['thumbnail'])
                                        <img src="{{ asset('storage/' . $item['thumbnail']) }}" class="w-full h-full object-cover">
                                    @elseif(isset($item['plan_id']))
                                        <div class="w-full h-full bg-[#F51B1B] flex items-center justify-center text-[10px] font-black text-white">VIP</div>
                                    @else
                                        <i class="fas {{ (isset($item['type']) && $item['type'] === 'theme') ? 'fa-palette' : 'fa-plug' }} text-gray-500 text-sm"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-bold text-sm truncate">{{ $item['name'] }}</h4>
                                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider">{{ $item['type'] ?? 'producto' }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-white font-black text-sm">${{ number_format($item['price'], 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Coupon Code -->
                    <div class="mb-6">
                        <form action="{{ route('checkout.apply-coupon') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Código de cupón" class="flex-1 bg-[#111111] border border-white/10 rounded-xl px-4 py-2.5 text-xs font-bold text-white placeholder-gray-600 focus:border-[#FF2121] transition-all outline-none uppercase">
                            <button type="submit" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all border border-white/10">Aplicar</button>
                        </form>
                        @if(session('coupon'))
                            <div class="mt-3 flex justify-between items-center px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                                <div class="flex-1">
                                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-wider block">Cupón: {{ session('coupon')['code'] }}</span>
                                    <span class="text-xs font-black text-emerald-400">-${{ number_format(session('coupon')['discount'], 2) }}</span>
                                </div>
                                <form action="{{ route('checkout.remove-coupon') }}" method="POST" class="ml-3">
                                    @csrf
                                    <button type="submit" class="w-7 h-7 flex items-center justify-center bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/30 rounded-lg transition-all" title="Eliminar cupón">
                                        <i class="fas fa-times text-rose-400 text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Points Redemption -->
                    @php
                        $userPoints = auth()->user()->points;
                        $conversionRate = (int) (\App\Models\Setting::where('key', 'points_conversion_rate')->value('value') ?? 100);
                        $maxDiscount = $userPoints > 0 ? floor($userPoints / $conversionRate) : 0;
                        $subtotalAfterCoupon = $total - (session('coupon')['discount'] ?? 0);
                        $maxUsableDiscount = min($maxDiscount, $subtotalAfterCoupon);
                    @endphp

                    @if($userPoints >= $conversionRate && $subtotalAfterCoupon > 0)
                        <div class="mb-6 pt-5 border-t border-white/[0.06]">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-3 flex items-center justify-between">
                                <span class="flex items-center gap-2">Canjear Puntos</span>
                                <span class="text-amber-400"><i class="fas fa-coins mr-1"></i> {{ number_format($userPoints) }}</span>
                            </h4>
                            
                            @if(session('points_redemption'))
                                <div class="flex justify-between items-center px-4 py-3 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                                    <div class="flex-1">
                                        <span class="text-[10px] font-black text-amber-400 uppercase tracking-wider block">Puntos Canjeados</span>
                                        <span class="text-xs font-black text-amber-400">-${{ number_format(session('points_redemption')['discount'], 2) }}</span>
                                    </div>
                                    <form action="{{ route('checkout.remove-points') }}" method="POST" class="ml-3">
                                        @csrf
                                        <button type="submit" class="w-7 h-7 flex items-center justify-center bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/30 rounded-lg transition-all" title="Quitar Puntos">
                                            <i class="fas fa-times text-rose-400 text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('checkout.apply-points') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="points_to_use" value="{{ $maxUsableDiscount * $conversionRate }}">
                                    <button type="submit" class="w-full px-4 py-3 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-400 rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                                        <i class="fas fa-magic"></i>
                                        Usar mis puntos (-${{ number_format($maxUsableDiscount, 2) }})
                                    </button>
                                </form>
                                <p class="mt-2 text-[10px] text-gray-500 font-bold text-center">
                                    {{ $conversionRate }} Puntos = $1.00 Descuento
                                </p>
                            @endif
                        </div>
                    @endif

                    <div class="space-y-3 pt-5 border-t border-white/[0.06]">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="text-white">${{ number_format($total, 2) }}</span>
                        </div>
                        @if($rankDiscount > 0)
                            <div class="flex justify-between items-center text-xs font-bold">
                                <span class="text-[#F51B1B] flex items-center gap-2">
                                    <i class="fas fa-shield-alt"></i> Descuento VIP ({{ auth()->user()->rank->name }})
                                </span>
                                <span class="text-[#F51B1B]">-${{ number_format($rankDiscount, 2) }}</span>
                            </div>
                        @endif
                        @if(session('coupon'))
                            <div class="flex justify-between items-center text-xs font-bold">
                                <span class="text-rose-400">Descuento Cupón</span>
                                <span class="text-rose-400">-${{ number_format(session('coupon')['discount'], 2) }}</span>
                            </div>
                        @endif
                        @if(session('points_redemption'))
                            <div class="flex justify-between items-center text-xs font-bold">
                                <span class="text-amber-400">Descuento Puntos</span>
                                <span class="text-amber-400">-${{ number_format(session('points_redemption')['discount'], 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="text-gray-500">Envío</span>
                            <span class="text-emerald-400">Gratis</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-white/[0.06]">
                            <span class="text-base font-black text-white">Total</span>
                            <span class="text-3xl font-black text-[#FF2121]">
                                @php
                                    $finalTotal = $total - $rankDiscount - (session('coupon')['discount'] ?? 0) - (session('points_redemption')['discount'] ?? 0);
                                @endphp
                                ${{ number_format(max(0, $finalTotal), 2) }}
                            </span>
                        </div>
                        
                        @if(isset($pointsToEarn) && $pointsToEarn > 0)
                            <div class="mt-3 pt-3 border-t border-white/[0.06] flex justify-between items-center">
                                <span class="text-[10px] font-black text-amber-500 uppercase tracking-wider flex items-center gap-1">
                                    <i class="fas fa-gift"></i> Ganarás
                                </span>
                                <span class="text-xs font-black text-amber-400 bg-amber-500/10 px-2.5 py-1 rounded-lg border border-amber-500/20">
                                    +{{ number_format($pointsToEarn) }} Puntos
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Promo / Guarantee -->
                <div class="bg-gradient-to-br from-[#FF2121]/10 to-[#F51B1B]/10 border border-[#FF2121]/20 rounded-2xl p-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-[#FF2121]/20 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-shield-check text-[#FF2121] text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-white mb-1">Compra 100% segura</h4>
                            <p class="text-xs text-gray-400 leading-relaxed">Actualizaciones incluidas y soporte técnico para todos tus productos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection