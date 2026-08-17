<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\PluginRelease;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get the latest plugin version from database or fallback to file.
     */
    public static function getPluginLatestVersion()
    {
        $latestRelease = PluginRelease::latestRelease();
        if ($latestRelease) {
            return $latestRelease->version_number;
        }

        $pluginPath = base_path('wordpress-plugin/marketplace-connect/marketplace-connect.php');
        if (file_exists($pluginPath)) {
            $content = file_get_contents($pluginPath);
            if (preg_match('/Version:\s*([0-9.]+)/i', $content, $matches)) {
                return $matches[1];
            }
        }

        return '1.0.0';
    }
}
