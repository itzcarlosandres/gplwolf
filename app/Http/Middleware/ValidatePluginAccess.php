<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ValidatePluginAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No autenticado.',
                'code' => 'UNAUTHENTICATED'
            ], 401);
        }

        // 1. Quick Disconnect / Domain Check
        $tokenRecord = $user->currentAccessToken();
        if ($tokenRecord && Str::startsWith($tokenRecord->name, 'wp-plugin:')) {
            $domain = Str::replaceFirst('wp-plugin:', '', $tokenRecord->name);
            
            // Check if this domain is registered in the user's ConnectedSites
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

        // 2. Membership Status check
        $activeMembership = $user->activeMembership;
        if (!$activeMembership && !$user->isAdmin()) {
            // Check if user has ANY completed orders (maybe they bought a single product)
            $hasPurchases = $user->orders()->where('status', 'completed')->exists();
            if (!$hasPurchases) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requiere una membresía activa o compra para utilizar el plugin.',
                    'code' => 'MEMBERSHIP_INACTIVE'
                ], 403);
            }
        }

        return $next($request);
    }
}
