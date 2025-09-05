<?php
namespace App\Livewire\Items;

use Livewire\Component;
use App\Models\category;
use App\Models\Item;

class Manage extends Component
{
    public $editItemId = null;
    public $editItemName = '';
    public $search = '';

    public function deleteItem($itemId)
    {
        Item::findOrFail($itemId)->delete();
        session()->flash('message', 'تم حذف العنصر بنجاح.');
    }

    public function startEdit($itemId)
    {
        $item = Item::findOrFail($itemId);
        $this->editItemId = $itemId;
        $this->editItemName = $item->name;
    }

    public function saveEdit()
    {
        $item = Item::findOrFail($this->editItemId);
        $item->name = $this->editItemName;
        $item->save();
        $this->editItemId = null;
        $this->editItemName = '';
        session()->flash('message', 'تم تعديل العنصر بنجاح.');
    }

    public function cancelEdit()
    {
        $this->editItemId = null;
        $this->editItemName = '';
    }

    public function getFilteredCategoriesProperty()
    {
        $search = trim($this->search);
        $query = Category::with(['items' => function($q) use ($search) {
            if ($search !== '') {
                $q->where('name', 'like', "%$search%");
            }
        }]);
        $categories = $query->get();
        return $search === '' ? $categories : $categories->filter(fn($cat) => $cat->items->count() > 0);
    }

    public function render()
    {
        return view('livewire.items.manage', [
            'filteredCategories' => $this->filteredCategories
        ]);
    }
}
