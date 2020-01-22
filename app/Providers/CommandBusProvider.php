<?php

namespace App\Providers;

use SmoothCode\Sample\Infrastructure\CommandBus\Adapter\TacticianCommandBus;
use Illuminate\Support\ServiceProvider;

use SmoothCode\Propagation\CommandBus;

class CommandBusProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommandBus::class, TacticianCommandBus::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
