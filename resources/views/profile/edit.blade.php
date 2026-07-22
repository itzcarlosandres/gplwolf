@extends('layouts.user')

@section('title', 'Mi Perfil')

@section('content')
<div class="space-y-10 pb-20">
    <div>
        <h1 class="text-4xl font-black text-white leading-tight">Configuración de Perfil</h1>
        <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Administra tu información personal y seguridad.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Update Info -->
        <div class="glass p-8 rounded-[40px] border-white/5 space-y-8">
            <h3 class="text-xl font-black text-white flex items-center gap-3">
                <div class="bg-[#FF2121]/20 p-2 rounded-lg text-[#FF2121] text-sm"><i class="fas fa-user-edit"></i></div>
                Información del Perfil
            </h3>
            <div class="max-w-xl text-gray-400">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="glass p-8 rounded-[40px] border-white/5 space-y-8">
            <h3 class="text-xl font-black text-white flex items-center gap-3">
                <div class="bg-amber-500/20 p-2 rounded-lg text-amber-500 text-sm"><i class="fas fa-lock"></i></div>
                Actualizar Contraseña
            </h3>
            <div class="max-w-xl text-gray-400">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="lg:col-span-2 glass p-8 rounded-[40px] border-white/5 space-y-8 border-rose-500/10">
            <h3 class="text-xl font-black text-white flex items-center gap-3">
                <div class="bg-rose-500/20 p-2 rounded-lg text-rose-500 text-sm"><i class="fas fa-exclamation-triangle"></i></div>
                Zona de Peligro
            </h3>
            <div class="max-w-xl text-gray-400">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for Breeze partails inside dark theme */
    input[type="text"], input[type="email"], input[type="password"] {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        border-radius: 1rem !important;
        padding: 0.75rem 1rem !important;
    }
    input:focus {
        ring: 2px !important;
        ring-color: #FF2121 !important;
        outline: none !important;
    }
    label {
        font-size: 10px !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        color: #64748b !important;
        margin-bottom: 0.5rem !important;
        display: block !important;
    }
    button[type="submit"] {
        background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%) !important;
        color: white !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        padding: 0.75rem 1.5rem !important;
        border-radius: 1rem !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.2s !important;
        font-size: 10px !important;
    }
    button[type="submit"]:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 10px 20px rgba(255, 33, 33, 0.2) !important;
    }
    .text-gray-600 { color: #94a3b8 !important; }
</style>
@endsection