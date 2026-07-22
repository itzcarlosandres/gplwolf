<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConnectedSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LicenseController extends Controller
{
    /**
     * Activate a license or register a connected site.
     * This endpoint is called by the WordPress plugin.
     */
    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string', // User's API Key or License Key
            'domain' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid request parameters',
                'message' => $validator->errors()->first()
            ], 400);
        }

        // 1. Find User by API Key (assuming license_key acts as API key for now)
        // In a real scenario, you might map this to a specific purchase license.
        // For this demo/ MVP, we assume the user has a global API Key or we search for a specific license.
        
        // Let's assume we are verifying a Membership or a User Token
        // Adaptation: We check if there's a user with a matching "api_token" or similar, 
        // OR we just check a License model if you were using that.
        
        // SINCE USER SAID: "I don't sell licenses, just want to count sites"
        // We will assume the plugin sends a "User ID" + "Secret" OR just an "API Key" belonging to the user.
        
        // Let's search for a License matching the key
        $license = \App\Models\License::where('license_key', $request->license_key)->first();

        if (!$license) {
             return response()->json([
                'success' => false,
                'error' => 'invalid_license',
                'message' => 'Licencia no válida o no encontrada.'
            ], 404);
        }

        // 2. Check if User matches
        if (!$license->user) {
             return response()->json([
                'success' => false,
                'error' => 'invalid_user',
                'message' => 'Licencia no asociada a ningún usuario.'
            ], 404);
        }
        
        // 3. Check for Bans FIRST
        $existingSite = ConnectedSite::where('domain', $request->domain)->first();
        if ($existingSite && $existingSite->is_banned) {
             return response()->json([
                'success' => false,
                'error' => 'domain_banned',
                'message' => 'Este dominio ha sido bloqueado por el administrador.'
            ], 403);
        }

        // 4. Check for Site Limits based on Plan
        $user = $license->user;
        $activeMembership = $user->activeMembership;
        
        // Default limit if no membership (e.g. 1 free site)
        $limit = 1; 
        
        if ($activeMembership) {
            $limit = $activeMembership->plan->sites_limit;
        }

        // If limit is 0, it means UNLIMITED
        if ($limit > 0) {
            // Count current sites excluding the one trying to connect if it already exists
            $currentSites = ConnectedSite::where('user_id', $user->id)->count();
            
            // Allow if site already exists (re-activation)
            $isReactivation = ConnectedSite::where('user_id', $user->id)->where('domain', $request->domain)->exists();
            
            if (!$isReactivation && $currentSites >= $limit) {
                return response()->json([
                    'success' => false,
                    'error' => 'limit_reached',
                    'message' => "Has alcanzado el límite de {$limit} sitios para tu plan actual. Actualiza tu membresía."
                ], 403);
            }
        }

        // 5. Register or Update Connected Site
        // We check if this domain is already connected for this user/license
        $site = ConnectedSite::firstOrCreate(
            [
                'user_id' => $license->user_id,
                'domain' => $request->domain
            ],
            [
                'connected_at' => now(),
            ]
        );

        // 4. Update License Status (Optional based on your logic)
        // $license->activations_count++;
        // $license->save();

        return response()->json([
            'success' => true,
            'message' => 'Sitio conectado correctamente.',
            'site_id' => $site->id,
            'plan' => $license->user->activeMembership ? $license->user->activeMembership->plan->name : 'Free', // Send plan info if needed
        ]);
    }

    /**
     * Check for updates.
     */
    public function checkUpdate(Request $request)
    {
        // 1. Basic Validation
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string',
            'domain' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => 'invalid_request'], 400);
        }

        // 2. Security Check: Is this domain connected and valid?
        $site = ConnectedSite::where('domain', $request->domain)->first();

        // If site not found (disconnected) OR banned
        if (!$site || $site->is_banned) {
             return response()->json([
                'success' => false,
                'error' => 'site_not_authorized',
                'message' => 'Este sitio no está autorizado para recibir actualizaciones. Conéctalo nuevamente.'
            ], 403);
        }

        // 3. Optional: Verify License/User exist
        // Note: For speed, we trust ConnectedSite record as source of truth. 
        // If you want extra security, re-verify $site->user->hasActiveMembership() here.

        // 4. Return Data (Mockup for now, connected to real logic later)
        // You would normally look up the ProductVersion here based on 'product_id' sent by plugin
        // Assuming we are updating 'product_id' passed in request, OR a default one.
        
        $downloadUrl = route('api.license.download', [
            'license_key' => $request->license_key,
            'domain' => $request->domain,
            'version' => 'latest' // or specific version
        ]);

        return response()->json([
            'success' => true, 
            'version' => '1.0.0',
            'package' => $downloadUrl, // WordPress expects 'package' for the zip url
            'download_url' => $downloadUrl 
        ]);
    }

    /**
     * Secure Download Endpoint for Plugins
     */
    public function download(Request $request)
    {
         // 1. Validate
         if (!$request->has('license_key') || !$request->has('domain')) {
             abort(403, 'Missing credentials');
         }

         // 2. Security Check (Again)
         $site = ConnectedSite::where('domain', $request->domain)->first();
         if (!$site || $site->is_banned) {
             abort(403, 'Site not authorized');
         }

         // 3. Find Product/Version file
         // This is a mockup. In reality you fetch the ProductVersion file path.
         // Example: 
         // $version = ProductVersion::where(...)->first();
         // $filePath = $version->file_path;
         
         // For this demo, we can't serve a real file without a real product architecture link,
         // but this is where you would do:
         // return Storage::disk('public')->download($filePath);
         
    }
}