<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// === SCRIPT MAESTRO DE PRUEBAS DE CORREO - SINGLE FILE ===
// Sube este archivo a la carpeta /public/ de tu servidor

define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Rank;
use App\Models\Ticket;

// 1. Limpiar Caché si se solicita
$msg = "";
if (isset($_GET['clear_cache'])) {
    try {
        Artisan::call('optimize:clear');
        $msg = "<div class='alert success'>✅ Caché limpiada correctamente (optimize:clear)</div>";
    } catch (Exception $e) {
        $msg = "<div class='alert error'>❌ Error limpiando caché: ".$e->getMessage()."</div>";
    }
}

// 2. Procesar Envío
if (isset($_POST['action'])) {
    $targetEmail = $_POST['email'] ?? 'itzcarlosandres@gmail.com';
    $type = $_POST['action'];
    
    try {
        switch ($type) {
            case 'smtp':
                Mail::raw("Prueba SMTP exitosa - ".now(), function($m) use ($targetEmail) {
                    $m->to($targetEmail)->subject("✅ Test SMTP Laravel");
                });
                $msg = "<div class='alert success'>✅ Correo SMTP enviado a $targetEmail</div>";
                break;
                
            case 'purchase':
                // Mock Data
                $user = new User(['name' => 'Usuario Test', 'email' => $targetEmail]);
                $order = new Order([
                    'id' => rand(1000,9999), 
                    'total' => 49.99, 
                    // 'created_at' removed from array to safely assign property below
                    'payment_method' => 'TestScript',
                    'order_number' => 'ORD-TEST-'.rand(100,999)
                ]);
                $order->created_at = \Carbon\Carbon::now(); // Explicit property assignment
                $order->setRelation('user', $user);
                
                // Item
                $product = new \App\Models\Product(['name' => 'Producto Demo', 'slug' => 'demo']);
                $item = new OrderItem(['price' => 49.99, 'quantity' => 1]);
                $item->setRelation('product', $product);
                $order->setRelation('items', collect([$item]));

                Mail::to($targetEmail)->send(new \App\Mail\PurchaseConfirmation($order, 100));
                $msg = "<div class='alert success'>✅ Email de Compra enviado a $targetEmail</div>";
                break;

            case 'membership_activated':
                $user = new User(['name' => 'Usuario Test', 'email' => $targetEmail]);
                $plan = new MembershipPlan(['name' => 'Plan Premium Anual', 'price' => 99.00]);
                $mem = new Membership([
                    'status' => 'active'
                ]);
                // Force Carbon properties assignment
                $mem->started_at = \Carbon\Carbon::now();
                $mem->expires_at = \Carbon\Carbon::now()->addYear();
                $mem->created_at = \Carbon\Carbon::now();
                
                $mem->setRelation('user', $user);
                $mem->setRelation('plan', $plan);
                
                Mail::to($targetEmail)->send(new \App\Mail\MembershipActivated($mem));
                $msg = "<div class='alert success'>✅ Email de Membresía Activada enviado a $targetEmail</div>";
                break;
                
            case 'membership_expiring':
                $user = new User(['name' => 'Usuario Test', 'email' => $targetEmail]);
                $plan = new MembershipPlan(['name' => 'Plan Básico', 'price' => 29.00]);
                $mem = new Membership([
                    'status' => 'active'
                ]);
                $mem->started_at = \Carbon\Carbon::now()->subYear();
                $mem->expires_at = \Carbon\Carbon::now()->addDays(3);
                $mem->setRelation('user', $user);
                $mem->setRelation('plan', $plan);
                
                Mail::to($targetEmail)->send(new \App\Mail\MembershipExpiring($mem));
                $msg = "<div class='alert success'>✅ Email de Expiración enviado a $targetEmail</div>";
                break;
                
            case 'rank_upgrade':
                $user = new User(['name' => 'Usuario Test', 'email' => $targetEmail]);
                $user->points = 1500; // Mock points
                $newRank = new Rank(['name' => 'Diamante', 'color' => '#b9f2ff']);
                $newRank->discount_percentage = 20; // Mock discount
                $oldRank = new Rank(['name' => 'Oro', 'color' => '#ffd700']);
                
                Mail::to($targetEmail)->send(new \App\Mail\RankUpgradeNotification($user, $newRank, $oldRank));
                $msg = "<div class='alert success'>✅ Email de Subida de Rango enviado a $targetEmail</div>";
                break;
        }
    } catch (Exception $e) {
        $msg = "<div class='alert error'>❌ Error enviando correo: ".$e->getMessage()."</div>";
        // Debug View Paths
        if (str_contains($e->getMessage(), 'View [')) {
            $paths = implode(', ', \Illuminate\Support\Facades\Config::get('view.paths'));
            $msg .= "<div class='alert' style='background:#fff'>🔍 Laravel buscó en: <strong>$paths</strong><br>Asegúrate que el archivo esté en una de esas carpetas dentro de <code>/emails/membership_expiring.blade.php</code></div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Pruebas de Correo</title>
    <style>
        body { font-family: sans-serif; padding: 40px; background: #f0f2f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; color: #1f2937; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .success { background: #d1fae5; color: #065f46; border: 1px solid #34d399; }
        .error { background: #fee2e2; color: #991b1b; border: 1px solid #f87171; }
        input[type="email"] { width: 100%; padding: 12px; font-size: 16px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        button { padding: 15px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.2s; color: white; width: 100%; }
        .btn-blue { background: #FF2121; } .btn-blue:hover { background: #F51B1B; }
        .btn-green { background: #10b981; } .btn-green:hover { background: #059669; }
        .btn-purple { background: #FF2121; } .btn-purple:hover { background: #F51B1B; }
        .btn-orange { background: #f59e0b; } .btn-orange:hover { background: #d97706; }
        .btn-gray { background: #6b7280; margin-bottom: 20px; } .btn-gray:hover { background: #4b5563; }
        label { font-weight: bold; display: block; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛠️ Panel Maestro de Correos</h1>
        
        <?= $msg ?>

        <a href="?clear_cache=1">
            <button class="btn-gray">🧹 Forzar Limpieza de Caché (Arreglar error 404)</button>
        </a>

        <!-- DEBUG FILE SYSTEM -->
        <div style="background:#e5e7eb; padding:15px; margin-bottom:20px; border-radius:8px; font-family:monospace; font-size:12px;">
            <strong>🔍 Diagnóstico de Archivos en el Servidor:</strong><br>
            <?php
            $path = base_path('resources/views/emails');
            if (is_dir($path)) {
                echo "Carpeta: $path <span style='color:green'>[EXISTE]</span><br>";
                $files = scandir($path);
                foreach ($files as $f) {
                    if ($f == '.' || $f == '..') continue;
                    echo "- $f (Tamaño: " . filesize("$path/$f") . " bytes) <br>";
                }
            } else {
                echo "Carpeta: $path <span style='color:red'>[NO EXISTE]</span> - La ruta base es: " . base_path() . "<br>";
            }
            ?>
        </div>

        <form method="POST">
            <label>Enviar pruebas a:</label>
            <input type="email" name="email" value="<?= $_POST['email'] ?? 'itzcarlosandres@gmail.com' ?>" required>

            <div class="grid">
                <button type="submit" name="action" value="smtp" class="btn-gray">Test Básico SMTP</button>
                <button type="submit" name="action" value="purchase" class="btn-blue">Confirmación Compra</button>
                <button type="submit" name="action" value="membership_activated" class="btn-green">Membresía Activada</button>
                <button type="submit" name="action" value="membership_expiring" class="btn-orange">Membresía Expirando</button>
                <button type="submit" name="action" value="rank_upgrade" class="btn-purple">Subida Rango</button>
            </div>
        </form>
    </div>
</body>
</html>