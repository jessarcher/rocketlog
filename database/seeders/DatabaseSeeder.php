<?php

namespace Database\Seeders;

use App\Models\Bullet;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with test accounts and data.
     *
     * Idempotent, so it can run repeatedly in preview environments.
     * Do not run against production.
     *
     * Models are built directly instead of via factories because model
     * factories always evaluate their definition, which calls Faker.
     * Faker is not installed when dependencies are installed without the
     * dev packages, e.g. for deployments using "composer install --no-dev".
     */
    public function run(): void
    {
        $this->createEmptyUser();
        $this->createFullUser();
    }

    private function createEmptyUser(): void
    {
        if (User::where('email', 'empty@example.com')->exists()) {
            return;
        }

        $this->user('Empty User', 'empty@example.com');
    }

    private function createFullUser(): void
    {
        if (User::where('email', 'full@example.com')->exists()) {
            return;
        }

        $user = $this->user('Full User', 'full@example.com');
        $user->forceFill(['preferences' => [
            'dismissed_welcome' => true,
        ]])->save();

        $user->bullets()->save($this->bullet(
            $user, null, 'Write blog post', 'incomplete', now()->subDay(), now()->subDay()->format('Y-m-d')
        ));
        $user->bullets()->save($this->bullet(
            $user, null, 'Refactor invoice reminders', 'complete', now()->subDays(2), now()->subDays(2)->format('Y-m-d')
        ));

        $collection = $user->collections()->save(new Collection([
            'name' => 'RocketLog launch',
            'type' => 'bullet',
        ]));
        $collection->bullets()->saveMany([
            $this->bullet($user, $collection, 'Ship Laravel 12 upgrade', 'complete', now()->subDay()),
            $this->bullet($user, $collection, 'Email beta subscribers', 'incomplete', now()->subDays(2)),
            $this->bullet($user, $collection, 'Refresh marketing site', 'incomplete', now()->subDays(2)),
            $this->bullet($user, $collection, 'Plan pricing experiment', 'incomplete', now()->subDays(2)),
            $this->bullet($user, $collection, 'Fix reported bullet sync bug', 'complete', now()->subDays(2)),
        ]);
        $collection->bullets()->save($this->bullet(
            $user, $collection, 'Thank new subscribers', 'incomplete', now()->subDay()
        ));

        $friend = $this->user('Friend User', 'friend@example.com');
        $sharedCollection = $friend->collections()->save(new Collection([
            'name' => 'Shared list',
            'type' => 'bullet',
        ]));
        $sharedCollection->bullets()->saveMany([
            $this->bullet($user, $sharedCollection, 'Book venue for meetup', 'incomplete', now()->subDay()),
            $this->bullet($user, $sharedCollection, 'Collect RSVPs', 'incomplete', now()->subDays(2)),
            $this->bullet($user, $sharedCollection, 'Draft meetup agenda', 'incomplete', now()->subDays(2)),
            $this->bullet($user, $sharedCollection, 'Order name badges', 'incomplete', now()->subDays(2)),
            $this->bullet($user, $sharedCollection, 'Prepare demo account', 'complete', now()->subDays(2)),
        ]);
        $sharedCollection->bullets()->save($this->bullet(
            $friend, $sharedCollection, 'Invite the co-organiser', 'incomplete', now()->subDay()
        ));
        $sharedCollection->users()->attach($user);
    }

    private function user(string $name, string $email): User
    {
        return User::forceCreate([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }

    private function bullet(User $user, ?Collection $collection, string $name, string $state, $createdAt, ?string $date = null): Bullet
    {
        return Bullet::forceCreate([
            'user_id' => $user->id,
            'collection_id' => $collection?->id,
            'type' => 'task',
            'name' => $name,
            'state' => $state,
            'created_at' => $createdAt,
            'date' => $date,
        ]);
    }
}
