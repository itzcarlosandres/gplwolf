@extends('layouts.user')

@section('title', 'Sitios Conectados')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Sitios Conectados</h1>
            <p class="text-gray-400 mt-2">Gestiona las licencias de tu membresía en tus sitios web.</p>
        </div>
        <div class="bg-[#F51B1B]/10 border border-[#FF2121]/20 rounded-xl px-4 py-3 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#FF2121]/20 flex items-center justify-center">
                <i class="fab fa-wordpress text-[#FF2121] text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-[#FF2121] font-bold uppercase tracking-wider">Límite de Sitios</p>
                <div class="flex items-end gap-1">
                    <span class="text-xl font-black text-white">{{ auth()->user()->connectedSites()->count() }}</span>
                    <span class="text-sm text-gray-400 font-bold mb-0.5">/ 
                        @php
                            $limit = auth()->user()->activeMembership?->plan?->sites_limit ?? 1;
                        @endphp
                        {{ $limit == 0 ? '∞' : $limit }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sites List -->
    <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden">
        @if(auth()->user()->connectedSites->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/[0.02]">
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">Dominio / Sitio</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">Fecha Conexión</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach(auth()->user()->connectedSites as $site)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-check-circle text-emerald-500"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-base">{{ parse_url($site->domain, PHP_URL_HOST) ?? $site->domain }}</div>
                                        <div class="text-xs text-gray-500 font-mono mt-0.5 truncate max-w-[200px]">{{ $site->domain }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-white font-medium text-sm">{{ $site->connected_at->format('M d, Y') }}</span>
                                    <span class="text-xs text-gray-500">{{ $site->connected_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <form action="{{ route('user.sites.destroy', $site) }}" method="POST" onsubmit="return confirm('¿Estás seguro? Al desconectar este sitio, el plugin dejará de funcionar en él.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition-all text-xs font-bold uppercase tracking-wide border border-rose-500/20">
                                        <i class="fas fa-unlink"></i> Desconectar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-20 text-center">
                <div class="w-20 h-20 bg-gray-700/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-globe text-3xl text-gray-600"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No tienes sitios conectados</h3>
                <p class="text-gray-400 max-w-md mx-auto">Instala nuestro plugin de WordPress en tu sitio para conectar tu licencia y descargar recursos directamente.</p>
                <div class="mt-8">
                    <a href="{{ url('marketplace-connect.zip') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-[#FF2121]/25" download>
                        <i class="fas fa-download"></i> Descargar Plugin
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection