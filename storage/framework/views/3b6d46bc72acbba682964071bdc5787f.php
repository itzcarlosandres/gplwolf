<form action="<?php echo e(route('admin.settings.hero.update')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column: Settings -->
        <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                    <i class="fas fa-heading text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Hero Section</h3>
                    <p class="text-xs text-gray-500 font-medium">Configura el estilo y contenido del hero principal</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Hero Style -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Estilo del Hero</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <?php
                            $styles = [
                                'circles' => ['name' => 'Circles', 'desc' => 'Órbita Flotante de Marcas', 'icon' => 'fa-circle-notch'],
                                'aurora' => ['name' => 'Aurora', 'desc' => 'Glass & Fluido', 'icon' => 'fa-water'],
                                'stark' => ['name' => 'Stark', 'desc' => 'Minimalista & Corporativo', 'icon' => 'fa-building'],
                                'cyber' => ['name' => 'Cyber', 'desc' => 'Bento Grid & Moderno', 'icon' => 'fa-th-large'],
                                'split' => ['name' => 'Split', 'desc' => '2 Columnas + Code Block', 'icon' => 'fa-columns'],
                            ];
                        ?>

                        <?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="hero_style" value="<?php echo e($key); ?>" class="peer sr-only" <?php echo e(($settings['hero_style'] ?? '') == $key ? 'checked' : ''); ?>>
                            <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-4 peer-checked:border-[#FF2121]/50 peer-checked:bg-[#FF2121]/10 transition-all hover:border-white/20 h-full">
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

                <!-- Hero Title -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Título Principal</label>
                    <textarea name="hero_title" rows="3" required
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold leading-tight placeholder-gray-700"><?php echo e($settings['hero_title'] ?? "Themes & Plugins\n[G]Premium WP[/G]"); ?></textarea>
                    <p class="text-[10px] text-gray-500 mt-2 font-medium">
                        <i class="fas fa-info-circle mr-1"></i>
                        Usa <code class="bg-[#080808] px-1 rounded text-white">[G]texto[/G]</code> para degradado.
                    </p>
                </div>

                <!-- Hero Description -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Descripción</label>
                    <textarea name="hero_description" rows="3" required
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold leading-relaxed placeholder-gray-700"><?php echo e($settings['hero_description'] ?? 'Impulsa tus proyectos con los mejores recursos digitales.'); ?></textarea>
                </div>

                <!-- Hero Title Size -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Tamaño del Título</label>
                    <div class="relative">
                        <select name="hero_title_size" class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold appearance-none">
                            <option value="text-xl" <?php echo e(($settings['hero_title_size'] ?? '') == 'text-xl' ? 'selected' : ''); ?>>XL (Muy Pequeño)</option>
                            <option value="text-2xl" <?php echo e(($settings['hero_title_size'] ?? '') == 'text-2xl' ? 'selected' : ''); ?>>2XL (Pequeño)</option>
                            <option value="text-3xl" <?php echo e(($settings['hero_title_size'] ?? '') == 'text-3xl' ? 'selected' : ''); ?>>3XL (Normal)</option>
                            <option value="text-4xl" <?php echo e(($settings['hero_title_size'] ?? '') == 'text-4xl' ? 'selected' : ''); ?>>4XL (Mediano)</option>
                            <option value="text-5xl" <?php echo e(($settings['hero_title_size'] ?? '') == 'text-5xl' ? 'selected' : ''); ?>>5XL (Grande)</option>
                            <option value="text-6xl" <?php echo e(($settings['hero_title_size'] ?? '') == 'text-6xl' ? 'selected' : ''); ?>>Grande (6XL)</option>
                            <option value="text-7xl" <?php echo e(($settings['hero_title_size'] ?? 'text-8xl') == 'text-7xl' ? 'selected' : ''); ?>>Extra Grande (7XL)</option>
                            <option value="text-8xl" <?php echo e(($settings['hero_title_size'] ?? 'text-8xl') == 'text-8xl' ? 'selected' : ''); ?>>Gigante (8XL)</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs"></i>
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
                    <p class="text-xs text-gray-500 font-medium">Así se verá el hero en tu sitio</p>
                </div>
            </div>

            <div class="p-8 flex-1 relative overflow-hidden flex flex-col items-center justify-center min-h-[400px]">
                <div class="absolute inset-0 bg-[#F51B1B]/5 blur-[80px] rounded-full"></div>

                <?php
                    $previewTitle = $settings['hero_title'] ?? "Themes & Plugins\n[G]Premium WP[/G]";
                    $previewTitle = preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF2121] to-[#F51B1B]">$1</span>', e($previewTitle));
                    $previewTitle = nl2br($previewTitle);
                ?>

                <div class="relative z-10 text-center max-w-sm">
                    <h1 class="font-black text-white tracking-tight mb-4 leading-[1.1] text-4xl lg:text-5xl">
                        <?php echo $previewTitle; ?>

                    </h1>
                    <p class="text-gray-400 text-sm font-medium leading-relaxed">
                        <?php echo e($settings['hero_description'] ?? 'Impulsa tus proyectos con los mejores recursos digitales.'); ?>

                    </p>
                </div>

                <p class="text-[10px] text-gray-600 mt-8 relative z-10 font-medium uppercase tracking-wider">
                    * La vista real puede variar según la resolución.
                </p>
            </div>
        </div>
    </div>
</form><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/admin/settings/tabs/hero.blade.php ENDPATH**/ ?>