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
    public $editCategoryId = null;
    public $editCategoryName = '';
    public $editCategoryColor = '';

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

    public function startEditCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->editCategoryId = $categoryId;
        $this->editCategoryName = $category->name;
        $this->editCategoryColor = $category->color ?? '#3B82F6';
    }

    public function saveCategoryEdit()
    {
        $category = Category::findOrFail($this->editCategoryId);
        $category->name = $this->editCategoryName;
        $category->color = $this->editCategoryColor;
        $category->save();
        
        $this->editCategoryId = null;
        $this->editCategoryName = '';
        $this->editCategoryColor = '';
        session()->flash('message', 'تم تعديل القسم بنجاح.');
    }

    public function cancelCategoryEdit()
    {
        $this->editCategoryId = null;
        $this->editCategoryName = '';
        $this->editCategoryColor = '';
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
