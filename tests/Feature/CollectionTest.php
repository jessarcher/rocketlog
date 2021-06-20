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
}
