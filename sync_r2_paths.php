<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

echo "=== SINCRONIZADOR DE RUTAS R2 ===\n\n";

try {
    // 1. Obtener todos los archivos reales en R2
    echo "1. Listando archivos en R2...\n";
    $filesInR2 = Storage::disk('r2')->files('products/files');
    echo "   ✅ Encontrados: " . count($filesInR2) . " archivos\n\n";

    // 2. Obtener todos los productos de la base de datos
    echo "2. Obteniendo productos de la base de datos...\n";
    $products = DB::table('products')->whereNotNull('product_file')->get();
    echo "   ✅ Encontrados: " . count($products) . " productos\n\n";

    echo "3. Sincronizando rutas...\n";
    $fixed = 0;
    $notFound = 0;

    foreach ($products as $product) {
        $dbPath = $product->product_file;
        
        // Si la ruta en DB ya existe en R2, está bien
        if (in_array($dbPath, $filesInR2)) {
            echo "   ✅ OK: {$product->name} -> {$dbPath}\n";
            continue;
        }

        // Si no existe, buscar por nombre de archivo (sin UUID)
        $originalName = basename($dbPath);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        
        // Buscar archivos con la misma extensión
        $matches = array_filter($filesInR2, function($file) use ($extension) {
            return pathinfo($file, PATHINFO_EXTENSION) === $extension;
        });

        if (count($matches) === 1) {
            // Solo hay un archivo con esa extensión, asumimos que es el correcto
            $correctPath = reset($matches);
            
            DB::table('products')
                ->where('id', $product->id)
                ->update(['product_file' => $correctPath]);
            
            echo "   🔧 CORREGIDO: {$product->name}\n";
            echo "      Antes: {$dbPath}\n";
            echo "      Ahora: {$correctPath}\n\n";
            $fixed++;
        } else {
            echo "   ⚠️ NO ENCONTRADO: {$product->name} -> {$dbPath}\n";
            $notFound++;
        }
    }

    echo "\n=== RESUMEN ===\n";
    echo "✅ Productos correctos: " . (count($products) - $fixed - $notFound) . "\n";
    echo "🔧 Productos corregidos: {$fixed}\n";
    echo "⚠️ Productos sin archivo: {$notFound}\n";

    if ($notFound > 0) {
        echo "\n💡 Los productos sin archivo deben ser re-subidos desde el panel de administración.\n";
    }

} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== FIN ===\n";
