<?php

namespace Tests\Browser;

use App\Models\Collection;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PartialReloadTest extends DuskTestCase
{
    public function test_collection_partial_reload_shows_updated_bullet(): void
    {
        $user = User::where('email', 'full@example.com')->first();
        $collection = Collection::where('user_id', $user->id)->first();
        $bullet = $collection->bullets()->first();
        $bullet->update(['name' => 'Original Test Bullet']);

        $this->browse(function (Browser $browser) use ($user, $collection, $bullet) {
            $this->loginViaUi($browser);
            $browser->visit(route('c.show', $collection))
                ->pause(1000);

            $this->assertTextareaContains($browser, 'Original Test Bullet');

            $bullet->update(['name' => 'Externally Updated Bullet']);

            $browser->script("window.Echo.connector.pusher.connection.emit('reconnected')");
            $browser->pause(2000);

            $this->assertTextareaContains($browser, 'Externally Updated Bullet');
        });
    }

    public function test_daily_log_partial_reload_shows_updated_bullet(): void
    {
        $user = User::where('email', 'full@example.com')->first();
        $bullet = $user->bullets()->orderBy('id')->first();
        $bullet->update(['name' => 'Original Test Bullet']);

        $this->browse(function (Browser $browser) use ($user, $bullet) {
            $this->loginViaUi($browser);
            $browser->visit(route('daily-log.index'))
                ->pause(1000);

            $this->assertTextareaContains($browser, 'Original Test Bullet');

            $bullet->update(['name' => 'Externally Updated Bullet']);

            $browser->script("window.Echo.connector.pusher.connection.emit('reconnected')");
            $browser->pause(2000);

            $this->assertTextareaContains($browser, 'Externally Updated Bullet');
        });
    }

    private function loginViaUi(Browser $browser): void
    {
        $browser->visit('/login');

        if (str_contains($browser->driver->getCurrentURL(), 'login')) {
            $browser->type('#email', 'full@example.com')
                ->type('#password', 'password')
                ->press('Login')
                ->pause(2000);
        }
    }

    /**
     * Bullet names are rendered inside textareas, so assert against their
     * values rather than the page's visible text.
     */
    private function assertTextareaContains(Browser $browser, string $expected): void
    {
        $values = collect($browser->script(
            "return JSON.stringify(Array.from(document.querySelectorAll('textarea')).map(t => t.value))"
        ))->first() ?: '[]';

        $this->assertStringContainsString($expected, $values, "Expected [{$expected}] in textarea values: {$values}");
    }
}