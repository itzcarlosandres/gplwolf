<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MembershipController extends Controller
{
    /**
     * Display a listing of user memberships.
     */
    public function index()
    {
        $memberships = Membership::with(['user', 'plan'])
            ->latest()
            ->paginate(15);
        
        return view('admin.memberships.index', compact('memberships'));
    }

    /**
     * Show the form for editing the specified membership.
     */
    public function edit(Membership $membership)
    {
        return view('admin.memberships.edit', compact('membership'));
    }

    /**
     * Update the specified membership in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,expired,cancelled,suspended',
            'expires_at' => 'nullable|date',
            'extra_daily_downloads' => 'required|integer|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        $membership->update($validated);

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Membresía actualizada correctamente.');
    }

    /**
     * Extend membership by days.
     */
    public function extend(Request $request, Membership $membership)
    {
        $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $currentExpiry = $membership->expires_at ? Carbon::parse($membership->expires_at) : now();
        
        // If expired, start from today
        if ($currentExpiry->isPast()) {
            $currentExpiry = now();
        }

        $membership->update([
            'expires_at' => $currentExpiry->addDays($request->days),
            'status' => 'active' // Reactive if it was expired
        ]);

        return back()->with('success', "Se han añadido {$request->days} días a la membresía.");
    }

    /**
     * Remove the specified membership from storage.
     */
    public function destroy(Membership $membership)
    {
        $membership->delete();

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Membresía eliminada correctamente.');
    }
}
