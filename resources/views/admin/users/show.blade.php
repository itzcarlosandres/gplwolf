@extends('layouts.admin')

@section('title', 'Perfil de Usuario: ' . $user->name)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('admin.users.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">{{ $user->name }}</h1>
            <p class="text-gray-400 mt-1">Miembro desde {{ $user->created_at->format('M Y') }} • ID: #{{ $user->id }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="bg-[#F51B1B] hover:bg-[#FF2121] text-white px-6 py-2.5 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-[#F51B1B]/20">
            <i class="fas fa-user-edit mr-2"></i> Editar Perfil
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    <!-- Left: Stats & Info -->
    <div class="space-y-8">
        <!-- User Identity -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl text-center">
            <div class="relative inline-block mb-6">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=6366f1&color=fff&bold=true" class="w-32 h-32 rounded-3xl ring-4 ring-[#FF2121]/20 shadow-2xl">
                @if($user->role === 'admin')
                    <div class="absolute -top-2 -right-2 bg-[#FF2121] text-white px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-lg">ADMIN</div>
                @endif
            </div>
            <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
            <p class="text-sm text-gray-500 font-mono mb-6">{{ $user->email }}</p>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Órdenes</p>
                    <p class="text-xl font-bold text-white">{{ $user->orders->count() }}</p>
                </div>
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Descargas</p>
                    <p class="text-xl font-bold text-white">{{ $user->downloads->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Membership Info -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5 flex items-center gap-2">
                <i class="fas fa-crown text-amber-500"></i> Membresía Actual
            </h3>
            @forelse($user->memberships as $membership)
                <div class="bg-[#F51B1B]/10 border border-[#FF2121]/20 p-5 rounded-2xl mb-4">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-black text-[#FF2121] uppercase tracking-widest">{{ $membership->plan->name }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-emerald-500/20 text-emerald-400 border border-emerald-500/20">{{ $membership->status }}</span>
                    </div>
                    <p class="text-[10px] text-gray-500 font-medium">Expira: {{ $membership->expires_at ? $membership->expires_at->format('d/m/Y') : 'Nunca' }}</p>
                </div>
            @empty
                <div class="text-center py-6 opacity-30 italic text-sm text-gray-400">Sin membresía activa.</div>
            @endforelse
        </div>
    </div>

    <!-- Center/Right: Activity -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Recent Orders -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Historial de Compras</h3>
                <i class="fas fa-shopping-bag text-gray-600"></i>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-900/40 text-gray-500 text-[10px] uppercase font-bold tracking-widest border-b border-white/5">
                        <tr>
                            <th class="px-6 py-4">Orden</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Total</th>
                            <th class="px-6 py-4 text-right pr-10">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($user->orders as $order)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-[#FF2121] font-bold hover:text-[#FF2121]">#{{ $order->order_number }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded font-black text-[10px] uppercase {{ $order->status === 'completed' ? 'text-emerald-400 bg-emerald-500/10 border border-emerald-500/20' : 'text-amber-400 bg-amber-500/10 border border-amber-500/20' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-white font-mono font-bold">${{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4 text-right pr-10 text-gray-500 text-xs">{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-600 italic">No se han realizado compras.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Downloads History -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Actividad de Descargas</h3>
                <i class="fas fa-cloud-download-alt text-gray-600"></i>
            </div>
            <div class="space-y-4 p-6">
                @forelse($user->downloads->take(10) as $download)
                    <div class="flex items-center justify-between p-4 bg-gray-900/30 rounded-2xl border border-white/5 group hover:bg-gray-900/50 transition-all">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-[#FF2121]/10 rounded-xl flex items-center justify-center text-[#FF2121] mr-4">
                                <i class="fas fa-file-archive"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold">{{ $download->product->name ?? 'Producto Eliminado' }}</p>
                                <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">IP: {{ $download->ip_address }}</p>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-600 font-bold">{{ optional($download->created_at)->diffForHumans() ?? 'N/A' }}</p>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-600 italic text-sm">Sin descargas registradas.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection