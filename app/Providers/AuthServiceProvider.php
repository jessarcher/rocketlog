<?php

namespace App\Providers;

use App\Models\Bullet;
use App\Models\Collection;
use App\Models\Team;
use App\Policies\BulletPolicy;
use App\Policies\CollectionPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
