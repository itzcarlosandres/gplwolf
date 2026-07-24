<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Setting;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Filter by category if present
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search by name/description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Load all relevant settings in one query
        $settings = Setting::whereIn('key', [
            'products_per_page', 'products_grid_columns', 'products_section_title', 'sidebar_title'
        ])->pluck('value', 'key');

        $productsPerPage = (int) ($settings['products_per_page'] ?? 24);
        $gridColumns = (int) ($settings['products_grid_columns'] ?? 6);
        $sectionTitle = $settings['products_section_title'] ?? 'Lo más Vendido';
        $sidebarTitle = $settings['sidebar_title'] ?? 'Top Popular';

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('downloads_count', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }

        $products = $query->paginate($productsPerPage);

        $categories = Category::where('is_active', true)->withCount('products')->get();
        $sidebarProducts = $this->getSidebarProducts();

        return view('products.index', compact('products', 'categories', 'sidebarProducts', 'sidebarTitle', 'gridColumns', 'sectionTitle'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load([
            'category',
            'versions' => function($q) {
                $q->orderBy('released_at', 'desc');
            }
        ]);

        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        if ($relatedProducts->count() < 3) {
            $existing = $relatedProducts->pluck('id')->push($product->id)->toArray();
            $needed = 3 - $relatedProducts->count();
            $extra = Product::where('is_active', true)
                ->whereNotIn('id', $existing)
                ->latest()
                ->take($needed)
                ->get();
            $relatedProducts = $relatedProducts->concat($extra);
        }

        $popularProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->orderBy('downloads_count', 'desc')
            ->take(5)
            ->get();

        $categories = \App\Models\Category::where('is_active', true)->get();
        $globalSettings = \App\Models\Setting::pluck('value', 'key')->toArray();

        $hasRequestedUpdate = false;
        if (auth()->check()) {
            $hasRequestedUpdate = \App\Models\UpdateRequest::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->where('status', 'pending')
                ->exists();
        }

        return view('products.show', compact('product', 'relatedProducts', 'popularProducts', 'categories', 'globalSettings', 'hasRequestedUpdate'));
    }

    /**
     * Display products for a specific category.
     */
    public function category(Category $category)
    {
        $query = Product::with('category')
            ->where('is_active', true)
            ->where('category_id', $category->id);

        // Search by name/description
        if (request()->has('search') && request()->search) {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Load all relevant settings in one query
        $settings = Setting::whereIn('key', [
            'products_per_page', 'products_grid_columns', 'sidebar_title'
        ])->pluck('value', 'key');

        // Sorting
        $sort = request()->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('downloads_count', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }

        $productsPerPage = (int) ($settings['products_per_page'] ?? 24);
        $products = $query->paginate($productsPerPage);

        $categories = Category::where('is_active', true)->withCount('products')->get();
        $sidebarProducts = $this->getSidebarProducts();
        $sidebarTitle = $settings['sidebar_title'] ?? 'Top Popular';
        $gridColumns = (int) ($settings['products_grid_columns'] ?? 6);
        $sectionTitle = $category->name;

        return view('products.index', compact('products', 'categories', 'sidebarProducts', 'sidebarTitle', 'gridColumns', 'sectionTitle'));
    }

    /**
     * Get products for the sidebar based on settings.
     */
    private function getSidebarProducts()
    {
        $type = Setting::where('key', 'sidebar_type')->value('value') ?? 'popular';
        $limit = Setting::where('key', 'sidebar_limit')->value('value') ?? 5;

        $query = Product::with('category')->where('is_active', true);

        switch ($type) {
            case 'best_seller':
                $query->where('badge', 'Más Vendido');
                break;
            case 'top_rated':
                $query->where('badge', 'Trending');
                break;
            case 'most_viewed':
                $query->orderBy('views_count', 'desc');
                break;
            case 'recent':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
            default:
                $query->orderBy('downloads_count', 'desc');
                break;
        }

        return $query->take($limit)->get();
    }

    /**
     * Display official legal licenses page.
     */
    public function licenses()
    {
        $products = Product::where('is_active', true)
            ->where('is_license', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('products.licenses', compact('products'));
    }
}