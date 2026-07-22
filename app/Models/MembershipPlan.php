<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration',
        'duration_days',
        'benefits',
        'is_active',
        'is_featured',
        'sort_order',
        'daily_download_limit',
        'sites_limit',
        'reward_points',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'benefits' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'duration_days' => 'integer',
        'sort_order' => 'integer',
        'daily_download_limit' => 'integer',
        'sites_limit' => 'integer',
        'reward_points' => 'integer',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function isLifetime()
    {
        return $this->duration === 'lifetime';
    }
}