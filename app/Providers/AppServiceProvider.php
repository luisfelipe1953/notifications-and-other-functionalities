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
        \Illuminate\Support\Facades\Validator::extend('rar', function ($attribute, $value, $parameters, $validator) {
            return $value->getClientMimeType() === 'application/x-rar-compressed';
        });
    }
}
