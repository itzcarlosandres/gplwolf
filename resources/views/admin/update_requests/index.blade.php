@extends('layouts.admin')

@section('content')
<div class="px-6 py-6 border-b border-white/5">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-white">Solicitudes de Actualización</h2>
    </div>
</div>

<div class="p-6">
    @if($requests->count() > 0)
    <div class="overflow-x-auto rounded-xl border border-white/5">
        <table class="w-full text-left">
            <thead class="bg-white/5">
                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-white/5">
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3">Usuario</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 bg-[#0d0d0d]">
                @foreach($requests as $req)
                <tr class="group hover:bg-white/5 transition-colors">
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-700/50 flex items-center justify-center text-gray-400 overflow-hidden">
                                @if($req->product->thumbnail)
                                <img src="{{ asset('storage/'.$req->product->thumbnail) }}" class="w-full h-full object-cover">
                                @else
                                <i class="fas fa-box"></i>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('products.show', $req->product) }}" target="_blank" class="text-white font-bold hover:text-[#FF2121] transition-colors">
                                    {{ $req->product->name }}
                                </a>
                                <div class="text-xs text-gray-500">v{{ $req->product->version }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        @if($req->user)
                        <div class="flex items-center gap-2">
                             <div class="w-8 h-8 rounded-full bg-[#FF2121]/20 flex items-center justify-center text-[#FF2121] text-xs font-bold uppercase overflow-hidden">
                                {{ substr($req->user->name, 0, 1) }}
                             </div>
                             <span class="text-gray-300 text-sm">{{ $req->user->name }}</span>
                        </div>
                        @else
                        <span class="text-gray-500 italic">Usuario Eliminado</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-400">
                        {{ $req->created_at->diffForHumans() }}
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('admin.update-requests.complete', $req) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition-colors" title="Marcar como Completado">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.update-requests.destroy', $req) }}" method="POST" onsubmit="return confirm('¿Borrar solicitud?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $requests->links() }}
    </div>
    @else
        <div class="text-center py-12 border border-dashed border-white/10 rounded-xl bg-white/5">
            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-600">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-300">Todo al día</h3>
            <p class="text-gray-500">No hay solicitudes de actualización pendientes.</p>
        </div>
    @endif
</div>
@endsection