<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Membresía Expira Pronto</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6; }
        .email-container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
        .header { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 40px 30px; text-align: center; } /* Amber Warning Color */
        .header h1 { color: #ffffff; margin: 0 0 10px 0; font-size: 28px; font-weight: 800; }
        .header p { color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 14px; }
        .icon-badge { width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 40px; }
        .content { padding: 40px 30px; }
        .greeting { font-size: 18px; color: #1f2937; margin-bottom: 20px; font-weight: 600; }
        .message { color: #6b7280; line-height: 1.6; margin-bottom: 30px; }
        .info-box { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 8px; margin-bottom: 30px; }
        .info-box p { margin: 0; color: #92400e; font-size: 14px; line-height: 1.5; }
        .button { display: inline-block; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 700; text-align: center; margin: 20px 0; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4); }
        .footer { background: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 5px 0; }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="icon-badge">⏳</div>
            <h1>Tu Membresía Expira Pronto</h1>
            <p>{{ $membership->plan->name }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">¡Hola {{ $membership->user->name }}!</div>
            
            <div class="message">
                <p>Te escribimos para recordarte que tu suscripción al plan <strong>{{ $membership->plan->name }}</strong> está por finalizar.</p>
                <p>No pierdas acceso a todos tus beneficios, descargas premium y soporte prioritario.</p>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <p><strong>Fecha de Expiración:</strong> {{ $membership->end_date->format('d \d\e F, Y') }}</p>
                <p>Te quedan: <strong>{{ now()->diffInDays($membership->end_date) }} días</strong>.</p>
            </div>

            <!-- CTA Button -->
            <center>
                <a href="{{ route('pricing') }}" class="button">Renovar Membresía Ahora</a>
            </center>

            <div class="message" style="margin-top: 30px; font-size: 14px;">
                <p>Si ya has renovado tu plan, por favor ignora este mensaje.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Esperamos seguir ayudándote en tus proyectos.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>