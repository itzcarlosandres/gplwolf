<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function addToCart(MembershipPlan $plan, Request $request)
    {
        $cart = session()->get('cart', []);

        $price = $plan->price;
        if ($request->has('discount10') || $request->input('offer') == '1') {
            $price = round($price * 0.90, 2);
        }

        $planKey = 'plan_' . $plan->id;

        if(isset($cart[$planKey])) {
            $cart[$planKey]['quantity'] = 1;
            $cart[$planKey]['price'] = $price;
        } else {
            $cart[$planKey] = [
                "id" => $plan->id,
                "name" => 'Membresía ' . $plan->name,
                "quantity" => 1,
                "price" => $price,
                "thumbnail" => null,
                "type" => 'membership',
                "plan_id" => $plan->id
            ];
        }

        session()->put('cart', $cart);

        $msg = ($request->has('discount10') || $request->input('offer') == '1')
            ? '¡Plan de Membresía añadido con 10% OFF especial!'
            : 'Membresía añadida al carrito!';

        return redirect()->route('cart.index')->with('success', $msg);
    }

    public function pricing()
    {
        $plans = MembershipPlan::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('price', 'asc')
            ->get();

        return view('membership.pricing', compact('plans'));
    }
}
