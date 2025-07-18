<?php

use App\Livewire\Items\Show as ShowItems;
use App\Models\category;
use App\Models\Item;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('seed', function () {

    $categories = [
        [
            'name' => 'فواكه', 
            'color' => '#FF5733',
            'items' => [
                ['name' => 'تفاح', 'active' => false],
                ['name' => 'موز', 'active' => false],
                ['name' => 'برتقال', 'active' => false],
                ['name' => 'عنب', 'active' => false],
                ['name' => 'فراولة', 'active' => false],
                ['name' => 'أناناس', 'active' => false],
                ['name' => 'ليمون', 'active' => false],
                ['name' => 'كيوي', 'active' => false],
                ['name' => 'مانجو', 'active' => false],
                ['name' => 'جوافة', 'active' => false],
                ['name' => 'خوخ', 'active' => false],
                ['name' => 'كمثرى', 'active' => false],
                ['name' => 'تين', 'active' => false],
                ['name' => 'رمان', 'active' => false],
                ['name' => 'بطيخ', 'active' => false],
                ['name' => 'شمام', 'active' => false],
            ],
        ],
        [
            'name' => 'خضروات', 
            'color' => '#33FF57',
            'items' => [
                ['name' => 'خيار', 'active' => false],
                ['name' => 'طماطم', 'active' => false],
                ['name' => 'بطاطس', 'active' => false],
                ['name' => 'جزر', 'active' => false],
                ['name' => 'بصل', 'active' => false],
                ['name' => 'ثوم', 'active' => false],
                ['name' => 'فلفل', 'active' => false],
                ['name' => 'قرنبيط', 'active' => false],
                ['name' => 'بروكلي', 'active' => false],
                ['name' => 'سبانخ', 'active' => false],
                ['name' => 'كوسا', 'active' => false],
                ['name' => 'فاصوليا خضراء', 'active' => false],
                ['name' => 'كرنب', 'active' => false],
                ['name' => 'فجل', 'active' => false],
                ['name' => 'بطاطا حلوة', 'active' => false],
                ['name' => 'شمندر', 'active' => false],
                ['name' => 'ذرة', 'active' => false],
                ['name' => 'بازلاء', 'active' => false],
                ['name' => 'كرفس', 'active' => false],
                ['name' => 'كراث', 'active' => false],
                ['name' => 'بقدونس', 'active' => false],
                ['name' => 'نعناع', 'active' => false],
                ['name' => 'ريحان', 'active' => false],
                ['name' => 'زعتر', 'active' => false],
                ['name' => 'شبت', 'active' => false],
                ['name' => 'كزبرة', 'active' => false],
            ],
        ],
        [
            'name' => 'معلبات', 
            'color' => '#3357FF',
            'items' => [
                ['name' => 'فاصوليا', 'active' => false],
                ['name' => 'حمص', 'active' => false],
                ['name' => 'عدس', 'active' => false],
                ['name' => 'ذرة', 'active' => false],
                ['name' => 'بازلاء', 'active' => false],
                ['name' => 'طماطم', 'active' => false],
                ['name' => 'خضار مشكلة', 'active' => false],
                ['name' => 'سمك سردين', 'active' => false],
                ['name' => 'سمك تونة', 'active' => false],
                ['name' => 'فطر', 'active' => false],
                ['name' => 'زيتون', 'active' => false],
            ],
        ],
        [
            'name' => 'حلويات', 
            'color' => '#FF33A1',
            'items' => [
                ['name' => 'شوكولاتة', 'active' => false],
                ['name' => 'بسكويت', 'active' => false],
                ['name' => 'كعكة', 'active' => false],
            ],
        ],
        [
            'name' => 'مشروبات', 
            'color' => '#A133FF',
            'items' => [
                ['name' => 'عصير', 'active' => false],
                ['name' => 'ماء', 'active' => false],
                ['name' => 'شاي', 'active' => false],
                ['name' => 'قهوة', 'active' => false],
                ['name' => 'مشروبات غازية', 'active' => false],
            ],
        ],
        [            'name' => 'مخبوزات', 
            'color' => '#33FFFF',
            'items' => [
                ['name' => 'خبز', 'active' => false],
                ['name' => 'كرواسون', 'active' => false],
                ['name' => 'بيتزا', 'active' => false],
            ],
        ],
        [            'name' => 'ألبان', 
            'color' => '#edd9d4',
            'items' => [
                ['name' => 'حليب', 'active' => false],
                ['name' => 'زبادي', 'active' => false],
                ['name' => 'جبنة', 'active' => false],
            ],
        ],
    ];
    dump('waiting...');
    foreach ($categories as $category) {
        $cat = category::firstOrCreate($category);
        foreach ($category['items'] as $item) {
            $cat->items()->firstOrCreate($item);
        }
    }
    dd('done');
})->name('seed');

Route::get('/welcome', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', ShowItems::class)->name('showItems');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
