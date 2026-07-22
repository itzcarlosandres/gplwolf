@extends('layouts.user')

@section('title', 'Soporte Técnico')

@section('content')
<div class="space-y-10 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-white leading-tight">Soporte Técnico</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">¿Tienes alguna duda o problema? Estamos para ayudarte.</p>
        </div>
        <a href="{{ route('user.support.create') }}" class="px-8 py-4 gradient-bg rounded-2xl text-xs font-black uppercase tracking-widest text-white shadow-xl shadow-[#F51B1B]/20 hover:scale-105 transition-all">
            Nuevo Ticket <i class="fas fa-plus ml-2"></i>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-bold flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($tickets as $ticket)
            <a href="{{ route('user.support.show', $ticket) }}" class="glass p-8 rounded-[40px] border-white/5 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden group hover:bg-white/5 transition-all">
                <div class="w-16 h-16 bg-gray-900 rounded-[28px] flex-shrink-0 flex items-center justify-center text-2xl shadow-inner border border-white/5">
                    @if($ticket->status === 'open')
                        <i class="fas fa-envelope-open text-amber-500"></i>
                    @elseif($ticket->status === 'answered')
                        <i class="fas fa-comment-dots text-emerald-500"></i>
                    @else
                        <i class="fas fa-lock text-gray-600"></i>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 bg-white/5 rounded-lg text-[9px] font-black uppercase tracking-widest border border-white/10
                            {{ $ticket->priority === 'high' ? 'text-rose-400 border-rose-500/20' : ($ticket->priority === 'medium' ? 'text-amber-400 border-amber-500/20' : 'text-[#FF2121] border-[#FF2121]/20') }}">
                            Prioridad {{ $ticket->priority }}
                        </span>
                        <span class="text-[10px] font-black text-gray-600 uppercase tracking-widest">
                            ID #{{ $ticket->id }}
                        </span>
                    </div>
                    <h3 class="text-xl font-black text-white group-hover:text-[#FF2121] transition-colors uppercase truncate">
                        {{ $ticket->subject }}
                    </h3>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mt-1">
                        Creado hace {{ $ticket->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="flex flex-col items-center md:items-end gap-3 shrink-0">
                    <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border 
                        {{ $ticket->status === 'open' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : ($ticket->status === 'answered' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-white/5 text-gray-500 border-white/10') }}">
                        {{ $ticket->status === 'open' ? 'Abierto' : ($ticket->status === 'answered' ? 'Respondido' : 'Cerrado') }}
                    </span>
                    <i class="fas fa-chevron-right text-gray-700 group-hover:text-[#FF2121] transition-all group-hover:translate-x-1"></i>
                </div>
            </a>
        @empty
            <div class="py-32 text-center group">
                <div class="opacity-20 flex flex-col items-center group-hover:opacity-40 transition-opacity">
                    <i class="fas fa-headset text-7xl mb-6"></i>
                    <p class="text-2xl font-black uppercase tracking-widest">No tienes tickets abiertos</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $tickets->links() }}
    </div>
</div>
@endsection