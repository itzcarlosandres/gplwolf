

<?php $__env->startSection('title', 'Panel de Control'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Panel de Control</h1>
        <p class="text-gray-400 mt-1">Resumen general de tu marketplace hoy.</p>
    </div>
    <div class="flex items-center space-x-3">
        <span class="inline-flex items-center rounded-md bg-[#FF2121]/10 px-2 py-1 text-xs font-medium text-[#FF2121] ring-1 ring-inset ring-[#FF2121]/20">
            Actualizado: <?php echo e(now()->format('H:i')); ?>

        </span>
    </div>
</div>

<?php
    $pendingUpdatesList = \App\Models\UpdateRequest::where('status', 'pending')->with(['product', 'user'])->latest()->get();
?>
<?php if($pendingUpdatesList->count() > 0): ?>
    <div class="mb-8 p-5 bg-gradient-to-r from-amber-500/15 via-amber-500/10 to-transparent border border-amber-500/30 rounded-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4 backdrop-blur-xl">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-amber-400 text-xl shrink-0 animate-pulse">
                <i class="fas fa-sync-alt"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    Tienes <?php echo e($pendingUpdatesList->count()); ?> solicitud<?php echo e($pendingUpdatesList->count() > 1 ? 'es' : ''); ?> de actualización pendiente<?php echo e($pendingUpdatesList->count() > 1 ? 's' : ''); ?>

                </h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    Última por <strong class="text-white"><?php echo e($pendingUpdatesList->first()->user->name ?? 'Usuario'); ?></strong> para <strong class="text-amber-400"><?php echo e($pendingUpdatesList->first()->product->name ?? 'Producto'); ?></strong>
                </p>
            </div>
        </div>
        <a href="<?php echo e(route('admin.update-requests.index')); ?>" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-black font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-amber-500/20 whitespace-nowrap">
            Atender Solicitudes →
        </a>
    </div>
<?php endif; ?>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gray-800/40 backdrop-blur-xl p-6 rounded-2xl border border-white/5 flex items-center group hover:bg-gray-800/60 transition-all duration-300">
        <div class="w-14 h-14 bg-[#FF2121]/10 text-[#FF2121] rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-box"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Productos</h3>
            <p class="text-2xl font-bold text-white mt-1"><?php echo e(number_format($stats['total_products'])); ?></p>
        </div>
    </div>

    <div class="bg-gray-800/40 backdrop-blur-xl p-6 rounded-2xl border border-white/5 flex items-center group hover:bg-gray-800/60 transition-all duration-300">
        <div class="w-14 h-14 bg-[#F51B1B]/10 text-[#F51B1B] rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-users"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Usuarios</h3>
            <p class="text-2xl font-bold text-white mt-1"><?php echo e(number_format($stats['total_users'])); ?></p>
        </div>
    </div>

    <div class="bg-gray-800/40 backdrop-blur-xl p-6 rounded-2xl border border-white/5 flex items-center group hover:bg-gray-800/60 transition-all duration-300">
        <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Órdenes</h3>
            <p class="text-2xl font-bold text-white mt-1"><?php echo e(number_format($stats['total_orders'])); ?></p>
        </div>
    </div>

    <div class="bg-gray-800/40 backdrop-blur-xl p-6 rounded-2xl border border-white/5 flex items-center group hover:bg-gray-800/60 transition-all duration-300">
        <div class="w-14 h-14 bg-amber-500/10 text-amber-500 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Ingresos</h3>
            <p class="text-2xl font-bold text-white mt-1">$<?php echo e(number_format($stats['total_revenue'], 2)); ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-gray-800/40 backdrop-blur-xl rounded-2xl border border-white/5 overflow-hidden flex flex-col">
        <div class="p-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-history text-[#FF2121]"></i> Órdenes Recientes
            </h2>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-[#FF2121] hover:text-[#FF2121] text-sm font-semibold transition-colors">
                Ver todas <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-900/40 text-gray-400 text-[10px] uppercase font-bold tracking-widest border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4">Orden</th>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    <?php $__empty_1 = true; $__currentLoopData = $stats['recent_orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4 font-mono text-[#FF2121] group-hover:text-[#FF2121]">#<?php echo e($order->order_number); ?></td>
                            <td class="px-6 py-4 text-gray-300"><?php echo e($order->user->name ?? 'Usuario'); ?></td>
                            <td class="px-6 py-4 font-bold text-white">$<?php echo e(number_format($order->total, 2)); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider
                                    <?php echo e($order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-500 border border-amber-500/20'); ?>">
                                    <?php echo e($order->status); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-3xl mb-3 opacity-20"></i>
                                    <p>No hay órdenes registradas.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-gray-800/40 backdrop-blur-xl rounded-2xl border border-white/5 overflow-hidden flex flex-col">
        <div class="p-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-fire-alt text-orange-400"></i> Productos Populares
            </h2>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="text-[#FF2121] hover:text-[#FF2121] text-sm font-semibold transition-colors">
                Gestionar <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
        <div class="p-6 flex-1">
            <div class="space-y-5">
                <?php $__empty_1 = true; $__currentLoopData = $stats['top_products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-all group border border-transparent hover:border-white/5">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center text-xl mr-4 border border-white/10 group-hover:rotate-6 transition-transform">
                                <?php if($product->type === 'theme'): ?> 🎨 <?php else: ?> ⚡ <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-[#FF2121] transition-colors"><?php echo e($product->name); ?></h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider bg-gray-900 px-1.5 py-0.5 rounded border border-white/5"><?php echo e($product->type); ?></span>
                                    <span class="text-[10px] text-gray-400">• <?php echo e($product->category->name ?? 'Sin Categoría'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-white"><?php echo e($product->downloads_count); ?></p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Descargas</p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="flex flex-col items-center justify-center h-full py-10 opacity-40">
                        <i class="fas fa-ghost text-4xl mb-4"></i>
                        <p class="text-sm">Nada por aquí aún.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>