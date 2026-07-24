@extends('layouts.admin')

@section('title', 'Redactar Boletín')

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.newsletter.index') }}" class="w-10 h-10 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-white transition-all">
        <i class="fas fa-arrow-left text-xs"></i>
    </a>
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Redactar Boletín</h1>
        <p class="text-gray-500 text-sm mt-1">Envía una nueva campaña u oferta a todos tus suscriptores activos.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6">
            <form action="{{ route('admin.newsletter.send-mail') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Asunto del Correo</label>
                    <input type="text" name="subject" required placeholder="Ej: ¡Oferta Exclusiva! 50% de descuento en todos nuestros plugins" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-bold placeholder-gray-700">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Cuerpo / Contenido del Boletín</label>
                    <textarea name="content" required rows="10" placeholder="Escribe el mensaje o la oferta aquí..." class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder-gray-700 leading-relaxed"></textarea>
                </div>

                <button type="submit" class="w-full bg-[#F51B1B] hover:bg-[#FF2121] text-white py-4 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-lg shadow-[#F51B1B]/20">
                    Enviar Boletín a {{ $subscribersCount }} Suscriptores
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white mb-4">Información de Campaña</h3>
            <div class="space-y-4 text-xs">
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-500">Destinatarios Activos</span>
                    <span class="font-bold text-white font-mono">{{ $subscribersCount }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-500">Estado del envío</span>
                    <span class="font-bold text-emerald-400">Listo para Encolar</span>
                </div>
                <div class="p-3 bg-white/5 rounded-xl border border-white/10">
                    <p class="text-gray-400 leading-relaxed text-[11px]">
                        <strong>Nota de rendimiento:</strong> Los correos se envían en segundo plano utilizando el sistema de colas (Queue) de Laravel para no ralentizar el servidor.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
