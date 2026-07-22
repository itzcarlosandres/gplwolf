<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'link',
        'product_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public static function createForProductUpdate(Product $product, $oldVersion, $newVersion)
    {
        // Obtener usuarios que tienen este producto (han hecho pedidos completados)
        $userIds = \DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.product_id', $product->id)
            ->where('orders.status', 'completed')
            ->distinct()
            ->pluck('orders.user_id');

        foreach ($userIds as $userId) {
            self::create([
                'user_id' => $userId,
                'type' => 'product_update',
                'title' => '🚀 Actualización Disponible',
                'message' => "{$product->name} se actualizó de v{$oldVersion} a v{$newVersion}",
                'icon' => 'fa-sync-alt',
                'link' => route('products.show', $product->slug),
                'product_id' => $product->id,
            ]);
        }
    }
}
