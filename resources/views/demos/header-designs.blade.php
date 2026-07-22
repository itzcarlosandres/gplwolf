<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - 5 Header Designs | CaletaWP</title>
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
        .glass { background: rgba(10, 10, 10, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .gradient-bg { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); }
        .neon-glow { box-shadow: 0 0 15px rgba(255, 33, 33, 0.4), 0 0 60px rgba(255, 33, 33, 0.1); }
        .neon-text { text-shadow: 0 0 10px rgba(255, 33, 33, 0.5); }
        .design-card { scroll-margin-top: 20px; }
    </style>
</head>
<body class="bg-[#050505] text-gray-300">

    <!-- Design Selector Sidebar -->
    <div class="fixed left-0 top-1/2 -translate-y-1/2 z-[60] flex flex-col gap-2 pl-4">
        <a href="#design1" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Glass Dark (Actual)">1</a>
        <a href="#design2" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Neon Cyber">2</a>
        <a href="#design3" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Minimal Clean">3</a>
        <a href="#design4" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Gradient Bold">4</a>
        <a href="#design5" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-[#FF2121] flex items-center justify-center text-xs font-black text-white transition-all hover:scale-110 border border-white/10 hover:border-[#FF2121]" title="Mega Categories">5</a>
    </div>

    <!-- Page Title -->
    <div class="py-12 text-center">
        <h1 class="text-4xl font-black text-white mb-3">5 Diseños de Header</h1>
        <p class="text-gray-500 text-sm font-medium">Selecciona el que más te guste para CaletaWP</p>
    </div>

    <!-- ============================================ -->
    <!-- DESIGN 1: GLASS DARK (Current) -->
    <!-- ============================================ -->
    <div id="design1" class="design-card mb-8">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-[#FF2121]/20 text-[#FF2121] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#FF2121]/20">Diseño 1 — Glass Dark (Actual)</span>
        </div>

        <nav class="glass border-b border-white/5 py-3 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-2xl font-black tracking-tighter text-white flex items-center gap-2 group">
                        <div class="w-9 h-9 gradient-bg rounded-xl flex items-center justify-center text-sm text-white shadow-lg shadow-[#F51B1B]/40 group-hover:scale-110 transition-transform">
                            <i class="fas fa-store"></i>
                        </div>
                        <span class="group-hover:text-[#FF2121] transition-colors">CaletaWP</span>
                    </a>
                    <button class="md:hidden w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-gray-400 border border-white/10">
                        <i class="fas fa-search text-sm"></i>
                    </button>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-[#FF2121] transition group">
                        <i class="fas fa-box-open text-[10px] opacity-50 group-hover:opacity-100 group-hover:text-[#FF2121] transition-all"></i>
                        Productos
                        <span class="bg-rose-500 text-[7px] font-black px-1.5 py-0.5 rounded-[4px] text-white shadow-lg shadow-rose-500/20 group-hover:scale-110 transition-transform">HOT</span>
                    </a>
                    <a href="#" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition group">
                        <i class="fas fa-magic text-[10px] opacity-50 group-hover:opacity-100 group-hover:text-amber-500 transition-all"></i>
                        Actualizaciones
                    </a>
                    <a href="#" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition group">
                        <i class="fas fa-crown text-[10px] opacity-50 group-hover:opacity-100 group-hover:text-yellow-500 transition-all"></i>
                        Membresías
                    </a>
                </div>

                <!-- Search -->
                <div class="hidden md:block">
                    <input type="text" placeholder="Buscar productos..." class="w-64 px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder-gray-500 focus:border-[#FF2121] focus:ring-2 focus:ring-[#FF2121]/20 transition-all pr-10">
                    <i class="fas fa-search absolute right-10 top-1/2 -translate-y-1/2 text-gray-500 text-sm pointer-events-none"></i>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <a href="#" class="relative w-11 h-11 bg-white/5 rounded-xl border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#FF2121]/50 hover:bg-[#FF2121]/10 transition-all group">
                        <i class="fas fa-shopping-cart text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 gradient-bg rounded-lg text-[10px] font-black text-white flex items-center justify-center ring-4 ring-[#0d0d0d] shadow-lg">2</span>
                    </a>
                    <div class="h-6 w-px bg-white/10 hidden md:block"></div>
                    <a href="#" class="hidden md:flex items-center gap-3 bg-gray-900/50 border border-white/10 pl-2 pr-4 py-1.5 rounded-xl hover:bg-gray-900 transition-all group">
                        <img src="https://ui-avatars.com/api/?name=Carlos&background=6366f1&color=fff&bold=true" class="w-7 h-7 rounded-lg shadow-lg">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-300 group-hover:text-white">Mi Cuenta</span>
                    </a>
                    <button class="md:hidden w-11 h-11 bg-white/5 rounded-xl flex items-center justify-center text-white border border-white/10">
                        <i class="fas fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <!-- ============================================ -->
    <!-- DESIGN 2: NEON CYBERPUNK -->
    <!-- ============================================ -->
    <div id="design2" class="design-card mb-8">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-[#F51B1B]/20 text-[#F51B1B] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#F51B1B]/20">Diseño 2 — Neon Cyber</span>
        </div>

        <nav class="bg-[#0a0a0f] border-b border-[#F51B1B]/20 py-3 sticky top-0 z-50 relative overflow-hidden">
            <!-- Animated neon background -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 left-1/4 w-96 h-32 bg-[#F51B1B] rounded-full blur-[100px] animate-pulse"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-32 bg-[#F51B1B] rounded-full blur-[100px] animate-pulse" style="animation-delay: 1s"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center relative z-10">
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-2xl font-black tracking-tighter text-white flex items-center gap-2 group">
                        <div class="w-9 h-9 bg-gradient-to-br from-[#FF2121] to-[#F51B1B] rounded-xl flex items-center justify-center text-sm text-white shadow-lg shadow-[#F51B1B]/40 group-hover:shadow-[#F51B1B]/60 group-hover:scale-110 transition-all neon-glow">
                            <i class="fas fa-store"></i>
                        </div>
                        <span class="neon-text text-white">CaletaWP</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="#" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white bg-[#F51B1B]/20 rounded-xl border border-[#F51B1B]/30 hover:bg-[#F51B1B]/30 hover:border-[#F51B1B]/50 transition-all group">
                        <i class="fas fa-box-open text-[10px] mr-2 text-[#F51B1B]"></i>Productos
                    </a>
                    <a href="#" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white rounded-xl hover:bg-white/5 transition-all group">
                        <i class="fas fa-magic text-[10px] mr-2 text-amber-400"></i>Actualizaciones
                    </a>
                    <a href="#" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white rounded-xl hover:bg-white/5 transition-all group">
                        <i class="fas fa-crown text-[10px] mr-2 text-yellow-400"></i>Membresías
                    </a>
                </div>

                <!-- Search -->
                <div class="hidden md:block relative">
                    <input type="text" placeholder="Buscar..." class="w-52 px-4 py-2.5 bg-black/50 border border-[#F51B1B]/30 rounded-xl text-white text-sm placeholder-gray-600 focus:border-[#F51B1B] focus:ring-2 focus:ring-[#F51B1B]/20 transition-all">
                    <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-[#F51B1B]/50 text-sm"></i>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <a href="#" class="relative w-11 h-11 bg-black/50 rounded-xl border border-[#F51B1B]/30 flex items-center justify-center text-gray-400 hover:text-[#F51B1B] hover:border-[#F51B1B]/50 hover:bg-[#F51B1B]/10 transition-all group">
                        <i class="fas fa-shopping-cart text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-[#F51B1B] rounded-lg text-[10px] font-black text-white flex items-center justify-center ring-4 ring-[#0a0a0f] shadow-lg shadow-[#F51B1B]/30">2</span>
                    </a>
                    <a href="#" class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-[#F51B1B]/30 hover:shadow-[#F51B1B]/50 hover:scale-105 transition-all">
                        <i class="fas fa-user-plus opacity-50"></i> Unirse
                    </a>
                    <button class="md:hidden w-11 h-11 bg-black/50 rounded-xl flex items-center justify-center text-white border border-[#F51B1B]/30">
                        <i class="fas fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <!-- ============================================ -->
    <!-- DESIGN 3: MINIMAL CLEAN (White/Light) -->
    <!-- ============================================ -->
    <div id="design3" class="design-card mb-8">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-gray-100 text-gray-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-gray-200">Diseño 3 — Minimal Clean</span>
        </div>

        <nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 py-3 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-2xl font-black tracking-tighter text-gray-900 flex items-center gap-2 group">
                        <div class="w-9 h-9 bg-gray-900 rounded-xl flex items-center justify-center text-sm text-white group-hover:scale-110 transition-transform">
                            <i class="fas fa-store"></i>
                        </div>
                        <span class="group-hover:text-[#F51B1B] transition-colors">CaletaWP</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#" class="text-sm font-bold text-[#F51B1B] transition group">
                        Productos
                    </a>
                    <a href="#" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition group">
                        Actualizaciones
                    </a>
                    <a href="#" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition group">
                        Membresías
                    </a>
                </div>

                <!-- Search -->
                <div class="hidden md:block relative">
                    <input type="text" placeholder="Buscar..." class="w-52 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:border-[#FF2121] focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
                    <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <a href="#" class="relative w-11 h-11 bg-gray-50 rounded-xl border border-gray-200 flex items-center justify-center text-gray-500 hover:text-[#F51B1B] hover:border-[#FF2121]/30 transition-all group">
                        <i class="fas fa-shopping-cart text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-gray-900 rounded-lg text-[10px] font-black text-white flex items-center justify-center">2</span>
                    </a>
                    <a href="#" class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-800 transition-all">
                        <i class="fas fa-user opacity-50"></i> Mi Cuenta
                    </a>
                    <button class="md:hidden w-11 h-11 bg-gray-50 rounded-xl flex items-center justify-center text-gray-600 border border-gray-200">
                        <i class="fas fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <!-- ============================================ -->
    <!-- DESIGN 4: GRADIENT BOLD -->
    <!-- ============================================ -->
    <div id="design4" class="design-card mb-8">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-[#FF2121]/20 text-[#FF2121] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#FF2121]/20">Diseño 4 — Gradient Bold</span>
        </div>

        <nav class="gradient-bg py-3 sticky top-0 z-50 relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center relative z-10">
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <a href="#" class="text-2xl font-black tracking-tighter text-white flex items-center gap-2 group">
                        <div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-sm text-white border border-white/20 group-hover:scale-110 transition-transform">
                            <i class="fas fa-store"></i>
                        </div>
                        <span>CaletaWP</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="#" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white bg-white/20 rounded-xl border border-white/20 backdrop-blur-sm transition-all group">
                        <i class="fas fa-box-open text-[10px] mr-2 opacity-70"></i>Productos
                    </a>
                    <a href="#" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white/70 hover:text-white rounded-xl hover:bg-white/10 transition-all group">
                        <i class="fas fa-magic text-[10px] mr-2 opacity-50"></i>Actualizaciones
                    </a>
                    <a href="#" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white/70 hover:text-white rounded-xl hover:bg-white/10 transition-all group">
                        <i class="fas fa-crown text-[10px] mr-2 opacity-50"></i>Membresías
                    </a>
                </div>

                <!-- Search -->
                <div class="hidden md:block relative">
                    <input type="text" placeholder="Buscar..." class="w-52 px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white text-sm placeholder-white/50 focus:bg-white/20 focus:border-white/30 transition-all backdrop-blur-sm">
                    <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-white/50 text-sm"></i>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <a href="#" class="relative w-11 h-11 bg-white/10 rounded-xl border border-white/20 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/20 transition-all group backdrop-blur-sm">
                        <i class="fas fa-shopping-cart text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-white text-[#F51B1B] rounded-lg text-[10px] font-black flex items-center justify-center shadow-lg">2</span>
                    </a>
                    <a href="#" class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-white text-[#F51B1B] text-xs font-black uppercase tracking-widest rounded-xl shadow-lg shadow-black/20 hover:shadow-black/40 hover:scale-105 transition-all">
                        <i class="fas fa-user-plus opacity-50"></i> Unirse
                    </a>
                    <button class="md:hidden w-11 h-11 bg-white/10 rounded-xl flex items-center justify-center text-white border border-white/20">
                        <i class="fas fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <!-- ============================================ -->
    <!-- DESIGN 5: MEGA CATEGORIES -->
    <!-- ============================================ -->
    <div id="design5" class="design-card mb-8">
        <div class="max-w-7xl mx-auto px-6 mb-4">
            <span class="inline-block px-4 py-1.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-emerald-500/20">Diseño 5 — Mega Categories</span>
        </div>

        <nav class="bg-[#0a0a0a] border-b border-white/5 sticky top-0 z-50">
            <!-- Top row: Logo + Search + Actions -->
            <div class="py-3">
                <div class="max-w-7xl mx-auto px-6 flex justify-between items-center gap-6">
                    <!-- Logo -->
                    <a href="#" class="text-2xl font-black tracking-tighter text-white flex items-center gap-2 group shrink-0">
                        <div class="w-9 h-9 gradient-bg rounded-xl flex items-center justify-center text-sm text-white shadow-lg shadow-[#F51B1B]/40 group-hover:scale-110 transition-transform">
                            <i class="fas fa-store"></i>
                        </div>
                        <span class="group-hover:text-[#FF2121] transition-colors">CaletaWP</span>
                    </a>

                    <!-- Centered Search Bar -->
                    <div class="hidden md:block flex-1 max-w-xl relative">
                        <input type="text" placeholder="Buscar themes, plugins, herramientas..." class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-2xl text-white text-sm placeholder-gray-500 focus:border-[#FF2121] focus:ring-2 focus:ring-[#FF2121]/20 transition-all pr-12">
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 gradient-bg rounded-xl flex items-center justify-center text-white hover:scale-105 transition-transform">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3 shrink-0">
                        <a href="#" class="relative w-11 h-11 bg-white/5 rounded-xl border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#FF2121]/50 transition-all group">
                            <i class="fas fa-shopping-cart text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 gradient-bg rounded-lg text-[10px] font-black text-white flex items-center justify-center ring-4 ring-[#0a0a0a] shadow-lg">2</span>
                        </a>
                        <a href="#" class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all group">
                            <i class="fas fa-headset text-sm opacity-50 group-hover:opacity-100 transition"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Soporte</span>
                        </a>
                        <a href="#" class="hidden md:flex items-center gap-2 bg-gray-900/50 border border-white/10 pl-2 pr-4 py-1.5 rounded-xl hover:bg-gray-900 transition-all group">
                            <img src="https://ui-avatars.com/api/?name=Carlos&background=6366f1&color=fff&bold=true" class="w-7 h-7 rounded-lg shadow-lg">
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-300 group-hover:text-white">Mi Cuenta</span>
                        </a>
                        <button class="md:hidden w-11 h-11 bg-white/5 rounded-xl flex items-center justify-center text-white border border-white/10">
                            <i class="fas fa-bars-staggered"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom row: Category pills -->
            <div class="border-t border-white/5 py-2.5 hidden md:block">
                <div class="max-w-7xl mx-auto px-6 flex items-center gap-2 overflow-x-auto">
                    <a href="#" class="shrink-0 px-4 py-1.5 bg-[#FF2121]/20 text-[#FF2121] text-[10px] font-black uppercase tracking-widest rounded-lg border border-[#FF2121]/20 hover:bg-[#FF2121]/30 transition-all">
                        <i class="fas fa-fire text-[8px] mr-1"></i> Todos
                    </a>
                    <a href="#" class="shrink-0 px-4 py-1.5 bg-white/5 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-white/5 hover:bg-white/10 hover:text-white transition-all">
                        <i class="fas fa-palette text-[8px] mr-1"></i> Themes
                    </a>
                    <a href="#" class="shrink-0 px-4 py-1.5 bg-white/5 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-white/5 hover:bg-white/10 hover:text-white transition-all">
                        <i class="fas fa-plug text-[8px] mr-1"></i> Plugins
                    </a>
                    <a href="#" class="shrink-0 px-4 py-1.5 bg-white/5 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-white/5 hover:bg-white/10 hover:text-white transition-all">
                        <i class="fas fa-toolbox text-[8px] mr-1"></i> Herramientas
                    </a>
                    <a href="#" class="shrink-0 px-4 py-1.5 bg-white/5 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-white/5 hover:bg-white/10 hover:text-white transition-all">
                        <i class="fas fa-cube text-[8px] mr-1"></i> Elementor
                    </a>
                    <a href="#" class="shrink-0 px-4 py-1.5 bg-white/5 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-white/5 hover:bg-white/10 hover:text-white transition-all">
                        <i class="fas fa-shopping-bag text-[8px] mr-1"></i> WooCommerce
                    </a>
                    <a href="#" class="shrink-0 px-4 py-1.5 bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-lg border border-emerald-500/20 hover:bg-emerald-500/20 transition-all">
                        <i class="fas fa-gift text-[8px] mr-1"></i> Gratis
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Placeholder Content Below -->
    <div class="max-w-7xl mx-auto px-6 py-20 text-center">
        <p class="text-gray-600 text-sm">Contenido de la página aquí abajo...</p>
    </div>

</body>
</html>