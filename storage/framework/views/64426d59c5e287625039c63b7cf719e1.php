

<?php $__env->startSection('title', 'Configuraciones del Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-white tracking-tight">Configuraciones del Sistema</h1>
        <p class="text-sm text-gray-500 mt-2 font-medium">Administra todas las configuraciones de tu marketplace desde un solo lugar</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden mb-6" x-data="{ activeTab: '<?php echo e(request()->get('tab', 'hero')); ?>' }">
        <!-- Tab Headers -->
        <div class="border-b border-white/[0.06] bg-[#080808]/50">
            <div class="flex overflow-x-auto pb-1 custom-scrollbar cursor-grab active:cursor-grabbing select-none"
                 x-data="{
                    isDown: false,
                    startX: 0,
                    scrollLeft: 0,
                    start(e) {
                        this.isDown = true;
                        this.startX = e.pageX - $el.offsetLeft;
                        this.scrollLeft = $el.scrollLeft;
                    },
                    stop() {
                        this.isDown = false;
                    },
                    move(e) {
                        if (!this.isDown) return;
                        e.preventDefault();
                        const x = e.pageX - $el.offsetLeft;
                        const walk = (x - this.startX) * 2;
                        $el.scrollLeft = this.scrollLeft - walk;
                    }
                 }"
                 @mousedown="start($event)"
                 @mouseleave="stop()"
                 @mouseup="stop()"
                 @mousemove="move($event)">

                <?php
                    $tabs = [
                        ['id' => 'general', 'icon' => 'fa-sliders-h', 'label' => 'General & SEO', 'color' => 'purple'],
                        ['id' => 'hero', 'icon' => 'fa-paint-brush', 'label' => 'Hero Section', 'color' => 'indigo'],
                        ['id' => 'sidebar', 'icon' => 'fa-columns', 'label' => 'Sidebar', 'color' => 'indigo'],
                        ['id' => 'topbar', 'icon' => 'fa-bullhorn', 'label' => 'Top Bar', 'color' => 'pink'],
                        ['id' => 'points', 'icon' => 'fa-coins', 'label' => 'Sistema de Puntos', 'color' => 'amber'],
                        ['id' => 'gamification', 'icon' => 'fa-gamepad', 'label' => 'Gamificación', 'color' => 'red'],
                        ['id' => 'payments', 'icon' => 'fa-wallet', 'label' => 'Pagos', 'color' => 'emerald'],
                        ['id' => 'plugin', 'icon' => 'fab fa-wordpress', 'label' => 'Plugin WordPress', 'color' => 'blue'],
                        ['id' => 'products', 'icon' => 'fa-th', 'label' => 'Productos', 'color' => 'cyan'],
                        ['id' => 'storage', 'icon' => 'fa-cloud', 'label' => 'Almacenamiento (CDN)', 'color' => 'blue'],
                    ];
                ?>

                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button @click="activeTab = '<?php echo e($tab['id']); ?>'; window.history.pushState({}, '', '?tab=<?php echo e($tab['id']); ?>')"
                        :class="activeTab === '<?php echo e($tab['id']); ?>' ? 'text-white border-<?php echo e($tab['color']); ?>-500 bg-<?php echo e($tab['color']); ?>-500/10' : 'text-gray-400 hover:text-white hover:bg-white/5 border-transparent'"
                        class="flex items-center gap-3 px-6 py-4 font-black text-xs uppercase tracking-wider transition-all border-b-2 whitespace-nowrap">
                    <i class="fas <?php echo e($tab['icon']); ?>" :class="activeTab === '<?php echo e($tab['id']); ?>' ? 'text-<?php echo e($tab['color']); ?>-400' : ''"></i>
                    <span><?php echo e($tab['label']); ?></span>
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="p-6 w-full block">
            <div x-show="activeTab === 'general'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.general', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'hero'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.hero', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'sidebar'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'topbar'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'points'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.points', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'gamification'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.gamification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'payments'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.payments', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'plugin'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.plugin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'products'" x-transition>
                <?php echo $__env->make('admin.settings.tabs.products', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'storage'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <?php echo $__env->make('admin.settings.tabs.storage', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.02);
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\MAMP\htdocs\gplwolf\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>