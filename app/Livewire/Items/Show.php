<?php

namespace App\Livewire\Items;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Show extends Component
{
    public $search = '';
    #[Session('selectedList')]
    public $selectedList = null;
    #[Session('shoppingMode')]
    public $shoppingMode = false;

    public function mount($list = null)
    {
        if (!Auth::check()) {
            return;
        }

        // If URL parameter is provided, validate and use it
        if ($list) {
            $selectedList = ItemList::findOrFail($list);
            if ($selectedList->user_id !== Auth::id()) {
                abort(403);
            }
            $this->selectedList = $list;
            return;
        }

        // If no URL parameter but we have a session value, validate it
        if ($this->selectedList) {
            $selectedList = ItemList::find($this->selectedList);
            if ($selectedList && $selectedList->user_id === Auth::id()) {
                return;
            }
        }

        // If no valid list is set, use the first available list
        $lists = Auth::user()->lists;
        if ($lists->isNotEmpty()) {
            $this->selectedList = $lists->first()->id;
        }
    }

    public function toggleItem(Item $item)
    {
        if (!$this->selectedList || !Auth::check()) {
            return;
        }

        try {
            $list = ItemList::findOrFail($this->selectedList);
            
            if ($list->user_id !== Auth::id()) {
                abort(403);
            }

            $existingItem = $list->items()->where('item_id', $item->id)->first();
            
            if ($existingItem) {
                $newActive = !$existingItem->pivot->active;
                $list->items()->updateExistingPivot($item->id, ['active' => $newActive]);
            } else {
                $list->items()->attach($item->id, ['active' => false]);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'حدث خطأ أثناء تحديث الغرض');
        }
    }

    public function render()
    {
        $categories = collect();
        $lists = Auth::check() ? Auth::user()->lists : collect();

        if ($this->selectedList && Auth::check()) {
            $list = ItemList::with(['items' => function($q) {
                $q->when($this->search, function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
                $q->with('category');
            }])->findOrFail($this->selectedList);

            $items = $list->items;
            
            if ($this->shoppingMode) {
                $items = $items->filter(function($item) {
                    return $item->pivot->active;
                });
            }

            $categorizedItems = $items->groupBy('category.id');
            
            $categories = Category::whereIn('id', $categorizedItems->keys())
                ->get()
                ->map(function($category) use ($categorizedItems) {
                    $category->setRelation('items', collect($categorizedItems->get($category->id)));
                    return $category;
                })
                ->sortBy('name');
        }

        return view('livewire.items.show', [
            'categories' => $categories,
            'lists' => $lists,
        ]);
    }
}