@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-10 pb-20">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-white leading-tight">Hola, {{ explode(' ', $user->name)[0] }} 👋</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Bienvenido de nuevo a tu panel de control.</p>
        </div>
        
        <div class="flex items-center gap-4">
            <!-- Points Card -->
            <div class="bg-amber-500/10 border border-amber-500/20 px-6 py-4 rounded-3xl flex items-center gap-4 group hover:bg-amber-500/20 transition-all">
                <div class="w-10 h-10 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-600/40">
                    <i class="fas fa-coins text-lg"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-amber-500 uppercase tracking-widest mb-0.5">Mis Puntos</p>
                    <h4 class="text-lg font-black text-white leading-none">{{ number_format($user->points) }}</h4>
                </div>
            </div>

            @if($activeMembership)
            <div class="bg-[#F51B1B]/10 border border-[#FF2121]/20 px-6 py-4 rounded-3xl flex items-center gap-4 group hover:bg-[#F51B1B]/20 transition-all">
                <div class="w-10 h-10 gradient-bg rounded-2xl flex items-center justify-center text-white shadow-lg shadow-[#F51B1B]/40">
                    <i class="fas fa-crown text-lg"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-[#FF2121] uppercase tracking-widest mb-0.5">Plan {{ $activeMembership->plan->name }}</p>
                    <h4 class="text-lg font-black text-white leading-none">
                        @if($activeMembership->expires_at)
                            {{ round(now()->diffInDays($activeMembership->expires_at)) }} días restantes
                        @else
                            X Vida
                        @endif
                    </h4>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-[32px] border-white/5 relative overflow-hidden group">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Total Compras</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-black text-white">{{ $user->orders->count() }}</h3>
                <div class="text-[#FF2121] font-black text-[9px] uppercase tracking-widest">Pedidos</div>
            </div>
        </div>
        <div class="glass p-6 rounded-[32px] border-white/5 relative overflow-hidden group">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Descargas Totales</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-black text-white">{{ $user->downloads->count() }}</h3>
                <div class="text-emerald-500 font-black text-[9px] uppercase tracking-widest">Archivos</div>
            </div>
        </div>
        @if($activeMembership)
        <div class="glass p-6 rounded-[32px] border-white/5 relative overflow-hidden group">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Descargas Restantes Hoy</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-black text-white">{{ $user->remainingDownloads() }}</h3>
                <div class="text-[#FF2121] font-black text-[9px] uppercase tracking-widest">Límite: {{ $activeMembership->plan->daily_download_limit ?: '∞' }}</div>
            </div>
        </div>
        @endif
        <div class="glass p-6 rounded-[32px] border-white/5 relative overflow-hidden group">
            <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Inversión Total</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-black text-white">${{ number_format($user->orders->sum('total'), 0) }}</h3>
                <div class="text-amber-500 font-black text-[9px] uppercase tracking-widest">Gastado</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-black text-white">Pedidos Recientes</h3>
                <a href="#" class="text-[10px] font-black text-gray-500 uppercase tracking-widest hover:text-white transition">Ver todos <i class="fas fa-arrow-right ml-2 text-[8px]"></i></a>
            </div>
            
            <div class="glass rounded-[40px] border-white/5 overflow-hidden">
                @forelse($recentOrders as $order)
                <div class="p-8 flex items-center justify-between hover:bg-white/[0.02] transition-colors border-b border-white/5 last:border-0 group">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-gray-900 rounded-2xl flex items-center justify-center text-gray-400 group-hover:text-[#FF2121] transition-colors border border-white/5 shadow-inner">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold">Pedido #{{ substr($order->id, 0, 8) }}</h4>
                            <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">{{ $order->created_at->format('d M, Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-white font-black text-lg mb-1">${{ number_format($order->total, 2) }}</div>
                        <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest border {{ $order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-20 text-center opacity-20">
                    <i class="fas fa-shopping-bag text-5xl mb-4"></i>
                    <p class="text-sm font-black uppercase tracking-widest">Aún no has realizado compras</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Downloads -->
        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-black text-white">Descargas</h3>
                <a href="#" class="text-[10px] font-black text-gray-500 uppercase tracking-widest hover:text-white transition">Historial <i class="fas fa-arrow-right ml-2 text-[8px]"></i></a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentDownloads as $download)
                <div class="glass p-6 rounded-[32px] border-white/5 group hover:bg-white/5 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-900 rounded-xl flex-shrink-0 border border-white/5 flex items-center justify-center text-lg shadow-inner overflow-hidden">
                            @if($download->product->thumbnail)
                            <img src="{{ asset('storage/' . $download->product->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-box text-gray-700"></i>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h5 class="text-xs font-black text-white uppercase truncate group-hover:text-[#FF2121] transition-colors">{{ $download->product->name }}</h5>
                            <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest mt-1">v{{ $download->product->version }}</p>
                        </div>
                        <a href="{{ asset('storage/' . $download->product->product_file) }}" download class="w-10 h-10 bg-[#FF2121]/10 hover:bg-[#F51B1B] text-[#FF2121] hover:text-white rounded-xl flex items-center justify-center transition-all shadow-lg active:scale-95">
                            <i class="fas fa-download text-xs"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="glass p-12 rounded-[32px] border-white/5 text-center opacity-20 border-dashed">
                    <i class="fas fa-cloud-download-alt text-4xl mb-3"></i>
                    <p class="text-[10px] font-black uppercase tracking-widest">Sin descargas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection