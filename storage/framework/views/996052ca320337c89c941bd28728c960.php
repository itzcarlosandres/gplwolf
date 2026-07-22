<form action="<?php echo e(route('admin.settings.sidebar.update')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column: Settings -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                    <i class="fas fa-columns text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Configuración del Sidebar</h3>
                    <p class="text-xs text-gray-500 font-medium">Personaliza el panel lateral de productos destacados</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Sidebar Title -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Título de la Sección</label>
                    <input type="text" name="sidebar_title" value="<?php echo e($settings['sidebar_title'] ?? 'Top Popular'); ?>" required
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                </div>

                <!-- Sidebar Type -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Tipo de Listado</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <?php
                            $types = [
                                'popular' => ['name' => 'Más Populares', 'desc' => 'Por descargas', 'icon' => 'fa-fire'],
                                'best_seller' => ['name' => 'Más Vendidos', 'desc' => 'Badge destacado', 'icon' => 'fa-trophy'],
                                'top_rated' => ['name' => 'Mejor Valorados', 'desc' => 'Trending', 'icon' => 'fa-star'],
                                'most_viewed' => ['name' => 'Más Vistos', 'desc' => 'Por visitas', 'icon' => 'fa-eye'],
                                'recent' => ['name' => 'Nuevos Lanzamientos', 'desc' => 'Recientes', 'icon' => 'fa-clock'],
                            ];
                        ?>

                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="sidebar_type" value="<?php echo e($key); ?>" class="peer sr-only" <?php echo e(($settings['sidebar_type'] ?? '') == $key ? 'checked' : ''); ?>>
                            <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-4 flex items-center gap-3 peer-checked:border-[#FF2121]/50 peer-checked:bg-[#FF2121]/10 transition-all hover:border-white/20">
                                <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 peer-checked:text-[#FF2121]">
                                    <i class="fas <?php echo e($type['icon']); ?>"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-white block"><?php echo e($type['name']); ?></span>
                                    <span class="text-[10px] text-gray-500 uppercase tracking-wider font-medium"><?php echo e($type['desc']); ?></span>
                                </div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Sidebar Limit -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Cantidad a Mostrar</label>
                    <div class="relative">
                        <input type="number" name="sidebar_limit" value="<?php echo e($settings['sidebar_limit'] ?? 5); ?>" min="1" max="10" required
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-600 uppercase">prod</span>
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
                    <p class="text-xs text-gray-500 font-medium">Ejemplo visual simplificado</p>
                </div>
            </div>

            <div class="p-8 flex-1 relative overflow-hidden flex flex-col justify-center">
                <div class="absolute -right-5 -bottom-5 opacity-5 text-[#FF2121] text-8xl">
                    <i class="fas fa-list"></i>
                </div>

                <div class="max-w-xs mx-auto space-y-6 relative z-10 w-full">
                    <h4 class="text-sm font-black text-white uppercase tracking-wider pb-4 border-b border-white/[0.06] flex items-center gap-3">
                        <div class="w-2 h-2 bg-[#FF2121] rounded-full animate-pulse"></div>
                        <?php echo e($settings['sidebar_title'] ?? 'Top Popular'); ?>

                    </h4>

                    <?php for($i = 1; $i <= 3; $i++): ?>
                    <div class="flex items-center gap-4 group opacity-75">
                        <div class="w-12 h-12 bg-[#080808] rounded-xl border border-white/[0.06] flex items-center justify-center text-lg font-black text-gray-600">
                            <?php echo e($i); ?>

                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 bg-white/10 rounded-full w-3/4"></div>
                            <div class="h-2 bg-white/5 rounded-full w-1/2"></div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</form><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/admin/settings/tabs/sidebar.blade.php ENDPATH**/ ?>