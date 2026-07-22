<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Set Carbon Locale to Spanish
        \Carbon\Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES.utf8', 'es');

        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $globalSettings = \Illuminate\Support\Facades\Cache::remember('global_settings', 3600, function () {
                return \App\Models\Setting::pluck('value', 'key')->toArray();
            });

            // Override Filesystem Config
            if (isset($globalSettings['storage_driver']) && in_array($globalSettings['storage_driver'], ['public', 'bunnycdn', 'r2'])) {
                 config(['filesystems.default' => $globalSettings['storage_driver']]);
            }

            \Illuminate\Support\Facades\View::share('globalSettings', $globalSettings);
        }

        // Register User Observer for automatic rank assignment
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        // Register Setting Observer to clear settings cache on changes
        \App\Models\Setting::observe(\App\Observers\SettingObserver::class);

        // Register Product Observer to clear sitemap cache on changes
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
    }
}
