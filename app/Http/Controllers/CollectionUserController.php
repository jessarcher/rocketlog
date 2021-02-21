<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\Request;

class CollectionUserController extends Controller
{
    public function store(Request $request, Collection $collection)
    {
        $this->authorize('update', $collection);

        $user = User::where('email', $request->email)->first();

        $this->invalidIf($user === null, 'email', 'A user with this email address was not found.');

        $collection->users()->attach($user);

        return redirect(route('c.show', $collection));
    }

    public function destroy(Collection $collection, User $user)
    {
        $this->authorize('update', $collection);

        $collection->users()->detach($user);

        return redirect(route('c.show', $collection));
    }
}
