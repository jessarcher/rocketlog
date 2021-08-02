<?php

use App\Models\Bullet;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_authentication()
    {
        $this
            ->post('/c')
            ->assertRedirect('/login');
    }

    public function test_it_stores_a_new_collection()
    {
        $this
            ->actingAs($user = User::factory()->create())
            ->post('/c', ['name' => 'Test collection'])
            ->assertRedirect('/c/'.Hashids::encode(1));

        $this->assertDatabaseHas('collections', [
            'user_id' => $user->id,
            'name' => 'Test collection',
            'type' => 'bullet',
        ]);
    }

    public function test_it_shows_a_users_collection()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create(['user_id' => $user->id]);
        $bullet = Bullet::factory()->create(['collection_id' => $collection->id]);
        $otherUser = User::factory()->create();
        $collection->users()->attach($otherUser);

        $this
            ->get("/c/{$collection->hashid}")
            ->assertOk()
            ->assertViewHas('page.props.collection.name', $collection->name)
            ->assertViewHas('page.props.collection.bullets.0.name', $bullet->name)
            ->assertViewHas('page.props.collection.users.0.name', $otherUser->name);
    }

    public function test_it_shows_a_collection_that_a_user_has_access_to()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);

        $this
            ->get("/c/{$collection->hashid}")
            ->assertOk();
    }

    public function test_it_forbids_collections_a_user_doesnt_have_access_to()
    {
        $collection = Collection::factory()->create();

        $this
            ->actingAs(User::factory()->create())
            ->get("/c/{$collection->hashid}")
            ->assertForbidden();
    }

    public function test_it_updates_a_collection()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create(['user_id' => $user->id]);

        $this
            ->patch("/c/{$collection->hashid}", [
                'name' => 'New collection name',
                'type' => 'checklist',
                'hide_done' => true,
            ])
            ->assertRedirect("/c/{$collection->hashid}");

        $this->assertDatabaseHas('collections', [
            'id' => $collection->id,
            'name' => 'New collection name',
            'type' => 'checklist',
            'hide_done' => true,
        ]);
    }

    public function test_it_destroys_a_collection()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create(['user_id' => $user->id]);

        $this
            ->delete("/c/{$collection->hashid}")
            ->assertRedirect('/daily-log');
    }

    public function test_only_the_owner_can_delete_the_collection()
    {
        $this->actingAs($user = User::factory()->create());
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);

        $this
            ->delete("/c/{$collection->hashid}")
            ->assertForbidden();
    }

    public function test_users_can_add_bullets_to_the_daily_log()
    {
        $user = User::factory()->create();
        $collection = Collection::factory()->create();
        $collection->users()->attach($user);
        $bullet = Bullet::factory()->create([
            'date' => null,
        ]);
        $collection->bullets()->save($bullet);
        $user->bullets()->save($bullet);

        $response = $this
            ->actingAs($user)
            ->patch("/c/{$collection->hashid}/bullets/{$bullet->id}", [
                'date' => '2021-02-03'
            ]);

        $response->assertRedirect("/c/{$collection->hashid}");
        $this->assertEquals('2021-02-03', $bullet->fresh()->date->format('Y-m-d'));
    }

    public function test_other_users_cant_add_bullets_to_the_owners_daily_log()
    {
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
    }

    public function test_users_can_be_invited_to_a_collection()
    {
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
