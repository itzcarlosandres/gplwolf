@extends('layouts.frontend')

@section('title', 'Política de Reembolso')

@section('content')
<div class="pt-32 pb-20">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tighter">Política de <span class="text-[#FF2121]">Reembolso</span></h1>
            <p class="text-gray-400 text-lg">Transparencia y claridad para productos digitales.</p>
        </div>
        
        <div class="glass p-10 rounded-[40px] border border-white/5 space-y-8 relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#F51B1B]/10 rounded-full blur-[80px] pointer-events-none -mr-32 -mt-32"></div>

            <div class="p-6 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-start gap-4">
                <i class="fas fa-exclamation-triangle text-rose-500 text-xl mt-1"></i>
                <div>
                    <h3 class="font-bold text-white mb-2">Naturaleza de los Productos Digitales</h3>
                    <p class="text-sm text-gray-400">
                        Debido a la naturaleza irrevocable de los productos digitales (software descargable), <strong>no realizamos reembolsos una vez que el producto ha sido descargado</strong> o accedido, tal como se establece en las leyes de protección al consumidor para bienes digitales.
                    </p>
                </div>
            </div>

            <section>
                <h3 class="font-bold text-white text-lg mb-4">¿Cuándo SÍ ofrecemos reembolso?</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-500 flex-shrink-0 mt-0.5"><i class="fas fa-check text-xs"></i></div>
                        <p class="text-gray-400 text-sm">Si el archivo descargado está corrupto o técnicamente defectuoso y nuestro equipo de soporte no puede resolver el problema ni proporcionar un archivo funcional.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-500 flex-shrink-0 mt-0.5"><i class="fas fa-check text-xs"></i></div>
                        <p class="text-gray-400 text-sm">Si el producto descargado es completamente diferente al descrito en la página del producto.</p>
                    </div>
                </div>
            </section>

            <section>
                <h3 class="font-bold text-white text-lg mb-4">¿Cuándo NO ofrecemos reembolso?</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-gray-700/50 flex items-center justify-center text-gray-500 flex-shrink-0 mt-0.5"><i class="fas fa-times text-xs"></i></div>
                        <p class="text-gray-400 text-sm">Si simplemente "cambió de opinión" después de descargar.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-gray-700/50 flex items-center justify-center text-gray-500 flex-shrink-0 mt-0.5"><i class="fas fa-times text-xs"></i></div>
                        <p class="text-gray-400 text-sm">Si no tiene los conocimientos técnicos suficientes para instalar o utilizar el producto (WordPress, Hosting, etc.).</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-gray-700/50 flex items-center justify-center text-gray-500 flex-shrink-0 mt-0.5"><i class="fas fa-times text-xs"></i></div>
                        <p class="text-gray-400 text-sm">Si el producto no incluye una "License Key" para actualizaciones automáticas (esto se especifica en los Términos de Uso).</p>
                    </div>
                </div>
            </section>

            <div class="text-center pt-8 border-t border-white/5">
                <p class="text-sm text-gray-500 mb-4">Si cree que califica para un reembolso, por favor contáctenos:</p>
                <a href="{{ route('pages.help') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl font-bold transition-all shadow-lg shadow-[#F51B1B]/20">
                    <i class="fas fa-envelope"></i> Contactar Soporte
                </a>
            </div>

        </div>
    </div>
</div>
@endsection