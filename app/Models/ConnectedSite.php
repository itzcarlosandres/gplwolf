<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectedSite extends Model
{
    protected $fillable = ['user_id', 'domain', 'connected_at', 'is_banned'];

    protected $casts = [
        'connected_at' => 'datetime',
        'is_banned' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}