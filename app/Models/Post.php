<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'thumbnail',
        'author_id',
        'category',
        'tags',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views_count',
        'reading_time',
        'featured',
    ];

    protected $casts = [
        'tags'         => 'array',
        'published_at' => 'datetime',
        'featured'     => 'boolean',
    ];

    // ── Relationships ─────────────────────────────────
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // ── Scopes ────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // ── Accessors ─────────────────────────────────────

    /**
     * Calculate estimated reading time in minutes from body HTML.
     */
    public function getReadingTimeAttribute(): int
    {
        if (!empty($this->attributes['reading_time'])) {
            return (int) $this->attributes['reading_time'];
        }

        $wordCount = str_word_count(strip_tags($this->body ?? ''));
        return max(1, (int) ceil($wordCount / 200));
    }

    /**
     * Return the SEO title (custom or fallback to post title).
     */
    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    /**
     * Return the SEO description (custom or fallback to excerpt).
     */
    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description ?: ($this->excerpt ?? '');
    }

    /**
     * Return the thumbnail URL (local storage).
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail) return null;
        return asset('storage/' . $this->thumbnail);
    }

    /**
     * Return tags as array always (handles null).
     */
    public function getTagsListAttribute(): array
    {
        return $this->tags ?? [];
    }

    // ── Boot ──────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title on create
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
            // Calculate reading time
            if (empty($post->reading_time) && $post->body) {
                $wordCount = str_word_count(strip_tags($post->body));
                $post->reading_time = max(1, (int) ceil($wordCount / 200));
            }
        });

        // Recalculate reading time on update
        static::updating(function ($post) {
            if ($post->isDirty('body') && $post->body) {
                $wordCount = str_word_count(strip_tags($post->body));
                $post->reading_time = max(1, (int) ceil($wordCount / 200));
            }
        });
    }

    // ── Helpers ───────────────────────────────────────
    public static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::withTrashed()->where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Increment views without touching updated_at.
     */
    public function incrementViews(): void
    {
        \DB::table('posts')->where('id', $this->id)->increment('views_count');
    }

    /**
     * Get related posts by same category.
     */
    public function related(int $limit = 3)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where('category', $this->category)
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * All unique categories that have published posts.
     */
    public static function publishedCategories(): array
    {
        return static::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values()
            ->toArray();
    }
}
