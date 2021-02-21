<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionBulletDoneController extends Controller
{
    public function destroy(Collection $collection)
    {
        $this->authorize('update', $collection);

        $collection->bullets()->whereState('complete')->delete();

        return redirect(route('c.show', $collection));
    }
}
