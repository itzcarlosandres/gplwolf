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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $activeMembership = $user->activeMembership;
        
        if (!$activeMembership && !$user->isAdmin()) {
            return back()->with('error', 'Debes tener una membresía activa para conectar sitios.');
        }

        $validated = $request->validate([
            'domain' => 'required|url',
        ], [
            'domain.required' => 'Debes ingresar la URL de tu sitio.',
            'domain.url' => 'Debes ingresar una URL válida (ej: https://tusitio.com).',
        ]);

        $domain = rtrim(strtolower($validated['domain']), '/');

        // Check if domain is already registered for this user
        $exists = $user->connectedSites()->where('domain', $domain)->exists();
        if ($exists) {
            return back()->withInput()->with('error', 'Este dominio ya está registrado en tu cuenta.');
        }

        // Check sites limit
        if ($user->isAdmin()) {
            $siteLimit = 0; // Unlimited
        } else {
            $siteLimit = (int) $activeMembership->plan->sites_limit;
        }

        if ($siteLimit > 0 && $user->connectedSites()->count() >= $siteLimit) {
            return back()->withInput()->with('error', 'Has alcanzado el límite de sitios conectados de tu plan (' . $siteLimit . '). Desconecta un sitio antiguo para agregar uno nuevo.');
        }

        // Create
        $user->connectedSites()->create([
            'domain' => $domain,
            'connected_at' => now(),
        ]);

        return redirect()->route('user.sites.index')->with('success', 'Sitio agregado y autorizado correctamente. Ahora puedes instalar el plugin en tu WordPress.');
    }

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

        $site->delete();

        return redirect()->route('user.sites.index')->with('success', 'Sitio desconectado correctamente.');
    }
}