<?php

namespace App\Providers;

use App\Models\Bullet;
use App\Models\Collection;
use App\Policies\BulletPolicy;
use App\Policies\CollectionPolicy;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/daily-log';

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

        $this->bootAuth();
        $this->bootRoute();
    }

    public function bootAuth(): void
    {
        Gate::policy(Bullet::class, BulletPolicy::class);
        Gate::policy(Collection::class, CollectionPolicy::class);
    }

    public function bootRoute(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });


    }
}
