@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div x-data="{ showPointsModal: false, selectedUser: null, userName: '' }">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Usuarios</h1>
        <p class="text-gray-500 text-sm mt-1">Administra los usuarios y sus permisos en la plataforma.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
        <i class="fas fa-user-plus"></i> Nuevo Usuario
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total</h3>
            <p class="text-2xl font-black text-white mt-1">{{ number_format($stats['total_users']) }}</p>
        </div>
        <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121]">
            <i class="fas fa-users text-lg"></i>
        </div>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-[#FF2121] uppercase tracking-widest">Admins</h3>
            <p class="text-2xl font-black text-[#FF2121] mt-1">{{ number_format($stats['admin_users']) }}</p>
        </div>
        <div class="w-10 h-10 bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl flex items-center justify-center text-[#FF2121]">
            <i class="fas fa-user-shield text-lg"></i>
        </div>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Clientes</h3>
            <p class="text-2xl font-black text-emerald-400 mt-1">{{ number_format($stats['customer_users']) }}</p>
        </div>
        <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400">
            <i class="fas fa-user text-lg"></i>
        </div>
    </div>
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 flex justify-between items-center">
        <div>
            <h3 class="text-[10px] font-black text-[#F51B1B] uppercase tracking-widest">Membresías</h3>
            <p class="text-2xl font-black text-[#F51B1B] mt-1">{{ number_format($stats['users_with_memberships']) }}</p>
        </div>
        <div class="w-10 h-10 bg-[#F51B1B]/10 border border-[#F51B1B]/20 rounded-xl flex items-center justify-center text-[#F51B1B]">
            <i class="fas fa-id-card text-lg"></i>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#0d0d0d]/50 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Usuario</th>
                    <th class="px-6 py-4">Rol</th>
                    <th class="px-6 py-4 text-center">Órdenes</th>
                    <th class="px-6 py-4">Membresía</th>
                    <th class="px-6 py-4">Registro</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                @forelse($users as $user)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&bold=true" class="w-10 h-10 rounded-full ring-2 ring-[#FF2121]/20 group-hover:ring-[#FF2121]/40 transition-all">
                                    @if($user->memberships_count > 0)
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-[#F51B1B] rounded-full flex items-center justify-center border-2 border-[#111111]">
                                            <i class="fas fa-crown text-[6px] text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-white group-hover:text-[#FF2121] transition-colors">{{ $user->name }}</div>
                                    <div class="text-[10px] text-gray-500 font-mono tracking-tighter">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-[#FF2121]/10 text-[#FF2121] border border-[#FF2121]/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#FF2121]"></span> Admin
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-gray-500/10 text-gray-500 border border-white/5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> User
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-black text-gray-400 bg-white/5 px-2.5 py-1 rounded-md">{{ $user->orders_count }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->memberships_count > 0)
                                <span class="text-[#F51B1B] font-bold flex items-center text-xs">
                                    <i class="fas fa-bolt mr-1.5 text-[#F51B1B]"></i> ACTIVE VIP
                                </span>
                            @else
                                <span class="text-gray-600 text-xs">Sin plan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 font-medium text-xs">
                            {{ $user->created_at->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.users.show', $user) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all" title="Ver Detalle">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <button type="button" @click="showPointsModal = true; selectedUser = {{ $user->id }}; userName = '{{ addslashes($user->name) }}'" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-[#F51B1B] hover:bg-[#F51B1B]/10 rounded-lg transition-all" title="Gestionar Puntos">
                                    <i class="fas fa-gem text-xs"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all" title="Eliminar">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center text-gray-500">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fas fa-users-slash text-2xl"></i>
                                </div>
                                <p class="text-lg font-bold text-gray-400">No se encontraron usuarios</p>
                                <p class="text-sm text-gray-600 mt-1">Agrega usuarios manualmente.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="px-6 py-4 bg-white/[0.02] border-t border-white/5">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Points Modal -->
<div x-show="showPointsModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showPointsModal" @click="showPointsModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" x-transition.opacity></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="showPointsModal" class="inline-block align-bottom bg-[#111111] rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white/10" x-transition.scale>
            <form :action="`/admin/users/${selectedUser}/points`" method="POST">
                @csrf
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-[#F51B1B]/10 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-gem text-[#F51B1B]"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">
                                Gestionar Puntos <span x-text="userName" class="text-gray-400 text-sm font-normal"></span>
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="bg-[#FF2121]/10 border border-[#FF2121]/20 rounded-xl p-3">
                                    <p class="text-xs text-[#FF2121]">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Usa números positivos para añadir (ej: 100) y negativos para restar (ej: -50).
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Cantidad de Puntos</label>
                                    <input type="number" name="amount" required class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#F51B1B]/50 focus:border-[#F51B1B] py-2.5 px-4 text-sm placeholder:text-gray-600" placeholder="0">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Motivo (Opcional)</label>
                                    <input type="text" name="description" class="w-full bg-[#0d0d0d] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#F51B1B]/50 focus:border-[#F51B1B] py-2.5 px-4 text-sm placeholder:text-gray-600" placeholder="Ej: Ajuste manual, Compensación...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#0d0d0d]/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-white/5">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg shadow-[#F51B1B]/20 px-4 py-2 bg-[#F51B1B] text-base font-bold text-white hover:bg-[#F51B1B] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-all">
                        Guardar Cambios
                    </button>
                    <button type="button" @click="showPointsModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-white/10 shadow-sm px-4 py-2 bg-white/5 text-base font-bold text-gray-300 hover:text-white hover:bg-white/10 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection