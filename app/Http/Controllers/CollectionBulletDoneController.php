<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionBulletDoneController extends Controller
{
    public function destroy(Request $request, Collection $collection)
    {
        $this->authorize('update', $collection);

        $bullets = $collection->bullets()->whereState('complete')->get();

        if ($bullets->contains(fn ($bullet) => $bullet->date)) {
            $request->user()->clearDailyLogCache();
        }

        $bullets->each->delete();

        $collection->clearCache();

        return redirect(route('c.show', $collection));
    }
}
