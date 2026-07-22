@extends('layouts.admin')

@section('title', 'Configuración de Puntos')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Sistema de Puntos</h1>
        <p class="text-gray-400 mt-1">Configura cómo los usuarios ganan y gastan sus puntos.</p>
    </div>
</div>

<form action="{{ route('admin.settings.points.update') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    @csrf
    
    <!-- Estado del Sistema -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <div class="bg-[#FF2121]/20 p-2 rounded-lg"><i class="fas fa-coins text-[#FF2121] text-sm"></i></div>
                Estado General
            </h2>

            <div class="flex items-center gap-4 mb-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="points_enabled" value="1" class="sr-only peer" {{ isset($settings['points_enabled']) && $settings['points_enabled'] ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#F51B1B]"></div>
                    <span class="ml-3 text-sm font-medium text-gray-300">Habilitar Sistema de Puntos</span>
                </label>
            </div>
            <p class="text-xs text-gray-500">Si desactivas esto, los usuarios no ganarán puntos ni podrán pagar con ellos.</p>
        </div>

        <!-- Reglas de Ganancia y Canje -->
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5 shadow-2xl">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                <div class="bg-emerald-500/20 p-2 rounded-lg"><i class="fas fa-exchange-alt text-emerald-400 text-sm"></i></div>
                Reglas de Conversión
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Ganar Puntos -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 ml-1">Ganancia por Compra</label>
                    <div class="relative">
                        <input type="number" name="points_per_currency" value="{{ $settings['points_per_currency'] ?? 1 }}" min="0" class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono text-xl text-center">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Puntos por cada $1</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-2 text-center">Ej: Si pones 1, gastar $50 otorga 50 puntos.</p>
                </div>

                <!-- Valor de Canje -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 ml-1">Valor de Canje</label>
                    <div class="relative">
                        <input type="number" name="points_conversion_rate" value="{{ $settings['points_conversion_rate'] ?? 100 }}" min="1" class="w-full bg-gray-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono text-xl text-center">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Puntos = $1 USD</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Info -->
    <div class="space-y-8">
        <div class="bg-gradient-to-br from-[#FF2121] to-[#F51B1B] p-8 rounded-3xl shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 blur-3xl rounded-full -mr-16 -mt-16"></div>
            <h3 class="text-xl font-bold text-white mb-4 relative z-10">Resumen</h3>
            <div class="space-y-4 relative z-10 text-[#FF2121] text-sm">
                <p>Con la configuración actual:</p>
                <ul class="list-disc pl-4 space-y-2">
                    <li>Una compra de <strong>$100.00</strong> otorgará <strong><span id="preview-earn">0</span> puntos</strong>.</li>
                    <li>Para obtener <strong>$1.00 de descuento</strong>, el usuario necesita <strong><span id="preview-spend">0</span> puntos</strong>.</li>
                </ul>
            </div>
            <button type="submit" class="w-full mt-8 bg-white text-[#F51B1B] font-bold py-4 rounded-xl hover:bg-[#FF2121]/5 transition-colors shadow-lg">
                Guardar Configuración
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const earnInput = document.querySelector('input[name="points_per_currency"]');
        const spendInput = document.querySelector('input[name="points_conversion_rate"]');
        const previewEarn = document.getElementById('preview-earn');
        const previewSpend = document.getElementById('preview-spend');

        function updatePreview() {
            const pointsPerDollar = parseInt(earnInput.value) || 0;
            const pointsForDollar = parseInt(spendInput.value) || 1;

            previewEarn.textContent = 100 * pointsPerDollar;
            previewSpend.textContent = pointsForDollar;
        }

        earnInput.addEventListener('input', updatePreview);
        spendInput.addEventListener('input', updatePreview);
        updatePreview();
    });
</script>
@endsection