<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        // Ensure sitemap URLs use the domain configured in APP_URL (avoid localhost in production)
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));
        }

        $xml = Cache::remember('sitemap_xml', 3600, function () {
            $products = Product::active()->get();
            $posts    = Post::published()->latest('published_at')->get();

            return view('sitemap', [
                'products' => $products,
                'posts'    => $posts,
            ])->render();
        });

        return response($xml)->header('Content-Type', 'text/xml');
    }
}
