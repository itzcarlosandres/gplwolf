<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = NewsletterSubscriber::where('email', $request->email)->first();

        if ($subscriber) {
            if ($subscriber->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este correo ya está registrado en nuestro boletín.',
                ]);
            }

            $subscriber->update(['is_active' => true]);
        } else {
            NewsletterSubscriber::create([
                'email' => $request->email,
                'is_active' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => '¡Gracias! Te has suscrito correctamente a nuestro boletín.',
        ]);
    }
}
