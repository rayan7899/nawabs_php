<?php

namespace App\Livewire\Items;

use App\Models\Item;
use App\Models\ItemList;
use App\Models\ListItem;
use Livewire\Component;

class Usage extends Component
{
    public ItemList $list;
    public Item $item;

    public function mount()
    {
        $this->list = ItemList::findOrFail(request('li')); // li means list_id
    }

    public function getUsagesProperty()
    {
        // TODO: insure the user can see the item usage
        $listItem = ListItem::where('item_id', $this->item->id)
            ->where('list_id', $this->list->id)
            ->first();
        return $listItem->itemUsages ?? [];
    }

    public function render()
    {
        return view('livewire.items.usage');
    }
}
