<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔥 ¡No pierdas tu racha!</title>
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
            background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%);
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
            text-align: center;
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
        .streak-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px;
            padding: 30px;
            margin: 20px 0 30px 0;
            border: 2px solid #FF2121;
            box-shadow: 0 4px 12px rgba(245, 27, 27, 0.2);
            text-align: center;
        }
        .streak-card h2 {
            margin: 0 0 5px 0;
            color: #92400e;
            font-size: 32px;
            font-weight: 800;
        }
        .streak-card .streak-title {
            color: #FF2121;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .streak-card .description {
            color: #78350f;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 700;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(245, 27, 27, 0.4);
        }
        .info-box {
            background: #fdf2f8;
            border-left: 4px solid #db2777;
            padding: 15px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: left;
        }
        .info-box p {
            margin: 0;
            color: #9d174d;
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
            <div class="icon-badge">🔥</div>
            <h1>¡No pierdas tu racha!</h1>
            <p>Quedan pocas horas para reclamar tus puntos de hoy</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Hola {{ $user->name }},</div>
            
            <div class="message">
                <p>Notamos que aún no has entrado a reclamar tu recompensa diaria de hoy.</p>
                <p>¡No dejes que se apague el fuego! Entra ahora para mantener tu racha activa y seguir sumando puntos gratis en GPLWolf.</p>
            </div>

            <!-- Streak Card -->
            <div class="streak-card">
                <div class="streak-title">Racha Actual</div>
                <h2>{{ $streak }} Días</h2>
                <div class="description">
                    Recuerda que si no reclamas hoy, tu racha volverá a <strong>0 días</strong> y perderás tu progreso hacia el cofre final.
                </div>
            </div>

            <!-- CTA Button -->
            <a href="{{ route('user.rewards') }}" class="button">RECLAMAR PUNTOS AHORA</a>

            <!-- Info Box -->
            <div class="info-box">
                <p>💡 <strong>¿Para qué sirven los puntos?</strong> Puedes canjear tus puntos por descuentos adicionales permanentes o saldo para adquirir plantillas y complementos de WordPress Premium en GPLWolf.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} GPLWolf. Todos los derechos reservados.</p>
            <p>Has recibido este correo electrónico porque eres un usuario registrado en GPLWolf.</p>
        </div>
    </div>
</body>
</html>
