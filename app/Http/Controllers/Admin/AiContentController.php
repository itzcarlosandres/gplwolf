<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class AiContentController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Generar todo el contenido SEO
     */
    public function generateSeoContent(Request $request)
    {
        set_time_limit(120); // Aumentar tiempo de ejecución a 2 minutos

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_type' => 'required|in:theme,plugin',
            'features' => 'nullable|array',
            'keywords' => 'nullable|array',
        ]);

        try {
            $content = $this->geminiService->generateSeoContent(
                $validated['product_name'],
                $validated['product_type'],
                $validated['features'] ?? [],
                $validated['keywords'] ?? []
            );

            // Analizar SEO del contenido generado
            $seoScore = $this->analyzeSeoScore($content['full_description'], $validated['keywords'] ?? []);

            return response()->json([
                'success' => true,
                'content' => $content,
                'seo_score' => $seoScore,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar contenido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Analizar score SEO del contenido
     */
    protected function analyzeSeoScore($html, $keywords)
    {
        $score = [
            'total' => 0,
            'checks' => []
        ];

        // Check H1 (No debe haber H1 en la descripción, el título lo maneja la página)
        $h1Count = substr_count($html, '<h1>');
        $score['checks']['h1'] = [
            'passed' => $h1Count === 0,
            'message' => $h1Count === 0 ? 'Estructura correcta (Sin H1)' : 'El contenido no debe tener H1',
            'points' => $h1Count === 0 ? 20 : 0
        ];

        // Check H2 (al menos 2)
        $h2Count = substr_count($html, '<h2>');
        $score['checks']['h2'] = [
            'passed' => $h2Count >= 2,
            'message' => "Encontrados {$h2Count} H2",
            'points' => $h2Count >= 2 ? 15 : ($h2Count * 7)
        ];

        // Check longitud (400-600 palabras)
        $cleanText = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
        $wordCount = empty($cleanText) ? 0 : count(explode(' ', $cleanText));
        $score['checks']['length'] = [
            'passed' => $wordCount >= 400 && $wordCount <= 600,
            'message' => "{$wordCount} palabras",
            'points' => ($wordCount >= 400 && $wordCount <= 600) ? 20 : ($wordCount >= 300 ? 10 : 5)
        ];

        // Check keywords
        if (!empty($keywords)) {
            $keywordCount = 0;
            foreach ($keywords as $keyword) {
                $keywordCount += substr_count(strtolower($html), strtolower($keyword));
            }
            $density = $wordCount > 0 ? ($keywordCount / $wordCount) * 100 : 0;
            $score['checks']['keywords'] = [
                'passed' => $density >= 2 && $density <= 3,
                'message' => "Densidad: " . number_format($density, 2) . "%",
                'points' => ($density >= 2 && $density <= 3) ? 25 : ($density > 0 ? 10 : 0)
            ];
        } else {
            $score['checks']['keywords'] = [
                'passed' => true,
                'message' => "Sin keywords especificadas",
                'points' => 15
            ];
        }

        // Check listas
        $listsCount = substr_count($html, '<ul>') + substr_count($html, '<ol>');
        $score['checks']['lists'] = [
            'passed' => $listsCount >= 2,
            'message' => $listsCount >= 2 ? "{$listsCount} listas presentes" : 'Faltan listas',
            'points' => $listsCount >= 2 ? 10 : ($listsCount * 5)
        ];

        // Check strong tags
        $strongCount = substr_count($html, '<strong>');
        $score['checks']['emphasis'] = [
            'passed' => $strongCount >= 5 && $strongCount <= 10,
            'message' => "{$strongCount} palabras resaltadas",
            'points' => ($strongCount >= 5 && $strongCount <= 10) ? 10 : ($strongCount > 0 ? 5 : 0)
        ];

        // Calcular total
        $score['total'] = array_sum(array_column($score['checks'], 'points'));

        return $score;
    }
}