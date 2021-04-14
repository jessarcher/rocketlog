<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionController extends Controller
{
    public function store(Request $request)
    {
        $collection = $request->user()->collections()->create([
            'name' => $request->name,
            'type' => 'bullet',
        ]);

        return redirect(route('c.show', $collection));
    }

    public function show(Collection $collection)
    {
        $this->authorize($collection);

        return Inertia::render('Collection', [
            'collection' => $collection->load('bullets', 'users'),
        ]);
    }

    public function update(Collection $collection, Request $request)
    {
        $this->authorize($collection);

        $collection->update($request->only(['name', 'type', 'hide_done']));

        return redirect(route('c.show', $collection));
    }

    public function destroy(Collection $collection)
    {
        $this->authorize($collection);

        $collection->delete();

        return redirect(route('daily-log.index'));
    }
}
