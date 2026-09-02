<?php

namespace App\Livewire\Items;

use App\Livewire\Forms\CategoryForm;
use App\Livewire\Forms\ItemForm;
use App\Livewire\Forms\ListForm;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Show extends Component
{
    public $search = '';
    #[Session('selectedListId')]
    public ?int $selectedListId = null;
    public ?ItemList $list;
    public $lists = [];
    #[Session('shoppingMode')]
    public $shoppingMode = false;
    public ?Category $selectedCategory = null;
    public string $categoryName;
    public ListForm $listForm;
    public CategoryForm $categoryForm;
    public ItemForm $itemForm;

    public function mount($list = null)
    {
        if ($this->selectedListId == null || !Auth::user()->lists->pluck('id')->contains($this->selectedListId)) {
            $this->selectedListId = Auth::user()->lists->first()?->id;
        }
        $this->list = ItemList::find($this->selectedListId);
        $this->lists = Auth::user()->lists;
        $this->categoryForm->list_id = $this->list?->id;
    }

    public function updatedSelectedListId()
    {
        $list = ItemList::find($this->selectedListId);
        $this->list = $list;
        $this->selectedCategory = null;
    }

    public function getCategoriesProperty()
    {
        return $this->list->categories->sortBy('name');
    }

    public function getItemsProperty()
    {
        $items = $this->list->items;
        if ($this->selectedCategory) {
            $items = $items->filter(function ($item) {
                return $item->category_id == $this->selectedCategory->id;
            });
        }
        if ($this->search != '') {
            $items = $items->filter(fn($item) => str_contains($item->name, trim($this->search)));
        }
        return $items->sortBy('category_id');
    }

    public function getActiveItemsProperty()
    {
        $items = $this->list->items->whereNotNull('need_at')
            ->sortBy('category_id');
        if ($this->selectedCategory) {
            $items = $items->filter(function ($item) {
                return $item->category_id == $this->selectedCategory->id;
            });
        }
        return $items;
    }

    public function selectCategory(Category $category)
    {
        if($this->selectedCategory == $category){
            $this->selectedCategory = null;
            $this->categoryForm->name = '';
        }else{
            $this->selectedCategory = $category->id ? $category : null;
            $this->categoryForm->name = $category?->name ?? '';
        }
    }

    public function toggleItem(?array $data, ?Item $item)
    {
        // validate the input
        if ($data && ($data['value'] > 99 || $data['value'] < 1)) {
            LivewireAlert::title(__("Error"))
                ->text(__("max value is 99 and min value is 1"))
                ->error()->timerProgressBar()->timer(5000)->show();
            return;
        }
        try {
            if ($item->id == null) {
                $item = Item::find($data['item']['id']);
            }

            if ($item->need_at) {
                $item->update([
                    'need_at'   => null,
                    'needed_by' => null,
                    'quantity'  => null,
                ]);
            } else {
                $item->update([
                    'need_at'   => now(),
                    'needed_by' => Auth::user()->id,
                    'quantity'  => $data['value'] ?? 1,
                ]);
            }
        } catch (\Throwable $th) {
            LivewireAlert::title(__("Error"))
                ->text(__("An error occurred while toggling the item."))
                ->error()->timerProgressBar()->timer(5000)->show();
            Log::critical($th);
        }
    }

    public function longPressed(Item $item)
    {
        LivewireAlert::withNumberInput(placeholder: __('Quantity'))
            ->withConfirmButton(__('Save'))
            ->onConfirm('toggleItem', ['item' => $item])
            ->timer(0)
            ->show();
    }

    public function newItem()
    {
        DB::beginTransaction();
        $category = $this->categoryForm->firstOrCreate();
        $this->itemForm->name = $this->search;
        $this->itemForm->category_id = $category->id;
        $item = $this->itemForm->firstOrCreate();
        $this->list->items()->create([
            'name'          => 'test',
            'category_id'   => 1,
            'type'          => 1,
            'created_by'    => Auth::id(),
        ]);
        DB::commit();
        $this->reset('search');
        LivewireAlert::title(__('Item added successfully.'))
            ->success()->asToast()->show();
    }

    public function createList()
    {
        $list = $this->listForm->create();
        if($list){
            $this->redirectIntended(route('lists.manage', ['list'=>$list->id]));
        }
    }

    public function render()
    {
        return view('livewire.items.show');
    }
}
