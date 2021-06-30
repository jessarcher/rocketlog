<?php

namespace App\Http\Controllers;

use App\Models\Bullet;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionBulletController extends Controller
{
    public function store(Request $request, Collection $collection)
    {
        $this->authorize('update', $collection);

        $collection->bullets()->create([
            'date' => $request->date,
            'name' => $request->name,
            'type' => 'task',
            'state' => 'incomplete',
            'user_id' => $request->user()->id,
        ]);

        return redirect(route('c.show', $collection));
    }

    public function update(Request $request, Collection $collection, Bullet $bullet)
    {
        $this->authorize('update', $collection);

        $bullet->update($request->only(['name', 'date', 'state']));

        return redirect(route('c.show', $collection));
    }

    public function move(Request $request, Collection $collection)
    {
        $this->authorize('update', $collection);

        $bullet = Bullet::find($request->id);
        abort_if($bullet === null, 400, 'Invalid bullet');
        $this->authorize('update', $bullet);

        $bullet->collection_id = $collection->id;
        $bullet->date = $request->date;
        $bullet->save();

        return back();
    }

    public function destroy(Request $request, Collection $collection, Bullet $bullet)
    {
        $this->authorize('update', $collection);

        $bullet->delete();

        return redirect(route('c.show', $collection));
    }
}
