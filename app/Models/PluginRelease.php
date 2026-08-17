<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PluginRelease extends Model
{
    protected $fillable = ['version_number', 'changelog', 'released_at'];

    protected $casts = [
        'released_at' => 'datetime',
    ];

    /**
     * Get the latest published release.
     */
    public static function latestRelease()
    {
        return self::orderBy('released_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();
    }
}
