@extends('layouts.admin')

@section('title', 'Atender Ticket #' . $ticket->id)

@section('content')
<div class="space-y-10 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center">
            <a href="{{ route('admin.tickets.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
                <i class="fas fa-arrow-left text-xs"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Ticket #{{ $ticket->id }}</h1>
                <p class="text-gray-400 mt-1">Usuario: <span class="text-[#FF2121] font-bold">{{ $ticket->user->name }}</span></p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            @if($ticket->status !== 'closed')
                <form action="{{ route('admin.tickets.close', $ticket) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-6 py-3 bg-white/5 hover:bg-rose-600/10 hover:text-rose-400 text-gray-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/10 hover:border-rose-500/20 transition-all">
                        Cerrar Ticket <i class="fas fa-lock ml-2"></i>
                    </button>
                </form>
            @endif
            <span class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest border 
                {{ $ticket->status === 'open' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : ($ticket->status === 'answered' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-white/5 text-gray-500 border-white/10') }}">
                Estado: {{ $ticket->status }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-bold flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Ticket Conversation -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Message History -->
            <div class="space-y-6">
                @foreach($ticket->messages as $message)
                    <div class="p-8 rounded-[40px] border relative overflow-hidden {{ $message->is_admin ? 'bg-[#F51B1B]/10 border-[#FF2121]/20' : 'bg-gray-800/20 border-white/5 shadow-2xl' }}">
                        <div class="flex items-center gap-4 mb-6">
                            @if($message->is_admin)
                                <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center text-white"><i class="fas fa-user-shield"></i></div>
                                <div>
                                    <h4 class="text-white font-black uppercase text-xs tracking-widest">Tú (Staff)</h4>
                                    <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">{{ $message->created_at->format('d M, Y H:i') }}</p>
                                </div>
                                <div class="ml-auto px-4 py-1 bg-emerald-500/10 rounded-lg text-[9px] font-black text-emerald-400 uppercase border border-emerald-500/20">Respuesta Oficial</div>
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($message->user->name) }}&background=6366f1&color=fff&bold=true" class="w-12 h-12 rounded-2xl">
                                <div>
                                    <h4 class="text-white font-black uppercase text-xs tracking-widest">{{ $message->user->name }}</h4>
                                    <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">{{ $message->created_at->format('d M, Y H:i') }}</p>
                                </div>
                                <div class="ml-auto px-4 py-1 bg-[#FF2121]/10 rounded-lg text-[9px] font-black text-[#FF2121] uppercase border border-[#FF2121]/20">Cliente</div>
                            @endif
                        </div>
                        <div class="text-gray-300 leading-relaxed text-sm whitespace-pre-line">
                            {{ $message->message }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Reply Form -->
            @if($ticket->status !== 'closed')
                <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[40px] border border-white/5 shadow-2xl overflow-hidden relative">
                    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-[#F51B1B]/5 blur-[100px] rounded-full"></div>
                    
                    <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5">Enviar Respuesta</h3>
                    
                    <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST" class="space-y-6 relative z-10">
                        @csrf
                        <textarea name="admin_reply" rows="6" required 
                            class="w-full bg-gray-900 border border-white/10 rounded-3xl px-6 py-5 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all placeholder:text-gray-700 resize-none leading-relaxed"
                            placeholder="Escribe aquí tu respuesta para el cliente..."></textarea>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-[#F51B1B] hover:bg-[#FF2121] text-white px-10 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all shadow-xl shadow-[#F51B1B]/20 active:scale-95">
                                Responder Ticket <i class="fas fa-paper-plane ml-3"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <div class="bg-gray-800/40 p-8 rounded-[40px] border border-white/5 shadow-2xl">
                <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 py-2 border-b border-white/5">Detalles del Cliente</h3>
                <div class="space-y-6">
                    <div>
                        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2">Asunto Inicial</p>
                        <p class="text-white text-xs font-medium leading-relaxed italic">"{{ $ticket->subject }}"</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2">Prioridad</p>
                        <span class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border 
                            {{ $ticket->priority === 'high' ? 'bg-rose-500/10 text-rose-400 border-rose-500/20' : ($ticket->priority === 'medium' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-[#FF2121]/10 text-[#FF2121] border-[#FF2121]/20') }}">
                            Prioridad {{ $ticket->priority }}
                        </span>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2">Total Pedidos</p>
                        <p class="text-white font-medium text-sm">{{ $ticket->user->orders()->count() }} Compras</p>
                    </div>
                </div>
            </div>

            <!-- Quick tools -->
            <div class="glass p-8 rounded-[40px] border-white/5">
                <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4 text-center">Navegación</p>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('admin.orders.index', ['search' => $ticket->user->email]) }}" class="flex items-center justify-between p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-all border border-white/5 group">
                        <span class="text-[10px] font-bold text-gray-400 group-hover:text-white uppercase tracking-widest">Ver Pedidos</span>
                        <i class="fas fa-shopping-cart text-gray-650 group-hover:text-[#FF2121] text-xs transition-all"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection