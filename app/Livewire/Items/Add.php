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

    public function rules()
    {
        return [
            'item_name' => ['required', 'string', 'unique:items,name'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages()
    {
        return [
            'item_name.required' => 'يجب إدخال اسم العنصر.',
            'item_name.unique' => 'هذا العنصر موجود مسبقاً.',
            'category_id.required' => 'يجب اختيار تصنيف.',
            'category_id.exists' => 'التصنيف المختار غير صالح.',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            category::find($this->category_id)->items()->create([
                'name' => $this->item_name,
                'active' => false,
            ]);
            
            session()->flash('success', 'تم إضافة العنصر بنجاح.');
            $this->reset(['item_name', 'category_id']);
            $this->dispatch('reset-search');
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'حدث خطأ أثناء إضافة العنصر.');
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
