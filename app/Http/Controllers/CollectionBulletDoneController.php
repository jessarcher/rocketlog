<?php

namespace App\Http\Controllers;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Collection;

class CollectionBulletDoneController extends Controller
{
    public function destroy(Collection $collection)
    {
        $this->authorize('update', $collection);

        $completeBullets = $collection->bullets()->whereState('complete')->get();

        $completeBullets->each->delete();

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        $completeBullets
            ->filter(fn ($bullet) => $bullet->date)
            ->pluck('user_id')
            ->unique()
            ->each(fn ($userId) => broadcast(new DailyLogUpdated($userId))->toOthers());

        return redirect(route('c.show', $collection));
    }
}
