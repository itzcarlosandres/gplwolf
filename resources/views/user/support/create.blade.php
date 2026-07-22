@extends('layouts.user')

@section('title', 'Nuevo Ticket de Soporte')

@section('content')
<div class="max-w-3xl mx-auto pb-20">
    <div class="mb-10">
        <a href="{{ route('user.support.index') }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-gray-500 hover:text-white transition-colors gap-2 mb-6">
            <i class="fas fa-arrow-left text-[10px]"></i> Volver a Soporte
        </a>
        <h1 class="text-4xl font-black text-white leading-tight">Abrir Ticket</h1>
        <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Cuéntanos en qué podemos ayudarte hoy.</p>
    </div>

    <div class="glass p-10 rounded-[48px] border-white/5 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#F51B1B]/5 blur-[100px] rounded-full"></div>

        <form action="{{ route('user.support.store') }}" method="POST" class="space-y-8 relative z-10">
            @csrf
            
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Asunto de la consulta</label>
                <input type="text" name="subject" required 
                    class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-medium focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700"
                    placeholder="Ej: Problema con la licencia de GeneratePress">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Prioridad</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="priority" value="low" class="hidden peer">
                            <div class="py-3 text-center rounded-xl bg-white/5 border border-white/10 text-[10px] font-black uppercase text-gray-500 peer-checked:bg-[#F51B1B] peer-checked:text-white peer-checked:border-[#FF2121] transition-all">Baja</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="priority" value="medium" checked class="hidden peer">
                            <div class="py-3 text-center rounded-xl bg-white/5 border border-white/10 text-[10px] font-black uppercase text-gray-500 peer-checked:bg-[#F51B1B] peer-checked:text-white peer-checked:border-[#FF2121] transition-all">Media</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="priority" value="high" class="hidden peer">
                            <div class="py-3 text-center rounded-xl bg-white/5 border border-white/10 text-[10px] font-black uppercase text-gray-500 peer-checked:bg-rose-600 peer-checked:text-white peer-checked:border-rose-500 transition-all">Alta</div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Mensaje Detallado</label>
                <textarea name="message" rows="8" required 
                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-6 py-5 text-white font-medium focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700 leading-relaxed resize-none"
                    placeholder="Describe tu problema con el mayor detalle posible para ayudarte más rápido..."></textarea>
            </div>

            <button type="submit" class="w-full py-6 gradient-bg rounded-3xl text-xs font-black uppercase tracking-[0.3em] text-white shadow-2xl shadow-[#F51B1B]/40 transform hover:scale-[1.02] active:scale-95 transition-all">
                Enviar Ticket <i class="fas fa-paper-plane ml-3 text-[10px]"></i>
            </button>
        </form>
    </div>
</div>
@endsection