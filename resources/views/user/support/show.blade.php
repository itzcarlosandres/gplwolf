@extends('layouts.user')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
<div class="max-w-4xl mx-auto pb-20 space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <a href="{{ route('user.support.index') }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-gray-500 hover:text-white transition-colors gap-2 mb-6">
                <i class="fas fa-arrow-left text-[10px]"></i> Volver a Mis Tickets
            </a>
            <h1 class="text-4xl font-black text-white leading-tight">Ticket #{{ $ticket->id }}</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">{{ $ticket->subject }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest border 
                {{ $ticket->status === 'open' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : ($ticket->status === 'answered' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-white/5 text-gray-500 border-white/10') }}">
                {{ $ticket->status === 'open' ? 'Abierto' : ($ticket->status === 'answered' ? 'Respondido' : 'Cerrado') }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-bold flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Messages Thread -->
    <div class="space-y-8">
        @foreach($ticket->messages as $message)
            <div class="glass p-10 rounded-[48px] border-white/5 relative overflow-hidden {{ $message->is_admin ? 'bg-[#FF2121]/5 border-[#FF2121]/20' : '' }}">
                <div class="flex items-center gap-4 mb-8">
                    @if($message->is_admin)
                        <div class="w-12 h-12 gradient-bg rounded-2xl shadow-xl flex items-center justify-center text-white">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-black uppercase text-xs tracking-widest">Soporte Técnico</h4>
                            <p class="text-[10px] text-[#FF2121] font-bold uppercase tracking-widest">Respuesta Oficial • {{ $message->created_at->format('d M, Y H:i') }}</p>
                        </div>
                        <div class="ml-auto px-4 py-1.5 bg-emerald-500/10 rounded-xl text-[9px] font-black text-emerald-400 uppercase tracking-widest border border-emerald-500/20">Staff</div>
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($message->user->name) }}&background=6366f1&color=fff&bold=true" class="w-12 h-12 rounded-2xl shadow-xl">
                        <div>
                            <h4 class="text-white font-black uppercase text-xs tracking-widest">{{ $message->user->name }}</h4>
                            <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">{{ $message->created_at->format('d M, Y H:i') }}</p>
                        </div>
                        <div class="ml-auto px-4 py-1.5 bg-white/5 rounded-xl text-[9px] font-black text-gray-400 uppercase tracking-widest border border-white/10">Tú</div>
                    @endif
                </div>
                <div class="text-gray-300 leading-relaxed text-sm whitespace-pre-line">
                    {{ $message->message }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- User Reply Form -->
    @if($ticket->status !== 'closed')
        <div class="glass p-10 rounded-[48px] border-white/5 relative overflow-hidden bg-white/[0.01]">
            <h3 class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center gap-3">
                <i class="fas fa-reply text-[#FF2121]"></i> Responder al Ticket
            </h3>
            
            <form action="{{ route('user.support.reply', $ticket) }}" method="POST" class="space-y-6">
                @csrf
                <textarea name="message" rows="6" required 
                    class="w-full bg-white/5 border border-white/10 rounded-3xl px-6 py-5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700 resize-none leading-relaxed"
                    placeholder="Escribe tu respuesta o más información aquí..."></textarea>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-10 py-5 gradient-bg rounded-2xl text-[10px] font-black uppercase tracking-widest text-white shadow-2xl shadow-[#F51B1B]/40 transform hover:scale-105 active:scale-95 transition-all">
                        Enviar Respuesta <i class="fas fa-paper-plane ml-3"></i>
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="p-10 text-center border-2 border-dashed border-white/5 rounded-[48px]">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-600">Este ticket está cerrado y no acepta más respuestas.</p>
        </div>
    @endif
</div>
@endsection