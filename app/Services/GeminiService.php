<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl;
    protected $enabled;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->apiUrl = config('services.gemini.api_url');
        $this->enabled = config('services.gemini.enabled', true);
    }

    /**
     * Generar todo el contenido SEO de una vez (Optimizado con Http::pool)
     */
    public function generateSeoContent($productName, $productType, $features = [], $keywords = [])
    {
        if (!$this->enabled || !$this->apiKey) {
            throw new \Exception('Gemini AI no está configurado. Por favor agrega tu API key en el archivo .env');
        }

        // Preparar prompts
        $shortPrompt = $this->buildShortDescriptionPrompt($productName, $productType, $keywords);
        $htmlPrompt = $this->buildSeoHtmlPrompt($productName, $productType, $features, $keywords);
        $metaDescPrompt = $this->buildMetaDescriptionPrompt($productName, $productType, $keywords);
        $metaKeysPrompt = $this->buildMetaKeywordsPrompt($productName, $productType, $keywords);
        
        // Ejecutar llamadas en paralelo
        $responses = Http::pool(fn ($pool) => [
            $pool->as('short')->timeout(120)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($shortPrompt, 500)),
            $pool->as('html')->timeout(120)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($htmlPrompt, 3000)),
            $pool->as('meta_desc')->timeout(120)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($metaDescPrompt, 300)),
            $pool->as('meta_keys')->timeout(120)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($metaKeysPrompt, 300)),
        ]);

        // Procesar resultados
        return [
            'short_description' => $this->parseResponse($responses['short']),
            'full_description' => $this->parseResponse($responses['html']),
            'meta_description' => $this->parseResponse($responses['meta_desc']),
            'meta_keywords' => $this->parseResponse($responses['meta_keys']),
            'slug' => $this->generateSeoSlug($productName),
        ];
    }
    
    protected function buildPayload($prompt, $maxTokens = 2048) {
        return [
            'contents' => [['parts' => [['text' => $prompt]]]],
            'generationConfig' => [
                'temperature' => 0.8,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => $maxTokens,
            ]
        ];
    }
    
    protected function parseResponse($response) {
        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            $text = trim($text);
            $text = trim($text, '"\'');
            $text = preg_replace('/^```html\s*/i', '', $text);
            $text = preg_replace('/\s*```$/i', '', $text);
            
            return $text;
        }

        $errorMsg = 'API Error';
        try {
            $data = $response->json();
            if (isset($data['error']['message'])) {
                $errorMsg = $data['error']['message'];
            } else {
                $errorMsg = $response->body();
            }
        } catch (\Exception $e) {
            $errorMsg = $response->body() ?: $e->getMessage();
        }

        throw new \Exception("Error de la API de Gemini: " . $errorMsg);
    }

    /**
     * Generar slug SEO-friendly
     */
    public function generateSeoSlug($productName)
    {
        return Str::slug($productName);
    }

    /**
     * Construir prompt para descripción corta
     */
    protected function buildShortDescriptionPrompt($productName, $productType, $keywords)
    {
        $keywordsStr = !empty($keywords) ? implode(', ', $keywords) : '';
        $typeEs = $productType === 'theme' ? 'tema' : 'plugin';
        
        return <<<PROMPT
Eres un experto en marketing de productos WordPress.
Genera una descripción corta y atractiva (máximo 150 caracteres) para un {$typeEs} de WordPress llamado "{$productName}".

KEYWORDS: {$keywordsStr}

La descripción debe:
- Ser concisa y directa (máximo 150 caracteres)
- Destacar el beneficio principal
- Usar lenguaje profesional en español
- Incluir keyword principal si es posible
- No incluir emojis ni caracteres especiales

DEVUELVE SOLO LA DESCRIPCIÓN, SIN COMILLAS NI EXPLICACIONES.
PROMPT;
    }

    /**
     * Construir prompt para HTML SEO optimizado
     */
    protected function buildSeoHtmlPrompt($productName, $productType, $features, $keywords)
    {
        // Auto-generate keywords from product name if not provided
        if (empty($keywords)) {
            $keywords = $this->extractKeywordsFromName($productName, $productType);
        }
        
        $keywordsStr = implode(', ', $keywords);
        $featuresStr = !empty($features) ? implode(', ', $features) : 'diseño moderno, fácil de usar, responsive';
        
        $typeEs = $productType === 'theme' ? 'tema' : 'plugin';
        
        return <<<PROMPT
Genera HTML SEO para {$typeEs} WordPress: "{$productName}"

Keywords: {$keywordsStr}
Características: {$featuresStr}

ESTRUCTURA (300-400 palabras):
1. NO uses tag <h1>. Comienza con <p> intro 100 palabras
2. <h2>Características</h2> + <ul> 5 items
3. <h2>Beneficios</h2> + <ul> 4 items  
4. <h3>¿Para quién?</h3> + <p> 50 palabras
5. <h2>Por qué elegir</h2> + <p> 80 palabras

Usa <strong> 7 veces, <em> 2 veces. Solo HTML limpio, sin CSS, sin markdown.
PROMPT;
    }

    /**
     * Extract keywords from product name
     */
    protected function extractKeywordsFromName($productName, $productType)
    {
        $keywords = [];
        
        // Add product name
        $keywords[] = strtolower($productName);
        
        // Add type
        $keywords[] = $productType === 'theme' ? 'tema wordpress' : 'plugin wordpress';
        
        // Add common keywords
        $keywords[] = 'wordpress';
        $keywords[] = 'premium';
        
        // Extract words from product name
        $words = preg_split('/[\s\-_]+/', strtolower($productName));
        foreach ($words as $word) {
            if (strlen($word) > 3 && !in_array($word, ['para', 'con', 'sin', 'the', 'and'])) {
                $keywords[] = $word;
            }
        }
        
        return array_unique(array_slice($keywords, 0, 8));
    }

    /**
     * Construir prompt para meta description
     */
    protected function buildMetaDescriptionPrompt($productName, $productType, $keywords)
    {
        $keywordsStr = !empty($keywords) ? implode(', ', $keywords) : 'wordpress, premium';
        $typeEs = $productType === 'theme' ? 'tema' : 'plugin';
        
        return <<<PROMPT
Genera una meta description SEO para un {$typeEs} de WordPress llamado "{$productName}".

KEYWORDS: {$keywordsStr}

REQUISITOS:
- Exactamente 150-160 caracteres
- Incluir keyword principal al inicio
- Incluir llamada a la acción
- Persuasivo y atractivo
- En español
- Sin emojis

DEVUELVE SOLO LA META DESCRIPTION, SIN COMILLAS NI EXPLICACIONES.
PROMPT;
    }

    /**
     * Construir prompt para meta keywords
     */
    protected function buildMetaKeywordsPrompt($productName, $productType, $keywords)
    {
        $keywordsStr = !empty($keywords) ? implode(', ', $keywords) : 'wordpress';
        $typeEs = $productType === 'theme' ? 'tema' : 'plugin';
        
        return <<<PROMPT
Genera 8-10 meta keywords SEO para un {$typeEs} de WordPress llamado "{$productName}".

KEYWORDS BASE: {$keywordsStr}

REQUISITOS:
- Incluir keywords base
- Agregar variaciones y sinónimos
- Incluir long-tail keywords
- Relevantes para WordPress
- En español
- Separadas por comas

DEVUELVE SOLO LAS KEYWORDS SEPARADAS POR COMAS, SIN EXPLICACIONES.
PROMPT;
    }

    /**
     * Llamada a la API de Gemini
     */
    protected function callGeminiAPI($prompt)
    {
        try {
            $response = Http::timeout(120) // Increased timeout to 120s
                ->withoutVerifying()
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl . '?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.8,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 2500, // Optimized for speed/length balance
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                $text = trim($text);
                $text = trim($text, '"\'');
                $text = preg_replace('/^```html\s*/i', '', $text);
                $text = preg_replace('/\s*```$/i', '', $text);
                
                return $text;
            }

            // Log detailed error
            Log::error('Gemini API Error Status: ' . $response->status());
            Log::error('Gemini API Error Body: ' . $response->body());
            
            throw new \Exception('Error en la API de Gemini: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            throw $e;
        }
    }
}