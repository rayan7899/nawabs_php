<?php

namespace App\Providers;

use App\Enums\ListUserRoleEnum;
use App\Enums\ItemTypeEnum;
use App\Enums\ListItemStatus;
use App\Enums\ListTypeEnum;
use App\Enums\ListStatusEnum;
use App\Enums\ListUserStatusEnum;
use App\Models\Item;
use App\Models\ItemList;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class ListServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        User::created(function ($user) {
            try{
                // Create default list when create new user
                $defaultList = ItemList::create([
                    'name' => __('My List'),
                    'type' => ListTypeEnum::DEFAULT->value,
                    'status' => ListStatusEnum::ACTIVE->value,
                    'created_by' => $user->id,
                ]);
    
                // Attach the user to the default list with the owner role
                $user->lists()->attach($defaultList->id, [
                        'role' => ListUserRoleEnum::OWNER->value,
                        'status' => ListUserStatusEnum::ACCEPTED->value,
                    ]);
    
                // Get default items
                $defaultItems = Item::where('type', ItemTypeEnum::DEFAULT->value)->get();
    
                // Attach default items to the new list
                if ($defaultItems->isNotEmpty()) {
                    $defaultList->items()->attach($defaultItems->pluck('id'), [
                            'status' => ListItemStatus::DEFAULT->value,
                            'created_by' => $user->id,
                        ]);
                }
            }catch (\Exception $e) {
                Log::critical($e);
            }
        });
    }
}