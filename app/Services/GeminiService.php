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
     * Generar todo el contenido SEO de una vez (Ejecución secuencial con reintento para evitar límites de concurrencia)
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
        
        // Ejecutar llamadas de manera secuencial con reintentos para evitar picos de demanda/concurrencia
        $shortResponse = Http::timeout(120)->retry(3, 1000)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($shortPrompt, 500));
        $htmlResponse = Http::timeout(120)->retry(3, 1000)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($htmlPrompt, 5000));
        $metaDescResponse = Http::timeout(120)->retry(3, 1000)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($metaDescPrompt, 500));
        $metaKeysResponse = Http::timeout(120)->retry(3, 1000)->withoutVerifying()->post($this->apiUrl . '?key=' . $this->apiKey, $this->buildPayload($metaKeysPrompt, 500));

        // Procesar resultados
        return [
            'short_description' => $this->parseResponse($shortResponse),
            'full_description' => $this->parseResponse($htmlResponse),
            'meta_description' => $this->parseResponse($metaDescResponse),
            'meta_keywords' => $this->parseResponse($metaKeysResponse),
            'slug' => $this->generateSeoSlug($productName),
        ];
    }
    
    protected function buildPayload($prompt, $maxTokens = 2048) {
        return [
            'contents' => [['parts' => [['text' => $prompt]]]],
            'generationConfig' => [
                'temperature' => 0.4,
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
            
            // Extract content from markdown code block if present
            if (preg_match('/```[a-z]*\s*(.*?)\s*```/is', $text, $matches)) {
                $text = trim($matches[1]);
            } else {
                $text = preg_replace('/^```[a-z]*\s*/i', '', $text);
                $text = preg_replace('/\s*```$/i', '', $text);
            }
            
            // Trim standard and curly quotes that AI often wraps output in
            $text = trim($text, "\"'“”«»");
            
            // Fix double-encoded or encoded HTML entities (e.g. &lt;p&gt; -> <p>, &amp;oacute; -> ó)
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            
            // Remove leaked markdown formatting symbols
            $text = str_replace(['**', '__'], '', $text);
            
            // Remove markdown headers markers inside HTML if they leaked (e.g. <h2>## Title</h2>)
            $text = preg_replace('/(<h[1-6]>)\s*#+\s*/i', '$1', $text);
            $text = preg_replace('/\s*#+\s*(<\/h[1-6]>)/i', '$1', $text);
            
            // Remove markdown list bullet markers inside <li> if they leaked (e.g. <li>* Feature</li>)
            $text = preg_replace('/<li>\s*[\*\-\•]\s*/i', '<li>', $text);

            // Extract only the HTML content block if HTML tags are present
            if (stripos($text, '<p') !== false || stripos($text, '<h2') !== false || stripos($text, '<ul') !== false) {
                $firstTagPos = false;
                $tags = ['<p', '<h2', '<div', '<ul'];
                foreach ($tags as $tag) {
                    $pos = stripos($text, $tag);
                    if ($pos !== false && ($firstTagPos === false || $pos < $firstTagPos)) {
                        $firstTagPos = $pos;
                    }
                }
                
                $lastTagPos = false;
                $closingTags = ['</p>', '</h2>', '</h3>', '</ul>', '</div>'];
                foreach ($closingTags as $tag) {
                    $pos = strripos($text, $tag);
                    if ($pos !== false) {
                        $tagEnd = $pos + strlen($tag);
                        if ($lastTagPos === false || $tagEnd > $lastTagPos) {
                            $lastTagPos = $tagEnd;
                        }
                    }
                }
                
                if ($firstTagPos !== false && $lastTagPos !== false && $lastTagPos > $firstTagPos) {
                    $text = substr($text, $firstTagPos, $lastTagPos - $firstTagPos);
                }
            }
            
            return trim($text);
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

    protected function buildShortDescriptionPrompt($productName, $productType, $keywords)
    {
        $keywordsStr = !empty($keywords) ? implode(', ', $keywords) : '';
        $typeEs = $productType === 'theme' ? 'tema' : 'plugin';
        
        return <<<PROMPT
Eres un experto en marketing de productos WordPress.
Genera una descripción corta y atractiva (alrededor de 120 caracteres, máximo 150) para un {$typeEs} de WordPress llamado "{$productName}".

KEYWORDS: {$keywordsStr}

La descripción debe:
- Ser breve y directa (máximo 150 caracteres)
- Destacar el beneficio principal
- Usar lenguaje profesional en español
- Incluir keyword principal si es posible
- No incluir emojis ni caracteres especiales

DEVUELVE SOLO LA DESCRIPCIÓN, SIN COMILLAS NI EXPLICACIONES DE CONTEO.
PROMPT;
    }

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

ESTRUCTURA (un artículo completo y detallado de unas 500 palabras en total):
1. NO uses tag <h1>. Comienza con un párrafo <p> de introducción (aproximadamente de 130 palabras). Dentro de esta introducción, incluye OBLIGATORIAMENTE de manera literal y natural un enlace HTML utilizando la etiqueta exacta <a href="/products">catálogo de productos</a> o la etiqueta exacta <a href="/products">nuestra colección de temas y plugins</a>. Es sumamente crucial para el enlazado interno que la etiqueta <a> esté presente con href="/products".
2. <h2>Características</h2> + <ul> de al menos 5 a 7 items detallados.
3. <h2>Beneficios</h2> + <ul> de al menos 4 a 6 items detallados.
4. <h3>¿Para quién?</h3> + un párrafo <p> detallado.
5. <h2>Por qué elegir</h2> + un párrafo <p> detallado.

Usa la etiqueta <strong> para resaltar palabras clave importantes de forma natural (entre 5 y 10 veces en todo el texto) y la etiqueta <em> unas 2 veces. Solo HTML limpio, sin CSS, sin markdown.

IMPORTANTE: DEVUELVE ÚNICAMENTE EL CÓDIGO HTML DE LA ESTRUCTURA. NO realices conteos, no incluyas listas de verificación, no expliques cómo contaste las etiquetas ni agregues notas de validación al final. Comienza directamente con el tag <p> y termina con </p>.
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

    protected function buildMetaDescriptionPrompt($productName, $productType, $keywords)
    {
        $keywordsStr = !empty($keywords) ? implode(', ', $keywords) : 'wordpress, premium';
        $typeEs = $productType === 'theme' ? 'tema' : 'plugin';
        
        return <<<PROMPT
Genera una meta description SEO para un {$typeEs} de WordPress llamado "{$productName}".

KEYWORDS: {$keywordsStr}

REQUISITOS:
- Longitud adecuada para meta descripción (alrededor de 150 caracteres, máximo 160)
- Incluir keyword principal al inicio
- Incluir llamada a la acción
- Persuasivo y atractivo
- En español
- Sin emojis

DEVUELVE SOLO LA META DESCRIPTION, SIN COMILLAS NI EXPLICACIONES DE CONTEO.
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
                        'temperature' => 0.4,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 5000, // Optimized for speed/length balance
                    ]
                ]);

            if ($response->successful()) {
                return $this->parseResponse($response);
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