<?php

namespace App\Http\Controllers;

use App\Models\Bullet;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CollectionOrderController extends Controller
{
    public function update(Request $request, Collection $collection): RedirectResponse
    {
        $this->authorize($collection);

        $orderedIds = $request->json()->all();

        Bullet::query()
            ->select('collection_id')
            ->distinct()
            ->whereIn('id', $orderedIds)
            ->pluck('collection_id')
            ->when(fn ($ids) => $ids->count() !== 1, fn () => abort(403, 'Cannot update bullet order for multiple collections'))
            ->when(fn ($ids) => $ids->first() !== $collection->id, fn () => abort(403, 'Bullets do not belong to this collection'));

        Bullet::setNewOrder($orderedIds);

        return redirect(route('c.show', $collection));
    }
}
