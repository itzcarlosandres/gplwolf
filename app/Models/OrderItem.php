<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'membership_plan_id',
        'product_name',
        'product_type',
        'price',
        'quantity',
        'license_key',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function license()
    {
        return $this->hasOne(License::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
    
    /**
     * Generate a license for this order item.
     */
    public function generateLicense()
    {
        if ($this->license) {
            return $this->license;
        }
        
        return License::create([
            'order_item_id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->order->user_id,
            'license_key' => License::generateKey(),
            'status' => 'active',
            'expires_at' => now()->addYear(),
        ]);
    }
}
