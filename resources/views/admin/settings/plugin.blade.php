@extends('layouts.admin')

@section('title', 'Configuración del Plugin WordPress')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white tracking-tight">Plugin de WordPress</h1>
        <p class="text-gray-400 mt-2">Configura el plugin de conexión y la funcionalidad de Domain Locking</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-sm font-bold flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-sm font-bold flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.plugin.update') }}" method="POST">
        @csrf
        
        <!-- Estado del Plugin -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 p-8 mb-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 bg-[#FF2121]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fab fa-wordpress text-[#FF2121] text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-white mb-2">Estado del Plugin</h2>
                    <p class="text-gray-400 text-sm">Habilita o deshabilita la funcionalidad del plugin de WordPress</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Habilitar Plugin -->
                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                    <div>
                        <label class="text-white font-bold text-sm block mb-1">Habilitar Plugin de WordPress</label>
                        <p class="text-gray-500 text-xs">Permite que los usuarios conecten sus sitios WordPress mediante el plugin</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="plugin_enabled" class="sr-only peer" {{ ($settings['plugin_enabled'] ?? 0) ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#F51B1B] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#F51B1B]"></div>
                    </label>
                </div>

                <!-- Mostrar en Menú de Usuario -->
                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                    <div>
                        <label class="text-white font-bold text-sm block mb-1">Mostrar "Sitios Conectados" en Menú</label>
                        <p class="text-gray-500 text-xs">Muestra u oculta la sección "Sitios Conectados" en el panel de usuario</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="plugin_show_menu" class="sr-only peer" {{ ($settings['plugin_show_menu'] ?? 0) ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#F51B1B] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#F51B1B]"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Configuración de Límites -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 p-8 mb-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-amber-400 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-white mb-2">Domain Locking</h2>
                    <p class="text-gray-400 text-sm">Configura los límites de sitios conectados por usuario</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-white mb-2">
                        Límite de Sitios por Usuario
                        <span class="text-gray-500 font-normal">(Predeterminado)</span>
                    </label>
                    <input type="number" 
                           name="plugin_site_limit" 
                           value="{{ $settings['plugin_site_limit'] ?? 5 }}" 
                           min="1" 
                           max="100"
                           class="w-full px-4 py-3 bg-gray-900 border border-white/10 rounded-xl text-white focus:border-[#FF2121] focus:ring-2 focus:ring-[#FF2121]/20 outline-none transition-all"
                           required>
                    <p class="text-gray-500 text-xs mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Este límite se aplicará a todos los usuarios. Puedes configurar límites personalizados por plan de membresía en el futuro.
                    </p>
                </div>
            </div>
        </div>

        <!-- Información del Plugin -->
        <div class="bg-gradient-to-r from-[#FF2121]/10 to-[#F51B1B]/10 backdrop-blur-xl rounded-3xl border border-[#FF2121]/20 p-8 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-[#FF2121]/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-download text-[#FF2121] text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-white mb-2">Descarga del Plugin</h3>
                    <p class="text-gray-300 text-sm mb-4">El plugin está disponible para descarga en:</p>
                    <div class="bg-black/20 rounded-xl p-4 font-mono text-sm text-[#FF2121] border border-[#FF2121]/20">
                        {{ route('pages.plugin.download') }}
                    </div>
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('pages.plugin.download') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl font-bold text-sm transition-all">
                            <i class="fas fa-download"></i> Descargar Plugin
                        </a>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 text-white rounded-xl font-bold text-sm transition-all">
                            <i class="fas fa-book"></i> Ver Documentación
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Control de Versión del Plugin -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 p-8 mb-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 bg-[#FF2121]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-code-branch text-[#FF2121] text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-white mb-1">Publicar Nueva Versión</h2>
                    <p class="text-gray-400 text-sm">Libera una actualización del plugin. Se guardará en el historial y actualizará automáticamente la versión del archivo del plugin en el servidor.</p>
                </div>
                <div class="px-3 py-1 bg-white/5 border border-white/10 text-white text-xs font-bold rounded-lg font-mono">
                    Versión actual: v{{ $currentVersion }}
                </div>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-white mb-2">Número de Versión</label>
                        <input type="text" 
                               name="new_version_number" 
                               placeholder="Ej: 1.0.1" 
                               value="{{ old('new_version_number') }}"
                               class="w-full px-4 py-3 bg-gray-900 border border-white/10 rounded-xl text-white focus:border-[#FF2121] focus:ring-2 focus:ring-[#FF2121]/20 outline-none transition-all">
                        <p class="text-gray-500 text-[11px] mt-1">Sugerido: versión superior a la actual.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-white mb-2">Registro de Cambios (Changelog)</label>
                        <textarea name="changelog" 
                                  rows="2" 
                                  placeholder="¿Qué novedades o correcciones incluye esta actualización?" 
                                  class="w-full px-4 py-3 bg-gray-900 border border-white/10 rounded-xl text-white focus:border-[#FF2121] focus:ring-2 focus:ring-[#FF2121]/20 outline-none transition-all">{{ old('changelog') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Versiones -->
        <div class="bg-gray-800/40 backdrop-blur-xl rounded-3xl border border-white/5 p-8 mb-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-history text-gray-400 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-white mb-1">Historial de Versiones</h2>
                    <p class="text-gray-400 text-sm">Listado cronológico de actualizaciones publicadas para el plugin conector.</p>
                </div>
            </div>

            @if($releases->count() > 0)
                <div class="overflow-hidden border border-white/5 rounded-2xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-white/[0.02]">
                                <th class="px-5 py-4 text-xs font-bold text-gray-400 uppercase">Versión</th>
                                <th class="px-5 py-4 text-xs font-bold text-gray-400 uppercase">Changelog</th>
                                <th class="px-5 py-4 text-xs font-bold text-gray-400 uppercase">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($releases as $release)
                                <tr class="hover:bg-white/[0.01] transition-colors">
                                    <td class="px-5 py-4 font-mono text-sm font-bold text-[#FF2121]">
                                        v{{ $release->version_number }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-300 text-sm">
                                        {{ $release->changelog ?: 'Sin descripción' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-500 text-sm">
                                        {{ $release->released_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 bg-white/[0.01] border border-dashed border-white/10 rounded-2xl">
                    <i class="fas fa-info-circle text-gray-600 text-2xl mb-2"></i>
                    <p class="text-gray-400 text-sm">No hay versiones en el historial aún. Se usará la versión predeterminada del código fuente.</p>
                </div>
            @endif
        </div>

        <!-- Botón Guardar -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.dashboard') }}" 
               class="px-6 py-3 bg-white/5 hover:bg-white/10 text-white rounded-xl font-bold transition-all">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] hover:from-[#FF2121] hover:to-[#F51B1B] text-white rounded-xl font-bold transition-all shadow-lg shadow-[#F51B1B]/20">
                <i class="fas fa-save mr-2"></i> Guardar Configuración
            </button>
        </div>
    </form>
</div>
@endsection