<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rank;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        // Load all settings for the unified page
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        // Auto-seed Ranks if empty
        if (Rank::count() === 0) {
            $defaultRanks = [
                ['name' => 'Bronce', 'min_points' => 0, 'discount_percentage' => 0, 'icon' => 'fas fa-shield-alt', 'color' => '#fb923c'],
                ['name' => 'Plata', 'min_points' => 500, 'discount_percentage' => 5.00, 'icon' => 'fas fa-shield-alt', 'color' => '#9ca3af'],
                ['name' => 'Oro', 'min_points' => 1000, 'discount_percentage' => 10.00, 'icon' => 'fas fa-crown', 'color' => '#fbbf24'],
                ['name' => 'Diamante', 'min_points' => 2500, 'discount_percentage' => 15.00, 'icon' => 'fas fa-gem', 'color' => '#22d3ee'],
            ];
            foreach ($defaultRanks as $rank) {
                Rank::create($rank);
            }
        }

        $ranks = Rank::orderBy('min_points', 'asc')->get();
        
        // Set defaults for missing values
        $defaults = [
            'hero_title' => "Themes & Plugins\n[G]Premium WP[/G]",
            'hero_description' => 'Impulsa tus proyectos con los mejores recursos digitales.',
            'hero_title_size' => 'text-8xl',
            'sidebar_title' => 'Top Popular',
            'sidebar_type' => 'popular',
            'sidebar_limit' => 5,
            'topbar_enabled' => 1,
            'topbar_message' => '🎉 Oferta especial: 50% de descuento en todos los planes anuales',
            'topbar_link' => '',
            'points_enabled' => 0,
            'points_per_currency' => 1,
            'points_conversion_rate' => 100,
            'plugin_enabled' => 0,
            'plugin_site_limit' => 5,
            'plugin_show_menu' => 0,
            'products_grid_columns' => 6,
            'products_per_page' => 24,
            'products_section_title' => 'Lo más Vendido',
            'home_products_style' => 'grid',
            'home_products_count' => 6,
            'home_grid_columns' => 4,
            'home_featured_title' => 'Lo más Vendido',
            'home_featured_description' => 'Explora nuestras últimas novedades premium para WordPress.',
        ];
        
        $settings = array_merge($defaults, $settings);
        
        return view('admin.settings.index', compact('settings', 'ranks'));
    }

    public function hero()
    {
        $settings = Setting::whereIn('key', [
            'hero_title',
            'hero_description',
            'hero_title_size',
            'hero_style'
        ])->pluck('value', 'key');

        return view('admin.settings.hero', compact('settings'));
    }

    public function updateHero(Request $request)
    {
        $data = $request->validate([
            'hero_title' => 'required|string',
            'hero_description' => 'required|string',
            'hero_title_size' => 'required|string',
            'hero_style' => 'required|in:circles,aurora,stark,cyber,split',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        
        // Limpiar caché para reflejar cambios inmediatos
        \Illuminate\Support\Facades\Cache::flush();

        return back()->with('success', 'Configuración de Hero actualizada correctamente');
    }

    public function sidebar()
    {
        $settings = Setting::whereIn('key', [
            'sidebar_title',
            'sidebar_type', // 'popular', 'best_seller', 'top_rated', 'most_viewed', 'recent'
            'sidebar_limit'
        ])->pluck('value', 'key');

        // Defaults
        if (!isset($settings['sidebar_title'])) $settings['sidebar_title'] = 'Top Popular';
        if (!isset($settings['sidebar_type'])) $settings['sidebar_type'] = 'popular';
        if (!isset($settings['sidebar_limit'])) $settings['sidebar_limit'] = 5;

        return view('admin.settings.sidebar', compact('settings'));
    }

    public function updateSidebar(Request $request)
    {
        $data = $request->validate([
            'sidebar_title' => 'required|string|max:50',
            'sidebar_type' => 'required|string|in:popular,best_seller,top_rated,most_viewed,recent',
            'sidebar_limit' => 'required|integer|min:1|max:10',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Configuración de Sidebar actualizada correctamente');
    }

    public function topbar()
    {
        $settings = Setting::whereIn('key', [
            'topbar_enabled',
            'topbar_text',
            'topbar_link',
            'topbar_link_text',
            'topbar_bg_color',
        ])->pluck('value', 'key');

        return view('admin.settings.topbar', compact('settings'));
    }

    public function updateTopbar(Request $request)
    {
        $data = $request->validate([
            'topbar_text' => 'required|string|max:255',
            'topbar_link' => 'nullable|string|max:255',
            // 'topbar_link_text' and 'topbar_bg_color' are removed from validation as they are not in the new form
        ]);

        // Use Laravel's built-in boolean converter which handles 'on', '1', true, etc.
        // If the checkbox is unchecked, this returns false.
        $isEnabled = $request->boolean('topbar_enabled');
        $valueToStore = $isEnabled ? '1' : '0';

        // Update enable status
        Setting::updateOrCreate(
            ['key' => 'topbar_enabled'],
            ['value' => $valueToStore]
        );

        // Update other fields
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        // Clear view and app cache to ensure frontend updates immediately
        \Illuminate\Support\Facades\Cache::flush();

        $statusMsg = $isEnabled ? 'ACTIVADO' : 'DESACTIVADO';
        return back()->with('success', "Configuración guardada. El Top Bar está: $statusMsg");
    }

    public function points()
    {
        $settings = Setting::whereIn('key', [
            'points_enabled',
            'points_per_currency',
            'points_conversion_rate'
        ])->pluck('value', 'key');

        return view('admin.settings.points', compact('settings'));
    }

    public function updatePoints(Request $request)
    {
        $data = $request->validate([
            'points_per_currency' => 'required|integer|min:0',
            'points_conversion_rate' => 'required|integer|min:1',
        ]);

        $data['points_enabled'] = $request->has('points_enabled') ? 1 : 0;

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Configuración de puntos actualizada correctamente');
    }

    public function plugin()
    {
        $settings = Setting::whereIn('key', [
            'plugin_enabled',
            'plugin_site_limit',
            'plugin_show_menu'
        ])->pluck('value', 'key');

        // Defaults
        if (!isset($settings['plugin_enabled'])) $settings['plugin_enabled'] = 0;
        if (!isset($settings['plugin_site_limit'])) $settings['plugin_site_limit'] = 5;
        if (!isset($settings['plugin_show_menu'])) $settings['plugin_show_menu'] = 0;

        return view('admin.settings.plugin', compact('settings'));
    }

    public function updatePlugin(Request $request)
    {
        $data = $request->validate([
            'plugin_site_limit' => 'required|integer|min:1|max:100',
        ]);

        $data['plugin_enabled'] = $request->has('plugin_enabled') ? 1 : 0;
        $data['plugin_show_menu'] = $request->has('plugin_show_menu') ? 1 : 0;

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Configuración del Plugin actualizada correctamente');
    }

    public function products()
    {
        $settings = Setting::whereIn('key', [
            'products_grid_columns',
            'products_per_page',
            'products_section_title',
            'home_products_style',
            'home_products_count',
            'home_grid_columns',
            'home_featured_title',
            'home_featured_description'
        ])->pluck('value', 'key');

        // Defaults
        if (!isset($settings['products_grid_columns'])) $settings['products_grid_columns'] = 6;
        if (!isset($settings['products_per_page'])) $settings['products_per_page'] = 24;
        if (!isset($settings['products_section_title'])) $settings['products_section_title'] = 'Lo más Vendido';
        if (!isset($settings['home_products_style'])) $settings['home_products_style'] = 'grid';
        if (!isset($settings['home_products_count'])) $settings['home_products_count'] = 6;
        if (!isset($settings['home_grid_columns'])) $settings['home_grid_columns'] = 4;
        if (!isset($settings['home_featured_title'])) $settings['home_featured_title'] = 'Lo más Vendido';
        if (!isset($settings['home_featured_description'])) $settings['home_featured_description'] = 'Explora nuestras últimas novedades premium para WordPress.';

        return view('admin.settings.products', compact('settings'));
    }

    public function updateProducts(Request $request)
    {
        $data = $request->validate([
            'products_grid_columns' => 'required|integer|min:3|max:6',
            'products_per_page' => 'required|integer|min:6|max:100',
            'products_section_title' => 'required|string|max:100',
            'home_products_style' => 'required|in:grid,list,bento,bauhaus,minimalist,two_columns',
            'home_products_count' => 'required|integer|min:1|max:100',
            'home_grid_columns' => 'required|integer|min:3|max:6',
            'home_featured_title' => 'nullable|string|max:150',
            'home_featured_description' => 'nullable|string|max:255',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Configuración de Productos actualizada correctamente');
    }

    public function updateStorage(Request $request)
    {
        $data = $request->validate([
            'storage_driver' => 'required|in:public,bunnycdn,r2', // public = local
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Configuración de Almacenamiento actualizada correctamente');
    }

    public function general()
    {
        return redirect()->route('settings.index', ['tab' => 'general']);
    }

    public function updateGeneral(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string|max:100',
            'site_identity_type' => 'required|in:logo,text',
            'site_icon' => 'nullable|string|max:50',
            'site_font' => 'nullable|string|max:50',
            'site_logo' => 'nullable|image|mimes:png,svg,jpg,jpeg,webp|max:10240',
            'site_favicon' => 'nullable|image|mimes:png,ico,svg,webp|max:5120',
            'home_meta_title' => 'nullable|string|max:100',
            'home_meta_description' => 'nullable|string|max:255',
            'home_meta_keywords' => 'nullable|string|max:255',
            'product_seo_title_template' => 'nullable|string|max:255',
            'product_seo_desc_template' => 'nullable|string|max:255',
            'site_header_code' => 'nullable|string',
            'site_og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // Asegurar que exista la carpeta public/ui
        if (!file_exists(public_path('ui'))) {
            mkdir(public_path('ui'), 0755, true);
        }

        $fileKeys = ['site_logo', 'site_favicon', 'site_og_image'];
        
        foreach ($fileKeys as $key) {
            if ($request->hasFile($key)) {
                // Borrar archivo viejo si existe físicamente
                $oldFile = Setting::where('key', $key)->value('value');
                if ($oldFile && file_exists(public_path($oldFile)) && is_file(public_path($oldFile))) {
                    unlink(public_path($oldFile));
                }

                // Subir nuevo archivo directamente a public/ui
                $file = $request->file($key);
                $filename = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('ui'), $filename);
                
                // Guardar ruta relativa (ej: ui/12345_site_logo.png)
                $data[$key] = 'ui/' . $filename;
            } else {
                unset($data[$key]);
            }
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        \Illuminate\Support\Facades\Cache::forget('global_settings');

        return back()->with('success', 'Configuración General e Identidad actualizadas correctamente');
    }

    public function removeImage(Request $request)
    {
        $key = $request->input('key');
        
        if (!in_array($key, ['site_logo', 'site_favicon', 'site_og_image'])) {
            return back()->with('error', 'No puedes eliminar este campo.');
        }

        $oldFile = Setting::where('key', $key)->value('value');
        
        if ($oldFile) {
            // Borrar archivo físico usando path público directo
            if (file_exists(public_path($oldFile)) && is_file(public_path($oldFile))) {
                unlink(public_path($oldFile));
            }
            Setting::updateOrCreate(['key' => $key], ['value' => '']);
        }

        \Illuminate\Support\Facades\Cache::forget('global_settings');
        return back()->with('success', 'Imagen eliminada correctamente.');
    }

    public function updateGamification(Request $request)
    {
        $data = $request->validate([
            'rewards' => 'required|array',
            'rewards.*' => 'required|numeric|min:0',
        ]);

        $config = [
            'active' => $request->has('active'),
            'rewards' => array_map('intval', $data['rewards']) // Ensure integers
        ];

        Setting::updateOrCreate(
            ['key' => 'gamification_rewards'],
            ['value' => json_encode($config)]
        );

        return back()->with('success', 'Matriz de Gamificación actualizada correctamente');
    }

    public function payments()
    {
        $settings = Setting::where('key', 'like', 'manual_payment_%')
            ->orWhere('key', 'like', 'paypal_%')
            ->orWhere('key', 'like', 'coinpal_%')
            ->pluck('value', 'key');

        return view('admin.settings.payments', compact('settings'));
    }

    public function updatePayments(Request $request)
    {
        // Validate Manual Payments
        $data = $request->validate([
            'manual_payment_bank' => 'nullable|string',
            'manual_payment_binance' => 'nullable|string',
            'manual_payment_paypal' => 'nullable|string',
            'manual_payment_instructions' => 'nullable|string',
            
            'paypal_client_id' => 'nullable|string',
            'paypal_secret' => 'nullable|string',
            'paypal_mode' => 'nullable|in:sandbox,live',
            
            'coinpal_merchant_no' => 'nullable|string',
            'coinpal_api_key' => 'nullable|string',
            'coinpal_mode' => 'nullable|in:sandbox,live',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        return back()->with('success', 'Configuración de Pagos actualizada correctamente');
    }

    public function updateRanks(Request $request)
    {
        $data = $request->validate([
            'ranks' => 'required|array',
            'ranks.*.id' => 'required|exists:ranks,id',
            'ranks.*.name' => 'required|string|max:50',
            'ranks.*.min_points' => 'required|integer|min:0',
            'ranks.*.discount_percentage' => 'required|numeric|min:0|max:100',
            'ranks.*.color' => 'nullable|string|max:7',
        ]);

        foreach ($data['ranks'] as $rankData) {
            $rank = Rank::find($rankData['id']);
            $rank->update([
                'name' => $rankData['name'],
                'min_points' => $rankData['min_points'],
                'discount_percentage' => $rankData['discount_percentage'],
                'color' => $rankData['color'] ?? $rank->color,
            ]);
        }

        return back()->with('success', 'Niveles de Membresía actualizados correctamente');
    }
}