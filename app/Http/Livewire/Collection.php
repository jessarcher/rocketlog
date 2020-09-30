<?php

namespace App\Http\Livewire;

use App\Models\Bullet;
use App\Models\Collection as CollectionModel;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Collection extends Component
{
    use AuthorizesRequests;

    public CollectionModel $collection;

    public $newBulletName = '';

    public $addUserEmail = '';

    public $confirmingClearDone = false;

    public $confirmingRemoveCollection = false;

    protected $rules = [
        'collection.name' => 'required|string',
        'collection.type' => 'required|in:bullet,checklist',
        'collection.hide_done' => 'required|boolean',
        'addUserEmail' => 'email',
    ];

    protected $listeners = [
        'bulletDeleted' => '$refresh',
        'bulletStateUpdated' => '$refresh',
    ];

    public function render()
    {
        $this->authorize('view', $this->collection);

        return view('livewire.collection', [
            'bullets' => $this->collection->hide_done ?
                $this->collection->bullets()->whereIn('state', ['incomplete', 'note'])->get() :
                $this->collection->bullets()->get()
        ])->layout('layouts.journal');
    }

    public function updated()
    {
        $this->validate();

        $this->authorize('update', $this->collection);

        $this->collection->save();
    }

    public function addBullet()
    {
        if (empty($this->newBulletName)) {
            return;
        }

        $this->authorize('update', $this->collection);

        Bullet::create([
            'name' => $this->newBulletName,
            'type' => 'task',
            'state' => 'incomplete',
            'user_id' => request()->user()->id,
            'collection_id' => $this->collection->id,
        ]);

        $this->reset('newBulletName');
    }

    public function clearDone()
    {
        $this->authorize('update', $this->collection);

        $this->collection->bullets()->where('state', 'complete')->delete();
        $this->confirmingClearDone = false;
    }

    public function delete()
    {
        $this->authorize('delete', $this->collection);

        $this->collection->delete();

        return redirect()->to('/daily-log');
    }

    public function addUser()
    {
        $this->authorize('share', $this->collection);

        $this->validateOnly('addUserEmail');

        $user = User::where('email', $this->addUserEmail)->first();

        if (empty($user)) {
            $this->addError('email', 'A user with this email address was not found.');
        }

        $this->collection->users()->attach($user);

        $this->reset('addUserEmail');

        $this->collection = $this->collection->fresh();
    }

    public function removeUser($userId)
    {
        $this->authorize('share', $this->collection);

        $this->collection->users()->detach($userId);

        $this->collection = $this->collection->fresh();
    }
}
