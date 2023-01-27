<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUserToCollectionRequest;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class CollectionUserController extends Controller
{
    public function store(InviteUserToCollectionRequest $request, Collection $collection): RedirectResponse
    {
        $collection->users()->attach($request->invitedUser);

        return redirect(route('c.show', $collection));
    }

    public function destroy(Collection $collection, User $user): RedirectResponse
    {
        $this->authorize('update', $collection);

        $collection->users()->detach($user);

        return redirect(route('c.show', $collection));
    }
}
