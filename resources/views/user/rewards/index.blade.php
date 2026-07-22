@extends('layouts.user')

@section('title', 'Mis Recompensas')

@section('content')
<div class="relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-yellow-500/10 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-[#F51B1B]/10 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-5xl mx-auto px-6">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <span class="text-yellow-500 font-bold uppercase tracking-widest text-xs mb-4 block animate-bounce">🎁 Bonus Diario</span>
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-6">
                Recompensas <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">Diarias</span>
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto text-lg">Entra cada día para ganar puntos gratis. ¡Completa la racha de 7 días para desbloquear el Cofre Legendario!</p>
        </div>

        <!-- Main Card -->
        <div class="glass border border-white/10 rounded-[40px] p-8 md:p-12 relative overflow-hidden" x-data="rewardsApp()">
            
            <!-- Streak Header -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center text-3xl shadow-lg shadow-orange-500/20 text-white animate-pulse">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-white">Racha: <span x-text="streak">{{ $status['streak'] }}</span> Días</h3>
                        <p class="text-gray-400 text-sm font-bold">¡Sigue así! No rompas la cadena.</p>
                    </div>
                </div>
                
                <div class="bg-white/5 rounded-2xl px-6 py-3 border border-white/5 flex items-center gap-3">
                    <i class="fas fa-coins text-yellow-400 text-xl"></i>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Mis Puntos</p>
                        <p class="text-white font-black text-xl">{{ Auth::user()->points }}</p>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-12 relative z-10">
                
                @foreach($status['week_calendar'] as $day)
                    @php
                        $isChest = $day['day'] == 7;
                        $statusClass = '';
                        $opacity = '';
                        $border = '';
                        
                        if ($day['status'] == 'claimed') {
                            $statusClass = 'bg-gray-900/50 border-green-500/30';
                            $opacity = 'opacity-50';
                        } elseif ($day['status'] == 'active') {
                             $statusClass = 'bg-gradient-to-b from-[#FF2121] to-[#F51B1B] border-[#FF2121] shadow-[0_0_30px_rgba(255, 33, 33, 0.5)] transform scale-110 z-20 cursor-pointer hover:scale-115 transition-transform';
                             $opacity = '';
                        } else {
                            $statusClass = 'bg-white/5 border-white/5 grayscale';
                            $opacity = 'opacity-50';
                        }

                        if ($isChest) {
                             $statusClass = 'bg-gradient-to-br from-[#F51B1B]/50 to-pink-900/50 border-[#F51B1B]/30 group';
                             $opacity = ''; 
                        }
                    @endphp

                <!-- Day {{ $day['day'] }} -->
                <div class="aspect-[3/4] rounded-2xl flex flex-col items-center justify-center p-4 relative group {{ $statusClass }} {{ $opacity }}">
                    @if($day['status'] == 'claimed')
                        <div class="absolute inset-0 bg-green-500/5"></div>
                        <span class="text-xs font-bold text-green-400 mb-2">Día {{ $day['day'] }}</span>
                        <i class="fas fa-check-circle text-3xl text-green-500 mb-2"></i>
                        <span class="text-white font-black opacity-50">+{{ $day['points'] }} Pts</span>
                    @elseif($day['status'] == 'active')
                        <!-- Active Day -->
                        <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-white to-transparent opacity-50"></div>
                        <span class="text-xs font-black text-[#FF2121] uppercase tracking-widest mb-3">HOY</span>
                        <div class="w-12 h-12 rounded-full bg-black/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i class="fas fa-gift text-2xl text-yellow-300 animate-[wiggle_1s_ease-in-out_infinite]"></i>
                        </div>
                        <span class="text-white font-black text-xl drop-shadow-lg">+{{ $day['points'] }}</span>
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    @elseif($isChest)
                        <!-- Chest Day -->
                         <div class="absolute inset-0 bg-[#F51B1B]/10 group-hover:bg-[#F51B1B]/20 transition-colors"></div>
                        <span class="text-xs font-black text-[#F51B1B] mb-2">Día 7</span>
                        <i class="fas fa-gem text-3xl text-[#FF2121] mb-2 group-hover:scale-110 transition-transform shadow-[#F51B1B]/50 drop-shadow-[0_0_10px_rgba(245, 27, 27, 0.5)]"></i>
                        <span class="text-white font-black text-sm text-center">COFRE<br>RARO</span>
                    @else
                        <!-- Locked -->
                        <span class="text-xs font-bold text-gray-500 mb-2">Día {{ $day['day'] }}</span>
                        <i class="fas fa-lock text-2xl text-gray-600 mb-2"></i>
                        <span class="text-gray-400 font-bold text-sm">+{{ $day['points'] }} Pts</span>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- CTA Button -->
            <div class="text-center">
                @if($status['claimed_today'])
                    <div class="flex flex-col items-center gap-4">
                        <button disabled class="px-12 py-5 bg-gray-800 text-gray-400 font-bold text-lg rounded-2xl cursor-not-allowed border border-white/5">
                            <i class="fas fa-check mr-2"></i> ¡Vuelve mañana!
                        </button>
                        
                        <!-- Rest Timer -->
                        <div class="bg-black/30 px-6 py-2 rounded-xl border border-white/10" x-init="startTimer()">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1">Próxima recompensa en</p>
                            <div class="font-mono text-xl font-black text-yellow-400 tracking-widest" x-text="countdown">--:--:--</div>
                        </div>
                    </div>
                @else
                    <button @click="claim()" :disabled="loading" 
                            class="relative group px-12 py-5 bg-[#F51B1B] text-white font-black text-lg rounded-2xl shadow-xl shadow-[#F51B1B]/30 overflow-hidden transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        <span class="relative flex items-center gap-3">
                            <span x-text="loading ? 'Reclamando...' : 'RECLAMAR {{ $status['next_points'] }} PUNTOS'"></span> 
                            <i class="fas fa-hand-pointer animate-pulse" x-show="!loading"></i>
                            <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                        </span>
                    </button>
                    <p class="mt-4 text-xs text-gray-500 font-bold">No rompas la racha para llegar al cofre.</p>
                @endif
            </div>

        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <div class="bg-white/5 rounded-2xl p-6 border border-white/5">
                <i class="fas fa-sync text-2xl text-[#FF2121] mb-3"></i>
                <h4 class="text-white font-bold mb-1">Reset Diario</h4>
                <p class="text-sm text-gray-400">El día se reinicia a las 00:00 UTC. No olvides entrar antes.</p>
            </div>
            <div class="bg-white/5 rounded-2xl p-6 border border-white/5">
                <i class="fas fa-link text-2xl text-[#F51B1B] mb-3"></i>
                <h4 class="text-white font-bold mb-1">Mantén la Racha</h4>
                <p class="text-sm text-gray-400">Si fallas un día, la racha vuelve a 0 y pierdes el cofre final.</p>
            </div>
            <div class="bg-white/5 rounded-2xl p-6 border border-white/5">
                <i class="fas fa-store text-2xl text-emerald-400 mb-3"></i>
                <h4 class="text-white font-bold mb-1">Gasta tus Puntos</h4>
                <p class="text-sm text-gray-400">Usa tus puntos para descuentos en plugins premium.</p>
            </div>
        </div>

    </div>
