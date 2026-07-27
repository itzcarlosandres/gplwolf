<?php
// Standalone Laravel Mail Tester Script

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Console\Kernel;

// Boot Laravel Console
$app->make(Kernel::class)->bootstrap();

$toEmail = $argv[1] ?? null;

if (!$toEmail) {
    echo "========================================================\n";
    echo "Laravel SMTP Tester\n";
    echo "========================================================\n";
    echo "Uso: php test_mail.php tu-correo@ejemplo.com\n\n";
    echo "Configuración actual en .env:\n";
    echo "MAIL_MAILER: " . config('mail.default') . "\n";
    echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
    echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
    echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
    echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
    echo "========================================================\n";
    exit(1);
}

echo "Enviando correo de prueba a {$toEmail}...\n";

try {
    Mail::raw('¡Hola! Este es un correo de prueba enviado desde tu servidor de Laravel para verificar la configuración SMTP.', function ($message) use ($toEmail) {
        $message->to($toEmail)
            ->subject('Prueba de Conexión SMTP - Laravel');
    });
    echo "\n¡ÉXITO! El correo de prueba fue enviado correctamente a {$toEmail}.\n";
} catch (\Exception $e) {
    echo "\n¡ERROR al enviar el correo!\n";
    echo "Mensaje de error: " . $e->getMessage() . "\n\n";
    echo "Detalles del error para diagnóstico:\n" . $e->getTraceAsString() . "\n";
}
