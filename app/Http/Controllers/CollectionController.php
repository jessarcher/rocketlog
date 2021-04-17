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

        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'in:bullet,checklist',
            'hide_done' => 'boolean',
        ]);

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
