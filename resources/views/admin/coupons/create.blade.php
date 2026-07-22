@extends('layouts.admin')

@section('title', 'Nuevo Cupón')

@section('content')
<div class="mb-8 flex items-center">
    <a href="{{ route('admin.coupons.index') }}" class="mr-4 w-10 h-10 bg-gray-800/50 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-800 transition-all border border-white/5">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Nuevo Cupón</h1>
        <p class="text-gray-400 mt-1">Crea un nuevo código de descuento para tus productos.</p>
    </div>
</div>

<form action="{{ route('admin.coupons.store') }}" method="POST" class="max-w-4xl">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[32px] border border-white/5 shadow-2xl space-y-6">
            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Código del Cupón</label>
                <input type="text" name="code" required class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-mono uppercase" placeholder="EJ: PROMO2024">
                @error('code') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Tipo</label>
                    <select name="type" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                        <option value="fixed">Monto Fijo ($)</option>
                        <option value="percent">Porcentaje (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Valor</label>
                    <input type="number" step="0.01" name="value" required class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all" placeholder="10.00">
                </div>
            </div>
        </div>

        <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[32px] border border-white/5 shadow-2xl space-y-6">
            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Compra Mínima ($)</label>
                <input type="number" step="0.01" name="min_purchase" value="0" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Límite de Uso</label>
                    <input type="number" name="usage_limit" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all" placeholder="Opcional">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Fecha Expiración</label>
                    <input type="date" name="expires_at" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                </div>
            </div>
        </div>
    </div>

    <!-- Restrictions Section -->
    <div class="mt-8 bg-gray-800/40 backdrop-blur-xl p-8 rounded-[32px] border border-white/5 shadow-2xl space-y-6">
        <h3 class="text-xl font-bold text-white mb-4">Restricciones de Uso</h3>
        
        <!-- Type Selector -->
        <div>
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Aplicar A</label>
            <select name="restriction_type" id="restriction_type" class="w-full bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-bold">
                <option value="none">Todo el sitio (Sin restricciones)</option>
                <option value="products">Productos Específicos</option>
                <option value="categories">Categorías Específicas</option>
                <option value="membership_plans">Planes de Membresía</option>
            </select>
        </div>

        <!-- Dynamic Selectors -->
        <div id="restriction_products" class="hidden restriction-group">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Seleccionar Productos</label>
            <select name="restriction_ids[]" multiple class="w-full h-40 bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <p class="text-[10px] text-gray-500 mt-2 ml-1">* Mantén presionado CTRL para seleccionar múltiples.</p>
        </div>

        <div id="restriction_categories" class="hidden restriction-group">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Seleccionar Categorías</label>
            <select name="restriction_ids[]" multiple class="w-full h-40 bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <p class="text-[10px] text-gray-500 mt-2 ml-1">* Mantén presionado CTRL para seleccionar múltiples.</p>
        </div>

        <div id="restriction_membership_plans" class="hidden restriction-group">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Seleccionar Planes</label>
            <select name="restriction_ids[]" multiple class="w-full h-40 bg-gray-950 border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all">
                @foreach($membershipPlans as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                @endforeach
            </select>
            <p class="text-[10px] text-gray-500 mt-2 ml-1">* Mantén presionado CTRL para seleccionar múltiples.</p>
        </div>
    </div>

    <script>
        document.getElementById('restriction_type').addEventListener('change', function() {
            // Hide all groups and disable their inputs to prevent submission
            document.querySelectorAll('.restriction-group').forEach(el => {
                el.classList.add('hidden');
                el.querySelector('select').disabled = true;
            });

            // Show selected group
            const type = this.value;
            if (type !== 'none') {
                const target = document.getElementById('restriction_' + type);
                if (target) {
                    target.classList.remove('hidden');
                    target.querySelector('select').disabled = false;
                }
            }
        });
        
        // Trigger on load
        document.getElementById('restriction_type').dispatchEvent(new Event('change'));
    </script>

        <button type="submit" class="w-full gradient-bg text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-[#F51B1B]/30 hover:opacity-90 transition-all transform active:scale-95 leading-none">
            Crear Cupón de Descuento <i class="fas fa-check-circle ml-2"></i>
        </button>
    </div>
</form>
@endsection