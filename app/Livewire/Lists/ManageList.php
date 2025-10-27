<?php

namespace App\Livewire\Lists;

use Livewire\Component;
use App\Models\ItemList;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ManageList extends Component
{
    public $list;
    public $search = '';
    public $selectedCategory = null;
    public $newItemName = '';
    public $newItemCategoryId = null;
    
    public function mount(ItemList $list)
    {
        $this->list = $list;
        if (!$this->list->user_id === Auth::id()) {
            abort(403);
        }
    }

    public function getCategoriesForSelectionProperty()
    {
        return Category::orderBy('name')->get();
    }

    public $searchAvailable = '';

    public function getFilteredCategoriesProperty()
    {
        return Category::with(['items' => function ($query) {
            if ($this->searchAvailable) {
                $query->where('name', 'like', '%' . $this->searchAvailable . '%');
            }
        }])->get();
    }

    public function addItemToList($itemId)
    {
        $this->list->items()->syncWithoutDetaching([$itemId]);
        $this->dispatch('item-added');
    }

    public function removeItemFromList($itemId)
    {
        $this->list->items()->detach($itemId);
        // If the item is private and not used in any other lists, delete it
        $item = Item::find($itemId);
        if ($item && $item->private && $item->lists()->count() === 0) {
            $item->delete();
        }
        $this->dispatch('item-removed');
    }

    public function addPrivateItem()
    {
        $this->validate([
            'newItemName' => 'required|min:2',
            'newItemCategoryId' => 'required|exists:categories,id'
        ]);

        $item = Item::create([
            'name' => $this->newItemName,
            'user_id' => Auth::id(),
            'category_id' => $this->newItemCategoryId,
            'private' => true,
            'active' => false,
        ]);

        $this->list->items()->attach($item->id);
        $this->newItemName = '';
        $this->newItemCategoryId = null;
        $this->dispatch('item-added');
    }

    public function getListItemsProperty()
    {
        return $this->list->items()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.lists.manage-list');
    }
}