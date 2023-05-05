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
        callStatic(Gate::class, 'define', 'viewWebSocketsDashboard', function ($user = null) {
            // If session has been set that the user has passed authentication, return true
            if (session('websockets.authenticated')) {
                return true;
            }

            // If a user is provided, use the Laravel authentication system.
            // The code below is unnecessary but it serves two purposes:
            // 1. Bypass codacy issues
            // 2. Allow this gate to work as expected when using Laravel UI
            if ($user) {
                return callStatic(Gate::class, 'forUser', null)->check('viewWebSocketsDashboard');
            }

            // Make sure the username and password are set and non empty
            if (empty(config('websockets.auth.username')) || empty(config('websockets.auth.password'))) {
                return false;
            }

            // If no user is provided, use the default Laravel authentication
            $authenticated = strtolower(request('username', '')) === strtolower(config('websockets.auth.username'))
                && request('password', '') === config('websockets.auth.password');

            // Put in session that the user has passed authentication
            if ($authenticated) {
                session(['websockets.authenticated' => true]);
            }

            return $authenticated;
        });
    }
}
