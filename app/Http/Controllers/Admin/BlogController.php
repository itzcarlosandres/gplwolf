<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    // ── Listing ────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $status   = $request->get('status');
        $category = $request->get('category');
        $search   = $request->get('q');

        $query = Post::withTrashed()->with('author')->latest();

        if ($status && $status !== 'all') {
            if ($status === 'trashed') {
                $query = Post::onlyTrashed()->with('author')->latest();
            } else {
                $query->whereNull('deleted_at')->where('status', $status);
            }
        } else {
            $query->whereNull('deleted_at');
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'drafts'    => Post::where('status', 'draft')->count(),
            'views'     => Post::sum('views_count'),
        ];

        $categories = Post::whereNotNull('category')->distinct()->pluck('category');

        $seoSettings = [
            'blog_seo_title'       => \App\Models\Setting::where('key', 'blog_seo_title')->value('value') ?: 'Blog de WordPress, Plugins y Temas GPL — GPLWolf',
            'blog_seo_description' => \App\Models\Setting::where('key', 'blog_seo_description')->value('value') ?: 'Explora los mejores tutoriales, guías y recursos sobre WordPress, plugins y temas GPL premium. Aprende a optimizar y acelerar tu sitio web paso a paso.',
            'blog_seo_keywords'    => \App\Models\Setting::where('key', 'blog_seo_keywords')->value('value') ?: 'blog wordpress, tutoriales wordpress, plugins premium gpl, temas wordpress, elementor pro, woocommerce tips',
        ];

        return view('admin.blog.index', compact('posts', 'stats', 'categories', 'status', 'category', 'search', 'seoSettings'));
    }

    // ── Update Blog SEO Settings ───────────────────────────────────────────
    public function updateSeoSettings(Request $request)
    {
        $validated = $request->validate([
            'blog_seo_title'       => 'required|string|max:80',
            'blog_seo_description' => 'required|string|max:180',
            'blog_seo_keywords'    => 'nullable|string|max:300',
        ]);

        foreach ($validated as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        return back()->with('success', 'Configuración SEO del Blog guardada correctamente.');
    }

    // ── Create ─────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.blog.create');
    }

    // ── Store ──────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|unique:posts,slug|max:255',
            'excerpt'          => 'nullable|string|max:500',
            'body'             => 'nullable|string',
            'thumbnail'        => 'nullable|image|max:4096',
            'category'         => 'nullable|string|max:100',
            'tags'             => 'nullable|string',
            'status'           => 'required|in:draft,published,scheduled',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords'    => 'nullable|string|max:255',
            'featured'         => 'nullable|boolean',
        ]);

        // Handle thumbnail upload (local public storage)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('blog/thumbnails', 'public');
        }

        // Parse tags
        $tags = null;
        if (!empty($validated['tags'])) {
            $tags = array_filter(array_map('trim', explode(',', $validated['tags'])));
        }

        // Auto-generate slug
        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Post::generateUniqueSlug($validated['title']);

        // Set published_at for published posts without a date
        $publishedAt = $validated['published_at'] ?? null;
        if ($validated['status'] === 'published' && !$publishedAt) {
            $publishedAt = now();
        }

        Post::create([
            'title'            => $validated['title'],
            'slug'             => $slug,
            'excerpt'          => $validated['excerpt'] ?? null,
            'body'             => $validated['body'] ?? null,
            'thumbnail'        => $thumbnailPath,
            'author_id'        => Auth::id(),
            'category'         => $validated['category'] ?? null,
            'tags'             => $tags,
            'status'           => $validated['status'],
            'published_at'     => $publishedAt,
            'meta_title'       => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords'    => $validated['meta_keywords'] ?? null,
            'featured'         => $request->boolean('featured'),
        ]);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Artículo creado exitosamente.');
    }

    // ── Edit ───────────────────────────────────────────────────────────────
    public function edit(Post $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    // ── Update ─────────────────────────────────────────────────────────────
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt'          => 'nullable|string|max:500',
            'body'             => 'nullable|string',
            'thumbnail'        => 'nullable|image|max:4096',
            'category'         => 'nullable|string|max:100',
            'tags'             => 'nullable|string',
            'status'           => 'required|in:draft,published,scheduled',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords'    => 'nullable|string|max:255',
            'featured'         => 'nullable|boolean',
        ]);

        // Handle thumbnail
        $thumbnailPath = $post->thumbnail;
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('blog/thumbnails', 'public');
        }

        // Parse tags
        $tags = $post->tags;
        if (isset($validated['tags'])) {
            $tags = array_filter(array_map('trim', explode(',', $validated['tags'])));
        }

        // Handle published_at
        $publishedAt = $validated['published_at'] ?? $post->published_at;
        if ($validated['status'] === 'published' && !$publishedAt) {
            $publishedAt = now();
        }

        $post->update([
            'title'            => $validated['title'],
            'slug'             => !empty($validated['slug']) ? Str::slug($validated['slug']) : $post->slug,
            'excerpt'          => $validated['excerpt'] ?? null,
            'body'             => $validated['body'] ?? null,
            'thumbnail'        => $thumbnailPath,
            'category'         => $validated['category'] ?? null,
            'tags'             => $tags,
            'status'           => $validated['status'],
            'published_at'     => $publishedAt,
            'meta_title'       => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords'    => $validated['meta_keywords'] ?? null,
            'featured'         => $request->boolean('featured'),
        ]);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Artículo actualizado exitosamente.');
    }

    // ── Publish toggle ─────────────────────────────────────────────────────
    public function publish(Post $post)
    {
        if ($post->status === 'published') {
            $post->update(['status' => 'draft', 'published_at' => null]);
            $message = 'Artículo despublicado.';
        } else {
            $post->update(['status' => 'published', 'published_at' => now()]);
            $message = 'Artículo publicado exitosamente.';
        }

        return back()->with('success', $message);
    }

    // ── Destroy ────────────────────────────────────────────────────────────
    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Artículo eliminado (puedes restaurarlo).');
    }

    // ── AI Generation (AJAX) ───────────────────────────────────────────────
    public function generateAiContent(Request $request)
    {
        set_time_limit(180);

        $validated = $request->validate([
            'topic'      => 'required|string|max:255',
            'keywords'   => 'nullable|string',
            'tone'       => 'nullable|in:informativo,tutorial,comparativa,opinion',
            'word_count' => 'nullable|integer|min:300|max:1500',
        ]);

        $keywords = !empty($validated['keywords'])
            ? array_filter(array_map('trim', explode(',', $validated['keywords'])))
            : [];

        try {
            $content = $this->gemini->generateBlogContent(
                topic:      $validated['topic'],
                keywords:   $keywords,
                tone:       $validated['tone'] ?? 'informativo',
                wordCount:  (int) ($validated['word_count'] ?? 800),
            );

            return response()->json([
                'success' => true,
                'content' => $content,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generando contenido: ' . $e->getMessage(),
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
