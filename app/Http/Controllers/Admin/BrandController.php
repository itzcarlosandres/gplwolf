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
     * Display a listing of brands & promo ads.
     */
    public function index()
    {
        $brands = Brand::orderBy('sort_order', 'asc')->orderBy('created_at', 'asc')->get();
        
        $brandsEnabled = Setting::where('key', 'home_brands_enabled')->value('value');
        $brandsEnabled = ($brandsEnabled === null || $brandsEnabled === '1' || $brandsEnabled === 'true' || $brandsEnabled === true);
        
        $brandsTitle = Setting::where('key', 'home_brands_title')->value('value') ?: 'Marcas de Confianza';

        return view('admin.brands.index', compact('brands', 'brandsEnabled', 'brandsTitle'));
    }

    /**
     * Show the form for creating a new brand/promo.
     */
    public function create()
    {
        return view('admin.brands.create');
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
        $validated['sort_order'] = $validated['sort_order'] ?? (Brand::max('sort_order') + 1);
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
     * Reorder brands via Drag & Drop (SortableJS).
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
            'message' => 'Orden de marcas y anuncios actualizado correctamente.',
        ]);
    }

    /**
     * Update global section settings (enable/disable, title).
     */
    public function updateSettings(Request $request)
    {
        $enabled = $request->boolean('home_brands_enabled');
        $title = $request->input('home_brands_title', 'Marcas de Confianza');

        Setting::updateOrCreate(['key' => 'home_brands_enabled'], ['value' => $enabled ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'home_brands_title'], ['value' => $title]);

        return response()->json([
            'success' => true,
            'enabled' => $enabled,
            'title' => $title,
            'message' => $enabled ? 'Sección de Marcas & Anuncios activada en la Home.' : 'Sección de Marcas & Anuncios desactivada en la Home.',
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