</div>

<!-- RANK PROGRESS SECTION -->
<div class="max-w-5xl mx-auto px-6 mt-12">
    <div class="glass border border-white/10 rounded-[40px] p-8 md:p-12 relative overflow-hidden">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <span class="text-[#F51B1B] font-bold uppercase tracking-widest text-xs mb-4 block">🛡️ Sistema de Rangos</span>
            <h2 class="text-3xl md:text-4xl font-black text-white tracking-tighter mb-4">
                Tu Nivel <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F51B1B] to-pink-500">VIP</span>
            </h2>
            <p class="text-gray-400 max-w-xl mx-auto mb-6">Sube de nivel ganando puntos. Cada rango desbloquea descuentos permanentes en toda la tienda.</p>
            
            @if(auth()->user()->maxRank && auth()->user()->maxRank->id !== auth()->user()->current_rank_id)
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-500/10 border border-yellow-500/20">
                <i class="fas fa-crown text-yellow-400"></i>
                <span class="text-xs font-black text-yellow-400">MÁXIMO ALCANZADO: {{ auth()->user()->maxRank->name }}</span>
            </div>
            @endif
        </div>

        @if($currentRank)
        <!-- Current Rank Card -->
        <div class="relative overflow-hidden rounded-3xl border border-white/10 p-8 mb-8" style="background: linear-gradient(135deg, {{ $currentRank->color }}15 0%, transparent 100%);">
            <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full blur-[100px] opacity-20" style="background-color: {{ $currentRank->color }}"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">
                <!-- Rank Icon -->
                <div class="w-32 h-32 relative flex-shrink-0">
                    <div class="absolute inset-0 rounded-full opacity-20 blur-xl animate-pulse" style="background-color: {{ $currentRank->color }}"></div>
                    <div class="w-full h-full rounded-full flex items-center justify-center shadow-2xl border-4 border-white/10 relative z-10" style="background: linear-gradient(135deg, {{ $currentRank->color }}80 0%, {{ $currentRank->color }} 100%);">
                        <i class="{{ $currentRank->icon ?? 'fas fa-shield-alt' }} text-5xl text-white"></i>
                    </div>
                </div>

                <!-- Progress Info -->
                <div class="flex-1 w-full">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <span class="block text-xs font-black uppercase tracking-widest mb-1" style="color: {{ $currentRank->color }}">Tu Rango Actual</span>
                            <h3 class="text-3xl font-black text-white">{{ $currentRank->name }}</h3>
                        </div>
                        @if($nextRank)
                        <div class="text-right">
                            <span class="block text-xs font-black text-[#F51B1B] uppercase tracking-widest mb-1">Próximo Rango</span>
                            <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#F51B1B] to-pink-500">{{ $nextRank->name }} <i class="fas fa-chevron-right text-xs ml-1"></i></h3>
                        </div>
                        @else
                        <div class="text-right">
                            <span class="block text-xs font-black text-yellow-400 uppercase tracking-widest mb-1">¡Nivel Máximo!</span>
                            <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">Completado <i class="fas fa-crown text-xs ml-1"></i></h3>
                        </div>
                        @endif
                    </div>

                    <!-- Progress Bar -->
                    @if($nextRank)
                    <div class="h-4 bg-gray-800 rounded-full overflow-hidden relative border border-white/5">
                        <div class="absolute top-0 left-0 h-full rounded-full shadow-[0_0_15px_rgba(245, 27, 27, 0.5)] relative transition-all duration-500" 
                             style="width: {{ min($progressPercent, 100) }}%; background: linear-gradient(90deg, {{ $currentRank->color }} 0%, #F51B1B 100%);">
                             <div class="absolute top-0 right-0 bottom-0 w-1 bg-white/50 animate-pulse"></div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-2 text-xs font-bold text-gray-500">
                        <span>{{ number_format(Auth::user()->points) }} Puntos</span>
                        <span>{{ number_format($nextRank->min_points - Auth::user()->points) }} Puntos para {{ $nextRank->name }}</span>
                    </div>
                    @else
                    <div class="h-4 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full overflow-hidden relative border border-yellow-500/30 shadow-[0_0_20px_rgba(234,179,8,0.4)]"></div>
                    <p class="text-center mt-2 text-xs font-bold text-yellow-400">¡Has alcanzado el rango máximo!</p>
                    @endif

                    <div class="mt-6 flex gap-4 flex-wrap">
                         <div class="px-4 py-2 rounded-xl bg-gray-800/50 border border-white/5 flex items-center gap-3">
                            <i class="fas fa-tag text-[#F51B1B]"></i>
                            <span class="text-gray-300 text-sm">Descuento Actual: <span class="text-white font-black">{{ $currentRank->discount_percentage }}% OFF</span></span>
                         </div>
                         @if($nextRank)
                         <div class="px-4 py-2 rounded-xl bg-[#F51B1B]/10 border border-[#F51B1B]/20 flex items-center gap-3">
                            <i class="fas fa-lock-open text-[#F51B1B]"></i>
                            <span class="text-[#FF2121] text-sm">En {{ $nextRank->name }}: <span class="text-[#F51B1B] font-black">{{ $nextRank->discount_percentage }}% OFF</span></span>
                         </div>
                         @endif
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- No Rank Yet -->
        <div class="text-center py-12 bg-white/5 rounded-3xl border border-white/10 mb-8">
            <i class="fas fa-shield-alt text-6xl text-gray-600 mb-4"></i>
            <h3 class="text-2xl font-black text-white mb-2">Sin Rango Asignado</h3>
            <p class="text-gray-400 mb-6">Gana puntos para alcanzar tu primer rango y desbloquear beneficios.</p>
            @if($allRanks->first())
            <p class="text-sm text-gray-500">Necesitas <span class="text-white font-bold">{{ $allRanks->first()->min_points }} puntos</span> para alcanzar <span class="font-bold" style="color: {{ $allRanks->first()->color }}">{{ $allRanks->first()->name }}</span></p>
            @endif
        </div>
        @endif

        <!-- All Ranks Grid -->
        <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-3">
            <i class="fas fa-trophy text-[#F51B1B]"></i> Todos los Niveles
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($allRanks as $rank)
            <div class="glass p-6 rounded-2xl border flex flex-col items-center text-center transition-all hover:-translate-y-2 relative
                {{ $currentRank && $currentRank->id === $rank->id ? 'border-2 scale-105 shadow-2xl' : 'border-white/5 opacity-60 grayscale hover:grayscale-0 hover:opacity-100' }}"
                style="{{ $currentRank && $currentRank->id === $rank->id ? 'border-color: ' . $rank->color . '; box-shadow: 0 0 30px ' . $rank->color . '40;' : '' }}">
                
                @if($currentRank && $currentRank->id === $rank->id)
                <div class="absolute top-3 right-3 text-xs font-black px-2 py-0.5 rounded" style="background-color: {{ $rank->color }}; color: white;">TÚ</div>
                @endif

                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 shadow-lg ring-4 ring-opacity-20" 
                     style="background: linear-gradient(135deg, {{ $rank->color }}80 0%, {{ $rank->color }} 100%); ring-color: {{ $rank->color }};">
                    <i class="{{ $rank->icon ?? 'fas fa-shield-alt' }} text-2xl text-white"></i>
                </div>
                
                <h3 class="text-xl font-black mb-1" style="color: {{ $rank->color }}">{{ $rank->name }}</h3>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">{{ number_format($rank->min_points) }}+ Puntos</p>
                
                <div class="w-full rounded-xl p-3 mb-4" style="background-color: {{ $rank->color }}15; border: 1px solid {{ $rank->color }}30;">
                    <span class="block text-2xl font-black" style="color: {{ $rank->color }}">{{ $rank->discount_percentage }}% OFF</span>
                    <span class="text-[10px] text-gray-500 uppercase font-black">En toda la tienda</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Info Footer -->
        <div class="mt-8 text-center">
            <p class="text-gray-500 text-sm">
                * Los rangos se actualizan automáticamente al alcanzar los puntos requeridos. Los descuentos se aplican automáticamente en el checkout.
            </p>
        </div>

    </div>
