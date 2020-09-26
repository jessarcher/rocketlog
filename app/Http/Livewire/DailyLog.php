<?php

namespace App\Http\Livewire;

use App\Models\Bullet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DailyLog extends Component
{
    public $newBulletName = '';

    protected $listeners = [
        'bulletDeleted' => '$refresh',
        'bulletMigrated' => '$refresh',
        'bulletStateUpdated' => '$refresh',
    ];

    public function render()
    {
        $dates = request()
            ->user()
            ->bullets()
            ->select(DB::raw('DISTINCT DATE(created_at) as date'))
            ->whereNull('collection_id')
            ->latest('date')
            ->take(5)
            ->pluck('date')
            ->prepend(date('Y-m-d'))
            ->unique()
            ->take(5);

        $bulletsByDate = request()
            ->user()
            ->bullets()
            ->oldest()
            ->whereDate('created_at', '<=', $dates->first())
            ->whereDate('created_at', '>=', $dates->last())
            ->whereNull('collection_id')
            ->get()
            ->groupBy(fn ($bullet) => $bullet->created_at->format('Y-m-d'));

        return view('livewire.daily-log', [
            'days' => $dates->map(fn ($date) => (object) [
                'date' => new Carbon($date),
                'bullets' => $bulletsByDate->get($date) ?? []
            ]),
        ])->layout('layouts.journal');
    }

    public function addBullet()
    {
        if (empty($this->newBulletName)) {
            return;
        }

        request()->user()->bullets()->create([
            'name' => $this->newBulletName,
            'type' => 'task',
            'state' => 'incomplete',
        ]);

        $this->reset('newBulletName');
        $this->dispatchBrowserEvent('bullet-added');
    }
}
