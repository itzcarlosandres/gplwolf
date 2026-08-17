<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['latestVersion', 'category']);
        
        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $products = $query->latest()->paginate(15);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function checkDuplicate(Request $request)
    {
        $name = $request->query('name');
        if (!$name) {
            return response()->json(['exists' => false]);
        }

        $slug = Str::slug($name);
        $exists = Product::where('name', $name)
            ->orWhere('slug', $slug)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request, ImageService $imageService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'full_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:theme,plugin,gpl,premium',
            'price' => 'required|numeric|min:0',
            'demo_url' => 'nullable|url',
            'thumbnail' => 'nullable|file|max:10240',
            'product_file' => 'nullable|max:512000',
            'version' => 'required|string|max:50',
            'is_active' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_popular' => 'boolean',
            'is_license' => 'boolean',
            'badge' => 'nullable|string|max:50',
            'reward_points' => 'nullable|integer|min:0',
            'points_multiplier' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
        ]);
        
        // Handle thumbnail upload optimized
        if ($request->hasFile('thumbnail')) {
            try {
                $validated['thumbnail'] = $imageService->optimizeAndSave(
                    $request->file('thumbnail'), 
                    'products/thumbnails'
                );
            } catch (\Exception $e) {
                // Fallback manual sin fileinfo
                $file = $request->file('thumbnail');
                $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = storage_path('app/public/products/thumbnails');
                $file->move($destinationPath, $filename);
                $validated['thumbnail'] = 'products/thumbnails/' . $filename;
            }
        }
        
        // Handle product file upload (Standard or Chunked)
        if ($request->filled('uploaded_file_path')) {
             // Case 1: File pre-uploaded via chunks
             $validated['product_file'] = $request->input('uploaded_file_path');
        } elseif ($request->hasFile('product_file')) {
             // Case 2: Standard small file upload
            $file = $request->file('product_file');
            $disk = config('filesystems.default');
            $targetDisk = in_array($disk, ['r2', 's3', 'bunnycdn']) ? $disk : 'public';
            
            Log::info("Attempting R2 upload (Standard)", [
                'disk' => $targetDisk,
                'original' => $file->getClientOriginalName()
            ]);

            $path = Storage::disk($targetDisk)->putFile('products/files', $file);
            
            if ($path) {
                Log::info("R2 upload successful", ['path' => $path]);
                $validated['product_file'] = $path;
            } else {
                Log::error("R2 upload failed", ['disk' => $targetDisk]);
            }
        }
        
        // Generate unique slug logic
        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        } else {
            $originalSlug = Str::slug($validated['name']);
            $slug = $originalSlug;
            $count = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
        }
        
        $product = Product::create($validated);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'versions', 'downloads', 'licenses', 'orderItems']);
        
        // Productos relacionados vacíos para evitar errores en la vista
        $relatedProducts = collect();
        
        return view('admin.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product, ImageService $imageService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'full_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:theme,plugin,gpl,premium',
            'price' => 'required|numeric|min:0',
            'demo_url' => 'nullable|url',
            'thumbnail' => 'nullable|file|max:10240',
            'product_file' => 'nullable|max:512000',
            'version' => 'required|string|max:50',
            'is_active' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_popular' => 'boolean',
            'is_license' => 'boolean',
            'badge' => 'nullable|string|max:50',
            'reward_points' => 'nullable|integer|min:0',
            'points_multiplier' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
        ]);
        
        // Handle thumbnail upload optimized
        if ($request->hasFile('thumbnail')) {
            // Eliminar imagen anterior si existe
            if ($product->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->thumbnail)) {
                // Opcional: Eliminar la vieja. Lo dejo comentado por seguridad.
                // \Illuminate\Support\Facades\Storage::disk('public')->delete($product->thumbnail);
            }

            try {
                $validated['thumbnail'] = $imageService->optimizeAndSave(
                    $request->file('thumbnail'), 
                    'products/thumbnails'
                );
            } catch (\Exception $e) {
                 // Fallback manual sin fileinfo
                 $file = $request->file('thumbnail');
                 $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
                 $destinationPath = storage_path('app/public/products/thumbnails');
                 $file->move($destinationPath, $filename);
                 $validated['thumbnail'] = 'products/thumbnails/' . $filename;
            }
        }
        
        // Handle product file upload
        if ($request->filled('uploaded_file_path')) {
             // Case 1: File pre-uploaded via chunks
             $validated['product_file'] = $request->input('uploaded_file_path');
        } elseif ($request->hasFile('product_file')) {
            $file = $request->file('product_file');
            $disk = config('filesystems.default');
            $targetDisk = in_array($disk, ['r2', 's3', 'bunnycdn']) ? $disk : 'public';
            
            // Subir y obtener la ruta real generada por Laravel
            $path = Storage::disk($targetDisk)->putFile('products/files', $file);
            
            if ($path) {
                // No eliminamos el archivo anterior para mantener el historial de versiones en ProductVersion
                $validated['product_file'] = $path;
            }
        }
        
        // Update slug logic
        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        } elseif ($validated['name'] !== $product->name) {
            // Only regenerate from name if name changed AND slug was not manually provided
             $originalSlug = Str::slug($validated['name']);
             $slug = $originalSlug;
             $count = 1;
             // Exclude current product from unique check
             while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                 $slug = $originalSlug . '-' . $count++;
             }
             $validated['slug'] = $slug;
        }
        
        // Detectar cambio de versión para crear notificaciones
        $oldVersion = $product->version;
        $newVersion = $validated['version'] ?? $oldVersion;
        $versionChanged = $oldVersion !== $newVersion;
        
        $product->update($validated);
        
        // Crear notificaciones si cambió la versión
        if ($versionChanged) {
            \App\Models\Notification::createForProductUpdate($product, $oldVersion, $newVersion);
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente.' . ($versionChanged ? ' Notificaciones enviadas a los clientes.' : ''));
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
    
    public function addVersion(Request $request, Product $product)
    {
        $validated = $request->validate([
            'version_number' => 'required|string|max:50',
            'changelog' => 'nullable|string',
            'version_file' => 'required|max:512000', // Validation relaxed
            'released_at' => 'required|date',
        ]);
        
        // Backup current version if it doesn't exist in history to prevent file loss
        if ($product->product_file && !ProductVersion::where('product_id', $product->id)->where('version_number', $product->version)->exists()) {
             $disk = config('filesystems.default');
             $targetDisk = in_array($disk, ['r2', 's3', 'bunnycdn']) ? $disk : 'public';
             
             $size = 0;
             try {
                if (Storage::disk($targetDisk)->exists($product->product_file)) {
                    $size = Storage::disk($targetDisk)->size($product->product_file);
                }
             } catch (\Exception $e) {}

             ProductVersion::create([
                'product_id' => $product->id,
                'version_number' => $product->version,
                'changelog' => 'Versión anterior preservada automáticamente',
                'file_path' => $product->product_file,
                'file_size' => $size,
                'released_at' => $product->updated_at ?? now(),
             ]);
        }
        
        // Handle file upload
        if ($request->hasFile('version_file')) {
            $file = $request->file('version_file');
            $disk = config('filesystems.default');
            $targetDisk = in_array($disk, ['r2', 's3', 'bunnycdn']) ? $disk : 'public';

            $path = Storage::disk($targetDisk)->putFile('products/versions', $file);
            
            $validated['file_path'] = $path;
            $validated['file_size'] = $file->getSize();
        }
        
        $validated['product_id'] = $product->id;
        
        ProductVersion::create($validated);
        
        // Update product main version and main file
        $oldVersion = $product->version;
        $newVersion = $validated['version_number'];
        
        $product->update([
            'version' => $newVersion,
            'product_file' => $validated['file_path']
        ]);

        // Send notifications to buyers
        if ($oldVersion !== $newVersion) {
            \App\Models\Notification::createForProductUpdate($product, $oldVersion, $newVersion);
        }
        
        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Nueva versión agregada exitosamente.');
    }

    /**
     * Handle Chunked Uploads via Resumable.js
     */
    public function uploadChunk(Request $request)
    {
        $receiver = new \Illuminate\Http\UploadedFile(
            $request->file('file')->getPathname(),
            $request->file('file')->getClientOriginalName(),
            $request->file('file')->getClientMimeType(),
            $request->file('file')->getError(),
            true
        );

        $identifier = $request->resumableIdentifier;
        $chunkNumber = $request->resumableChunkNumber;
        $totalChunks = $request->resumableTotalChunks;
        $filename = $request->resumableFilename;

        // Temp storage path
        $chunkDir = storage_path('app/chunks/' . $identifier);
        
        if (!File::isDirectory($chunkDir)) {
            File::makeDirectory($chunkDir, 0777, true, true);
        }

        // Move the chunk
        $request->file('file')->move($chunkDir, $chunkNumber);

        // Check if all chunks are uploaded
        $allChunksUploaded = true;
        for ($i = 1; $i <= $totalChunks; $i++) {
            if (!File::exists($chunkDir . '/' . $i)) {
                $allChunksUploaded = false;
                break;
            }
        }

        if ($allChunksUploaded) {
            return $this->mergeChunks($identifier, $filename, $totalChunks);
        }

        return response()->json(['message' => 'Chunk uploaded']);
    }

    /**
     * Merge chunks into final file
     */
    protected function mergeChunks($identifier, $filename, $totalChunks)
    {
        $chunkDir = storage_path('app/chunks/' . $identifier);
        $finalPath = storage_path('app/public/temp/' . $filename);
        
        // Ensure temp public dir exists
        if (!File::isDirectory(dirname($finalPath))) {
            File::makeDirectory(dirname($finalPath), 0777, true, true);
        }

        // Create output file
        $outFile = fopen($finalPath, 'wb');

        for ($i = 1; $i <= $totalChunks; $i++) {
            $chunkPath = $chunkDir . '/' . $i;
            $chunk = fopen($chunkPath, 'rb');
            stream_copy_to_stream($chunk, $outFile);
            fclose($chunk);
            unlink($chunkPath); // Delete chunk
        }

        fclose($outFile);
        rmdir($chunkDir); // Remove chunk dir

        // Now move to final destination (R2/S3 coverage)
        $disk = config('filesystems.default');
        $targetDisk = in_array($disk, ['r2', 's3', 'bunnycdn']) ? $disk : 'public';
        
        $finalFilename = 'products/files/' . Str::random(40) . '.' . pathinfo($filename, PATHINFO_EXTENSION);
        
        if ($targetDisk !== 'public') {
            // Upload to Cloud
            $stream = fopen($finalPath, 'r+');
            Storage::disk($targetDisk)->writeStream($finalFilename, $stream);
            fclose($stream);
            unlink($finalPath); // Delete local temp merged file
        } else {
            // Move to public storage properly
            $publicPath = 'products/files/' . basename($finalFilename);
            Storage::disk('public')->move('temp/' . $filename, $publicPath);
            $finalFilename = $publicPath;
        }

        return response()->json([
            'done' => true,
            'path' => $finalFilename,
            'url' => Storage::disk($targetDisk)->url($finalFilename)
        ]);
    }

    public function toggleBestSeller(Product $product)
    {
        $product->is_best_seller = !$product->is_best_seller;
        $product->save();

        $status = $product->is_best_seller ? 'marcado como Más Comprado 🔥' : 'quitado de Más Comprados';
        return redirect()->back()->with('success', "{$product->name} {$status}.");
    }

    public function togglePopular(Product $product)
    {
        $product->is_popular = !$product->is_popular;
        $product->save();

        $status = $product->is_popular ? 'marcado como Popular ⭐' : 'quitado de Populares';
        return redirect()->back()->with('success', "{$product->name} {$status}.");
    }
}