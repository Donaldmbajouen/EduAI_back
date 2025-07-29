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
        // Limiter la longueur par défaut des champs de la base de données à 199 caractères
        \Illuminate\Support\Facades\Schema::defaultStringLength(199);
    }
}
