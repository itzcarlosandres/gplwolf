<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membresía por Expirar</title>
    <style>
        body { font-family: -apple-system, system-ui, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background-color: #d97706; padding: 30px; text-align: center; color: white; }
        .content { padding: 30px; color: #374151; line-height: 1.6; }
        .warning-box { background-color: #fffbeb; border: 1px solid #fbbf24; color: #92400e; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .btn { display: inline-block; background-color: #d97706; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1 style="margin:0;">⚠️ Acción Requerida</h1>
        </div>
        <div class="content">
            <h2>Hola {{ $membership->user->name }},</h2>
            
            <p>Te informamos que tu membresía <strong>{{ $membership->plan->name }}</strong> está próxima a vencer.</p>
            
            <div class="warning-box">
                <strong>Fecha de Expiración:</strong> {{ $membership->expires_at ? $membership->expires_at->format('d/m/Y') : 'Pronto' }} <br>
                Tu Membresía expira en {{ \Carbon\Carbon::now()->diffInDays($membership->expires_at) }} días.
            </div>

            <p>Para evitar la interrupción de tus descargas y beneficios exclusivos, te recomendamos renovar tu plan hoy mismo.</p>

            <center>
                <a href="{{ route('home') }}" class="btn">Renovar Membresía Ahora</a>
            </center>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>