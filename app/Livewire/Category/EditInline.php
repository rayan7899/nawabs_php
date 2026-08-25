<?php

namespace App\Livewire\Category;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditInline extends Component
{
    public Category $category;
    public CategoryForm $categoryForm;

    public function mount()
    {
        $this->categoryForm->name = $this->category->name;
        $this->categoryForm->color = $this->category->color;
    }

    public function updateCategory(Category $category)
    {
        $this->categoryForm->update($category);
        LivewireAlert::title(__('Category updated successfully'))
            ->success()->asToast()->show();
    }

    public function render()
    {
        return view('livewire.category.edit-inline');
    }
}
