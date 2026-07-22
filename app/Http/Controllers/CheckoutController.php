<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\PaypalService;
use App\Services\CoinpalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $paypal;
    protected $coinpal;

    public function __construct(PaypalService $paypal, CoinpalService $coinpal)
    {
        $this->paypal = $paypal;
        $this->coinpal = $coinpal;
    }
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Tu carrito está vacío');
        }

        $total = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Calculate Rank Discount
        $rankDiscount = 0;
        $user = auth()->user();
        if ($user && $user->rank) {
            $rankDiscount = ($total * $user->rank->discount_percentage) / 100;
        }

        $categories = \App\Models\Category::where('is_active', true)->get();
        $paymentSettings = \App\Models\Setting::where('key', 'like', 'manual_payment_%')->pluck('value', 'key');

        // Load all relevant settings in one query
        $settings = \App\Models\Setting::whereIn('key', ['points_per_currency'])
            ->pluck('value', 'key');
        $pointsPerCurrency = (int) ($settings['points_per_currency'] ?? 1);

        // Batch fetch plans and products to avoid N+1 queries
        $planIds = [];
        $productIds = [];
        foreach ($cart as $item) {
            if (isset($item['plan_id'])) {
                $planIds[] = $item['plan_id'];
            } else {
                $productIds[] = $item['id'];
            }
        }

        $plans = \App\Models\MembershipPlan::whereIn('id', array_unique($planIds))
            ->pluck('reward_points', 'id')
            ->all();

        $products = \App\Models\Product::whereIn('id', array_unique($productIds))
            ->get(['id', 'reward_points', 'points_multiplier', 'price'])
            ->keyBy('id');

        $pointsToEarn = 0;
        foreach ($cart as $item) {
            if (isset($item['plan_id'])) {
                $pointsToEarn += $plans[$item['plan_id']] ?? 0;
            } else {
                $product = $products[$item['id']] ?? null;
                if ($product) {
                    if ($product->reward_points > 0) {
                        $pointsToEarn += ($product->reward_points * $item['quantity']);
                    } else {
                        $multiplier = (float) ($product->points_multiplier ?? 1.0);
                        $pointsToEarn += floor($product->price * $pointsPerCurrency * $multiplier * $item['quantity']);
                    }
                }
            }
        }

        return view('checkout.index', compact('cart', 'total', 'categories', 'paymentSettings', 'pointsToEarn', 'rankDiscount'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required']);
        $coupon = \App\Models\Coupon::where('code', $request->code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->with('error', 'El cupón no es válido o ha expirado.');
        }

        $cart = session()->get('cart', []);
        $cartSubtotal = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        if ($cartSubtotal < $coupon->min_purchase) {
            return back()->with('error', 'El pedido no alcanza el mínimo de $' . $coupon->min_purchase);
        }

        // Calculate Applicable Total based on Restrictions
        $applicableTotal = 0;
        $hasApplicableItems = false;

        if ($coupon->restriction_type === 'none') {
            $applicableTotal = $cartSubtotal;
            $hasApplicableItems = true;
        } else {
            // Preload product category IDs for category restrictions to avoid N+1
            $productCategoryIds = [];
            if ($coupon->restriction_type === 'categories') {
                $productIds = collect($cart)
                    ->whereNull('plan_id')
                    ->pluck('id')
                    ->unique()
                    ->all();

                $productCategoryIds = \App\Models\Product::whereIn('id', $productIds)
                    ->pluck('category_id', 'id')
                    ->all();
            }

            foreach ($cart as $item) {
                $price = $item['price'] * $item['quantity'];

                if (isset($item['plan_id'])) {
                    // It's a Membership
                    if ($coupon->restriction_type === 'membership_plans') {
                         if (in_array($item['plan_id'], $coupon->restriction_ids ?? [])) {
                             $applicableTotal += $price;
                             $hasApplicableItems = true;
                         }
                    }
                } else {
                     // It's a Product
                     if ($coupon->restriction_type === 'products') {
                         if (in_array($item['id'], $coupon->restriction_ids ?? [])) {
                             $applicableTotal += $price;
                             $hasApplicableItems = true;
                         }
                     } elseif ($coupon->restriction_type === 'categories') {
                         $categoryId = $productCategoryIds[$item['id']] ?? null;
                         if ($categoryId && in_array($categoryId, $coupon->restriction_ids ?? [])) {
                             $applicableTotal += $price;
                             $hasApplicableItems = true;
                         }
                     }
                }
            }
        }

        if (!$hasApplicableItems) {
            return back()->with('error', 'Este cupón no es válido para los artículos en su carrito.');
        }

        // Calculate Discount on Applicable Total Only
        $discountValue = 0;
        if ($coupon->type === 'fixed') {
             // Fixed discount applies to the cart, but capped at applicable total 
             // (or do we allow $10 off entire cart even if restricted items distinct? 
             // Standard logic: Fixed amount usually capped at applicable items total or cart total needed to contain them)
             // Simpler approach: Fixed Value capped at Applicable Total.
             $discountValue = min($coupon->value, $applicableTotal);
        } else {
             $discountValue = ($applicableTotal * $coupon->value) / 100;
        }

        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discountValue
        ]);

        return back()->with('success', '¡Cupón aplicado con éxito! Ahorraste $' . number_format($discountValue, 2));
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Cupón eliminado correctamente.');
    }

    public function applyPoints(Request $request)
    {
        $pointsToUse = (int) $request->points_to_use;
        $user = auth()->user();
        $userPoints = $user->points;

        if ($pointsToUse > $userPoints) {
            return back()->with('error', 'No tienes suficientes puntos.');
        }

        $conversionRate = (int) (\App\Models\Setting::where('key', 'points_conversion_rate')->value('value') ?? 100);
        $discountAmount = $pointsToUse / $conversionRate;

        session()->put('points_redemption', [
            'points' => $pointsToUse,
            'discount' => $discountAmount
        ]);

        return back()->with('success', '¡Puntos canjeados con éxito!');
    }

    public function removePoints()
    {
        session()->forget('points_redemption');
        return back()->with('success', 'Puntos removidos de la orden.');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:card,paypal,coinpal,manual,points',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Tu carrito está vacío');
        }

        $subtotal = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Apply Rank Discount (VIP Benefit)
        $rankDiscount = 0;
        $user = auth()->user();
        if ($user && $user->rank) {
            $rankDiscount = ($subtotal * $user->rank->discount_percentage) / 100;
        }

        $couponDiscount = session()->has('coupon') ? session()->get('coupon')['discount'] : 0;
        $pointsDiscount = session()->has('points_redemption') ? session()->get('points_redemption')['discount'] : 0;

        $totalDiscount = $rankDiscount + $couponDiscount + $pointsDiscount;
        $totalValue = max(0, $subtotal - $totalDiscount);

        // Load settings once
        $settings = \App\Models\Setting::whereIn('key', ['points_conversion_rate', 'points_per_currency'])
            ->pluck('value', 'key');
        $pointsConversionRate = (int) ($settings['points_conversion_rate'] ?? 100);
        $pointsPerCurrency = (int) ($settings['points_per_currency'] ?? 1);

        try {
            DB::beginTransaction();

            // Preload cart items to avoid N+1 queries
            $cartPlanIds = [];
            $cartProductIds = [];
            foreach ($cart as $details) {
                if (isset($details['plan_id'])) {
                    $cartPlanIds[] = $details['plan_id'];
                } else {
                    $cartProductIds[] = $details['id'];
                }
            }

            $plans = \App\Models\MembershipPlan::whereIn('id', array_unique($cartPlanIds))->get()->keyBy('id');
            $products = Product::whereIn('id', array_unique($cartProductIds))->get()->keyBy('id');

            // Si el total es $0 (cupón 100% o productos gratis), completar automáticamente
            if ($totalValue <= 0) {
                $status = 'completed';
                $paymentMethod = 'free'; // Or points if covered fully
                if ($pointsDiscount > 0 && $totalValue <= 0) $paymentMethod = 'points_full';
            } elseif ($request->payment_method === 'points') {
                // Pago con Puntos (legacy check, but kept for full payment option if UI allows)
                $status = 'completed';
                $paymentMethod = 'points';

                $pointsNeeded = ceil($totalValue * $pointsConversionRate);

                if (auth()->user()->points < $pointsNeeded) {
                    throw new \Exception('No tienes suficientes puntos. Necesitas ' . $pointsNeeded . ' puntos.');
                }

                // Deducir puntos (Legacy method)
                auth()->user()->decrement('points', $pointsNeeded);
                \App\Models\PointTransaction::create([
                    'user_id' => auth()->id(),
                    'amount' => -$pointsNeeded,
                    'type' => 'purchase',
                    'description' => 'Pago total de orden con puntos'
                ]);

            } else {
                $status = ($request->payment_method === 'manual') ? 'pending' : (($request->payment_method === 'card') ? 'completed' : 'pending');
                $paymentMethod = $request->payment_method ?? 'card';
            }

            // Deduct Points from Partial Redemption if applied (and not points_full check above which handles it differently)
            if (session()->has('points_redemption') && $paymentMethod !== 'points') { 
                $redeemedPoints = session('points_redemption')['points'];
                if (auth()->user()->points < $redeemedPoints) {
                     throw new \Exception('Error de sincronización de puntos. Intenta de nuevo.');
                }
                auth()->user()->decrement('points', $redeemedPoints);
                
                \App\Models\PointTransaction::create([
                    'user_id' => auth()->id(),
                    'amount' => -$redeemedPoints,
                    'type' => 'redemption',
                    'description' => 'Descuento parcial en compra'
                ]);
            }

            // Create Order
            $orderNumber = 'ORD-' . strtoupper(uniqid());
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount, // Now includes coupon + points
                'coupon_id' => session()->has('coupon') ? session()->get('coupon')['id'] : null,
                'tax' => 0,
                'total' => $totalValue,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'transaction_id' => ($paymentMethod === 'manual' || $paymentMethod === 'paypal' || $paymentMethod === 'coinpal') ? null : 'FREE-' . strtoupper(uniqid()),
                'notes' => $request->notes,
            ]);


            $totalPointsToAward = 0;

            // Create Order items and licenses
            foreach ($cart as $id => $details) {
                if (isset($details['plan_id'])) {
                    // It's a Membership Plan
                    $plan = $plans[$details['plan_id']] ?? null;
                    if (!$plan) continue;

                    $item = OrderItem::create([
                        'order_id' => $order->id,
                        'membership_plan_id' => $plan->id,
                        'product_name' => $plan->name,
                        'product_type' => 'membership',
                        'price' => $plan->price,
                        'quantity' => 1,
                    ]);

                    $totalPointsToAward += $plan->reward_points;

                    if ($order->status === 'completed') {
                        $this->activateMembership($order->user_id, $plan);
                    }
                } else {
                    // It's a Product
                    $product = $products[$details['id']] ?? null;
                    if (!$product) continue;

                    $item = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_type' => $product->type ?? 'premium',
                        'price' => $product->price,
                        'quantity' => $details['quantity'],
                    ]);

                    // Calcular Puntos Ganados
                    $points = 0;

                    if ($product->reward_points > 0) {
                        $points = $product->reward_points;
                    } else {
                        $multiplier = (float) ($product->points_multiplier ?? 1.0);
                        $points = floor($product->price * $pointsPerCurrency * $multiplier);
                    }

                    $totalPointsToAward += ($points * $details['quantity']);

                    if ($order->status === 'completed') {
                        $item->generateLicense();
                    }
                }
            }

            // Award points if completed
            if ($order->status === 'completed') {
                $order->user->increment('points', $totalPointsToAward);
                if ($order->coupon_id) {
                    $coupon = \App\Models\Coupon::find($order->coupon_id);
                    if ($coupon) {
                        $coupon->increment('usage_count');
                    }
                }

                // Registrar transacción de puntos
                if ($totalPointsToAward > 0) {
                    \App\Models\PointTransaction::create([
                        'user_id' => $user->id,
                        'amount' => $totalPointsToAward,
                        'type' => 'purchase',
                        'description' => 'Puntos ganados por compra - Orden #' . $order->order_number
                    ]);
                }
            }

            DB::commit();

            $pointsEarned = $totalPointsToAward;

            // Enviar email de confirmación de compra (en cola para no bloquear)
            \Illuminate\Support\Facades\Mail::to($user->email)
                ->send(new \App\Mail\PurchaseConfirmation($order, $pointsEarned));

            // Clear Session (Will do it after payment for automated ones, or now for manual/simulated)
            session()->forget('cart');
            session()->forget('coupon');
            session()->forget('points_redemption');

            // Clear Session (Will do it after payment for automated ones, or now for manual/simulated)
            if ($order->status === 'completed' || $order->payment_method === 'manual') {
                session()->forget(['cart', 'coupon']);
            }

            // --- REDIRECTS TO GATEWAYS ---
            if ($order->payment_method === 'paypal') {
                $paypalOrder = $this->paypal->createOrder($order->total, $order->order_number);
                if ($paypalOrder && isset($paypalOrder['links'])) {
                    $approveLink = collect($paypalOrder['links'])->where('rel', 'approve')->first();
                    if ($approveLink) {
                        return redirect()->away($approveLink['href']);
                    }
                }
                return back()->with('error', 'No se pudo iniciar el pago con PayPal.');
            }


            if ($order->payment_method === 'coinpal') {
                \Log::info('=== INICIANDO PAGO COINPAL ===');
                \Log::info('Order Total: ' . $order->total);
                \Log::info('Order Number: ' . $order->order_number);
                
                $coinpalOrder = $this->coinpal->createPayment($order->total, $order->order_number);
                
                \Log::info('CoinPal Order Result:', ['result' => $coinpalOrder]);
                
                if ($coinpalOrder && isset($coinpalOrder['nextStepContent'])) {
                    \Log::info('Redirecting to: ' . $coinpalOrder['nextStepContent']);
                    return redirect()->away($coinpalOrder['nextStepContent']);
                }
                
                \Log::error('CoinPal payment failed - no nextStepContent in response');
                return back()->with('error', 'No se pudo iniciar el pago con Criptomonedas.');
            }


            return redirect()->route('checkout.success', $order)->with('success', '¡Compra realizada con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Hubo un error al procesar tu pedido: ' . $e->getMessage());
        }
    }

    protected function activateMembership($userId, $plan)
    {
        // Deactivate old active memberships
        \App\Models\Membership::where('user_id', $userId)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $expiresAt = $plan->isLifetime() ? null : now()->addDays($plan->duration_days ?: 30);

        $membership = \App\Models\Membership::create([
            'user_id' => $userId,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => $expiresAt,
        ]);
        
        // Bonus de bienvenida (500 puntos)
        $bonusPoints = 500;
        $user = \App\Models\User::find($userId);
        
        if ($user) {
            $user->increment('points', $bonusPoints);
            
            // Registrar transacción de bonus
            \App\Models\PointTransaction::create([
                'user_id' => $userId,
                'amount' => $bonusPoints,
                'type' => 'bonus',
                'description' => 'Bonus de bienvenida - Membresía ' . $plan->name
            ]);
            
            // Enviar email de membresía activada
            \Illuminate\Support\Facades\Mail::to($user->email)
                ->send(new \App\Mail\MembershipActivated($membership, $bonusPoints));
        }
    }

    public function success(Order $order)
    {
        // Ensure the order belongs to the user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('checkout.success', compact('order', 'categories'));
    }
}