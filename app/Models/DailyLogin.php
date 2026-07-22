<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLogin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logged_at',
        'current_streak',
        'max_streak'
    ];

    protected $casts = [
        'logged_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
