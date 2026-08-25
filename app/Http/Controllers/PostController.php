<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('categoria');
        $tag      = $request->get('tag');
        $search   = $request->get('q');

        $query = Post::published()->latest('published_at');

        if ($category) {
            $query->byCategory($category);
        }

        if ($tag) {
            $query->whereJsonContains('tags', $tag);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $featuredId = null;
        $featured   = null;

        if (!$category && !$tag && !$search) {
            $featured   = Post::published()->featured()->latest('published_at')->first();
            $featuredId = optional($featured)->id ?? 0;
        }

        $posts      = $query->when($featuredId, fn($q) => $q->where('id', '!=', $featuredId))->paginate(9);
        $categories = Post::publishedCategories();

        $seoTitle       = \App\Models\Setting::where('key', 'blog_seo_title')->value('value') ?: 'Blog de WordPress, Plugins y Temas GPL — GPLWolf';
        $seoDescription = \App\Models\Setting::where('key', 'blog_seo_description')->value('value') ?: 'Explora los mejores tutoriales, guías y recursos sobre WordPress, plugins y temas GPL premium. Aprende a optimizar y acelerar tu sitio web paso a paso.';
        $seoKeywords    = \App\Models\Setting::where('key', 'blog_seo_keywords')->value('value') ?: 'blog wordpress, tutoriales wordpress, plugins premium gpl, temas wordpress, elementor pro, woocommerce tips';

        return view('blog.index', compact('posts', 'featured', 'categories', 'category', 'search', 'seoTitle', 'seoDescription', 'seoKeywords'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        // Increment views without touching updated_at
        $post->incrementViews();

        $related = $post->related(3);

        // Intelligent Product Matching for Lead Capture Widget
        $recommendedProduct = $this->findMatchingProduct($post);

        // Fetch 7-day Trial Plan
        $trialPlan = \App\Models\MembershipPlan::where('is_active', true)
            ->where(function ($q) {
                $q->where('slug', 'prueba-7-dias')
                  ->orWhere('duration', 'trial');
            })
            ->first();

        return view('blog.show', compact('post', 'related', 'recommendedProduct', 'trialPlan'));
    }

    /**
     * Find best matching product from catalogue based on post content/category/tags
     */
    protected function findMatchingProduct(Post $post): ?\App\Models\Product
    {
        $keywords = [];

        // Add tags
        if (!empty($post->tags_list)) {
            $keywords = array_merge($keywords, $post->tags_list);
        }

        // Add category
        if ($post->category) {
            $keywords[] = $post->category;
        }

        // Extract meaningful words from title
        $titleWords = preg_split('/[\s\-_,.:;!?()"\']+/u', $post->title);
        $stopWords = ['para', 'como', 'tutorial', 'guia', 'guía', 'mejores', 'top', 'que', 'con', 'sin', 'los', 'las', 'por', 'del', 'the', 'and', 'how', 'tips', 'paso', 'crear', 'usar', 'sitio', 'web', 'wordpress', 'plugin', 'tema', 'theme'];
        foreach ($titleWords as $word) {
            $w = mb_strtolower(trim($word));
            if (mb_strlen($w) >= 3 && !in_array($w, $stopWords)) {
                $keywords[] = $w;
            }
        }

        $keywords = array_unique(array_filter($keywords));

        if (!empty($keywords)) {
            $matched = \App\Models\Product::where('is_active', true)
                ->where(function ($q) use ($keywords) {
                    foreach ($keywords as $kw) {
                        $q->orWhere('name', 'like', "%{$kw}%")
                          ->orWhere('slug', 'like', "%{$kw}%")
                          ->orWhere('description', 'like', "%{$kw}%");
                    }
                })
                ->orderBy('downloads_count', 'desc')
                ->first();

            if ($matched) {
                return $matched;
            }
        }

        // Fallback: Popular or Featured Product
        return \App\Models\Product::where('is_active', true)
            ->where('is_popular', true)
            ->inRandomOrder()
            ->first()
            ?: \App\Models\Product::where('is_active', true)->orderBy('downloads_count', 'desc')->first();
    }
}
