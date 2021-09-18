<?php

namespace Tests\Feature;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Bullet;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DailyLogTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_requires_authentication()
    {
        $this
            ->get('/daily-log')
            ->assertRedirect('/login');
    }

    public function test_it_only_shows_my_bullets()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $myBullet = $user->bullets()->save(
            Bullet::factory()->make(['date' => now()->format('Y-m-d')])
        );
        $otherBullet = Bullet::factory()->create(['date' => now()->format('Y-m-d')]);

        $response = $this
            ->actingAs($user)
            ->get('/daily-log');

        $response->assertOk();
        $response->assertSee($myBullet->name);
        $response->assertDontSee($otherBullet->name);
    }

    public function test_it_only_shows_six_days_of_bullets()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $this->travelTo(now()->subDays(7));
        $oldBullet = $user->bullets()->save(Bullet::factory()->make(['date' => now()]));

        $this->travelTo(now()->addDay());
        $recentBullet1 = $user->bullets()->save(Bullet::factory()->make(['date' => now()]));

        $this->travelTo(now()->addDay());
        $recentBullet2 = $user->bullets()->save(Bullet::factory()->make(['date' => now()]));

        $this->travelTo(now()->addDay());
        $recentBullet3 = $user->bullets()->save(Bullet::factory()->make(['date' => now()]));

        $this->travelTo(now()->addDay());
        $recentBullet4 = $user->bullets()->save(Bullet::factory()->make(['date' => now()]));

        $this->travelTo(now()->addDay());
        $recentBullet5 = $user->bullets()->save(Bullet::factory()->make(['date' => now()]));

        $this->travelTo(now()->addDay());
        $recentBullet6 = $user->bullets()->save(Bullet::factory()->make(['date' => now()]));

        $this->travelBack();

        $response = $this
            ->actingAs($user)
            ->get('/daily-log');

        $response->assertSee($recentBullet1->name);
        $response->assertSee($recentBullet2->name);
        $response->assertSee($recentBullet3->name);
        $response->assertSee($recentBullet4->name);
        $response->assertSee($recentBullet5->name);
        $response->assertSee($recentBullet6->name);
        $response->assertDontSee($oldBullet->name);
    }

    public function test_it_stores_bullets()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/daily-log', [
                'date' => now()->format('Y-m-d'),
                'name' => $name = $this->faker->text,
            ]);

        $response->assertRedirect('/daily-log');
        $this->assertDatabaseHas('bullets', [
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
            'name' => $name,
            'type' => 'task',
            'state' => 'incomplete',
        ]);
        Event::assertDispatched(fn (DailyLogUpdated $event) => $event->userId === $user->id);
    }

    public function test_it_updates_bullets()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $bullet = $user->bullets()->save(Bullet::factory()->make(['date' => now()->subDays(2)]));

        $response = $this
            ->actingAs($user)
            ->patch("/daily-log/{$bullet->id}", [
                'date' => now()->format('Y-m-d'),
                'name' => $name = $this->faker->text,
                'state' => 'complete',
            ]);

        $response->assertRedirect('/daily-log');
        $this->assertDatabaseHas('bullets', [
            'id' => $bullet->id,
            'date' => now()->format('Y-m-d'),
            'name' => $name,
            'state' => 'complete',
        ]);
        Event::assertDispatched(fn (DailyLogUpdated $event) => $event->userId === $user->id);
    }

    public function test_it_moves_bullets()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = $user->collections()->save(Collection::factory()->make());
        $bullet = $user->bullets()->save(Bullet::factory()->make(['date' => null, 'collection_id' => $collection->id]));

        $response = $this
            ->actingAs($user)
            ->from("/c/{$collection->slug}")
            ->put('/daily-log', [
                'id' => $bullet->id,
                'date' => now()->format('Y-m-d'),
            ]);

        $response->assertRedirect("/c/{$collection->slug}");
        $this->assertDatabaseHas('bullets', [
            'id' => $bullet->id,
            'date' => now()->format('Y-m-d'),
            'collection_id' => null,
        ]);
        Event::assertDispatched(fn (DailyLogUpdated $event) => $event->userId === $user->id);
    }

    public function test_a_user_cant_move_others_bullets()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create();
        $bullet = $collection->bullets()->save(Bullet::factory()->make(['date' => null]));

        $response = $this
            ->actingAs($user)
            ->put('/daily-log', [
                'id' => $bullet->id,
                'date' => now()->format('Y-m-d'),
            ]);

        $response->assertForbidden();
    }

    public function test_a_user_can_move_others_bullets_if_they_own_the_collection()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $user->id]);
        $bullet = Bullet::factory()->create(['date' => null, 'collection_id' => $collection->id]);

        $response = $this
            ->actingAs($user)
            ->from("/c/{$collection->slug}")
            ->put('/daily-log', [
                'id' => $bullet->id,
                'date' => now()->format('Y-m-d'),
            ]);

        $response->assertRedirect("/c/{$collection->slug}");
        $this->assertDatabaseHas('bullets', [
            'id' => $bullet->id,
            'date' => now()->format('Y-m-d'),
            'collection_id' => null,
        ]);
        Event::assertDispatched(fn (DailyLogUpdated $event) => $event->userId === $user->id);
        Event::assertDispatched(fn (CollectionUpdated $event) => $event->collectionId === $collection->id);
    }

    public function test_a_user_can_move_others_bullets_if_they_have_access_to_the_collection()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);
        $bullet = Bullet::factory()->create(['date' => null, 'collection_id' => $collection->id]);

        $response = $this
            ->actingAs($user)
            ->from("/c/{$collection->slug}")
            ->put('/daily-log', [
                'id' => $bullet->id,
                'date' => now()->format('Y-m-d'),
            ]);

        $response->assertRedirect("/c/{$collection->slug}");
        $this->assertDatabaseHas('bullets', [
            'id' => $bullet->id,
            'date' => now()->format('Y-m-d'),
            'collection_id' => null,
        ]);
        Event::assertDispatched(fn (DailyLogUpdated $event) => $event->userId === $user->id);
        Event::assertDispatched(fn (CollectionUpdated $event) => $event->collectionId === $collection->id);
    }

    public function test_it_destroys_bullets()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = $user->collections()->save(Collection::factory()->make());
        $bullet = $user->bullets()->save(Bullet::factory()->make(['date' => null, 'collection_id' => $collection->id]));

        $this
            ->actingAs($user)
            ->delete("/daily-log/{$bullet->id}")
            ->assertRedirect('/daily-log');

        $this->assertDatabaseMissing('bullets', ['id' => $bullet->id]);
        Event::assertDispatched(fn (DailyLogUpdated $event) => $event->userId === $user->id);
    }

    public function test_a_user_cant_update_others_bullets()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $bullet = $otherUser->bullets()->save(
            Bullet::factory()->make(['date' => '2021-04-07', 'collection_id' => null])
        );

        $response = $this
            ->actingAs($user)
            ->put("/daily-log/{$bullet->id}", [
                'date' => now()->format('Y-m-d'),
            ]);

        $response->assertForbidden();
    }

    public function test_a_user_cant_delete_others_bullets()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $bullet = $otherUser->bullets()->save(
            Bullet::factory()->make(['date' => '2021-04-07', 'collection_id' => null])
        );

        $response = $this
            ->actingAs($user)
            ->delete("/daily-log/{$bullet->id}");

        $response->assertForbidden();
    }
}
