<?php

namespace App\Observers;

use App\ItemUsageActions;
use App\Models\ListItem;
use Illuminate\Support\Facades\Auth;

class ListItemObserver
{
    /**
     * Handle the ListItem "created" event.
     */
    public function created(ListItem $listItem): void
    {
        //
    }

    /**
     * Handle the ListItem "updated" event.
     */
    public function updated(ListItem $listItem): void
    {
        if ($listItem->wasChanged('need_at')) {
            $listItem->itemUsages()->create([
                'action' => $listItem->need_at === null ? ItemUsageActions::REMOVE->value : ItemUsageActions::ADD->value,
            ]);
        }
    }

    /**
     * Handle the ListItem "deleted" event.
     */
    public function deleted(ListItem $listItem): void
    {
        //
    }

    /**
     * Handle the ListItem "restored" event.
     */
    public function restored(ListItem $listItem): void
    {
        //
    }

    /**
     * Handle the ListItem "force deleted" event.
     */
    public function forceDeleted(ListItem $listItem): void
    {
        //
    }
}
