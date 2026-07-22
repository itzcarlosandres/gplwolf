<?php

use Illuminate\Support\Facades\Storage;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain');

echo "--- DEPURADOR DE CONEXIÓN CLOUDFLARE R2 ---\n\n";

$diskName = 'r2'; // Forzamos el disco r2 para la prueba

try {
    echo "1. Verificando configuración del disco '$diskName'...\n";
    $config = config("filesystems.disks.$diskName");
    
    if (!$config) {
        die("ERROR: El disco '$diskName' no está definido en config/filesystems.php\n");
    }

    echo "   - Endpoint: " . ($config['endpoint'] ?? 'No definido') . "\n";
    echo "   - Bucket: " . ($config['bucket'] ?? 'No definido') . "\n";
    echo "   - Region: " . ($config['region'] ?? 'No definido') . "\n";
    
    echo "\n2. Intentando subir un archivo de prueba (test_r2.txt)...\n";
    $timestamp = date('Y-m-d H:i:s');
    $content = "Prueba de conexión R2 generada el: $timestamp";
    $filePath = 'debug/test_r2.txt';

    $result = Storage::disk($diskName)->put($filePath, $content);

    if ($result) {
        echo "   ✅ ¡ÉXITO! Archivo subido correctamente.\n";
    } else {
        echo "   ❌ ERROR: La subida devolvió 'false' sin excepción.\n";
    }

    echo "\n3. Intentando verificar la existencia del archivo...\n";
    if (Storage::disk($diskName)->exists($filePath)) {
        echo "   ✅ ¡ÉXITO! El archivo existe en el bucket.\n";
    } else {
        echo "   ❌ ERROR: El archivo NO aparece como existente (NoSuchKey?).\n";
    }

    echo "\n4. Generando URL de descarga...\n";
    try {
        $url = Storage::disk($diskName)->url($filePath);
        echo "   - URL Pública: $url\n";
        
        $tempUrl = Storage::disk($diskName)->temporaryUrl($filePath, now()->addMinutes(10));
        echo "   - URL Temporal (Signed): $tempUrl\n";
        
        echo "\n   👉 Prueba a abrir la URL Temporal en tu navegador.\n";
    } catch (\Exception $e) {
        echo "   ⚠️ Nota: No se pudo generar URL (posiblemente falta configuración de dominio o visibilidad).\n";
    }

    echo "\n5. Intentando leer el contenido del archivo...\n";
    $readContent = Storage::disk($diskName)->get($filePath);
    echo "   - Contenido leído: '$readContent'\n";

} catch (\Aws\S3\Exception\S3Exception $e) {
    echo "\n❌ ERROR DE AWS/S3 (R2):\n";
    echo "   - Mensaje: " . $e->getAwsErrorMessage() . "\n";
    echo "   - Código de Error: " . $e->getAwsErrorCode() . "\n";
    echo "   - Tipo: " . $e->getAwsErrorType() . "\n";
} catch (\Exception $e) {
    echo "\n❌ ERROR GENERAL:\n";
    echo "   - Mensaje: " . $e->getMessage() . "\n";
    echo "   - Línea: " . $e->getLine() . "\n";
    
    if (strpos($e->getMessage(), 'Class "Aws\S3\S3Client" not found') !== false) {
        echo "\n   ‼️ ATENCIÓN: No tienes instalado el driver de S3.\n";
        echo "   Ejecuta: composer require league/flysystem-aws-s3-v3 \"^3.0\" --ignore-platform-req=php\n";
    }
}

echo "\n--- FIN DE LA PRUEBA ---\n";
