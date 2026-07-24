<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #050505; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #d4d4d8;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #0a0a0c; border: 1px solid #1f1f23; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
        <!-- Header -->
        <tr>
            <td style="padding: 40px 40px 20px 40px; text-align: center; border-bottom: 1px solid #1f1f23;">
                <span style="font-size: 24px; font-weight: 900; color: #fff; letter-spacing: -0.05em; text-transform: uppercase;">
                    GPL<span style="color: #ef4444;">WOLF</span>
                </span>
                <p style="font-size: 10px; font-weight: bold; text-transform: uppercase; color: #52525b; letter-spacing: 0.15em; margin: 5px 0 0 0;">Boletín de Ofertas y Novedades</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 40px; font-size: 15px; line-height: 1.6; color: #a1a1aa;">
                {!! nl2br(e($contentBody)) !!}
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding: 30px 40px; background-color: #050505; border-top: 1px solid #1f1f23; text-align: center; font-size: 11px; color: #52525b;">
                <p style="margin: 0 0 10px 0;">Recibiste este correo porque estás suscrito al boletín de noticias de GPLWolf.</p>
                <p style="margin: 0;">&copy; {{ date('Y') }} GPLWolf. Todos los derechos reservados.</p>
            </td>
        </tr>
    </table>
</body>
</html>
