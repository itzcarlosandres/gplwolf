<!-- ==============================================
     OPCIÓN 4: SPLIT CODE (2 Columnas + Code Block)
     ============================================== -->
<div class="relative min-h-[70vh] flex items-center overflow-hidden bg-[#0a0a0a]">
    <!-- Subtle dot pattern -->
    <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Soft glow (only lower area, away from menu) -->
    <div class="absolute top-[80%] left-1/2 -translate-x-1/2 -translate-y-1/2 w-[450px] h-[450px] bg-gradient-to-r from-[#FF2121]/10 to-[#F51B1B]/10 rounded-full blur-[90px]"></div>
    <!-- Dark top gradient so menu area stays clean -->
    <div class="absolute inset-x-0 top-0 h-[200px] bg-gradient-to-b from-[#0a0a0a] via-[#0a0a0a]/80 to-transparent z-[1] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
        <!-- Left Side: Text -->
        <div class="py-16 md:py-20 lg:py-24">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#FF2121]/10 border border-[#FF2121]/20 mb-8">
                <i class="fas fa-code text-[#FF2121] text-xs"></i>
                <span class="text-xs font-bold text-[#F51B1B] uppercase tracking-widest">{{ $settings['hero_badge'] ?? 'Para Desarrolladores' }}</span>
            </div>

            <h1 class="{{ $settings['hero_title_size'] ?? 'text-5xl lg:text-7xl' }} font-black text-white mb-6 leading-[0.95] tracking-tight">
                {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-shimmer-red-yellow">$1</span>', e($settings['hero_title'] ?? 'Construye con [G]código premium[/G]')) !!}
            </h1>

            <p class="text-lg text-gray-400 mb-10 max-w-lg leading-relaxed">
                {{ $settings['hero_description'] ?? 'Plugins, themes y snippets optimizados. Descarga directa, versiones actualizadas y documentación completa.' }}
            </p>

            <div class="flex gap-4 mb-12">
                @auth
                <a href="{{ route('products.index') }}" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-bold rounded-xl transition-all shadow-lg shadow-[#F51B1B]/30 flex items-center gap-2">
                    <i class="fas fa-rocket"></i> Empezar Ahora
                </a>
                @else
                <a href="{{ route('register') }}" class="px-8 py-4 gradient-bg hover:opacity-90 text-white font-bold rounded-xl transition-all shadow-lg shadow-[#F51B1B]/30 flex items-center gap-2">
                    <i class="fas fa-rocket"></i> Crear Cuenta
                </a>
                @endauth
                <a href="#planes" class="px-8 py-4 border border-white/10 text-white font-bold rounded-xl hover:bg-white/5 transition-all">
                    Ver Planes
                </a>
            </div>

            <!-- Feature Pills -->
            <div class="flex flex-wrap gap-3 mb-12">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-gray-300">
                    <i class="fas fa-shield-halved text-[#FF2121]"></i> GPL Licenciado
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-gray-300">
                    <i class="fas fa-download text-[#FF2121]"></i> Descarga Directa
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-gray-300">
                    <i class="fas fa-sync text-[#F51B1B]"></i> Updates Automáticos
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-gray-300">
                    <i class="fas fa-headset text-[#FF2121]"></i> Soporte 24/7
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-gray-300">
                    <i class="fas fa-coins text-[#F51B1B]"></i> Puntos por Compra
                </div>
            </div>
        </div>

        <!-- Right Side: Code Block -->
        <div class="hidden lg:flex items-center justify-center p-12">
            <div class="relative w-full max-w-lg">
                <!-- Window Chrome -->
                <div class="bg-[#0b0b0b] rounded-2xl border border-white/10 overflow-hidden shadow-2xl shadow-[#FF2121]/5">
                    <div class="flex items-center gap-2 px-4 py-3 bg-[#131313] border-b border-white/5">
                        <div class="w-3 h-3 rounded-full bg-[#FF2121]/80"></div>
                        <div class="w-3 h-3 rounded-full bg-[#F51B1B]/80"></div>
                        <div class="w-3 h-3 rounded-full bg-white/20"></div>
                        <span class="ml-3 text-xs text-gray-500 font-mono">wp-config.php</span>
                    </div>
                    <div class="p-6 font-mono text-sm leading-relaxed text-left">
                        <div class="text-gray-500 mb-2">// GPLWolf Plugin</div>
                        <div class="code-line-1 overflow-hidden whitespace-nowrap"><span class="text-[#F51B1B]">require_once</span> <span class="text-[#FF2121]">'marketplace-connect.php'</span>;</div>
                        <br>
                        <div class="text-gray-500 mb-2">// Auto-update config</div>
                        <div class="code-line-2 overflow-hidden whitespace-nowrap"><span class="text-[#FF2121]">$config</span> = <span class="text-[#F51B1B]">['auto' => true]</span>;</div>
                        <br>
                        <div class="text-gray-500 mb-2">// License activation</div>
                        <div class="code-line-3 overflow-hidden whitespace-nowrap"><span class="text-[#FF2121]">activate_license</span>(<span class="text-[#F51B1B]">$key</span>);<span class="code-cursor border-r-2 border-[#FF2121]">&nbsp;</span></div>
                    </div>
                </div>
                <!-- Floating badges -->
                <div class="absolute -top-4 -right-4 bg-[#FF2121] text-white text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg float-anim">
                    <i class="fas fa-check mr-1"></i> GPL Validado
                </div>
                <div class="absolute -bottom-3 -left-3 bg-[#1a1a1a] border border-[#FF2121]/30 text-[#FF2121] text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg float-anim" style="animation-delay: 1s">
                    <i class="fas fa-sync mr-1"></i> Auto-Update
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes typing { from { width: 0; } to { width: 100%; } }
    @keyframes blink-caret { from, to { border-color: transparent; } 50% { border-color: #FF2121; } }
    @keyframes float-y { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    .code-line-1 { animation: typing 2s steps(30) 0.5s both; }
    .code-line-2 { animation: typing 2s steps(25) 2.5s both; }
    .code-line-3 { animation: typing 1.5s steps(20) 4.5s both; }
    .code-cursor { animation: blink-caret 1s step-end infinite; }
    .float-anim { animation: float-y 5s ease-in-out infinite; }
</style>