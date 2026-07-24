<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Product::where('is_active', true)
            ->orderBy('updated_at', 'desc');

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        // Transform collection to include "can_download" status
        $products->getCollection()->transform(function ($product) use ($request) {
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'type' => $product->type,
                'category_name' => $product->category ? $product->category->name : null,
                'category_slug' => $product->category ? $product->category->slug : null,
                'version' => $product->version, // Current version on server
                'thumbnail' => $product->thumbnail ? asset('storage/' . $product->thumbnail) : null,
                'is_license' => (bool) $product->is_license,
                'is_new' => $product->created_at->gt(now()->subDays(15)),
                'can_download' => $request->user()->canDownload($product),
                'short_description' => \Illuminate\Support\Str::limit(strip_tags($product->description), 100),
            ];
        });

        return response()->json($products);
    }

    public function show($id)
    {
        $product = \App\Models\Product::where('is_active', true)->findOrFail($id);

        return response()->json([
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'type' => $product->type,
            'category_name' => $product->category ? $product->category->name : null,
            'category_slug' => $product->category ? $product->category->slug : null,
            'is_license' => (bool) $product->is_license,
            'is_new' => $product->created_at->gt(now()->subDays(15)),
            'description' => $product->description,
            'version' => $product->version,
            'can_download' => request()->user()->canDownload($product),
        ]);
    }

    public function download(Request $request, $id)
    {
        // Support token in query param or bearer header for WP Updater
        $tokenStr = $request->bearerToken() ?? $request->query('api_token');
        
        if ($tokenStr) {
            $token = \Laravel\Sanctum\PersonalAccessToken::findToken($tokenStr);
            if ($token && $token->tokenable) {
                // Manually authenticate user for this request scope
                \Illuminate\Support\Facades\Auth::login($token->tokenable);
                $request->setUserResolver(function () use ($token) {
                    return $token->tokenable;
                });
            }
        }

        $user = $request->user();
        
        if (!$user) {
             return response()->json(['success' => false, 'message' => 'Unauthenticated.', 'code' => 'UNAUTHENTICATED'], 401);
        }

        // Manually run ValidatePluginAccess logic (quick disconnect validation)
        $tokenRecord = $user->currentAccessToken();
        if ($tokenRecord && \Illuminate\Support\Str::startsWith($tokenRecord->name, 'wp-plugin:')) {
            $domain = \Illuminate\Support\Str::replaceFirst('wp-plugin:', '', $tokenRecord->name);
            $siteExists = $user->connectedSites()->where('domain', $domain)->exists();
            if (!$siteExists) {
                // Instantly revoke this token since it's disconnected/blocked
                $tokenRecord->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Este sitio ha sido desconectado o bloqueado por el administrador.',
                    'code' => 'SITE_DISCONNECTED'
                ], 403);
            }
        }

        $product = \App\Models\Product::where('is_active', true)->findOrFail($id);

        // 1. Verify Access Logic (Membership/Purchase)
        $activeMembership = $user->activeMembership;
        if ($activeMembership && !$user->hasPurchased($product->id)) {
            $limit = $activeMembership->plan->daily_download_limit + $activeMembership->extra_daily_downloads;
            if ($limit > 0) {
                // Count how many times THIS product has been downloaded today
                $thisProductToday = $user->downloads()
                    ->where('product_id', $product->id)
                    ->whereDate('downloaded_at', \Carbon\Carbon::today())
                    ->count();

                // If first time today, check total daily limit
                if ($thisProductToday === 0) {
                    $distinctToday = $user->downloads()
                        ->whereDate('downloaded_at', \Carbon\Carbon::today())
                        ->distinct('product_id')
                        ->count('product_id');
                        
                    if ($distinctToday >= $limit) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Límite de descargas diarias alcanzado (' . $limit . '/' . $limit . '). Tu cupo se restablece mañana.',
                            'code' => 'DOWNLOAD_LIMIT_REACHED'
                        ], 403);
                    }
                }
            }
        }

        if (!$user->canDownload($product)) {
            return response()->json([
                'success' => false, 
                'message' => 'No tienes permiso para descargar este producto. Adquiere una membresía o compra el producto.',
                'code' => 'FORBIDDEN'
            ], 403);
        }

        // 2. Validate Domain Locking (Security)
        // Ensure the token being used matches the domain it claims (if stored in token name)
        // or simply that the user has a valid connected site.
        // For strict locking, we'd check if the Referer/Origin matches the connected site, 
        // but since this is an API call from PHP (cURL), Referer might be spoofed or missing.
        // We rely on the unique Token generated for that site.
        if ($request->bearerToken()) {
            $tokenRecord = \Laravel\Sanctum\PersonalAccessToken::findToken($request->bearerToken());
            if ($tokenRecord && !$tokenRecord->can('marketplace:access')) {
                return response()->json([
                    'success' => false,
                    'message' => 'El token proporcionado no tiene permisos para acceder al marketplace.',
                    'code' => 'INVALID_TOKEN_SCOPE'
                ], 403);
            }
        }
        
        // 3. Determine File Path and Disk
        $disk = config('filesystems.default');
        $latestVersion = $product->latestVersion;
        $fileToDownload = ($latestVersion && $latestVersion->file_path) 
            ? $latestVersion->file_path 
            : $product->product_file;

        // Path Cleanup for R2/S3 consistency
        $fileToDownload = str_replace('\\', '/', $fileToDownload);
        $fileToDownload = ltrim($fileToDownload, '/');
        $fileToDownload = preg_replace('/^(public\/|storage\/|app\/)/', '', $fileToDownload);
        $fileToDownload = ltrim($fileToDownload, '/');

        // CLOUD LOGIC (R2 / S3 / Bunny)
        if (in_array($disk, ['r2', 's3', 'bunnycdn'])) {
             // Increment downloads & Log
            $product->incrementDownloads();
            $user->downloads()->create([
                'product_id' => $product->id,
                'downloaded_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            try {
                // Return Redirect URL (API Client should handle 302 or return URL string)
                $signedUrl = \Illuminate\Support\Facades\Storage::disk($disk)->temporaryUrl($fileToDownload, now()->addHour());
                
                // Fix: If client requests URL string (to avoid Header conflicts with R2), return JSON
                if ($request->has('get_url')) {
                    return response()->json(['url' => $signedUrl]);
                }

                return redirect()->away($signedUrl);

            } catch (\Exception $e) {
                 // Fallback
                 $publicUrl = \Illuminate\Support\Facades\Storage::disk($disk)->url($fileToDownload);
                 
                 if ($request->has('get_url')) {
                     return response()->json(['url' => $publicUrl]);
                 }
                 
                 return redirect()->away($publicUrl);
            }
        }

        // LOCAL LOGIC
        if (!$fileToDownload || !\Illuminate\Support\Facades\Storage::disk('public')->exists($fileToDownload)) {
            return response()->json([
                'success' => false, 
                'message' => 'Archivo no encontrado en el servidor (Local).',
                'code' => 'FILE_NOT_FOUND'
            ], 404);
        }

        // Increment downloads & Log
        $product->incrementDownloads();
        $user->downloads()->create([
            'product_id' => $product->id,
            'downloaded_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->has('get_url')) {
            $publicUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($fileToDownload);
            return response()->json(['url' => url($publicUrl)]); // Asegurar URL absoluta
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($fileToDownload);
    }

    public function checkUpdates(Request $request)
    {
        $plugins = $request->input('plugins', []);
        
        if (empty($plugins) || !is_array($plugins)) {
             return response()->json(['success' => true, 'updates' => []]);
        }

        $slugs = array_keys($plugins);
        
        $products = \App\Models\Product::whereIn('slug', $slugs)
            ->where('is_active', true)
            ->get();

        $updates = [];
        foreach ($products as $product) {
            $clientVersion = $plugins[$product->slug] ?? '0.0.0';
            
            if (version_compare($product->version, $clientVersion, '>')) {
                // Only serve update packages if user actually has permissions to download
                if ($request->user()->canDownload($product)) {
                    $token = $request->bearerToken() ?? $request->query('api_token');
                    $updates[$product->slug] = [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'new_version' => $product->version,
                        'package_url' => url("/api/v1/download/{$product->id}?api_token=" . $token), 
                        'requires' => $product->wordpress_version ?? '5.0',
                        'tested' => '6.4'
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'updates' => $updates
        ]);
    }
}