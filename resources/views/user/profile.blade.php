@extends('layouts.user')

@section('title', $isOwnProfile ? 'Mi Perfil' : $user->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-6">
    
    <!-- Header Compacto -->
    <div class="glass rounded-2xl p-6 mb-6">
        <div class="flex items-center gap-6">
            <!-- Avatar -->
            <div class="relative flex-shrink-0">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#F51B1B] to-pink-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-user text-3xl text-white"></i>
                </div>
                @if($user->rank)
                <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full flex items-center justify-center shadow-lg" 
                     style="background: linear-gradient(135deg, {{ $user->rank->color }}80 0%, {{ $user->rank->color }} 100%);">
                    <i class="{{ $user->rank->icon ?? 'fas fa-crown' }} text-white text-sm"></i>
                </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-black text-white mb-1">{{ $user->name }}</h1>
                <p class="text-sm text-gray-400 font-bold mb-3">
                    Miembro desde {{ $user->created_at->format('F Y') }}
                </p>
                
                <!-- Quick Stats -->
                <div class="flex gap-4 flex-wrap">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-coins text-yellow-400 text-sm"></i>
                        <span class="text-sm font-black text-white">{{ number_format($user->points) }}</span>
                        <span class="text-xs text-gray-500">pts</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-[#FF2121] text-sm"></i>
                        <span class="text-sm font-black text-white">{{ $stats['total_orders'] }}</span>
                        <span class="text-xs text-gray-500">compras</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-fire text-orange-400 text-sm"></i>
                        <span class="text-sm font-black text-white">{{ $stats['current_streak'] }}</span>
                        <span class="text-xs text-gray-500">días</span>
                    </div>
                </div>
            </div>

            <!-- Rango Actual -->
            @if($user->rank)
            <div class="hidden md:flex flex-col items-center gap-2 px-6 py-4 rounded-xl border" 
                 style="background: linear-gradient(135deg, {{ $user->rank->color }}10 0%, {{ $user->rank->color }}05 100%); border-color: {{ $user->rank->color }}20;">
                <i class="{{ $user->rank->icon ?? 'fas fa-shield-alt' }} text-3xl" style="color: {{ $user->rank->color }}"></i>
                <div class="text-center">
                    <div class="text-lg font-black text-white">{{ $user->rank->name }}</div>
                    <div class="text-xs font-bold" style="color: {{ $user->rank->color }}">{{ $user->rank->discount_percentage }}% OFF</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Grid de 2 Columnas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Progreso -->
        <div class="glass rounded-2xl p-6">
            <h3 class="text-sm font-black text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-[#F51B1B]"></i>
                Próximo Nivel
            </h3>
            
            @php
                $allRanks = \App\Models\Rank::orderBy('min_points', 'asc')->get();
                $nextRank = $allRanks->where('min_points', '>', $user->points)->first();
                $currentRank = $user->rank;
                
                if ($nextRank && $currentRank) {
                    $pointsInCurrentTier = $user->points - $currentRank->min_points;
                    $pointsNeededForNext = $nextRank->min_points - $currentRank->min_points;
                    $progressPercent = ($pointsInCurrentTier / $pointsNeededForNext) * 100;
                } elseif ($nextRank && !$currentRank) {
                    $progressPercent = ($user->points / $nextRank->min_points) * 100;
                } else {
                    $progressPercent = 100;
                }
            @endphp
            
            @if($nextRank)
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" 
                     style="background: linear-gradient(135deg, {{ $currentRank->color ?? '#FF2121' }}80 0%, {{ $currentRank->color ?? '#F51B1B' }} 100%);">
                    <i class="{{ $currentRank->icon ?? 'fas fa-shield-alt' }} text-white text-lg"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between text-xs font-bold text-gray-400 mb-1">
                        <span>{{ $currentRank->name ?? 'Bronce' }}</span>
                        <span class="text-[#F51B1B]">{{ $nextRank->name }}</span>
                    </div>
                    <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-yellow-500 to-[#F51B1B]" style="width: {{ min($progressPercent, 100) }}%;"></div>
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-500 text-center">
                {{ number_format($nextRank->min_points - $user->points) }} puntos para {{ $nextRank->name }} ({{ $nextRank->discount_percentage }}% OFF)
            </p>
            @else
            <div class="text-center py-4">
                <i class="fas fa-crown text-5xl text-yellow-400 mb-3"></i>
                <p class="text-sm font-bold text-white">¡Rango Máximo Alcanzado!</p>
            </div>
            @endif
        </div>

        <!-- Máximo Alcanzado -->
        <div class="glass rounded-2xl p-6">
            <h3 class="text-sm font-black text-white mb-4 flex items-center gap-2">
                <i class="fas fa-crown text-yellow-400"></i>
                Máximo Alcanzado
            </h3>
            
            @if($user->maxRank)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" 
                         style="background: linear-gradient(135deg, {{ $user->maxRank->color }}80 0%, {{ $user->maxRank->color }} 100%);">
                        <i class="{{ $user->maxRank->icon ?? 'fas fa-crown' }} text-white text-lg"></i>
                    </div>
                    <div>
                        <div class="text-xl font-black text-white">{{ $user->maxRank->name }}</div>
                        <div class="text-xs font-bold" style="color: {{ $user->maxRank->color }}">Logro Permanente</div>
                    </div>
                </div>
                @if($isOwnProfile && isset($stats['rank_savings']))
                <div class="text-right">
                    <div class="text-2xl font-black text-white">${{ number_format($stats['rank_savings'], 0) }}</div>
                    <div class="text-xs text-green-400 font-bold">Ahorrado</div>
                </div>
                @endif
            </div>
            @else
            <p class="text-sm text-gray-500 text-center py-4">Aún no has alcanzado ningún rango</p>
            @endif
        </div>

        <!-- Logros -->
        <div class="glass rounded-2xl p-6">
            <h3 class="text-sm font-black text-white mb-4 flex items-center gap-2">
                <i class="fas fa-trophy text-yellow-400"></i>
                Logros ({{ collect($achievements)->where('unlocked', true)->count() }}/{{ count($achievements) }})
            </h3>
            
            <div class="grid grid-cols-4 gap-3">
                @foreach($achievements as $achievement)
                <div class="aspect-square rounded-lg flex items-center justify-center cursor-pointer transition-transform {{ $achievement['unlocked'] ? 'bg-gradient-to-br ' . $achievement['color'] . ' hover:scale-110' : 'bg-gray-700 opacity-40' }}"
                     title="{{ $achievement['name'] }}">
                    <i class="fas {{ $achievement['icon'] }} text-white text-lg"></i>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Estadísticas -->
        @if($isOwnProfile)
        <div class="glass rounded-2xl p-6">
            <h3 class="text-sm font-black text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-[#FF2121]"></i>
                Estadísticas
            </h3>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Total Gastado</span>
                    <span class="text-sm font-black text-white">${{ number_format($stats['total_spent'] ?? 0, 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Productos</span>
                    <span class="text-sm font-black text-white">{{ $stats['products_purchased'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Pts. Ganados</span>
                    <span class="text-sm font-black text-[#F51B1B]">{{ number_format($stats['points_earned'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Pts. Canjeados</span>
                    <span class="text-sm font-black text-amber-400">{{ number_format($stats['points_redeemed'] ?? 0) }}</span>
                </div>
            </div>
        </div>
        @endif

    </div>

    <!-- Actividad Reciente (Full Width) -->
    @if(count($recentActivity) > 0)
    <div class="glass rounded-2xl p-6 mt-6">
        <h3 class="text-sm font-black text-white mb-4 flex items-center gap-2">
            <i class="fas fa-history text-green-400"></i>
            Actividad Reciente
        </h3>
        
        <div class="space-y-3">
            @foreach($recentActivity as $activity)
            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-all">
                <div class="w-8 h-8 rounded-full bg-{{ $activity['color'] }}-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}-400 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-white">{{ $activity['title'] }}</div>
                    <div class="text-[10px] text-gray-500">{{ $activity['description'] }}</div>
                </div>
                <div class="text-[10px] text-gray-500 whitespace-nowrap">{{ $activity['date']->diffForHumans() }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection