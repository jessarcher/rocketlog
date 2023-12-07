<?php

namespace Database\Seeders;

use App\Models\Bullet;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createEmptyUser();
        $this->createFullUser();
    }

    private function createEmptyUser()
    {
        User::factory()->create(['email' => 'empty@example.com']);
    }

    private function createFullUser()
    {
        $user = User::factory()->create([
            'email' => 'full@example.com',
            'preferences' => [
                'dismissed_welcome' => true,
            ],
        ]);
        $user->bullets()->save(Bullet::factory()->make(['date' => now()->subDay()->format('Y-m-d')]));
        $user->bullets()->save(Bullet::factory()->make(['date' => now()->subDay(2)->format('Y-m-d')]));

        $collection = $user->collections()->save(Collection::factory()->make());
        $collection->bullets()->saveMany(Bullet::factory(5)->make(['user_id' => $user->id]));
        $collection->bullets()->save(Bullet::factory()->make([
            'user_id' => $user->id,
            'date' => now()->subDay()->format('Y-m-d'),
        ]));

        $friend = User::factory()->create(['email' => 'friend@example.com']);
        $collection = $friend->collections()->save(Collection::factory()->make());
        $collection->bullets()->saveMany(Bullet::factory(5)->make(['user_id' => $user->id]));
        $collection->bullets()->save(Bullet::factory()->make([
            'user_id' => $friend->id,
            'date' => now()->subDay()->format('Y-m-d'),
        ]));
        $collection->users()->attach($user);
    }
}
