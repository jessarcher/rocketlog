<?php

namespace App\Http\Controllers;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Bullet;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CollectionBulletController extends Controller
{
    public function store(Request $request, Collection $collection)
    {
        Gate::authorize('update', $collection);

        $collection->bullets()->create([
            'name' => $request->name,
            'type' => 'task',
            'state' => 'incomplete',
            'user_id' => $request->user()->id,
        ]);

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        return redirect(route('c.show', $collection));
    }

    public function update(Request $request, Collection $collection, Bullet $bullet)
    {
        Gate::authorize('update', $collection);

        abort_if($bullet->collection_id !== $collection->id, 404);

        $bullet->update($request->only(
            array_merge(['name', 'state'], $bullet->user_id === $request->user()->id ? ['date'] : [])
        ));

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        if ($bullet->date) {
            broadcast(new DailyLogUpdated($bullet->user_id))->toOthers();
        }

        return redirect(route('c.show', $collection));
    }

    public function move(Request $request, Collection $collection)
    {
        Gate::authorize('update', $collection);

        $bullet = Bullet::find($request->id);
        abort_if($bullet === null, 400, 'Invalid bullet');
        Gate::authorize('update', $bullet);

        if ($bullet->collection_id === null) {
            $bullet->date = null;
        }
        $bullet->collection_id = $collection->id;
        $bullet->save();
        $bullet->moveToEnd();

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        if ($bullet->date) {
            broadcast(new DailyLogUpdated($bullet->user_id))->toOthers();
        }

        return back();
    }

    public function destroy(Collection $collection, Bullet $bullet)
    {
        Gate::authorize('update', $collection);

        abort_if($bullet->collection_id !== $collection->id, 404);

        $bullet->delete();

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        if ($bullet->date) {
            broadcast(new DailyLogUpdated($bullet->user_id))->toOthers();
        }

        return redirect(route('c.show', $collection));
    }
}
