<?php

namespace App\Livewire\Lists;

use App\Livewire\Forms\ListForm;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class ListsSidebar extends Component
{
    public $isAddingList = false;
    public User $user;
    public ListForm $listForm;

    function mount()
    {
        $this->user = Auth::user();
    }

    public function getUserListsProperty()
    {
        return $this->user->lists;
    }

    public function startAddingList()
    {
        $this->isAddingList = true;
    }

    public function cancelAddingList()
    {
        $this->isAddingList = false;
        $this->listForm->name = '';
    }

    public function createList()
    {
        $this->listForm->create();
        $this->isAddingList = false;
        $this->user->load('lists');
    }

    public function render()
    {
        return view('livewire.lists.lists-sidebar');
    }
}