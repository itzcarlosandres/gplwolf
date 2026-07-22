<?php

namespace App\Http\Controllers;

use App\Models\ProductVersion;
use Illuminate\Http\Request;

class UpdatesController extends Controller
{
    public function index()
    {
        $updates = ProductVersion::with('product')
            ->orderBy('released_at', 'desc')
            ->paginate(10);

        // Obtener IDs de productos comprados si el usuario está logueado
        $purchasedProductIds = [];
        if (auth()->check()) {
            $user = auth()->user();
            $purchasedProductIds = \App\Models\Product::whereHas('orderItems.order', function($q) use ($user) {
                $q->where('user_id', $user->id)->where('status', 'completed');
            })->pluck('id')->toArray();
        }

        if (request()->ajax()) {
            return view('updates.partials.list', compact('updates', 'purchasedProductIds'))->render();
        }

        return view('updates.index', compact('updates', 'purchasedProductIds'));
    }
}
