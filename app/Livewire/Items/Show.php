<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Illuminate\Support\Facades\Log;
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
            $this->skipRender();
        } catch (\Throwable $th) {
            Log::error($th);
            dd('Error updating item: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.items.show');
    }
}
