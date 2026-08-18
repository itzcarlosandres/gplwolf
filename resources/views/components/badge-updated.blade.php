@props(['size' => 'sm', 'class' => ''])

@php
    $sizeClasses = match($size) {
        'xs' => 'px-1.5 py-0.5 text-[7.5px] gap-1 rounded',
        'md' => 'px-2.5 py-1 text-[9.5px] gap-1.5 rounded-lg',
        'lg' => 'px-3.5 py-1.5 text-xs gap-2 rounded-xl',
        default => 'px-2 py-0.5 text-[8.5px] gap-1.5 rounded-lg',
    };

    $iconSize = match($size) {
        'xs' => 'text-[7px]',
        'md' => 'text-[9px]',
        'lg' => 'text-[11px]',
        default => 'text-[8px]',
    };
@endphp

<span class="relative inline-flex items-center font-black uppercase tracking-wider text-white bg-gradient-to-r from-[#FF2121] via-[#F51B1B] to-[#FF3B3B] border border-red-400/40 shadow-md shadow-[#FF2121]/30 overflow-hidden select-none leading-none {{ $sizeClasses }} {{ $class }}">
    <!-- Shimmer Light Sweep Effect -->
    <span class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/35 to-transparent animate-shimmer-sweep pointer-events-none"></span>

    <!-- Animated Rotating Sync Icon -->
    <i class="fas fa-sync-alt {{ $iconSize }} animate-spin-slow text-white drop-shadow-sm flex-shrink-0"></i>

    <!-- Text -->
    <span class="drop-shadow-sm font-black whitespace-nowrap">Actualizado</span>
</span>