</div>


<style>
@keyframes wiggle {
    0%, 100% { transform: rotate(-3deg); }
    50% { transform: rotate(3deg); }
}
</style>

<script>
    function rewardsApp() {
        return {
            loading: false,
            streak: {{ $status['streak'] }},
            countdown: '--:--:--',
            
            startTimer() {
                // Parse last detailed claim time from server, or fallback to now
                const lastClaimTime = new Date('{{ \Carbon\Carbon::parse($status["last_claim_at"] ?? now())->toIso8601String() }}');
                const nextClaimTime = new Date(lastClaimTime.getTime() + 24 * 60 * 60 * 1000); // Add 24 hours

                const updateTimer = () => {
                    const now = new Date();
                    const diff = nextClaimTime - now;
                    
                    if (diff <= 0) {
                        this.countdown = "00:00:00";
                        if (diff > -2000) location.reload(); // Reload shortly after expiration
                        return;
                    }

                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    this.countdown = 
                        String(hours).padStart(2, '0') + ':' + 
                        String(minutes).padStart(2, '0') + ':' + 
                        String(seconds).padStart(2, '0');
                };

                updateTimer();
                setInterval(updateTimer, 1000);
            },

            claim() {
                this.loading = true;
                fetch('{{ route("user.rewards.claim") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success Animation or Reload
                        alert('¡+' + data.points + ' Puntos ganados!');
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    alert('Error al reclamar recompensa.');
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        }
    }
</script>
@endsection