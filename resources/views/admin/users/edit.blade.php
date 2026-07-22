@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Editar Usuario</h1>
        <p class="text-gray-400 mt-1">Actualiza la información del usuario {{ $user->name }}.</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-bold transition-all duration-200 border border-white/5">
        <i class="fas fa-arrow-left mr-2"></i> Volver
    </a>
</div>

<div class="bg-gray-800/40 backdrop-blur-xl rounded-2xl border border-white/5 p-8 max-w-4xl mx-auto">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-400 mb-2">Nombre Completo</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121] @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-400 mb-2">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121] @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rol -->
            <div>
                <label for="role" class="block text-sm font-bold text-gray-400 mb-2">Rol de Usuario</label>
                <select name="role" id="role" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]">
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Puntos -->
            <div>
                <label for="points" class="block text-sm font-bold text-gray-400 mb-2">Puntos de Recompensa</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-gem text-[#F51B1B]"></i>
                    </div>
                    <input type="number" name="points" id="points" value="{{ old('points', $user->points) }}" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl pl-10 pr-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#F51B1B]" min="0">
                </div>
                <p class="mt-1 text-xs text-gray-500">Saldo actual del usuario.</p>
                @error('points')
                    <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rango VIP -->
            <div>
                <label for="current_rank_id" class="block text-sm font-bold text-gray-400 mb-2">Rango VIP</label>
                <select name="current_rank_id" id="current_rank_id" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#F51B1B]">
                    <option value="">Sin Rango (Automático)</option>
                    @foreach($ranks as $rank)
                        <option value="{{ $rank->id }}" 
                                {{ old('current_rank_id', $user->current_rank_id) == $rank->id ? 'selected' : '' }}
                                style="background-color: {{ $rank->color }}20;">
                            {{ $rank->name }} ({{ number_format($rank->min_points) }}+ pts, {{ $rank->discount_percentage }}% OFF)
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Asignar manualmente o dejar en automático según puntos.</p>
                @error('current_rank_id')
                    <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="border-t border-white/5 pt-6 mt-6">
            <h3 class="text-lg font-bold text-white mb-4">Cambiar Contraseña</h3>
            <p class="text-sm text-gray-400 mb-4">Deja estos campos vacíos si no deseas cambiar la contraseña.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-400 mb-2">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121] @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-400 mb-2">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-[#F51B1B] hover:bg-[#FF2121] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-[#F51B1B]/20 transition-all duration-200">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection