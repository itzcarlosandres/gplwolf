<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Load all settings in one query
        $settings = \App\Models\Setting::pluck('value', 'key');

        // Get home products settings from cached collection
        $homeProductsCount = (int) ($settings['home_products_count'] ?? 6);
        $homeProductsStyle = $settings['home_products_style'] ?? 'grid';
        $homeGridColumns = (int) ($settings['home_grid_columns'] ?? 4);

        $products = \App\Models\Product::with('category')
            ->where('is_active', true)
            ->latest('updated_at')
            ->take($homeProductsCount)
            ->get();

        $bestSellers = \App\Models\Product::with('category')
            ->where('is_active', true)
            ->where('is_best_seller', true)
            ->take(5)
            ->get();

        if ($bestSellers->count() < 5) {
            $existingIds = $bestSellers->pluck('id')->toArray();
            $needed = 5 - $bestSellers->count();
            $extra = \App\Models\Product::with('category')
                ->withCount('orderItems')
                ->where('is_active', true)
                ->whereNotIn('id', $existingIds)
                ->orderBy('order_items_count', 'desc')
                ->orderBy('downloads_count', 'desc')
                ->latest()
                ->take($needed)
                ->get();
            $bestSellers = $bestSellers->concat($extra);
        }

        $popularProducts = \App\Models\Product::with('category')
            ->where('is_active', true)
            ->where('is_popular', true)
            ->take(5)
            ->get();

        if ($popularProducts->count() < 5) {
            $existingIds = $popularProducts->pluck('id')->toArray();
            $needed = 5 - $popularProducts->count();
            $extra = \App\Models\Product::with('category')
                ->where('is_active', true)
                ->whereNotIn('id', $existingIds)
                ->orderBy('rating', 'desc')
                ->latest()
                ->take($needed)
                ->get();
            $popularProducts = $popularProducts->concat($extra);
        }

        // IDs de categorías principales
        $pluginCategoryIds = \App\Models\Category::where(function($q) {
            $q->where('slug', 'plugins')
              ->orWhere('name', 'like', '%plugin%');
        })->pluck('id')->toArray();

        $themeCategoryIds = \App\Models\Category::where(function($q) {
            $q->whereIn('slug', ['temas', 'themes'])
              ->orWhere('name', 'like', '%tema%')
              ->orWhere('name', 'like', '%theme%');
        })->pluck('id')->toArray();

        $templateKitCategoryIds = \App\Models\Category::where(function($q) {
            $q->whereIn('slug', ['template-kits', 'kits-de-plantillas', 'plantillas'])
              ->orWhere('name', 'like', '%kit%')
              ->orWhere('name', 'like', '%template%')
              ->orWhere('name', 'like', '%plantilla%');
        })->whereNotIn('id', array_merge($pluginCategoryIds, $themeCategoryIds))->pluck('id')->toArray();

        $mainCategoryIds = array_unique(array_merge($pluginCategoryIds, $themeCategoryIds, $templateKitCategoryIds));

        // 1. Plugins
        $latestPlugins = \App\Models\Product::with('category')
            ->where('is_active', true)
            ->where(function($q) use ($pluginCategoryIds) {
                $q->whereIn('category_id', $pluginCategoryIds);
                if (empty($pluginCategoryIds)) {
                    $q->orWhere('type', 'plugin');
                }
            })
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 2. Temas
        $latestThemes = \App\Models\Product::with('category')
            ->where('is_active', true)
            ->where(function($q) use ($themeCategoryIds) {
                $q->whereIn('category_id', $themeCategoryIds);
                if (empty($themeCategoryIds)) {
                    $q->orWhere('type', 'theme');
                }
            })
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 3. Kits de Plantillas
        $templateKits = \App\Models\Product::with('category')
            ->where('is_active', true)
            ->whereIn('category_id', $templateKitCategoryIds)
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 4. Otras Categorías (ej. phpscript, traducciones, software, etc.)
        $otherResources = \App\Models\Product::with('category')
            ->where('is_active', true)
            ->whereNotIn('category_id', $mainCategoryIds)
            ->latest('updated_at')
            ->take(5)
            ->get();

        $plans = \App\Models\MembershipPlan::where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();

        $categories = \App\Models\Category::where('is_active', true)
            ->withCount('products')
            ->get();

        $brands = \App\Models\Brand::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $productsCount = \App\Models\Product::count();
        $usersCount = \App\Models\User::count();

        $latestUpdates = \App\Models\ProductVersion::with('product')
            ->latest()
            ->take(3)
            ->get();

        $homeBrandsEnabled = \App\Models\Setting::where('key', 'home_brands_enabled')->value('value');
        $homeBrandsEnabled = ($homeBrandsEnabled === null || $homeBrandsEnabled === '1' || $homeBrandsEnabled === 'true' || $homeBrandsEnabled === true);
        $homeBrandsTitle = \App\Models\Setting::where('key', 'home_brands_title')->value('value') ?: 'Marcas de Confianza';

        return view('home', compact(
            'products', 'bestSellers', 'popularProducts', 'plans', 'categories', 'brands',
            'settings', 'productsCount', 'usersCount',
            'latestUpdates', 'homeProductsStyle', 'homeGridColumns', 'latestPlugins', 'latestThemes',
            'templateKits', 'otherResources', 'homeBrandsEnabled', 'homeBrandsTitle'
        ));
    }

    public function uiLab()
    {
        return view('ui-lab');
    }

    public function downloadPlugin()
    {
        $pluginDir = base_path('wordpress-plugin/marketplace-connect');
        if (!file_exists($pluginDir)) {
            abort(404, 'Directorio del plugin no encontrado.');
        }

        // Create temporary file path
        $tempZip = tempnam(sys_get_temp_dir(), 'mp_plugin_');
        
        $zip = new \ZipArchive();
        if ($zip->open($tempZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'No se pudo crear el archivo temporal ZIP.');
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($pluginDir),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = 'marketplace-connect/' . str_replace('\\', '/', substr($filePath, strlen($pluginDir) + 1));
                
                // If it is the main plugin file, rewrite the API URL dynamically!
                if ($file->getFilename() === 'marketplace-connect.php') {
                    $content = file_get_contents($filePath);
                    
                    // Replace API URL definition with actual production URL
                    $apiUrl = url('/api/v1');
                    $content = preg_replace(
                        "/define\(\s*'MARKETPLACE_API_URL'\s*,\s*'(.*?)'\s*\);/i",
                        "define( 'MARKETPLACE_API_URL', '{$apiUrl}' );",
                        $content
                    );
                    
                    $zip->addFromString($relativePath, $content);
                } else {
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        $zip->close();

        return response()->download($tempZip, 'marketplace-connect.zip')->deleteFileAfterSend(true);
    }
}
