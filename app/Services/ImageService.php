<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        // Inicializamos el gestor si existe la clase
        if (class_exists('Intervention\Image\ImageManager')) {
            $this->manager = new ImageManager(new Driver());
        }
    }

    /**
     * Procesa, redimensiona y convierte una imagen a WebP (con fallback seguro).
     */
    public function optimizeAndSave(UploadedFile $file, string $folder, int $width = 800, int $quality = 80): string
    {
        // Generar nombre de archivo
        $filename = Str::uuid();

        // Si tenemos la librería, optimizamos
        if ($this->manager) {
            try {
                $image = $this->manager->read($file);

                if ($image->width() > $width) {
                    $image->scale(width: $width);
                }

                $encoded = $image->toWebp($quality);
                $filename .= '.webp';
                
                $uploadPath = storage_path('app/public/' . trim($folder, '/'));
                if (!file_exists($uploadPath)) mkdir($uploadPath, 0755, true);
                
                file_put_contents($uploadPath . '/' . $filename, (string) $encoded);
                return trim($folder, '/') . '/' . $filename;
            } catch (\Exception $e) {
                // Si falla la optimización, pasamos al modo manual
            }
        }

        // --- MODO FALLBACK SEGURO (Si no hay librería o falla) ---
        $filename .= '.' . $file->getClientOriginalExtension();
        $uploadPath = storage_path('app/public/' . trim($folder, '/'));
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        $file->move($uploadPath, $filename);
        return trim($folder, '/') . '/' . $filename;
    }
}