<?php

namespace App\Http\Livewire;

use App\Models\Bullet as BulletModel;
use Livewire\Component;

class Bullet extends Component
{
    public BulletModel $bullet;

    public string $type;

    public ?string $fade;

    protected $rules = [
        'bullet.name' => 'required|string',
        'bullet.state' => 'required|in:incomplete,complete,note,migrated,scheduled,event',
    ];

    public function render()
    {
        return view('livewire.bullet');
    }

    public function updated()
    {
        $this->validate();

        $this->bullet->save();
    }

    public function updatedBulletState()
    {
        $this->emitUp('bulletStateUpdated');
    }

    public function delete()
    {
        $this->bullet->delete();
        $this->emitUp('bulletDeleted');
    }

    public function migrate($collectionId = null)
    {
        request()->user()->bullets()->create([
            'name' => $this->bullet->name,
            'type' => $this->bullet->type,
            'collection_id' => $collectionId,
            'state' => 'incomplete',
        ]);

        $this->emitUp('bulletMigrated');
    }
}
