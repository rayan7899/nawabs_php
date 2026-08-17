<?php

use App\Livewire\Invitations\Invite;
use App\Livewire\Items\Add as AddItem;
use App\Livewire\Items\Show as ShowItems;
use App\Livewire\Items\Usage;
use App\Livewire\Invitations\Show as ShowInvitations;
use App\Livewire\Lists\Categories;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('seed', function () {

    $categories = [
        [
            'name' => 'فواكه',
            'color' => '#FF5733',
            'items' => [
                ['name' => 'تفاح', 'type' => 1],
                ['name' => 'موز', 'type' => 1],
                ['name' => 'برتقال', 'type' => 1],
                ['name' => 'عنب', 'type' => 1],
                ['name' => 'فراولة', 'type' => 1],
                ['name' => 'أناناس', 'type' => 1],
                ['name' => 'ليمون', 'type' => 1],
                ['name' => 'كيوي', 'type' => 1],
                ['name' => 'مانجو', 'type' => 1],
                ['name' => 'جوافة', 'type' => 1],
                ['name' => 'خوخ', 'type' => 1],
                ['name' => 'كمثرى', 'type' => 1],
                ['name' => 'تين', 'type' => 1],
                ['name' => 'رمان', 'type' => 1],
                ['name' => 'بطيخ', 'type' => 1],
                ['name' => 'شمام', 'type' => 1],
            ],
        ],
        [
            'name' => 'خضروات',
            'color' => '#33FF57',
            'items' => [
                ['name' => 'خيار', 'type' => 1],
                ['name' => 'طماطم', 'type' => 1],
                ['name' => 'بطاطس', 'type' => 1],
                ['name' => 'جزر', 'type' => 1],
                ['name' => 'بصل', 'type' => 1],
                ['name' => 'ثوم', 'type' => 1],
                ['name' => 'فلفل', 'type' => 1],
                ['name' => 'قرنبيط', 'type' => 1],
                ['name' => 'بروكلي', 'type' => 1],
                ['name' => 'سبانخ', 'type' => 1],
                ['name' => 'كوسا', 'type' => 1],
                ['name' => 'فاصوليا خضراء', 'type' => 1],
                ['name' => 'كرنب', 'type' => 1],
                ['name' => 'فجل', 'type' => 1],
                ['name' => 'بطاطا حلوة', 'type' => 1],
                ['name' => 'شمندر', 'type' => 1],
                ['name' => 'ذرة', 'type' => 1],
                ['name' => 'بازلاء', 'type' => 1],
                ['name' => 'كرفس', 'type' => 1],
                ['name' => 'كراث', 'type' => 1],
                ['name' => 'بقدونس', 'type' => 1],
                ['name' => 'نعناع', 'type' => 1],
                ['name' => 'ريحان', 'type' => 1],
                ['name' => 'زعتر', 'type' => 1],
                ['name' => 'شبت', 'type' => 1],
                ['name' => 'كزبرة', 'type' => 1],
            ],
        ],
        [
            'name' => 'معلبات',
            'color' => '#3357FF',
            'items' => [
                ['name' => 'فاصوليا', 'type' => 1],
                ['name' => 'حمص', 'type' => 1],
                ['name' => 'عدس', 'type' => 1],
                ['name' => 'ذرة', 'type' => 1],
                ['name' => 'بازلاء', 'type' => 1],
                ['name' => 'طماطم', 'type' => 1],
                ['name' => 'خضار مشكلة', 'type' => 1],
                ['name' => 'سمك سردين', 'type' => 1],
                ['name' => 'سمك تونة', 'type' => 1],
                ['name' => 'فطر', 'type' => 1],
                ['name' => 'زيتون', 'type' => 1],
            ],
        ],
        [
            'name' => 'حلويات',
            'color' => '#FF33A1',
            'items' => [
                ['name' => 'شوكولاتة', 'type' => 1],
                ['name' => 'بسكويت', 'type' => 1],
                ['name' => 'كعكة', 'type' => 1],
            ],
        ],
        [
            'name' => 'مشروبات',
            'color' => '#A133FF',
            'items' => [
                ['name' => 'عصير', 'type' => 1],
                ['name' => 'ماء', 'type' => 1],
                ['name' => 'شاي', 'type' => 1],
                ['name' => 'قهوة', 'type' => 1],
                ['name' => 'مشروبات غازية', 'type' => 1],
            ],
        ],
        [
            'name' => 'مخبوزات',
            'color' => '#33FFFF',
            'items' => [
                ['name' => 'خبز', 'type' => 1],
                ['name' => 'كرواسون', 'type' => 1],
                ['name' => 'بيتزا', 'type' => 1],
            ],
        ],
        [
            'name' => 'ألبان',
            'color' => '#edd9d4',
            'items' => [
                ['name' => 'حليب', 'type' => 1],
                ['name' => 'زبادي', 'type' => 1],
                ['name' => 'جبنة', 'type' => 1],
            ],
        ],
    ];
    dump('waiting...');
    foreach ($categories as $category) {
        $cat = Category::firstOrCreate([
            'name' => $category['name'],
            'color' => $category['color'],
        ]);
        foreach ($category['items'] as $item) {
            $cat->items()->firstOrCreate($item);
        }
    }
    dd('done');
})->name('seed');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/', ShowItems::class)->name('showItems');
    Route::get('/list/{list?}', ShowItems::class)->name('showItems.list');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('default-items', \App\Livewire\Admin\DefaultItems::class)->name('default-items');
})->name('admin.');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::prefix('items')->name('item.')->group(function () {
        Route::get('{item}/usage', Usage::class)->name('usage');
    });

    Route::prefix('lists')->name('lists.')->group(function () {
        Route::get('{list}', Categories::class)->name('manage');

        Route::get('{listId}/invitations', Invite::class)->name('invite');
        Route::get('{list}/newItem', AddItem::class)->name('newItem');
    });

    Route::prefix('invitations')->name('invitations.')->group(function () {
        Route::get('/', ShowInvitations::class)->name('show');
    });
});

require __DIR__ . '/auth.php';
