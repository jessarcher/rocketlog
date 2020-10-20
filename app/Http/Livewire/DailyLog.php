<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;

class DailyLog extends Component
{
    public User $user;

    protected $listeners = [
        'bulletDeleted' => '$refresh',
        'bulletMigrated' => '$refresh',
        'bulletStateUpdated' => '$refresh',
    ];

    protected $rules = [
        'user.timezone' => 'string',
    ];

    public function mount()
    {
        $this->user = request()->user();
    }

    public function render()
    {
        $dates = request()
            ->user()
            ->bullets()
            ->select('date')
            ->distinct()
            ->whereNotNull('date')
            ->whereNull('collection_id')
            ->latest('date')
            ->take(5)
            ->pluck('date')
            ->prepend(now()->timezone($this->user->timezone)->format('Y-m-d'))
            ->unique()
            ->sortDesc()
            ->take(5);

        $bulletsByDate = request()
            ->user()
            ->bullets()
            ->oldest()
            ->whereDate('created_at', '<=', $dates->first())
            ->whereDate('created_at', '>=', $dates->last())
            ->whereNull('collection_id')
            ->get()
            ->groupBy(fn ($bullet) => $bullet->created_at->timezone($this->user->timezone)->format('Y-m-d'));

        return view('livewire.daily-log', [
            'days' => $dates->map(fn ($date) => (object) [
                'date' => new Carbon($date),
                'bullets' => $bulletsByDate->get($date) ?? []
            ]),
        ])->layout('layouts.journal');
    }

    public function addBullet($value)
    {
        if (empty($value)) {
            return;
        }

        request()->user()->bullets()->create([
            'date' => now()->timezone(request()->user()->timezone),
            'name' => $value,
            'type' => 'task',
            'state' => 'incomplete',
        ]);
    }

    public function updatedUserTimezone()
    {
        $this->user->save();
    }
}
