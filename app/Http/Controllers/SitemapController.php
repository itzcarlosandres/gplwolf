<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        // Asegurar que las URLs del sitemap usen el dominio configurado en .env (APP_URL)
        // Esto evita que salga "localhost" si se genera desde CLI o un entorno local, y asegura el dominio correcto.
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));
        }

        $xml = \Illuminate\Support\Facades\Cache::remember('sitemap_xml', 86400, function () {
            // Usamos el scope 'active()' del modelo Product en lugar de buscar una columna 'status' que no existe
            $products = Product::active()->get();

            return view('sitemap', [
                'products' => $products,
            ])->render();
        });

        return response($xml)->header('Content-Type', 'text/xml');
    }
}
