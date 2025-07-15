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
        if (empty($this->item_name)) {
            dd('لا يمكن ترك حقل اسم العنصر فارغ.');
        }
        if (Item::where('name', $this->item_name)->exists()) {
            dd('العنصر موجود.');
        }
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
