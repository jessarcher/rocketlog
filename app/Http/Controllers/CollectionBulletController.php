<?php

namespace App\Http\Controllers;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Bullet;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionBulletController extends Controller
{
    public function store(Request $request, Collection $collection)
    {
        $this->authorize('update', $collection);

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
        $this->authorize('update', $collection);

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
        $this->authorize('update', $collection);

        $bullet = Bullet::find($request->id);
        abort_if($bullet === null, 400, 'Invalid bullet');
        $this->authorize('update', $bullet);

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
        $this->authorize('update', $collection);

        $bullet->delete();

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        if ($bullet->date) {
            broadcast(new DailyLogUpdated($bullet->user_id))->toOthers();
        }

        return redirect(route('c.show', $collection));
    }
}
