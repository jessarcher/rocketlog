<?php

namespace App\Providers;

use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\Facades\Broadcast;
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
        // Laravel 10's BroadcastManager doesn't include the "reverb" driver, which
        // is a Pusher-compatible driver built into the framework since Laravel 11.
        // This shim can be removed once the application upgrades to Laravel 11+.
        Broadcast::extend('reverb', function ($app, array $config) {
            return new PusherBroadcaster($app->make(BroadcastManager::class)->pusher($config));
        });
    }
}
