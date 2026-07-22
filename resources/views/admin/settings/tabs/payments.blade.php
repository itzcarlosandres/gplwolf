<form action="{{ route('admin.settings.payments.update') }}" method="POST">
    @csrf

    <div class="space-y-6">
        <!-- Header Card -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <i class="fas fa-wallet text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Pasarelas de Pago</h3>
                    <p class="text-xs text-gray-500 font-medium">Configura pagos manuales y gateways automáticas</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column: Manual Payments -->
            <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gray-500/10 border border-gray-500/20 flex items-center justify-center text-gray-400">
                        <i class="fas fa-hand-holding-usd text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">Pagos Manuales</h3>
                        <p class="text-xs text-gray-500 font-medium">Instrucciones para pagos fuera de línea</p>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Bank -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Transferencia Bancaria</label>
                        <textarea name="manual_payment_bank" rows="4"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500/50 focus:ring-2 focus:ring-emerald-500/10 transition-all font-bold placeholder-gray-700 resize-none">{{ $settings['manual_payment_bank'] ?? '' }}</textarea>
                    </div>

                    <!-- Binance -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Binance / Crypto Manual</label>
                        <textarea name="manual_payment_binance" rows="4"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500/50 focus:ring-2 focus:ring-emerald-500/10 transition-all font-bold placeholder-gray-700 resize-none">{{ $settings['manual_payment_binance'] ?? '' }}</textarea>
                    </div>

                    <!-- PayPal Manual -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">PayPal (Correo Manual)</label>
                        <input type="text" name="manual_payment_paypal" value="{{ $settings['manual_payment_paypal'] ?? '' }}" placeholder="pago@ejemplo.com"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500/50 focus:ring-2 focus:ring-emerald-500/10 transition-all font-bold placeholder-gray-700">
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Instrucciones al Usuario</label>
                        <textarea name="manual_payment_instructions" rows="3"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500/50 focus:ring-2 focus:ring-emerald-500/10 transition-all font-bold placeholder-gray-700 resize-none">{{ $settings['manual_payment_instructions'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Automated Gateways -->
            <div class="space-y-6">
                <!-- PayPal API -->
                <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                            <i class="fab fa-paypal text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white">PayPal Checkout</h3>
                            <p class="text-xs text-gray-500 font-medium">API de pagos con PayPal</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Client ID</label>
                            <input type="text" name="paypal_client_id" value="{{ $settings['paypal_client_id'] ?? '' }}"
                                class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Secret Key</label>
                            <input type="password" name="paypal_secret" value="{{ $settings['paypal_secret'] ?? '' }}"
                                class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Mode</label>
                            <div class="relative">
                                <select name="paypal_mode" class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold appearance-none">
                                    <option value="sandbox" {{ ($settings['paypal_mode'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                    <option value="live" {{ ($settings['paypal_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CoinPal API -->
                <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                            <i class="fas fa-coins text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white">CoinPal Crypto</h3>
                            <p class="text-xs text-gray-500 font-medium">Pagos con criptomonedas</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Merchant No.</label>
                            <input type="text" name="coinpal_merchant_no" value="{{ $settings['coinpal_merchant_no'] ?? '' }}"
                                class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">API Key</label>
                            <input type="password" name="coinpal_api_key" value="{{ $settings['coinpal_api_key'] ?? '' }}"
                                class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Mode</label>
                            <div class="relative">
                                <select name="coinpal_mode" class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold appearance-none">
                                    <option value="sandbox" {{ ($settings['coinpal_mode'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                    <option value="live" {{ ($settings['coinpal_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center justify-center gap-3">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </div>
</form>