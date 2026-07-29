<?php

use App\Enums\ItemTypeEnum;
use App\Livewire\Items\Add;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemList;
use App\Models\User;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;

it('shows matching items from the database as autocomplete suggestions', function () {
    $user = User::factory()->create();
    actingAs($user);

    $category = Category::create([
        'name' => 'Groceries',
        'color' => '#FF5733',
        'created_by' => $user->id,
    ]);

    $list = ItemList::create([
        'name' => 'Weekly Shop',
        'type' => 1,
        'status' => 1,
        'created_by' => $user->id,
    ]);

    Item::create([
        'name' => 'Milk',
        'category_id' => $category->id,
        'type' => ItemTypeEnum::CUSTOM->value,
        'created_by' => $user->id,
    ]);

    Item::create([
        'name' => 'Bread',
        'category_id' => $category->id,
        'type' => ItemTypeEnum::CUSTOM->value,
        'created_by' => $user->id,
    ]);

    Livewire::test(Add::class, ['listId' => $list->id])
        ->set('itemForm.name', 'mi')
        ->assertSee('Milk')
        ->assertDontSee('Bread');
});
