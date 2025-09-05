<?php

namespace App\Livewire\Items;

use App\Models\category;
use App\Models\Item;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    public $item_name;
    public $category_id = '';
    public $categories = [];

    public function mount()
    {
        $this->categories = category::all();
    }

    public function save()
    {
        if (empty($this->item_name) || empty($this->category_id)) {
            dd('لا يمكن ترك حقل اسم العنصر او التصنيف فارغ.');
        }
        if (Item::where('name', $this->item_name)->exists()) {
            dd('العنصر موجود.');
        }
        try {
            category::find($this->category_id)->items()->create([
                'name' => $this->item_name,
                'active' => false,
            ]);
            $this->reset(['item_name']);
            $this->dispatch('reset-search');
        } catch (\Throwable $th) {
            dd($th);
            Log::error($th);
        }
    }

    public function delete()
    {
        if (empty($this->item_name)) {
            dd('لا يمكن ترك حقل اسم العنصر فارغ.');
        }
        if (!Item::where('name', $this->item_name)->exists()) {
            dd('العنصر غير موجود.');
        }
        try {
            Item::where('name', $this->item_name)->delete();
            $this->item_name = '';
        } catch (\Throwable $th) {
            Log::error($th);
            dd('Error updating item: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.items.add');
    }
}
