<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class SubmitUrlsToGoogle extends Command
{
    protected $signature = 'google:submit-urls {--limit=10}';
    protected $description = 'Submit product URLs to Google for indexing';

    public function handle()
    {
        $limit = $this->option('limit');
        
        // Get active products
        $products = Product::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();

        $this->info("📤 Enviando {$products->count()} URLs a Google...");
        
        $submitted = 0;
        $failed = 0;

        foreach ($products as $product) {
            $url = route('products.show', $product->slug);
            
            try {
                // Usar cURL para enviar a Google
                $this->submitToGoogle($url);
                $this->line("✅ {$url}");
                $submitted++;
                
                // Esperar 1 segundo entre requests para no saturar
                sleep(1);
                
            } catch (\Exception $e) {
                $this->error("❌ Error en {$url}: " . $e->getMessage());
                $failed++;
            }
        }

        $this->info("\n🎉 Proceso completado:");
        $this->info("✅ Enviadas: {$submitted}");
        if ($failed > 0) {
            $this->warn("❌ Fallidas: {$failed}");
        }
        
        $this->info("\n💡 Tip: Las URLs aparecerán en Google Search Console en 24-48 horas.");
        
        return 0;
    }

    private function submitToGoogle($url)
    {
        // Ping a Google usando el endpoint público
        $pingUrl = "https://www.google.com/ping?sitemap=" . urlencode($url);
        
        $ch = curl_init($pingUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new \Exception("HTTP {$httpCode}");
        }
        
        return true;
    }
}
