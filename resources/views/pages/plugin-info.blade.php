@extends('layouts.frontend')

@section('meta_title', 'Plugin Oficial GPLWolf - Gestor de Actualizaciones')
@section('meta_description', 'Descarga el plugin oficial de GPLWolf para WordPress. Actualizaciones automáticas, instalación en 1 clic y gestión de licencias centralizada.')

@section('content')
<div class="relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[800px] bg-gradient-to-b from-[#F51B1B]/20 to-transparent -z-10 pointer-events-none"></div>
    <div class="absolute top-20 right-0 w-[500px] h-[500px] bg-pink-600/10 blur-[120px] rounded-full -z-10 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#F51B1B]/10 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-20 pb-32 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-8 animate-fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#FF2121]/30 bg-[#FF2121]/10 text-[#FF2121] text-sm font-bold uppercase tracking-wider backdrop-blur-md">
                <i class="fas fa-bolt text-yellow-400"></i> v2.0 Disponible
            </div>
            
            <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] tracking-tight">
                El Puente entre <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF2121] via-[#F51B1B] to-pink-400">Tu WordPress</span>
                y GPLWolf.
            </h1>
            
            <p class="text-xl text-slate-400 leading-relaxed max-w-xl">
                Olvídate de subir archivos FTP manualmente. Conecta tu sitio, valida tu licencia y recibe actualizaciones de tus recursos premium directamente en tu panel de WordPress.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="{{ route('pages.plugin.download') }}" class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-bold text-lg shadow-[0_0_40px_-10px_rgba(255,255,255,0.3)] hover:scale-105 transition-transform flex items-center justify-center gap-3 group" download>
                    <i class="fab fa-wordpress text-2xl group-hover:rotate-12 transition-transform"></i>
                    Descargar Plugin
                </a>
                <a href="#como-funciona" class="px-8 py-4 mesh-card rounded-2xl font-bold text-lg hover:bg-white/10 transition-colors flex items-center justify-center text-white">
                    ¿Cómo funciona?
                </a>
            </div>

            <div class="flex items-center gap-4 text-sm text-slate-500 pt-4">
                <div class="flex items-center gap-1">
                    <i class="fas fa-check-circle text-emerald-500"></i> Seguro
                </div>
                <div class="flex items-center gap-1">
                    <i class="fas fa-check-circle text-emerald-500"></i> Ligero (< 2MB)
                </div>
                <div class="flex items-center gap-1">
                    <i class="fas fa-check-circle text-emerald-500"></i> Compatible con WP 6.0+
                </div>
            </div>
        </div>

        <!-- 3D Abstract Representation -->
        <div class="relative hidden lg:block perspective-1000">
            <!-- Central Connector -->
            <div class="relative z-10 w-full aspect-square bg-gradient-to-br from-slate-800 to-slate-900 rounded-[3rem] border border-white/10 shadow-2xl p-8 flex flex-col items-center justify-center transform rotate-y-12 rotate-x-6 hover:rotate-0 transition-transform duration-700 backdrop-blur-xl">
                
                <!-- Floating Icons Animation -->
                <div class="absolute inset-0 overflow-hidden rounded-[3rem]">
                    <i class="fab fa-elementor absolute top-10 left-10 text-4xl text-pink-500/20 animate-pulse"></i>
                    <i class="fab fa-yoast absolute bottom-20 right-10 text-4xl text-yellow-500/20 animate-pulse" style="animation-delay: 1s"></i>
                    <i class="fas fa-shopping-cart absolute top-1/2 right-10 text-4xl text-[#F51B1B]/20 animate-pulse" style="animation-delay: 2s"></i>
                </div>

                <div class="w-32 h-32 bg-gradient-to-tr from-[#FF2121] to-[#F51B1B] rounded-3xl flex items-center justify-center shadow-[0_0_60px_rgba(245, 27, 27, 0.5)] mb-8 relative z-20">
                    <i class="fas fa-sync-alt text-5xl text-white animate-spin-slow"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-2">Sincronización Total</h3>
                <p class="text-slate-400 text-center text-sm px-8">
                    Tus licencias se validan en tiempo real. Si un producto tiene update, te avisamos al instante.
                </p>

                <!-- Status Badge -->
                <div class="mt-8 bg-emerald-500/10 border border-emerald-500/20 px-4 py-2 rounded-full flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Estado: Online</span>
                </div>
            </div>

            <!-- Back Card (Decoration) -->
            <div class="absolute top-10 -right-10 w-full h-full bg-white/5 rounded-[3rem] -z-10 border border-white/5 transform rotate-6 scale-95 blur-sm"></div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="max-w-7xl mx-auto px-6 mb-32">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Poderoso. Invisible.</h2>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg">
                Diseñado para trabajar en segundo plano sin ralentizar tu sitio web ni molestar a tus clientes.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="mesh-card p-10 rounded-[2.5rem] hover:bg-white/10 transition-colors group">
                <div class="w-14 h-14 bg-[#FF2121]/10 rounded-2xl flex items-center justify-center text-[#FF2121] mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-magic text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">1-Click Updates</h3>
                <p class="text-slate-400 leading-relaxed">
                    Actualiza plugins y themes premium como si fueran del repositorio oficial de WordPress. Un clic y listo.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="mesh-card p-10 rounded-[2.5rem] hover:bg-white/10 transition-colors group">
                <div class="w-14 h-14 bg-[#F51B1B]/10 rounded-2xl flex items-center justify-center text-[#F51B1B] mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-secret text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Modo Marca Blanca</h3>
                <p class="text-slate-400 leading-relaxed">
                    Oculta nuestra marca. Tus clientes verán "Tu Agencia Updater" en lugar de GPLWolf. Ideal para revendedores.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="mesh-card p-10 rounded-[2.5rem] hover:bg-white/10 transition-colors group">
                <div class="w-14 h-14 bg-pink-500/10 rounded-2xl flex items-center justify-center text-pink-400 mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Gestor de Licencias</h3>
                <p class="text-slate-400 leading-relaxed">
                    Controla en qué dominios se usan tus recursos. Bloquea o desbloquea sitios remotamente desde tu panel.
                </p>
            </div>
        </div>
    </section>

    <!-- How it Works (Steps) -->
    <section id="como-funciona" class="max-w-6xl mx-auto px-6 mb-32">
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 border border-white/10 rounded-[3rem] p-8 md:p-16 relative overflow-hidden">
            <!-- Decor -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-[80px] -z-0"></div>

            <div class="relative z-10">
                <h2 class="text-3xl font-black text-white mb-12 text-center">Instalación en 3 Pasos</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                    <!-- Connector Line (Desktop) -->
                    <div class="hidden md:block absolute top-12 left-20 right-20 h-0.5 bg-gradient-to-r from-[#FF2121] via-[#F51B1B] to-[#F51B1B] -z-10"></div>

                    <!-- Step 1 -->
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-[#0d0d0d] border-4 border-slate-700 rounded-full flex items-center justify-center text-3xl font-black text-white shadow-xl mb-6 relative z-10">
                            1
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">Descarga el .ZIP</h4>
                        <p class="text-slate-400 text-sm">Obtén el archivo del plugin desde esta misma página.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-[#0d0d0d] border-4 border-[#F51B1B] rounded-full flex items-center justify-center text-3xl font-black text-white shadow-xl shadow-[#F51B1B]/50 mb-6 relative z-10">
                            2
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">Sube a WordPress</h4>
                        <p class="text-slate-400 text-sm">Ve a Plugins > Añadir Nuevo > Subir Plugin e instálalo.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-[#0d0d0d] border-4 border-emerald-500 rounded-full flex items-center justify-center text-3xl font-black text-white shadow-xl shadow-emerald-900/50 mb-6 relative z-10">
                            3
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">Conecta tu API Key</h4>
                        <p class="text-slate-400 text-sm">Copia tu llave maestra desde tu perfil y pégala en el plugin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technical Specs -->
    <section class="max-w-4xl mx-auto px-6 mb-24 border-t border-white/5 pt-16">
        <h3 class="text-xl font-bold text-white mb-8 text-center uppercase tracking-widest">Especificaciones Técnicas</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                 <div class="text-3xl font-black text-white mb-1">8.1+</div>
                 <div class="text-xs font-bold text-slate-500 uppercase">PHP Version</div>
            </div>
            <div>
                 <div class="text-3xl font-black text-white mb-1">6.0+</div>
                 <div class="text-xs font-bold text-slate-500 uppercase">WordPress</div>
            </div>
            <div>
                 <div class="text-3xl font-black text-white mb-1">100%</div>
                 <div class="text-xs font-bold text-slate-500 uppercase">GPL Freedoms</div>
            </div>
            <div>
                 <div class="text-3xl font-black text-white mb-1">< 1s</div>
                 <div class="text-xs font-bold text-slate-500 uppercase">Load Time</div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="mb-20 px-6">
        <div class="max-w-5xl mx-auto bg-gradient-to-r from-[#FF2121] to-[#F51B1B] rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
            <!-- Glows -->
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-150"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-8">Empieza a automatizar hoy.</h2>
                <a href="{{ route('pages.plugin.download') }}" class="inline-block px-12 py-5 bg-white text-[#F51B1B] rounded-full font-black text-xl shadow-xl hover:scale-105 hover:bg-[#FF2121]/5 transition-all transform active:scale-95" download>
                    <i class="fas fa-download mr-2"></i> Descargar Plugin Gratis
                </a>
                <p class="mt-6 text-[#FF2121] text-sm font-medium">Versión 2.1.0 • Actualizado Ene 2026 • 150KB</p>
            </div>
        </div>
    </section>

</div>

<style>
    .perspective-1000 { perspective: 1000px; }
    .rotate-y-12 { transform: rotateY(12deg); }
    .rotate-x-6 { transform: rotateX(6deg); }
    .animate-spin-slow { animation: spin 8s linear infinite; }
</style>
@endsection