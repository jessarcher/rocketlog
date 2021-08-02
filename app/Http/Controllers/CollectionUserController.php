<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUserToCollectionRequest;
use App\Models\Collection;
use App\Models\User;

class CollectionUserController extends Controller
{
    public function store(InviteUserToCollectionRequest $request, Collection $collection)
    {
        $collection->users()->attach($request->invitedUser);

        return redirect(route('c.show', $collection));
    }

    public function destroy(Collection $collection, User $user)
    {
        $this->authorize('update', $collection);

        $collection->users()->detach($user);

        return redirect(route('c.show', $collection));
    }
}
