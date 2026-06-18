<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Ensure generated URLs use HTTPS in production. Render terminates TLS
        // at its proxy, so without this asset()/url() can emit http:// links
        // that browsers block as mixed content (causing unstyled pages).
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
