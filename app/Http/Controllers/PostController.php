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

        return view('blog.show', compact('post', 'related'));
    }
}
