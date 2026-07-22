<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConnectedSite;
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
