<div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <flux:heading size="xl" level="1" class="inline">{{ __('الأغراض') }}</flux:heading>
            @auth
                <flux:button icon="squares-2x2" :href="route('lists.manage', ['list'=>$selectedList])" label="لوحة التحكم"  />
            @else
                <div class="flex gap-2">
                    <flux:button href="{{ route('login') }}" label="تسجيل الدخول"  />
                    <flux:button href="{{ route('register') }}" label="إنشاء حساب" />
                </div>
            @endauth
        </div>
        @if(Auth::check() && $lists->isNotEmpty())
            <div class="flex items-center">
                <select 
                    wire:model.live="selectedList"
                    class="min-w-[200px] rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-500 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-teal-500"
                >
                    <option value="">اختر قائمة</option>
                    @foreach($lists as $list)
                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    <flux:separator variant="subtle" class="mb-5 mt-3" />

    @auth
        <div class="mb-4">
            <flux:switch wire:model.live="shoppingMode"
                label="وضع التسوق"
                align="start"/>
        </div>
    @endauth

    <div class="mb-4 w-full max-w-md">
        <flux:input
            type="search"
            wire:model.live.debounce.0ms="search"
            name="search"
            placeholder="ابحث عن غرض"
            class="w-full"
            icon="magnifying-glass"
            x-data="{search: $wire.entangle('search')}"
            x-on:reset-search.window="search = ''; $nextTick(() => $refs.searchInput && $refs.searchInput.focus())"
            x-ref="searchInput"
        />
    </div>
    
    @guest
        <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg">
            <p class="text-sm font-medium">
                قم بإنشاء حساب للوصول إلى جميع المميزات وحفظ قوائمك الخاصة!
            </p>
        </div>
    @endguest

    <div class="@if(!$shoppingMode && (!$search || $categories->isNotEmpty())) columns-3 md:columns-7 lg:columns-10 xl:columns-13 2xl:columns-15 @endif gap-1">
        @if(Auth::check() && $selectedList)
            @forelse ($categories as $category)
                <div class="gap-1 flex flex-col border-r-1 ps-1" style="border-color: {{ $category->color }};">
                    <flux:legend style="color: {{ $category->color }};">
                        {{ $category->name }}
                    </flux:legend>

                    @foreach ($category->items as $item)
                        <x-item-button 
                            wire:click="toggleItem({{ $item->id }})"
                            wire:loading.class="opacity-50"
                            wire:target="toggleItem({{ $item->id }})"
                            :label="$item->name" 
                            :active="$item->pivot->active"
                            wire:key='{{ $item->id }}' 
                            :id="$item->id" 
                            class="flex-stretch hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors" />
                    @endforeach
                </div>
            @empty
                <div class="flex flex-col items-center justify-center w-full py-12">
                    <div class="text-lg text-blue-700 dark:text-blue-300 font-bold mb-4">
                        @if($search && !$shoppingMode)
                            <div class="flex flex-col items-center gap-4">
                                <span>لم يتم العثور على أي غرض يطابق البحث في هذه القائمة.</span>
                                <livewire:items.add 
                                    :item_name="$search" 
                                    :selected_list="$selectedList"
                                    :show_category="true"
                                    key="{{ 'add-search-' . $search }}" 
                                />
                            </div>
                        @elseif($shoppingMode)
                            <div class="flex flex-col items-center gap-4">
                                <span>لا توجد أغراض نشطة في وضع التسوق.</span>
                                <flux:button 
                                    wire:click="$set('shoppingMode', false)" 
                                    :loading="false"
                                >
                                    خروج من وضع التسوق
                                </flux:button>
                            </div>
                        @else
                            <div class="flex flex-col items-center gap-4">
                                <span>هذه القائمة فارغة. يمكنك إضافة أغراض إليها الآن!</span>
                                <livewire:items.add 
                                    :item_name="''" 
                                    :selected_list="$selectedList"
                                    :show_category="true"
                                    key="add-empty" 
                                />
                            </div>
                        @endif
                    </div>
                </div>
            @endforelse
        @elseif(Auth::check())
            <div class="flex flex-col items-center justify-center py-12">
                <div class="text-lg text-blue-700 dark:text-blue-300 font-bold mb-4">
                    {{ $lists->isEmpty() ? 'لا توجد قوائم متاحة. يرجى إنشاء قائمة أولاً.' : 'يرجى اختيار قائمة لعرض الأغراض.' }}
                </div>
            </div>
        @else
            @forelse ($categories as $category)
                <div class="gap-1 flex flex-col border-r-1 ps-1" style="border-color: {{ $category->color }};">
                    <flux:legend style="color: {{ $category->color }};">
                        {{ $category->name }}
                    </flux:legend>

                    @foreach ($category->items as $item)
                        <x-item-button 
                            wire:click="$dispatch('openModal', { component: 'auth.login' })"
                            :label="$item->name" 
                            :active="false"
                            wire:key='{{ $item->id }}' 
                            :id="$item->id" 
                            class="flex-stretch hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors" />
                    @endforeach
                </div>
            @empty
                <div class="flex flex-col items-center justify-center w-full py-12">
                    <div class="text-lg text-blue-700 dark:text-blue-300 font-bold mb-4">
                        @if($search)
                            لم يتم العثور على أي غرض يطابق البحث.
                        @else
                            لم يتم العثور على أي غرض.
                        @endif
                    </div>
                </div>
            @endforelse
        @endif
    </div>

    @if($selectedList && auth()->check() && !$shoppingMode && ($categories->isEmpty() || $categories->every(fn($cat) => $cat->items->isEmpty())))
        <div class="flex flex-col items-center justify-center py-12">
            <div class="text-lg text-blue-700 dark:text-blue-300 font-bold mb-4">
                لم يتم العثور على أي غرض.
            </div>
        </div>
    @endif
</div>
