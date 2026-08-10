<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class UpdateManagerController extends Controller
{
    public function index()
    {
        $pendingRequests = \App\Models\UpdateRequest::where('status', 'pending')
            ->with(['product.category'])
            ->get()
            ->groupBy('product_id')
            ->map(function($group) {
                $product = $group->first()->product;
                if ($product) {
                    $product->requests_count = $group->count();
                }
                return $product;
            })
            ->filter()
            ->values();

        $recentProducts = Product::with('category')
            ->where('is_active', true)
            ->latest('updated_at')
            ->take(6)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'version' => $product->version,
                    'category' => $product->category->name ?? 'General',
                    'image' => $product->thumbnail ? asset('storage/' . $product->thumbnail) : null,
                ];
            });

        return view('admin.updates.manager', compact('pendingRequests', 'recentProducts'));
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            
            $products = Product::where('name', 'like', "%{$query}%")
                ->select('id', 'name', 'version', 'thumbnail', 'category_id')
                ->with('category')
                ->limit(10)
                ->get()
                ->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'version' => $product->version,
                        'category' => $product->category->name ?? 'General',
                        'image' => $product->thumbnail ? asset('storage/' . $product->thumbnail) : null,
                    ];
                });

            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'version_number' => 'required|string|max:50',
                'released_at' => 'required|date',
                'version_file' => 'required|max:512000',
                'changelog' => 'nullable|string'
            ]);

            $file = $request->file('version_file');

            $product = Product::findOrFail($request->product_id);

            // Determine Disk
            $disk = config('filesystems.default');
            $targetDisk = in_array($disk, ['r2', 's3', 'bunnycdn']) ? $disk : 'public';

            // Generate filename manually
            $filename = Str::random(40) . '.zip';
            $path = 'products/versions/' . $filename;

            // Upload File using stream to avoid memory issues with large files
            $stream = fopen($file->getRealPath(), 'r+');
            Storage::disk($targetDisk)->writeStream($path, $stream);
            fclose($stream);
            
            // Create Version Record
            ProductVersion::create([
                'product_id' => $product->id,
                'version_number' => $request->version_number,
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'changelog' => $request->changelog,
                'released_at' => $request->released_at
            ]);

            // Update Main Product
            $oldVersion = $product->version;
            $product->update([
                'version' => $request->version_number,
                'product_file' => $path
            ]);

            // Notifications logic (Safe wrapped)
            if ($oldVersion !== $request->version_number) {
                 try {
                     \App\Models\Notification::createForProductUpdate($product, $oldVersion, $request->version_number);
                 } catch (\Exception $ne) {
                     Log::warning('Notification creation failed: ' . $ne->getMessage());
                 }
            }

            return response()->json([
                'success' => true,
                'message' => 'Versión publicada y notificaciones enviadas.'
            ]);
        } catch (\Exception $e) {
            Log::error('Update Upload Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}