<?php

namespace App\Http\Controllers;

use App\Models\Bullet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            ->whereNull('collection_id')
            ->latest('date')
            ->take(5)
            ->pluck('date');

        $bulletsByDate = $request
            ->user()
            ->bullets()
            ->oldest()
            ->whereDate('date', '<=', $dates->first())
            ->whereDate('date', '>=', $dates->last())
            ->whereNull('collection_id')
            ->get()
            ->groupBy(fn ($bullet) => $bullet->date->format('Y-m-d'));

        return Inertia::render('DailyLog', [
            'days' => $dates->map(fn ($date) => (object) [
                'date' => $date,
                'bullets' => $bulletsByDate->get($date) ?? []
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

        return redirect(route('daily-log.index'));
    }

    public function update(Request $request, Bullet $bullet)
    {
        $bullet->update($request->only(['name', 'state', 'date']));

        return redirect(route('daily-log.index'));
    }

    public function destroy(Request $request, Bullet $bullet)
    {
        $bullet->delete();

        return redirect(route('daily-log.index'));
    }
}