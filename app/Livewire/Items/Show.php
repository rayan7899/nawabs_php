<?php

namespace App\Livewire\Items;

use App\Models\category;
use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Show extends Component
{
    public $search = '';

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
        $categories = category::whereHas('items', function ($q) {
            if ($this->search) {
                $q->where('name', 'like', '%' . $this->search . '%');
            }
        })->with(['items' => function ($q) {
            if ($this->search) {
                $q->where('name', 'like', '%' . $this->search . '%');
            }
        }])->orderBy('name')->get();

        return view('livewire.items.show', [
            'categories' => $categories,
        ]);
    }
}
