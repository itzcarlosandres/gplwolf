<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - 5 Diseños de Menú | CaletaWP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF2121',
                        secondary: '#F51B1B',
                        accent: '#f59e0b',
                        dark: '#050505',
                        indigo: { 400: '#FF2121', 500: '#FF2121', 600: '#F51B1B' },
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); }
        @keyframes float-y { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .float-anim { animation: float-y 5s ease-in-out infinite; }
        @keyframes pulse-glow { 0%, 100% { opacity: 0.5; transform: scale(1); } 50% { opacity: 1; transform: scale(1.05); } }
        .pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        /* Hide scrollbar for horizontal scroll areas */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#050505] text-gray-300">

    <!-- Selector -->
    <div class="fixed left-0 top-1/2 -translate-y-1/2 z-[60] flex flex-col gap-2 pl-4">
        <a href="#m1" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Command Bar">1</a>
        <a href="#m2" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Dock">2</a>
        <a href="#m3" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Glass Prism">3</a>
        <a href="#m4" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Command Deck">4</a>
        <a href="#m5" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Minimal Line">5</a>
    </div>

    <div class="py-12 text-center">
        <h1 class="text-4xl font-black text-white mb-3">5 Diseños de Menú</h1>
        <p class="text-gray-500 text-sm font-medium">Diseñados para fusionarse con el hero</p>
    </div>

    <!-- ============================================ -->
    <!-- MENU 1: COMMAND BAR -->
    <!-- ============================================ -->
    <div id="m1" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-[#FF2121]/20 text-[#FF2121] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#FF2121]/20">Menú 1 — Command Bar</span>
        </div>

        <div class="relative min-h-[80vh] overflow-hidden bg-[#0a0a0a]">
            <!-- Hero background -->
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px); background-size: 28px 28px;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-[#FF2121]/10 rounded-full blur-[120px] pulse-glow"></div>

            <!-- Menu -->
            <nav class="sticky top-4 z-50 mx-4 md:mx-8 lg:mx-12 mt-4">
                <div class="max-w-5xl mx-auto px-2 py-2 bg-[#0a0a0a]/70 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-2xl shadow-black/40">
                    <div class="flex items-center justify-between gap-4 px-2">
                        <a href="#" class="flex items-center gap-2 text-white font-black text-lg tracking-tight shrink-0">
                            <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center text-sm"><i class="fas fa-rocket"></i></div>
                            CaletaWP
                        </a>
                        
                        <div class="hidden md:flex flex-1 max-w-md relative">
                            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                            <input type="text" placeholder="Buscar themes, plugins..." class="w-full bg-white/5 border border-white/10 rounded-xl pl-9 pr-4 py-2 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-[#FF2121]/50 transition-all">
                            <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-600 bg-white/5 px-2 py-0.5 rounded-md border border-white/10">⌘K</span>
                        </div>

                        <div class="hidden lg:flex items-center gap-1">
                            <a href="#" class="px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition">Productos</a>
                            <a href="#" class="px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition">Novedades</a>
                            <a href="#" class="px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition">Planes</a>
                            <a href="#" class="px-3 py-2 text-xs font-bold text-gray-400 hover:text-white transition">Soporte</a>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white transition"><i class="fas fa-shopping-cart text-xs"></i></button>
                            <button class="hidden sm:flex px-4 py-2 gradient-bg rounded-xl text-xs font-black text-white transition hover:scale-105">Unirse</button>
                            <button class="md:hidden w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white"><i class="fas fa-bars text-xs"></i></button>
                        </div>
                    </div>
                </div>
                
                <!-- Category chips floating below -->
                <div class="max-w-5xl mx-auto mt-3 flex items-center justify-center gap-2 overflow-x-auto no-scrollbar px-4">
                    <a href="#" class="shrink-0 px-3 py-1.5 bg-[#FF2121]/20 text-[#FF2121] border border-[#FF2121]/30 rounded-lg text-[10px] font-black uppercase tracking-widest"><i class="fas fa-fire text-[8px] mr-1"></i> Todos</a>
                    <a href="#" class="shrink-0 px-3 py-1.5 bg-white/5 text-gray-400 border border-white/10 hover:bg-white/10 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition"><i class="fas fa-plug text-[8px] mr-1"></i> Plugins</a>
                    <a href="#" class="shrink-0 px-3 py-1.5 bg-white/5 text-gray-400 border border-white/10 hover:bg-white/10 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition"><i class="fas fa-palette text-[8px] mr-1"></i> Temas</a>
                    <a href="#" class="shrink-0 px-3 py-1.5 bg-white/5 text-gray-400 border border-white/10 hover:bg-white/10 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition"><i class="fas fa-crown text-[8px] mr-1"></i> Premium</a>
                    <a href="#" class="shrink-0 px-3 py-1.5 bg-white/5 text-gray-400 border border-white/10 hover:bg-white/10 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition"><i class="fas fa-layer-group text-[8px] mr-1"></i> Kits</a>
                </div>
            </nav>

            <div class="relative z-10 flex items-center justify-center min-h-[60vh] px-6">
                <div class="text-center max-w-3xl">
                    <h2 class="text-5xl md:text-7xl font-black text-white mb-6">Descargas Premium</h2>
                    <p class="text-lg text-gray-400 mb-8">Menu tipo command bar, flotante y compacto.</p>
                    <button class="px-8 py-4 gradient-bg rounded-2xl text-white font-bold">Explorar Ahora</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MENU 2: DOCK -->
    <!-- ============================================ -->
    <div id="m2" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-[#F51B1B]/20 text-[#F51B1B] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#F51B1B]/20">Menú 2 — Dock</span>
        </div>

        <div class="relative min-h-[80vh] overflow-hidden bg-[#05080f]">
            <!-- Hero background -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#F51B1B]/10 via-transparent to-transparent"></div>
            <div class="absolute top-1/3 right-1/4 w-[500px] h-[500px] bg-[#F51B1B]/10 rounded-full blur-[100px] float-anim"></div>

            <!-- Dock Menu -->
            <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50">
                <div class="flex items-center gap-2 px-3 py-2.5 bg-white/5 backdrop-blur-2xl border border-white/10 rounded-full shadow-2xl shadow-black/50">
                    <a href="#" class="flex items-center gap-2 px-3 text-white font-black text-base tracking-tight">
                        <div class="w-8 h-8 bg-gradient-to-br from-[#FF2121] to-[#F51B1B] rounded-full flex items-center justify-center text-xs"><i class="fas fa-bolt"></i></div>
                    </a>
                    
                    <div class="hidden md:flex items-center gap-1 px-2 border-l border-white/10">
                        <a href="#" class="w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition" title="Productos"><i class="fas fa-box text-sm"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition" title="Plugins"><i class="fas fa-plug text-sm"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition" title="Temas"><i class="fas fa-palette text-sm"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition" title="VIP"><i class="fas fa-crown text-sm"></i></a>
                    </div>

                    <div class="relative hidden sm:block">
                        <input type="text" placeholder="Buscar..." class="w-40 lg:w-56 bg-white/5 border border-white/10 rounded-full pl-9 pr-4 py-2 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-[#F51B1B]/50 transition-all">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-[10px]"></i>
                    </div>

                    <div class="flex items-center gap-2 pl-2 border-l border-white/10">
                        <a href="#" class="w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition relative"><i class="fas fa-shopping-cart text-sm"></i><span class="absolute top-1 right-1 w-2 h-2 bg-[#F51B1B] rounded-full"></span></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FF2121] to-[#F51B1B] flex items-center justify-center text-white text-xs font-black">CA</a>
                    </div>
                </div>
            </nav>

            <div class="relative z-10 flex items-center justify-center min-h-[80vh] px-6 pt-20">
                <div class="text-center max-w-2xl">
                    <h2 class="text-5xl md:text-7xl font-black text-white mb-6">Dock Flotante</h2>
                    <p class="text-lg text-gray-400">Menú centrado tipo macOS, minimal e icónico.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MENU 3: GLASS PRISM -->
    <!-- ============================================ -->
    <div id="m3" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-emerald-500/20">Menú 3 — Glass Prism</span>
        </div>

        <div class="relative min-h-[80vh] overflow-hidden bg-[#080808]">
            <!-- Hero background -->
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 50px 50px;"></div>
            <div class="absolute top-0 left-1/4 w-[400px] h-[400px] bg-emerald-500/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-[#FF2121]/10 rounded-full blur-[120px]"></div>

            <!-- Menu -->
            <nav class="sticky top-0 z-50">
                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-emerald-500/50 to-transparent"></div>
                <div class="bg-gradient-to-b from-[#0a0a0a]/80 to-transparent backdrop-blur-xl">
                    <div class="max-w-7xl mx-auto px-6 py-4">
                        <div class="flex items-center justify-between gap-6">
                            <a href="#" class="text-2xl font-black text-white tracking-tighter flex items-center gap-2">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-[#FF2121]/20 border border-emerald-500/30 flex items-center justify-center"><i class="fas fa-cube text-emerald-400"></i></div>
                                CaletaWP
                            </a>

                            <div class="hidden lg:flex items-center gap-1">
                                <a href="#" class="px-4 py-2 text-sm font-bold text-white bg-white/10 rounded-xl border border-white/20"><i class="fas fa-fire text-emerald-400 text-xs mr-1.5"></i> Todos</a>
                                <a href="#" class="px-4 py-2 text-sm font-bold text-gray-400 hover:text-white hover:bg-white/5 rounded-xl transition">Plugins</a>
                                <a href="#" class="px-4 py-2 text-sm font-bold text-gray-400 hover:text-white hover:bg-white/5 rounded-xl transition">Temas</a>
                                <a href="#" class="px-4 py-2 text-sm font-bold text-gray-400 hover:text-white hover:bg-white/5 rounded-xl transition">Premium</a>
                                <a href="#" class="px-4 py-2 text-sm font-bold text-gray-400 hover:text-white hover:bg-white/5 rounded-xl transition">Kits</a>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="hidden md:flex items-center bg-white/5 border border-white/10 rounded-2xl px-4 py-2.5">
                                    <i class="fas fa-search text-gray-500 text-xs mr-2"></i>
                                    <input type="text" placeholder="Buscar..." class="bg-transparent text-sm text-white placeholder-gray-600 focus:outline-none w-32">
                                </div>
                                <button class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-gray-400 hover:text-white transition"><i class="fas fa-shopping-cart"></i></button>
                                <button class="px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-[#FF2121] rounded-xl text-xs font-black text-black hover:scale-105 transition">Unirse</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="relative z-10 flex items-center justify-center min-h-[60vh] px-6">
                <div class="text-center max-w-3xl">
                    <h2 class="text-5xl md:text-7xl font-black text-white mb-6">Glass Prism</h2>
                    <p class="text-lg text-gray-400">Transparencias, gradientes y bordes luminosos.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MENU 4: COMMAND DECK -->
    <!-- ============================================ -->
    <div id="m4" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-amber-500/20 text-amber-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-amber-500/20">Menú 4 — Command Deck</span>
        </div>

        <div class="relative min-h-[80vh] overflow-hidden bg-[#0a0a0f]">
            <!-- Hero background -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(245,158,11,0.1),transparent_50%)]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-amber-500/5 rounded-full blur-[120px]"></div>

            <!-- Menu -->
            <nav class="sticky top-0 z-50 border-b border-white/5">
                <div class="bg-[#0a0a0f]/60 backdrop-blur-xl">
                    <div class="max-w-7xl mx-auto px-6">
                        <div class="flex items-center justify-between h-16">
                            <div class="flex items-center gap-8">
                                <a href="#" class="text-xl font-black text-white tracking-tight flex items-center gap-2">
                                    <div class="w-9 h-9 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center text-sm"><i class="fas fa-bolt"></i></div>
                                    CaletaWP
                                </a>
                                <div class="hidden xl:flex items-center gap-6 text-xs font-bold uppercase tracking-widest text-gray-500">
                                    <a href="#" class="hover:text-amber-400 transition">Productos</a>
                                    <a href="#" class="hover:text-amber-400 transition">Categorías</a>
                                    <a href="#" class="hover:text-amber-400 transition">Ofertas</a>
                                    <a href="#" class="hover:text-amber-400 transition">Soporte</a>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="hidden md:flex relative">
                                    <input type="text" placeholder="Buscar productos..." class="w-64 bg-[#14141c] border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-gray-600 focus:border-amber-500/50 focus:outline-none transition">
                                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                                </div>
                                <button class="w-10 h-10 bg-[#14141c] border border-white/10 rounded-xl text-gray-400 hover:text-amber-400 transition"><i class="fas fa-shopping-cart"></i></button>
                                <button class="hidden sm:flex items-center gap-2 px-4 h-10 bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl text-xs font-black text-black"><i class="fas fa-user"></i> Cuenta</button>
                                <button class="xl:hidden w-10 h-10 bg-[#14141c] border border-white/10 rounded-xl text-white"><i class="fas fa-bars"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Deck strip -->
                <div class="bg-[#14141c]/80 backdrop-blur-md border-t border-white/5">
                    <div class="max-w-7xl mx-auto px-6 py-2 flex items-center gap-2 overflow-x-auto no-scrollbar">
                        <a href="#" class="shrink-0 px-3 py-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-lg text-[10px] font-black uppercase tracking-widest"><i class="fas fa-fire text-[8px] mr-1"></i> Tendencias</a>
                        <a href="#" class="shrink-0 px-3 py-1.5 text-gray-500 hover:text-white hover:bg-white/5 rounded-lg text-[10px] font-black uppercase tracking-widest transition">Builders</a>
                        <a href="#" class="shrink-0 px-3 py-1.5 text-gray-500 hover:text-white hover:bg-white/5 rounded-lg text-[10px] font-black uppercase tracking-widest transition">SEO</a>
                        <a href="#" class="shrink-0 px-3 py-1.5 text-gray-500 hover:text-white hover:bg-white/5 rounded-lg text-[10px] font-black uppercase tracking-widest transition">Seguridad</a>
                        <a href="#" class="shrink-0 px-3 py-1.5 text-gray-500 hover:text-white hover:bg-white/5 rounded-lg text-[10px] font-black uppercase tracking-widest transition">WooCommerce</a>
                        <a href="#" class="shrink-0 px-3 py-1.5 text-gray-500 hover:text-white hover:bg-white/5 rounded-lg text-[10px] font-black uppercase tracking-widest transition">Membership</a>
                    </div>
                </div>
            </nav>

            <div class="relative z-10 flex items-center justify-center min-h-[55vh] px-6">
                <div class="text-center max-w-3xl">
                    <h2 class="text-5xl md:text-7xl font-black text-white mb-6">Command Deck</h2>
                    <p class="text-lg text-gray-400">Barra superior + deck de categorías para navegación rápida.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MENU 5: MINIMAL LINE -->
    <!-- ============================================ -->
    <div id="m5" class="mb-4">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-rose-500/20 text-rose-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-rose-500/20">Menú 5 — Minimal Line</span>
        </div>

        <div class="relative min-h-[80vh] overflow-hidden bg-[#050505]">
            <!-- Hero background -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(225,29,72,0.08),transparent_40%)]"></div>

            <!-- Menu -->
            <nav class="fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                    <a href="#" class="text-xl font-black text-white tracking-tight">CaletaWP</a>
                    
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white transition">Productos</a>
                        <a href="#" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white transition">Categorías</a>
                        <a href="#" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white transition">Novedades</a>
                        <a href="#" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-white transition">Soporte</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="w-9 h-9 flex items-center justify-center text-gray-400 hover:text-white transition"><i class="fas fa-search text-sm"></i></button>
                        <button class="w-9 h-9 flex items-center justify-center text-gray-400 hover:text-white transition"><i class="fas fa-shopping-cart text-sm"></i></button>
                        <button class="px-5 py-2 border border-white/20 rounded-full text-xs font-black text-white hover:bg-white hover:text-black transition">Login</button>
                        <button class="md:hidden w-9 h-9 flex items-center justify-center text-white"><i class="fas fa-bars"></i></button>
                    </div>
                </div>
                <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
            </nav>

            <div class="relative z-10 flex items-center justify-center min-h-[80vh] px-6">
                <div class="text-center max-w-2xl">
                    <h2 class="text-5xl md:text-7xl font-black text-white mb-6">Minimal Line</h2>
                    <p class="text-lg text-gray-400">Líneas finas, tipografía heavy y cero distracciones.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>