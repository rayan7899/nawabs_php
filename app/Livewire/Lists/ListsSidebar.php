<?php

namespace App\Livewire\Lists;

use App\Livewire\Forms\ListForm;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class ListsSidebar extends Component
{
    const LIST_COUNT_LIMIT = 3;

    public $isAddingList = false;
    public User $user;
    public ListForm $listForm;

    function mount()
    {
        $this->user = Auth::user();
        $this->listForm->setUser($this->user);
    }

    public function getUserListsProperty()
    {
        return $this->user->lists;
    }

    public function startAddingList()
    {
        if ($this::LIST_COUNT_LIMIT <= count($this->user->lists)) {
            LivewireAlert::title(__('Can not add new list.'))
                ->text(__('You have reached the maximum number of lists allowed.'))
                ->error()
                ->asToast()
                ->timer(10000)
                ->show();
            return;
        }
        $this->isAddingList = true;
    }

    public function cancelAddingList()
    {
        $this->isAddingList = false;
        $this->listForm->name = '';
    }

    public function createList()
    {
        if ($this::LIST_COUNT_LIMIT <= count($this->user->lists)) {
            LivewireAlert::title(__('Can not add new list.'))
                ->text(__('You have reached the maximum number of lists allowed.'))
                ->error()
                ->asToast()
                ->timer(10000)
                ->show();
            return;
        }

        $this->listForm->create();
        $this->isAddingList = false;
        $this->user->load('lists');
    }

    public function render()
    {
        return view('livewire.lists.lists-sidebar');
    }
}