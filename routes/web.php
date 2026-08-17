<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontendProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MembershipPlanController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');

Route::get('/category/{category:slug}', [FrontendProductController::class, 'category'])->name('categories.show');
Route::get('/product/{product:slug}', [FrontendProductController::class, 'show'])->name('products.show');
Route::get('/updates', [\App\Http\Controllers\UpdatesController::class, 'index'])->name('updates.index');

    // Blog Routes

Route::get('/blog', [\App\Http\Controllers\PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\PostController::class, 'show'])->name('blog.show');



// Search Routes
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('/api/search', [\App\Http\Controllers\SearchController::class, 'liveSearch'])->name('search.live');

// API Routes for Plugins
Route::post('/api/v1/activate', [\App\Http\Controllers\Api\LicenseController::class, 'activate'])->name('api.license.activate');
Route::post('/api/v1/check-update', [\App\Http\Controllers\Api\LicenseController::class, 'checkUpdate'])->name('api.license.check-update');
Route::get('/api/v1/download', [\App\Http\Controllers\Api\LicenseController::class, 'download'])->name('api.license.download');

// Sitemap - Ruta principal y alias por seguridad
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.alias');

// Hero Designs Live Showcase Demo
Route::get('/hero-demos', function() {
    $settings = \App\Models\Setting::pluck('value', 'key');
    $brands = \App\Models\Brand::where('is_active', true)->orderBy('sort_order', 'asc')->get();
    $productsCount = \App\Models\Product::count();
    $usersCount = \App\Models\User::count();
    $activeHero = request('hero', 'circles');
    return view('demos.hero-designs', compact('settings', 'brands', 'productsCount', 'usersCount', 'activeHero'));
})->name('hero.demos');

// Static Info Pages
Route::get('/membresias', [\App\Http\Controllers\MembershipController::class, 'pricing'])->name('membership.pricing');
Route::get('/licencias', [FrontendProductController::class, 'licenses'])->name('products.licenses');
Route::view('/plugin-oficial', 'pages.plugin-info')->name('pages.plugin');
Route::get('/plugin-oficial/descargar', [\App\Http\Controllers\HomeController::class, 'downloadPlugin'])->name('pages.plugin.download');
Route::view('/terminos', 'pages.terms')->name('pages.terms');
Route::view('/reembolso', 'pages.refund')->name('pages.refund');
Route::view('/ayuda', 'pages.help')->name('pages.help');
Route::view('/programa-recompensas', 'pages.rewards-program')->name('pages.rewards');

// Newsletter subscription
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');








