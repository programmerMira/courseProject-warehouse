<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Provider::observe(\App\Observers\ProviderObserver::class);
        \App\Transport::observe(\App\Observers\TransportObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}
