<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        // Search by order number or user
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $orders = $query->latest()->paginate(20);
        
        // Calculate statistics
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
        ];
        
        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'items.license']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
        ]);

        $this->processStatusChange($order, $request->status);

        return redirect()->back()
            ->with('success', 'Estado de la orden actualizado exitosamente.');
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'notes' => 'nullable|string',
        ]);
        
        if ($request->has('notes')) {
            $order->update(['notes' => $request->notes]);
        }
        
        $this->processStatusChange($order, $request->status);
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Orden actualizada exitosamente.');
    }

    /**
     * Process order status changes and trigger side-effects
     */
    protected function processStatusChange(Order $order, $newStatus)
    {
        $oldStatus = $order->status;
        
        // Only update if changed
        if ($oldStatus === $newStatus) return;

        $order->update(['status' => $newStatus]);
        
        // If order is completed, process items (licenses, memberships, points)
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $totalPointsToAward = 0;

            foreach ($order->items->load('product') as $item) {
                // 1. Licenses for products
                if ($item->product_id && !$item->license) {
                    $item->generateLicense();
                    if ($item->product) {
                        // Lógica de Puntos replicada con soporte para multiplicadores
                        if ($item->product->reward_points > 0) {
                             $totalPointsToAward += ($item->product->reward_points * $item->quantity);
                        } else {
                             // Cálculo dinámico
                             $pointsPerCurrency = (int) (\App\Models\Setting::where('key', 'points_per_currency')->value('value') ?? 1);
                             $multiplier = (float) ($item->product->points_multiplier ?? 1.0);
                             // Usar precio del item guardado en la orden
                             $points = floor($item->price * $pointsPerCurrency * $multiplier);
                             $totalPointsToAward += ($points * $item->quantity);
                        }
                    }
                }

                // 2. Activate Memberships
                if ($item->membership_plan_id) {
                    $plan = \App\Models\MembershipPlan::find($item->membership_plan_id);
                    if ($plan) {
                        $this->activateMembership($order->user_id, $plan);
                        $totalPointsToAward += $plan->reward_points;
                    }
                }
            }

            // 3. Award points
            if ($totalPointsToAward > 0) {
                $order->user->increment('points', $totalPointsToAward);

                \App\Models\PointTransaction::create([
                    'user_id' => $order->user_id,
                    'amount' => $totalPointsToAward,
                    'type' => 'purchase',
                    'description' => 'Puntos ganados por compra - Orden #' . $order->order_number
                ]);
            }

            // 4. Update coupon usage
            if ($order->coupon_id) {
                $coupon = \App\Models\Coupon::find($order->coupon_id);
                if ($coupon) {
                    $coupon->increment('usage_count');
                }
            }
        }

        // Si la orden se cancela después de haber sido completada, revertir acciones
        if ($newStatus === 'cancelled' && $oldStatus === 'completed') {
            // Revocar licencias
            foreach ($order->items as $item) {
                if ($item->license) {
                    $item->license->update(['is_active' => false]);
                }
            }
            
            // Desactivar membresías asociadas a esta orden
            if ($order->items()->whereNotNull('membership_plan_id')->exists()) {
                \App\Models\Membership::where('user_id', $order->user_id)
                    ->where('status', 'active')
                    ->whereHas('membershipPlan', function($q) use ($order) {
                        $q->whereIn('id', $order->items()->pluck('membership_plan_id'));
                    })
                    ->update(['status' => 'cancelled']);
            }
            
            // Revertir cupón si se cancela
            if ($order->coupon_id) {
                $coupon = \App\Models\Coupon::find($order->coupon_id);
                if ($coupon) {
                    $coupon->decrement('usage_count');
                }
            }
        }
    }


    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        // Fuerza bruta: Permitir eliminar cualquier orden
        // Opcional: Podrías querer revertir puntos/membresías aquí también si lo deseas, 
        // pero "eliminar" suele ser destructivo sin vuelta atrás.
        
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Orden eliminada exitosamente.');
    }
}
