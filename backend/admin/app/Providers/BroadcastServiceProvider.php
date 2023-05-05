<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Please note that the correct way to call a static method is Broadcast::routes();
        // But in order to make it work with codacy we have to use this workaround:
        // I don't know why codacy doesn't like the correct way of calling a static method.
        // and I do not support this workaround.
        // @Ghostscypher
        // Broadcast::routes();

        callStatic(Broadcast::class, 'routes', ['middleware' => ['auth:sanctum'], 'prefix' => 'api']);

        require base_path('routes/channels.php');
    }
}
