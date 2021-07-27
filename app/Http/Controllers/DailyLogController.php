<?php

namespace App\Http\Controllers;

use App\Models\Bullet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DailyLogController extends Controller
{
    public function index(Request $request)
    {
        [$dates, $bulletsByDate, $hash] = Cache::remember(
            "users.{$request->user()->id}.daily-log",
            now()->addDays(1),
            function () use ($request) {
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

                return [
                    $dates,
                    $bulletsByDate ?? null,
                    isset($bulletsByDate) ? md5($bulletsByDate->toJson()) : null
                ];
            }
        );

        if ($request->query('hashonly')) {
            return $hash;
        }

        return Inertia::render('DailyLog', [
            'days' => $dates->map(fn ($date) => (object) [
                'date' => $date,
                'bullets' => $bulletsByDate?->get($date) ?? [],
            ]),
            'hash' => $hash,
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

        $request->user()->clearDailyLogCache();

        return redirect(route('daily-log.index'));
    }

    public function update(Request $request, Bullet $bullet)
    {
        $this->authorize($bullet);

        $bullet->update($request->only(['name', 'state', 'date']));

        $request->user()->clearDailyLogCache();

        if ($bullet->collection_id) {
            $bullet->collection->clearCache();
        }

        return redirect(route('daily-log.index'));
    }

    public function move(Request $request)
    {
        $bullet = Bullet::find($request->id);
        abort_if($bullet === null, 400, 'Invalid bullet');

        $this->authorize('update', $bullet);

        if ($bullet->collection_id) {
            $bullet->collection->clearCache();
        }

        $bullet->collection_id = null;
        $bullet->date = $request->input('date');
        $bullet->save();

        $request->user()->clearDailyLogCache();

        return back();
    }

    public function destroy(Request $request, Bullet $bullet)
    {
        $this->authorize($bullet);

        if ($bullet->collection_id) {
            $bullet->collection->clearCache();
        }

        $bullet->delete();

        $request->user()->clearDailyLogCache();

        return redirect(route('daily-log.index'));
    }
}
