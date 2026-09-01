<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    public $category_name;

    public function save()
    {
        if (empty($this->category_name)) {
            dd('لا يمكن ترك حقل اسم التصنيف فارغ.');
        }
        if (Category::where('name', $this->category_name)->exists()) {
            dd('التصنيف موجود.');
        }
        try {
            Category::create([
                'name' => $this->category_name,
                'color' => '#000000',
                'created_by' => Auth::id()
            ]);
            $this->category_name = '';
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function render()
    {
        return view('livewire.category.add');
    }
}
