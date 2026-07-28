<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'points',
        'current_rank_id',
        'max_rank_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user's memberships.
     */
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Get the user's active membership.
     */
    public function activeMembership()
    {
        return $this->hasOne(Membership::class)
                    ->where('status', 'active')
                    ->where(function ($query) {
                        $query->whereNull('expires_at')
                              ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Get the user's licenses.
     */
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    /**
     * Get the user's downloads.
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /**
     * Get the user's notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has active membership.
     */
    public function hasActiveMembership()
    {
        return $this->activeMembership()->exists();
    }

    /**
     * Check if user has purchased a product.
     */
    public function hasPurchased($productId)
    {
        return $this->orders()
                    ->where('status', 'completed')
                    ->whereHas('items', function ($query) use ($productId) {
                        $query->where('product_id', $productId);
                    })
                    ->exists();
    }
    /**
     * Check if user can download a product.
     */
    public function canDownload($product)
    {
        // 1. Regular Purchase
        if ($this->hasPurchased($product->id)) {
            return true;
        }

        // 2. Membership
        $activeMembership = $this->activeMembership;
        if (!$activeMembership) {
            return false;
        }

        // 3. Excluded Categories
        if ($product->category && $product->category->exclude_from_membership) {
            return false;
        }

        // 4. Daily Limit
        $limit = $activeMembership->plan->daily_download_limit + $activeMembership->extra_daily_downloads;
        if ($limit > 0) {
            // Count how many times THIS product has been downloaded today
            $thisProductToday = $this->downloads()
                ->where('product_id', $product->id)
                ->whereDate('downloaded_at', \Carbon\Carbon::today())
                ->count();

            // If already downloaded today, allow up to 5 times without counting more
            if ($thisProductToday > 0) {
                return $thisProductToday < 5; // Limit per product session
            }

            // If first time today, check total daily limit
            $distinctToday = $this->downloads()
                ->whereDate('downloaded_at', \Carbon\Carbon::today())
                ->distinct('product_id')
                ->count('product_id');
                
            if ($distinctToday >= $limit) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get remaining daily downloads.
     */
    public function remainingDownloads()
    {
        $activeMembership = $this->activeMembership;
        if (!$activeMembership) return 0;

        $limit = $activeMembership->plan->daily_download_limit + $activeMembership->extra_daily_downloads;
        if ($limit == 0) return 'Ilimitado';

        $todayDownloads = $this->downloads()
            ->whereDate('downloaded_at', \Carbon\Carbon::today())
            ->distinct('product_id')
            ->count('product_id');

        return max(0, $limit - $todayDownloads);
    }

    /**
     * Get the user's tickets.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the user's connected sites (WP Plugins).
     */
    public function connectedSites()
    {
        return $this->hasMany(ConnectedSite::class);
    }

    // --- GAMIFICATION START ---

    public function dailyLogin()
    {
        return $this->hasOne(DailyLogin::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'current_rank_id');
    }

    public function maxRank()
    {
        return $this->belongsTo(Rank::class, 'max_rank_id');
    }

    /**
     * Add points to the user and log transaction.
     */
    public function addPoints(int $amount, string $type, ?string $description = null, array $metadata = [])
    {
        if ($amount <= 0) return;

        $this->increment('points', $amount);

        $this->pointTransactions()->create([
            'amount' => $amount,
            'type' => $type, // e.g., 'daily_login', 'purchase'
            'description' => $description,
            'metadata' => $metadata
        ]);

        // Future: Fire event to check rank upgrade
    }

    /**
     * Spend points from the user wallet.
     */
    public function spendPoints(int $amount, string $type, ?string $description = null, array $metadata = []): bool
    {
        if ($amount <= 0) return false;
        if ($this->points < $amount) return false;

        $this->decrement('points', $amount);

        $this->pointTransactions()->create([
            'amount' => -$amount,
            'type' => $type, // e.g., 'purchase_discount'
            'description' => $description,
            'metadata' => $metadata
        ]);

        return true;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
