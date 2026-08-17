<?php

namespace App\Livewire\Items;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemList;
use App\Models\ListItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Show extends Component
{
    public $search = '';
    #[Session('selectedList')]
    public $selectedList;
    #[Session('shoppingMode')]
    public $shoppingMode = false;
    public $selectedCategory;

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
        $this->selectedCategory = $this->selectedList->categories[0]->id ?? null;
    }

    function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function toggleItem(Item $item)
    {
        if (!$item) {
            LivewireAlert::title(__('Item not found.'))
                ->warning()->timerProgressBar()->show();
            return;
        }

        $listItem = ListItem::where('list_id', $this->selectedList)->where('item_id', $item->id)->first();
        if (!$listItem) {
            LivewireAlert::title(__('Item not found in the list.'))
                ->warning()->timerProgressBar()->show();
            return;
        }

        try {
            $listItem->update([
                'need_at' => $listItem->need_at ? null : now(),
                'needed_by' => $listItem->needed_by ? null : Auth::id(),
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'حدث خطأ أثناء تحديث الغرض');
        }
    }

    public function render()
    {
        $lists = Auth::check() ? Auth::user()->lists : collect();

        $list = ItemList::find($this->selectedList);
        return view('livewire.items.show', [
            'categories' => $list->categoriesWithItems,
            'lists' => $lists,
        ]);
    }
}
