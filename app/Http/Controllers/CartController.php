<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $categories = \App\Models\Category::where('is_active', true)->get();

        return view('cart.index', compact('cart', 'total', 'categories'));
    }

    public function add(Product $product, Request $request)
    {
        $cart = session()->get('cart', []);

        $basePrice = ($product->sale_price && $product->sale_price < $product->price) ? $product->sale_price : $product->price;

        // Si se añade desde la oferta rápida con 10% OFF
        if ($request->has('discount10') || $request->input('offer') == '1') {
            $basePrice = round($basePrice * 0.90, 2);
        }

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $basePrice,
                "thumbnail" => $product->thumbnail,
                "type" => $product->type,
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);

        $message = ($request->has('discount10') || $request->input('offer') == '1')
            ? '¡Oferta especial con 10% OFF añadida al carrito!'
            : 'Producto añadido al carrito!';

        return redirect()->route('cart.index')->with('success', $message);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }
}
