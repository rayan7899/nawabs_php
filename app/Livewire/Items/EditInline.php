<?php

namespace App\Livewire\Items;

use App\Livewire\Forms\ItemForm;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditInline extends Component
{
    public Item $item;
    public ItemForm $itemForm;

    public function mount()
    {
        $this->itemForm->name = $this->item->name;
        $this->itemForm->category_id = $this->item->category_id;
    }

    public function updateItem(Item $item)
    {
        $this->itemForm->type = $item->type;
        $this->itemForm->update($item);
        LivewireAlert::title(__('Item updated successfully'))
            ->success()->asToast()->show();
    }
    public function render()
    {
        return view('livewire.items.edit-inline');
    }
}
