<?php
/**
 * SCRIPT PARA LIMPIAR CACHÉ Y CREAR ARCHIVOS DE HEROES
 */

echo "<h1>Limpiando caché y creando archivos...</h1><hr>";

// Paso 1: Limpiar caché de vistas
echo "<h2>Paso 1: Limpiando caché de vistas</h2>";
$cachePath = __DIR__ . '/storage/framework/views';
if (is_dir($cachePath)) {
    $files = glob($cachePath . '/*');
    $deleted = 0;
    foreach ($files as $file) {
        if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            unlink($file);
            $deleted++;
        }
    }
    echo "<p style='color:green;'>✅ Eliminados $deleted archivos de caché</p>";
} else {
    echo "<p style='color:orange;'>⚠️ No se encontró el directorio de caché</p>";
}

// Paso 2: Crear directorio heroes
echo "<h2>Paso 2: Creando directorio heroes</h2>";
$heroesDir = __DIR__ . '/resources/views/partials/heroes';

if (!is_dir($heroesDir)) {
    if (mkdir($heroesDir, 0755, true)) {
        echo "<p style='color:green;'>✅ Directorio creado: $heroesDir</p>";
    } else {
        echo "<p style='color:red;'>❌ ERROR: No se pudo crear el directorio</p>";
        echo "<p>Permisos insuficientes. Contacta a tu hosting.</p>";
        exit;
    }
} else {
    echo "<p style='color:blue;'>ℹ️ El directorio ya existe</p>";
}

// Paso 3: Crear archivos
echo "<h2>Paso 3: Creando archivos blade</h2>";

$aurora = <<<'BLADE'
<div class="relative min-h-[90vh] flex items-center justify-center overflow-hidden border-b border-white/10 bg-[#020617]">
    <div class="absolute inset-0">
        <div class="absolute top-[-10%] left-[20%] w-[500px] h-[500px] bg-[#F51B1B]/20 rounded-full blur-[120px] mix-blend-screen animate-pulse"></div>
    </div>
    <div class="relative w-full max-w-7xl mx-auto px-6 z-10 flex flex-col items-center text-center">
        <h1 class="text-6xl md:text-8xl font-black tracking-tight mb-8 leading-tight text-white">
            Recursos Premium
        </h1>
        <p class="text-xl text-white/70 max-w-2xl mb-12">
            La plataforma definitiva para creadores
        </p>
        <a href="{{ route('products.index') }}" class="px-8 py-4 bg-white text-black font-bold rounded-full">
            Explorar Recursos
        </a>
    </div>
</div>
BLADE;

$cyber = <<<'BLADE'
<div class="relative min-h-[90vh] flex items-center justify-center bg-[#050505]">
    <div class="relative w-full max-w-7xl mx-auto px-6 py-20 text-center">
        <h1 class="text-7xl font-black text-white mb-6">Todo en Uno</h1>
        <p class="text-lg text-gray-400 mb-8">Plugins y temas premium</p>
        <a href="{{ route('products.index') }}" class="bg-white text-black px-8 py-4 rounded-xl font-bold">
            Explorar
        </a>
    </div>
</div>
BLADE;

$stark = <<<'BLADE'
<div class="relative min-h-[85vh] flex items-center justify-center bg-[#09090b]">
    <div class="relative w-full max-w-6xl mx-auto px-6 py-12 text-center">
        <h1 class="text-7xl font-bold text-white mb-6">Crea sin Límites</h1>
        <p class="text-lg text-gray-400 mb-10">Descargas directas y soporte</p>
        <a href="{{ route('products.index') }}" class="px-8 py-3 bg-white text-black font-semibold rounded">
            Explorar
        </a>
    </div>
</div>
BLADE;

$archivos = [
    'aurora.blade.php' => $aurora,
    'cyber.blade.php' => $cyber,
    'stark.blade.php' => $stark
];

$creados = 0;
foreach ($archivos as $nombre => $contenido) {
    $ruta = $heroesDir . '/' . $nombre;
    if (file_put_contents($ruta, $contenido)) {
        echo "<p style='color:green;'>✅ Creado: $nombre (" . filesize($ruta) . " bytes)</p>";
        chmod($ruta, 0644);
        $creados++;
    } else {
        echo "<p style='color:red;'>❌ Error al crear: $nombre</p>";
    }
}

// Paso 4: Verificar archivos
echo "<h2>Paso 4: Verificando archivos creados</h2>";
foreach ($archivos as $nombre => $contenido) {
    $ruta = $heroesDir . '/' . $nombre;
    if (file_exists($ruta)) {
        echo "<p style='color:green;'>✅ Existe: $nombre</p>";
    } else {
        echo "<p style='color:red;'>❌ NO existe: $nombre</p>";
    }
}

echo "<hr>";
if ($creados === 3) {
    echo "<h2 style='color:green;'>🎉 ¡COMPLETADO!</h2>";
    echo "<p><strong>Se crearon los 3 archivos y se limpió la caché.</strong></p>";
    echo "<p><strong>IMPORTANTE:</strong></p>";
    echo "<ol>";
    echo "<li>Elimina este archivo (limpiar_cache_heroes.php)</li>";
    echo "<li>Recarga tu página de inicio</li>";
    echo "</ol>";
    echo "<br><a href='/' style='display:inline-block; padding:12px 24px; background:#10B981; color:white; text-decoration:none; border-radius:8px; font-weight:bold; font-size:16px;'>🏠 Ir al Home</a>";
} else {
    echo "<h2 style='color:red;'>❌ Error</h2>";
    echo "<p>Solo se crearon $creados de 3 archivos.</p>";
}