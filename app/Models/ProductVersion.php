<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'version_number',
        'changelog',
        'file_path',
        'file_size',
        'update_package_file',
        'extra_file_name',
        'released_at',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'released_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }
}
