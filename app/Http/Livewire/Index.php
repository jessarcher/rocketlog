<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Index extends Component
{
    public $newCollectionName = '';

    public function render()
    {
        return view('livewire.index', [
            'collections' => request()->user()->currentTeam->collections
        ]);
    }

    public function addCollection()
    {
        $collection = request()->user()->currentTeam->collections()->create([
            'name' => $this->newCollectionName,
            'type' => 'bullet',
        ]);

        $this->reset();

        return redirect()->to(route('collections', $collection));
    }
}
