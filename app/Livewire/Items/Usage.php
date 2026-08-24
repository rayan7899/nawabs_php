<?php

namespace App\Livewire\Items;

use App\Models\Item;
use App\Models\ItemList;
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
        // $this->authorize('view-item-usages', $this->list);
        return $this->item->itemUsages ?? [];
    }

    public function render()
    {
        return view('livewire.items.usage');
    }
}
