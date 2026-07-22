<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ConnectedSite;
use Illuminate\Http\Request;

class ConnectedSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if plugin feature is enabled
        $pluginShowMenu = \App\Models\Setting::where('key', 'plugin_show_menu')->value('value');
        
        if (!$pluginShowMenu) {
            abort(404);
        }
        
        return view('user.sites.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $site = ConnectedSite::findOrFail($id);

        // Policy Check: Ensure user owns this site
        if ($site->user_id !== auth()->id()) {
            abort(403);
        }

        // Revoke Tokens associated with this specific site (if we named them strictly)
        // For broad revocation based on name:
        /*
        auth()->user()->tokens->filter(function ($token) use ($site) {
             return str_contains($token->name, $site->domain);
        })->each->delete();
        */
        
        // Simpler for now: just delete the record so they can register again
        // Domain Locking check in AuthController looks at table records.
        $site->delete();

        return redirect()->route('user.sites.index')->with('success', 'Sitio desconectado correctamente.');
    }
}