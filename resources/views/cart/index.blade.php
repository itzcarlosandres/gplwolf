@extends('layouts.frontend')

@section('title', 'Tu Carrito - WP Marketplace')

@section('content')
    <main class="py-20 max-w-7xl mx-auto px-6">
        <h1 class="text-4xl font-black text-white mb-12 tracking-tight flex items-center gap-4">
            <i class="fas fa-shopping-cart text-[#FF2121]"></i> Tu Carrito
        </h1>

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
                <!-- Columna Izquierda: Oferta VIP Membresía -->
                <div class="lg:col-span-1 order-2 lg:order-1">
                    @php
                        $bestPlan = \App\Models\MembershipPlan::orderBy('price', 'desc')->first();
                    @endphp
                    @if($bestPlan)
                        @php
                            $planPrice = $bestPlan->price;
                            $planDiscounted = round($planPrice * 0.90, 2);
                            $isPlanInCart = isset($cart['plan_' . $bestPlan->id]);
                        @endphp
                        <div class="bg-gradient-to-br from-[#1c0808] via-[#121212] to-[#0a0a0a] p-6 rounded-[32px] border border-[#FF2121]/30 shadow-2xl relative overflow-hidden group">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#FF2121]/15 blur-2xl rounded-full pointer-events-none"></div>
                            <div class="absolute -bottom-10 -left-10 w-28 h-28 bg-amber-500/10 blur-2xl rounded-full pointer-events-none"></div>

                            <div class="relative text-center">
                                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white text-2xl shadow-xl shadow-amber-500/30 rotate-3 group-hover:rotate-6 transition-transform">
                                    <i class="fas fa-crown"></i>
                                </div>

                                <div class="flex items-center justify-center gap-1.5 mb-2 flex-wrap">
                                    <span class="px-2.5 py-0.5 bg-amber-500/20 border border-amber-500/40 text-amber-300 text-[9px] font-black uppercase tracking-widest rounded-full">
                                        Pase VIP
                                    </span>
                                    <span class="px-2.5 py-0.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-[#FF2121]/40 border border-red-400/40">
                                        10% OFF
                                    </span>
                                </div>

                                <h4 class="text-base font-black text-white tracking-tight">
                                    ¿Descargas Ilimitadas?
                                </h4>
                                <p class="text-xs text-gray-400 font-medium mt-1 leading-relaxed">
                                    Consigue acceso instantáneo a toda la librería premium con el <span class="font-extrabold text-sm text-shimmer-white tracking-wide">{{ \Illuminate\Support\Str::startsWith($bestPlan->name, 'Plan') ? $bestPlan->name : 'Plan ' . $bestPlan->name }}</span>.
                                </p>

                                <div class="my-5 pt-4 border-t border-white/10 flex items-center justify-center gap-3">
                                    <span class="text-xs text-gray-500 line-through decoration-rose-500 font-mono font-bold">${{ number_format($planPrice, 2) }}</span>
                                    <span class="text-2xl font-black text-amber-400 font-mono tracking-tight">${{ number_format($planDiscounted, 2) }}<span class="text-xs font-normal text-gray-400">/mes</span></span>
                                </div>

                                @if(!$isPlanInCart)
                                    <form action="{{ route('membership.add', $bestPlan) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="discount10" value="1">
                                        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-xl shadow-amber-500/20 hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                                            <i class="fas fa-crown text-xs"></i>
                                            Añadir Pase (-10%)
                                        </button>
                                    </form>
                                @else
                                    <span class="w-full py-3 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-black rounded-xl flex items-center justify-center gap-2">
                                        <i class="fas fa-check-circle"></i> En Carrito
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Columna Central: Lista de Ítems + Ofertas Rápidas -->
                <div class="lg:col-span-2 space-y-6 order-1 lg:order-2">
                    @foreach($cart as $id => $item)
                        <div class="glass p-6 rounded-[32px] border-white/5 flex items-center gap-6 group hover:bg-white/[0.05] transition-all">
                            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gray-900 border border-white/10 flex-shrink-0">
                                @if($item['thumbnail'])
                                    <img src="{{ asset('storage/' . $item['thumbnail']) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full gradient-bg flex items-center justify-center text-3xl">
                                        @if($item['type'] === 'theme') 🎨 @else ⚡ @endif
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-white group-hover:text-[#FF2121] transition-colors">{{ $item['name'] }}</h3>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-gray-500 hover:text-rose-500 transition-colors p-2"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                                <div class="flex items-center gap-4 text-sm font-bold uppercase tracking-widest">
                                    <span class="text-[#FF2121]">{{ $item['type'] }}</span>
                                    <span class="text-gray-600 font-mono text-xs">Cant: {{ $item['quantity'] }}</span>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-2xl font-black text-white font-mono">${{ number_format($item['price'], 2) }}</div>
                            </div>
                        </div>
                    @endforeach

                    @php
                        $cartProductIds = array_keys($cart);
                        $quickOffers = \App\Models\Product::whereNotIn('id', $cartProductIds)
                            ->where('price', '>', 0)
                            ->inRandomOrder()
                            ->take(2)
                            ->get();
                    @endphp

                    @if($quickOffers->count() > 0)
                        <div class="mt-8 bg-gradient-to-br from-[#121212] to-[#1c0808] p-6 rounded-[32px] border border-[#FF2121]/30 shadow-2xl shadow-[#FF2121]/10 relative overflow-hidden">
                            <div class="absolute -top-12 -right-12 w-36 h-36 bg-[#FF2121]/10 blur-2xl rounded-full pointer-events-none"></div>

                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-[#FF2121]/20 border border-[#FF2121]/40 flex items-center justify-center text-[#FF2121] shadow-lg shadow-[#FF2121]/20">
                                        <i class="fas fa-bolt text-base animate-pulse"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm md:text-base font-black text-white uppercase tracking-wider flex items-center gap-2">
                                            Añade un Complemento 
                                            <span class="px-2 py-0.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] text-white text-[9px] font-black rounded-md uppercase tracking-wider shadow-md shadow-[#FF2121]/40 border border-red-400/40">
                                                10% OFF EXTRA
                                            </span>
                                        </h3>
                                        <p class="text-xs text-gray-400 font-medium">Aprovecha este descuento exclusivo antes de finalizar tu pedido.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3.5">
                                @foreach($quickOffers as $offerProduct)
                                    @php
                                        $basePrice = ($offerProduct->sale_price && $offerProduct->sale_price < $offerProduct->price) ? $offerProduct->sale_price : $offerProduct->price;
                                        $discountedPrice = round($basePrice * 0.90, 2);
                                    @endphp
                                    <div class="bg-black/50 p-4 rounded-2xl border border-white/10 hover:border-[#FF2121]/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all duration-300 group">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0 relative">
                                                @if($offerProduct->thumbnail)
                                                    <img src="{{ asset('storage/' . $offerProduct->thumbnail) }}" alt="{{ $offerProduct->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 flex items-center justify-center text-white/50">
                                                        <i class="fas {{ $offerProduct->type === 'theme' ? 'fa-palette' : 'fa-plug' }}"></i>
                                                    </div>
                                                @endif
                                                <span class="absolute top-0.5 right-0.5 text-[8px] font-black text-white bg-[#FF2121] px-1 rounded-sm leading-none">-10%</span>
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="text-sm font-bold text-white group-hover:text-[#FF2121] transition-colors truncate">{{ $offerProduct->name }}</h4>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-[9px] font-black uppercase text-gray-300 bg-white/5 px-2 py-0.5 rounded border border-white/10">{{ $offerProduct->type }}</span>
                                                    <span class="text-xs text-gray-500 line-through decoration-rose-500 font-mono font-bold">${{ number_format($basePrice, 2) }}</span>
                                                    <span class="text-xs font-black text-emerald-400 font-mono">${{ number_format($discountedPrice, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('cart.add', $offerProduct) }}" method="POST" class="shrink-0">
                                            @csrf
                                            <input type="hidden" name="discount10" value="1">
                                            <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] hover:opacity-90 text-white font-black text-xs rounded-xl transition-all shadow-lg shadow-[#FF2121]/30 hover:scale-105 active:scale-95 flex items-center justify-center gap-1.5 whitespace-nowrap uppercase tracking-wider">
                                                <i class="fas fa-plus text-[10px]"></i>
                                                Añadir (-10%)
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Columna Derecha: Resumen de Orden -->
                <div class="lg:col-span-1 space-y-8 order-3">
                    <div class="glass p-8 rounded-[40px] border-[#FF2121]/20 shadow-2xl shadow-[#F51B1B]/10 relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#FF2121]/10 blur-[50px] rounded-full"></div>
                        
                        <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] pb-6 border-b border-white/5 mb-6">Resumen de Orden</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-gray-500 uppercase">Subtotal</span>
                                <span class="text-white font-mono font-black">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-gray-500 uppercase">Impuestos</span>
                                <span class="text-white font-mono font-black">$0.00</span>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-white/10 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-black text-white uppercase tracking-tighter">Total</span>
                                <span class="text-3xl font-black text-[#FF2121] font-mono tracking-tighter">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full py-5 gradient-bg text-white font-black text-center rounded-2xl shadow-xl shadow-[#F51B1B]/30 hover:opacity-90 transition-all uppercase tracking-[0.2em] text-xs">
                            Proceder al Pago <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <div class="bg-[#F51B1B]/10 p-6 rounded-3xl border border-[#FF2121]/10 text-center">
                        <div class="text-[#FF2121] mb-3"><i class="fas fa-shield-halved text-2xl"></i></div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed">
                            Pago Seguro & <br> Actualizaciones Garantizadas
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="glass p-20 rounded-[40px] text-center border-dashed border-2 border-white/5">
                <h2 class="text-3xl font-black text-white mb-4">Tu carrito está vacío</h2>
                <p class="text-gray-500 mb-10 max-w-sm mx-auto font-medium">Parece que aún no has añadido nada a tu colección. Explora nuestros recursos premium ahora.</p>
                <a href="{{ route('home') }}" class="inline-flex px-10 py-5 gradient-bg text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-xl shadow-[#F51B1B]/30">
                    Ir a la Tienda
                </a>
            </div>
        @endif
    </main>
@endsection