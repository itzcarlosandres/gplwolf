<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'expires_at',
        'usage_limit',
        'usage_count',
        'is_active',
        'restriction_type', // none, products, categories, membership_plans
        'restriction_ids',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'restriction_ids' => 'array',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isValid()
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount($total)
    {
        if ($this->type === 'fixed') {
            return min($this->value, $total);
        }
        return ($total * $this->value) / 100;
    }

    // Restriction Helpers
    public function appliesToProduct($productId, $categoryIds = [])
    {
        if ($this->restriction_type === 'none') {
            return true;
        }

        if ($this->restriction_type === 'products') {
            return in_array($productId, $this->restriction_ids ?? []);
        }

        if ($this->restriction_type === 'categories') {
            // Check if any of the product's categories match the restricted category IDs
            // Assumes $categoryIds is an array of IDs
            if (empty($categoryIds)) return false; 
            
            // If checking single category ID passed as int/string
            if (!is_array($categoryIds)) $categoryIds = [$categoryIds];

            return !empty(array_intersect($categoryIds, $this->restriction_ids ?? []));
        }
        
        // If it's a membership coupon, it doesn't apply to products generally, logic handled in Cart
        return false;
    }
}