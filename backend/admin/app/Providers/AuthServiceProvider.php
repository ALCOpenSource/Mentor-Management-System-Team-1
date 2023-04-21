<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        callStatic(Gate::class, 'define', 'viewWebSocketsDashboard', function () {
            // Make sure the username and password are set and non empty
            if (empty(config('websockets.statistics.auth.username')) || empty(config('websockets.statistics.auth.password'))) {
                return false;
            }

            return strtolower(request('username', '')) === strtolower(config('websockets.statistics.auth.username'))
                && request('password', '') === config('websockets.statistics.auth.password');
        });
    }
}
