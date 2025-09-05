<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Component;

class Usage extends Component
{
    public $item;
    public $usages;
    public function mount(Item $item)
    {
        $this->item = $item;
        $this->usages = $item->itemUsage()->latest()->get();
    }
    
    public function render()
    {
        return view('livewire.items.usage');
    }
}
