<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Show extends Component
{
    public $items;

    public function mount()
    {
        $this->items = Item::orderBy('name')->get();
    }

    public function toggleItem(Item $item)
    {
        try {
            $item->update([
                'active' => !$item->active,
            ]);
            $this->redirectRoute('showItems', navigate: true);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.items.show');
    }
}
