<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    public $item_name;

    public function save()
    {
        try {
            Item::create([
                'name' => $this->item_name,
                'active' => false,
            ]);
            $this->item_name = '';
        } catch (\Throwable $th) {
            dd($th);
            Log::error($th);
        }
    }

    public function render()
    {
        return view('livewire.items.add');
    }
}
