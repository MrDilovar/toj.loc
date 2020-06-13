<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is_store', function ($user) {
            return Auth::check() && $user->role === 'store';
        });

        Gate::define('is_admin', function ($user) {
            return Auth::check() && $user->role === 'admin';
        });

        Gate::define('store_can', function ($user, $user_id) {
            return $user->id === $user_id;
        });
    }
}
