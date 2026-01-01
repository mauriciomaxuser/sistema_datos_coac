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
        // Forzar el uso de HTTPS en producción
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        //
    }
}
