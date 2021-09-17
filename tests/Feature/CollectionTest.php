<?php

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Bullet;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_authentication()
    {
        $response = $this->post('/c');

        $response->assertRedirect('/login');
    }

    public function test_it_stores_a_new_collection()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/c', ['name' => 'Test collection']);

        $response->assertRedirect('/c/'.Hashids::encode(1));
        $this->assertDatabaseHas('collections', [
            'user_id' => $user->id,
            'name' => 'Test collection',
            'type' => 'bullet',
        ]);
    }

    public function test_it_shows_a_users_collection()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $user->id]);
        $bullet = Bullet::factory()->create(['collection_id' => $collection->id]);
        $otherUser = User::factory()->create();
        $collection->users()->attach($otherUser);

        $response = $this
            ->actingAs($user)
            ->get("/c/{$collection->hashid}");

        $response
            ->assertOk()
            ->assertViewHas('page.props.collection.name', $collection->name)
            ->assertViewHas('page.props.collection.bullets.0.name', $bullet->name)
            ->assertViewHas('page.props.collection.users.0.name', $otherUser->name);
    }

    public function test_it_shows_a_collection_that_a_user_has_access_to()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);

        $response = $this
            ->actingAs($user)
            ->get("/c/{$collection->hashid}");

        $response->assertOk();
    }

    public function test_it_forbids_collections_a_user_doesnt_have_access_to()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/c/{$collection->hashid}");

        $response->assertForbidden();
    }

    public function test_it_updates_a_collection()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->patch("/c/{$collection->hashid}", [
                'name' => 'New collection name',
                'type' => 'checklist',
                'hide_done' => true,
            ]);

        $response->assertRedirect("/c/{$collection->hashid}");
        $this->assertDatabaseHas('collections', [
            'id' => $collection->id,
            'name' => 'New collection name',
            'type' => 'checklist',
            'hide_done' => true,
        ]);
        Event::assertDispatched(fn (CollectionUpdated $event) => $event->collectionId === $collection->id);
    }

    public function test_it_destroys_a_collection()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->delete("/c/{$collection->hashid}");

        $response->assertRedirect('/daily-log');
        Event::assertDispatched(fn (CollectionUpdated $event) => $event->collectionId === $collection->id);
    }

    public function test_only_the_owner_can_delete_the_collection()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);

        $response = $this
            ->actingAs($user)
            ->delete("/c/{$collection->hashid}");

        $response->assertForbidden();
    }

    public function test_users_can_add_bullets_to_the_daily_log()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = $user->collections()->save(Collection::factory()->make());
        $bullet = $collection->bullets()->save(
            Bullet::factory()->make([
                'user_id' => $user->id,
                'date' => null,
            ])
        );

        $response = $this
            ->actingAs($user)
            ->patch("/c/{$collection->hashid}/bullets/{$bullet->id}", [
                'date' => '2021-02-03'
            ]);

        $response->assertRedirect("/c/{$collection->hashid}");
        $this->assertEquals('2021-02-03', $bullet->fresh()->date->format('Y-m-d'));
        Event::assertDispatched(fn (CollectionUpdated $event) => $event->collectionId === $collection->id);
        Event::assertDispatched(fn (DailyLogUpdated $event) => $event->userId === $user->id);
    }

    public function test_other_users_cant_add_bullets_to_the_owners_daily_log()
    {
        Event::fake();
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);
        $bullet = Bullet::factory()->create([
            'date' => null,
        ]);
        $collection->bullets()->save($bullet);

        $response = $this
            ->actingAs($user)
            ->patch("/c/{$collection->hashid}/bullets/{$bullet->id}", [
                'date' => '2021-02-03'
            ]);

        $response->assertRedirect("/c/{$collection->hashid}");
        $this->assertNull($bullet->fresh()->date);
        Event::assertDispatched(fn (CollectionUpdated $event) => $event->collectionId === $collection->id);
        Event::assertNotDispatched(DailyLogUpdated::class);
    }

    public function test_only_an_authorized_user_can_invite_someone_to_a_collection()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = Collection::factory()->create();
        $friend = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson("/c/{$collection->hashid}/users", [
                'email' => $friend->email,
            ]);

        $response->assertForbidden();
    }

    public function test_users_can_be_invited_to_a_collection()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = $user->collections()->save(Collection::factory()->make());
        $friend = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson("/c/{$collection->hashid}/users", [
                'email' => $friend->email,
            ]);

        $response->assertRedirect("/c/{$collection->hashid}");
        $this->assertTrue($collection->users->contains($friend));
    }

    public function test_a_user_must_exist_to_be_invited_to_a_collection()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = $user->collections()->save(Collection::factory()->make());

        $response = $this
            ->actingAs($user)
            ->postJson("/c/{$collection->hashid}/users", [
                'email' => 'doesntexist@example.com',
            ]);

        $response->assertJsonValidationErrors(['email' => 'A user with this email address was not found.']);
    }

    public function test_a_user_cannot_be_invited_to_a_collection_twice()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $collection = $user->collections()->save(Collection::factory()->make());
        $friend = User::factory()->create();
        $collection->users()->attach($friend);

        $response = $this
            ->actingAs($user)
            ->postJson("/c/{$collection->hashid}/users", [
                'email' => $friend->email,
            ]);

        $response->assertJsonValidationErrors(['email' => 'This user has already been added to this collection.']);
    }
}
