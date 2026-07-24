@extends('layouts.frontend')

@section('meta_title', 'Planes de Membresía Premium - GPLWolf')
@section('meta_description', 'Únete al club GPLWolf y descarga más de 5,000 temas y plugins premium de WordPress con descargas ilimitadas, actualizaciones automáticas y 100% seguros.')

@section('content')
<div class="relative overflow-hidden bg-[#050505] text-white pb-20 font-sans" x-data="pricingPage()">
    <!-- Background Effects -->
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[150px] -z-10 animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-yellow-500/5 rounded-full blur-[180px] -z-10"></div>
    <div class="absolute top-[30%] right-0 w-[400px] h-[400px] bg-pink-600/5 rounded-full blur-[130px] -z-10 animate-[float_8s_ease-in-out_infinite]"></div>

    <!-- Limited Time Sticky Alert Banner -->
    <div class="bg-gradient-to-r from-red-600 via-pink-600 to-amber-500 text-white text-xs md:text-sm py-3 px-4 text-center font-black relative z-50 tracking-wider shadow-lg shadow-red-600/20">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-center items-center gap-2">
            <span class="flex items-center gap-1.5 animate-bounce sm:animate-none">
                ⚡ ¡OFERTA DE BIENVENIDA! 10% DE DESCUENTO EXTRA EN CUALQUIER PLAN:
            </span>
            <span class="bg-white/20 px-2 py-0.5 rounded font-mono font-bold text-white tracking-widest text-xs uppercase border border-white/30">
                OFERTA10
            </span>
            <span class="text-white/90 text-xs sm:text-sm font-medium">
                Se aplica automáticamente al dar clic. Expira en:
            </span>
            <span class="font-mono text-yellow-300 font-black text-sm tracking-widest bg-black/30 px-3 py-0.5 rounded border border-yellow-500/20" x-text="timerDisplay">
                14:59
            </span>
        </div>
    </div>

    <!-- Main Header -->
    <div class="max-w-7xl mx-auto px-6 pt-16 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/10 border border-red-500/20 text-xs font-black uppercase text-red-500 tracking-widest mb-6 animate-pulse">
            👑 Acceso Ilimitado
        </span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black tracking-tighter text-white mb-6 leading-none">
            Impulsa tus Sitios Web con<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-amber-500 drop-shadow-sm">Membresía Premium</span>
        </h1>
        <p class="text-gray-400 max-w-2xl mx-auto text-base md:text-lg leading-relaxed mb-12">
            Descarga miles de themes y plugins premium de WordPress con licencia GPL original, archivos 100% limpios y actualizaciones automáticas.
        </p>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch text-left">
            @forelse($plans as $plan)
                @php
                    $isFeatured = $plan->is_featured;
                    
                    // Calculamos precios
                    $originalPrice = (float) $plan->price;
                    $discountedPrice = round($originalPrice * 0.90, 2);
                    
                    // Si el plan es anual simulamos el ahorro
                    $billingType = $plan->duration; // 'monthly', 'yearly', etc.
                    $isYearlyPlan = Str::contains(strtolower($plan->name), ['anual', 'year', 'año']);
                @endphp

                <!-- Pricing Card -->
                <div class="relative bg-gradient-to-b from-white/[0.04] to-transparent border rounded-[36px] p-8 flex flex-col justify-between transition-all duration-500 transform hover:-translate-y-2 group
                    {{ $isFeatured ? 'border-red-500/40 shadow-2xl shadow-red-500/10' : 'border-white/[0.06] hover:border-white/20' }}">

                    <!-- Popular Ribbon -->
                    @if($isFeatured)
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-red-600 to-amber-500 text-white text-[10px] font-black uppercase px-5 py-1.5 rounded-full tracking-widest shadow-lg border border-red-500/30 animate-[pulse_2s_infinite]">
                            ★ MÁS RECOMENDADO ★
                        </div>
                    @endif

                    <div>
                        <!-- Plan Name & Description -->
                        <div class="mb-8">
                            <span class="text-xs font-black uppercase tracking-widest {{ $isFeatured ? 'text-red-500' : 'text-gray-500' }}">
                                {{ $plan->name }}
                            </span>
                            <p class="text-gray-400 text-xs mt-1">{{ $plan->description ?? 'Acceso a los mejores recursos.' }}</p>
                        </div>

                        <!-- Price Section -->
                        <div class="mb-8 p-6 bg-white/[0.02] border border-white/[0.04] rounded-2xl relative overflow-hidden">
                            <!-- Discount Slash Effect -->
                            <div class="absolute top-2 right-4 text-xs font-semibold text-gray-500 line-through">
                                ${{ number_format($originalPrice, 2) }}
                            </div>
                            
                            <div class="flex items-baseline gap-1">
                                <span class="text-5xl font-black tracking-tight text-white">
                                    ${{ number_format($discountedPrice, 2) }}
                                </span>
                                <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">
                                    / @if($plan->duration === 'monthly') mes @elseif($plan->duration === 'yearly') año @else unico @endif
                                </span>
                            </div>
                            
                            <div class="text-[10px] text-emerald-400 font-black uppercase tracking-wider mt-2 flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> ¡Ahorras ${{ number_format($originalPrice - $discountedPrice, 2) }} hoy!
                            </div>
                        </div>

                        <!-- Benefits checklist -->
                        <div class="space-y-4 mb-8">
                            <!-- Download Limit -->
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-check text-[9px] text-emerald-400"></i>
                                </div>
                                <span class="text-sm text-gray-300">
                                    <strong>{{ $plan->daily_download_limit ?: 'Descargas ilimitadas' }}</strong> descargas diarias
                                </span>
                            </div>

                            <!-- Connected Sites Limit -->
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-check text-[9px] text-emerald-400"></i>
                                </div>
                                <span class="text-sm text-gray-300">
                                    Conecta hasta <strong>{{ $plan->sites_limit ?: 'Sitios ilimitados' }}</strong> webs con el plugin oficial
                                </span>
                            </div>

                            <!-- Reward points -->
                            @if($plan->reward_points > 0)
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-check text-[9px] text-emerald-400"></i>
                                </div>
                                <span class="text-sm text-gray-300">
                                    🎁 Recibe <strong>+{{ $plan->reward_points }} puntos VIP</strong> de regalo
                                </span>
                            </div>
                            @endif

                            <!-- Loop Custom Benefits -->
                            @foreach($plan->benefits ?? [] as $benefit)
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fas fa-check text-[9px] text-emerald-400"></i>
                                    </div>
                                    <span class="text-sm text-gray-300 leading-relaxed">{{ $benefit }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Buy CTA Form -->
                    <form action="{{ route('membership.add', $plan) }}?offer=1" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="offer" value="1">
                        <button type="submit" class="w-full relative group py-4 px-6 rounded-2xl font-black text-sm uppercase tracking-wider text-white shadow-xl overflow-hidden transition-all duration-300 hover:scale-[1.03] active:scale-[0.97]
                            {{ $isFeatured 
                                ? 'bg-gradient-to-r from-red-600 to-amber-500 shadow-red-500/20' 
                                : 'bg-white/5 border border-white/10 hover:bg-white/10' }}">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/15 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            <span class="flex items-center justify-center gap-2">
                                Activar Ahora <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 text-gray-500 italic">No hay planes de membresía activos disponibles en este momento.</div>
            @endforelse
        </div>
    </div>

    <!-- Value Propositions Section -->
    <section class="max-w-7xl mx-auto px-6 mt-32">
        <div class="text-center mb-16">
            <span class="text-red-500 font-bold uppercase tracking-widest text-xs mb-3 block">✓ Beneficios GPLWolf</span>
            <h2 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-4">Todo lo que Necesitas para tu Negocio</h2>
            <p class="text-gray-500 max-w-lg mx-auto text-sm">Ahorra miles de dólares en suscripciones individuales de plugins y temas de WordPress.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(239,68,68,0.15)]">
                    <i class="fas fa-shield-virus"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">100% Libre de Malware</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Escaneamos y auditamos cada archivo periódicamente para garantizar que no contengan código malicioso ni virus.
                </p>
            </div>
            
            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(245,158,11,0.15)]">
                    <i class="fas fa-sync-alt animate-spin-slow"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Actualizaciones de por Vida</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Accede a las últimas actualizaciones de tus plugins favoritos de manera inmediata. Subimos versiones nuevas todos los días.
                </p>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
                    <i class="fas fa-plug"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Plugin de Auto-Actualización</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Usa nuestro plugin oficial para conectar tu WordPress y actualizar temas y plugins directamente desde el escritorio.
                </p>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] p-8 rounded-3xl hover:border-white/10 transition-colors">
                <div class="w-12 h-12 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-[0_0_15px_rgba(59,130,246,0.15)]">
                    <i class="fas fa-infinity"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Licencia GPL Ilimitada</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Usa los productos en tantos sitios web como desees. El software GPL no está limitado por dominios.
                </p>
            </div>
        </div>
    </section>

    <!-- Comparison Matrix Table -->
    <section class="max-w-4xl mx-auto px-6 mt-32">
        <div class="text-center mb-16">
            <span class="text-[#FF2121] font-bold uppercase tracking-widest text-xs mb-3 block">⚡ Comparativa de Ahorro</span>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-white mb-4">¿Por qué Elegir una Membresía?</h2>
            <p class="text-gray-500 text-sm">Hacemos los números simples para tu bolsillo.</p>
        </div>

        <div class="bg-white/[0.02] border border-white/[0.06] rounded-[32px] overflow-hidden shadow-2xl backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-white/[0.06] bg-white/[0.02]">
                            <th class="p-6 text-sm font-black uppercase text-gray-400 tracking-wider">Beneficios & Recursos</th>
                            <th class="p-6 text-sm font-black uppercase text-red-500 tracking-wider text-center">Compra de Plugin Único</th>
                            <th class="p-6 text-sm font-black uppercase text-white tracking-wider text-center bg-red-600/15">Membresía Premium</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04] text-sm">
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Descargas instantáneas</td>
                            <td class="p-6 text-center text-gray-500">Solo 1 producto</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5">Acceso a +5,000 archivos</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Actualizaciones automáticas con Plugin</td>
                            <td class="p-6 text-center text-red-500"><i class="fas fa-times-circle"></i> No disponible</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5"><i class="fas fa-check-circle"></i> Incluido</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Uso en sitios ilimitados</td>
                            <td class="p-6 text-center text-emerald-400"><i class="fas fa-check-circle"></i> Sí</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5"><i class="fas fa-check-circle"></i> Sí</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Soporte Técnico de instalación</td>
                            <td class="p-6 text-center text-gray-500">Limitado</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5">Soporte Prioritario 24/7</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-gray-300">Solicitar actualizaciones / nuevos recursos</td>
                            <td class="p-6 text-center text-red-500"><i class="fas fa-times-circle"></i> No</td>
                            <td class="p-6 text-center text-emerald-400 font-bold bg-red-600/5"><i class="fas fa-check-circle"></i> Sí, ilimitadas</td>
                        </tr>
                        <tr class="bg-white/[0.01]">
                            <td class="p-6 font-black text-white text-base">Costo Promedio Estimado</td>
                            <td class="p-6 text-center text-gray-400 font-bold text-base">$30 - $80 por plugin</td>
                            <td class="p-6 text-center text-yellow-400 font-black text-xl bg-red-600/10">Un solo pago mínimo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="max-w-3xl mx-auto px-6 mt-32">
        <div class="text-center mb-16">
            <span class="text-red-500 font-bold uppercase tracking-widest text-xs mb-3 block">❓ Preguntas Frecuentes</span>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight text-white mb-4">¿Tienes alguna duda?</h2>
            <p class="text-gray-500 text-sm">Resolvemos tus inquietudes de inmediato.</p>
        </div>

        <div class="space-y-4">
            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 1 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 1 ? null : 1">
                    <span>¿Qué tipo de licencia tienen los archivos?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 1 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 1" x-transition>
                    Todos los plugins y temas de WordPress distribuidos en GPLWolf poseen una licencia pública general (GPL). Esto significa que son 100% legales para descargar, modificar y usar en tantos dominios como consideres oportuno.
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 2 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 2 ? null : 2">
                    <span>¿Son originales y limpios los plugins?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 2 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 2" x-transition>
                    Sí, absolutamente. Descargamos los archivos directamente de los autores originales y los distribuimos tal cual, sin modificaciones (sin nulled scripts, sin virus ni anuncios). Todos los archivos pasan por análisis de virus recurrentes.
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 3 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 3 ? null : 3">
                    <span>¿Cómo se actualizan los complementos?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 3 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 3" x-transition>
                    Puedes actualizarlos manualmente descargándolos del panel de GPLWolf y resubiéndolos en tu sitio, o bien instalar nuestro plugin oficial de GPLWolf. Este te permite actualizar de forma automatizada con un solo clic desde tu propio panel de administración de WordPress.
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 4 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 4 ? null : 4">
                    <span>¿Hay límites de descarga diaria?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 4 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 4" x-transition>
                    Los límites de descarga dependen del plan seleccionado. El plan Básico está limitado a 5 descargas diarias para prevenir abusos, mientras que el plan Pro cuenta con descargas ilimitadas o límites muy altos definidos en tu panel.
                </div>
            </div>
            
            <div class="bg-white/[0.02] border border-white/[0.04] rounded-2xl overflow-hidden transition-colors" :class="activeFaq === 5 ? 'border-red-500/20' : ''">
                <button class="w-full flex items-center justify-between p-6 text-left font-bold text-white transition-colors hover:text-red-400"
                        @click="activeFaq = activeFaq === 5 ? null : 5">
                    <span>¿Existe política de reembolso?</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="activeFaq === 5 ? 'rotate-180 text-red-500' : ''"></i>
                </button>
                <div class="px-6 pb-6 text-sm text-gray-400 leading-relaxed" x-show="activeFaq === 5" x-transition>
                    Sí, ofrecemos una garantía de reembolso de 7 días. Si alguno de los archivos descargados presenta problemas técnicos demostrables que nuestro equipo de soporte no pueda resolver, te reembolsaremos la totalidad de tu suscripción.
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Symbols & Payment Badges -->
    <div class="max-w-7xl mx-auto px-6 mt-32 text-center">
        <p class="text-xs font-black text-gray-500 uppercase tracking-[0.25em] mb-8">Pago 100% Seguro y Encriptado</p>
        <div class="flex flex-wrap justify-center items-center gap-8 opacity-45 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-500">
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-paypal"></i> PayPal</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-stripe"></i> Stripe</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-visa"></i> Visa</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-cc-mastercard"></i> MasterCard</span>
            <span class="text-2xl font-bold flex items-center gap-1.5"><i class="fab fa-bitcoin"></i> Cripto/Binance</span>
        </div>
    </div>
</div>

<script>
    function pricingPage() {
        return {
            activeFaq: 1,       // active FAQ index
            timer: 15 * 60,     // 15 minutes in seconds
            timerDisplay: '15:00',

            init() {
                // Initialize Countdown Timer
                const interval = setInterval(() => {
                    if (this.timer <= 0) {
                        // Reset timer back to 15m to maintain fake urgency
                        this.timer = 15 * 60;
                    }
                    this.timer--;
                    const minutes = Math.floor(this.timer / 60);
                    const seconds = this.timer % 60;
                    this.timerDisplay = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                }, 1000);
            }
        }
    }
</script>

<style>
    .animate-spin-slow {
        animation: spin 8s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endsection
