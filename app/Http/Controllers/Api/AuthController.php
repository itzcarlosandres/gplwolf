<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Check if plugin feature is enabled
        $pluginEnabled = \App\Models\Setting::where('key', 'plugin_enabled')->value('value');
        
        if (!$pluginEnabled) {
            return response()->json([
                'success' => false,
                'message' => 'El plugin de WordPress está temporalmente deshabilitado. Por favor, contacta al administrador.',
                'code' => 'PLUGIN_DISABLED'
            ], 503);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'site_url' => 'required|url', // Domain Locking
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas.',
                'code' => 'INVALID_CREDENTIALS'
            ], 401);
        }


        // --- DOMAIN LOCKING LOGIC ---
        // Verificar si el usuario ya tiene este sitio registrado o si puede registrar uno nuevo
        $existingSite = $user->connectedSites()->where('domain', $request->site_url)->first();
        
        if (!$existingSite) {
            // Get site limit from active membership plan, fallback to global setting if no membership, or admin is bypass
            $activeMembership = $user->activeMembership;
            if ($activeMembership) {
                // If sites_limit is 0 in DB, it means unlimited
                $siteLimit = (int) $activeMembership->plan->sites_limit;
            } elseif ($user->isAdmin()) {
                $siteLimit = 0; // Unlimited for admin
            } else {
                // Fallback to global setting if user has no active membership (e.g. they only have manual purchases)
                $siteLimit = (int) \App\Models\Setting::where('key', 'plugin_site_limit')->value('value') ?: 1;
            }
            
            if ($siteLimit > 0 && $user->connectedSites()->count() >= $siteLimit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Has alcanzado el límite de sitios conectados (' . $siteLimit . '). Desconecta un sitio antiguo desde tu panel de usuario.',
                    'code' => 'SITE_LIMIT_REACHED'
                ], 403);
            }

            // Register new site
            $user->connectedSites()->create([
                'domain' => $request->site_url,
                'connected_at' => now(),
            ]);
        }

        // Generate Token associated with this domain claim
        // The token name acts as the claimed domain. We can use this later to verify the origin if needed.
        $tokenName = 'wp-plugin:' . $request->site_url;
        
        // Optionally delete old token for this same domain to cycle keys
        $user->tokens()->where('name', $tokenName)->delete();

        $token = $user->createToken($tokenName, ['marketplace:access'])->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $this->getUserStats($user),
            'site_registered' => true
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($this->getUserStats($request->user()));
    }

    private function getUserStats($user)
    {
        $activeMembership = $user->activeMembership;
        
        // Calculate daily downloads
        $downloadsToday = 0;
        $downloadLimit = 0;
        
        if ($activeMembership) {
             $downloadLimit = $activeMembership->plan->daily_download_limit;
             $downloadsToday = \App\Models\Download::where('user_id', $user->id)
                ->whereDate('downloaded_at', now()->today())
                ->distinct('product_id')
                ->count('product_id');
        }

        // Dynamic site limit calculation
        if ($activeMembership) {
            $sitesLimit = $activeMembership->plan->sites_limit > 0 ? $activeMembership->plan->sites_limit : 'Ilimitado';
        } elseif ($user->isAdmin()) {
            $sitesLimit = 'Ilimitado';
        } else {
            $sitesLimit = (int) \App\Models\Setting::where('key', 'plugin_site_limit')->value('value') ?: 1;
        }

        return [
            'name' => $user->name,
            'email' => $user->email,
            'points' => $user->points ?? 0,
            'plan' => $activeMembership ? $activeMembership->plan->name : 'Gratis',
            'plan_status' => $activeMembership ? 'Activo' : 'Inactivo',
            'expires_at' => $activeMembership ? ($activeMembership->expires_at ? $activeMembership->expires_at->format('Y-m-d') : 'Nunca') : '-',
            'downloads_today' => $downloadsToday,
            'downloads_limit' => $activeMembership ? ($downloadLimit > 0 ? $downloadLimit : 'Ilimitado') : 0,
            'avatar' => $user->profile_photo_url ?? null, // Assuming Jetstream or similar
            'sites_connected' => $user->connectedSites()->count(),
            'sites_limit' => $sitesLimit,
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada exitosamente.']);
    }
}