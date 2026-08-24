<?php

namespace App\Livewire\Lists;

use App\Models\Item;
use App\Models\ItemList;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class Categories extends Component
{
    public ItemList $list;

    public function mount(ItemList $list)
    {
        $this->list = $list;
    }

    public function getCategoriesWithItemsProperty()
    {
        return $this->list->categoriesWithItems;
    }

    public function removeItemFromList($itemId)
    {
        try {
            // TODO ask user if he sure to delete item
            Item::find($itemId)->delete();
            LivewireAlert::title(__('Item deleted successfully.'))
                ->success()
                ->asToast()
                ->show();
        } catch (\Throwable $th) {
            Log::error('Error deleting item: ' . $th->getMessage());
            LivewireAlert::title(__('Error deleting item.') . $th->getCode())
                ->timer(4000)->timerProgressBar(true)->error()->show();
        }
    }

    public function addItemToList(Item $itemId)
    {
        try {
            $this->list->items()->attach($itemId);
            LivewireAlert::title(__('Item added successfully.'))
                ->success()
                ->asToast()
                ->show();
        } catch (\Throwable $th) {
            Log::error('Error adding item: ' . $th->getMessage());
            LivewireAlert::title(__('Error adding item.') . $th->getCode())
                ->timer(4000)->timerProgressBar(true)->error()->show();
        }
    }

    public function render()
    {
        return view('livewire.lists.categories');
    }
}
