<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña | CaletaWP</title>
</head>
<body style="background-color: #080808; color: #d1d5db; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; margin: 0; padding: 40px 20px; line-height: 1.6;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #0d0d0d; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        <!-- Header -->
        <tr>
            <td style="padding: 40px 40px 20px 40px; text-align: center;">
                <div style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); border-radius: 8px; color: #ffffff; font-weight: 900; font-size: 18px; letter-spacing: 1px; text-transform: uppercase;">
                    CALETA WP
                </div>
            </td>
        </tr>
        
        <!-- Content -->
        <tr>
            <td style="padding: 20px 40px 40px 40px;">
                <h1 style="color: #ffffff; font-size: 24px; font-weight: 800; margin-top: 0; margin-bottom: 20px; text-align: center;">¿Olvidaste tu contraseña?</h1>
                
                <p style="color: #9ca3af; font-size: 15px; margin-bottom: 25px;">
                    Hola, <strong>{{ $name }}</strong>:
                </p>
                <p style="color: #9ca3af; font-size: 15px; margin-bottom: 30px;">
                    Recibimos una solicitud para restablecer la contraseña de tu cuenta en CaletaWP. Si no la solicitaste, puedes ignorar este correo de forma segura. De lo contrario, puedes cambiarla haciendo clic en el botón de abajo:
                </p>
                
                <!-- Action Button -->
                <div style="text-align: center; margin-bottom: 40px;">
                    <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 14px 30px; background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 8px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 4px 15px rgba(255, 33, 33, 0.3);">
                        Restablecer Contraseña
                    </a>
                </div>
                
                <p style="color: #6b7280; font-size: 13px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 25px; margin-bottom: 0;">
                    Este enlace de recuperación es válido por <strong>60 minutos</strong>. Si tienes problemas para hacer clic en el botón, copia y pega la siguiente dirección en tu navegador:
                </p>
                <p style="color: #FF2121; font-size: 12px; word-break: break-all; margin-top: 10px; margin-bottom: 0;">
                    <a href="{{ $url }}" style="color: #FF2121; text-decoration: underline;">{{ $url }}</a>
                </p>
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td style="padding: 30px 40px; background-color: #0a0a0a; text-align: center; border-top: 1px solid rgba(255,255,255,0.05);">
                <p style="color: #4b5563; font-size: 12px; margin: 0;">
                    Este es un correo automático, por favor no respondas a esta dirección.
                </p>
                <p style="color: #4b5563; font-size: 12px; margin-top: 5px; margin-bottom: 0;">
                    © 2026 CaletaWP. Temas y Plugins GPL con actualizaciones y soporte.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
