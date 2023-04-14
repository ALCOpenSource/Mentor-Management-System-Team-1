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
        $broadcast = new Broadcast();
        $broadcast->__callStatic('routes', []);

        require base_path('routes/channels.php');
    }
}
