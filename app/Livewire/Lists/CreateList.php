<?php

namespace App\Livewire\Lists;

use App\Livewire\Forms\ListForm;
use Livewire\Component;

class CreateList extends Component
{
    public ListForm $listForm;

    public function save()
    {
        $list = $this->listForm->create();
        if($list){
            $this->redirectRoute('lists.manage', ['list'=>$list->id]);
        }
        $this->modal('create-list')->close();
        $this->reset('listForm.name');
    }

    public function render()
    {
        return view('livewire.lists.create-list');
    }
}