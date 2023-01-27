<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $this->validate($request, [
            'dismissed_welcome' => ['nullable', 'boolean'],
        ]);

        $user->preferences = array_merge(
            $user->preferences ?? [],
            $request->only(['dismissed_welcome'])
        );

        $user->save();

        return $user->preferences;
    }
}
