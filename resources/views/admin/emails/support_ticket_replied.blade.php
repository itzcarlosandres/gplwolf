<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Respuesta en Soporte</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6; }
        .email-container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px 30px; text-align: center; } /* Green Support Color */
        .header h1 { color: #ffffff; margin: 0 0 10px 0; font-size: 28px; font-weight: 800; }
        .header p { color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 14px; }
        .icon-badge { width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 40px; }
        .content { padding: 40px 30px; }
        .greeting { font-size: 18px; color: #1f2937; margin-bottom: 20px; font-weight: 600; }
        .message { color: #374151; line-height: 1.6; margin-bottom: 30px; }
        .reply-box { background: #f3f4f6; border-left: 4px solid #10b981; padding: 20px; border-radius: 8px; margin-bottom: 30px; white-space: pre-line; color: #1f2937; }
        .button { display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 700; text-align: center; margin: 20px 0; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4); }
        .footer { background: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 5px 0; }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="icon-badge">💬</div>
            <h1>Respuesta de Soporte</h1>
            <p>Ticket #{{ $ticket->id }} • {{ $ticket->subject }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Hola {{ $ticket->user->name }},</div>
            
            <div class="message">
                <p>Hemos respondido a tu solicitud de soporte.</p>
            </div>

            <!-- Reply Box -->
            <div class="reply-box">
                {{ $replyContent }}
            </div>

            <!-- CTA Button -->
            <center>
                <a href="{{ route('user.support.show', $ticket) }}" class="button">Ver Ticket & Responder</a>
            </center>
            
            <div class="message" style="margin-top: 20px; font-size: 14px; text-align: center; color: #9ca3af;">
                <p>Estado del Ticket: <strong>{{ ucfirst($ticket->status) }}</strong></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>