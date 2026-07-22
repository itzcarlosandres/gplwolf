<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function liveSearch(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with('category')
            ->limit(5)
            ->get();

        return response()->json($products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'url' => route('products.show', $product->slug),
                'thumbnail' => $product->thumbnail ? asset('storage/' . $product->thumbnail) : null,
                'price' => number_format($product->price, 2),
                'type' => $product->category ? $product->category->name : 'Producto',
            ];
        }));
    }

    public function index(Request $request)
    {
        $query = $request->input('q');
        
        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('full_description', 'LIKE', "%{$query}%");
            })
            ->latest('updated_at')
            ->paginate(12);

        return view('search.index', compact('products', 'query'));
    }
}