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
        'update_package_file',
        'extra_file_name',
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

    /**
     * Get the file size in bytes dynamically or from latest version.
     */
    public function getFileSizeAttribute()
    {
        if (!$this->product_file) {
            return null;
        }

        // Try to get size from latest version first
        if ($this->latestVersion && $this->latestVersion->file_size) {
            return $this->latestVersion->file_size;
        }

        // If not, compute from storage and cache for 1 hour
        return cache()->remember('product_size_' . $this->id, 3600, function () {
            try {
                $disk = config('filesystems.default');
                $targetDisk = in_array($disk, ['r2', 's3', 'bunnycdn']) ? $disk : 'public';
                
                $path = str_replace('\\', '/', $this->product_file);
                $path = ltrim($path, '/');
                $path = preg_replace('/^(public\/|storage\/|app\/)/', '', $path);
                $path = ltrim($path, '/');

                if (\Illuminate\Support\Facades\Storage::disk($targetDisk)->exists($path)) {
                    return \Illuminate\Support\Facades\Storage::disk($targetDisk)->size($path);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Could not get file size for product {$this->id}: " . $e->getMessage());
            }
            return null;
        });
    }

    /**
     * Get formatted size label for the frontend.
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        if (!$bytes) {
            return 'Archivo .ZIP';
        }

        if ($bytes >= 1073741824) {
            $size = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $size = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $size = number_format($bytes / 1024, 2) . ' KB';
        } else {
            $size = $bytes . ' bytes';
        }

        return 'Tamaño: ' . $size;
    }

    /**
     * Determine if the product was genuinely updated to a new version (not just newly created).
     */
    public function isRecentlyUpdated(int $days = 5): bool
    {
        if (!$this->updated_at || !$this->created_at) {
            return false;
        }

        // A new product has created_at ≈ updated_at.
        // Product is only considered updated if updated_at is at least 10 minutes after created_at
        if (!$this->updated_at->gt($this->created_at->copy()->addMinutes(10))) {
            return false;
        }

        // Only mark as updated if updated_at is within the recent window (e.g. 5 days)
        return $this->updated_at->gt(now()->subDays($days));
    }

    /**
     * Get is_recently_updated attribute.
     */
    public function getIsRecentlyUpdatedAttribute(): bool
    {
        return $this->isRecentlyUpdated(5);
    }

    /**
     * Get all available download files for this product (main file and update package/extras).
     */
    public function getDownloadFiles(): array
    {
        $files = [];
        $latestVersion = $this->latestVersion;

        // 1. Archivo Principal (.ZIP)
        $mainPath = ($latestVersion && $latestVersion->file_path) ? $latestVersion->file_path : $this->product_file;
        if (!empty($mainPath)) {
            $files[] = [
                'type' => 'main',
                'title' => 'Archivo del Producto (.ZIP)',
                'subtitle' => 'Paquete completo del recurso v' . ($this->version ?? '1.0.0'),
                'icon' => 'fa-box-open',
                'badge' => 'Archivo Principal',
                'badge_color' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
                'download_url' => route('product.download', ['product' => $this->id, 'type' => 'main']),
            ];
        }

        // 2. Paquete de Actualización / Archivo Secundario (.ZIP)
        $extraPath = ($latestVersion && $latestVersion->update_package_file) ? $latestVersion->update_package_file : $this->update_package_file;
        $extraName = ($latestVersion && $latestVersion->extra_file_name) ? $latestVersion->extra_file_name : ($this->extra_file_name ?: 'Paquete de Actualización (.ZIP)');

        if (!empty($extraPath)) {
            $files[] = [
                'type' => 'extra',
                'title' => $extraName,
                'subtitle' => 'Archivos de actualización / Complementos adicionales v' . ($this->version ?? '1.0.0'),
                'icon' => 'fa-file-zipper',
                'badge' => 'Paquete Adicional',
                'badge_color' => 'bg-amber-500/15 text-amber-400 border-amber-500/30',
                'download_url' => route('product.download', ['product' => $this->id, 'type' => 'extra']),
            ];
        }

        return $files;
    }

    /**
     * Check if product has multiple download files available.
     */
    public function hasMultipleFiles(): bool
    {
        return count($this->getDownloadFiles()) > 1;
    }
}

