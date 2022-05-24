<?php

namespace App\Http\Controllers;

use App\Models\Bullet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FutureLogController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('FutureLog', [
            //
        ]);
    }

    public function store(Request $request)
    {
        if (empty($request->name)) {
            return;
        }

        $request->user()->bullets()->create([
            'date' => $request->date,
            'name' => $request->name,
            'type' => 'task',
            'state' => 'incomplete',
        ]);

        return redirect(route('future-log.index'));
    }

    public function update(Request $request, Bullet $bullet)
    {
        $this->authorize('update', $bullet);

        $bullet->update($request->only(['name', 'state', 'date']));

        return redirect(route('future-log.index'));
    }

    public function move(Request $request)
    {
        $bullet = Bullet::find($request->id);
        abort_if($bullet === null, 400, 'Invalid bullet');

        $this->authorize('update', $bullet);

        $bullet->collection_id = null;
        $bullet->date = $request->input('date');
        $bullet->save();

        return back();
    }

    public function destroy(Bullet $bullet)
    {
        $this->authorize('delete', $bullet);

        $bullet->delete();

        return redirect(route('daily-log.index'));
    }
}
