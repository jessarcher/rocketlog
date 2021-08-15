<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|string']);

        $collection = $request->user()->collections()->create([
            'name' => $request->name,
            'type' => 'bullet',
        ]);

        return redirect(route('c.show', $collection));
    }

    public function show(Request $request, Collection $collection)
    {
        $this->authorize($collection);

        if ($request->query('hashonly')) {
            return $collection->hash;
        }

        return Inertia::render('Collection', ['collection' => $collection, 'hash' => $collection->hash]);
    }

    public function update(Collection $collection, Request $request)
    {
        $this->authorize($collection);

        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'in:bullet,checklist',
            'hide_done' => 'boolean',
        ]);

        $collection->update($request->only(['name', 'type', 'hide_done']));

        $collection->clearCache();

        return redirect(route('c.show', $collection));
    }

    public function destroy(Request $request, Collection $collection)
    {
        $this->authorize($collection);

        $collection->clearCache();
        $collection->delete();

        $request->user()->clearDailyLogCache();

        return redirect(route('daily-log.index'));
    }
}
