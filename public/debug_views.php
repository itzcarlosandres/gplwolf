<?php
/**
 * DIAGNÓSTICO DE VISTAS LARAVEL
 * Sube esto a la raíz (public_html o similar) y ejecútalo via web.
 */

// Cargar Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Obtener rutas de vistas configuradas
$viewPaths = config('view.paths');
$targetView = 'partials.heroes.aurora';
$expectedPath = 'partials/heroes/aurora.blade.php';

echo "<h1>Diagnóstico de Vistas</h1><hr>";

echo "<h3>1. Rutas donde Laravel busca vistas:</h3>";
echo "<ul>";
foreach ($viewPaths as $path) {
    echo "<li>" . htmlspecialchars($path) . "</li>";
    
    // Verificar si existe el archivo en esta ruta
    $fullPath = rtrim($path, '/') . '/' . $expectedPath;
    echo "<ul>";
    if (file_exists($fullPath)) {
        echo "<li style='color:green'>✅ ARCHIVO ENCONTRADO AQUÍ: $fullPath</li>";
        echo "<li>Permisos: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "</li>";
        echo "<li>Tamaño: " . filesize($fullPath) . " bytes</li>";
        echo "<li>Dueño/Grupo: " . fileowner($fullPath) . "/" . filegroup($fullPath) . "</li>";
        
        // Intentar leer
        if (is_readable($fullPath)) {
            echo "<li style='color:green'>✅ Es legible por PHP</li>";
        } else {
            echo "<li style='color:red'>❌ NO es legible por PHP (Problema de Permisos)</li>";
        }
    } else {
        echo "<li style='color:red'>❌ No existe: $fullPath</li>";
        
        // Verificar directorio padre
        $dir = dirname($fullPath);
        if (is_dir($dir)) {
            echo "<li style='color:blue'>ℹ️ El directorio SÍ existe: $dir</li>";
            echo "<li>Contenido del directorio:</li>";
            $files = scandir($dir);
            echo "<pre>" . print_r($files, true) . "</pre>";
        } else {
            echo "<li style='color:orange'>⚠️ Tampoco existe el directorio: $dir</li>";
        }
    }
    echo "</ul>";
}
echo "</ul>";

echo "<h3>2. Estado del View Finder:</h3>";
try {
    $exists = view()->exists($targetView);
    echo "<p>Laravel dice que la vista '$targetView' " . ($exists ? "<strong style='color:green'>EXISTE ✅</strong>" : "<strong style='color:red'>NO EXISTE ❌</strong>") . "</p>";
} catch (Exception $e) {
    echo "<p style='color:red'>Error al verificar vista: " . $e->getMessage() . "</p>";
}