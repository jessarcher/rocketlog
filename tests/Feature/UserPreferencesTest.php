<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPreferencesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_saves_the_dismiss_welcome_preference()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/user/preferences', [
                'dismissed_welcome' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'preferences->dismissed_welcome' => true
        ]);
    }
}
