@extends('layouts.user')

@section('title', 'Mi Panel - GPLWolf')

@section('content')
<div class="space-y-8 pb-20 text-white">
    <!-- Welcome Header -->
    <div class="relative overflow-hidden rounded-[36px] border border-white/5 bg-gradient-to-r from-red-600/10 via-pink-600/5 to-transparent p-8 md:p-10 flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-2xl">
        <div class="absolute -right-24 -top-24 w-80 h-80 bg-red-600/10 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="space-y-2">
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-none">
                ¡Hola, <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-pink-500 to-amber-400">{{ explode(' ', $user->name)[0] }}</span>! 👋
            </h1>
            <p class="text-gray-400 text-sm md:text-base font-medium">Bienvenido de nuevo. Aquí tienes el resumen de tu cuenta y descargas de hoy.</p>
        </div>
        
        <!-- Live status widget -->
        <div class="flex flex-wrap items-center gap-4">
            <!-- Points Card -->
            <a href="{{ route('user.rewards') }}" class="bg-amber-500/10 border border-amber-500/20 px-6 py-3.5 rounded-2xl flex items-center gap-4 hover:bg-amber-500/20 transition-all duration-300">
                <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-amber-600/40 animate-pulse">
                    <i class="fas fa-coins text-base"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-amber-400 uppercase tracking-widest mb-0.5">Mis Puntos</p>
                    <h4 class="text-base font-black text-white leading-none">{{ number_format($user->points) }}</h4>
                </div>
            </a>

            <!-- Membership Card -->
            @if($activeMembership)
            <a href="{{ route('membership.pricing') }}" class="bg-[#F51B1B]/10 border border-[#FF2121]/20 px-6 py-3.5 rounded-2xl flex items-center gap-4 hover:bg-[#F51B1B]/20 transition-all duration-300">
                <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-amber-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-600/40">
                    <i class="fas fa-crown text-base"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-red-400 uppercase tracking-widest mb-0.5">Plan {{ $activeMembership->plan->name }}</p>
                    <h4 class="text-base font-black text-white leading-none">
                        @if($activeMembership->expires_at)
                            {{ round(now()->diffInDays($activeMembership->expires_at)) }} días
                        @else
                            De por Vida
                        @endif
                    </h4>
                </div>
            </a>
            @else
            <a href="{{ route('membership.pricing') }}" class="bg-white/5 border border-white/10 px-6 py-3.5 rounded-2xl flex items-center gap-4 hover:bg-white/10 transition-all duration-300">
                <div class="w-10 h-10 bg-gray-700 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-crown text-base"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Membresía</p>
                    <h4 class="text-xs font-black text-[#FF2121] uppercase tracking-wider leading-none">Activar Club</h4>
                </div>
            </a>
            @endif
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-[28px] border border-white/5 relative overflow-hidden group hover:border-[#FF2121]/30 transition-all duration-300">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Total Compras</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-black text-white">{{ $user->orders->count() }}</h3>
                <span class="px-2 py-0.5 rounded bg-[#FF2121]/15 text-[#FF2121] text-[8px] font-black uppercase tracking-wider">Pedidos</span>
            </div>
        </div>
        
        <div class="glass p-6 rounded-[28px] border border-white/5 relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-300">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Descargas Totales</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-black text-white">{{ $user->downloads->count() }}</h3>
                <span class="px-2 py-0.5 rounded bg-emerald-500/15 text-emerald-400 text-[8px] font-black uppercase tracking-wider">Archivos</span>
            </div>
        </div>

        <div class="glass p-6 rounded-[28px] border border-white/5 relative overflow-hidden group hover:border-blue-500/30 transition-all duration-300">
            @if($activeMembership)
                <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Límite Diario Hoy</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-black text-white">{{ $user->remainingDownloads() }}</h3>
                    <span class="px-2 py-0.5 rounded bg-blue-500/15 text-blue-400 text-[8px] font-black uppercase tracking-wider">Cupo: {{ $activeMembership->plan->daily_download_limit ?: '∞' }}</span>
                </div>
            @else
                <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Límite Diario Hoy</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-3xl font-black text-white">0</h3>
                    <span class="px-2 py-0.5 rounded bg-gray-500/15 text-gray-400 text-[8px] font-black uppercase tracking-wider">Sin Plan</span>
                </div>
            @endif
        </div>
        
        <div class="glass p-6 rounded-[28px] border border-white/5 relative overflow-hidden group hover:border-amber-500/30 transition-all duration-300">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Inversión Total</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-black text-white">${{ number_format($user->orders->sum('total'), 2) }}</h3>
                <span class="px-2 py-0.5 rounded bg-amber-500/15 text-amber-400 text-[8px] font-black uppercase tracking-wider">Gastado</span>
            </div>
        </div>
    </div>

    <!-- Lists Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-black text-white">Pedidos Recientes</h3>
                <a href="{{ route('user.orders') }}" class="text-[10px] font-black text-gray-500 uppercase tracking-widest hover:text-white transition flex items-center gap-1.5">
                    Ver todos <i class="fas fa-arrow-right text-[8px]"></i>
                </a>
            </div>
            
            <div class="glass rounded-[32px] border border-white/10 overflow-hidden shadow-2xl">
                @forelse($recentOrders as $order)
                    <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-white/[0.02] transition-colors border-b border-white/5 last:border-0 group">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center text-gray-400 group-hover:text-[#FF2121] transition-colors border border-white/5 shadow-inner flex-shrink-0">
                                <i class="fas fa-file-invoice text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-bold">Pedido #{{ $order->order_number ?? substr($order->id, 0, 8) }}</h4>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">{{ $order->created_at->format('d M, Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="w-full sm:w-auto flex items-center justify-between sm:justify-end gap-6 sm:text-right">
                            <div>
                                <div class="text-white font-black text-base mb-1">${{ number_format($order->total, 2) }}</div>
                                @if($order->status === 'completed')
                                    <span class="px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        Completado
                                    </span>
                                @elseif($order->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">
                                        Pendiente
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20">
                                        Cancelado
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('user.orders.show', $order) }}" class="w-9 h-9 bg-white/5 border border-white/5 hover:border-white/20 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center opacity-40">
                        <i class="fas fa-shopping-bag text-5xl mb-4"></i>
                        <p class="text-sm font-black uppercase tracking-widest">Aún no has realizado compras</p>
                        <p class="text-xs text-gray-500 mt-2 font-medium">Tus pedidos recientes aparecerán aquí una vez realices un checkout.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Downloads (1/3 width) -->
        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-black text-white">Últimas Descargas</h3>
                <a href="{{ route('user.downloads') }}" class="text-[10px] font-black text-gray-500 uppercase tracking-widest hover:text-white transition flex items-center gap-1.5">
                    Descargas <i class="fas fa-arrow-right text-[8px]"></i>
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentDownloads as $download)
                    <div class="glass p-5 rounded-[28px] border border-white/5 group hover:border-[#FF2121]/30 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 bg-gray-900 rounded-xl flex-shrink-0 border border-white/5 flex items-center justify-center text-lg shadow-inner overflow-hidden">
                                @if($download->product->thumbnail)
                                    <img src="{{ asset('storage/' . $download->product->thumbnail) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-red-600/10 flex items-center justify-center text-red-500">
                                        <i class="fas fa-cube text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h5 class="text-xs font-black text-white uppercase truncate group-hover:text-[#FF2121] transition-colors" title="{{ $download->product->name }}">
                                    {{ $download->product->name }}
                                </h5>
                                <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest mt-1">v{{ $download->product->version }}</p>
                            </div>
                            
                            <a href="{{ route('product.download', $download->product) }}" class="w-9 h-9 bg-[#FF2121]/10 hover:bg-[#F51B1B] text-[#FF2121] hover:text-white rounded-xl flex items-center justify-center transition-all shadow-md active:scale-95 flex-shrink-0" title="Descargar de nuevo">
                                <i class="fas fa-download text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="glass p-12 rounded-[28px] border border-white/5 text-center opacity-40 border-dashed flex flex-col items-center justify-center gap-3">
                        <i class="fas fa-cloud-download-alt text-4xl text-gray-600 mb-1"></i>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Sin descargas recientes</p>
                        <p class="text-[9px] text-gray-500 leading-normal">Aquí se mostrarán los archivos premium que hayas descargado en la plataforma.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection