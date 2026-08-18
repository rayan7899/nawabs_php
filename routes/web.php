<?php

use App\Enums\ItemTypeEnum;
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
    dump('waiting...');
    $categories = [
        [
            'name' => 'خضروات',
            'color' => '#22C55E',
            'items' => [
                'قرنبيط',
                'بروكلي',
                'كوسا',
                'فاصوليا خضراء',
                'كرنب',
                'فجل',
                'ذرة',
                'زعتر',
                'شبت',
                'سفرجل',
                'كراث',
                'بازلاء',
                'ريحان',
                'خس',
                'جرجير',
                'بطاطا حلوة',
                'كزبرة',
                'نعناع',
                'بطاطس',
                'فلفل',
                'طماطم',
                'جزر',
                'سبانخ',
                'بقدونس',
                'كرفس',
                'ثوم',
                'رجلة',
                'خيار',
                'شمندر',
                'بصل',
            ]
        ],
        [
            'name' => 'فواكه',
            'color' => '#F97316',
            'items' => [
                'مانجو',
                'خوخ',
                'تين',
                'رمان',
                'بطيخ',
                'عنب',
                'موز',
                'جوافة',
                'كيوي',
                'ليمون اخضر',
                'شمام',
                'فراولة',
                'أناناس',
                'كمثرى',
                'ليمون',
                'تفاح 🍎',
                'برتقال',
                'تفاح',
            ]
        ],
        [
            'name' => 'منتجات الألبان',
            'color' => '#3B82F6',
            'items' => [
                'حليب',
                'لبن',
                'جبنة',
                'لبنه',
                'زبادي',
            ]
        ],
        [
            'name' => 'لحوم',
            'color' => '#EF4444',
            'items' => [
                'دجاج',
                'لحم',
                'سمك',
                'برجر'
            ]
        ],
        [
            'name' => 'أدوات المطبخ',
            'color' => '#EF4444',
            'items' => [
                'قصدير',
            ]
        ],
        [
            'name' => 'حلويات',
            'color' => '#EF4444',
            'items' => [
                'شوكولاتة',
                'بسكويت',
                'كعكة',
            ]
        ],
        [
            'name' => 'عناية شخصية',
            'color' => '#EF4444',
            'items' => [
                'معجون أسنان',
            ]
        ],
        [
            'name' => 'مجمدات 🧊',
            'color' => '#EF4444',
            'items' => [
                'ستربس',
                'لحم مفروم',
                'صدور دجاج',
            ]
        ],
        [
            'name' => 'مخبوزات',
            'color' => '#EF4444',
            'items' => [
                'خبز',
                'بيتزا',
                'كرواسون',
            ]
        ],
        [
            'name' => 'مشروبات',
            'color' => '#EF4444',
            'items' => [
                'ماء',
                'شاي',
                'مشروبات غازية',
                'قهوة',
                'عصير',
            ]
        ],
        [
            'name' => 'معلبات',
            'color' => '#EF4444',
            'items' => [
                'فاصوليا',
                'حمص',
                'عدس',
                'خضار مشكلة',
                'زيتون',
                'طماطم',
                'بازلاء',
                'سمك سردين',
                'سمك تونة',
                'صلصة',
                'ذرة',
                'فطر',
            ]
        ],
        [
            'name' => 'منظفات 🧼',
            'color' => '#EF4444',
            'items' => [
                'صابون الوزير',
                'صابون يدين',
                'صابون مواعين',
                'مناديل',
                'الأسفنجة العجيبة',
                'صابون ملابس',
                'ملح غسالة المواعين',
            ]
        ],
        [
            'name' => 'مواد غذائية',
            'color' => '#EF4444',
            'items' => [
                'مايونيز',
                'عسل',
                'كاتشب',
                'بيض',
                'شطة',
                'بيض السمان 🪺',
                'طحين',
                'سماق',
                'سكر',
                'شاهي لبتون',
            ]
        ],
    ];

    foreach ($categories as $categoryData) {
        $category = Category::create([
            'name'          => $categoryData['name'],
            'color'         => $categoryData['color'],
            'created_by'    => 1,
        ]);

        // Create items for this category
        foreach ($categoryData['items'] as $itemName) {
            Item::create([
                'name'          => $itemName,
                'category_id'   => $category->id,
                'type'          => ItemTypeEnum::DEFAULT->value,
                'created_by'    => 1,
            ]);
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
