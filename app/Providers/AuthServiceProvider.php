<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPostPolicies();
        Passport::routes();
        //
    }
    public function registerPostPolicies()
    {
        Gate::define('read', function ($user) {
            return $user->hasAccess(['read']);
        });
        Gate::define('readWaybills', function ($user) {
            return $user->hasAccess(['readWaybills']);
        });
        Gate::define('readWarehouse', function ($user) {
            return $user->hasAccess(['readWarehouse']);
        });
        Gate::define('readDetailCard', function ($user) {
            return $user->hasAccess(['readDetailCard']);
        });
        Gate::define('edit', function ($user) {
            return $user->hasAccess(['edit']);
        });
        Gate::define('create', function ($user) {
            return $user->hasAccess(['create']);
        });
        Gate::define('write', function ($user) {
            return $user->hasAccess(['write']);
        });
    }
}
