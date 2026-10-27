<?php

namespace Database\Seeders;

use App\Models\Bullet;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with test accounts and data.
     *
     * Skipped in production and safe to run repeatedly (idempotent),
     * so it can be part of non-production deployment commands.
     */
    public function run(): void
    {
        if (App::environment('production')) {
            return;
        }

        $this->createEmptyUser();
        $this->createFullUser();
    }

    private function createEmptyUser(): void
    {
        User::firstOrCreate(['email' => 'empty@example.com']);
    }

    private function createFullUser(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'full@example.com'],
            ['preferences' => [
                'dismissed_welcome' => true,
            ]]
        );

        if (! $user->wasRecentlyCreated) {
            return;
        }

        $user->bullets()->save(Bullet::factory()->make(['date' => now()->subDay()->format('Y-m-d')]));
        $user->bullets()->save(Bullet::factory()->make(['date' => now()->subDay(2)->format('Y-m-d')]));

        $collection = $user->collections()->save(Collection::factory()->make());
        $collection->bullets()->saveMany(Bullet::factory(5)->make(['user_id' => $user->id]));
        $collection->bullets()->save(Bullet::factory()->make([
            'user_id' => $user->id,
            'date' => now()->subDay()->format('Y-m-d'),
        ]));

        $friend = User::firstOrCreate(['email' => 'friend@example.com']);
        $friendCollection = $friend->collections()->save(Collection::factory()->make());
        $friendCollection->bullets()->saveMany(Bullet::factory(5)->make(['user_id' => $user->id]));
        $friendCollection->bullets()->save(Bullet::factory()->make([
            'user_id' => $friend->id,
            'date' => now()->subDay()->format('Y-m-d'),
        ]));
        $friendCollection->users()->attach($user);
    }
}
