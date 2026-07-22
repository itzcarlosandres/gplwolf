<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::withCount(['orders', 'memberships']);
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->latest()->paginate(20);
        
        // Calculate statistics
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'customer_users' => User::where('role', 'customer')->count(),
            'users_with_memberships' => User::whereHas('memberships', function($q) {
                $q->where('status', 'active');
            })->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,customer',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['orders.items.product', 'memberships.plan', 'downloads.product']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $ranks = \App\Models\Rank::orderBy('min_points', 'asc')->get();
        return view('admin.users.edit', compact('user', 'ranks'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'points' => 'nullable|integer|min:0',
            'current_rank_id' => 'nullable|exists:ranks,id',
        ]);
        
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
    
    /**
     * Update the role of the specified user.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,customer',
        ]);
        
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', 'No puedes cambiar tu propio rol.');
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Rol de usuario actualizado exitosamente.');
    }

    /**
     * Update the points of the specified user.
     */
    public function updatePoints(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|not_in:0',
            'description' => 'nullable|string|max:255',
        ]);
        
        $amount = (int) $validated['amount'];
        
        // Prevent negative balance
        if ($amount < 0 && $user->points + $amount < 0) {
            return redirect()->back()->with('error', 'El usuario no tiene suficientes puntos para restar esa cantidad.');
        }
        
        $user->increment('points', $amount);
        
        $type = $amount > 0 ? 'añadidos' : 'restados';
        $absAmount = abs($amount);
        
        return redirect()->back()->with('success', "Se han {$type} {$absAmount} puntos al usuario correctamente.");
    }
}
