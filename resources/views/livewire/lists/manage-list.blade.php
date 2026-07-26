<div>
    
</div>
{{-- <div>
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="xl" level="1" class="ms-3 inline">{{ $list->name }}</flux:heading>
        </div>
    </div>

    <flux:separator variant="subtle" class="mb-5 mt-3" />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- List Items Section -->
        <div class="space-y-4 bg:-white dark:bg-neutral-800 p-4 rounded-lg shadow">
            <flux:heading size="lg" level="2">{{ __('أغراض القائمة') }}</flux:heading>
            
            <div class="flex flex-col gap-2">
                <form wire:submit="addPrivateItem" class="flex gap-2">
                    <div class="flex gap-2 flex-grow">
                        <flux:input
                            type="text"
                            wire:model="newItemName"
                            placeholder="إضافة غرض خاص"
                            class="w-full"
                        />
                        <flux:select
                            wire:model="newItemCategoryId"
                            class="w-48"
                        >
                            <option value="">بدون قسم</option>
                            @foreach($this->categoriesForSelection as $category)
                                <option value="{{ $category->id }}" style="color: {{ $category->color }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </flux:select>
                    </div>
                    <flux:button type="submit" icon="plus" />
                </form>

                <flux:input
                    type="search"
                    wire:model.live.debounce.0ms="search"
                    name="search"
                    placeholder="ابحث في القائمة"
                    class="w-full "
                    icon="magnifying-glass"
                />
                
            </div>
            
            @error('newItemName')
                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
            @error('newItemCategoryId')
                <p class="text-sm text-red-500 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror

            <div class="space-y-2">
                @forelse($this->listItems as $item)
                    <div class="flex items-center justify-between p-2 bg-white dark:bg-zinc-800 rounded-lg shadow-sm">
                        <span>{{ $item->name }}</span>
                        <flux:button
                            variant="ghost"
                            size="sm"
                            icon="trash"
                            wire:click="removeItemFromList({{ $item->id }})"
                            class="text-red-500 hover:text-red-600"
                        />
                    </div>
                @empty
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        {{ __('لا توجد أغراض في هذه القائمة') }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Available Items Section -->
        <div class="space-y-4 bg:-white dark:bg-neutral-800 p-4 rounded-lg shadow">
            <div class="space-y-4">
                <flux:heading size="lg" level="2">{{ __('الأغراض المتوفرة') }}</flux:heading>
                
                <flux:input
                    type="search"
                    wire:model.live.debounce.0ms="searchAvailable"
                    placeholder="ابحث في الأغراض المتوفرة"
                    class="w-full"
                    icon="magnifying-glass"
                />
            </div>

            @foreach($this->filteredCategories as $category)
                @php
                    $availableItems = $category->items->filter(fn($item) => 
                        !$this->listItems->contains($item->id) && 
                        (empty($this->search) || str_contains(strtolower($item->name), strtolower($this->search)))
                    );
                @endphp

                @if($availableItems->isNotEmpty())
                    <div class="space-y-2">
                        <flux:legend style="color: {{ $category->color }};">
                            {{ $category->name }}
                        </flux:legend>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach($availableItems as $item)
                                <flux:button
                                    variant="outline"
                                    wire:click="addItemToList({{ $item->id }})"
                                    class="justify-start"
                                >
                                    {{ $item->name }}
                                </flux:button>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @if($this->filteredCategories->every(fn($cat) => 
                $cat->items->filter(fn($item) => 
                    !$this->listItems->contains($item->id) && 
                    (empty($this->search) || str_contains(strtolower($item->name), strtolower($this->search)))
                )->isEmpty()
            ))
                <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                    {{ $this->searchAvailable 
                        ? __('لا توجد أغراض تطابق البحث') 
                        : __('لا توجد أغراض متاحة للإضافة') 
                    }}
                </div>
            @endif
        </div>
    </div>
</div> --}}