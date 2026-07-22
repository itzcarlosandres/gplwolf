<!-- ==============================================
     OPCIÓN 1: CIRCULAR BRANDS ORBIT (Marcas en Círculos)
     ============================================== -->
<div class="relative min-h-0 flex items-center justify-center overflow-hidden bg-[#050505] py-10 sm:py-14 md:py-16">
    <!-- Ambient Red Glow Backdrops (Optimized for Mobile) -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] sm:w-[500px] md:w-[650px] h-[320px] sm:h-[500px] md:h-[650px] bg-gradient-to-tr from-[#FF2121]/20 via-[#F51B1B]/10 to-transparent rounded-full blur-[90px] md:blur-[140px] animate-pulse"></div>
        <div class="absolute -top-20 -left-20 w-60 md:w-96 h-60 md:h-96 bg-[#FF2121]/10 rounded-full blur-[80px] md:blur-[120px]"></div>
        <div class="absolute -bottom-20 -right-20 w-60 md:w-96 h-60 md:h-96 bg-amber-500/10 rounded-full blur-[80px] md:blur-[120px]"></div>
        <!-- Grid overlay -->
        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.06)_1px,transparent_1px)] [background-size:20px_20px] md:[background-size:28px_28px]"></div>
    </div>

    <!-- Floating Brand Circles Orbiting (Ajustados móviles y desktop) -->
    <div class="absolute inset-0 max-w-7xl mx-auto pointer-events-none z-20">
        <?php
            $circlePositions = [
                ['top' => '10%', 'left' => '3%', 'delay' => '0s', 'icon' => 'fab fa-wordpress', 'name' => 'WordPress'],
                ['top' => '12%', 'right' => '3%', 'delay' => '1.2s', 'icon' => 'fas fa-cubes', 'name' => 'Elementor'],
                ['top' => '42%', 'left' => '1.5%', 'delay' => '1.8s', 'icon' => 'fas fa-shield-halved', 'name' => 'Yoast SEO'],
                ['top' => '44%', 'right' => '1.5%', 'delay' => '3.1s', 'icon' => 'fas fa-palette', 'name' => 'Astra Theme'],
                ['top' => '72%', 'left' => '4%', 'delay' => '2.5s', 'icon' => 'fas fa-shopping-cart', 'name' => 'WooCommerce'],
                ['top' => '74%', 'right' => '4%', 'delay' => '3.8s', 'icon' => 'fas fa-rocket', 'name' => 'WP Rocket'],
            ];
        ?>

        <?php $__currentLoopData = $circlePositions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="absolute flex flex-col items-center group pointer-events-auto cursor-pointer circle-float opacity-40 sm:opacity-75 md:opacity-100" style="top: <?php echo e($pos['top']); ?>; left: <?php echo e($pos['left'] ?? 'auto'); ?>; right: <?php echo e($pos['right'] ?? 'auto'); ?>; animation-delay: <?php echo e($pos['delay']); ?>;">
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-14 md:h-14 rounded-full bg-gradient-to-br from-[#1c0808] via-[#111] to-[#0a0a0a] border border-[#FF2121]/40 shadow-lg md:shadow-xl shadow-[#FF2121]/20 flex items-center justify-center text-white text-xs sm:text-base md:text-xl group-hover:scale-115 group-hover:border-[#FF2121] group-hover:shadow-[0_0_25px_rgba(255,33,33,0.5)] transition-all duration-300 relative">
                    <div class="absolute inset-0 rounded-full bg-[#FF2121]/10 blur-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <i class="<?php echo e($pos['icon']); ?> group-hover:text-[#FF2121] transition-colors"></i>
                </div>
                <span class="mt-1 text-[8px] sm:text-[9px] font-black uppercase tracking-wider text-gray-400 group-hover:text-white bg-black/80 px-1.5 py-0.5 rounded-full border border-white/10 backdrop-blur-md transition-colors shadow-md hidden sm:inline-block">
                    <?php echo e($pos['name']); ?>

                </span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Main Content Container -->
    <div class="relative z-10 w-full max-w-4xl mx-auto px-4 sm:px-6 flex flex-col items-center text-center">

        <!-- Glowing Central Circle Badge -->
        <div class="inline-flex items-center gap-2 sm:gap-3 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-[#FF2121]/10 border border-[#FF2121]/30 backdrop-blur-xl text-[10px] sm:text-xs font-bold text-white mb-4 sm:mb-6 shadow-xl shadow-[#FF2121]/20 hover:scale-105 transition-transform">
            <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-[#FF2121] flex items-center justify-center text-white text-[8px] sm:text-[9px] animate-pulse">
                <i class="fas fa-certificate"></i>
            </div>
            <span class="uppercase tracking-widest text-gray-200">Ecosistema GPL Licenciado</span>
            <span class="px-1.5 py-0.5 sm:px-2 bg-white/10 text-amber-300 text-[8px] sm:text-[9px] font-black rounded-full">Garantizado</span>
        </div>

        <!-- Main Title (Adaptativo en Móviles) -->
        <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-black tracking-tight text-white mb-4 sm:mb-6 leading-[1.1] md:leading-[1.05]">
            <?php echo preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF2121] via-[#F51B1B] to-amber-400">$1</span>', e($settings['hero_title'] ?? 'Las mejores [G]Marcas WordPress[/G] en un solo lugar')); ?>

        </h1>

        <!-- Subtitle -->
        <p class="text-sm sm:text-base md:text-lg text-gray-400 max-w-xl mb-6 sm:mb-8 leading-relaxed font-medium px-2">
            <?php echo e($settings['hero_description'] ?? 'Descarga directa con actualizaciones automáticas. Formateado para agencias, desarrolladores y creadores de contenido.'); ?>

        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row justify-center items-stretch sm:items-center gap-3 sm:gap-4 w-full sm:w-auto px-4 sm:px-0">
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('products.index')); ?>" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] text-white font-black text-xs uppercase tracking-wider rounded-2xl hover:scale-105 transition-all shadow-2xl shadow-[#FF2121]/40 flex items-center justify-center gap-2.5">
                <i class="fas fa-rocket text-sm"></i> Explora el Catálogo
            </a>
            <?php else: ?>
            <a href="<?php echo e(route('register')); ?>" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] text-white font-black text-xs uppercase tracking-wider rounded-2xl hover:scale-105 transition-all shadow-2xl shadow-[#FF2121]/40 flex items-center justify-center gap-2.5">
                <i class="fas fa-user-plus text-sm"></i> Crear Cuenta Gratis
            </a>
            <?php endif; ?>

            <a href="#planes" class="w-full sm:w-auto px-7 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#FF2121]/40 text-white font-black text-xs uppercase tracking-wider rounded-2xl transition-all backdrop-blur-md flex items-center justify-center gap-2">
                <i class="fas fa-crown text-amber-400"></i> Ver Membresías
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes circleFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(2deg); }
    }
    .circle-float {
        animation: circleFloat 5s ease-in-out infinite;
    }
</style>
<?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/partials/heroes/circles.blade.php ENDPATH**/ ?>