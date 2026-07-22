    



    <?php $__env->startSection('content'); ?>
        <!-- Hero Section -->
        <!-- Hero Section -->
        <?php
            $heroStyle = request('hero') ?? ($settings['hero_style'] ?? 'circles');
        ?>

        <?php if($heroStyle === 'circles'): ?>
            <?php if ($__env->exists('partials.heroes.circles')) echo $__env->make('partials.heroes.circles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($heroStyle === 'stark'): ?>
            <?php if ($__env->exists('partials.heroes.stark')) echo $__env->make('partials.heroes.stark', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($heroStyle === 'cyber'): ?>
            <?php if ($__env->exists('partials.heroes.cyber')) echo $__env->make('partials.heroes.cyber', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($heroStyle === 'split'): ?>
            <?php if ($__env->exists('partials.heroes.split')) echo $__env->make('partials.heroes.split', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php if ($__env->exists('partials.heroes.aurora')) echo $__env->make('partials.heroes.aurora', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        <!-- Trusted Brands Slider -->
        <section class="relative py-12 md:py-16 bg-[#0a0a0a] border-b border-white/[0.04] overflow-hidden">
            <!-- Sliding Neon Line divider -->
            <div class="absolute top-0 left-0 w-full h-px animated-line"></div>
            <div class="max-w-7xl mx-auto px-6 mb-8">
                <p class="text-center text-xs font-black text-gray-500 uppercase tracking-[0.2em]">Marcas de Confianza</p>
            </div>
            
            <div class="relative">
                <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-[#0a0a0a] to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-[#0a0a0a] to-transparent z-10 pointer-events-none"></div>
                
                <div class="flex items-center gap-12 brands-marquee">
                    <?php $__currentLoopData = [$brands, $brands]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-12 shrink-0" <?php echo e($loop->index === 1 ? 'aria-hidden="true"' : ''); ?>>
                            <?php $__currentLoopData = $brandGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-3 px-6 py-3 bg-white/[0.03] border border-white/[0.06] rounded-xl shrink-0 hover:bg-white/[0.06] transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                                        <i class="<?php echo e($brand->icon ?? 'fas fa-cube'); ?> text-gray-400 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-bold text-gray-300 whitespace-nowrap"><?php echo e($brand->name); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section id="productos" class="pt-12 md:pt-16 pb-20 md:pb-24 bg-[#0a0a0a]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-full mb-4">
                            <i class="fas fa-fire text-[#FF2121] text-[10px]"></i>
                            <span class="text-[10px] font-black text-[#FF2121] uppercase tracking-widest">Destacados</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-2"><?php echo e($settings['home_featured_title'] ?? 'Lo más Vendido'); ?></h2>
                        <p class="text-gray-500 text-sm"><?php echo e($settings['home_featured_description'] ?? 'Explora nuestras últimas novedades premium para WordPress.'); ?></p>
                    </div>
                    <a href="<?php echo e(route('products.index')); ?>" class="group flex items-center gap-2 px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-[#FF2121]/30 rounded-xl text-white text-sm font-bold transition-all">
                        Ver Todos
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <?php if($homeProductsStyle === 'list'): ?>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group relative">
                            <!-- Hover Glow Backdrop -->
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] rounded-2xl blur opacity-0 group-hover:opacity-75 transition duration-500"></div>
                             
                            <div class="relative bg-[#0c0c0c] rounded-xl p-4 flex items-center gap-6 border border-white/5 hover:border-transparent transition-all">
                                <!-- Rank Badge -->
                                <div class="absolute -left-3 -top-3 w-8 h-8 flex items-center justify-center bg-[#F51B1B] text-white font-black text-sm rounded-lg shadow-lg rotate-12 z-10 border border-white/20">
                                    #<?php echo e($index + 1); ?>

                                </div>

                                <!-- Points on Hover Badge (List View) -->
                                <?php
                                    $pointsPerCurrency = \App\Models\Setting::where('key', 'points_per_currency')->value('value') ?? 1;
                                    $pts = ($product->reward_points > 0) 
                                            ? $product->reward_points 
                                            : floor($product->price * $pointsPerCurrency * ($product->points_multiplier ?? 1));
                                ?>
                                <?php if($pts > 0): ?>
                                    <div class="absolute top-3 right-3 z-20 px-2.5 py-1 bg-gray-900/90 backdrop-blur-md rounded-xl border border-amber-400/50 flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg shadow-black/50">
                                        <i class="fas fa-coins text-amber-300 text-[10px] drop-shadow-md"></i>
                                        <span class="text-xs font-black text-amber-300 leading-none drop-shadow-sm">+<?php echo e($pts); ?> Pts</span>
                                    </div>
                                <?php endif; ?>

                                <!-- Image with Neon Border -->
                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="w-20 h-20 flex-shrink-0 rounded-xl bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 p-2 border border-white/10 relative overflow-hidden group-hover:scale-105 transition-transform">
                                    <div class="absolute inset-0 bg-[#FF2121]/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="w-full h-full bg-[#1a1a1a] rounded-lg flex items-center justify-center relative z-10 overflow-hidden">
                                        <?php if($product->thumbnail): ?>
                                            <img src="<?php echo e(asset('storage/' . $product->thumbnail)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover" loading="<?php echo e($index < 2 ? 'eager' : 'lazy'); ?>">
                                        <?php else: ?>
                                            <i class="fas <?php echo e($product->type === 'theme' ? 'fa-palette' : 'fa-plug'); ?> text-3xl text-white"></i>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                        <span class="text-[9px] font-black text-white bg-gray-800/90 border border-white/20 uppercase tracking-wider px-2 py-0.5 rounded-md shadow-sm"><?php echo e(ucfirst($product->type)); ?></span>
                                         
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-900 border border-emerald-500/40 rounded text-emerald-400 text-[9px] font-bold flex-shrink-0 shadow-sm">
                                            <i class="fas fa-code-branch text-[7px]"></i>
                                            v<?php echo e($product->version); ?>

                                        </span>

                                        <?php if($product->badge): ?>
                                            <?php
                                                $badgeBg = match($product->badge) {
                                                    'Más Vendido' => 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-500/30 border-amber-300/40',
                                                    'Trending' => 'bg-gradient-to-r from-rose-500 to-pink-600 shadow-rose-500/30 border-rose-400/40',
                                                    'Popular' => 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-blue-500/30 border-blue-400/40',
                                                    default => 'bg-gradient-to-r from-[#FF2121] to-[#F51B1B] shadow-[#FF2121]/40 border-red-400/40',
                                                };
                                            ?>
                                            <span class="text-[9px] font-black text-white <?php echo e($badgeBg); ?> px-2 py-0.5 rounded-md ml-1 shadow-md uppercase tracking-wider border"><?php echo e($product->badge); ?></span>
                                        <?php endif; ?>

                                        <?php if($product->versions()->where('created_at', '>', now()->subHours(48))->exists()): ?>
                                            <span class="relative px-2 py-0.5 bg-[#F51B1B] rounded text-[9px] font-bold text-white overflow-hidden shadow-[0_0_10px_rgba(245,27,27,0.5)] ml-2">
                                                <div class="absolute top-0 left-[-100%] w-[50%] h-full bg-gradient-to-r from-transparent via-white/40 to-transparent skew-x-12 animate-[shimmer_2s_infinite]"></div>
                                                <i class="fas fa-sync-alt mr-1 text-[8px] animate-spin-slow"></i> ACTUALIZADO
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php echo e(route('products.show', $product->slug)); ?>">
                                        <h3 class="text-xl font-bold text-white group-hover:text-[#FF2121] transition-colors truncate"><?php echo e($product->name); ?></h3>
                                    </a>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="flex text-amber-400 text-[10px]">
                                            <span class="font-bold mr-1"><?php echo e($product->rating ?? 5.0); ?></span>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="text-xs text-gray-400 truncate"><?php echo e($product->short_description ?? ''); ?></span>
                                    </div>
                                </div>
                                
                                <!-- Meta & Action -->
                                <div class="flex items-center gap-6 px-4 border-l border-white/5">
                                    <div class="text-right">
                                        <?php if($product->price > 0): ?>
                                            <?php if($product->sale_price && $product->sale_price < $product->price): ?>
                                                <div class="flex flex-col items-end">
                                                    <span class="text-xs text-rose-400 line-through decoration-rose-500 font-bold opacity-70">
                                                        $<?php echo e(number_format($product->price, 2)); ?>

                                                    </span>
                                                    <div class="text-lg font-black text-white text-shadow-neon text-[#FF2121]">
                                                        $<?php echo e(number_format($product->sale_price, 2)); ?>

                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-lg font-black text-white text-shadow-neon">$<?php echo e(number_format($product->price, 2)); ?></div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="text-lg font-black text-[#FF2121] text-shadow-neon">GRATIS</div>
                                        <?php endif; ?>
                                    </div>
                                    <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-[#F51B1B] hover:bg-[#FF2121] text-white shadow-lg shadow-[#F51B1B]/30 flex items-center justify-center transition-all hover:scale-110 active:scale-95">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-full py-12 text-center text-gray-500">
                                No hay productos.
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif($homeProductsStyle === 'bento'): ?>
                    <?php if ($__env->exists('partials.products.bento')) echo $__env->make('partials.products.bento', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php else: ?>
                    
                    <div class="grid grid-cols-2 md:grid-cols-<?php echo e(min($homeGridColumns ?? 4, 4)); ?> lg:grid-cols-<?php echo e($homeGridColumns ?? 4); ?> gap-6">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-gray-800/60 rounded-xl overflow-hidden border border-white/10 hover:border-[#FF2121]/50 transition-all group cursor-pointer">
                            <!-- Imagen Compacta Centrada -->
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block">
                                <div class="aspect-square bg-gradient-to-br from-[#FF2121]/10 to-[#F51B1B]/10 flex items-center justify-center text-4xl relative overflow-hidden">
                                    <?php if($product->thumbnail): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->thumbnail)); ?>" 
                                            alt="<?php echo e($product->name); ?>" 
                                            loading="<?php echo e($index < 2 ? 'eager' : 'lazy'); ?>"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20">
                                            <i class="fas <?php echo e($product->type === 'theme' ? 'fa-palette' : 'fa-plug'); ?> text-5xl text-white/50"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Badge de Estado -->
                                    <div class="absolute top-3 left-3 z-30 flex flex-col gap-1.5 items-start">
                                        <?php if($product->badge): ?>
                                            <?php
                                                $badges = [
                                                    'Más Vendido' => ['bg' => 'bg-gradient-to-r from-amber-500 to-amber-600 shadow-amber-500/30 border-amber-300/40', 'icon' => 'fa-crown'],
                                                    'Trending' => ['bg' => 'bg-gradient-to-r from-rose-500 to-pink-600 shadow-rose-500/30 border-rose-400/40', 'icon' => 'fa-fire'],
                                                    'Popular' => ['bg' => 'bg-gradient-to-r from-blue-600 to-cyan-500 shadow-blue-500/30 border-blue-400/40', 'icon' => 'fa-star'],
                                                    'Nuevo' => ['bg' => 'bg-gradient-to-r from-[#FF2121] to-[#F51B1B] shadow-[#FF2121]/40 border-red-400/40', 'icon' => 'fa-bolt'],
                                                ];
                                                $badgeData = $badges[$product->badge] ?? ['bg' => 'bg-gray-800 border-gray-600', 'icon' => 'fa-tag'];
                                                $icon = $badgeData['icon'];
                                                $bg = $badgeData['bg'];
                                            ?>
                                            <span class="flex items-center gap-1.5 text-[9px] font-black text-white <?php echo e($bg); ?> backdrop-blur-md px-2.5 py-1 rounded-xl shadow-lg uppercase tracking-wider border leading-none">
                                                <i class="fas <?php echo e($icon); ?> text-[8px]"></i>
                                                <?php echo e($product->badge); ?>

                                            </span>
                                        <?php endif; ?>

                                        <?php if($product->sale_price && $product->sale_price < $product->price): ?>
                                            <?php
                                                $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                                            ?>
                                            <span class="flex items-center gap-1.5 text-[9px] font-black text-white bg-rose-600 px-2.5 py-1 rounded-xl shadow-lg uppercase tracking-wider border border-white/10 shadow-black/30 leading-none animate-pulse">
                                                <i class="fas fa-percent text-[8px]"></i>
                                                <?php echo e($discount); ?>% OFF
                                            </span>
                                        <?php endif; ?>

                                        <?php if($product->versions()->where('created_at', '>', now()->subHours(48))->exists()): ?>
                                            <span class="relative flex items-center gap-1.5 text-[9px] font-black text-white bg-[#F51B1B] px-2.5 py-1 rounded-xl shadow-lg uppercase tracking-wider border border-white/10 shadow-black/30 leading-none overflow-hidden">
                                                <div class="absolute top-0 left-[-100%] w-[50%] h-full bg-gradient-to-r from-transparent via-white/40 to-transparent skew-x-12 animate-[shimmer_2s_infinite]"></div>
                                                <i class="fas fa-sync-alt text-[8px] animate-spin-slow"></i> 
                                                ACTUALIZADO
                                            </span>
                                        <?php endif; ?>

                                        
                                        <?php
                                            $hasLongBadge = $product->badge && strlen($product->badge) > 8;
                                            $pointsPerCurrency = \App\Models\Setting::where('key', 'points_per_currency')->value('value') ?? 1;
                                            $pts = ($product->reward_points > 0) 
                                                    ? $product->reward_points 
                                                    : floor($product->price * $pointsPerCurrency * ($product->points_multiplier ?? 1));
                                        ?>
                                         
                                        <?php if($hasLongBadge && $pts > 0): ?>
                                            <span class="flex items-center gap-1.5 px-2.5 py-1 bg-gray-900/90 backdrop-blur-md rounded-xl border border-amber-400/50 shadow-lg shadow-black/50">
                                                <i class="fas fa-coins text-amber-300 text-[10px] drop-shadow-md"></i>
                                                <span class="text-xs font-black text-amber-300 leading-none drop-shadow-sm">+<?php echo e($pts); ?> Pts</span>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <?php if(!$hasLongBadge && $pts > 0): ?>
                                        <div class="absolute top-3 right-3 z-30 px-2.5 py-1 bg-gray-900/90 backdrop-blur-md rounded-xl border border-amber-400/50 flex items-center gap-1.5 transform translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 shadow-lg shadow-black/50">
                                            <i class="fas fa-coins text-amber-300 text-[10px] drop-shadow-md"></i>
                                            <span class="text-xs font-black text-amber-300 leading-none drop-shadow-sm">+<?php echo e($pts); ?> Pts</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            
                            <!-- Contenido -->
                            <div class="p-3">
                                <!-- Título con Versión al lado -->
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="flex-1 min-w-0">
                                        <h4 class="font-bold text-sm truncate group-hover:text-[#FF2121] transition-colors">
                                            <?php echo e($product->name); ?>

                                        </h4>
                                    <i class="fas <?php echo e($product->type === 'theme' ? 'fa-palette' : 'fa-plug'); ?> text-sm"></i>
                                    </a>
                                     
                                    <!-- Badge de Versión Rojo -->
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#FF2121]/20 border border-[#FF2121]/30 rounded text-[#FF2121] text-[9px] font-bold">
                                            <i class="fas fa-code-branch text-[7px]"></i>
                                            v<?php echo e($product->version); ?>

                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Precio y Botón -->
                                <div class="flex items-center justify-between mt-3">
                                    <div class="text-lg font-black">
                                        <?php if($product->price == 0): ?>
                                            <span class="text-[#FF2121] text-sm">GRATIS</span>
                                        <?php elseif($product->sale_price && $product->sale_price < $product->price): ?>
                                            <div class="flex flex-col items-start leading-none gap-0.5">
                                                <span class="text-[10px] text-rose-400 line-through decoration-rose-500 font-bold opacity-70">
                                                    $<?php echo e(number_format($product->price, 2)); ?>

                                                </span>
                                                <span class="text-[#FF2121] text-lg">
                                                    $<?php echo e(number_format($product->sale_price, 2)); ?>

                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-white">$<?php echo e(number_format($product->price, 2)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Botón de Carrito Rápido -->
                                    <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="w-7 h-7 bg-[#F51B1B] hover:bg-[#FF2121] rounded-lg flex items-center justify-center transition-all hover:scale-110">
                                            <i class="fas fa-cart-plus text-xs text-white"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-full py-16 text-center glass rounded-3xl border-dashed border-2 border-white/5">
                                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-300 font-bold">No hay productos disponibles.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Sección 2 Columnas: Más Comprados & Populares -->
        <section class="py-12 bg-[#050505] border-t border-white/5">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
                    
                    <!-- Columna 1: Más Comprados (5 ítems) -->
                    <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-[#FF2121]/10 blur-3xl rounded-full pointer-events-none"></div>

                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-[#FF2121]/20 border border-[#FF2121]/30 flex items-center justify-center text-[#FF2121] shadow-lg shadow-[#FF2121]/20">
                                    <i class="fas fa-fire text-base"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white tracking-tight">Más Comprados</h3>
                                    <p class="text-xs text-gray-500 font-medium">Los plugins y temas más adquiridos</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-[#FF2121]/10 border border-[#FF2121]/30 text-[#FF2121] text-[10px] font-black uppercase tracking-wider rounded-lg">Top 5</span>
                        </div>

                        <div class="space-y-3.5">
                            <?php $__currentLoopData = $bestSellers->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-[#FF2121]/30 transition-all duration-300 group/item">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-[#FF2121] group-hover/item:border-[#FF2121]/40">
                                            #<?php echo e($index + 1); ?>

                                        </span>
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                            <?php if($item->thumbnail): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->thumbnail)); ?>" alt="<?php echo e($item->name); ?>" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                            <?php else: ?>
                                                <div class="w-full h-full bg-gradient-to-br from-[#FF2121]/20 to-[#F51B1B]/20 flex items-center justify-center text-white/50 text-xs">
                                                    <i class="fas <?php echo e($item->type === 'theme' ? 'fa-palette' : 'fa-plug'); ?>"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0">
                                            <a href="<?php echo e(route('products.show', $item->slug)); ?>" class="text-sm font-bold text-white group-hover/item:text-[#FF2121] transition-colors truncate block">
                                                <?php echo e($item->name); ?>

                                            </a>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400 bg-white/5 px-2 py-0.5 rounded border border-white/10"><?php echo e($item->type); ?></span>
                                                <span class="text-xs font-black text-white font-mono">$<?php echo e(number_format($item->price, 2)); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="<?php echo e(route('cart.add', $item)); ?>" method="POST" class="shrink-0 ml-2">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-[#FF2121] text-gray-300 hover:text-white border border-white/10 hover:border-[#FF2121] transition-all flex items-center justify-center shadow-sm">
                                            <i class="fas fa-cart-plus text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Columna 2: Populares (5 ítems) -->
                    <div class="bg-[#0c0c0c] p-6 md:p-8 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-sky-500/10 blur-3xl rounded-full pointer-events-none"></div>

                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-sky-500/20 border border-sky-500/30 flex items-center justify-center text-sky-400 shadow-lg shadow-sky-500/20">
                                    <i class="fas fa-star text-base"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white tracking-tight">Populares</h3>
                                    <p class="text-xs text-gray-500 font-medium">Los recursos mejor valorados por la comunidad</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-sky-500/10 border border-sky-500/30 text-sky-400 text-[10px] font-black uppercase tracking-wider rounded-lg">Top 5</span>
                        </div>

                        <div class="space-y-3.5">
                            <?php $__currentLoopData = $popularProducts->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.07] border border-white/5 hover:border-sky-500/30 transition-all duration-300 group/item">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <span class="w-6 h-6 rounded-lg bg-white/5 border border-white/10 text-gray-400 text-xs font-black flex items-center justify-center shrink-0 font-mono group-hover/item:text-sky-400 group-hover/item:border-sky-500/40">
                                            #<?php echo e($index + 1); ?>

                                        </span>
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-900 border border-white/10 shrink-0">
                                            <?php if($item->thumbnail): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->thumbnail)); ?>" alt="<?php echo e($item->name); ?>" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                                            <?php else: ?>
                                                <div class="w-full h-full bg-gradient-to-br from-sky-500/20 to-blue-600/20 flex items-center justify-center text-white/50 text-xs">
                                                    <i class="fas <?php echo e($item->type === 'theme' ? 'fa-palette' : 'fa-plug'); ?>"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0">
                                            <a href="<?php echo e(route('products.show', $item->slug)); ?>" class="text-sm font-bold text-white group-hover/item:text-sky-400 transition-colors truncate block">
                                                <?php echo e($item->name); ?>

                                            </a>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[9px] font-black uppercase tracking-wider text-gray-400 bg-white/5 px-2 py-0.5 rounded border border-white/10"><?php echo e($item->type); ?></span>
                                                <span class="text-xs font-black text-white font-mono">$<?php echo e(number_format($item->price, 2)); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="<?php echo e(route('cart.add', $item)); ?>" method="POST" class="shrink-0 ml-2">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-sky-500 text-gray-300 hover:text-white border border-white/10 hover:border-sky-500 transition-all flex items-center justify-center shadow-sm">
                                            <i class="fas fa-cart-plus text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <!-- Plans Section -->
        <section id="planes" class="py-20 md:py-24 bg-[#080808] relative overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-[#FF2121]/5 blur-[120px] rounded-full pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative">
                <div class="text-center mb-12 md:mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-500/10 border border-amber-500/20 rounded-full mb-4">
                        <i class="fas fa-crown text-amber-400 text-[10px]"></i>
                        <span class="text-[10px] font-black text-amber-300 uppercase tracking-widest">Membresías</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-3">Elige tu Plan</h2>
                    <p class="text-gray-500 text-sm max-w-lg mx-auto">Obtén acceso ilimitado a toda nuestra biblioteca premium por una fracción del costo.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                    <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $featuredClass = $plan->is_featured ? 'border-[#FF2121]/30 shadow-lg shadow-[#FF2121]/10' : 'border-white/[0.06]';
                            $featuredOffset = $plan->is_featured ? 'md:-mt-4 md:mb-4' : '';
                        ?>
                        <div class="relative bg-[#0a0a0a] border <?php echo e($featuredClass); ?> rounded-2xl p-6 md:p-8 flex flex-col <?php echo e($featuredOffset); ?>">
                            <?php if($plan->is_featured): ?>
                                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] text-white text-[10px] font-black px-4 py-1.5 uppercase tracking-wider rounded-full shadow-lg animated-badge">
                                    Recomendado
                                </div>
                            <?php endif; ?>

                            <div class="mb-6">
                                <h3 class="text-sm font-black <?php echo e($plan->is_featured ? 'text-[#FF2121]' : 'text-gray-400'); ?> uppercase tracking-widest mb-4"><?php echo e($plan->name); ?></h3>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-4xl md:text-5xl font-black text-white">$<?php echo e($plan->price == (int)$plan->price ? number_format($plan->price, 0) : number_format($plan->price, 2)); ?></span>
                                    <span class="text-gray-500 text-xs font-bold">/ <?php echo e($plan->duration); ?></span>
                                </div>
                            </div>

                            <div class="space-y-3 mb-8 flex-1">
                                <?php $__currentLoopData = $plan->benefits ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start gap-3">
                                        <div class="w-5 h-5 rounded-full <?php echo e($plan->is_featured ? 'bg-[#FF2121]/20' : 'bg-white/5'); ?> flex items-center justify-center shrink-0 mt-0.5">
                                            <i class="fas fa-check text-[10px] <?php echo e($plan->is_featured ? 'text-[#FF2121]' : 'text-gray-500'); ?>"></i>
                                        </div>
                                        <span class="text-sm text-gray-400 leading-relaxed"><?php echo e($benefit); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <form action="<?php echo e(route('membership.add', $plan)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php
                                    $buttonClass = $plan->is_featured 
                                        ? 'bg-[#F51B1B] hover:bg-[#FF2121] text-white shadow-lg shadow-[#F51B1B]/20' 
                                        : 'bg-white/5 hover:bg-white/10 border border-white/10 text-white';
                                ?>
                                <button type="submit" class="w-full py-3.5 rounded-xl font-black text-sm transition-all <?php echo e($buttonClass); ?>">
                                    Activar Ahora
                                </button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes disponibles.</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section id="categorias" class="py-20 md:py-24 bg-[#080808] relative overflow-hidden">
            <!-- Split background: solid left + animated dots right -->
            <div class="absolute inset-0 split-dots-bg"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="mb-10">
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-2">Explorar por categoría</h2>
                    <p class="text-gray-500 text-sm">Encuentra exactamente lo que necesitas.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="group relative bg-[#0a0a0a] border border-white/[0.06] hover:border-white/20 rounded-2xl p-5 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#FF2121]/5 <?php echo e($category->products_count > 0 ? 'category-pulse' : ''); ?>">
                            <div class="w-12 h-12 rounded-xl bg-white/5 group-hover:bg-[#FF2121]/10 flex items-center justify-center mb-4 transition-colors duration-300">
                                <i class="<?php echo e($category->icon ?? 'fas fa-folder'); ?> text-xl text-gray-400 group-hover:text-[#FF2121] transition-colors duration-300"></i>
                            </div>
                            <h3 class="text-sm font-black text-white mb-1 line-clamp-1 group-hover:text-[#FF2121] transition-colors"><?php echo e($category->name); ?></h3>
                            <span class="text-xs text-gray-500"><?php echo e($category->products_count); ?> <?php echo e($category->products_count === 1 ? 'producto' : 'productos'); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>



        <?php
            $orgSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $settings['site_name'] ?? 'WP Marketplace',
                'url' => route('home'),
                'logo' => isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('images/logo-default.png'),
                'description' => $settings['site_description'] ?? 'Themes y Plugins Premium para WordPress'
            ];
        ?>
        <script type="application/ld+json">
            <?php echo json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>

        </script>
        <style>
        @keyframes shimmer {
            100% { left: 200%; }
        }
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Split animated dots background */
        .split-dots-bg {
            background: linear-gradient(135deg, #0a0a0a 0%, #0a0a0a 50%, #080808 50%, #080808 100%);
        }
        .split-dots-bg::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 32px 32px;
            animation: dots-drift 20s linear infinite;
            opacity: 0.6;
        }
        .split-dots-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 1px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(255, 33, 33, 0.3), transparent);
            transform: translateX(-50%);
        }
        @keyframes dots-drift {
            0% { background-position: 0 0; }
            100% { background-position: 32px 32px; }
        }

        /* Brands marquee slider */
        .brands-marquee {
            animation: marquee-scroll 30s linear infinite;
        }
        .brands-marquee:hover {
            animation-play-state: paused;
        }
        @keyframes marquee-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .animated-line {
            background: linear-gradient(90deg, transparent 0%, rgba(255, 33, 33, 0.15) 35%, rgba(255, 33, 33, 0.8) 50%, rgba(255, 33, 33, 0.15) 65%, transparent 100%);
            background-size: 200% 100%;
            animation: line-slide 3s linear infinite;
        }
        @keyframes line-slide {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }

        /* Category pulse for categories with products */
        .category-pulse {
            position: relative;
        }
        .category-pulse::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(255, 33, 33, 0.3), transparent, rgba(255, 33, 33, 0.2));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
            filter: blur(8px);
        }
        .category-pulse:hover::before {
            opacity: 1;
            animation: category-glow 2s ease-in-out infinite;
        }
        @keyframes category-glow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        </style>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/home.blade.php ENDPATH**/ ?>