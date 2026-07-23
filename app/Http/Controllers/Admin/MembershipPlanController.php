<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of membership plans.
     */
    public function index()
    {
        $plans = MembershipPlan::withCount('memberships')->latest()->get();
        
        return view('admin.membership-plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new membership plan.
     */
    public function create()
    {
        return view('admin.membership-plans.create');
    }

    /**
     * Store a newly created membership plan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|in:monthly,annual,lifetime',
            'duration_days' => 'required|integer|min:1',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'daily_download_limit' => 'nullable|integer|min:0',
            'sites_limit' => 'nullable|integer|min:0',
            'reward_points' => 'nullable|integer|min:0',
        ]);
        
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        
        // Ensure slug is unique
        $count = MembershipPlan::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        MembershipPlan::create($validated);
        
        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Plan de membresía creado exitosamente.');
    }

    /**
     * Display the specified membership plan.
     */
    public function show(MembershipPlan $membershipPlan)
    {
        $membershipPlan->load(['memberships.user']);
        
        return view('admin.membership-plans.show', compact('membershipPlan'));
    }

    /**
     * Show the form for editing the specified membership plan.
     */
    public function edit(MembershipPlan $membershipPlan)
    {
        return view('admin.membership-plans.edit', compact('membershipPlan'));
    }

    /**
     * Update the specified membership plan in storage.
     */
    public function update(Request $request, MembershipPlan $membershipPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|in:monthly,annual,lifetime',
            'duration_days' => 'required|integer|min:1',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'daily_download_limit' => 'nullable|integer|min:0',
            'sites_limit' => 'nullable|integer|min:0',
            'reward_points' => 'nullable|integer|min:0',
        ]);
        
        if ($validated['name'] !== $membershipPlan->name) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
            // Ensure slug is unique
            $count = MembershipPlan::where('slug', 'like', $validated['slug'] . '%')
                ->where('id', '!=', $membershipPlan->id)
                ->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }
        
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $membershipPlan->update($validated);
        
        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Plan de membresía actualizado exitosamente.');
    }

    /**
     * Remove the specified membership plan from storage.
     */
    public function destroy(MembershipPlan $membershipPlan)
    {
        // Check if plan has active memberships
        if ($membershipPlan->memberships()->where('status', 'active')->exists()) {
            return redirect()->route('admin.membership-plans.index')
                ->with('error', 'No se puede eliminar un plan con membresías activas.');
        }
        
        $membershipPlan->delete();
        
        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Plan de membresía eliminado exitosamente.');
    }
}
