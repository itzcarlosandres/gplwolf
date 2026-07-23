<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConnectedSite;
use App\Models\User;
use Illuminate\Http\Request;

class ConnectedSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ConnectedSite::with('user');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('domain', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
        }

        $sites = $query->latest()->paginate(20);

        // Calculate stats
        $totalSites = ConnectedSite::count();
        $uniqueDomains = ConnectedSite::distinct('domain')->count();
        $sitesThisMonth = ConnectedSite::where('created_at', '>=', now()->startOfMonth())->count();

        return view('admin.sites.index', compact('sites', 'totalSites', 'uniqueDomains', 'sitesThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.sites.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'domain' => 'required|url',
        ], [
            'user_id.required' => 'Debes seleccionar un cliente.',
            'user_id.exists' => 'El cliente seleccionado no existe.',
            'domain.required' => 'Debes ingresar una dirección URL.',
            'domain.url' => 'Debes ingresar una dirección URL válida (ej: https://tusitio.com).',
        ]);

        $domain = rtrim(strtolower($validated['domain']), '/');

        // Check if domain is already registered for this user
        $exists = ConnectedSite::where('user_id', $validated['user_id'])
            ->where('domain', $domain)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['domain' => 'Este dominio ya está registrado para este usuario.']);
        }

        ConnectedSite::create([
            'user_id' => $validated['user_id'],
            'domain' => $domain,
            'connected_at' => now(),
        ]);

        return redirect()->route('admin.sites.index')->with('success', 'Dominio autorizado y agregado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $site = ConnectedSite::findOrFail($id);
        $users = User::orderBy('name')->get();
        return view('admin.sites.edit', compact('site', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $site = ConnectedSite::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'domain' => 'required|url',
        ], [
            'user_id.required' => 'Debes seleccionar un cliente.',
            'user_id.exists' => 'El cliente seleccionado no existe.',
            'domain.required' => 'Debes ingresar una dirección URL.',
            'domain.url' => 'Debes ingresar una dirección URL válida (ej: https://tusitio.com).',
        ]);

        $domain = rtrim(strtolower($validated['domain']), '/');

        // Check if domain is registered for this user excluding current record
        $exists = ConnectedSite::where('user_id', $validated['user_id'])
            ->where('domain', $domain)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['domain' => 'Este dominio ya está registrado para este usuario.']);
        }

        $site->update([
            'user_id' => $validated['user_id'],
            'domain' => $domain,
        ]);

        return redirect()->route('admin.sites.index')->with('success', 'Dominio actualizado con éxito.');
    }

    /**
     * Helper to ban/unban a site.
     */
    public function toggleBan($id)
    {
        $site = ConnectedSite::findOrFail($id);
        $site->is_banned = !$site->is_banned;
        $site->save();

        $message = $site->is_banned ? 'Dominio baneado correctamente.' : 'Dominio desbaneado correctamente.';
        return back()->with('success', $message);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $site = ConnectedSite::findOrFail($id);
        $site->delete();

        return back()->with('success', 'Dominio desconectado correctamente.');
    }
}
