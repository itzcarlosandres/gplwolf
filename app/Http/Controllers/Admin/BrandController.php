<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of brands & promo ads separately.
     */
    public function index()
    {
        $brands = Brand::where('is_promo', false)->orderBy('sort_order', 'asc')->orderBy('name', 'asc')->get();
        $promos = Brand::where('is_promo', true)->orderBy('sort_order', 'asc')->orderBy('name', 'asc')->get();
        
        $brandsEnabled = Setting::where('key', 'home_brands_enabled')->value('value');
        $brandsEnabled = ($brandsEnabled === null || $brandsEnabled === '1' || $brandsEnabled === 'true' || $brandsEnabled === true);
        
        $promosEnabled = Setting::where('key', 'home_promos_enabled')->value('value');
        $promosEnabled = ($promosEnabled === null || $promosEnabled === '1' || $promosEnabled === 'true' || $promosEnabled === true);

        $brandsTitle = Setting::where('key', 'home_brands_title')->value('value') ?: 'Marcas de Confianza';
        $promosTitle = Setting::where('key', 'home_promos_title')->value('value') ?: 'Ofertas & Promociones';

        return view('admin.brands.index', compact('brands', 'promos', 'brandsEnabled', 'promosEnabled', 'brandsTitle', 'promosTitle'));
    }

    /**
     * Show the form for creating a new brand/promo.
     */
    public function create(Request $request)
    {
        $defaultType = $request->query('type', 'brand'); // 'brand' or 'promo'
        return view('admin.brands.create', compact('defaultType'));
    }

    /**
     * Store a newly created brand/promo in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'is_promo' => 'nullable|boolean',
            'link_url' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:100',
            'highlight_color' => 'nullable|string|in:amber,red,emerald,blue,purple,white',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $count = Brand::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        $validated['is_promo'] = $request->boolean('is_promo');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? (Brand::where('is_promo', $validated['is_promo'])->max('sort_order') + 1);
        $validated['highlight_color'] = $validated['highlight_color'] ?? 'amber';

        Brand::create($validated);
        
        return redirect()->route('admin.brands.index')
            ->with('success', $validated['is_promo'] ? 'Anuncio / Promoción creado exitosamente.' : 'Marca creada exitosamente.');
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'is_promo' => 'nullable|boolean',
            'link_url' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:100',
            'highlight_color' => 'nullable|string|in:amber,red,emerald,blue,purple,white',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validated['name'] !== $brand->name) {
            $validated['slug'] = Str::slug($validated['name']);
            $count = Brand::where('slug', 'like', $validated['slug'] . '%')
                ->where('id', '!=', $brand->id)
                ->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        $validated['is_promo'] = $request->boolean('is_promo');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $brand->sort_order;
        $validated['highlight_color'] = $validated['highlight_color'] ?? 'amber';

        $brand->update($validated);
        
        return redirect()->route('admin.brands.index')
            ->with('success', $brand->is_promo ? 'Anuncio / Promoción actualizado exitosamente.' : 'Marca actualizada exitosamente.');
    }

    /**
     * Toggle active status via AJAX.
     */
    public function toggleStatus(Brand $brand)
    {
        $brand->is_active = !$brand->is_active;
        $brand->save();

        return response()->json([
            'success' => true,
            'is_active' => $brand->is_active,
            'message' => $brand->is_active ? 'Elemento activado' : 'Elemento pausado/desactivado',
        ]);
    }

    /**
     * Reorder brands or promos via Drag & Drop (SortableJS).
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:brands,id',
        ]);

        foreach ($request->ids as $position => $id) {
            Brand::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizado correctamente.',
        ]);
    }

    /**
     * Update global section settings (enable/disable, title) for brands or promos.
     */
    public function updateSettings(Request $request)
    {
        if ($request->has('home_brands_enabled')) {
            $enabled = $request->boolean('home_brands_enabled');
            Setting::updateOrCreate(['key' => 'home_brands_enabled'], ['value' => $enabled ? '1' : '0']);
        }

        if ($request->has('home_brands_title')) {
            Setting::updateOrCreate(['key' => 'home_brands_title'], ['value' => $request->input('home_brands_title')]);
        }

        if ($request->has('home_promos_enabled')) {
            $enabled = $request->boolean('home_promos_enabled');
            Setting::updateOrCreate(['key' => 'home_promos_enabled'], ['value' => $enabled ? '1' : '0']);
        }

        if ($request->has('home_promos_title')) {
            Setting::updateOrCreate(['key' => 'home_promos_title'], ['value' => $request->input('home_promos_title')]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Configuración de la sección guardada correctamente.',
        ]);
    }

    /**
     * Remove the specified brand from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        
        return redirect()->route('admin.brands.index')
            ->with('success', 'Elemento eliminado exitosamente.');
    }
}
