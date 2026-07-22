<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Nuevo Rango Desbloqueado!</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #0d0d0d;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .header {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header h1 {
            color: #ffffff;
            margin: 0 0 10px 0;
            font-size: 32px;
            font-weight: 900;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        .header p {
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            font-size: 16px;
            position: relative;
            z-index: 1;
            font-weight: 600;
        }
        .rank-badge {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 60px;
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            color: #f1f5f9;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .message {
            color: #cbd5e1;
            line-height: 1.7;
            margin-bottom: 30px;
            font-size: 15px;
        }
        .rank-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
            border: 3px solid #fbbf24;
            box-shadow: 0 8px 24px rgba(251, 191, 36, 0.3);
        }
        .rank-card .old-rank {
            color: #78350f;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .rank-card .arrow {
            font-size: 24px;
            margin: 10px 0;
            color: #92400e;
        }
        .rank-card .new-rank {
            font-size: 36px;
            font-weight: 900;
            color: #92400e;
            margin: 10px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .rank-card .rank-icon {
            font-size: 48px;
            margin: 15px 0;
        }
        .benefits-box {
            background: rgba(251, 191, 36, 0.1);
            border: 2px solid rgba(251, 191, 36, 0.3);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .benefits-box h3 {
            color: #fbbf24;
            margin: 0 0 15px 0;
            font-size: 18px;
            font-weight: 800;
        }
        .benefit-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            color: #e2e8f0;
            font-size: 14px;
        }
        .benefit-item .icon {
            width: 32px;
            height: 32px;
            background: rgba(251, 191, 36, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 16px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 900;
            color: #fbbf24;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #1a1a1a;
            text-decoration: none;
            padding: 18px 36px;
            border-radius: 12px;
            font-weight: 800;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
            font-size: 16px;
        }
        .footer {
            background: #0d0d0d;
            padding: 30px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .footer p {
            color: #64748b;
            font-size: 12px;
            margin: 5px 0;
        }
    </style>
</head>
@php
    // Map FontAwesome classes to Emojis for Email Compatibility
    $iconMap = [
        'fas fa-crown' => '👑',
        'fas fa-medal' => '🥇',
        'fas fa-star' => '⭐',
        'fas fa-trophy' => '🏆',
        'fas fa-gem' => '💎',
        'fas fa-bolt' => '⚡',
        'fas fa-fire' => '🔥',
        'fas fa-rocket' => '🚀',
        'fas fa-heart' => '❤️',
        'fas fa-award' => '🎖️',
        'fas fa-certificate' => '📜',
        'fas fa-shield-alt' => '🛡️',
        'fas fa-thumbs-up' => '👍',
        'fas fa-gift' => '🎁',
    ];
    
    // Get icon from rank, defaulting to crown if not found
    $rawIcon = $newRank->icon ?? 'fas fa-crown';
    
    // Check if it's in the map, otherwise use crown if it looks like a class, or use raw if it's already an emoji
    $rankIcon = $iconMap[$rawIcon] ?? (str_contains($rawIcon, 'fa-') ? '👑' : $rawIcon);
@endphp
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="rank-badge">{{ $rankIcon }}</div>
            <h1>¡Felicidades!</h1>
            <p>Has Alcanzado un Nuevo Rango</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">¡Increíble logro, {{ $user->name }}!</div>
            
            <div class="message">
                <p>Tu dedicación ha dado frutos. Has acumulado suficientes puntos para desbloquear un nuevo nivel VIP.</p>
            </div>

            <!-- Rank Card -->
            <div class="rank-card">
                @if($oldRank)
                <div class="old-rank">Rango Anterior: {{ $oldRank->name }}</div>
                <div class="arrow">⬇️</div>
                @endif
                <div class="rank-icon">{{ $rankIcon }}</div>
                <div class="new-rank">{{ strtoupper($newRank->name) }}</div>
                <div style="color: #92400e; font-size: 14px; font-weight: 700; margin-top: 10px;">
                    ¡Este logro es permanente!
                </div>
            </div>

            <!-- Benefits Box -->
            <div class="benefits-box">
                <h3>✨ Beneficios Desbloqueados</h3>
                
                <div class="benefit-item">
                    <div class="icon">💰</div>
                    <div><strong>{{ $newRank->discount_percentage }}% de Descuento</strong> en todas tus compras</div>
                </div>
                
                <div class="benefit-item">
                    <div class="icon">⚡</div>
                    <div><strong>Acceso Anticipado</strong> a nuevos productos</div>
                </div>
                
                <div class="benefit-item">
                    <div class="icon">🎁</div>
                    <div><strong>Bonus Mensual</strong> de puntos gratis</div>
                </div>
                
                <div class="benefit-item">
                    <div class="icon">🏆</div>
                    <div><strong>Badge Exclusivo</strong> en tu perfil</div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ number_format($user->points) }}</div>
                    <div class="stat-label">Puntos Actuales</div>
                </div>
                
                @php
                    $nextRank = \App\Models\Rank::where('min_points', '>', $user->points)->orderBy('min_points', 'asc')->first();
                    $pointsToNext = $nextRank ? ($nextRank->min_points - $user->points) : 0;
                @endphp
                
                <div class="stat-card">
                    <div class="stat-value">{{ $nextRank ? number_format($pointsToNext) : '∞' }}</div>
                    <div class="stat-label">{{ $nextRank ? 'Para ' . $nextRank->name : 'Rango Máximo' }}</div>
                </div>
            </div>

            <!-- CTA Button -->
            <center>
                <a href="{{ route('user.profile') }}" class="button">Ver Mi Perfil VIP</a>
            </center>

            <!-- Additional Message -->
            @if($nextRank)
            <div class="message" style="margin-top: 30px; text-align: center;">
                <p style="color: #94a3b8; font-size: 13px;">
                    Sigue acumulando puntos para alcanzar el rango <strong style="color: {{ $nextRank->color ?? '#06b6d4' }};">{{ $nextRank->name }}</strong> y desbloquear un {{ $nextRank->discount_percentage }}% de descuento permanente.
                </p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong style="color: #94a3b8;">{{ config('app.name') }}</strong></p>
            <p>Tu tienda de confianza para WordPress</p>
            <p style="margin-top: 15px;">© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>