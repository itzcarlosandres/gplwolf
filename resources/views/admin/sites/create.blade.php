@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Autorizar Nuevo Dominio</h1>
            <p class="text-gray-400 text-sm mt-1">Conecta y autoriza un dominio WordPress manualmente para un cliente.</p>
        </div>
        <a href="{{ route('admin.sites.index') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white rounded-xl font-bold text-sm transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="bg-[#0c0c0c] border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
        <form action="{{ route('admin.sites.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- User Select -->
            <div class="space-y-2">
                <label for="user_id" class="block text-sm font-bold text-gray-300">Cliente / Usuario</label>
                <select name="user_id" id="user_id" class="block w-full rounded-xl border-0 bg-gray-900 py-3 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm">
                    <option value="" disabled selected>-- Selecciona un Cliente --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Domain Input -->
            <div class="space-y-2">
                <label for="domain" class="block text-sm font-bold text-gray-300">Dominio del Sitio (URL)</label>
                <input type="text" name="domain" id="domain" value="{{ old('domain') }}" placeholder="https://tusitioweb.com" class="block w-full rounded-xl border-0 bg-gray-900 py-3 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm" required>
                <p class="text-[11px] text-gray-500">Asegúrate de incluir el esquema completo (http:// o https://).</p>
                @error('domain') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Warning / Info Box -->
            <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.04] flex gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#FF2121]/10 border border-[#FF2121]/20 flex items-center justify-center text-[#FF2121] flex-shrink-0">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="text-xs leading-relaxed text-gray-400">
                    <strong class="text-white block mb-1">Nota sobre Límites</strong>
                    Como administrador, puedes agregar dominios manualmente ignorando los límites de sitios del plan del usuario. El usuario verá este sitio listado en su panel de "Sitios Conectados" y podrá utilizar el plugin directamente en él.
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
                <a href="{{ route('admin.sites.index') }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-white font-bold text-sm rounded-xl transition-all">Cancelar</a>
                <button type="submit" class="px-8 py-3 bg-[#FF2121] hover:bg-[#ef1a1a] text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-[#FF2121]/20 transition-all flex items-center gap-2">
                    <i class="fas fa-plus"></i> Autorizar Sitio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
