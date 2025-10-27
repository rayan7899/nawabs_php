<?php

namespace App\Livewire\Lists;

use Livewire\Component;
use App\Models\ItemList;
use Illuminate\Support\Facades\Auth;

class CreateList extends Component
{
    public $name = '';

    public function create()
    {
        $this->validate([
            'name' => 'required|min:3'
        ]);

        ItemList::create([
            'name' => $this->name,
            'user_id' => Auth::id(),
            'is_default' => false
        ]);

        $this->dispatch('list-created');
        $this->dispatch('close-modal');
        $this->reset('name');
    }

    public function render()
    {
        return view('livewire.lists.create-list');
    }
}