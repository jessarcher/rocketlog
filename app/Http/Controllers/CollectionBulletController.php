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

        $bullet->update($request->only(['name', 'state']));

        return redirect(route('c.show', $collection));
    }

    public function destroy(Request $request, Collection $collection, Bullet $bullet)
    {
        $this->authorize('update', $collection);

        $bullet->delete();

        return redirect(route('c.show', $collection));
    }
}
