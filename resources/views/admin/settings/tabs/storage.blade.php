<form action="{{ route('admin.settings.storage.update') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                        <i class="fas fa-server text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">Disco de Almacenamiento</h3>
                        <p class="text-xs text-gray-500 font-medium">Selecciona dónde se guardarán los archivos de tus productos.</p>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Local -->
                        <label class="cursor-pointer">
                            <input type="radio" name="storage_driver" value="public" class="peer sr-only" {{ ($settings['storage_driver'] ?? 'public') == 'public' ? 'checked' : '' }}>
                            <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-5 h-full flex flex-col items-center justify-center gap-3 peer-checked:border-[#FF2121]/50 peer-checked:bg-[#FF2121]/10 transition-all hover:border-white/20 text-center">
                                <i class="fas fa-hdd text-2xl text-gray-400 peer-checked:text-[#FF2121]"></i>
                                <span class="text-sm font-bold text-gray-300 peer-checked:text-white">Local (Servidor)</span>
                            </div>
                        </label>

                        <!-- BunnyCDN -->
                        <label class="cursor-pointer">
                            <input type="radio" name="storage_driver" value="bunnycdn" class="peer sr-only" {{ ($settings['storage_driver'] ?? '') == 'bunnycdn' ? 'checked' : '' }}>
                            <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-5 h-full flex flex-col items-center justify-center gap-3 peer-checked:border-orange-500/50 peer-checked:bg-orange-500/10 transition-all hover:border-white/20 text-center">
                                <i class="fas fa-carrot text-2xl text-gray-400 peer-checked:text-orange-400"></i>
                                <span class="text-sm font-bold text-gray-300 peer-checked:text-white">BunnyCDN</span>
                            </div>
                        </label>

                        <!-- R2 -->
                        <label class="cursor-pointer">
                            <input type="radio" name="storage_driver" value="r2" class="peer sr-only" {{ ($settings['storage_driver'] ?? '') == 'r2' ? 'checked' : '' }}>
                            <div class="bg-[#080808] border border-white/[0.08] rounded-xl p-5 h-full flex flex-col items-center justify-center gap-3 peer-checked:border-orange-400/50 peer-checked:bg-orange-400/10 transition-all hover:border-white/20 text-center">
                                <i class="fas fa-cloud text-2xl text-gray-400 peer-checked:text-orange-300"></i>
                                <span class="text-sm font-bold text-gray-300 peer-checked:text-white">CDNs / S3 (R2)</span>
                            </div>
                        </label>
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
            <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-400">
                        <i class="fas fa-carrot text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">BunnyCDN Status</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Access Key</span>
                        <span class="{{ env('BUNNYCDN_API_KEY') ? 'text-emerald-400' : 'text-rose-400' }} font-bold">
                            {{ env('BUNNYCDN_API_KEY') ? 'Configurado' : 'Faltante' }}
                        </span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Zone Name</span>
                        <span class="{{ env('BUNNYCDN_STORAGE_ZONE') ? 'text-emerald-400' : 'text-rose-400' }} font-bold">
                            {{ env('BUNNYCDN_STORAGE_ZONE') ?: 'Faltante' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- R2 Status -->
            <div class="bg-[#0a0a0a] border border-white/[0.06] rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-white/[0.06] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-400/10 border border-orange-400/20 flex items-center justify-center text-orange-300">
                        <i class="fas fa-cloud text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">Cloudflare R2 Status</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Access Key ID</span>
                        <span class="{{ env('CLOUDFLARE_R2_ACCESS_KEY_ID') ? 'text-emerald-400' : 'text-rose-400' }} font-bold">
                            {{ env('CLOUDFLARE_R2_ACCESS_KEY_ID') ? 'Configurado' : 'Faltante' }}
                        </span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-wider">Bucket</span>
                        <span class="{{ env('CLOUDFLARE_R2_BUCKET') ? 'text-emerald-400' : 'text-rose-400' }} font-bold">
                            {{ env('CLOUDFLARE_R2_BUCKET') ?: 'Faltante' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>