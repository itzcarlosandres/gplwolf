@extends('layouts.frontend')

@section('title', 'Centro de Ayuda')

@section('content')
<div class="pt-32 pb-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-black text-white mb-6 tracking-tighter">¿Cómo podemos <span class="text-[#FF2121]">ayudarte?</span></h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">Nuestro equipo está listo para resolver tus dudas sobre instalación, descargas y cuentas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <!-- Ticket Support Card -->
            <div class="glass p-8 rounded-[30px] border border-white/5 hover:border-[#FF2121]/30 transition-all group relative overflow-hidden">
                <div class="absolute inset-0 bg-[#F51B1B]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-14 h-14 rounded-2xl bg-[#F51B1B] flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-[#F51B1B]/30">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Soporte Técnico</h3>
                <p class="text-gray-400 mb-8 leading-relaxed">
                    Si tienes problemas con una descarga, un archivo corrupto o dudas sobre tu membresía, abre un ticket directo con nuestro equipo.
                </p>
                @auth
                    <a href="{{ route('user.support.index') }}" class="inline-flex items-center gap-2 text-[#FF2121] font-bold uppercase tracking-wider text-sm hover:text-white transition-colors">
                        Ir a Mis Tickets <i class="fas fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[#FF2121] font-bold uppercase tracking-wider text-sm hover:text-white transition-colors">
                        Inicia Sesión para Soporte <i class="fas fa-arrow-right"></i>
                    </a>
                @endauth
            </div>

            <!-- General Inquiries -->
            <div class="glass p-8 rounded-[30px] border border-white/5 hover:border-[#FF2121]/30 transition-all group relative overflow-hidden">
                <div class="absolute inset-0 bg-[#F51B1B]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-14 h-14 rounded-2xl bg-[#F51B1B] flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-[#F51B1B]/40">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Consultas Generales</h3>
                <p class="text-gray-400 mb-8 leading-relaxed">
                    Para dudas pre-venta, asociaciones, reportes de copyright o cualquier otro tema no técnico.
                </p>
                <a href="mailto:{{ $globalSettings['support_email'] ?? 'contacto@ejemplo.com' }}" class="inline-flex items-center gap-2 text-[#FF2121] font-bold uppercase tracking-wider text-sm hover:text-white transition-colors">
                    Enviar Email <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <h2 class="text-3xl font-black text-white mb-8">Preguntas Frecuentes</h2>
        <div class="space-y-4" x-data="{ active: null }">
            @php
                $faqs = [
                    [
                        'q' => '¿Los productos son originales?',
                        'a' => 'Sí, todos los archivos son 100% originales bajo licencia GPL. No contienen malware ni publicidad inyectada.'
                    ],
                    [
                        'q' => '¿Cómo funcionan las actualizaciones?',
                        'a' => 'Debedes descargar la nueva versión desde tu panel de usuario y reemplazar los archivos en tu servidor manualmente. No ofrecemos claves de licencia para auto-update.'
                    ],
                    [
                        'q' => '¿Puedo usar los productos en dominios ilimitados?',
                        'a' => 'Sí, la licencia GPL te permite usar los plugins y temas en tantos sitios web como desees.'
                    ],
                    [
                        'q' => '¿Ofrecen reembolso?',
                        'a' => 'Solo si el archivo está roto y no podemos arreglarlo. Revisa nuestra Política de Reembolso para más detalles.'
                    ]
                ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="glass rounded-2xl border border-white/5 overflow-hidden">
                <button @click="active = active === {{ $i }} ? null : {{ $i }}" class="w-full p-6 text-left flex justify-between items-center outline-none">
                    <span class="font-bold text-white">{{ $faq['q'] }}</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': active === {{ $i }} }"></i>
                </button>
                <div x-show="active === {{ $i }}" x-collapse class="px-6 pb-6 text-gray-400 text-sm leading-relaxed border-t border-white/5 pt-4">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection