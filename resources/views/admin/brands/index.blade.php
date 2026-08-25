@extends('layouts.admin')

@section('title', 'Marcas de Confianza & Anuncios')

@section('content')
<div class="space-y-6" x-data="brandsManager()">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-black uppercase tracking-wider mb-2">
                <i class="fas fa-bullhorn"></i> Marketing & Elementos de Home
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Marcas & Anuncios Promocionales</h1>
            <p class="text-gray-500 text-sm mt-1">Gestiona de forma 100% independiente las marcas de confianza y la barra de anuncios/promociones.</p>
        </div>
        <div class="flex items-center gap-3">
            <template x-if="activeTab === 'brands'">
                <a href="{{ route('admin.brands.create', ['type' => 'brand']) }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Nueva Marca de Confianza
                </a>
            </template>
            <template x-if="activeTab === 'promos'">
                <a href="{{ route('admin.brands.create', ['type' => 'promo']) }}" class="px-4 py-2.5 bg-gradient-to-r from-amber-500 to-yellow-400 hover:from-amber-400 hover:to-yellow-300 text-black rounded-xl text-xs font-black transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2">
                    <i class="fas fa-bolt"></i> Nuevo Anuncio / Promoción
                </a>
            </template>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex items-center gap-3 border-b border-white/[0.06] pb-px">
        <button @click="activeTab = 'brands'"
                class="px-5 py-3 text-xs font-black uppercase tracking-wider rounded-t-xl transition-all border-b-2 flex items-center gap-2"
                :class="activeTab === 'brands' ? 'border-[#FF2121] text-white bg-white/[0.04]' : 'border-transparent text-gray-500 hover:text-gray-300 hover:bg-white/[0.02]'">
            <i class="fas fa-certificate text-sm" :class="activeTab === 'brands' ? 'text-[#FF2121]' : 'text-gray-500'"></i>
            <span>Marcas de Confianza</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] bg-white/10 text-gray-300">{{ $brands->count() }}</span>
        </button>

        <button @click="activeTab = 'promos'"
                class="px-5 py-3 text-xs font-black uppercase tracking-wider rounded-t-xl transition-all border-b-2 flex items-center gap-2"
                :class="activeTab === 'promos' ? 'border-amber-400 text-white bg-white/[0.04]' : 'border-transparent text-gray-500 hover:text-gray-300 hover:bg-white/[0.02]'">
            <i class="fas fa-bolt text-sm" :class="activeTab === 'promos' ? 'text-amber-400' : 'text-gray-500'"></i>
            <span>Anuncios & Promociones</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-300">{{ $promos->count() }}</span>
        </button>
    </div>

    {{-- ========================================================================= --}}
    {{-- TAB 1: MARCAS DE CONFIANZA                                                --}}
    {{-- ========================================================================= --}}
    <div x-show="activeTab === 'brands'" class="space-y-6">
        {{-- Section Switch for Brands --}}
        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 text-xl">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white">Slider de Marcas en la Home</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Controla de forma independiente la visualización del carrusel de marcas.</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               x-model="brandsTitle" 
                               placeholder="Título (ej. Marcas de Confianza)" 
                               class="bg-[#0d0d0d] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-[#FF2121]/50 w-52">
                        <button @click="saveBrandsSettings()" 
                                class="px-3 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white rounded-xl text-xs font-bold transition-all">
                            Guardar Título
                        </button>
                    </div>

                    <div class="h-6 w-px bg-white/10 hidden md:block"></div>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               x-model="brandsEnabled" 
                               @change="saveBrandsSettings()" 
                               class="sr-only peer">
                        <div class="w-12 h-6 bg-[#0d0d0d] border border-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="ml-3 text-xs font-bold" :class="brandsEnabled ? 'text-emerald-400' : 'text-gray-500'" x-text="brandsEnabled ? 'Slider de Marcas Activo' : 'Slider de Marcas Apagado'"></span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Drag Hint --}}
        <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-white/[0.02] border border-white/[0.04] text-xs text-gray-400">
            <span class="flex items-center gap-2 font-medium">
                <i class="fas fa-grip-vertical text-gray-500"></i>
                Arrastra las marcas desde el icono para ordenar el slider ("Drop").
            </span>
            <span class="text-[11px] font-bold text-gray-500">{{ $brands->count() }} marcas registradas</span>
        </div>

        {{-- Brands Table --}}
        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#0d0d0d]/80 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                        <tr>
                            <th class="px-4 py-4 w-12 text-center">Mover</th>
                            <th class="px-6 py-4">Marca</th>
                            <th class="px-6 py-4">Icono FontAwesome</th>
                            <th class="px-6 py-4">Enlace Opcional</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="brands-sortable-tbody" class="divide-y divide-white/5 text-sm">
                        @forelse($brands as $brand)
                            <tr class="hover:bg-white/[0.02] transition-colors group cursor-default" data-id="{{ $brand->id }}">
                                <td class="px-4 py-4 text-center">
                                    <div class="cursor-grab active:cursor-grabbing p-2 text-gray-600 hover:text-white transition-colors drag-handle" title="Arrastrar para mover">
                                        <i class="fas fa-grip-vertical text-base"></i>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white group-hover:text-[#FF2121] transition-colors">{{ $brand->name }}</div>
                                    <div class="text-[10px] text-gray-500 mt-0.5 font-mono">{{ $brand->slug }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 text-sm">
                                            <i class="{{ $brand->icon ?? 'fas fa-cube' }}"></i>
                                        </div>
                                        <span class="text-xs text-gray-400 font-mono">{{ $brand->icon ?? 'fas fa-cube' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($brand->link_url)
                                        <a href="{{ $brand->link_url }}" target="_blank" class="text-xs text-blue-400 hover:underline flex items-center gap-1 max-w-[200px] truncate">
                                            <i class="fas fa-external-link-alt text-[10px]"></i> {{ $brand->link_url }}
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-600 italic">Solo icono/nombre</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" 
                                            @click="toggleItemStatus({{ $brand->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all border"
                                            :class="itemStatuses[{{ $brand->id }}] ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20 hover:bg-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20 hover:bg-rose-500/20'">
                                        <i class="fas" :class="itemStatuses[{{ $brand->id }}] ? 'fa-check-circle' : 'fa-pause-circle'"></i>
                                        <span x-text="itemStatuses[{{ $brand->id }}] ? 'Activo' : 'Pausado'"></span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.brands.edit', $brand) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta marca?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all" title="Eliminar">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4 text-gray-400">
                                            <i class="fas fa-certificate text-2xl"></i>
                                        </div>
                                        <p class="text-lg font-bold text-gray-400">No hay marcas de confianza</p>
                                        <p class="text-sm text-gray-600 mt-1">Crea tu primera marca con el botón superior.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- TAB 2: ANUNCIOS & PROMOCIONES                                             --}}
    {{-- ========================================================================= --}}
    <div x-show="activeTab === 'promos'" class="space-y-6" style="display: none;">
        {{-- Section Switch for Promos --}}
        <div class="bg-[#111111] border border-amber-500/20 rounded-2xl p-5 shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/15 border border-amber-500/30 flex items-center justify-center text-amber-400 text-xl">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white">Barra de Anuncios Promocionales en la Home</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Controla de forma independiente la visualización de las tarjetas de promoción (como el Trial de 7 Días).</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               x-model="promosTitle" 
                               placeholder="Título (ej. Ofertas & Promociones)" 
                               class="bg-[#0d0d0d] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 w-52">
                        <button @click="savePromosSettings()" 
                                class="px-3 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white rounded-xl text-xs font-bold transition-all">
                            Guardar Título
                        </button>
                    </div>

                    <div class="h-6 w-px bg-white/10 hidden md:block"></div>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               x-model="promosEnabled" 
                               @change="savePromosSettings()" 
                               class="sr-only peer">
                        <div class="w-12 h-6 bg-[#0d0d0d] border border-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-400"></div>
                        <span class="ml-3 text-xs font-bold" :class="promosEnabled ? 'text-amber-400' : 'text-gray-500'" x-text="promosEnabled ? 'Barra de Anuncios Activa' : 'Barra de Anuncios Apagada'"></span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Drag Hint --}}
        <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-amber-500/[0.03] border border-amber-500/10 text-xs text-amber-300/80">
            <span class="flex items-center gap-2 font-medium">
                <i class="fas fa-grip-vertical text-amber-400/60"></i>
                Arrastra los anuncios desde el icono para ordenar las promociones al instante ("Drop").
            </span>
            <span class="text-[11px] font-bold text-amber-400/80">{{ $promos->count() }} anuncios registrados</span>
        </div>

        {{-- Promos Table --}}
        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#0d0d0d]/80 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                        <tr>
                            <th class="px-4 py-4 w-12 text-center">Mover</th>
                            <th class="px-6 py-4">Texto / Promoción</th>
                            <th class="px-6 py-4">Badge / Color</th>
                            <th class="px-6 py-4">Enlace de Destino</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="promos-sortable-tbody" class="divide-y divide-white/5 text-sm">
                        @forelse($promos as $promo)
                            <tr class="hover:bg-white/[0.02] transition-colors group cursor-default" data-id="{{ $promo->id }}">
                                <td class="px-4 py-4 text-center">
                                    <div class="cursor-grab active:cursor-grabbing p-2 text-gray-600 hover:text-white transition-colors drag-handle" title="Arrastrar para mover">
                                        <i class="fas fa-grip-vertical text-base"></i>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white group-hover:text-amber-400 transition-colors flex items-center gap-2">
                                        <i class="{{ $promo->icon ?? 'fas fa-bolt' }} text-amber-400 text-xs"></i>
                                        <span>{{ $promo->name }}</span>
                                    </div>
                                    <div class="text-[10px] text-gray-500 mt-0.5 font-mono">{{ $promo->slug }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($promo->badge_text)
                                            <span class="px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-wider bg-gradient-to-r from-red-600 to-amber-500 text-white shadow-sm">
                                                {{ $promo->badge_text }}
                                            </span>
                                        @endif
                                        <span class="text-[10px] uppercase font-bold text-gray-400 font-mono">({{ $promo->highlight_color ?? 'amber' }})</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($promo->link_url)
                                        <a href="{{ $promo->link_url }}" target="_blank" class="text-xs text-amber-400 hover:underline flex items-center gap-1 max-w-[220px] truncate">
                                            <i class="fas fa-external-link-alt text-[10px]"></i> {{ $promo->link_url }}
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-600 italic">Sin enlace</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" 
                                            @click="toggleItemStatus({{ $promo->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all border"
                                            :class="itemStatuses[{{ $promo->id }}] ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20 hover:bg-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20 hover:bg-rose-500/20'">
                                        <i class="fas" :class="itemStatuses[{{ $promo->id }}] ? 'fa-check-circle' : 'fa-pause-circle'"></i>
                                        <span x-text="itemStatuses[{{ $promo->id }}] ? 'Activo' : 'Pausado'"></span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.brands.edit', $promo) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $promo) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este anuncio?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all" title="Eliminar">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/20 rounded-2xl flex items-center justify-center mb-4 text-amber-400">
                                            <i class="fas fa-bolt text-2xl"></i>
                                        </div>
                                        <p class="text-lg font-bold text-white">No hay anuncios promocionales</p>
                                        <p class="text-sm text-gray-500 mt-1">Crea tu primer anuncio promocional (ej. para el Trial de 7 Días).</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 z-50 px-5 py-3 rounded-2xl bg-[#1a1a1a] border border-white/10 shadow-2xl text-white text-xs font-bold flex items-center gap-3"
         style="display: none;">
        <i class="fas fa-check-circle text-emerald-400 text-base"></i>
        <span x-text="toast.message"></span>
    </div>
</div>

@push('scripts')
{{-- SortableJS for Drag & Drop --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
function brandsManager() {
    return {
        activeTab: 'brands',
        brandsEnabled: {{ $brandsEnabled ? 'true' : 'false' }},
        brandsTitle: '{{ addslashes($brandsTitle) }}',
        promosEnabled: {{ $promosEnabled ? 'true' : 'false' }},
        promosTitle: '{{ addslashes($promosTitle) }}',
        itemStatuses: {
            @foreach($brands as $b)
                {{ $b->id }}: {{ $b->is_active ? 'true' : 'false' }},
            @endforeach
            @foreach($promos as $p)
                {{ $p->id }}: {{ $p->is_active ? 'true' : 'false' }},
            @endforeach
        },
        toast: { show: false, message: '' },

        init() {
            // Sortable for Brands
            const brandsEl = document.getElementById('brands-sortable-tbody');
            if (brandsEl) {
                new Sortable(brandsEl, {
                    handle: '.drag-handle',
                    animation: 200,
                    ghostClass: 'bg-white/[0.08]',
                    onEnd: () => { this.saveOrder('brands-sortable-tbody'); }
                });
            }

            // Sortable for Promos
            const promosEl = document.getElementById('promos-sortable-tbody');
            if (promosEl) {
                new Sortable(promosEl, {
                    handle: '.drag-handle',
                    animation: 200,
                    ghostClass: 'bg-amber-500/10',
                    onEnd: () => { this.saveOrder('promos-sortable-tbody'); }
                });
            }
        },

        showToast(msg) {
            this.toast.message = msg;
            this.toast.show = true;
            setTimeout(() => { this.toast.show = false; }, 3000);
        },

        async saveOrder(containerId) {
            const rows = document.querySelectorAll('#' + containerId + ' tr[data-id]');
            const ids = Array.from(rows).map(r => parseInt(r.getAttribute('data-id')));

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('{{ route("admin.brands.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ ids })
                });
                const data = await res.json();
                if (data.success) {
                    this.showToast('✓ Orden actualizado correctamente.');
                }
            } catch (err) {
                console.error(err);
            }
        },

        async toggleItemStatus(id) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch(`/admin/brands/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    }
                });
                const data = await res.json();
                if (data.success) {
                    this.itemStatuses[id] = data.is_active;
                    this.showToast(data.message);
                }
            } catch (err) {
                console.error(err);
            }
        },

        async saveBrandsSettings() {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('{{ route("admin.brands.settings") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        home_brands_enabled: this.brandsEnabled,
                        home_brands_title: this.brandsTitle
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.showToast(this.brandsEnabled ? '✓ Slider de Marcas activado' : '✓ Slider de Marcas desactivado');
                }
            } catch (err) {
                console.error(err);
            }
        },

        async savePromosSettings() {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('{{ route("admin.brands.settings") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        home_promos_enabled: this.promosEnabled,
                        home_promos_title: this.promosTitle
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.showToast(this.promosEnabled ? '✓ Barra de Anuncios activada' : '✓ Barra de Anuncios desactivada');
                }
            } catch (err) {
                console.error(err);
            }
        }
    }
}
</script>
@endpush
@endsection