<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of all tickets.
     */
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->paginate(20);
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'messages.user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Update the ticket with an admin reply.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        // Create message
        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->admin_reply,
            'is_admin' => true,
        ]);

        $ticket->update([
            'admin_reply' => $request->admin_reply, // Keep for legacy/compat
            'status' => 'answered',
            'replied_at' => now(),
        ]);

        return redirect()->route('admin.tickets.show', $ticket)->with('success', 'Respuesta enviada correctamente.');
    }

    /**
     * Close the ticket.
     */
    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket cerrado correctamente.');
    }
}
