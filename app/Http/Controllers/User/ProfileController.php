<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the authenticated user's profile.
     */
    public function myProfile()
    {
        $user = Auth::user();
        $user->load(['rank', 'maxRank', 'orders', 'memberships']);
        
        // Calculate statistics
        $stats = $this->calculateUserStats($user);
        
        // Get achievements
        $achievements = $this->getUserAchievements($user);
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity($user);
        
        $isOwnProfile = true;
        
        return view('user.profile', compact('user', 'stats', 'achievements', 'recentActivity', 'isOwnProfile'));
    }
    
    /**
     * Show a public user profile.
     */
    public function show($id)
    {
        $user = User::with(['rank', 'maxRank'])->findOrFail($id);
        
        // Calculate public statistics only
        $stats = $this->calculateUserStats($user, $publicOnly = true);
        
        // Get achievements
        $achievements = $this->getUserAchievements($user);
        
        // Get recent activity (limited for public)
        $recentActivity = $this->getRecentActivity($user, $limit = 5);
        
        $isOwnProfile = Auth::check() && Auth::id() === $user->id;
        
        return view('user.profile', compact('user', 'stats', 'achievements', 'recentActivity', 'isOwnProfile'));
    }
    
    /**
     * Calculate user statistics.
     */
    protected function calculateUserStats(User $user, $publicOnly = false)
    {
        $stats = [
            'total_orders' => $user->orders()->count(),
            'days_active' => $user->created_at->diffInDays(now()),
            'current_streak' => $this->getCurrentStreak($user),
        ];
        
        if (!$publicOnly) {
            $stats['total_spent'] = $user->orders()->where('status', 'completed')->sum('total');
            $stats['products_purchased'] = $user->orders()
                ->where('status', 'completed')
                ->withCount('items')
                ->get()
                ->sum('items_count');
            $stats['points_earned'] = $user->points + $this->getPointsSpent($user);
            $stats['points_redeemed'] = $this->getPointsSpent($user);
            $stats['rank_savings'] = $this->calculateRankSavings($user);
        }
        
        return $stats;
    }
    
    /**
     * Get user achievements.
     */
    protected function getUserAchievements(User $user)
    {
        $achievements = [];
        
        // First Purchase
        $achievements[] = [
            'id' => 'first_purchase',
            'name' => 'Primera Compra',
            'icon' => 'fa-shopping-cart',
            'color' => 'from-[#FF2121] to-[#F51B1B]',
            'unlocked' => $user->orders()->count() > 0,
        ];
        
        // 7-Day Streak
        $achievements[] = [
            'id' => 'streak_7',
            'name' => 'Racha 7 Días',
            'icon' => 'fa-fire',
            'color' => 'from-[#FF2121] to-[#F51B1B]',
            'unlocked' => $this->getCurrentStreak($user) >= 7,
        ];
        
        // Rank achievements
        if ($user->maxRank) {
            if ($user->maxRank->min_points >= 500) {
                $achievements[] = [
                    'id' => 'rank_silver',
                    'name' => 'Rango Plata',
                    'icon' => 'fa-shield-alt',
                    'color' => 'from-gray-400 to-gray-500',
                    'unlocked' => true,
                ];
            }
            if ($user->maxRank->min_points >= 1000) {
                $achievements[] = [
                    'id' => 'rank_gold',
                    'name' => 'Rango Oro',
                    'icon' => 'fa-crown',
                    'color' => 'from-yellow-500 to-orange-500',
                    'unlocked' => true,
                ];
            }
        }
        
        // Diamond rank (locked if not achieved)
        $achievements[] = [
            'id' => 'rank_diamond',
            'name' => 'Rango Diamante',
            'icon' => 'fa-gem',
            'color' => 'from-[#FF2121] to-[#F51B1B]',
            'unlocked' => $user->maxRank && $user->maxRank->min_points >= 2500,
        ];
        
        return $achievements;
    }
    
    /**
     * Get recent user activity.
     */
    protected function getRecentActivity(User $user, $limit = 10)
    {
        $activity = [];
        
        // Recent orders
        $recentOrders = $user->orders()
            ->where('status', 'completed')
            ->latest()
            ->take($limit)
            ->get();
            
        foreach ($recentOrders as $order) {
            $activity[] = [
                'type' => 'purchase',
                'icon' => 'fa-plus',
                'color' => 'green',
                'title' => 'Compra completada',
                'description' => '+' . ($order->total * 10) . ' puntos ganados',
                'date' => $order->created_at,
            ];
        }
        
        // Sort by date
        usort($activity, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });
        
        return array_slice($activity, 0, $limit);
    }
    
    /**
     * Get current login streak.
     */
    protected function getCurrentStreak(User $user)
    {
        // This would integrate with your gamification service
        // For now, return a placeholder
        return 7;
    }
    
    /**
     * Get total points spent by user.
     */
    protected function getPointsSpent(User $user)
    {
        // Calculate from orders where points were used
        // Placeholder for now
        return 670;
    }
    
    /**
     * Calculate total savings from rank discounts.
     */
    protected function calculateRankSavings(User $user)
    {
        if (!$user->rank) {
            return 0;
        }
        
        $totalSpent = $user->orders()->where('status', 'completed')->sum('total');
        $discountPercent = $user->rank->discount_percentage;
        
        // Calculate what they would have paid without discount
        $savings = ($totalSpent / (100 - $discountPercent)) * $discountPercent;
        
        return round($savings, 2);
    }
}
