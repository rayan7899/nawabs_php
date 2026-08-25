<?php

namespace App\Livewire\Lists;

use App\Livewire\Forms\ListForm;
use App\Models\ItemList;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class Edit extends Component
{
    public ListForm $listForm;

    public function mount(ItemList $list)
    {
        $this->listForm->setList($list);
    }

    public function save()
    {
        $this->validate();
        try {
            $this->alert('test');
            if ($this->listForm->update()) {
                LivewireAlert::title(__("List updated successfully"))
                    ->success()->asToast()->show();
                $this->redirectRoute('lists.manage', ['list' => $this->listForm->list->id]);
            }else{
                LivewireAlert::title(__("Error"))->text(__("error occurred while edit list"))
                    ->error()->timerProgressBar()->show();
            }
        } catch (\Throwable $th) {
            LivewireAlert::title(__("Error"))->text(__("error occurred while edit list"))
                ->error()->timerProgressBar()->show();
            Log::critical($th);
        }
    }

    public function render()
    {
        return view('livewire.lists.edit');
    }
}
