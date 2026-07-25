@extends('layouts.user')

@section('title', 'Mis Claves de Licencia')

@section('content')
<div class="space-y-10 pb-20" x-data="{ 
    copyKey(key) {
        navigator.clipboard.writeText(key).then(() => {
            alert('¡Clave copiada al portapapeles!');
        }).catch(err => {
            console.error('Error al copiar: ', err);
        });
    }
}">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-white leading-tight">Mis Claves de Licencia</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Visualiza y gestiona las activaciones de tus licencias adquiridas.</p>
        </div>
    </div>

    <div class="glass rounded-[40px] border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.01]">
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Producto</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Clave de Licencia</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Estado</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Dominio Activado</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Límite</th>
                        <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($licenses as $license)
                        <tr class="hover:bg-white/[0.01] transition-colors">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center text-xl border border-white/5 overflow-hidden shrink-0">
                                        @if($license->product->thumbnail)
                                            <img src="{{ asset('storage/' . $license->product->thumbnail) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-box text-gray-700"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-white text-sm uppercase truncate max-w-[200px]" title="{{ $license->product->name }}">
                                            {{ $license->product->name }}
                                        </div>
                                        <div class="text-[9px] text-gray-500 font-mono mt-0.5">
                                            Adquirido el {{ $license->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-2">
                                    <code class="px-3 py-1.5 bg-black/40 border border-white/5 text-gray-300 font-mono text-xs rounded-xl uppercase tracking-wider select-all">
                                        {{ $license->license_key }}
                                    </code>
                                    <button @click="copyKey('{{ $license->license_key }}')" class="p-2 bg-white/5 hover:bg-white/10 hover:text-red-500 text-gray-400 rounded-xl transition-all border-none cursor-pointer" title="Copiar Licencia">
                                        <i class="fas fa-copy text-xs"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="p-6">
                                @if($license->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[9px] font-black uppercase tracking-wider border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-zinc-800 text-gray-500 text-[9px] font-black uppercase tracking-wider border border-white/5">
                                        <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="p-6">
                                @if($license->domain)
                                    <span class="text-xs font-mono text-gray-300 flex items-center gap-1.5">
                                        <i class="fas fa-globe text-gray-500 text-[10px]"></i>
                                        {{ $license->domain }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-600 font-bold italic">
                                        Sin dominio asignado
                                    </span>
                                @endif
                            </td>
                            <td class="p-6">
                                <span class="text-xs font-mono text-gray-400">
                                    {{ $license->activations_count }} / {{ $license->activations_limit ?? '1' }}
                                </span>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('user.support.create', ['subject' => 'Activación de licencia: ' . $license->product->name, 'message' => 'Hola, solicito la activación de mi licencia para el producto ' . $license->product->name . '. Mi clave es: ' . $license->license_key]) }}" class="px-4 py-2 bg-[#FF2121]/10 hover:bg-[#FF2121] border border-[#FF2121]/20 text-white hover:text-black rounded-xl text-[10px] font-black uppercase tracking-wider transition-all text-decoration-none flex items-center gap-1.5">
                                        <i class="fas fa-headset text-[9px]"></i> Soporte
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-16 text-center">
                                <div class="opacity-25 flex flex-col items-center">
                                    <i class="fas fa-key text-5xl mb-4 text-gray-600"></i>
                                    <p class="text-lg font-black uppercase tracking-widest">No tienes claves de licencia</p>
                                    <p class="text-xs text-gray-500 mt-2">Las licencias que compres o reclames aparecerán en esta sección.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($licenses->hasPages())
        <div class="mt-8">
            {{ $licenses->links() }}
        </div>
    @endif
</div>
@endsection
