@extends('layouts.admin')

@section('title', 'Crear Plan de Membresía')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-2xl font-semibold text-white leading-7 sm:truncate sm:text-3xl">Nuevo Plan de Membresía</h1>
            <p class="mt-1 text-sm text-gray-400">Configura un nuevo plan de suscripción para tus usuarios.</p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('admin.membership-plans.index') }}" class="inline-flex items-center rounded-lg bg-gray-800 px-3 py-2 text-sm font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-700 hover:bg-gray-700 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 font-light"></i> Volver al listado
            </a>
        </div>
    </div>

    <form action="{{ route('admin.membership-plans.store') }}" method="POST" class="mt-8 space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-white">Información Básica</h2>
                <p class="mt-1 text-sm leading-6 text-gray-400">Detalles principales del plan que verán los usuarios.</p>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-xl border border-white/10 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 overflow-hidden">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium leading-6 text-white">Nombre del Plan</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6 placeholder:text-gray-600" placeholder="Ej: Plan Pro Mensual">
                            </div>
                            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="price" class="block text-sm font-medium leading-6 text-white">Precio ($)</label>
                            <div class="mt-2">
                                <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6 placeholder:text-gray-600" placeholder="29.99">
                            </div>
                            @error('price') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="duration" class="block text-sm font-medium leading-6 text-white">Tipo de Duración</label>
                            <div class="mt-2 text-white">
                                <select name="duration" id="duration" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6">
                                    <option value="monthly" {{ old('duration') == 'monthly' ? 'selected' : '' }}>Mensual</option>
                                    <option value="annual" {{ old('duration') == 'annual' ? 'selected' : '' }}>Anual</option>
                                    <option value="lifetime" {{ old('duration') == 'lifetime' ? 'selected' : '' }}>De por vida</option>
                                </select>
                            </div>
                            @error('duration') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="duration_days" class="block text-sm font-medium leading-6 text-white">Duración (Días)</label>
                            <div class="mt-2">
                                <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', 30) }}" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6">
                            </div>
                            @error('duration_days') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                            <div class="sm:col-span-2">
                                <label for="daily_download_limit" class="block text-sm font-medium leading-6 text-white">Límite Descarga Diaria</label>
                                <div class="mt-2">
                                    <input type="number" name="daily_download_limit" id="daily_download_limit" value="{{ old('daily_download_limit', 0) }}" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6" placeholder="0 = Ilimitado">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="sites_limit" class="block text-sm font-medium leading-6 text-white">Límite Sitios Activos</label>
                                <div class="mt-2">
                                    <input type="number" name="sites_limit" id="sites_limit" value="{{ old('sites_limit', 1) }}" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6" placeholder="Ej: 5 (0 = Ilimitado)">
                                </div>
                            </div>

                        <div class="sm:col-span-2">
                            <label for="reward_points" class="block text-sm font-medium leading-6 text-white">Puntos de Regalo</label>
                            <div class="mt-2">
                                <input type="number" name="reward_points" id="reward_points" value="{{ old('reward_points', 0) }}" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium leading-6 text-white">Descripción Corta</label>
                            <div class="mt-2">
                                <textarea name="description" id="description" rows="3" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6 placeholder:text-gray-600">{{ old('description') }}</textarea>
                            </div>
                            @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-white">Beneficios y Estado</h2>
                <p class="mt-1 text-sm leading-6 text-gray-400">¿Qué incluye este plan y si debe estar visible?</p>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-xl border border-white/10 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 overflow-hidden">
                <div class="px-4 py-6 sm:p-8">
                    <div class="space-y-6">
                        <div x-data="{ benefits: [''] }">
                            <label class="block text-sm font-medium leading-6 text-white">Beneficios del Plan</label>
                            <template x-for="(benefit, index) in benefits" :key="index">
                                <div class="mt-2 flex gap-2">
                                    <input type="text" name="benefits[]" x-model="benefits[index]" class="block w-full rounded-lg border-0 bg-gray-900/50 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-[#FF2121] sm:text-sm sm:leading-6 placeholder:text-gray-600" placeholder="Ej: Descargas ilimitadas">
                                    <button type="button" @click="benefits.splice(index, 1)" class="p-2 text-red-400 hover:text-red-300">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="benefits.push('')" class="mt-3 inline-flex items-center text-sm font-medium text-[#FF2121] hover:text-[#FF2121]">
                                <i class="fas fa-plus mr-1"></i> Añadir otro beneficio
                            </button>
                        </div>

                        <div class="flex items-center gap-10">
                            <div class="flex items-center">
                                <div class="flex h-6 items-center">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-white/10 bg-gray-900 text-[#F51B1B] focus:ring-[#F51B1B] focus:ring-offset-gray-900">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="is_active" class="font-medium text-white">Plan Activo</label>
                                    <p class="text-gray-400">Los usuarios podrán suscribirse a este plan.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex h-6 items-center">
                                    <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 rounded border-white/10 bg-gray-900 text-[#F51B1B] focus:ring-[#F51B1B] focus:ring-offset-gray-900">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="is_featured" class="font-medium text-white">Plan Destacado</label>
                                    <p class="text-gray-400">Aparecerá resaltado en el marketplace.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-x-6 border-t border-white/10 px-4 py-4 sm:px-8">
                    <button type="button" onclick="window.history.back()" class="text-sm font-semibold leading-6 text-white hover:text-gray-300 transition-colors">Cancelar</button>
                    <button type="submit" class="rounded-lg bg-[#F51B1B] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#FF2121] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F51B1B] transition-all duration-200">
                        Guardar Plan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection