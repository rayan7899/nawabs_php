<?php

namespace App\Livewire\Lists;

use Livewire\Component;
use App\Models\ItemList;
use Illuminate\Support\Facades\Auth;

class ListsSidebar extends Component
{
    public $newListName = '';
    public $isAddingList = false;

    public function getUserListsProperty()
    {
        return Auth::user()->lists;
    }

    public function startAddingList()
    {
        $this->isAddingList = true;
    }

    public function cancelAddingList()
    {
        $this->isAddingList = false;
        $this->newListName = '';
    }

    public function createList()
    {
        $this->validate([
            'newListName' => 'required|min:3'
        ]);

        ItemList::create([
            'user_id' => Auth::id(),
            'name' => $this->newListName,
            'is_default' => false
        ]);

        $this->newListName = '';
        $this->isAddingList = false;
    }

    public function render()
    {
        return view('livewire.lists.lists-sidebar');
    }
}