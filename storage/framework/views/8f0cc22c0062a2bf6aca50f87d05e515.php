<form action="<?php echo e(route('admin.settings.products.update')); ?>" method="POST" class="space-y-6">
    <?php echo csrf_field(); ?>

    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight">Configuración de Productos</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Personaliza cómo se muestran los productos en tu marketplace</p>
        </div>
        <button type="submit" class="px-6 py-3 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center gap-2">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </div>

    <!-- Página de Productos -->
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                <i class="fas fa-th-large text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-white">Página de Productos</h3>
                <p class="text-xs text-gray-500 font-medium">Apariencia del catálogo principal</p>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Título de la Sección</label>
                <input type="text" name="products_section_title" value="<?php echo e($settings['products_section_title'] ?? 'Lo más Vendido'); ?>" required
                    class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
            </div>

            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Columnas (Grid)</label>
                <div class="grid grid-cols-4 gap-2">
                    <?php $__currentLoopData = [3,4,5,6]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cols): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="products_grid_columns" value="<?php echo e($cols); ?>" class="peer sr-only" <?php echo e(($settings['products_grid_columns'] ?? 6) == $cols ? 'checked' : ''); ?>>
                        <div class="text-center py-3 bg-[#080808] border border-white/[0.08] rounded-xl text-gray-500 text-xs font-black uppercase tracking-wider peer-checked:border-[#FF2121]/50 peer-checked:bg-[#FF2121]/10 peer-checked:text-[#FF2121] transition-all hover:border-white/20">
                            <?php echo e($cols); ?>

                        </div>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Productos por Página</label>
                <div class="relative">
                    <input type="number" name="products_per_page" value="<?php echo e($settings['products_per_page'] ?? 24); ?>" min="6" max="100" step="6" required
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-600 uppercase">prod</span>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="px-6 pb-6">
            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Vista Previa</label>
            <div class="bg-[#080808] border border-white/[0.06] rounded-xl p-6">
                <div class="flex justify-center items-end gap-2 h-24">
                    <?php for($i=0; $i<6; $i++): ?>
                        <div class="w-12 bg-gradient-to-t from-[#FF2121]/30 to-[#F51B1B]/5 rounded-t-md border border-[#FF2121]/20 <?php echo e($i >= (($settings['products_grid_columns'] ?? 6)) ? 'opacity-30 hidden md:block' : ''); ?>" style="height: <?php echo e(40 + ($i % 3) * 25); ?>px"></div>
                    <?php endfor; ?>
                </div>
                <p class="text-center text-[10px] text-gray-600 mt-4 uppercase tracking-wider font-bold"><?php echo e($settings['products_grid_columns'] ?? 6); ?> columnas visibles</p>
            </div>
        </div>
    </div>

    <!-- Productos en Home -->
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                <i class="fas fa-home text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-white">Productos en Home</h3>
                <p class="text-xs text-gray-500 font-medium">Configura la sección destacada del inicio</p>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Título y Subtítulo en Home -->
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Título en Home</label>
                <input type="text" name="home_featured_title" value="<?php echo e($settings['home_featured_title'] ?? 'Lo más Vendido'); ?>" required
                    class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700" placeholder="Ej: Lo más Vendido">
            </div>

            <div class="lg:col-span-2">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Subtítulo / Descripción en Home</label>
                <input type="text" name="home_featured_description" value="<?php echo e($settings['home_featured_description'] ?? 'Explora nuestras últimas novedades premium para WordPress.'); ?>" required
                    class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700" placeholder="Ej: Explora nuestras últimas novedades...">
            </div>

            <!-- Estilo -->
            <div class="lg:col-span-3">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Estilo de Visualización</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <?php
                        $styles = [
                            'grid' => ['icon' => 'fa-th', 'name' => 'Grid Compacto', 'desc' => 'Recomendado'],
                            'list' => ['icon' => 'fa-list', 'name' => 'Lista Horizontal', 'desc' => 'Detallado'],
                            'bento' => ['icon' => 'fa-th-large', 'name' => 'Bento Grid', 'desc' => 'Premium'],
                        ];
                    ?>
                    <?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="home_products_style" value="<?php echo e($key); ?>" class="peer sr-only" <?php echo e(($settings['home_products_style'] ?? 'grid') == $key ? 'checked' : ''); ?>>
                        <div class="relative p-5 bg-[#080808] border border-white/[0.08] rounded-xl peer-checked:border-[#FF2121]/50 peer-checked:bg-[#FF2121]/10 transition-all hover:border-white/20 h-full">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 peer-checked:text-[#FF2121]">
                                    <i class="fas <?php echo e($style['icon']); ?>"></i>
                                </div>
                                <div class="w-4 h-4 rounded-full border border-white/20 peer-checked:border-[#FF2121] peer-checked:bg-[#FF2121] flex items-center justify-center">
                                    <i class="fas fa-check text-[8px] text-white opacity-0 peer-checked:opacity-100"></i>
                                </div>
                            </div>
                            <h4 class="text-white font-bold text-sm"><?php echo e($style['name']); ?></h4>
                            <p class="text-[10px] text-gray-500 mt-1 font-medium uppercase tracking-wider"><?php echo e($style['desc']); ?></p>
                        </div>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Columnas Grid -->
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Columnas Grid</label>
                <div class="relative">
                    <select name="home_grid_columns" class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold appearance-none">
                        <option value="3" <?php echo e(($settings['home_grid_columns'] ?? 4) == 3 ? 'selected' : ''); ?>>3 Columnas</option>
                        <option value="4" <?php echo e(($settings['home_grid_columns'] ?? 4) == 4 ? 'selected' : ''); ?>>4 Columnas</option>
                        <option value="5" <?php echo e(($settings['home_grid_columns'] ?? 4) == 5 ? 'selected' : ''); ?>>5 Columnas</option>
                        <option value="6" <?php echo e(($settings['home_grid_columns'] ?? 4) == 6 ? 'selected' : ''); ?>>6 Columnas</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Cantidad -->
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Cantidad en Home</label>
                <div class="relative">
                    <input type="number" name="home_products_count" value="<?php echo e($settings['home_products_count'] ?? 6); ?>" min="1" max="100" required
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-600 uppercase">prod</span>
                </div>
            </div>

            <!-- Info -->
            <div class="flex items-center gap-3 p-4 bg-[#FF2121]/5 border border-[#FF2121]/10 rounded-xl">
                <i class="fas fa-info-circle text-[#FF2121]"></i>
                <p class="text-xs text-gray-400 leading-relaxed font-medium">Define cuántos productos mostrar en la sección de inicio. Elige el estilo que mejor se adapte a tu marca.</p>
            </div>
        </div>
    </div>

    <!-- Footer Save -->
    <div class="flex items-center justify-end pt-2">
        <button type="submit" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center gap-3">
            <i class="fas fa-save"></i> Guardar Configuración
        </button>
    </div>
</form><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/admin/settings/tabs/products.blade.php ENDPATH**/ ?>