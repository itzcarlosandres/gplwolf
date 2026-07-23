<form action="{{ route('admin.settings.storage.update') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                        <i class="fas fa-server text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white tracking-tight">Disco de Almacenamiento Activo</h3>
                        <p class="text-xs text-gray-400 mt-0.5 font-medium">Selecciona el almacenamiento principal para los archivos y ZIPs de tus productos.</p>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Local -->
                        <label class="cursor-pointer group">
                            <input type="radio" name="storage_driver" value="public" class="peer sr-only" {{ ($settings['storage_driver'] ?? 'public') == 'public' ? 'checked' : '' }}>
                            <div class="bg-white/[0.01] border border-white/[0.08] rounded-2xl p-6 h-full flex flex-col items-center justify-center gap-4 peer-checked:border-[#FF2121] peer-checked:bg-[#FF2121]/[0.04] transition-all hover:border-white/20 hover:bg-white/[0.02] text-center relative overflow-hidden group-hover:scale-[1.02] duration-200">
                                <div class="w-12 h-12 rounded-xl bg-white/[0.04] flex items-center justify-center text-gray-400 peer-checked:text-[#FF2121] transition-colors">
                                    <i class="fas fa-hdd text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-gray-300 peer-checked:text-white">Local</span>
                                    <span class="block text-[10px] text-gray-500 mt-1 leading-normal">Almacenamiento en el disco del servidor</span>
                                </div>
                            </div>
                        </label>

                        <!-- BunnyCDN -->
                        <label class="cursor-pointer group">
                            <input type="radio" name="storage_driver" value="bunnycdn" class="peer sr-only" {{ ($settings['storage_driver'] ?? '') == 'bunnycdn' ? 'checked' : '' }}>
                            <div class="bg-white/[0.01] border border-white/[0.08] rounded-2xl p-6 h-full flex flex-col items-center justify-center gap-4 peer-checked:border-orange-500 peer-checked:bg-orange-500/[0.04] transition-all hover:border-white/20 hover:bg-white/[0.02] text-center relative overflow-hidden group-hover:scale-[1.02] duration-200">
                                <div class="w-12 h-12 rounded-xl bg-white/[0.04] flex items-center justify-center text-gray-400 peer-checked:text-orange-400 transition-colors">
                                    <i class="fas fa-carrot text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-gray-300 peer-checked:text-white">BunnyCDN</span>
                                    <span class="block text-[10px] text-gray-500 mt-1 leading-normal">Almacenamiento ultra veloz y CDN integrada</span>
                                </div>
                            </div>
                        </label>

                        <!-- R2 -->
                        <label class="cursor-pointer group">
                            <input type="radio" name="storage_driver" value="r2" class="peer sr-only" {{ ($settings['storage_driver'] ?? '') == 'r2' ? 'checked' : '' }}>
                            <div class="bg-white/[0.01] border border-white/[0.08] rounded-2xl p-6 h-full flex flex-col items-center justify-center gap-4 peer-checked:border-sky-400 peer-checked:bg-sky-400/[0.04] transition-all hover:border-white/20 hover:bg-white/[0.02] text-center relative overflow-hidden group-hover:scale-[1.02] duration-200">
                                <div class="w-12 h-12 rounded-xl bg-white/[0.04] flex items-center justify-center text-gray-400 peer-checked:text-sky-300 transition-colors">
                                    <i class="fas fa-cloud text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-gray-300 peer-checked:text-white">CDNs / S3 (R2)</span>
                                    <span class="block text-[10px] text-gray-500 mt-1 leading-normal">Cloudflare R2 o cualquier bucket compatible S3</span>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Instructions / Warnings -->
                    <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.04] flex gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 flex-shrink-0">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="text-xs leading-relaxed text-gray-400">
                            <strong class="text-white block mb-1">Nota de Configuración</strong>
                            Para poder activar y utilizar BunnyCDN o Cloudflare R2, primero debes completar las variables correspondientes en el archivo <code class="text-white bg-white/10 px-1.5 py-0.5 rounded font-mono">.env</code> de tu servidor Laravel. Los indicadores de la derecha te mostrarán si el servidor ha detectado estas credenciales correctamente.
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-white/[0.06] flex justify-end">
                    <button type="submit" class="px-8 py-3 gradient-bg hover:opacity-90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#F51B1B]/30 transition-all flex items-center gap-2">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>

        <!-- Right: ENV Status -->
        <div class="space-y-6">
            <!-- Bunny Status -->
            <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-400">
                        <i class="fas fa-carrot text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white tracking-tight">Estado de BunnyCDN</h3>
                        <p class="text-[10px] text-gray-500 font-medium">Credenciales del archivo .env</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Access Key</span>
                        @if(env('BUNNYCDN_API_KEY'))
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-black text-[10px] uppercase tracking-wider">Activo</span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 font-black text-[10px] uppercase tracking-wider">Faltante</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Zone Name</span>
                        @if(env('BUNNYCDN_STORAGE_ZONE'))
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-mono text-[10px] font-bold">{{ env('BUNNYCDN_STORAGE_ZONE') }}</span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 font-black text-[10px] uppercase tracking-wider">Faltante</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- R2 Status -->
            <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-400/10 border border-sky-400/20 flex items-center justify-center text-sky-300">
                        <i class="fas fa-cloud text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-white tracking-tight">Estado de Cloudflare R2</h3>
                        <p class="text-[10px] text-gray-500 font-medium">Credenciales del archivo .env</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Access Key ID</span>
                        @if(env('CLOUDFLARE_R2_ACCESS_KEY_ID'))
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-black text-[10px] uppercase tracking-wider">Activo</span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 font-black text-[10px] uppercase tracking-wider">Faltante</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Bucket</span>
                        @if(env('CLOUDFLARE_R2_BUCKET'))
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-mono text-[10px] font-bold">{{ env('CLOUDFLARE_R2_BUCKET') }}</span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 font-black text-[10px] uppercase tracking-wider">Faltante</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>