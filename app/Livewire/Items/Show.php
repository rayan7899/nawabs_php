<?php

namespace App\Livewire\Items;

use App\Enums\ListItemStatus;
use App\Livewire\Forms\CategoryForm;
use App\Livewire\Forms\ItemForm;
use App\Models\Category;
use App\Models\ItemList;
use App\Models\ListItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Component;

use function Livewire\Volt\placeholder;

#[Layout('components.layouts.guest')]
class Show extends Component
{
    public $search = '';
    #[Session('selectedListId')]
    public ?int $selectedListId = null;
    public ItemList $list;
    public $lists = [];
    #[Session('shoppingMode')]
    public $shoppingMode = false;
    public ?Category $selectedCategory = null;
    public string $categoryName;
    public ItemForm $itemForm;
    public CategoryForm $categoryForm;

    public function mount($list = null)
    {
        if (!$this->selectedListId) {
            if ($list) {
                $this->selectedListId = $list->id;
            } else {
                $this->selectedListId = Auth::user()->lists->first()->id;
            }
        }
        $this->list = ItemList::find($this->selectedListId);
        $this->lists = Auth::user()->lists;
    }

    public function updatedSelectedListId()
    {
        $list = ItemList::find($this->selectedListId);
        $this->list = $list;
        $this->selectedCategory = null;
    }

    public function getCategoriesProperty()
    {
        return $this->list->categoriesWithItems->sortBy('name');
    }

    public function getItemsProperty()
    {
        $items = ListItem::where('list_id', $this->selectedListId)->get();
        if ($this->selectedCategory) {
            $items = $items->filter(function ($pivot) {
                return $pivot->item->category_id == $this->selectedCategory->id;
            });
        }
        if ($this->search != '') {
            $items = $items->filter(fn($pivot) => str_contains($pivot->item->name, trim($this->search)));
        }
        return $items->sortBy('item.name');
    }

    public function selectCategory(Category $category)
    {
        $this->selectedCategory = $category->id ? $category : null;
        $this->categoryForm->name = $category?->name ?? '';
    }

    public function toggleItem(?array $data, ?ListItem $pivot)
    {
        // validate the input
        if ($data && ($data['value'] > 99 || $data['value'] < 1)) {
            LivewireAlert::title(__("Error"))
                ->text(__("max value is 99 and min value is 1"))
                ->error()->timerProgressBar()->timer(5000)->show();
            return;
        }
        try {
            if ($pivot->id == null) {
                $pivot = ListItem::find($data['pivot']['id']);
            }

            if ($pivot->need_at) {
                $pivot->update([
                    'need_at'   => null,
                    'needed_by' => null,
                    'quantity'  => null,
                ]);
            } else {
                $pivot->update([
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

    public function longPressed(ListItem $pivot)
    {
        LivewireAlert::withNumberInput(placeholder: __('Quantity'))
            ->withConfirmButton(__('Save'))
            ->onConfirm('toggleItem', ['pivot' => $pivot])
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
        $this->list->items()->attach($item->id, [
            'status'    => ListItemStatus::CUSTOM->value,
        ]);
        DB::commit();
        $this->reset('search');
        LivewireAlert::title(__('Item added successfully.'))
            ->success()->asToast()->show();
    }

    public function render()
    {
        return view('livewire.items.show');
    }
}
