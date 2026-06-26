<?php

namespace App\Observers;

use App\ItemUsageActions;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        if($item->wasChanged('need_at')) {
            $item->itemUsage()->create([
                'action' => $item->need_at === null ? ItemUsageActions::REMOVE->value : ItemUsageActions::ADD->value,
                'created_by' => Auth::id(),
            ]);
        }
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     */
    public function forceDeleted(Item $item): void
    {
        //
    }
}
