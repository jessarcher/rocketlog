<?php

namespace App\Http\Controllers;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CollectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);

        $collection = $request->user()->collections()->create([
            'name' => $request->name,
            'type' => 'bullet',
        ]);

        return redirect(route('c.show', $collection));
    }

    public function show(Collection $collection)
    {
        Gate::authorize('view', $collection);

        return Inertia::render('Collection', [
            'collection' => $collection->load('bullets', 'users'),
        ]);
    }

    public function update(Request $request, Collection $collection)
    {
        Gate::authorize('update', $collection);

        $request->validate([
            'name' => 'required|string',
            'type' => 'in:bullet,checklist',
            'hide_done' => 'boolean',
        ]);

        $collection->update($request->only(['name', 'type', 'hide_done']));

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        return redirect(route('c.show', $collection));
    }

    public function destroy(Collection $collection)
    {
        Gate::authorize('delete', $collection);

        $bullets = $collection->bullets;

        $collection->delete();

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        $bullets
            ->filter(fn ($bullet) => $bullet->date)
            ->pluck('user_id')
            ->unique()
            ->each(fn ($userId) => broadcast(new DailyLogUpdated($userId))->toOthers());

        return redirect(route('daily-log.index'));
    }
}
