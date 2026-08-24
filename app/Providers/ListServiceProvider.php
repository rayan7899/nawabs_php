<?php

namespace App\Providers;

use App\Enums\ListUserRoleEnum;
use App\Enums\ItemTypeEnum;
use App\Enums\ListTypeEnum;
use App\Enums\ListStatusEnum;
use App\Enums\ListUserStatusEnum;
use App\Models\Category;
use App\Models\ItemList;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
                DB::beginTransaction();
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
    
                // Get default categories
                $defaultCategories = Category::where('type', ItemTypeEnum::DEFAULT->value)->get();

                foreach ($defaultCategories as $category) {
                    $newCategory = $category->replicate();
                    $newCategory->list_id = $defaultList->id;
                    $newCategory->type = ListTypeEnum::CUSTOM->value;
                    $newCategory->save();
                    foreach ($category->items as $item) {
                        $newItem = $item->replicate();
                        $newItem->category_id = $newCategory->id;
                        $newItem->type = ItemTypeEnum::CUSTOM->value;
                        $newItem->save();
                    }
                }
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack();
                Log::critical($e);
            }
        });
    }
}