<?php

namespace App\Livewire\Forms;

use App\Enums\ItemTypeEnum;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Form;

class ItemForm extends Form
{
    const MAX_ITEM_COUNT = 128;
    public $name, $category_id, $type;

    protected function rules()
    {
        return [
            'name'          => ['required', 'string', 'min:1', 'max:16'],
            'category_id'   => ['required', 'exists:categories,id'],
            'type'          => ['required', Rule::enum(ItemTypeEnum::class)],
        ];
    }

    /**
     * This function create new item.
     * return the item if creation is done or return false if not.
     * @return Item|bool
     */
    public function create(): Item|bool
    {
        if(Category::find($this->category_id)->list->items->count() >= $this::MAX_ITEM_COUNT){
            LivewireAlert::title(__('Can not add new item.'))
                ->text(__('You have reached the maximum number of items allowed per list.'))
                ->error()->asToast()->timer(10000)
                ->show();
            return false;
        }
        $this->type = ItemTypeEnum::CUSTOM->value;
        $this->validate();
        try {
            $item = Item::create([
                'name'          => $this->name,
                'type'          => $this->type,
                'category_id'   => $this->category_id,
                'created_by'    => Auth::id()
            ]);
            return $item;
        } catch (\Throwable $th) {
            Log::critical($th);
            return false;
        }
    }

    /**
     * Search for record then if not found create new one.
     * return item if process is done or false if fail
     * @return Item|bool
     */
    public function firstOrCreate(): Item|bool
    {
        if(Category::find($this->category_id)->list->items->count() >= $this::MAX_ITEM_COUNT){
            LivewireAlert::title(__('Can not add new item.'))
                ->text(__('You have reached the maximum number of items allowed per list.'))
                ->error()->asToast()->timer(10000)
                ->show();
            return false;
        }
        $this->type = ItemTypeEnum::CUSTOM->value; // always make new items as custom, only admin can make it default.
        $this->validate();
        try {
            return Item::query()->firstOrCreate(
                ['name' => trim($this->name), 'category_id' => $this->category_id],
                ['type' => $this->type, 'created_by' => Auth::id()]
            );
        } catch (\Throwable $th) {
            Log::critical($th);
            return false;
        }
    }

    public function update(Item $item)
    {
        $this->validate();
        try {
            $item->update([
                'name'          => $this->name,
                'category_id'   => $this->category_id,
            ]);
            return true;
        } catch (\Throwable $th) {
            Log::critical($th);
            return false;
        }
    }
}
