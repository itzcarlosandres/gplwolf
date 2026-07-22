<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membresía Activada</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header h1 {
            color: #ffffff;
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }
        .header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            font-size: 14px;
            position: relative;
            z-index: 1;
        }
        .icon-badge {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 50px;
            position: relative;
            z-index: 1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .membership-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            border: 2px solid #f59e0b;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
        }
        .membership-card h2 {
            margin: 0 0 10px 0;
            color: #92400e;
            font-size: 24px;
            font-weight: 800;
        }
        .membership-card .plan-name {
            color: #b45309;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .membership-card .validity {
            color: #78350f;
            font-size: 14px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(146, 64, 14, 0.2);
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        .benefit-item {
            background: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        .benefit-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .benefit-title {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .benefit-desc {
            font-size: 12px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 700;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }
        .info-box {
            background: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .info-box p {
            margin: 0;
            color: #065f46;
            font-size: 14px;
            line-height: 1.5;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #9ca3af;
            font-size: 12px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="icon-badge">👑</div>
            <h1>¡Membresía Activada!</h1>
            <p>Bienvenido al Club Premium</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">¡Felicidades {{ $membership->user->name }}!</div>
            
            <div class="message">
                <p>Tu membresía <strong>{{ $membership->plan->name }}</strong> ha sido activada exitosamente.</p>
                <p>Ahora tienes acceso ilimitado a todos nuestros productos y beneficios exclusivos.</p>
            </div>

            <!-- Membership Card -->
            <div class="membership-card">
                <div class="plan-name">{{ $membership->plan->name }}</div>
                <h2>Membresía {{ $membership->plan->duration_months == 12 ? 'Anual' : ($membership->plan->duration_months . ' Meses') }}</h2>
                <div class="validity">
                    <strong>Válida hasta:</strong> {{ $membership->expires_at->format('d \d\e F, Y') }}<br>
                    <strong>Estado:</strong> {{ $membership->status == 'active' ? 'Activa' : ucfirst($membership->status) }}
                </div>
            </div>

            <!-- Benefits Grid -->
            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-icon">🎨</div>
                    <div class="benefit-title">Acceso Total</div>
                    <div class="benefit-desc">Todos los temas y plugins</div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">⚡</div>
                    <div class="benefit-title">Actualizaciones</div>
                    <div class="benefit-desc">Gratis de por vida</div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">🎯</div>
                    <div class="benefit-title">Soporte VIP</div>
                    <div class="benefit-desc">Prioridad 24/7</div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">💎</div>
                    <div class="benefit-title">Bonus Puntos</div>
                    <div class="benefit-desc">+{{ $bonusPoints }} pts mensuales</div>
                </div>
            </div>

            <!-- Info Box -->
            @if($bonusPoints > 0)
            <div class="info-box">
                <p><strong>🎁 Bonus de Bienvenida</strong><br>
                Hemos añadido {{ $bonusPoints }} puntos extra a tu cuenta como regalo de bienvenida.</p>
            </div>
            @endif

            <!-- CTA Button -->
            <center>
                <a href="{{ route('home') }}" class="button">Explorar Catálogo Premium</a>
            </center>

            <!-- Additional Info -->
            <div class="message" style="margin-top: 30px;">
                <p style="font-size: 14px; color: #9ca3af;">
                    <strong>Detalles de tu Membresía:</strong><br>
                    Monto: ${{ number_format($membership->plan->price, 2) }}/{{ $membership->plan->duration_months == 12 ? 'año' : 'mes' }}<br>
                    Fecha de activación: {{ $membership->created_at->format('d \d\e F, Y') }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Tu tienda de confianza para WordPress</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            <p style="margin-top: 15px;">
                <a href="{{ route('user.profile') }}" style="color: #9ca3af; text-decoration: none;">Gestionar Membresía</a> •
                <a href="{{ route('home') }}" style="color: #9ca3af; text-decoration: none;">Soporte</a>
            </p>
        </div>
    </div>
</body>
</html>