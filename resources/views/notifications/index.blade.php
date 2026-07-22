@extends('layouts.user')

@section('title', 'Mis Notificaciones')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Notificaciones</h1>
            <p class="text-gray-400 mt-2 font-medium">Mantente al tanto de las actualizaciones de tus productos y novedades.</p>
        </div>
        
        @if($notifications->count() > 0)
        <button id="mark-all-read-btn" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all border border-white/5 flex items-center gap-2">
            <i class="fas fa-check-double"></i> Marcar todas como leídas
        </button>
        @endif
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="glass p-6 rounded-3xl border border-white/5 hover:bg-white/[0.02] transition-all group relative overflow-hidden {{ !$notification->is_read ? 'shadow-lg shadow-[#FF2121]/10 border-l-4 border-l-[#FF2121]' : 'opacity-75 hover:opacity-100' }}">
                
                @if(!$notification->is_read)
                    <div class="absolute top-4 right-4 w-2 h-2 bg-[#FF2121] rounded-full animate-pulse"></div>
                @endif

                <div class="flex items-start gap-5">
                    <!-- Icon Box -->
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 
                        {{ $notification->type === 'product_update' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-[#FF2121]/10 text-[#FF2121] border border-[#FF2121]/20' }}">
                        <i class="fas {{ $notification->icon ?? 'fa-bell' }} text-2xl"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-1">
                            <h3 class="text-lg font-bold text-white group-hover:text-[#FF2121] transition-colors truncate pr-4">
                                {{ $notification->title }}
                            </h3>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider flex-shrink-0 whitespace-nowrap">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <p class="text-gray-400 text-sm leading-relaxed mb-4 max-w-2xl">
                            {{ $notification->message }}
                        </p>

                        <div class="flex items-center gap-3">
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 rounded-lg text-xs font-bold text-white uppercase tracking-wider transition-all border border-white/5">
                                    Ver Detalles <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            @endif
                            
                            @if(!$notification->is_read)
                                <button onclick="markAsRead({{ $notification->id }}, this)" class="text-xs text-gray-500 hover:text-white font-bold underline decoration-dotted underline-offset-4 transition-colors">
                                    Marcar como leída
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bell-slash text-4xl text-gray-600"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Sin notificaciones</h3>
                <p class="text-gray-500 text-sm max-w-md mx-auto">Cuando tengas actualizaciones de tus productos o novedades importantes, aparecerán aquí.</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function markAsRead(id, btn) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(res => {
            if(res.ok) {
                // Reload to reflect changes or settle UI
                window.location.reload();
            }
        });
    }

    const markAllBtn = document.getElementById('mark-all-read-btn');
    if(markAllBtn) {
        markAllBtn.addEventListener('click', () => {
             fetch("{{ route('notifications.read-all') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                if(res.ok) {
                    window.location.reload();
                }
            });
        });
    }
</script>
@endpush
@endsection