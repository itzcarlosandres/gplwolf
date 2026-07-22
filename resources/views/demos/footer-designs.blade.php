<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Footer Designs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-bg { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); }

        @keyframes soft-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 33, 33, 0.25), 0 0 40px rgba(255, 33, 33, 0.15); transform: scale(1); }
            50% { box-shadow: 0 0 30px rgba(255, 33, 33, 0.4), 0 0 60px rgba(255, 33, 33, 0.25); transform: scale(1.03); }
        }
        .logo-pulse {
            animation: soft-glow 4s ease-in-out infinite;
        }
        @keyframes logo-shine {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .logo-shine {
            background: linear-gradient(90deg, #2862eb 0%, #60a5fa 25%, #2862eb 50%, #60a5fa 75%, #2862eb 100%);
            background-size: 200% auto;
            animation: logo-shine 6s linear infinite;
        }

        .animated-line {
            background: linear-gradient(90deg, transparent 0%, rgba(255, 33, 33, 0.1) 35%, rgba(255, 33, 33, 0.6) 50%, rgba(255, 33, 33, 0.1) 65%, transparent 100%);
            background-size: 200% 100%;
            animation: line-slide 3s linear infinite;
        }

        @keyframes line-slide {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }
    </style>
</head>
<body class="bg-[#080808] text-white">

    <!-- Header -->
    <div class="sticky top-0 z-50 bg-[#080808]/90 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-black tracking-tight">Footer Design Lab</h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-0.5">5 propuestas modernas y limpias</p>
            </div>
            <a href="{{ route('home') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-xs font-black uppercase tracking-wider transition">Volver al sitio</a>
        </div>
    </div>

    <!-- Demo 1: Minimal Dark -->
    <section class="relative">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-xs font-black text-[#FF2121] uppercase tracking-widest">Diseño 1</span>
                <h2 class="text-lg font-bold">Minimal Dark</h2>
            </div>
        </div>
        <footer class="bg-[#0d0d0d] border-t border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left">
                        <a href="#" class="text-2xl font-black tracking-tight gradient-text">WP Market</a>
                        <p class="text-gray-500 text-sm mt-2 max-w-sm">Recursos premium para WordPress. Themes, plugins y herramientas de marketing.</p>
                    </div>
                    <nav class="flex flex-wrap justify-center gap-8">
                        <a href="#" class="text-sm font-bold text-gray-400 hover:text-white transition">Productos</a>
                        <a href="#" class="text-sm font-bold text-gray-400 hover:text-white transition">Planes</a>
                        <a href="#" class="text-sm font-bold text-gray-400 hover:text-white transition">Soporte</a>
                        <a href="#" class="text-sm font-bold text-gray-400 hover:text-white transition">Términos</a>
                    </nav>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#FF2121]/50 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#FF2121]/50 transition"><i class="fab fa-discord"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#FF2121]/50 transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-white/[0.06] text-center">
                    <p class="text-[11px] font-black text-gray-600 uppercase tracking-widest">© 2026 WP Market. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </section>

    <!-- Demo 2: Gradient Glow -->
    <section class="relative mt-8">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-xs font-black text-[#F51B1B] uppercase tracking-widest">Diseño 2</span>
                <h2 class="text-lg font-bold">Gradient Glow</h2>
            </div>
        </div>
        <footer class="relative bg-[#0c111f] border-t border-white/[0.06] overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[200px] bg-[#F51B1B]/10 blur-[120px] rounded-full pointer-events-none"></div>
            <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-[#F51B1B]/50 to-transparent"></div>
            <div class="relative max-w-7xl mx-auto px-6 py-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="md:col-span-2">
                        <a href="#" class="text-2xl font-black tracking-tight gradient-text">WP Market</a>
                        <p class="text-gray-500 text-sm mt-4 max-w-md leading-relaxed">La plataforma líder en recursos premium para WordPress. Impulsa tus proyectos con themes y plugins verificados.</p>
                        <div class="flex gap-3 mt-6">
                            <a href="#" class="w-9 h-9 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center justify-center text-[#F51B1B] hover:bg-[#F51B1B] hover:text-white transition"><i class="fab fa-twitter text-xs"></i></a>
                            <a href="#" class="w-9 h-9 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center justify-center text-[#F51B1B] hover:bg-[#F51B1B] hover:text-white transition"><i class="fab fa-discord text-xs"></i></a>
                            <a href="#" class="w-9 h-9 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center justify-center text-[#F51B1B] hover:bg-[#F51B1B] hover:text-white transition"><i class="fab fa-instagram text-xs"></i></a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-widest text-white mb-5">Navegación</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-gray-400 hover:text-[#F51B1B] transition flex items-center gap-2"><i class="fas fa-box-open text-xs"></i> Productos</a></li>
                            <li><a href="#" class="text-sm text-gray-400 hover:text-[#F51B1B] transition flex items-center gap-2"><i class="fas fa-crown text-xs"></i> Programa VIP</a></li>
                            <li><a href="#" class="text-sm text-gray-400 hover:text-[#F51B1B] transition flex items-center gap-2"><i class="fas fa-plug text-xs"></i> Plugin Oficial</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-widest text-white mb-5">Ayuda</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-gray-400 hover:text-[#F51B1B] transition flex items-center gap-2"><i class="fas fa-life-ring text-xs"></i> Centro de Ayuda</a></li>
                            <li><a href="#" class="text-sm text-gray-400 hover:text-[#F51B1B] transition flex items-center gap-2"><i class="fas fa-file-contract text-xs"></i> Términos</a></li>
                            <li><a href="#" class="text-sm text-gray-400 hover:text-[#F51B1B] transition flex items-center gap-2"><i class="fas fa-undo-alt text-xs"></i> Reembolso</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-14 pt-8 border-t border-white/[0.06] flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-[11px] font-black text-gray-600 uppercase tracking-widest">© 2026 WP Market. Todos los derechos reservados.</p>
                    <p class="text-[11px] font-black text-gray-600 uppercase tracking-widest">Hecho con <i class="fas fa-heart text-[#F51B1B] mx-1"></i> para developers</p>
                </div>
            </div>
        </footer>
    </section>

    <!-- Demo 3: Corporate Multi-Column -->
    <section class="relative mt-8">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-xs font-black text-[#FF2121] uppercase tracking-widest">Diseño 3</span>
                <h2 class="text-lg font-bold">Corporate Multi-Column</h2>
            </div>
        </div>
        <footer class="bg-[#111111] border-t border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
                    <div class="lg:col-span-2">
                        <a href="#" class="inline-flex items-center gap-3 text-xl font-black tracking-tight mb-4">
                            <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center text-white"><i class="fas fa-bolt"></i></div>
                            WP Market
                        </a>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-sm">Descargas directas, actualizaciones automáticas y soporte prioritario. Todo en un solo lugar.</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-5">Productos</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Themes</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Plugins</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Marketing</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Nuevos</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-5">Compañía</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Planes</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Afiliados</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Blog</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Contacto</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-5">Legal</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Términos</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Privacidad</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Reembolso</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-[#FF2121] transition">Licencias</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-14 pt-8 border-t border-white/[0.06] flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-[11px] font-black text-gray-600 uppercase tracking-widest">© 2026 WP Market. Todos los derechos reservados.</p>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-500 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-500 hover:text-white transition"><i class="fab fa-discord"></i></a>
                        <a href="#" class="text-gray-500 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </section>

    <!-- Demo 4: Compact Bar -->
    <section class="relative mt-8">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-xs font-black text-emerald-400 uppercase tracking-widest">Diseño 4</span>
                <h2 class="text-lg font-bold">Compact Bar</h2>
            </div>
        </div>
        <footer class="bg-[#0d0d0d] border-t border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-6 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <a href="#" class="text-lg font-black tracking-tight gradient-text">WP Market</a>
                    <nav class="flex flex-wrap justify-center gap-6">
                        <a href="#" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition">Productos</a>
                        <a href="#" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition">Planes</a>
                        <a href="#" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition">Soporte</a>
                        <a href="#" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition">Términos</a>
                        <a href="#" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition">Reembolso</a>
                    </nav>
                    <div class="flex gap-3">
                        <a href="#" class="text-gray-500 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-500 hover:text-white transition"><i class="fab fa-discord"></i></a>
                        <a href="#" class="text-gray-500 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-white/[0.06] text-center md:text-left">
                    <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest">© 2026 WP Market. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </section>

    <!-- Demo 5: Bento Grid -->
    <section class="relative mt-8 mb-20">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-xs font-black text-[#FF2121] uppercase tracking-widest">Diseño 5</span>
                <h2 class="text-lg font-bold">Bento Grid — Premium</h2>
            </div>
        </div>
        <footer class="relative bg-[#080808] border-t border-white/[0.06] overflow-hidden">
            <!-- Ambient glows -->
            <div class="absolute top-0 left-0 w-[500px] h-[400px] bg-[#FF2121]/5 rounded-full blur-[150px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-[400px] h-[300px] bg-amber-500/5 rounded-full blur-[150px] pointer-events-none"></div>
            <div class="absolute top-0 inset-x-0 h-px animated-line"></div>

            <div class="relative max-w-7xl mx-auto px-6 py-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Brand Card (large) -->
                    <div class="md:col-span-2 group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#FF2121]/5 to-[#F51B1B]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-12 h-12 logo-shine rounded-2xl flex items-center justify-center text-white logo-pulse">
                                    <i class="fas fa-bolt text-lg"></i>
                                </div>
                                <a href="#" class="text-2xl font-black tracking-tight text-white">WP <span class="gradient-text">Market</span></a>
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed max-w-md">La plataforma líder en recursos premium para WordPress. Themes, plugins y herramientas de marketing optimizadas.</p>
                            <div class="flex gap-3 mt-6">
                                <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-twitter text-sm"></i></a>
                                <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-discord text-sm"></i></a>
                                <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-instagram text-sm"></i></a>
                                <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-[#F51B1B] hover:border-[#FF2121] transition-all duration-300"><i class="fab fa-youtube text-sm"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Stats card -->
                    <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400 mb-4">
                                    <i class="fas fa-chart-line text-sm"></i>
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Catálogo</h4>
                                <p class="text-3xl font-black text-white">1,200+</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-4">Productos premium activos</p>
                        </div>
                    </div>

                    <!-- Navigation Card -->
                    <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#FF2121]/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121] mb-5">
                                <i class="fas fa-compass text-sm"></i>
                            </div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-white mb-5">Navegación</h4>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-box-open text-xs text-gray-600 group-hover/item:text-[#FF2121] transition"></i> Productos</a></li>
                                <li><a href="#" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-crown text-xs text-gray-600 group-hover/item:text-[#FF2121] transition"></i> Programa VIP</a></li>
                                <li><a href="#" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-plug text-xs text-gray-600 group-hover/item:text-[#FF2121] transition"></i> Plugin Oficial</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-rose-500/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-rose-500/10 border border-rose-500/20 rounded-xl flex items-center justify-center text-rose-400 mb-5">
                                <i class="fas fa-life-ring text-sm"></i>
                            </div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-white mb-5">Ayuda</h4>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-question-circle text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Centro de Ayuda</a></li>
                                <li><a href="#" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-file-contract text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Términos</a></li>
                                <li><a href="#" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-undo-alt text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Reembolso</a></li>
                                <li><a href="#" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-3 group/item"><i class="fas fa-ticket-alt text-xs text-gray-600 group-hover/item:text-rose-400 transition"></i> Soporte</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Newsletter Card -->
                    <div class="md:col-span-2 group relative bg-gradient-to-br from-[#FF2121]/10 via-[#FF2121]/10 to-amber-500/10 border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-[#FF2121]/20 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h4 class="text-sm font-black uppercase tracking-widest text-white mb-1">Newsletter</h4>
                                    <p class="text-gray-400 text-sm">Nuevos productos y actualizaciones directo a tu email.</p>
                                </div>
                                <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-amber-400">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <input type="email" placeholder="tu@email.com" class="flex-1 bg-[#080808]/60 border border-white/10 rounded-2xl px-5 py-3.5 text-sm text-white placeholder:text-gray-600 focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all">
                                <button class="px-6 py-3.5 gradient-bg hover:opacity-90 text-white rounded-2xl text-xs font-black uppercase tracking-wider transition-all shadow-lg shadow-[#FF2121]/20">Suscribir</button>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Card -->
                    <div class="group relative bg-[#0d0d0d]/80 backdrop-blur-sm border border-white/[0.08] rounded-[32px] p-8 overflow-hidden hover:border-white/20 transition-all duration-500">
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#FF2121]/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121] mb-4">
                                <i class="fas fa-shield-alt text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">Pago Seguro</p>
                                <p class="text-xs text-gray-500 mt-1">PayPal, tarjetas y cripto</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-white/[0.06] flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-[11px] font-black text-gray-600 uppercase tracking-widest">© 2026 WP Market. Todos los derechos reservados.</p>
                    <div class="flex items-center gap-6 text-[11px] font-black text-gray-600 uppercase tracking-widest">
                        <a href="#" class="hover:text-white transition">Privacidad</a>
                        <a href="#" class="hover:text-white transition">Cookies</a>
                        <a href="#" class="hover:text-white transition">Licencias</a>
                    </div>
                </div>
            </div>
        </footer>
    </section>

</body>
</html>