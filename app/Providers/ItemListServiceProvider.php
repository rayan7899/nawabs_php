<?php

namespace App\Providers;

use App\Models\ItemList;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class ItemListServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        User::created(function ($user) {
            // Create default list
            $defaultList = ItemList::create([
                'name' => 'قائمتي',
                'user_id' => $user->id,
                'is_default' => true,
            ]);

            // Get default items (non-private items) from common categories
            $defaultItems = \App\Models\Item::where('private', false)
                ->whereNotNull('category_id')
                ->get();

            // Attach default items to the new list
            if ($defaultItems->isNotEmpty()) {
                $defaultList->items()->attach($defaultItems->pluck('id'));
            }
        });
    }
}