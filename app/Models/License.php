<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'order_item_id',
        'license_key',
        'status',
        'domain',
        'activations_limit',
        'activations_count',
        'activated_at',
        'expires_at',
    ];

    protected $casts = [
        'activations_limit' => 'integer',
        'activations_count' => 'integer',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($license) {
            if (empty($license->license_key)) {
                $license->license_key = self::generateLicenseKey();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function generateLicenseKey()
    {
        return strtoupper(Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8));
    }
    
    public static function generateKey()
    {
        return self::generateLicenseKey();
    }


    public function isActive()
    {
        return $this->status === 'active' && 
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function canActivate()
    {
        return $this->isActive() && $this->activations_count < $this->activations_limit;
    }

    public function activate($domain)
    {
        if (!$this->canActivate()) {
            return false;
        }

        $this->update([
            'domain' => $domain,
            'activations_count' => $this->activations_count + 1,
            'activated_at' => now(),
        ]);

        return true;
    }
}
