<?php

use App\Livewire\Items\Show as ShowItems;
use App\Models\Item;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('seed', function () {
    $items = [
        ['name' => 'عنب', 'active' => false],
        ['name' => 'بصل', 'active' => false],
        ['name' => 'طماطم', 'active' => false],
        ['name' => 'ثوم', 'active' => false],
        ['name' => 'خيار', 'active' => false],
        ['name' => 'خس', 'active' => false],
        ['name' => 'جرجير', 'active' => false],
        ['name' => 'بقدونس', 'active' => false],
        ['name' => 'بصل اخضر', 'active' => false],
        ['name' => 'تين', 'active' => false],
        ['name' => 'بطاطس', 'active' => false],
        ['name' => 'قرع', 'active' => false],
        ['name' => 'كوسة', 'active' => false],
        ['name' => 'ليمون', 'active' => false],
        ['name' => 'حبحر', 'active' => false],
        ['name' => 'بروكلي', 'active' => false],
        ['name' => 'زهرة', 'active' => false],
        ['name' => 'كرز', 'active' => false],
        ['name' => 'برتقال', 'active' => false],
        ['name' => 'خوخ', 'active' => false],
        ['name' => 'اناناس', 'active' => false],
        ['name' => 'تفاح', 'active' => false],
        ['name' => 'جح', 'active' => false],
        ['name' => 'جرو', 'active' => false],
        ['name' => 'شمندر', 'active' => false],
        ['name' => 'نعناع', 'active' => false],
        ['name' => 'كركم', 'active' => false],
        ['name' => 'زبادي', 'active' => false],
        ['name' => 'لبن', 'active' => false],
    ];
    dump('waiting...');
    foreach ($items as $item) {
        Item::firstOrCreate($item);
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
