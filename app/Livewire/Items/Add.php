<?php

namespace App\Livewire\Items;

use App\Enums\ListItemStatus;
use App\Livewire\Forms\CategoryForm;
use App\Livewire\Forms\ItemForm;
use App\Models\ItemList;
use App\Models\ListItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class Add extends Component
{
    public ItemList $list;
    public ItemForm $itemForm;
    public CategoryForm $categoryForm;

    public function setCategoryId(): bool {
        $this->categoryForm->list_id = $this->list->id;
        $category = $this->categoryForm->firstOrCreate(); // get category
        if ($category) {
            $this->itemForm->category_id = $category->id; // if got category assign its id to item form
            return true;
        }else {
            LivewireAlert::title(__('Error while getting category.'))
                ->error()->timerProgressBar()->show();
            DB::rollBack();
            Log::error("Error while getting category. \n in ". __FILE__ . ':' . __LINE__);
            return false;
        }
    }

    public function add(): void
    {
        if($this->list->items()->where('items.name', 'like', $this->itemForm->name)->exists()){
            LivewireAlert::title(__('Item is already added before.'))
            ->warning()->timerProgressBar()->show();
            return;
        }
        DB::beginTransaction();
        $this->setCategoryId();
        $newItem = $this->itemForm->firstOrCreate(); // get item if exists or create new one 
        if ($newItem) {
            LivewireAlert::title(__('Item added successfully.'))
                ->success()->asToast()->show();
            $this->reset(['itemForm.name', 'categoryForm.name']);
            DB::commit();
            return;
        } else {
            LivewireAlert::title(__('Error while adding new item.'))
                ->error()->show();
            DB::rollBack();
            Log::error("Error while adding new item. \n in ". __FILE__ . ':' . __LINE__);
            return;
        }
    }

    public function render()
    {
        return view('livewire.items.add');
    }
}
