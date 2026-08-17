@extends('layouts.user')

@section('title', 'Sitios Conectados')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ showModal: false, activeSite: null }">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Sitios Conectados</h1>
            <p class="text-gray-400 mt-2">Gestiona las licencias de tu membresía en tus sitios web.</p>
        </div>
        <div class="flex flex-wrap items-center gap-4">
            <a href="{{ route('pages.plugin.download') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-white rounded-xl font-bold transition-all border border-white/5 shadow-lg" download>
                <i class="fas fa-download text-emerald-400"></i> Descargar Plugin Oficial
            </a>
            
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
    </div>

    @if(auth()->user()->activeMembership || auth()->user()->isAdmin())
    <!-- Add Site Form -->
    <div class="bg-gray-800/20 border border-white/5 rounded-3xl p-6 mb-6">
        <h3 class="text-lg font-bold text-white mb-1">Conectar Nuevo Sitio Manualmente</h3>
        <p class="text-xs text-gray-400 mb-4">Ingresa la URL completa de tu sitio de WordPress para autorizarlo e instalar el plugin oficial.</p>
        
        <form action="{{ route('user.sites.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="url" 
                   name="domain" 
                   value="{{ old('domain') }}" 
                   placeholder="https://miblogwordpress.com" 
                   class="bg-gray-900/50 border border-white/10 rounded-2xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#FF2121]/50 focus:ring-1 focus:ring-[#FF2121]/50 flex-1 transition-all" 
                   required>
            <button type="submit" class="px-6 py-3 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-2xl font-bold text-sm transition-all shadow-lg hover:shadow-[#FF2121]/20 flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="fas fa-plus"></i> Conectar Sitio
            </button>
        </form>
        @if(session('error'))
            <p class="text-rose-400 text-xs font-semibold mt-2"><i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}</p>
        @endif
        @if($errors->has('domain'))
            <p class="text-rose-400 text-xs font-semibold mt-2"><i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('domain') }}</p>
        @endif
    </div>
    @endif
    @php
        $latestVersion = \App\Models\Setting::getPluginLatestVersion();
        $hasOutdatedSites = auth()->user()->connectedSites->contains(function($site) use ($latestVersion) {
            return !empty($site->plugin_version) && version_compare($site->plugin_version, $latestVersion, '<');
        });
    @endphp

    @if($hasOutdatedSites)
    <!-- Banner de actualización pendiente -->
    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/20 rounded-3xl p-6 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center flex-shrink-0 text-amber-500 text-xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <h4 class="text-base font-bold text-white mb-1">¡Actualización del Plugin Recomendada!</h4>
                <p class="text-gray-300 text-xs">Uno o más de tus sitios web de WordPress tienen una versión desactualizada del plugin conector. Descarga la última versión para garantizar la compatibilidad y el rendimiento.</p>
            </div>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('pages.plugin.download') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-black rounded-xl font-bold transition-all shadow-lg shadow-amber-500/10 text-sm" download>
                <i class="fas fa-download"></i> Descargar v{{ $latestVersion }}
            </a>
        </div>
    </div>
    @endif

    <!-- Sites List -->
    <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden">
        @if(auth()->user()->connectedSites->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/[0.02]">
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">Dominio / Sitio</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">Versión Plugin</th>
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
                                @php
                                    $siteVer = $site->plugin_version;
                                @endphp
                                @if(empty($siteVer))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-white/5 text-gray-400 border border-white/10">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                        Desconocida
                                    </span>
                                @elseif(version_compare($siteVer, $latestVersion, '<'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20" title="Actualización pendiente a v{{ $latestVersion }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        v{{ $siteVer }} (Pendiente v{{ $latestVersion }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        v{{ $siteVer }} (Al día)
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-white font-medium text-sm">{{ $site->connected_at->format('M d, Y') }}</span>
                                    <span class="text-xs text-gray-500">{{ $site->connected_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="activeSite = { id: {{ $site->id }}, domain: '{{ parse_url($site->domain, PHP_URL_HOST) ?? $site->domain }}', url: '{{ $site->domain }}', plugin_version: '{{ $site->plugin_version }}', resources: {{ json_encode($site->installed_resources ?? []) }} }; showModal = true;" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all text-xs font-bold uppercase tracking-wide border border-emerald-500/20 cursor-pointer border-none">
                                        <i class="fas fa-tasks"></i> Gestionar
                                    </button>
                                    
                                    <form action="{{ route('user.sites.destroy', $site) }}" method="POST" onsubmit="return confirm('¿Estás seguro? Al desconectar este sitio, el plugin dejará de funcionar en él.')" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition-all text-xs font-bold uppercase tracking-wide border border-rose-500/20 cursor-pointer">
                                            <i class="fas fa-unlink"></i> Desconectar
                                        </button>
                                    </form>
                                </div>
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
                    <a href="{{ route('pages.plugin.download') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-[#FF2121]/25" download>
                        <i class="fas fa-download"></i> Descargar Plugin
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Remote Resources Management Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showModal" style="display: none;" x-cloak>
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

        <!-- Modal Wrapper -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-[#0a0a0a] border border-white/10 rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl transition-all duration-300" @click.away="showModal = false" x-transition>
                <!-- Glow effect -->
                <div class="absolute top-0 left-0 w-full h-full bg-[#FF2121]/5 blur-3xl pointer-events-none"></div>

                <!-- Header -->
                <div class="p-6 border-b border-white/5 flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <i class="fas fa-server"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white" x-text="'Sitio: ' + (activeSite ? activeSite.domain : '')"></h3>
                            <p class="text-xs text-gray-500 font-medium" x-text="'Versión del conector: ' + (activeSite && activeSite.plugin_version ? 'v' + activeSite.plugin_version : 'Desconocida')"></p>
                        </div>
                    </div>
                    <button @click="showModal = false" class="text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 w-8 h-8 rounded-full flex items-center justify-center transition-all border-none cursor-pointer">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 relative z-10 max-h-[60vh] overflow-y-auto custom-scrollbar">
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Recursos de GPLWolf Instalados</h4>

                    <!-- Empty state -->
                    <div x-show="!activeSite || !activeSite.resources || Object.keys(activeSite.resources).length === 0" class="py-12 text-center bg-white/[0.01] border border-dashed border-white/10 rounded-2xl">
                        <i class="fas fa-box-open text-gray-700 text-3xl mb-3"></i>
                        <p class="text-gray-400 font-bold text-sm">No hay recursos de GPLWolf instalados en este sitio aún.</p>
                        <p class="text-gray-500 text-xs mt-1 font-medium">Los plugins o temas que instales a través del conector en este sitio aparecerán listados aquí automáticamente.</p>
                    </div>

                    <!-- Resources List -->
                    <div x-show="activeSite && activeSite.resources && Object.keys(activeSite.resources).length > 0" class="space-y-3">
                        <div class="overflow-hidden border border-white/5 rounded-2xl">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-white/5 bg-white/[0.02]">
                                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-wider">Recurso</th>
                                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-wider">Tipo</th>
                                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-wider">Instalado el</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    <template x-if="activeSite && activeSite.resources">
                                        <template x-for="(info, slug) in activeSite.resources" :key="slug">
                                            <tr class="hover:bg-white/[0.01] transition-colors">
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center gap-2">
                                                        <i class="fas text-gray-400 text-xs" :class="info.type === 'theme' ? 'fa-palette' : 'fa-plug'"></i>
                                                        <span class="text-white text-xs font-bold font-mono" x-text="slug"></span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider" 
                                                          :class="info.type === 'theme' ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'bg-red-500/10 text-red-400 border border-red-500/20'" 
                                                          x-text="info.type === 'theme' ? 'Tema' : 'Plugin'"></span>
                                                </td>
                                                <td class="px-4 py-3 text-gray-500 text-xs font-medium" x-text="new Date(info.installed_at * 1000).toLocaleDateString('es-ES', {year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute:'2-digit'})">
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection