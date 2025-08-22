<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        if ($this->app->runningUnitTests()) {
            // Make @vite a no-op during tests to avoid manifest requirement
            Blade::directive('vite', function () {
                return '';
            });
        }
    }
}
