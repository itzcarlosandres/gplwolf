<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DownloadController extends Controller
{
    public function downloadVersion(\App\Models\ProductVersion $version)
    {
        $user = auth()->user();
        $product = $version->product;

        // 1. Check permissions (Same as normal download)
        if (!$user->hasPurchased($product->id)) {
            $activeMembership = $user->activeMembership;
            if (!$activeMembership) {
                return back()->with('error', 'Debes comprar el producto o tener una membresía activa.');
            }
            if ($product->category && $product->category->exclude_from_membership) {
                return back()->with('error', 'Este producto está excluido de las membresías.');
            }
            
            // Limit check (Simplified for specific version, counts as a download today)
            $limit = $activeMembership->plan->daily_download_limit;
            if ($limit > 0) {
                $distinctToday = Download::where('user_id', $user->id)
                    ->whereDate('downloaded_at', Carbon::today())
                    ->distinct('product_id')
                    ->count('product_id');
                
                // If this product wasn't downloaded today, check limit
                $alreadyDownloadedToday = Download::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->whereDate('downloaded_at', Carbon::today())
                    ->exists();

                if (!$alreadyDownloadedToday && $distinctToday >= $limit) {
                    return back()->with('error', 'Has alcanzado tu límite de productos diarios (' . $limit . ').');
                }
            }
        }

        return $this->processVersionDownload($version, $user);
    }

    protected function processVersionDownload(\App\Models\ProductVersion $version, $user)
    {
        $disk = config('filesystems.default');
        $fileToDownload = str_replace('\\', '/', $version->file_path);
        $fileToDownload = ltrim($fileToDownload, '/');
        $fileToDownload = preg_replace('/^(public\/|storage\/|app\/)/', '', $fileToDownload);
        $fileToDownload = ltrim($fileToDownload, '/');

        // Si es R2 o S3, redirigimos a la URL firmada (o pública) directamente
        // Esto evita el problema de que exists() falle falsamente
        if (in_array($disk, ['r2', 's3', 'bunnycdn'])) {
            $version->product->incrementDownloads();
            
            // Log download
            Download::create([
                'user_id' => $user->id,
                'product_id' => $version->product_id,
                'downloaded_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Generar URL temporal (1 hora) si es privado, o URL directa
            try {
                 return redirect(Storage::disk($disk)->temporaryUrl($fileToDownload, now()->addHour()));
            } catch (\Exception $e) {
                 // Si falla temporaryUrl (ej. driver no lo soporta), intentar url normal
                 return redirect(Storage::disk($disk)->url($fileToDownload));
            }
        }

        // Lógica para disco LOCAL (Public)
        if (!$fileToDownload || !Storage::disk('public')->exists($fileToDownload)) {
            \Log::error("Download Version Failed: File not found for version {$version->id} on disk public. Path: {$fileToDownload}");
            return back()->with('error', 'La versión seleccionada no tiene un archivo disponible en el servidor.');
        }

        // Log the download
        Download::create([
            'user_id' => $user->id,
            'product_id' => $version->product_id,
            'downloaded_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $version->product->incrementDownloads();

        return Storage::disk('public')->download($fileToDownload);
    }

    public function download(Request $request, Product $product)
    {
        $user = auth()->user();
        $fileType = $request->query('type', 'main');

        // 1. Check if user purchased the product
        $hasPurchased = $user->hasPurchased($product->id);

        if ($hasPurchased) {
            return $this->processDownload($product, $user, $fileType);
        }

        // 2. Check Membership Access
        $activeMembership = $user->activeMembership;

        if (!$activeMembership) {
            return back()->with('error', 'Debes comprar el producto o tener una membresía activa.');
        }

        // 3. Check Excluded Categories
        if ($product->category && $product->category->exclude_from_membership) {
            return back()->with('error', 'Este producto está excluido de las membresías.');
        }

        // 4. Check Daily Download Limit
        $limit = $activeMembership->plan->daily_download_limit;
        
        if ($limit > 0) {
            // How many times has THIS product been downloaded today?
            $thisProductToday = Download::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->whereDate('downloaded_at', Carbon::today())
                ->count();

            // If already downloaded, allow re-downloads up to 5 times (Fair Use)
            if ($thisProductToday > 0) {
                if ($thisProductToday >= 5) {
                    return back()->with('error', 'Has superado el límite de re-descargas para este archivo hoy (Máx 5). Intenta mañana.');
                }
                // Allow re-download without checking daily total limit
                return $this->processDownload($product, $user, $fileType);
            }

            // If it's a NEW product for today, check total daily limit
            $distinctToday = Download::where('user_id', $user->id)
                ->whereDate('downloaded_at', Carbon::today())
                ->distinct('product_id')
                ->count('product_id');

            if ($distinctToday >= $limit) {
                return back()->with('error', 'Has alcanzado tu límite de productos diarios (' . $limit . ').');
            }
        }

        return $this->processDownload($product, $user, $fileType);
    }

    protected function processDownload(Product $product, $user, string $fileType = 'main')
    {
        $disk = config('filesystems.default');
        $latestVersion = $product->latestVersion;
        
        // 1. Determine which file to download according to fileType
        if ($fileType === 'extra') {
            $fileToDownload = ($latestVersion && $latestVersion->update_package_file) 
                ? $latestVersion->update_package_file 
                : $product->update_package_file;

            if (empty($fileToDownload)) {
                return back()->with('error', 'El paquete de actualización o archivo adicional no está disponible para este producto.');
            }
        } else {
            $fileToDownload = ($latestVersion && $latestVersion->file_path) 
                ? $latestVersion->file_path 
                : $product->product_file;
        }

        // Limpieza profunda de rutas para R2 (Evita NoSuchKey)
        $fileToDownload = str_replace('\\', '/', $fileToDownload);
        $fileToDownload = ltrim($fileToDownload, '/');
        
        // Si la ruta guardada incluye 'public/' o 'storage/', lo quitamos porque en R2 la raíz suele empezar directo en 'products/'
        $fileToDownload = preg_replace('/^(public\/|storage\/|app\/)/', '', $fileToDownload);
        $fileToDownload = ltrim($fileToDownload, '/');

        // --- LÓGICA CLOUD (R2/S3) ---
        if (in_array($disk, ['r2', 's3', 'bunnycdn'])) {
            // Log download
            Download::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'downloaded_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $product->incrementDownloads();

            try {
                 return redirect(Storage::disk($disk)->temporaryUrl($fileToDownload, now()->addHour()));
            } catch (\Exception $e) {
                 return redirect(Storage::disk($disk)->url($fileToDownload));
            }
        }

        // --- LÓGICA LOCAL (Fallback) ---
        // Aqui siempre forzamos 'public' porque si fuera cloud habría entrado arriba
        if (!$fileToDownload || !Storage::disk('public')->exists($fileToDownload)) {
             // Fallback logic for local...
             if ($latestVersion && $product->product_file && $fileToDownload !== $product->product_file) {
                 $fileToDownload = str_replace('\\', '/', $product->product_file);
                 if (!Storage::disk('public')->exists($fileToDownload)) {
                    \Log::error("Download Failed: File not found for product {$product->id}. Path: {$fileToDownload}");
                    return back()->with('error', 'El archivo no se encuentra en el servidor. Contacta con soporte.');
                 }
            } else {
                \Log::error("Download Failed: No file path for product {$product->id}");
                return back()->with('error', 'El archivo no está disponible.');
            }
        }

        // Log the download
        Download::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'downloaded_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $product->incrementDownloads();

        return Storage::disk('public')->download($fileToDownload);
    }
}