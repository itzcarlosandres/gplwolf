<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Membership;
use App\Models\Download;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
            'active_memberships' => Membership::where('status', 'active')->count(),
            'total_downloads' => Download::count(),
            'recent_orders' => Order::with(['user', 'items.product'])
                ->latest()
                ->take(10)
                ->get(),
            'top_products' => Product::withCount('downloads')
                ->orderBy('downloads_count', 'desc')
                ->take(5)
                ->get(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
