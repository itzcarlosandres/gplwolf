@extends('layouts.admin')

@section('title', 'Boletín de Newsletter')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Newsletter</h1>
        <p class="text-gray-500 text-sm mt-1">Administra los suscriptores y envía boletines de ofertas a tus clientes.</p>
    </div>
    <a href="{{ route('admin.newsletter.create-mail') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
        <i class="fas fa-paper-plane"></i> Enviar Boletín
    </a>
</div>

<!-- Subscribers Table -->
<div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4">Suscrito el</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($subscribers as $subscriber)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4 font-bold text-white">
                            {{ $subscriber->email }}
                        </td>
                        <td class="px-6 py-4">
                            @if($subscriber->is_active)
                                <span class="px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[9px] font-black rounded-lg uppercase tracking-wider">Activo</span>
                            @else
                                <span class="px-2.5 py-1 bg-gray-500/10 border border-gray-500/20 text-gray-400 text-[9px] font-black rounded-lg uppercase tracking-wider">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-400 font-mono text-xs">
                            {{ $subscriber->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.newsletter.toggle', $subscriber) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white rounded-lg text-xs font-bold transition-all">
                                        {{ $subscriber->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.newsletter.destroy', $subscriber) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este suscriptor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-500 hover:text-[#FF2121] rounded-lg transition-colors">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 font-medium">
                            No hay suscriptores registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($subscribers->hasPages())
        <div class="px-6 py-4 border-t border-white/5">
            {{ $subscribers->links() }}
        </div>
    @endif
</div>
@endsection
