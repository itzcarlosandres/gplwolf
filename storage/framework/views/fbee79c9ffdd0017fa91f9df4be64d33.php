<form action="<?php echo e(route('admin.settings.points.update')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <div class="space-y-6">
        <!-- Main Config Card -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <i class="fas fa-coins text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Sistema de Puntos</h3>
                    <p class="text-xs text-gray-500 font-medium">Configura cómo los usuarios ganan y gastan puntos</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Enable Switch -->
                <div class="bg-[#080808] rounded-xl border border-white/[0.08] p-4 flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-black text-white block mb-1">Habilitar Sistema de Puntos</h4>
                        <p class="text-xs text-gray-500 font-medium">Permite a los usuarios ganar y gastar puntos.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="points_enabled" class="sr-only peer" <?php echo e(($settings['points_enabled'] ?? 0) ? 'checked' : ''); ?>>
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    </label>
                </div>

                <!-- Inputs Split -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Puntos por Dólar (Ganancia)</label>
                        <div class="relative">
                            <input type="number" name="points_per_currency" value="<?php echo e($settings['points_per_currency'] ?? 1); ?>" min="0" required
                                class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 pl-10 text-white text-sm focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10 transition-all font-bold placeholder-gray-700">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                <i class="fas fa-plus text-xs"></i>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-2 text-right font-medium">Ej: Gasta $1 = Gana <?php echo e($settings['points_per_currency'] ?? 1); ?> Pt</p>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Tasa de Conversión (Gasto)</label>
                        <div class="relative">
                            <input type="number" name="points_conversion_rate" value="<?php echo e($settings['points_conversion_rate'] ?? 100); ?>" min="1" required
                                class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 pl-10 text-white text-sm focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10 transition-all font-bold placeholder-gray-700">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                <i class="fas fa-exchange-alt text-xs"></i>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-2 text-right font-medium">Ej: <?php echo e($settings['points_conversion_rate'] ?? 100); ?> Pts = $1 Descuento</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculator Preview -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-400">
                    <i class="fas fa-calculator text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Simulación del Sistema</h3>
                    <p class="text-xs text-gray-500 font-medium">Previsualiza el cálculo de puntos</p>
                </div>
            </div>

            <div class="p-8 relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 opacity-5 text-amber-500 text-9xl">
                    <i class="fas fa-calculator"></i>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto relative z-10">
                    <div class="bg-[#080808] p-6 rounded-xl border border-white/[0.06] text-center">
                        <div class="text-xs text-gray-400 font-medium mb-2">Si compran un producto de <strong class="text-white">$50.00</strong></div>
                        <div class="text-2xl font-black text-amber-400 flex items-center justify-center gap-2">
                            +<?php echo e(($settings['points_per_currency'] ?? 1) * 50); ?>

                            <span class="text-xs uppercase bg-amber-500/10 border border-amber-500/20 text-amber-400 px-2 py-1 rounded-lg font-black tracking-wider">Puntos</span>
                        </div>
                    </div>

                    <div class="bg-[#080808] p-6 rounded-xl border border-white/[0.06] text-center">
                        <div class="text-xs text-gray-400 font-medium mb-2">Para tener <strong class="text-white">$1.00</strong> de descuento</div>
                        <div class="text-2xl font-black text-white flex items-center justify-center gap-2">
                            <?php echo e($settings['points_conversion_rate'] ?? 100); ?>

                            <span class="text-xs uppercase bg-white/5 border border-white/10 text-gray-300 px-2 py-1 rounded-lg font-black tracking-wider">Puntos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center gap-3">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </div>
</form><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/admin/settings/tabs/points.blade.php ENDPATH**/ ?>