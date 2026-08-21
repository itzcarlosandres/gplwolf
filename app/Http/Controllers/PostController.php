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

        return view('blog.index', compact('posts', 'featured', 'categories', 'category', 'search'));
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
