<form action="<?php echo e(route('admin.settings.update-general')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6"
      x-data="{ 
          identityType: '<?php echo e($settings['site_identity_type'] ?? 'logo'); ?>', 
          selectedIcon: '<?php echo e($settings['site_icon'] ?? 'fas fa-store'); ?>' 
      }">
    <?php echo csrf_field(); ?>

    <!-- Branding Section -->
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center justify-center text-[#F51B1B]">
                <i class="fas fa-id-card text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-white">Identidad de Marca</h3>
                <p class="text-xs text-gray-500 font-medium">Configura el logo, favicon y nombre de tu sitio</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Site Name -->
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Nombre del Sitio</label>
                <input type="text" name="site_name" value="<?php echo e($settings['site_name'] ?? 'WP Marketplace'); ?>"
                    class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#F51B1B]/50 focus:ring-2 focus:ring-[#F51B1B]/10 transition-all font-bold placeholder-gray-700">
            </div>

            <!-- Identity Type -->
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Tipo de Identidad Visual</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="site_identity_type" value="logo" x-model="identityType" class="peer sr-only">
                        <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-4 flex items-center gap-3 peer-checked:border-[#F51B1B]/50 peer-checked:bg-[#F51B1B]/10 transition-all hover:border-white/20">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 peer-checked:text-[#F51B1B]">
                                <i class="fas fa-image"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-white block">Usar Logo</span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider">Imagen cargada</span>
                            </div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="site_identity_type" value="text" x-model="identityType" class="peer sr-only">
                        <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-4 flex items-center gap-3 peer-checked:border-[#F51B1B]/50 peer-checked:bg-[#F51B1B]/10 transition-all hover:border-white/20">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 peer-checked:text-[#F51B1B]">
                                <i class="fas fa-font"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-white block">Texto + Icono</span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider">Nombre + icono Font Awesome</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Icon Selector -->
            <div x-show="identityType === 'text'" x-transition>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-3">Selecciona un Icono</label>
                <div class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-12 gap-2">
                    <?php
                        $icons = [
                            'fas fa-store', 'fas fa-shopping-bag', 'fas fa-shopping-cart', 'fas fa-tags',
                            'fas fa-layer-group', 'fas fa-cubes', 'fas fa-code', 'fas fa-desktop',
                            'fas fa-laptop-code', 'fas fa-mobile-alt', 'fas fa-rocket', 'fas fa-bolt',
                            'fas fa-star', 'far fa-gem', 'fas fa-crown', 'fas fa-certificate',
                            'fas fa-check-circle', 'fas fa-download', 'fas fa-cloud-download-alt', 'fas fa-server',
                            'fas fa-database', 'fab fa-wordpress', 'fab fa-html5', 'fab fa-css3-alt',
                            'fab fa-js', 'fab fa-php', 'fab fa-laravel', 'fab fa-docker', 'fab fa-aws', 'fas fa-fire'
                        ];
                    ?>

                    <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="cursor-pointer group">
                        <input type="radio" name="site_icon" value="<?php echo e($icon); ?>" class="peer sr-only" x-model="selectedIcon">
                        <div class="aspect-square flex items-center justify-center rounded-xl bg-[#080808] border border-white/[0.08] peer-checked:bg-[#F51B1B] peer-checked:border-[#F51B1B] peer-checked:text-white hover:border-white/20 transition-all">
                            <i class="<?php echo e($icon); ?> text-lg" :class="selectedIcon === '<?php echo e($icon); ?>' ? 'text-white' : 'text-gray-400 group-hover:text-gray-200'"></i>
                        </div>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <p class="text-[10px] text-gray-500 mt-2 font-medium">Este icono aparecerá junto al nombre de tu sitio.</p>
            </div>

            <!-- Logo Upload -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Logo del Sitio (PNG/SVG)</label>
                    <div class="relative group cursor-pointer">
                        <div class="border border-dashed border-white/[0.08] rounded-xl p-6 text-center transition-all hover:border-[#F51B1B]/50 hover:bg-white/[0.02] bg-[#080808]">
                            <input type="file" name="site_logo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png,image/svg+xml,image/jpeg">

                            <?php if(isset($settings['site_logo'])): ?>
                                <img src="<?php echo e(asset($settings['site_logo'])); ?>" class="h-16 mx-auto mb-4 object-contain">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('remove-logo-form').submit();" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center shadow-lg transition-transform hover:scale-110" title="Eliminar Logo">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <p class="text-xs text-emerald-400 font-bold">Logo actual cargado</p>
                            <?php else: ?>
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-600 mb-3 group-hover:text-[#F51B1B] transition-colors"></i>
                                <p class="text-sm text-gray-400 font-medium">Click o arrastra para subir</p>
                            <?php endif; ?>
                            <p class="text-[10px] text-gray-600 mt-2">Recomendado: 200x50px PNG Transparente</p>
                        </div>
                    </div>
                </div>

                <!-- Favicon Upload -->
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Favicon (ICO/PNG)</label>
                    <div class="relative group cursor-pointer">
                        <div class="border border-dashed border-white/[0.08] rounded-xl p-6 text-center transition-all hover:border-[#F51B1B]/50 hover:bg-white/[0.02] bg-[#080808]">
                            <input type="file" name="site_favicon" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png,image/x-icon,image/svg+xml">

                            <?php if(isset($settings['site_favicon'])): ?>
                                <img src="<?php echo e(asset($settings['site_favicon'])); ?>" class="h-12 w-12 mx-auto mb-4 object-contain">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('remove-favicon-form').submit();" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center shadow-lg transition-transform hover:scale-110" title="Eliminar Favicon">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <p class="text-xs text-emerald-400 font-bold">Favicon actual</p>
                            <?php else: ?>
                                <i class="fas fa-star text-3xl text-gray-600 mb-3 group-hover:text-[#F51B1B] transition-colors"></i>
                                <p class="text-sm text-gray-400 font-medium">Click o arrastra para subir</p>
                            <?php endif; ?>
                            <p class="text-[10px] text-gray-600 mt-2">Recomendado: 32x32px o 64x64px</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Typography Section -->
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden"
         x-data="{ selectedFont: '<?php echo e($settings['site_font'] ?? 'Outfit'); ?>' }">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;800&family=Manrope:wght@400;800&family=Outfit:wght@400;800&family=Plus+Jakarta+Sans:wght@400;800&family=Poppins:wght@400;800&family=Space+Grotesk:wght@400;800&display=swap');
        </style>

        <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-400">
                <i class="fas fa-pen-nib text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-white">Tipografía Global</h3>
                <p class="text-xs text-gray-500 font-medium">Selecciona la fuente principal de tu marketplace</p>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <?php
                    $fonts = [
                        'Outfit' => 'Moderno & Bold',
                        'Inter' => 'Limpio & Estándar',
                        'Plus Jakarta Sans' => 'Geométrico & Startup',
                        'Poppins' => 'Amigable & Tech',
                        'Manrope' => 'Moderno & Legible',
                        'Space Grotesk' => 'Futurista & Tech'
                    ];
                ?>

                <?php $__currentLoopData = $fonts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $font => $desc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="cursor-pointer group">
                    <input type="radio" name="site_font" value="<?php echo e($font); ?>" class="peer sr-only" x-model="selectedFont">
                    <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-4 peer-checked:border-pink-500/50 peer-checked:bg-pink-500/10 hover:border-white/20 transition-all h-full flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-wider"><?php echo e($font); ?></span>
                            <div class="w-4 h-4 rounded-full border border-white/20 peer-checked:bg-pink-400 peer-checked:border-pink-400 flex items-center justify-center">
                                <i class="fas fa-check text-[8px] text-white opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        <div style="font-family: '<?php echo e($font); ?>', sans-serif;">
                            <span class="text-2xl text-white font-bold block">Aa Bb Cc</span>
                            <span class="text-xs text-gray-500 font-medium"><?php echo e($desc); ?></span>
                        </div>
                    </div>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- SEO Section -->
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                <i class="fas fa-globe text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-white">SEO Global</h3>
                <p class="text-xs text-gray-500 font-medium">Meta tags y optimización para motores de búsqueda</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Título SEO (Home)</label>
                    <input type="text" name="home_meta_title" value="<?php echo e($settings['home_meta_title'] ?? ($settings['site_name'] ?? 'WP Marketplace')); ?>"
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                    <p class="text-[10px] text-gray-500 mt-1 text-right font-medium">Aparecerá en la pestaña del navegador</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Meta Descripción (Home)</label>
                    <textarea name="home_meta_description" rows="3"
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700"><?php echo e($settings['home_meta_description'] ?? 'Descarga los mejores temas y plugins premium para WordPress.'); ?></textarea>
                    <p class="text-[10px] text-gray-500 mt-1 text-right font-medium">Recomendado: 150-160 caracteres</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Meta Keywords (Globales)</label>
                    <input type="text" name="home_meta_keywords" value="<?php echo e($settings['home_meta_keywords'] ?? 'wordpress, themes, plugins, premium, marketplace'); ?>"
                        class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                    <p class="text-[10px] text-gray-500 mt-1 font-medium">Separadas por comas</p>
                </div>
            </div>

            <!-- Product SEO Templates -->
            <div class="pt-6 border-t border-white/[0.06]">
                <h4 class="text-sm font-black text-white mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <i class="fas fa-magic text-[#FF2121]"></i> SEO Automático para Productos
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Plantilla de Título</label>
                        <input type="text" name="product_seo_title_template" value="<?php echo e($settings['product_seo_title_template'] ?? 'Descargar %name% - Premium GPL'); ?>"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        <p class="text-[10px] text-gray-500 mt-1 font-medium">Variables: <code class="text-[#FF2121]">%name%</code></p>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Plantilla de Descripción</label>
                        <input type="text" name="product_seo_desc_template" value="<?php echo e($settings['product_seo_desc_template'] ?? 'Descargar %name% - %description%'); ?>"
                            class="w-full bg-[#080808] border border-white/[0.08] rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700">
                        <p class="text-[10px] text-gray-500 mt-1 font-medium">Variables: <code class="text-[#FF2121]">%name%</code>, <code class="text-[#FF2121]">%description%</code></p>
                    </div>
                </div>
            </div>

            <!-- OG Image Upload -->
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2">Imagen Social por Defecto (OG Image)</label>
                <div class="relative group cursor-pointer">
                    <div class="border border-dashed border-white/[0.08] rounded-xl p-6 text-center transition-all hover:border-[#FF2121]/50 hover:bg-white/[0.02] bg-[#080808] flex flex-col items-center justify-center">
                        <input type="file" name="site_og_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/jpeg,image/png">

                        <?php if(isset($settings['site_og_image'])): ?>
                            <div class="relative w-full max-w-sm mb-4 rounded-lg overflow-hidden border border-white/[0.06]">
                                <img src="<?php echo e(asset($settings['site_og_image'])); ?>" class="w-full h-auto object-cover">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('remove-og-form').submit();" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 w-8 h-8 flex items-center justify-center shadow-lg transition-transform hover:scale-110 z-10" title="Eliminar Imagen">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </div>
                            <p class="text-xs text-emerald-400 font-bold">Imagen actual cargada</p>
                        <?php else: ?>
                            <i class="fas fa-share-alt text-3xl text-gray-600 mb-3 group-hover:text-[#FF2121] transition-colors"></i>
                            <p class="text-sm text-gray-400 font-medium">Subir imagen para compartir en redes</p>
                        <?php endif; ?>
                        <p class="text-[10px] text-gray-600 mt-2">Recomendado: 1200x630px JPG</p>
                    </div>
                </div>
            </div>

            <!-- Custom Code Section -->
            <div class="pt-6 border-t border-white/[0.06]">
                <h4 class="text-sm font-black text-white mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <i class="fas fa-code text-yellow-400"></i> Código Personalizado (Header)
                </h4>
                <div class="bg-[#080808] rounded-xl overflow-hidden border border-white/[0.08]">
                    <div class="bg-black/30 px-4 py-3 border-b border-white/[0.06] flex items-center justify-between">
                        <span class="text-[10px] font-mono text-gray-500 font-bold">&lt;head&gt; ... &lt;/head&gt;</span>
                        <span class="text-[10px] text-yellow-500/80 font-bold"><i class="fas fa-exclamation-triangle mr-1"></i> Precaución: Código sin validar</span>
                    </div>
                    <textarea name="site_header_code" rows="6"
                        class="w-full bg-transparent border-0 px-4 py-3 text-sm font-mono text-gray-300 focus:ring-0 placeholder-gray-700"
                        placeholder="<!-- Google Analytics, Verification Tags, etc. -->"><?php echo e($settings['site_header_code'] ?? ''); ?></textarea>
                </div>
                <p class="text-[10px] text-gray-500 mt-2 font-medium">Este código se inyectará directamente en el <code>&lt;head&gt;</code> de todas las páginas.</p>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="submit" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center gap-3">
            <i class="fas fa-save"></i>
            Guardar Configuración General
        </button>
    </div>
</form>

<!-- Hidden Forms for Image Removal -->
<form id="remove-logo-form" action="<?php echo e(route('admin.settings.remove-image')); ?>" method="POST" class="hidden">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="key" value="site_logo">
</form>

<form id="remove-favicon-form" action="<?php echo e(route('admin.settings.remove-image')); ?>" method="POST" class="hidden">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="key" value="site_favicon">
</form>

<form id="remove-og-form" action="<?php echo e(route('admin.settings.remove-image')); ?>" method="POST" class="hidden">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="key" value="site_og_image">
</form><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/admin/settings/tabs/general.blade.php ENDPATH**/ ?>