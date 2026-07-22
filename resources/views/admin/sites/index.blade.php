@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Control de Dominios</h1>
            <p class="text-gray-400 text-sm mt-1">Gestión de sitios donde tus plugins están instalados.</p>
        </div>
        
        <div class="relative">
            <form action="{{ route('admin.sites.index') }}" method="GET">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Buscar dominio o cliente..." 
                       class="bg-[#0c0c0c] border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm w-64 focus:outline-none focus:border-[#FF2121]/50 focus:ring-1 focus:ring-[#FF2121]/50 transition-all text-white placeholder-gray-500">
            </form>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-[#0c0c0c]/50 backdrop-blur-xl border border-white/5 p-5 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-[#FF2121]/5 group-hover:bg-[#FF2121]/10 transition-colors"></div>
            <div class="relative z-10">
                <p class="text-[#FF2121] text-xs font-bold uppercase tracking-wider mb-1">Total Conectados</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-white">{{ $totalSites }}</h3>
                    <span class="text-xs text-white/50">sitios activos</span>
                </div>
            </div>
            <div class="absolute -right-2 -bottom-4 text-[#FF2121]/10 text-6xl">
                <i class="fas fa-globe"></i>
            </div>
        </div>

        <div class="bg-[#0c0c0c]/50 backdrop-blur-xl border border-white/5 p-5 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-[#F51B1B]/5 group-hover:bg-[#F51B1B]/10 transition-colors"></div>
            <div class="relative z-10">
                <p class="text-[#F51B1B] text-xs font-bold uppercase tracking-wider mb-1">Dominios Únicos</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-white">{{ $uniqueDomains }}</h3>
                    <span class="text-xs text-white/50">instalaciones</span>
                </div>
            </div>
            <div class="absolute -right-2 -bottom-4 text-[#F51B1B]/10 text-6xl">
                <i class="fas fa-network-wired"></i>
            </div>
        </div>

        <div class="bg-[#0c0c0c]/50 backdrop-blur-xl border border-white/5 p-5 rounded-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="relative z-10">
                <p class="text-emerald-400 text-xs font-bold uppercase tracking-wider mb-1">Nuevos este mes</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-white">+{{ $sitesThisMonth }}</h3>
                    <span class="text-xs text-white/50">últimos 30 días</span>
                </div>
            </div>
            <div class="absolute -right-2 -bottom-4 text-emerald-500/10 text-6xl">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-[#0c0c0c] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-400">
                <thead class="bg-white/5 text-xs uppercase font-bold text-white/70">
                    <tr>
                        <th class="px-6 py-4">Dominio</th>
                        <th class="px-6 py-4">Cliente / Usuario</th>
                        <th class="px-6 py-4">Fecha de Conexión</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($sites as $site)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <a href="https://{{ $site->domain }}" target="_blank" class="flex items-center gap-3 group/link">
                                <div class="w-8 h-8 rounded-lg bg-[#FF2121]/10 flex items-center justify-center text-[#FF2121] group-hover/link:bg-[#FF2121] group-hover/link:text-white transition-all">
                                    <i class="fas fa-globe text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-white group-hover/link:text-[#FF2121] transition-colors">{{ $site->domain }}</div>
                                    <div class="text-xs text-gray-500">Ver sitio <i class="fas fa-external-link-alt text-[10px] ml-1 opacity-0 group-hover/link:opacity-100"></i></div>
                                </div>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            @if($site->user)
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($site->user->name) }}&background=random&color=fff&size=32" class="w-6 h-6 rounded-full">
                                    <div>
                                        <div class="text-white text-sm">{{ $site->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $site->user->email }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-red-400 italic">Usuario eliminado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-300">
                                {{ $site->created_at->format('d M, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $site->created_at->format('h:i A') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($site->is_banned)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    <i class="fas fa-ban mr-1.5 text-[10px]"></i>
                                    Baneado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
                                    Conectado
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                           <div class="flex items-center justify-end gap-2">
                               <form action="{{ route('admin.sites.ban', $site->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ $site->is_banned ? '¿Desbanear dominio?' : '¿BANEAR dominio? Esto impedirá que reciba actualizaciones.' }}');">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-lg {{ $site->is_banned ? 'bg-amber-500/10 text-amber-400 hover:bg-amber-500' : 'bg-gray-700/50 text-gray-400 hover:bg-rose-500 hover:text-white' }} hover:text-white transition-all text-xs group/ban" title="{{ $site->is_banned ? 'Quitar Ban' : 'Banear Dominio' }}">
                                        <i class="fas {{ $site->is_banned ? 'fa-undo' : 'fa-ban' }}"></i>
                                    </button>
                               </form>

                               <form action="{{ route('admin.sites.destroy', $site->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de desconectar este dominio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-500/10 text-rose-400 hover:text-white hover:bg-rose-500 transition-all text-xs group/btn" title="Desconectar Dominio">
                                        <i class="fas fa-unlink group-hover/btn:rotate-45 transition-transform"></i>
                                    </button>
                               </form>
                           </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-globe text-2xl text-white/20"></i>
                                </div>
                                <p class="text-lg font-medium text-white/50">No hay dominios conectados aún</p>
                                <p class="text-sm mt-1">Los sitios aparecerán aquí cuando los usuarios conecten sus productos.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($sites->hasPages())
           <div class="px-6 py-4 border-t border-white/5 bg-white/[0.01]">
               {{ $sites->links() }}
           </div>
        @endif
    </div>
</div>
@endsection