<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        callStatic(Blueprint::class, 'macro', 'genericMorph', function (string $column = null) {
            /* @var BlueIlluminate\Database\Schema\Blueprint $this */
            $column ??= strHelper('snake', $this->getTable());
            $this->string("{$column}_type")->index();
            $this->string("{$column}_id")->index();
        });

        callStatic(Blueprint::class, 'macro', 'genericNullableMorph', function (string $column = null) {
            /* @var BlueIlluminate\Database\Schema\Blueprint $this */
            $column ??= strHelper('snake', $this->getTable());
            $this->string("{$column}_type")->index()->nullable();
            $this->string("{$column}_id")->index()->nullable();
        });
    }
}
