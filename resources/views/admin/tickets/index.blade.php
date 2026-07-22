@extends('layouts.admin')

@section('title', 'Gestión de Tickets de Soporte')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Soporte Técnico</h1>
        <p class="text-gray-500 text-sm mt-1">Gestiona las consultas y problemas de tus clientes.</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-bold flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">ID / Fecha</th>
                    <th class="px-6 py-4">Usuario</th>
                    <th class="px-6 py-4">Asunto / Prioridad</th>
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="text-white font-black font-mono">#{{ $ticket->id }}</div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mt-0.5">{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&background=6366f1&color=fff&bold=true" class="w-10 h-10 rounded-xl ring-2 ring-[#FF2121]/20 group-hover:ring-[#FF2121]/40 transition-all">
                                <div>
                                    <div class="text-white font-bold text-sm group-hover:text-[#FF2121] transition-colors">{{ $ticket->user->name }}</div>
                                    <div class="text-[10px] text-gray-500 font-mono">{{ $ticket->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-white font-medium text-sm mb-2 truncate max-w-[220px]">{{ $ticket->subject }}</div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border
                                {{ $ticket->priority === 'high' ? 'bg-rose-500/10 text-rose-400 border-rose-500/20' : ($ticket->priority === 'medium' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-[#FF2121]/10 text-[#FF2121] border-[#FF2121]/20') }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                Prioridad {{ $ticket->priority }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusConfig = match($ticket->status) {
                                    'open' => ['label' => 'Pendiente', 'class' => 'bg-amber-500/10 text-amber-400 border-amber-500/20'],
                                    'answered' => ['label' => 'Respondido', 'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'],
                                    default => ['label' => 'Cerrado', 'class' => 'bg-white/5 text-gray-500 border-white/10']
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $statusConfig['class'] }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex w-9 h-9 bg-[#0d0d0d] border border-white/10 hover:border-[#FF2121]/50 hover:bg-[#F51B1B] hover:text-white rounded-xl items-center justify-center text-gray-400 transition-all" title="Responder">
                                <i class="fas fa-reply text-xs"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center text-gray-500">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fas fa-inbox text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">Todo el soporte está al día</p>
                                <p class="text-sm text-gray-600 mt-1">No hay tickets pendientes.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($tickets->hasPages())
<div class="mt-6">
    {{ $tickets->links() }}
</div>
@endif
@endsection