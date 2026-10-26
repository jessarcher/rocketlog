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

        $this->browse(function (Browser $browser) use ($collection, $bullet) {
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

        $this->browse(function (Browser $browser) use ($bullet) {
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
        $browser->visit('/login')->pause(1500);

        // Capture a raw login POST result through the page's own axios instance
        $browser->script(
            "window.axios.post('/login', { email: 'full@example.com', password: 'password' })".
            ".then(r => window.__loginResult = { status: r.status, redirect: r.request.responseURL, data: JSON.stringify(r.data).slice(0, 120) })".
            ".catch(e => window.__loginResult = { error: e.response ? { status: e.response.status, data: JSON.stringify(e.response.data).slice(0, 120) } : String(e) });"
        );
        $browser->pause(2500);
        fwrite(STDERR, "\nLOGIN POST RESULT: ".collect($browser->script("return JSON.stringify(window.__loginResult)"))->first()."\n");

        $url = $browser->driver->getCurrentURL();
        $text = substr(collect($browser->script("return document.body.innerText"))->first() ?: '', 0, 200);
        fwrite(STDERR, "\n[login] url: {$url} | text: {$text}\n");

        if (str_contains($url, 'login')) {
            $browser->waitFor('#email', 5)
                ->type('#email', 'full@example.com')
                ->type('#password', 'password')
                ->press('Login')
                ->pause(2000);
        }

        $cookies = collect($browser->driver->manage()->getCookies())
            ->map(fn ($c) => substr($c['name'], 0, 10).'='.substr($c['value'], 0, 20).'...')
            ->implode(', ');
        fwrite(STDERR, "\nBROWSER COOKIES: {$cookies}\n");

        $rows = \Illuminate\Support\Facades\DB::table('sessions')->orderByDesc('last_activity')->limit(2)
            ->get(['id', 'user_id', 'last_activity'])
            ->map(fn ($r) => substr($r->id, 0, 10)."/u{$r->user_id}")
            ->implode(', ');
        fwrite(STDERR, "SESSION ROWS: {$rows}\n");
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

        file_put_contents('/tmp/opencode/dusk-diag.txt', microtime(true)
            .' url: '.$browser->driver->getCurrentURL()
            .' | text: '.str_replace("\n", ' | ', substr(collect($browser->script("return document.body.innerText"))->first() ?: '', 0, 150))
            ." | textareas: {$values}\n", FILE_APPEND);

        $this->assertStringContainsString($expected, $values);
    }
}
