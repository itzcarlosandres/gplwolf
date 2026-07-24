<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'full_description',
        'type',
        'category',
        'price',
        'demo_url',
        'thumbnail',
        'screenshots',
        'features',
        'version',
        'wordpress_version',
        'is_active',
        'is_best_seller',
        'is_popular',
        'downloads_count',
        'rating',
        'reviews_count',
        'product_file',
        'category_id',
        'badge',
        'reward_points',
        'points_multiplier',
        'is_license',
    ];

    protected $casts = [
        'screenshots' => 'array',
        'features' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_popular' => 'boolean',
        'is_license' => 'boolean',
        'downloads_count' => 'integer',
        'reviews_count' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the versions for the product.
     */
    public function versions()
    {
        return $this->hasMany(ProductVersion::class)->orderBy('released_at', 'desc');
    }

    /**
     * Get the latest version.
     */
    public function latestVersion()
    {
        return $this->hasOne(ProductVersion::class)->latestOfMany();
    }

    /**
     * Get the downloads for the product.
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /**
     * Get the licenses for the product.
     */
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeInCategory($query, $category)
    {
        return $query->where('category', $category);
    }



    /**
     * Increment the download count.
     */
    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return $this->price == 0 ? 'Gratis' : '$' . number_format($this->price, 2);
    }

    /**
     * Check if product is free.
     */
    public function isFree()
    {
        return $this->price == 0 || $this->type === 'gpl';
    }

    /**
     * Check if product is premium.
     */
    public function isPremium()
    {
        return $this->type === 'premium';
    }
}
