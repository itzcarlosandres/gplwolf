@extends('layouts.admin')

@section('title', 'Configuraciones del Sistema')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-white tracking-tight">Configuraciones del Sistema</h1>
        <p class="text-sm text-gray-500 mt-2 font-medium">Administra todas las configuraciones de tu marketplace desde un solo lugar</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden mb-6" x-data="{ activeTab: '{{ request()->get('tab', 'hero') }}' }">
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

                @php
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
                @endphp

                @foreach($tabs as $tab)
                <button @click="activeTab = '{{ $tab['id'] }}'; window.history.pushState({}, '', '?tab={{ $tab['id'] }}')"
                        :class="activeTab === '{{ $tab['id'] }}' ? 'text-white border-{{ $tab['color'] }}-500 bg-{{ $tab['color'] }}-500/10' : 'text-gray-400 hover:text-white hover:bg-white/5 border-transparent'"
                        class="flex items-center gap-3 px-6 py-4 font-black text-xs uppercase tracking-wider transition-all border-b-2 whitespace-nowrap">
                    <i class="fas {{ $tab['icon'] }}" :class="activeTab === '{{ $tab['id'] }}' ? 'text-{{ $tab['color'] }}-400' : ''"></i>
                    <span>{{ $tab['label'] }}</span>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Tab Content -->
        <div class="p-6 w-full block">
            <div x-show="activeTab === 'general'" x-transition>
                @include('admin.settings.tabs.general')
            </div>

            <div x-show="activeTab === 'hero'" x-transition>
                @include('admin.settings.tabs.hero')
            </div>

            <div x-show="activeTab === 'sidebar'" x-transition>
                @include('admin.settings.tabs.sidebar')
            </div>

            <div x-show="activeTab === 'topbar'" x-transition>
                @include('admin.settings.tabs.topbar')
            </div>

            <div x-show="activeTab === 'points'" x-transition>
                @include('admin.settings.tabs.points')
            </div>

            <div x-show="activeTab === 'gamification'" x-transition>
                @include('admin.settings.tabs.gamification')
            </div>

            <div x-show="activeTab === 'payments'" x-transition>
                @include('admin.settings.tabs.payments')
            </div>

            <div x-show="activeTab === 'plugin'" x-transition>
                @include('admin.settings.tabs.plugin')
            </div>

            <div x-show="activeTab === 'products'" x-transition>
                @include('admin.settings.tabs.products')
            </div>

            <div x-show="activeTab === 'storage'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                @include('admin.settings.tabs.storage')
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
@endsection