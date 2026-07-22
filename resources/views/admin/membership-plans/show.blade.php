@extends('layouts.admin')

@section('title', 'Plan: ' . $membershipPlan->name)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('admin.membership-plans.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">{{ $membershipPlan->name }}</h1>
            <p class="text-gray-400 mt-1">Slug: {{ $membershipPlan->slug }} • Plan {{ ucfirst($membershipPlan->duration) }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.membership-plans.edit', $membershipPlan) }}" class="bg-[#F51B1B] hover:bg-[#FF2121] text-white px-6 py-2.5 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-[#F51B1B]/20">
            <i class="fas fa-edit mr-2"></i> Editar Plan
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    <!-- Left: Plan Details -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Overview -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="bg-[#FF2121]/20 p-2 rounded-lg"><i class="fas fa-crown text-[#FF2121] text-sm"></i></div>
                    Configuración del Plan
                </h2>
                <div class="flex gap-2">
                    @if($membershipPlan->is_featured)
                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-amber-500/10 text-amber-500 border border-amber-500/20">Destacado</span>
                    @endif
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $membershipPlan->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20' }}">
                        {{ $membershipPlan->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            
            <div class="space-y-6">
                <div>
                    <h4 class="text-xs font-black text-white uppercase tracking-widest mb-3 opacity-60">Descripción</h4>
                    <p class="text-gray-300 leading-relaxed">{{ $membershipPlan->description ?? 'Sin descripción.' }}</p>
                </div>
                
                <div>
                    <h4 class="text-xs font-black text-white uppercase tracking-widest mb-4 opacity-60">Beneficios Incluidos</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($membershipPlan->benefits ?? [] as $benefit)
                            <div class="flex items-center p-4 bg-gray-900/50 rounded-2xl border border-white/5 group hover:border-[#FF2121]/30 transition-all">
                                <div class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-400 mr-3 text-xs">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-sm text-gray-300 group-hover:text-white transition-colors">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscribers List -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Suscriptores del Plan</h3>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $membershipPlan->memberships->count() }} usuarios</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-900/40 text-gray-500 text-[10px] uppercase font-bold tracking-widest border-b border-white/5">
                        <tr>
                            <th class="px-8 py-4">Usuario</th>
                            <th class="px-8 py-4 text-center">Status</th>
                            <th class="px-8 py-4 text-right pr-10">Expira</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm font-medium">
                        @forelse($membershipPlan->memberships as $membership)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($membership->user->name) }}&background=6366f1&color=fff&bold=true" class="w-8 h-8 rounded-lg mr-3">
                                        <a href="{{ route('admin.users.show', $membership->user) }}" class="text-white hover:text-[#FF2121] transition-colors">{{ $membership->user->name }}</a>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest {{ $membership->status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20' }}">
                                        {{ $membership->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right pr-10 text-gray-500 text-xs">
                                    {{ $membership->expires_at ? $membership->expires_at->format('d/m/Y') : 'Lifetime' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-10 text-center text-gray-600 italic">No hay suscriptores aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Pricing & Stats -->
    <div class="space-y-8">
        <!-- Pricing Card -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#FF2121]/10 blur-[60px] rounded-full group-hover:bg-[#FF2121]/20 transition-all"></div>
            
            <div class="text-center mb-8 relative">
                <div class="text-[10px] font-black text-[#FF2121] uppercase tracking-[0.2em] mb-2">Inversión del Usuario</div>
                <div class="text-5xl font-black text-white tracking-tighter">
                    <span class="text-2xl text-[#FF2121] mr-1">$</span>{{ number_format($membershipPlan->price, 2) }}
                </div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-[0.3em] mt-3">Por {{ $membershipPlan->duration }}</p>
            </div>
            
            <div class="space-y-4 pt-6 border-t border-white/5">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Duración en días:</span>
                    <span class="text-xs font-black text-white px-2 py-1 bg-gray-900 rounded-lg border border-white/5">{{ $membershipPlan->duration_days }}</span>
                </div>
            </div>
        </div>

        <!-- Popularity Stats -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5">Métricas del Plan</h3>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#FF2121]/10 rounded-xl flex items-center justify-center text-[#FF2121]">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-white">{{ number_format($membershipPlan->memberships->count()) }}</p>
                            <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Total Usuarios</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-white">${{ number_format($membershipPlan->memberships->count() * $membershipPlan->price, 2) }}</p>
                            <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Ingresos Generados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection