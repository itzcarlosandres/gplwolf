<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UpdateRequest;
use Illuminate\Http\Request;

class UpdateRequestController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para solicitar actualizaciones.');
        }

        // Check if already pending
        if (UpdateRequest::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('status', 'pending')
            ->exists()) {
            return back()->with('info', 'Ya has solicitado una actualización para este producto. Estamos trabajando en ello.');
        }

        $updateRequest = UpdateRequest::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'status' => 'pending',
            'version' => $request->input('version')
        ]);

        // Notificar a todos los administradores
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => 'update_request',
                'title' => '🔔 Nueva Solicitud de Update',
                'message' => auth()->user()->name . " solicitó actualización para " . $product->name . ($request->input('version') ? " (v" . $request->input('version') . ")" : ""),
                'icon' => 'fa-sync-alt',
                'link' => route('admin.update-requests.index'),
                'product_id' => $product->id,
            ]);
        }

        return back()->with('success', '¡Solicitud enviada! Te notificaremos cuando el producto se actualice.');
    }
}
