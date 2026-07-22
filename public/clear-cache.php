<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Limpiando Caché - CaletaWP</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #0a0e27; color: #fff; }
        h1 { color: #FF2121; }
        .success { color: #34d399; margin: 10px 0; }
        .links { margin-top: 30px; }
        a { color: #FF2121; text-decoration: none; margin-right: 20px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>🔧 Limpiando caché de Laravel...</h1>";

try {
    $kernel->call('view:clear');
    echo "<p class='success'>✅ View cache cleared</p>";

    $kernel->call('cache:clear');
    echo "<p class='success'>✅ Application cache cleared</p>";

    $kernel->call('config:clear');
    echo "<p class='success'>✅ Config cache cleared</p>";

    $kernel->call('route:clear');
    echo "<p class='success'>✅ Route cache cleared</p>";

    // Borrar archivos compilados de Blade manualmente
    $viewPath = __DIR__.'/storage/framework/views';
    if (is_dir($viewPath)) {
        $files = glob($viewPath.'/*');
        $count = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $count++;
            }
        }
        echo "<p class='success'>✅ Deleted $count Blade compiled files</p>";
    }

    echo "<h2 style='color: #34d399; margin-top: 30px;'>🎉 ¡Todo listo! Errores corregidos.</h2>";
    echo "<div class='links'>
            <a href='/'>← Ir al inicio</a>
            <a href='/admin/products'>Ver productos admin</a>
          </div>";

} catch (Exception $e) {
    echo "<p style='color: #f87171;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "</body></html>";