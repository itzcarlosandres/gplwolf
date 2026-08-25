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

        $trialPlan = $plans->first(fn($p) => $p->slug === 'prueba-7-dias' || $p->duration === 'trial');

        return view('membership.pricing', compact('plans', 'trialPlan'));
    }

    public function claimTrial(Request $request)
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('membership.claim-trial'));
            return redirect()->route('login')->with('info', 'Por favor inicia sesión o crea una cuenta para activar tu membresía de prueba de 7 días.');
        }

        $user = auth()->user();

        $plan = MembershipPlan::where('slug', 'prueba-7-dias')
            ->orWhere('duration', 'trial')
            ->where('is_active', true)
            ->first();

        if (!$plan) {
            return redirect()->route('membership.pricing')->with('error', 'El plan de prueba no está disponible en este momento.');
        }

        // Check if user has an active membership already
        if ($user->hasActiveMembership()) {
            return redirect()->route('user.dashboard')->with('info', 'Ya cuentas con una membresía activa.');
        }

        // Check if user already used this trial plan in the past
        $alreadyUsedTrial = \App\Models\Membership::where('user_id', $user->id)
            ->where('membership_plan_id', $plan->id)
            ->exists();

        if ($alreadyUsedTrial) {
            return redirect()->route('membership.pricing')->with('error', 'Ya has utilizado tu periodo de prueba de 7 días anteriormente. Por favor elige uno de nuestros planes Pro para continuar.');
        }

        // If trial plan has a price > 0, route through cart & checkout
        if ($plan->price > 0) {
            return $this->addToCart($plan, $request);
        }

        // Activate 7-day free trial immediately
        $membership = \App\Models\Membership::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addDays($plan->duration_days ?: 7),
            'extra_daily_downloads' => 0,
        ]);

        if ($plan->reward_points > 0) {
            $user->increment('points', $plan->reward_points);
            \App\Models\PointTransaction::create([
                'user_id' => $user->id,
                'amount' => $plan->reward_points,
                'type' => 'bonus',
                'description' => 'Bonus de bienvenida - Membresía de Prueba 7 Días'
            ]);
        }

        return redirect()->route('user.dashboard')->with('success', '🎉 ¡Felicidades! Tu membresía de prueba por 7 días (3 descargas diarias) ha sido activada con éxito.');
    }
}
