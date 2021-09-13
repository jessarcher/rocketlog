<?php

namespace App\Http\Controllers;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionBulletDoneController extends Controller
{
    public function destroy(Collection $collection)
    {
        $this->authorize('update', $collection);

        $completeBullets = $collection->bullets()->whereState('complete')->get();

        $completeBullets->each->delete();

        CollectionUpdated::dispatch($collection);

        $completeBullets
            ->filter(fn ($bullet) => $bullet->date)
            ->pluck('user')
            ->unique()
            ->each(fn ($user) => DailyLogUpdated::dispatch($user));

        return redirect(route('c.show', $collection));
    }
}
