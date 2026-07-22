<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Display a listing of user's tickets.
     */
    public function index()
    {
        $tickets = Auth::user()->tickets()->latest()->paginate(10);
        return view('user.support.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        return view('user.support.create');
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|string',
        ]);

        $ticket = Auth::user()->tickets()->create([
            'subject' => $validated['subject'],
            'priority' => $validated['priority'],
            'message' => $validated['message'], // Keep for compatibility if needed
            'status' => 'open',
        ]);

        // Create initial message
        $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_admin' => false,
        ]);

        return redirect()->route('user.support.index')->with('success', 'Ticket creado correctamente. Te responderemos pronto.');
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['messages.user', 'user']);

        return view('user.support.show', compact('ticket'));
    }

    /**
     * Handle the user reply.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        if ($ticket->status === 'closed') {
            return back()->with('error', 'No puedes responder a un ticket cerrado.');
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_admin' => false,
        ]);

        $ticket->update(['status' => 'open']); // Reopen or set to open when user replies

        return back()->with('success', 'Tu respuesta ha sido enviada.');
    }
}
