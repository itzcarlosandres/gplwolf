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
                        <a href="{{ route('pages.plugin.download') }}" class="p-2 bg-[#FF2121] hover:bg-[#FF2121] rounded-lg text-white transition-colors">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Release Publishing & History (Full Width) -->
    <div class="space-y-6 mt-6">
        <!-- Control de Versión del Plugin -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                        <i class="fas fa-code-branch text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">Publicar Nueva Versión</h3>
                        <p class="text-xs text-gray-500 font-medium">Libera una actualización del plugin. Se guardará en el historial y reescribirá el código en el servidor.</p>
                    </div>
                </div>
                <div class="px-3 py-1.5 bg-white/5 border border-white/10 text-white text-xs font-bold rounded-lg font-mono">
                    Versión actual: v{{ $currentVersion }}
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Número de Versión</label>
                        <input type="text" name="new_version_number" placeholder="Ej: 1.0.1" value="{{ old('new_version_number') }}"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        <p class="text-[10px] text-gray-500 mt-2 font-medium">Sugerido: versión superior a la actual.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Registro de Cambios (Changelog)</label>
                        <textarea name="changelog" rows="2" placeholder="¿Qué novedades o correcciones incluye esta actualización?" 
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">{{ old('changelog') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Versiones -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400">
                    <i class="fas fa-history text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Historial de Versiones</h3>
                    <p class="text-xs text-gray-500 font-medium">Listado cronológico de actualizaciones publicadas para el plugin conector.</p>
                </div>
            </div>

            <div class="p-6">
                @if($releases->count() > 0)
                    <div class="overflow-hidden border border-white/[0.06] rounded-2xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/[0.06] bg-white/[0.02]">
                                    <th class="px-5 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Versión</th>
                                    <th class="px-5 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Changelog</th>
                                    <th class="px-5 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/[0.06]">
                                @foreach($releases as $release)
                                    <tr class="hover:bg-white/[0.01] transition-colors">
                                        <td class="px-5 py-4 font-mono text-xs font-bold text-[#FF2121]">
                                            v{{ $release->version_number }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-300 text-xs font-bold">
                                            {{ $release->changelog ?: 'Sin descripción' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-500 text-xs font-medium">
                                            {{ $release->released_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 bg-white/[0.01] border border-dashed border-white/10 rounded-2xl">
                        <i class="fas fa-info-circle text-gray-600 text-3xl mb-3"></i>
                        <p class="text-gray-400 text-sm font-bold">No hay versiones en el historial aún.</p>
                        <p class="text-gray-500 text-xs mt-1 font-medium">Se usará la versión predeterminada del código fuente.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Global Save Button (Unified) -->
        <div class="flex justify-end pt-2">
            <button type="submit" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center justify-center gap-3 border-none cursor-pointer">
                <i class="fas fa-save"></i> Guardar Cambios y Publicar Versión
            </button>
        </div>
    </div>
</form>