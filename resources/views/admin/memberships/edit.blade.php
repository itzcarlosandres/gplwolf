@extends('layouts.admin')

@section('title', 'Gestionar Suscripción: ' . $membership->user->name)

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.memberships.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Gestionar Suscripción</h1>
        <p class="text-gray-400 mt-1">Usuario: <span class="text-white font-bold">{{ $membership->user->name }}</span> | Plan: <span class="text-[#FF2121] font-bold">{{ $membership->plan->name }}</span></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <form action="{{ route('admin.memberships.update', $membership) }}" method="POST" class="lg:col-span-2 space-y-8">
        @csrf
        @method('PUT')
        
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[32px] border border-white/5 shadow-2xl space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Estado de Membresía</label>
                    <select name="status" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                        <option value="active" {{ $membership->status === 'active' ? 'selected' : '' }}>Activa</option>
                        <option value="pending" {{ $membership->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="expired" {{ $membership->status === 'expired' ? 'selected' : '' }}>Expirada</option>
                        <option value="cancelled" {{ $membership->status === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        <option value="suspended" {{ $membership->status === 'suspended' ? 'selected' : '' }}>⚠️ Suspendida / Baneada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Fecha de Expiración</label>
                    <input type="datetime-local" name="expires_at" value="{{ $membership->expires_at ? $membership->expires_at->format('Y-m-d\TH:i') : '' }}" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                </div>
            </div>

            <div class="p-6 bg-[#FF2121]/5 rounded-3xl border border-[#FF2121]/10">
                <label class="block text-[10px] font-black text-[#FF2121] uppercase tracking-widest mb-3 ml-1">Descargas Extra (Manuales)</label>
                <div class="flex items-center gap-4">
                    <input type="number" name="extra_daily_downloads" value="{{ $membership->extra_daily_downloads }}" class="w-32 bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all text-center text-xl font-black">
                    <p class="text-xs text-gray-500 leading-relaxed font-medium">Estas descargas se sumarán al límite diario del plan. <br>Límite actual del plan: <strong class="text-white">{{ $membership->plan->daily_download_limit ?: 'Ilimitado' }}</strong></p>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Notas Administrativas (Internas)</label>
                <textarea name="admin_notes" rows="4" class="w-full bg-gray-950 border border-white/10 rounded-2xl p-5 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all resize-none" placeholder="Motivo de suspensión, cambios manuales, etc...">{{ $membership->admin_notes }}</textarea>
            </div>

            <button type="submit" class="w-full gradient-bg text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-[#F51B1B]/30 hover:opacity-90 transition-all transform active:scale-95 leading-none">
                Guardar Cambios <i class="fas fa-save ml-2"></i>
            </button>
        </div>
    </form>

    <div class="space-y-8">
        <!-- quick extension -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[32px] border border-white/5 shadow-2xl">
            <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6 flex items-center gap-2">
                <i class="fas fa-clock text-[#FF2121]"></i> Extender Tiempo
            </h3>
            <form action="{{ route('admin.memberships.extend', $membership) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <button type="submit" name="days" value="7" class="py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-black text-white uppercase tracking-widest transition-all">+7 Días</button>
                    <button type="submit" name="days" value="30" class="py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-black text-white uppercase tracking-widest transition-all">+30 Días</button>
                    <button type="submit" name="days" value="90" class="py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-black text-white uppercase tracking-widest transition-all">+90 Días</button>
                    <button type="submit" name="days" value="365" class="py-3 bg-[#F51B1B]/20 hover:bg-[#F51B1B]/30 border border-[#FF2121]/30 rounded-xl text-[10px] font-black text-[#FF2121] uppercase tracking-widest transition-all">+1 Año</button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[32px] border border-white/5 shadow-2xl">
            <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6">Información General</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500">Miembro desde</span>
                    <span class="text-white font-bold">{{ $membership->starts_at ? $membership->starts_at->format('d M, Y') : $membership->created_at->format('d M, Y') }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500">Descargas Totales</span>
                    <span class="text-emerald-400 font-black">{{ $membership->user->downloads->count() }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500">ID Usuario</span>
                    <span class="text-white font-mono">#{{ $membership->user->id }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection