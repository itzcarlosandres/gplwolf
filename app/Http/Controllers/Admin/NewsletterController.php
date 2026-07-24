<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.newsletter.index', compact('subscribers'));
    }

    public function toggleStatus(NewsletterSubscriber $subscriber)
    {
        $subscriber->update([
            'is_active' => !$subscriber->is_active
        ]);

        return back()->with('success', 'Estado del suscriptor actualizado correctamente.');
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Suscriptor eliminado correctamente.');
    }

    public function createMail()
    {
        $subscribersCount = NewsletterSubscriber::where('is_active', true)->count();
        return view('admin.newsletter.create', compact('subscribersCount'));
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $subscribers = NewsletterSubscriber::where('is_active', true)->get();

        if ($subscribers->isEmpty()) {
            return back()->with('error', 'No hay suscriptores activos para enviar el boletín.');
        }

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewsletterMail($request->subject, $request->content));
        }

        return redirect()->route('admin.newsletter.index')->with('success', 'El boletín se ha puesto en cola para enviarse a ' . $subscribers->count() . ' suscriptores.');
    }
}
