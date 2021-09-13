<?php

namespace App\Http\Controllers;

use App\Events\CollectionUpdated;
use App\Events\DailyLogUpdated;
use App\Models\Bullet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DailyLogController extends Controller
{
    public function index(Request $request)
    {
        $dates = $request
            ->user()
            ->bullets()
            ->toBase()
            ->select('date')
            ->distinct()
            ->whereNotNull('date')
            ->latest('date')
            ->take(6)
            ->pluck('date');

        if ($dates->isNotEmpty()) {
            $bulletsByDate = $request
                ->user()
                ->bullets()
                ->oldest()
                ->whereDate('date', '<=', $dates->first())
                ->whereDate('date', '>=', $dates->last())
                ->get()
                ->groupBy(fn ($bullet) => $bullet->date->format('Y-m-d'));
        }

        return Inertia::render('DailyLog', [
            'days' => $dates->map(fn ($date) => (object) [
                'date' => $date,
                'bullets' => $bulletsByDate?->get($date) ?? [],
            ]),
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

        DailyLogUpdated::dispatch($request->user());

        return redirect(route('daily-log.index'));
    }

    public function update(Request $request, Bullet $bullet)
    {
        $this->authorize($bullet);

        $bullet->update($request->only(['name', 'state', 'date']));

        DailyLogUpdated::dispatch($request->user());

        if ($bullet->collection) {
            CollectionUpdated::dispatch($bullet->collection);
        }

        return redirect(route('daily-log.index'));
    }

    public function move(Request $request)
    {
        $bullet = Bullet::find($request->id);
        abort_if($bullet === null, 400, 'Invalid bullet');

        $this->authorize('update', $bullet);

        if ($bullet->collection) {
            CollectionUpdated::dispatch($bullet->collection);
        }

        $bullet->collection_id = null;
        $bullet->date = $request->input('date');
        $bullet->save();

        DailyLogUpdated::dispatch($request->user());

        return back();
    }

    public function destroy(Request $request, Bullet $bullet)
    {
        $this->authorize($bullet);

        $bullet->delete();

        DailyLogUpdated::dispatch($request->user());

        if ($bullet->collection) {
            CollectionUpdated::dispatch($bullet->collection);
        }

        return redirect(route('daily-log.index'));
    }
}
