<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectFirstPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only process GET requests on frontend
        if ($request->isMethod('GET') && !$request->is('admin*') && !$request->is('api*')) {
            $page = $request->query('page');
            
            // If page is 1 or 0, redirect to clean URL without page parameter
            if ($page !== null && in_array((string) $page, ['1', '0', ''], true)) {
                $queryParams = $request->query();
                unset($queryParams['page']);

                $cleanUrl = $request->url();
                if (!empty($queryParams)) {
                    $cleanUrl .= '?' . http_build_query($queryParams);
                }

                return redirect($cleanUrl, 301);
            }
        }

        return $next($request);
    }
}
