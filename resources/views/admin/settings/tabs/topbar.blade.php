<form action="{{ route('admin.settings.topbar.update') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column: Settings -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-400">
                    <i class="fas fa-bullhorn text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Configuración Top Bar</h3>
                    <p class="text-xs text-gray-500 font-medium">Barra de anuncios superior de tu sitio</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Enable Switch -->
                <div class="bg-[#080808] rounded-xl border border-white/[0.08] p-4 flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-black text-white mb-1">Mostrar Top Bar</h4>
                        <p class="text-xs text-gray-500 font-medium">Activa la barra de anuncios superior.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="topbar_enabled" class="sr-only peer" {{ ($settings['topbar_enabled'] ?? 1) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-pink-500"></div>
                    </label>
                </div>

                <!-- Top Bar Text -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Mensaje del Top Bar</label>
                    <input type="text" name="topbar_text" value="{{ old('topbar_text', $settings['topbar_text'] ?? '🎉 Oferta especial: 50% de descuento en todos los planes anuales') }}" required
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/10 transition-all font-bold placeholder-gray-700">
                    <p class="text-[10px] text-gray-500 mt-2 font-medium">
                        <i class="fas fa-info-circle mr-1"></i>
                        Puedes usar emojis para destacar el mensaje.
                    </p>
                </div>

                <!-- Top Bar Link -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">URL del Enlace (Opcional)</label>
                    <div class="relative">
                        <input type="text" name="topbar_link" value="{{ old('topbar_link', $settings['topbar_link'] ?? '') }}" placeholder="https://ejemplo.com/promo"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 pl-10 text-white text-sm focus:outline-none focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/10 transition-all font-bold placeholder-gray-700">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-link text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Preview -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center justify-center text-[#F51B1B]">
                    <i class="fas fa-eye text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Vista Previa</h3>
                    <p class="text-xs text-gray-500 font-medium">Así se verá la barra superior</p>
                </div>
            </div>

            <div class="p-8 flex-1 relative overflow-hidden flex flex-col items-center justify-center">
                <div class="absolute -right-5 -bottom-5 opacity-5 text-pink-500 text-8xl">
                    <i class="fas fa-eye"></i>
                </div>

                <!-- Browser Mockup -->
                <div class="w-full max-w-sm bg-[#080808] rounded-xl border border-white/[0.06] overflow-hidden shadow-2xl relative z-10">
                    <!-- Top Bar Preview -->
                    <div class="bg-gradient-to-r from-pink-600 to-[#F51B1B] px-4 py-2 flex items-center justify-center text-[10px] font-black text-white text-center leading-tight">
                        {{ $settings['topbar_text'] ?? '🎉 Oferta especial: 50% de descuento.' }}
                    </div>

                    <!-- Navbar Mockup -->
                    <div class="bg-[#0a0a0a] border-b border-white/[0.06] p-3 flex justify-between items-center">
                        <div class="w-20 h-4 bg-white/10 rounded"></div>
                        <div class="flex gap-2">
                            <div class="w-12 h-3 bg-white/5 rounded"></div>
                            <div class="w-12 h-3 bg-white/5 rounded"></div>
                        </div>
                    </div>

                    <!-- Content Mockup -->
                    <div class="p-4 space-y-3 opacity-50">
                        <div class="w-3/4 h-6 bg-white/10 rounded mb-4"></div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="h-20 bg-white/5 rounded"></div>
                            <div class="h-20 bg-white/5 rounded"></div>
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-gray-500 mt-6 text-center max-w-xs font-medium relative z-10">
                    Así se verá la barra superior en tu sitio web. El color del gradiente se adapta automáticamente a tu tema.
                </p>
            </div>
        </div>
    </div>
</form>