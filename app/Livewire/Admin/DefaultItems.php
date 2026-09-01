<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class DefaultItems extends Component
{
    public $newCategoryName = '';
    public $newCategoryColor = '#3B82F6';
    public $newItemName = '';
    public $selectedCategoryId = null;
    public $editingCategoryId = null;
    public $editCategoryName = '';
    public $editCategoryColor = '';

    public function mount()
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }
    }

    public function createCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|min:2',
            'newCategoryColor' => 'required|regex:/^#[0-9A-F]{6}$/i'
        ]);

        Category::create([
            'name' => $this->newCategoryName,
            'color' => $this->newCategoryColor,
            'created_by' => Auth::id()
        ]);

        $this->newCategoryName = '';
        $this->newCategoryColor = '#3B82F6';
        $this->dispatch('category-added');
    }

    public function startEditingCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->editingCategoryId = $categoryId;
        $this->editCategoryName = $category->name;
        $this->editCategoryColor = $category->color;
    }

    public function updateCategory()
    {
        $this->validate([
            'editCategoryName' => 'required|min:2',
            'editCategoryColor' => 'required|regex:/^#[0-9A-F]{6}$/i'
        ]);

        $category = Category::findOrFail($this->editingCategoryId);
        $category->update([
            'name' => $this->editCategoryName,
            'color' => $this->editCategoryColor
        ]);

        $this->editingCategoryId = null;
        $this->dispatch('category-updated');
    }

    public function deleteCategory($categoryId)
    {
        Category::findOrFail($categoryId)->delete();
        $this->dispatch('category-deleted');
    }

    public function addItem()
    {
        $this->validate([
            'newItemName' => 'required|min:2',
            'selectedCategoryId' => 'required|exists:categories,id'
        ]);

        Item::create([
            'name' => $this->newItemName,
            'category_id' => $this->selectedCategoryId,
            'private' => false,
            'active' => false,
            'created_by' => Auth::id()
        ]);

        $this->newItemName = '';
        $this->dispatch('item-added');
    }

    public function deleteItem($itemId)
    {
        Item::findOrFail($itemId)->delete();
        $this->dispatch('item-deleted');
    }

    public function getCategoriesProperty()
    {
        return Category::with('items')->get();
    }

    public function render()
    {
        return view('livewire.admin.default-items');
    }
}