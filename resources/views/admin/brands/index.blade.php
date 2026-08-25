@extends('layouts.admin')

@section('title', 'Marcas de Confianza & Anuncios')

@section('content')
<div class="space-y-6" x-data="brandsManager()">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-black uppercase tracking-wider mb-2">
                <i class="fas fa-bullhorn"></i> Slider Home & Promociones
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Marcas de Confianza & Anuncios</h1>
            <p class="text-gray-500 text-sm mt-1">Gestiona marcas y tarjetas promocionales (como el Trial de 7 Días) en el carrusel de la Home.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.brands.create') }}" class="px-4 py-2.5 bg-[#F51B1B] hover:bg-[#FF2121] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-[#F51B1B]/20 flex items-center gap-2">
                <i class="fas fa-plus"></i> Nuevo Elemento / Anuncio
            </a>
        </div>
    </div>

    {{-- Global Section Settings Card --}}
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-5 shadow-xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-xl">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white">Estado de la Sección en la Home</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Activa o apaga la barra completa de marcas/anuncios en la página principal.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 flex-wrap">
                <div class="flex items-center gap-2">
                    <input type="text" 
                           x-model="sectionTitle" 
                           placeholder="Título (ej. Marcas de Confianza)" 
                           class="bg-[#0d0d0d] border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 w-52">
                    <button @click="saveSettings()" 
                            class="px-3 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white rounded-xl text-xs font-bold transition-all">
                        Guardar Título
                    </button>
                </div>

                <div class="h-6 w-px bg-white/10 hidden md:block"></div>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" 
                           x-model="sectionEnabled" 
                           @change="saveSettings()" 
                           class="sr-only peer">
                    <div class="w-12 h-6 bg-[#0d0d0d] border border-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    <span class="ml-3 text-xs font-bold" :class="sectionEnabled ? 'text-emerald-400' : 'text-gray-500'" x-text="sectionEnabled ? 'Sección Activada' : 'Sección Desactivada'"></span>
                </label>
            </div>
        </div>
    </div>

    {{-- Drag & Drop Hint Banner --}}
    <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-white/[0.02] border border-white/[0.04] text-xs text-gray-400">
        <span class="flex items-center gap-2 font-medium">
            <i class="fas fa-grip-vertical text-gray-500"></i>
            Arrastra las filas desde el icono para reordenar el carrusel al instante ("Drop").
        </span>
        <span class="text-[11px] font-bold text-gray-500">
            Total: {{ $brands->count() }} elementos ({{ $brands->where('is_promo', true)->count() }} anuncios)
        </span>
    </div>

    {{-- Brands Table --}}
    <div class="bg-[#111111] border border-white/[0.06] rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#0d0d0d]/80 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                    <tr>
                        <th class="px-4 py-4 w-12 text-center">Mover</th>
                        <th class="px-4 py-4 w-16">Tipo</th>
                        <th class="px-6 py-4">Nombre / Contenido</th>
                        <th class="px-6 py-4">Icono / Badge</th>
                        <th class="px-6 py-4">Enlace de Destino</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="brands-sortable-tbody" class="divide-y divide-white/5 text-sm">
                    @forelse($brands as $brand)
                        <tr class="hover:bg-white/[0.02] transition-colors group cursor-default" data-id="{{ $brand->id }}">
                            {{-- Drag Handle --}}
                            <td class="px-4 py-4 text-center">
                                <div class="cursor-grab active:cursor-grabbing p-2 text-gray-600 hover:text-white transition-colors drag-handle" title="Arrastrar para mover">
                                    <i class="fas fa-grip-vertical text-base"></i>
                                </div>
                            </td>

                            {{-- Tipo --}}
                            <td class="px-4 py-4">
                                @if($brand->is_promo)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-wider bg-amber-500/15 text-amber-400 border border-amber-500/30">
                                        <i class="fas fa-bolt text-[8px]"></i> Promo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-wider bg-white/5 text-gray-400 border border-white/10">
                                        <i class="fas fa-shield-alt text-[8px]"></i> Marca
                                    </span>
                                @endif
                            </td>

                            {{-- Name & Slug --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-white group-hover:text-amber-400 transition-colors flex items-center gap-2">
                                    {{ $brand->name }}
                                </div>
                                <div class="text-[10px] text-gray-500 mt-0.5 font-mono">{{ $brand->slug }}</div>
                            </td>

                            {{-- Icon / Badge Preview --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-300 text-sm">
                                        <i class="{{ $brand->icon ?? 'fas fa-cube' }}"></i>
                                    </div>
                                    @if($brand->badge_text)
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase bg-gradient-to-r from-red-600 to-amber-500 text-white shadow-sm">
                                            {{ $brand->badge_text }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Link URL --}}
                            <td class="px-6 py-4">
                                @if($brand->link_url)
                                    <a href="{{ $brand->link_url }}" target="_blank" class="text-xs text-blue-400 hover:underline flex items-center gap-1 max-w-[200px] truncate">
                                        <i class="fas fa-external-link-alt text-[10px]"></i> {{ $brand->link_url }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-600 italic">Sin enlace</span>
                                @endif
                            </td>

                            {{-- Active Toggle Switch --}}
                            <td class="px-6 py-4 text-center">
                                <button type="button" 
                                        @click="toggleItemStatus({{ $brand->id }}, $event)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-all border"
                                        :class="itemStatuses[{{ $brand->id }}] ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20 hover:bg-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20 hover:bg-rose-500/20'">
                                    <i class="fas" :class="itemStatuses[{{ $brand->id }}] ? 'fa-check-circle' : 'fa-pause-circle'"></i>
                                    <span x-text="itemStatuses[{{ $brand->id }}] ? 'Activo' : 'Pausado'"></span>
                                </button>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-400 hover:bg-amber-400/10 rounded-lg transition-all" title="Editar">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este elemento?')">
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
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center text-gray-500">
                                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-4 text-amber-400">
                                        <i class="fas fa-bullhorn text-2xl"></i>
                                    </div>
                                    <p class="text-lg font-bold text-gray-400">No hay marcas ni anuncios</p>
                                    <p class="text-sm text-gray-600 mt-1">Crea tu primera marca o anuncio promocional.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
        sectionEnabled: {{ $brandsEnabled ? 'true' : 'false' }},
        sectionTitle: '{{ addslashes($brandsTitle) }}',
        itemStatuses: {
            @foreach($brands as $b)
                {{ $b->id }}: {{ $b->is_active ? 'true' : 'false' }},
            @endforeach
        },
        toast: { show: false, message: '' },

        init() {
            const el = document.getElementById('brands-sortable-tbody');
            if (el) {
                new Sortable(el, {
                    handle: '.drag-handle',
                    animation: 200,
                    ghostClass: 'bg-white/[0.08]',
                    onEnd: (evt) => {
                        this.saveOrder();
                    }
                });
            }
        },

        showToast(msg) {
            this.toast.message = msg;
            this.toast.show = true;
            setTimeout(() => { this.toast.show = false; }, 3000);
        },

        async saveOrder() {
            const rows = document.querySelectorAll('#brands-sortable-tbody tr[data-id]');
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

        async toggleItemStatus(id, evt) {
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

        async saveSettings() {
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
                        home_brands_enabled: this.sectionEnabled,
                        home_brands_title: this.sectionTitle
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.showToast(data.message);
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