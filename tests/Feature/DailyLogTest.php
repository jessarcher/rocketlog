<?php

namespace Tests\Feature;

use App\Models\Bullet;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->actingAs($user = User::factory()->create());

        $myBullet = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);
        $otherBullet = Bullet::factory()->create(['date' => now()]);

        $response = $this->get('/daily-log');

        $response->assertOk();
        $response->assertSee($myBullet->name);
        $response->assertDontSee($otherBullet->name);
    }

    public function test_it_only_shows_six_days_of_bullets()
    {
        $this->actingAs($user = User::factory()->create());

        $this->travelTo(now()->subDays(7));
        $oldBullet = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);

        $this->travelTo(now()->addDay());
        $recentBullet1 = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);

        $this->travelTo(now()->addDay());
        $recentBullet2 = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);

        $this->travelTo(now()->addDay());
        $recentBullet3 = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);

        $this->travelTo(now()->addDay());
        $recentBullet4 = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);

        $this->travelTo(now()->addDay());
        $recentBullet5 = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);

        $this->travelTo(now()->addDay());
        $recentBullet6 = Bullet::factory()->create(['user_id' => $user->id, 'date' => now()]);

        $this->travelBack();

        $response = $this->get('/daily-log');

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
        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/daily-log', [
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
    }

    public function test_it_updates_bullets()
    {
        $this->actingAs($user = User::factory()->create());
        $bullet = $user->bullets()->save(Bullet::factory()->make(['date' => now()->subDays(2)]));

        $response = $this->patch("/daily-log/{$bullet->id}", [
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
    }

    public function test_it_moves_bullets()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create(['user_id' => $user->id]);
        $bullet = $user->bullets()->save(Bullet::factory()->make(['date' => null, 'collection_id' => $collection->id]));

        $response = $this
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
    }

    public function test_a_user_cant_move_others_bullets()
    {
        $this->actingAs(User::factory()->create());
        $collection = Collection::factory()->create();
        $bullet = Bullet::factory()->create(['date' => null, 'collection_id' => $collection->id]);

        $response = $this
            ->put('/daily-log', [
                'id' => $bullet->id,
                'date' => now()->format('Y-m-d'),
            ]);

        $response->assertForbidden();
    }

    public function test_a_user_can_move_others_bullets_if_they_own_the_collection()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create(['user_id' => $user->id]);
        $bullet = Bullet::factory()->create(['date' => null, 'collection_id' => $collection->id]);

        $response = $this
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
    }

    public function test_a_user_can_move_others_bullets_if_they_have_access_to_the_collection()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);
        $bullet = Bullet::factory()->create(['date' => null, 'collection_id' => $collection->id]);

        $response = $this
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
    }

    public function test_it_destroys_bullets()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create(['user_id' => $user->id]);
        $bullet = $user->bullets()->save(Bullet::factory()->make(['date' => null, 'collection_id' => $collection->id]));

        $this
            ->delete("/daily-log/{$bullet->id}")
            ->assertRedirect('/daily-log');

        $this->assertDatabaseMissing('bullets', ['id' => $bullet->id]);
    }
}