// Cart Routes
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/membership/{plan}', [\App\Http\Controllers\MembershipController::class, 'addToCart'])->name('membership.add');
Route::delete('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [\App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
Route::post('/cart/coupon/remove', [\App\Http\Controllers\CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');

Route::middleware('auth')->group(function () {
    Route::post('/cart/points', [\App\Http\Controllers\CheckoutController::class, 'applyPoints'])->name('checkout.apply-points');
    Route::post('/cart/points/remove', [\App\Http\Controllers\CheckoutController::class, 'removePoints'])->name('checkout.remove-points');
});

// Checkout Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});

// Download Routes
Route::middleware('auth')->group(function () {
    Route::get('/download/{product:slug}', [\App\Http\Controllers\DownloadController::class, 'download'])->name('product.download');
    Route::get('/download-version/{version}', [\App\Http\Controllers\DownloadController::class, 'downloadVersion'])->name('version.download');
    Route::post('/products/{product}/request-update', [\App\Http\Controllers\UpdateRequestController::class, 'store'])->name('product.request-update');
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-downloads', [UserDashboardController::class, 'downloads'])->name('user.downloads');
    Route::get('/my-orders', [UserDashboardController::class, 'orders'])->name('user.orders');
    Route::get('/my-orders/{order}', [UserDashboardController::class, 'showOrder'])->name('user.orders.show');
    Route::post('/my-orders/{order}/upload-proof', [UserDashboardController::class, 'uploadProof'])->name('user.orders.upload-proof');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Support Tickets
    Route::get('/support', [SupportController::class, 'index'])->name('user.support.index');
    Route::get('/support/create', [SupportController::class, 'create'])->name('user.support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('user.support.store');
    Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('user.support.show');
    Route::post('/support/{ticket}/reply', [SupportController::class, 'reply'])->name('user.support.reply');

    // Connected Sites (Domain Locking)
    Route::resource('connected-sites', \App\Http\Controllers\User\ConnectedSiteController::class)
        ->only(['index', 'store', 'destroy'])
        ->names('user.sites');

    // Gamification Routes
    Route::get('/my-rewards', [UserDashboardController::class, 'rewards'])->name('user.rewards');
    Route::post('/my-rewards/claim', [UserDashboardController::class, 'claimReward'])->name('user.rewards.claim');
    
    // Profile Routes
    Route::get('/my-profile', [\App\Http\Controllers\User\ProfileController::class, 'myProfile'])->name('user.profile');
});

// Public Profile (accessible without auth)
Route::get('/user/{id}', [\App\Http\Controllers\User\ProfileController::class, 'show'])->name('user.public.profile');

/*
|--------------------------------------------------------------------------
| Admin Dashboard (Protected by Auth & Admin Role)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products Management
    Route::get('products/check-duplicate', [ProductController::class, 'checkDuplicate'])->name('products.check-duplicate');
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-best-seller', [ProductController::class, 'toggleBestSeller'])->name('products.toggle-best-seller');
    Route::post('products/{product}/toggle-popular', [ProductController::class, 'togglePopular'])->name('products.toggle-popular');
    Route::post('products/{product}/versions', [ProductController::class, 'addVersion'])->name('products.versions.store');
    Route::post('products/upload-chunk', [ProductController::class, 'uploadChunk'])->name('products.upload.chunk');
    
    // Bulk Sales
    Route::get('/bulk-sale', [App\Http\Controllers\Admin\BulkSaleController::class, 'index'])->name('bulk-sale.index');
    Route::post('/bulk-sale/apply', [App\Http\Controllers\Admin\BulkSaleController::class, 'apply'])->name('bulk-sale.apply');

    // Update Requests
    Route::get('/update-requests', [App\Http\Controllers\Admin\UpdateRequestController::class, 'index'])->name('update-requests.index');
    Route::post('/update-requests/{updateRequest}/complete', [App\Http\Controllers\Admin\UpdateRequestController::class, 'complete'])->name('update-requests.complete');
    Route::delete('/update-requests/{updateRequest}', [App\Http\Controllers\Admin\UpdateRequestController::class, 'destroy'])->name('update-requests.destroy');
    
    // Categories Management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('brands', BrandController::class);
    
    // Membership Plans Management
    Route::resource('membership-plans', MembershipPlanController::class);
    
    // Orders Management
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Users Management
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    Route::post('users/{user}/points', [UserController::class, 'updatePoints'])->name('users.update-points');

    // Coupons Management
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

    // Blog Management
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    
    // AI Content Generation
    Route::post('posts/ai/generate', [\App\Http\Controllers\Admin\AIContentController::class, 'generatePost'])->name('posts.ai.generate');
    Route::post('posts/ai/seo', [\App\Http\Controllers\Admin\AIContentController::class, 'improveSEO'])->name('posts.ai.seo');

    // User Memberships Management
    Route::resource('memberships', \App\Http\Controllers\Admin\MembershipController::class);
    Route::post('memberships/{membership}/extend', [\App\Http\Controllers\Admin\MembershipController::class, 'extend'])->name('memberships.extend');
    Route::post('memberships/{membership}/toggle-status', [\App\Http\Controllers\Admin\MembershipController::class, 'toggleStatus'])->name('memberships.toggle-status');

    // Newsletter Management
    Route::get('newsletter', [\App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('newsletter.index');
    Route::post('newsletter/{subscriber}/toggle', [\App\Http\Controllers\Admin\NewsletterController::class, 'toggleStatus'])->name('newsletter.toggle');
    Route::delete('newsletter/{subscriber}', [\App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('newsletter/create-mail', [\App\Http\Controllers\Admin\NewsletterController::class, 'createMail'])->name('newsletter.create-mail');
    Route::post('newsletter/send-mail', [\App\Http\Controllers\Admin\NewsletterController::class, 'sendMail'])->name('newsletter.send-mail');

    // Settings - Unified Page
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    
    // Settings - Individual Pages (Legacy, still accessible)
    Route::get('settings/hero', [SettingController::class, 'hero'])->name('settings.hero');
    Route::post('settings/hero', [SettingController::class, 'updateHero'])->name('settings.hero.update');
    
    // Sidebar Settings
    Route::get('/settings/sidebar', [SettingController::class, 'sidebar'])->name('settings.sidebar');
    Route::post('/settings/sidebar', [SettingController::class, 'updateSidebar'])->name('settings.sidebar.update');

    // Payments Settings
    Route::get('/settings/payments', [SettingController::class, 'payments'])->name('settings.payments');
    Route::post('/settings/payments', [SettingController::class, 'updatePayments'])->name('settings.payments.update');

    // Top Bar Settings
    Route::get('/settings/topbar', [SettingController::class, 'topbar'])->name('settings.topbar');
    Route::post('/settings/topbar', [SettingController::class, 'updateTopbar'])->name('settings.topbar.update');
    
    // Points Settings
    Route::get('/settings/points', [SettingController::class, 'points'])->name('settings.points');
    Route::post('/settings/points', [SettingController::class, 'updatePoints'])->name('settings.points.update');
    
    // Plugin Settings
    Route::get('/settings/plugin', [SettingController::class, 'plugin'])->name('settings.plugin');
    Route::post('/settings/plugin', [SettingController::class, 'updatePlugin'])->name('settings.plugin.update');
    
    // Products Settings
    Route::get('/settings/products', [SettingController::class, 'products'])->name('settings.products');
    Route::post('/settings/products', [SettingController::class, 'updateProducts'])->name('settings.products.update');

    // Storage Settings
    Route::post('/settings/storage', [SettingController::class, 'updateStorage'])->name('settings.storage.update');

    // General Settings (Logo, SEO)
    Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::post('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.update-general');
    Route::post('/settings/remove-image', [SettingController::class, 'removeImage'])->name('settings.remove-image');

    // Gamification Settings
    Route::post('/settings/gamification', [SettingController::class, 'updateGamification'])->name('settings.gamification.update');
    Route::post('/settings/ranks', [SettingController::class, 'updateRanks'])->name('settings.ranks.update');
    
    // AI Content Generation (with rate limiting)
    Route::post('/ai/generate-seo-content', [\App\Http\Controllers\Admin\AiContentController::class, 'generateSeoContent'])
        ->middleware('throttle:20,1')
        ->name('ai.generate.seo');

    // Email Previews & Testing
    Route::get('/emails/preview', [\App\Http\Controllers\Admin\EmailPreviewController::class, 'index'])->name('emails.preview.index');
    Route::get('/emails/preview/{type}', [\App\Http\Controllers\Admin\EmailPreviewController::class, 'show'])->name('emails.preview.show');
    Route::post('/emails/send/{type}', [\App\Http\Controllers\Admin\EmailPreviewController::class, 'send'])->name('emails.send');
    // Link to our new Update Manager
    Route::get('/updates/manager', [\App\Http\Controllers\Admin\UpdateManagerController::class, 'index'])->name('updates.manager');
    Route::get('/api/products/search', [\App\Http\Controllers\Admin\UpdateManagerController::class, 'search'])->name('api.products.search');
    Route::post('/updates/manager/store', [\App\Http\Controllers\Admin\UpdateManagerController::class, 'store'])->name('updates.manager.store');
    // Fallback for manual access to store URL
    Route::get('/updates/manager/store', function() { return redirect()->route('admin.updates.manager'); });

    // Sites/Domains Management
    Route::resource('sites', \App\Http\Controllers\Admin\ConnectedSiteController::class);
    Route::post('sites/{site}/ban', [\App\Http\Controllers\Admin\ConnectedSiteController::class, 'toggleBan'])->name('sites.ban');
});

// Admin Support Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    // Usamos POST para la respuesta ya que actualiza datos y guarda el historial
    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    Route::patch('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
});
// Payment Gateways Handlers
Route::get('/payment/paypal/success', [\App\Http\Controllers\PaymentController::class, 'paypalSuccess'])->name('paypal.success');
// Demo Routes
Route::get('/demos/update-request', function () {
    return view('demos.update-request');
})->name('demos.update-request');

Route::get('/payment/coinpal/redirect', [\App\Http\Controllers\PaymentController::class, 'coinpalRedirect'])->name('coinpal.redirect');
Route::post('/payment/coinpal/notify', [\App\Http\Controllers\PaymentController::class, 'coinpalNotify'])->name('coinpal.notify');
Route::get('/payment/coinpal/cancel', [\App\Http\Controllers\PaymentController::class, 'coinpalCancel'])->name('coinpal.cancel');


// Route for Email Debugging (Updated)
Route::get('/test-mail', function () {
    $results = [];
    // Force clear cache if parameter exists
    if (request()->has('clear')) {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $results[] = "🧹 Caché limpiada (optimize:clear)";
    }

    $targetEmail = auth()->user() ? auth()->user()->email : 'itzcarlosandres@gmail.com';

    // 1. SMTP Test
    try {
        Illuminate\Support\Facades\Mail::raw('Prueba SMTP OK - ' . now(), function ($message) use ($targetEmail) {
            $message->to($targetEmail)->subject('✅ Test SMTP Exitosa');
        });
        $results[] = "<span style='color:green'>✅ SMTP: Enviado correctamente a $targetEmail</span>";
    } catch (\Exception $e) {
        $results[] = "<span style='color:red'>❌ SMTP Error:</span> " . $e->getMessage();
    }

    // 2. Mailable Test (PurchaseConfirmation)
    try {
        $user = auth()->user() ?? new \App\Models\User(['name' => 'Tester', 'email' => $targetEmail]);
        $order = new \App\Models\Order([
            'id' => rand(1000,9999), 
            'total' => 10.00, 
            'created_at' => now(), 
            'payment_method' => 'test', 
            'order_number' => 'TEST-'.rand(100,999)
        ]);
        $order->setRelation('user', $user);
        $order->setRelation('items', collect([]));

        // USANDO SEND() PARA FORZAR ENVIO SIN COLA
        Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\PurchaseConfirmation($order, 50));
        
        $results[] = "<span style='color:green'>✅ Mailable HTML: Enviado correctamente (Send Force)</span>";
    } catch (\Exception $e) {
        $results[] = "<span style='color:red'>❌ Mailable Error:</span> " . $e->getMessage();
        $results[] = "Tip: Verifica que hayas subido los archivos de la carpeta app/Mail y resources/views/emails";
    }

    return response(implode('<br><hr><br>', $results));
});

// Ruta de diagnóstico para R2
Route::get('/debug-r2', function () {
    $diskName = 'r2';
    $results = ["--- DEPURADOR DE CONEXIÓN CLOUDFLARE R2 ---"];
    
    try {
        $results[] = "1. Verificando configuración...";
        $config = config("filesystems.disks.$diskName");
        $results[] = "   - Disco por defecto: " . config('filesystems.default');
        
        $results[] = "\n2. Límites de PHP y Servidor:";
        $results[] = "   - upload_max_filesize: " . ini_get('upload_max_filesize');
        $results[] = "   - post_max_size: " . ini_get('post_max_size');
        $results[] = "   - memory_limit: " . ini_get('memory_limit');
        $results[] = "   - Dominio App: " . config('app.url');

        $results[] = "\n--- INSPECCIÓN DE ARCHIVO (Admin/ProductController.php) ---";
        $filePath = app_path('Http/Controllers/Admin/ProductController.php');
        if (file_exists($filePath)) {
            $lines = file($filePath);
            $results[] = "Mostrando líneas 10-15 (Importaciones críticas):";
            for($i=9; $i < min(15, count($lines)); $i++) {
                $results[] = ($i+1) . ": " . rtrim($lines[$i]);
            }
            
            // Verificar si tiene las importaciones necesarias
            $fileContent = file_get_contents($filePath);
            $hasStorage = strpos($fileContent, 'use Illuminate\Support\Facades\Storage') !== false;
            $hasLog = strpos($fileContent, 'use Illuminate\Support\Facades\Log') !== false;
            
            $results[] = "\n📋 Verificación de Importaciones:";
            $results[] = ($hasStorage ? "✅" : "❌") . " Storage facade";
            $results[] = ($hasLog ? "✅" : "❌") . " Log facade";
            
            if (!$hasStorage || !$hasLog) {
                $results[] = "\n⚠️ PROBLEMA DETECTADO: Faltan importaciones necesarias para R2";
                $results[] = "El archivo debe tener estas líneas después de 'use App\Services\ImageService;':";
                $results[] = "use Illuminate\\Support\\Facades\\Storage;";
                $results[] = "use Illuminate\\Support\\Facades\\Log;";
            }
        } else {
            $results[] = "⚠️ Archivo no encontrado en $filePath";
        }

        $results[] = "\n4. Listando carpeta R2 (products/files):";
        $files = Illuminate\Support\Facades\Storage::disk($diskName)->files('products/files');
        if(empty($files)) {
            $results[] = "   ⚠️ Carpeta vacía.";
        } else {
            foreach(array_slice($files, -10) as $f) {
                $results[] = "   📍 " . $f . " (" . round(Illuminate\Support\Facades\Storage::disk($diskName)->size($f)/1024/1024, 2) . " MB)";
            }
        }

    } catch (\Exception $e) {
        $results[] = "❌ ERROR: " . $e->getMessage();
    }
    
    return response(implode('<br>', $results))->header('Content-Type', 'text/plain');
});

// Ruta de sincronización de archivos R2
Route::get('/sync-r2-paths', function () {
    $results = ["=== SINCRONIZADOR DE RUTAS R2 ===\n"];
    
    try {
        // 1. Obtener todos los archivos reales en R2
        $results[] = "1. Listando archivos en R2...";
        $filesInR2 = Illuminate\Support\Facades\Storage::disk('r2')->files('products/files');
        $results[] = "   ✅ Encontrados: " . count($filesInR2) . " archivos\n";

        // 2. Obtener todos los productos de la base de datos
        $results[] = "2. Obteniendo productos de la base de datos...";
        $products = \App\Models\Product::whereNotNull('product_file')->get();
        $results[] = "   ✅ Encontrados: " . count($products) . " productos\n";

        $results[] = "3. Sincronizando rutas...";
        $fixed = 0;
        $notFound = 0;
        $alreadyOk = 0;

        foreach ($products as $product) {
            $dbPath = $product->product_file;
            
            // Si la ruta en DB ya existe en R2, está bien
            if (in_array($dbPath, $filesInR2)) {
                $results[] = "   ✅ OK: {$product->name}";
                $alreadyOk++;
                continue;
            }

            // Si no existe, buscar por extensión (asumiendo que solo hay un ZIP por producto)
            $extension = pathinfo($dbPath, PATHINFO_EXTENSION);
            
            $matches = array_filter($filesInR2, function($file) use ($extension) {
                return pathinfo($file, PATHINFO_EXTENSION) === $extension;
            });

            if (count($matches) > 0) {
                // Tomar el primer match (o el más reciente)
                $correctPath = reset($matches);
                
                $product->update(['product_file' => $correctPath]);
                
                $results[] = "   🔧 CORREGIDO: {$product->name}";
                $results[] = "      Antes: {$dbPath}";
                $results[] = "      Ahora: {$correctPath}";
                $fixed++;
                
                // Remover del array para no reutilizarlo
                $filesInR2 = array_diff($filesInR2, [$correctPath]);
            } else {
                $results[] = "   ⚠️ NO ENCONTRADO: {$product->name} -> {$dbPath}";
                $notFound++;
            }
        }

        $results[] = "\n=== RESUMEN ===";
        $results[] = "✅ Productos correctos: {$alreadyOk}";
        $results[] = "🔧 Productos corregidos: {$fixed}";
        $results[] = "⚠️ Productos sin archivo: {$notFound}";

        if ($notFound > 0) {
            $results[] = "\n💡 Los productos sin archivo deben ser re-subidos desde el panel de administración.";
        }

    } catch (\Exception $e) {
        $results[] = "\n❌ ERROR: " . $e->getMessage();
    }

    $results[] = "\n=== FIN ===";
    
    return response(implode('<br>', $results))->header('Content-Type', 'text/plain');
});



// Clear all Laravel caches
Route::get('/clear-cache', function() {
    try {
        Artisan::call('view:clear');
        $view = '✅ View cache cleared';
        
        Artisan::call('cache:clear');
        $cache = '✅ Application cache cleared';
        
        Artisan::call('config:clear');
        $config = '✅ Config cache cleared';
        
        Artisan::call('route:clear');
        $route = '✅ Route cache cleared';
        
        // Delete Blade compiled files
        $viewPath = storage_path('framework/views');
        $count = 0;
        if (is_dir($viewPath)) {
            $files = glob($viewPath.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $count++;
                }
            }
        }
        $blade = "✅ Deleted $count Blade compiled files";
        
        return response("
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cache Cleared - GPLWolf</title>
                <style>
                    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #0a0e27; color: #fff; }
                    h1 { color: #FF2121; }
                    .success { color: #34d399; margin: 10px 0; font-size: 16px; }
                    .links { margin-top: 30px; }
                    a { color: #FF2121; text-decoration: none; margin-right: 20px; padding: 10px 20px; background: #1e293b; border-radius: 8px; display: inline-block; }
                    a:hover { background: #334155; }
                </style>
            </head>
            <body>
                <h1>🔧 Caché de Laravel Limpiada</h1>
                <p class='success'>$view</p>
                <p class='success'>$cache</p>
                <p class='success'>$config</p>
                <p class='success'>$route</p>
                <p class='success'>$blade</p>
                <h2 style='color: #34d399; margin-top: 30px;'>🎉 ¡Todo listo!</h2>
                <div class='links'>
                    <a href='/'>← Ir al inicio</a>
                    <a href='/admin/products'>Ver productos admin</a>
                </div>
            </body>
            </html>
        ");
        
    } catch (Exception $e) {
        return response("❌ Error: " . $e->getMessage(), 500);
    }
});

// Submit sitemap to Google for indexing
Route::get('/submit-to-google', function() {
    try {
        $sitemapUrl = url('/sitemap.xml');
        
        $results = [];
        $results[] = "📤 Notificando a Google sobre el sitemap...\n";
        $results[] = "Sitemap: {$sitemapUrl}\n";
        
        // Ping a Google con el sitemap
        $pingUrl = "https://www.google.com/ping?sitemap=" . urlencode($sitemapUrl);
        
        $ch = curl_init($pingUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode == 200 || $httpCode == 0) {
            $results[] = "✅ Sitemap enviado exitosamente a Google";
            $results[] = "\n📊 Estadísticas del sitemap:";
            
            // Contar productos en el sitemap
            $products = \App\Models\Product::where('is_active', true)
                ->whereNull('deleted_at')
                ->count();
            
            $results[] = "   • Productos activos: {$products}";
            $results[] = "   • Página principal: 1";
            $results[] = "   • Total URLs: " . ($products + 1);
            
            $results[] = "\n🎉 ¡Proceso completado!";
            $results[] = "\n💡 Próximos pasos:";
            $results[] = "   1. Ve a Google Search Console";
            $results[] = "   2. Sección 'Sitemaps'";
            $results[] = "   3. Verifica que {$sitemapUrl} esté listado";
            $results[] = "   4. Google rastreará las URLs en 1-7 días";
            
            $success = true;
        } else {
            $results[] = "⚠️ Respuesta HTTP: {$httpCode}";
            if ($error) {
                $results[] = "❌ Error: {$error}";
            }
            $results[] = "\n💡 Alternativa: Ve manualmente a Google Search Console";
            $results[] = "   y envía el sitemap: {$sitemapUrl}";
            $success = false;
        }
        
        $bgColor = $success ? '#0a0e27' : '#1a0e0e';
        $statusColor = $success ? '#34d399' : '#f87171';
        
        return response("
            <!DOCTYPE html>
            <html>
            <head>
                <title>Sitemap Enviado a Google - GPLWolf</title>
                <style>
                    body { font-family: 'Courier New', monospace; max-width: 900px; margin: 50px auto; padding: 20px; background: {$bgColor}; color: #fff; }
                    h1 { color: #FF2121; }
                    .log { background: #1e293b; padding: 20px; border-radius: 8px; white-space: pre-wrap; line-height: 1.8; border-left: 4px solid {$statusColor}; }
                    .links { margin-top: 30px; }
                    a { color: #FF2121; text-decoration: none; margin-right: 20px; padding: 10px 20px; background: #1e293b; border-radius: 8px; display: inline-block; }
                    a:hover { background: #334155; }
                </style>
            </head>
            <body>
                <h1>🚀 Notificación a Google</h1>
                <div class='log'>" . implode("\n", $results) . "</div>
                <div class='links'>
                    <a href='/'>← Ir al inicio</a>
                    <a href='/sitemap.xml' target='_blank'>📄 Ver Sitemap</a>
                    <a href='https://search.google.com/search-console' target='_blank'>🔍 Search Console</a>
                </div>
            </body>
            </html>
        ");
        
    } catch (\Exception $e) {
        return response("❌ Error: " . $e->getMessage(), 500);
    }
});

require __DIR__.'/auth.php';