<!-- ==============================================
     OPCIÓN 3: CYBER TECH (Futurista & Neón Rojo)
     ============================================== -->
<div class="relative min-h-[90vh] flex items-center justify-center bg-[#050505] overflow-hidden border-b border-[#FF2121]/20 py-20">
    <!-- Cyber Grid & Matrix Beam Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f0a0a_1px,transparent_1px),linear-gradient(to_bottom,#1f0a0a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>
        <div class="absolute top-1/4 left-10 w-80 h-80 bg-[#FF2121]/20 rounded-full blur-[140px] animate-pulse"></div>
        <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-[#F51B1B]/15 rounded-full blur-[160px] animate-pulse delay-700"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-6 z-10 grid lg:grid-cols-12 gap-12 items-center">
        <!-- Text & CTAs Column -->
        <div class="lg:col-span-7 text-left">
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/30 text-xs font-mono font-bold text-[#FF2121] mb-8 shadow-[0_0_20px_rgba(255,33,33,0.2)]">
                <span class="w-2 h-2 rounded-full bg-[#FF2121] animate-ping"></span>
                SYSTEM_STATUS: ONLINE // v4.2 GPL
            </div>

            <h1 class="{{ $settings['hero_title_size'] ?? 'text-5xl md:text-7xl' }} font-black text-white mb-6 leading-none tracking-tight">
                {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-shimmer-red-yellow drop-shadow-[0_0_25px_rgba(255,33,33,0.5)]">$1</span>', e($settings['hero_title'] ?? 'Ecosistema [G]WordPress Cyber[/G]')) !!}
            </h1>

            <p class="text-lg text-gray-400 mb-10 max-w-xl font-mono leading-relaxed">
                > {{ $settings['hero_description'] ?? 'Descarga directa de recursos de código limpio sin malware. Actualizaciones continuas en tiempo real.' }}
            </p>

            <div class="flex flex-wrap items-center gap-4 mb-12">
                @auth
                <a href="{{ route('products.index') }}" class="px-8 py-4 bg-[#FF2121] hover:bg-[#F51B1B] text-white font-mono font-black text-sm uppercase tracking-widest rounded-xl transition-all shadow-[0_0_30px_rgba(255,33,33,0.4)] hover:scale-105 flex items-center gap-3">
                    <i class="fas fa-terminal"></i> Acceder al Sistema
                </a>
                @else
                <a href="{{ route('register') }}" class="px-8 py-4 bg-[#FF2121] hover:bg-[#F51B1B] text-white font-mono font-black text-sm uppercase tracking-widest rounded-xl transition-all shadow-[0_0_30px_rgba(255,33,33,0.4)] hover:scale-105 flex items-center gap-3">
                    <i class="fas fa-terminal"></i> Iniciar Registro
                </a>
                @endauth

                <a href="#planes" class="px-8 py-4 bg-black/80 hover:bg-white/5 border border-[#FF2121]/30 hover:border-[#FF2121] text-gray-200 font-mono text-sm font-bold rounded-xl transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-microchip text-[#FF2121]"></i> Planes VIP
                </a>
            </div>

            <!-- Terminal Stats Pill -->
            <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/10 max-w-lg">
                <div>
                    <div class="text-2xl font-black text-white font-mono text-[#FF2121]">5,000+</div>
                    <div class="text-[10px] font-mono text-gray-500 uppercase tracking-wider">Themes & Plugins</div>
                </div>
                <div>
                    <div class="text-2xl font-black text-white font-mono text-emerald-400">99.9%</div>
                    <div class="text-[10px] font-mono text-gray-500 uppercase tracking-wider">Uptime Servidor</div>
                </div>
                <div>
                    <div class="text-2xl font-black text-white font-mono text-amber-400">24/7</div>
                    <div class="text-[10px] font-mono text-gray-500 uppercase tracking-wider">Auto Updates</div>
                </div>
            </div>
        </div>

        <!-- Interactive Cyber HUD Card -->
        <div class="lg:col-span-5 hidden lg:block">
            <div class="relative bg-gradient-to-br from-[#120707] to-[#080808] p-8 rounded-3xl border border-[#FF2121]/40 shadow-[0_0_50px_rgba(255,33,33,0.15)] relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#FF2121]/20 blur-2xl rounded-full"></div>
                
                <div class="flex items-center justify-between pb-6 border-b border-white/10 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-[#FF2121] animate-ping"></div>
                        <span class="font-mono text-xs text-gray-300 font-bold uppercase tracking-widest">LIVE_FEED // GPLWOLF</span>
                    </div>
                    <span class="px-2.5 py-1 bg-[#FF2121]/20 text-[#FF2121] font-mono text-[10px] font-black rounded-lg border border-[#FF2121]/40">SECURE</span>
                </div>

                <div class="space-y-4 font-mono text-xs text-gray-300">
                    <div class="p-3 bg-black/60 rounded-xl border border-white/5 flex items-center justify-between">
                        <span class="text-gray-400">> Elementor Pro Pro Pack</span>
                        <span class="text-emerald-400 font-bold">VERIFIED</span>
                    </div>
                    <div class="p-3 bg-black/60 rounded-xl border border-white/5 flex items-center justify-between">
                        <span class="text-gray-400">> WP Rocket Cache Ultra</span>
                        <span class="text-emerald-400 font-bold">v3.16 CLEAN</span>
                    </div>
                    <div class="p-3 bg-black/60 rounded-xl border border-white/5 flex items-center justify-between">
                        <span class="text-gray-400">> Yoast Premium SEO</span>
                        <span class="text-emerald-400 font-bold">UPDATED NOW</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-white/10 flex items-center justify-between">
                    <span class="text-[11px] font-mono text-gray-500">AUTONOMOUS DISPATCH</span>
                    <span class="text-xs font-mono text-[#FF2121] font-bold">100% GPL FREEDOM</span>
                </div>
            </div>
        </div>
    </div>
</div>