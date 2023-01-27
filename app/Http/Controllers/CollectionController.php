<?php

namespace App\Http\Controllers;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class CollectionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, ['name' => 'required|string']);

        $collection = $request->user()->collections()->create([
            'name' => $request->name,
            'type' => 'bullet',
        ]);

        return redirect(route('c.show', $collection));
    }

    public function show(Collection $collection): Response
    {
        $this->authorize($collection);

        return Inertia::render('Collection', [
            'collection' => $collection->load('bullets', 'users'),
        ]);
    }

    public function update(Request $request, Collection $collection): RedirectResponse
    {
        $this->authorize($collection);

        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'in:bullet,checklist',
            'hide_done' => 'boolean',
        ]);

        $collection->update($request->only(['name', 'type', 'hide_done']));

        broadcast(new CollectionUpdated($collection->id))->toOthers();

        return redirect(route('c.show', $collection));
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        $this->authorize($collection);

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
