<form action="{{ route('admin.settings.plugin.update') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column: Settings -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                    <i class="fas fa-plug text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Conexión WordPress</h3>
                    <p class="text-xs text-gray-500 font-medium">Gestiona el plugin oficial de tu marketplace</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Enable Plugin -->
                <div class="bg-[#080808] rounded-xl border border-white/[0.08] p-4 flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-black text-white mb-1">Habilitar Plugin</h4>
                        <p class="text-xs text-gray-500 font-medium">Permite conexión desde sitios externos.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="plugin_enabled" class="sr-only peer" {{ ($settings['plugin_enabled'] ?? 0) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FF2121]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#FF2121]"></div>
                    </label>
                </div>

                <!-- Show in Menu -->
                <div class="bg-[#080808] rounded-xl border border-white/[0.08] p-4 flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-black text-white mb-1">Mostrar en Menú</h4>
                        <p class="text-xs text-gray-500 font-medium">Visible en el panel de usuario.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="plugin_show_menu" class="sr-only peer" {{ ($settings['plugin_show_menu'] ?? 0) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FF2121]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#FF2121]"></div>
                    </label>
                </div>

                <!-- Site Limit -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Límite de Sitios por Usuario</label>
                    <div class="relative">
                        <input type="number" name="plugin_site_limit" value="{{ $settings['plugin_site_limit'] ?? 5 }}" min="1" max="100" required
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 pl-10 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-server text-xs"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-2 font-medium">Límite predeterminado global.</p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Download / Info -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center justify-center text-[#F51B1B]">
                    <i class="fas fa-download text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Plugin Oficial</h3>
                    <p class="text-xs text-gray-500 font-medium">Descarga para conectar sitios WordPress</p>
                </div>
            </div>

            <div class="p-8 flex-1 relative overflow-hidden flex flex-col justify-center items-center text-center">
                <div class="absolute -right-5 -bottom-5 opacity-5 text-[#FF2121] text-8xl">
                    <i class="fas fa-download"></i>
                </div>

                <div class="relative z-10 space-y-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-tr from-[#FF2121] to-[#F51B1B] shadow-2xl shadow-[#FF2121]/20 mb-2">
                        <i class="fab fa-wordpress text-4xl text-white"></i>
                    </div>

                    <div>
                        <h4 class="text-xl font-black text-white mb-2">Marketplace Connect</h4>
                        <p class="text-sm text-gray-400 max-w-xs mx-auto font-medium">
                            Descarga el plugin para conectar sitios WordPress con tu marketplace.
                        </p>
                    </div>

                    <div class="bg-[#080808] rounded-xl p-3 border border-white/[0.08] flex items-center gap-3 max-w-xs mx-auto">
                        <div class="flex-1 text-xs font-mono text-[#FF2121] truncate text-left font-bold">
                            marketplace-connect.zip
                        </div>
                        <a href="{{ url('marketplace-connect.zip') }}" class="p-2 bg-[#FF2121] hover:bg-[#FF2121] rounded-lg text-white transition-colors">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>