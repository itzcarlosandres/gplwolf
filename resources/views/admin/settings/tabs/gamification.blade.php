<form action="{{ route('admin.settings.gamification.update') }}" method="POST">
    @csrf

    @php
        $rewards = json_decode($settings['gamification_rewards'] ?? '{"active":true,"rewards":{"1":10,"2":20,"3":30,"4":40,"5":50,"6":75,"7":150}}', true);
    @endphp

    <div class="space-y-6">
        <!-- Daily Rewards Card -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400">
                    <i class="fas fa-trophy text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Recompensas Diarias</h3>
                    <p class="text-xs text-gray-500 font-medium">Configura los puntos por día consecutivo</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Enable/Disable Switch -->
                <div class="bg-[#080808] rounded-xl border border-white/[0.08] p-4 flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-black text-white block mb-1">Estado del Sistema</h4>
                        <p class="text-xs text-gray-500 font-medium">Activa o desactiva las recompensas diarias globalmente.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" class="sr-only peer" {{ ($rewards['active'] ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500"></div>
                    </label>
                </div>

                <!-- Rewards Matrix -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em]">Matriz de Premios (7 Días)</label>
                        <span class="px-3 py-1 rounded-lg bg-white/5 border border-white/[0.08] text-[10px] font-black text-gray-400 uppercase tracking-wider">
                            Ciclo automático
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                        @for($i = 1; $i <= 6; $i++)
                        <div class="bg-[#080808] p-4 rounded-xl border border-white/[0.08] text-center relative group hover:border-white/20 transition-all hover:-translate-y-1">
                            <span class="text-[10px] font-black text-gray-500 uppercase block mb-3 tracking-wider">Día {{ $i }}</span>
                            <div class="relative">
                                <input type="number" name="rewards[{{ $i }}]" value="{{ $rewards['rewards'][$i] ?? ($i * 10) }}"
                                    class="w-full bg-transparent text-center text-white font-black text-2xl border-none focus:ring-0 p-0" placeholder="0">
                                <span class="text-[9px] text-gray-400 font-black block mt-1 uppercase tracking-wider">Puntos</span>
                            </div>
                        </div>
                        @endfor

                        <!-- Day 7 (Chest) -->
                        <div class="bg-gradient-to-br from-red-900/40 to-[#F51B1B]/40 p-4 rounded-xl border border-red-500/30 text-center relative group hover:-translate-y-1 transition-transform">
                            <span class="text-[10px] font-black text-red-400 uppercase block mb-3 tracking-wider">🏆 Cofre</span>
                            <div class="relative">
                                <input type="number" name="rewards[7]" value="{{ $rewards['rewards'][7] ?? 150 }}"
                                    class="w-full bg-transparent text-center text-white font-black text-3xl border-none focus:ring-0 p-0 drop-shadow-[0_2px_10px_rgba(239,68,68,0.5)]" placeholder="0">
                                <span class="text-[9px] text-red-300 font-black block mt-1 uppercase tracking-wider">Bonus</span>
                            </div>
                            <div class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-yellow-400 rounded-full flex items-center justify-center text-[10px] text-black font-bold shadow-lg animate-bounce">!</div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-[#FF2121]/5 border border-[#FF2121]/10 rounded-xl p-4 flex items-start gap-3">
                    <i class="fas fa-info-circle text-[#FF2121] mt-0.5"></i>
                    <div class="text-xs text-gray-400 leading-relaxed font-medium">
                        <strong class="text-white">¿Cómo funciona?</strong> El usuario gana puntos por cada día consecutivo que entra al sitio. Si entra 7 días seguidos, recibe el premio "Cofre" y el contador se reinicia al Día 1.
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="p-6 border-t border-white/[0.06] flex justify-end">
                <button type="submit" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center gap-3">
                    <i class="fas fa-save"></i>
                    Guardar Configuración
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Ranks Configuration -->
<form action="{{ route('admin.settings.ranks.update') }}" method="POST" class="mt-6">
    @csrf

    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center justify-center text-[#F51B1B]">
                <i class="fas fa-shield-alt text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-white">Niveles de Membresía (Ranks)</h3>
                <p class="text-xs text-gray-500 font-medium">Configura descuentos automáticos por rango</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Ranks Table Header -->
            <div class="grid grid-cols-12 gap-4 px-4 py-2 text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] border-b border-white/[0.06] pb-2">
                <div class="col-span-3">Nombre del Rango</div>
                <div class="col-span-3">Puntos Min.</div>
                <div class="col-span-3">Descuento (%)</div>
                <div class="col-span-3">Color UI</div>
            </div>

            <!-- Ranks List -->
            <div class="space-y-3">
                @foreach($ranks as $index => $rank)
                <div class="grid grid-cols-12 gap-4 items-center bg-[#080808] hover:bg-white/[0.02] p-4 rounded-xl border border-white/[0.08] transition-colors group">
                    <input type="hidden" name="ranks[{{ $index }}][id]" value="{{ $rank->id }}">

                    <!-- Name -->
                    <div class="col-span-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-lg" style="background-color: {{ $rank->color }}20; color: {{ $rank->color }}">
                                <i class="{{ $rank->icon ?? 'fas fa-shield-alt' }}"></i>
                            </div>
                            <input type="text" name="ranks[{{ $index }}][name]" value="{{ $rank->name }}"
                                class="bg-transparent border-0 border-b border-transparent focus:border-white text-white font-bold w-full focus:ring-0 p-0 transition-all placeholder-gray-600 text-sm">
                        </div>
                    </div>

                    <!-- Points -->
                    <div class="col-span-3 relative">
                        <input type="number" name="ranks[{{ $index }}][min_points]" value="{{ $rank->min_points }}"
                            class="bg-[#0a0a0a] border border-white/[0.08] rounded-xl text-white font-mono text-sm w-full p-2.5 focus:ring-2 focus:ring-[#F51B1B]/10 focus:border-[#F51B1B]/50 transition-all font-bold">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-500 font-black pointer-events-none uppercase">PTS</span>
                    </div>

                    <!-- Discount -->
                    <div class="col-span-3 relative">
                        <input type="number" step="0.01" name="ranks[{{ $index }}][discount_percentage]" value="{{ $rank->discount_percentage }}"
                            class="bg-[#0a0a0a] border border-white/[0.08] rounded-xl text-emerald-400 font-mono text-sm w-full p-2.5 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500/50 transition-all font-bold">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-emerald-500/70 font-black pointer-events-none uppercase">% OFF</span>
                    </div>

                    <!-- Color -->
                    <div class="col-span-3 flex items-center gap-2">
                        <input type="color" name="ranks[{{ $index }}][color]" value="{{ $rank->color }}"
                            class="h-10 w-full bg-transparent border border-white/[0.08] rounded-xl cursor-pointer p-1">
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Info Box -->
            <div class="bg-[#F51B1B]/5 border border-[#F51B1B]/10 rounded-xl p-4 flex items-start gap-3">
                <i class="fas fa-info-circle text-[#F51B1B] mt-0.5"></i>
                <div class="text-xs text-gray-400 leading-relaxed font-medium">
                    <strong class="text-white">Nota:</strong> Los rangos se asignan automáticamente cuando el usuario alcanza los puntos mínimos. El descuento se aplica automáticamente en el checkout.
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="p-6 border-t border-white/[0.06] flex justify-end">
            <button type="submit" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center gap-3">
                <i class="fas fa-save"></i>
                Actualizar Rangos
            </button>
        </div>
    </div>
</form>