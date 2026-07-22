<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MembershipPlan;
use App\Models\Membership;
use App\Models\OrderItem;
use App\Services\PaypalService;
use App\Services\CoinpalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paypal;
    protected $coinpal;

    public function __construct(PaypalService $paypal, CoinpalService $coinpal)
    {
        $this->paypal = $paypal;
        $this->coinpal = $coinpal;
    }

    // --- PAYPAL HANDLERS ---

    public function paypalSuccess(Request $request)
    {
        $paypalOrderId = $request->token;
        if (!$paypalOrderId) {
            return redirect()->route('checkout.index')->with('error', 'Token de PayPal no encontrado.');
        }

        $capture = $this->paypal->captureOrder($paypalOrderId);

        if ($capture && ($capture['status'] === 'COMPLETED' || $capture['status'] === 'APPROVED')) {
            $orderNumber = $capture['purchase_units'][0]['reference_id'] ?? null;
            $order = Order::where('order_number', $orderNumber)->first();

            if ($order) {
                return $this->completeOrder($order, 'paypal', $capture['id']);
            }
        }

        return redirect()->route('checkout.index')->with('error', 'No se pudo capturar el pago de PayPal.');
    }

    public function paypalCancel()
    {
        return redirect()->route('checkout.index')->with('error', 'Pago de PayPal cancelado.');
    }

    // --- COINPAL HANDLERS ---

    public function coinpalRedirect(Request $request)
    {
        $orderNo = $request->orderNo;
        $order = Order::where('order_number', $orderNo)->first();

        if ($order && ($request->status === 'success' || $request->status === 'completed')) {
             if ($order->status === 'completed') {
                return redirect()->route('checkout.success', $order)->with('success', 'Pago con criptomonedas procesado.');
             }
             // We wait for webhook, but if it's already done or we want to trust redirect for now (less secure)
             // However, best practice is to show a "pending" or wait screen.
             return redirect()->route('checkout.success', $order)->with('success', 'Tu pago está siendo procesado por la red Blockchain.');
        }

        return redirect()->route('home')->with('info', 'Regresaste de CoinPal. Verifica el estado de tu orden en tu panel.');
    }

    public function coinpalCancel()
    {
        return redirect()->route('checkout.index')->with('error', 'Pago con Criptomonedas cancelado.');
    }

    public function coinpalNotify(Request $request)
    {
        $data = $request->all();
        
        if ($this->coinpal->verifyNotification($data)) {
            $order = Order::where('order_number', $data['orderNo'])->first();
            
            if ($order && ($data['status'] === 'success' || $data['status'] === 'completed')) {
                $this->completeOrder($order, 'coinpal', $data['transactionNo'] ?? 'COIN-' . $data['orderNo']);
                return response('success');
            }
        }

        return response('fail');
    }

    // --- SHARED LOGIC ---

    protected function completeOrder(Order $order, $method, $transactionId)
    {
        if ($order->status === 'completed') {
            return redirect()->route('checkout.success', $order);
        }

        try {
            DB::beginTransaction();

            $order->update([
                'status' => 'completed',
                'payment_method' => $method,
                'transaction_id' => $transactionId,
            ]);

            $totalPoints = 0;

            foreach ($order->items as $item) {
                if ($item->membership_plan_id) {
                    $plan = MembershipPlan::find($item->membership_plan_id);
                    if ($plan) {
                        $this->activateMembership($order->user_id, $plan);
                        $totalPoints += $plan->reward_points;
                    }
                } else {
                    $item->generateLicense();
                    
                    // Lógica de Puntos replicada del CheckoutController
                    $product = $item->product;
                    if ($product) {
                        if ($product->reward_points > 0) {
                             $totalPoints += ($product->reward_points * $item->quantity);
                        } else {
                             // Cálculo dinámico
                             $pointsPerCurrency = (int) (\App\Models\Setting::where('key', 'points_per_currency')->value('value') ?? 1);
                             $multiplier = (float) ($product->points_multiplier ?? 1.0);
                             // Usar precio del item en la orden para consistencia
                             $points = floor($item->price * $pointsPerCurrency * $multiplier);
                             $totalPoints += ($points * $item->quantity);
                        }
                    }
                }
            }

            // Award points
            $order->user->increment('points', $totalPoints);
            
            // Increment coupon usage
            if ($order->coupon_id) {
                $order->coupon->increment('usage_count');
            }

            DB::commit();

            return redirect()->route('checkout.success', $order)->with('success', 'Pago completado con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Completion Error: ' . $e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'Error al finalizar la orden.');
        }
    }

    protected function activateMembership($userId, $plan)
    {
        Membership::where('user_id', $userId)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $expiresAt = $plan->isLifetime() ? null : now()->addDays($plan->duration_days ?: 30);

        Membership::create([
            'user_id' => $userId,
            'membership_plan_id' => $plan->id,
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => $expiresAt,
        ]);
    }
}
