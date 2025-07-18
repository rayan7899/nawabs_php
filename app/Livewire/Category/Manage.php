<?php

namespace App\Livewire\Category;

use App\Models\category;
use Livewire\Component;

class Manage extends Component
{
    public $categories;
    public $category_id;
    public $name;
    public $color = '#000000';
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'color' => 'nullable|string|max:7',
    ];

    public function mount()
    {
        $this->fetchCategories();
    }

    public function fetchCategories()
    {
        $this->categories = category::all();
    }

    public function save()
    {
        $this->validate();
        if (category::where('name', $this->name)->where('id', '!=', $this->category_id)->exists()) {
            session()->flash('error', 'التصنيف موجود.');
            return;
        }
        if ($this->isEdit && $this->category_id) {
            $cat = category::find($this->category_id);
            if ($cat) {
                $cat->update([
                    'name' => $this->name,
                    'color' => $this->color,
                ]);
            }
        } else {
            category::create([
                'name' => $this->name,
                'color' => $this->color,
            ]);
        }
        $this->resetForm();
        $this->fetchCategories();
    }

    public function edit($id)
    {
        $cat = category::find($id);
        if ($cat) {
            $this->category_id = $cat->id;
            $this->name = $cat->name;
            $this->color = $cat->color;
            $this->isEdit = true;
        }
    }

    public function delete($id)
    {
        $cat = category::find($id);
        if ($cat) {
            $cat->delete();
            $this->fetchCategories();
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->category_id = null;
        $this->name = '';
        $this->color = '#000000';
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.category.manage');
    }
}
