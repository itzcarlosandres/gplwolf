<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard overview.
     */
    public function index()
    {
        $user = Auth::user();

        $recentOrders = $user->orders()->with('items.product')->latest()->take(5)->get();
        $recentDownloads = $user->downloads()->with('product')->latest('downloaded_at')->take(5)->get();
        $activeMembership = $user->memberships()->with('plan')->where('status', 'active')->latest()->first();

        return view('user.dashboard', compact('user', 'recentOrders', 'recentDownloads', 'activeMembership'));
    }

    public function downloads()
    {
        $user = Auth::user();

        // Obtener productos de órdenes completadas
        $products = Product::with('category')
            ->whereHas('orderItems.order', function($q) use ($user) {
                $q->where('user_id', $user->id)->where('status', 'completed');
            })->paginate(12);

        // Obtener IDs de productos con notificaciones de actualización no leídas
        $updatedProductIds = $user->notifications()
            ->where('type', 'product_update')
            ->where('is_read', false)
            ->pluck('product_id')
            ->toArray();
        
        return view('user.downloads', compact('products', 'updatedProductIds'));
    }

    /**
     * Display the user's orders.
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items.product')->latest()->paginate(10);
        
        return view('user.orders', compact('orders'));
    }


    /**
     * Display a specific order detail.
     */
    public function showOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'user']);
        $paymentSettings = \App\Models\Setting::where('key', 'like', 'manual_payment_%')->pluck('value', 'key');

        return view('user.order-show', compact('order', 'paymentSettings'));
    }

    /**
     * Handle the payment proof upload.
     */
    public function uploadProof(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048', // 2MB Max
            'payment_notes' => 'nullable|string|max:500'
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('proofs', 'public');
            $order->update([
                'payment_proof' => $path,
                'payment_notes' => $request->payment_notes
            ]);
        }

        return back()->with('success', '¡Comprobante subido con éxito! El administrador lo revisará pronto.');
    }

    public function rewards(\App\Services\GamificationService $gamification)
    {
        $user = Auth::user();
        $status = $gamification->getDailyStatus($user);
        
        // Rank Information
        $currentRank = $user->rank;
        $allRanks = \App\Models\Rank::orderBy('min_points', 'asc')->get();
        
        // Find next rank
        $nextRank = $allRanks->where('min_points', '>', $user->points)->first();
        
        // Calculate progress percentage
        $progressPercent = 0;
        if ($nextRank && $currentRank) {
            $pointsInCurrentTier = $user->points - $currentRank->min_points;
            $pointsNeededForNext = $nextRank->min_points - $currentRank->min_points;
            $progressPercent = ($pointsInCurrentTier / $pointsNeededForNext) * 100;
        } elseif ($nextRank && !$currentRank) {
            // User has no rank yet (0 points)
            $progressPercent = ($user->points / $nextRank->min_points) * 100;
        } else {
            // User is at max rank
            $progressPercent = 100;
        }

        $transactions = \App\Models\PointTransaction::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();
        
        return view('user.rewards.index', compact('status', 'currentRank', 'allRanks', 'nextRank', 'progressPercent', 'transactions'));
    }

    public function claimReward(\App\Services\GamificationService $gamification)
    {
        $result = $gamification->claimDailyReward(Auth::user());
        
        if ($result['success']) {
            return response()->json($result);
        } else {
            return response()->json($result, 400); 
        }
    }

    /**
     * Display client's active license keys and activations.
     */
    public function licenses()
    {
        $user = Auth::user();
        
        $licenses = \App\Models\License::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);
            
        return view('user.licenses', compact('licenses'));
    }
}
