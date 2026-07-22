<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Rank;
use App\Models\Ticket;
use App\Mail\PurchaseConfirmation;
use App\Mail\MembershipActivated;
use App\Mail\RankUpgradeNotification;
use App\Mail\SupportTicketReplied;
use App\Mail\MembershipExpiring;
use Illuminate\Http\Request;

class EmailPreviewController extends Controller
{
    public function index()
    {
        $previews = [
            'purchase' => 'Confirmación de Compra',
            'membership_activated' => 'Activación de Membresía',
            'membership_expiring' => 'Membresía por Expirar',
            'rank_upgrade' => 'Subida de Rango',
            'support_reply' => 'Respuesta de Soporte',
        ];

        return view('admin.emails.index', compact('previews'));
    }

    public function show($type)
    {
        $user = new User([
            'name' => 'Usuario Demo',
            'email' => 'demo@ejemplo.com',
        ]);

        switch ($type) {
            case 'purchase':
                $order = new Order([
                    'id' => 1001,
                    'total_amount' => 49.99,
                    'status' => 'completed',
                    'created_at' => now(),
                ]);
                $order->setRelation('user', $user);
                
                // Mock Order Items
                $product = new Product(['title' => 'WordPress Premium Theme', 'slug' => 'wp-theme']);
                $item = new OrderItem(['price' => 49.99]);
                $item->setRelation('product', $product);
                $order->setRelation('items', collect([$item]));

                return new PurchaseConfirmation($order, 150);

            case 'membership_activated':
                $plan = new MembershipPlan(['name' => 'Plan Pro Anual', 'price' => 99.00]);
                $membership = new Membership([
                    'start_date' => now(),
                    'end_date' => now()->addYear(),
                    'status' => 'active'
                ]);
                $membership->setRelation('plan', $plan);
                $membership->setRelation('user', $user);

                return new MembershipActivated($membership, 500);

            case 'membership_expiring':
                $plan = new MembershipPlan(['name' => 'Plan Pro Anual', 'price' => 99.00]);
                $membership = new Membership([
                    'start_date' => now()->subYear(),
                    'end_date' => now()->addDays(3), // Expira en 3 dias
                    'status' => 'active'
                ]);
                $membership->setRelation('plan', $plan);
                $membership->setRelation('user', $user);

                // We need to create this Mailable
                return new \App\Mail\MembershipExpiring($membership);

            case 'rank_upgrade':
                $newRank = new Rank(['name' => 'Diamante', 'color' => '#b9f2ff']);
                $oldRank = new Rank(['name' => 'Oro', 'color' => '#ffd700']);

                return new RankUpgradeNotification($user, $newRank, $oldRank);

            case 'support_reply':
                $ticket = new Ticket([
                    'id' => 505,
                    'subject' => 'Problema con la descarga',
                    'status' => 'answered'
                ]);
                $ticket->setRelation('user', $user);
                
                $replyContent = "Hola Usuario,\n\nHemos verificado tu cuenta y el enlace de descarga debería funcionar ahora. Por favor intenta nuevamente y avísanos si persiste el problema.\n\nSaludos,\nSoporte Técnico.";

                // We need to create this Mailable
                return new \App\Mail\SupportTicketReplied($ticket, $replyContent);

            default:
                abort(404);
        }
    }
}
