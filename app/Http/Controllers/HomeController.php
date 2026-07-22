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

        return view('home', compact(
            'products', 'bestSellers', 'popularProducts', 'plans', 'categories', 'brands',
            'settings', 'productsCount', 'usersCount',
            'latestUpdates', 'homeProductsStyle', 'homeGridColumns'
        ));
    }

    public function uiLab()
    {
        return view('ui-lab');
    }
}
