@extends('layouts.admin')

@section('title', 'Ajustes de Pagos Manuales')

@section('content')
<div class="max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white tracking-tight">Configuración de Pagos</h1>
        <p class="text-gray-400 mt-1">Gestiona los métodos de pago manuales y las pasarelas automáticas (PayPal, CoinPal).</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-bold flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.payments.update') }}" method="POST" class="space-y-12">
        @csrf
        
        <!-- SECCIÓN: PAGOS MANUALES -->
        <div>
            <h2 class="text-xs font-black text-[#FF2121] uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                PAGOS MANUALES
                <div class="h-px bg-white/5 flex-1"></div>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bank Details -->
                <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">
                        <div class="bg-[#FF2121]/20 p-2 rounded-lg text-[#FF2121]"><i class="fas fa-university"></i></div>
                        Transferencia Bancaria
                    </h3>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Datos del Banco</label>
                        <textarea name="manual_payment_bank" rows="4" 
                            class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all resize-none"
                            placeholder="Banco: XYZ&#10;Cuenta: 123456789&#10;Beneficiario: Juan Perez">{{ $settings['manual_payment_bank'] ?? '' }}</textarea>
                    </div>
                </div>

                <!-- Binance Details -->
                <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">
                        <div class="bg-amber-500/20 p-2 rounded-lg text-amber-500"><i class="fab fa-bitcoin"></i></div>
                        Binance Pay / Crypto
                    </h3>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Binance ID / Wallet</label>
                        <textarea name="manual_payment_binance" rows="4" 
                            class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all resize-none"
                            placeholder="Binance ID: 987654321&#10;Red: TRC20&#10;Wallet: TXXXXXXXXXXXX">{{ $settings['manual_payment_binance'] ?? '' }}</textarea>
                    </div>
                </div>

                <!-- PayPal Manual -->
                <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">
                        <div class="bg-[#F51B1B]/20 p-2 rounded-lg text-[#FF2121]"><i class="fab fa-paypal"></i></div>
                        PayPal (Manual/Amigos)
                    </h3>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Correo PayPal</label>
                        <input type="text" name="manual_payment_paypal" value="{{ $settings['manual_payment_paypal'] ?? '' }}"
                            class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all"
                            placeholder="pago@tuweb.com">
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">
                        <div class="bg-emerald-500/20 p-2 rounded-lg text-emerald-400"><i class="fas fa-info-circle"></i></div>
                        Instrucciones Generales
                    </h3>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Pasos a seguir</label>
                        <textarea name="manual_payment_instructions" rows="4" 
                            class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all resize-none"
                            placeholder="Realiza el pago y sube tu comprobante para que aprobemos tu orden.">{{ $settings['manual_payment_instructions'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: PASARELAS AUTOMÁTICAS -->
        <div>
            <h2 class="text-xs font-black text-rose-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                PASARELAS AUTOMÁTICAS (API)
                <div class="h-px bg-white/5 flex-1"></div>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- PayPal API -->
                <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">
                        <div class="bg-[#FF2121]/20 p-2 rounded-lg text-[#FF2121]"><i class="fab fa-paypal"></i></div>
                        PayPal Checkout API
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">PayPal Client ID</label>
                            <input type="text" name="paypal_client_id" value="{{ $settings['paypal_client_id'] ?? '' }}"
                                class="w-full bg-gray-950/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#FF2121]/50 outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">PayPal Secret Key</label>
                            <input type="password" name="paypal_secret" value="{{ $settings['paypal_secret'] ?? '' }}"
                                class="w-full bg-gray-950/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#FF2121]/50 outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">PayPal Mode</label>
                            <select name="paypal_mode" class="w-full bg-gray-950/50 border border-white/10 rounded-xl px-4 py-3 text-white outline-none text-xs">
                                <option value="sandbox" {{ ($settings['paypal_mode'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox (Pruebas)</option>
                                <option value="live" {{ ($settings['paypal_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live (Producción)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- CoinPal API -->
                <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-3">
                        <div class="bg-[#FF2121]/20 p-2 rounded-lg text-[#FF2121]"><i class="fas fa-coins"></i></div>
                        CoinPal (Criptomonedas)
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Merchant Number</label>
                            <input type="text" name="coinpal_merchant_no" value="{{ $settings['coinpal_merchant_no'] ?? '' }}"
                                class="w-full bg-gray-950/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#FF2121]/50 outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">CoinPal API Key</label>
                            <input type="password" name="coinpal_api_key" value="{{ $settings['coinpal_api_key'] ?? '' }}"
                                class="w-full bg-gray-950/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#FF2121]/50 outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">CoinPal Mode</label>
                            <select name="coinpal_mode" class="w-full bg-gray-950/50 border border-white/10 rounded-xl px-4 py-3 text-white outline-none text-xs">
                                <option value="sandbox" {{ ($settings['coinpal_mode'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox / Testnet</option>
                                <option value="live" {{ ($settings['coinpal_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live (Producción)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-10 border-t border-white/5">
            <button type="submit" class="bg-[#F51B1B] hover:bg-[#FF2121] text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-[#F51B1B]/20 active:scale-95">
                Guardar Configuración <i class="fas fa-save ml-2"></i>
            </button>
        </div>
    </form>
</div>
@endsection