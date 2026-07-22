<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function stylesDemo()
    {
        // Fake posts for demo
        $posts = collect(range(1, 6))->map(function($i) {
            return (object)[
                'title' => 'El Futuro del Diseño Web en 2026: Tendencias Revolucionarias ' . $i,
                'excerpt' => 'Descubre las nuevas tecnologías de IA y diseño generativo que están cambiando la forma en que construimos la web. Un análisis profundo de lo que viene.',
                'slug' => 'demo-post-' . $i,
                'published_at' => now()->subDays($i),
                'author' => (object)['name' => 'Alex Design'],
                'image' => null // Placeholder in view
            ];
        });
        return view('posts.demo-styles', compact('posts'));
    }

    public function index()
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related posts (same author or recent)
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('user_id', $post->user_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // If not enough related posts, fill with recent ones
        if ($relatedPosts->count() < 3) {
            $additionalPosts = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();

            $relatedPosts = $relatedPosts->merge($additionalPosts);
        }

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
