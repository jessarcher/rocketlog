<?php

namespace App\Providers;

use App\Models\Bullet;
use App\Models\Collection;
use App\Policies\BulletPolicy;
use App\Policies\CollectionPolicy;
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
        Bullet::class => BulletPolicy::class,
        Collection::class => CollectionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('viewWebSocketsDashboard', fn ($user) => $user->id === 1);
    }
}
