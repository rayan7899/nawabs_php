<div>
    <flux:button icon="squares-2x2" href="/dashboard" />
    <flux:heading size="xl" level="1" class="ms-3 inline">{{ __('الأغراض') }}</flux:heading>
    <flux:separator variant="subtle" class="mb-5 mt-3" />

    <div class="mb-4">
        <flux:switch wire:model.live="shoppingMode"
            label="وضع التسوق"
            align="start"/>
    </div>

    <div class="mb-4 w-full max-w-md">
        <flux:input
            type="text"
            wire:model.live.debounce.0ms="search"
            name="search"
            placeholder="ابحث عن غرض"
            class="w-full"
            icon="magnifying-glass"/>
    </div>

    <div class="@if(!$shoppingMode) columns-3 md:columns-7 lg:columns-10 xl:columns-13 2xl:columns-15 @endif gap-1">
        @foreach ($categories as $category)
            <div class="gap-1 flex flex-col border-r-1 ps-1" style="border-color: {{ $category->color }};">
                <flux:legend style="color: {{ $category->color }};">
                    {{ $category->name }}
                </flux:legend>

                @foreach ($category->items as $item)
                    <x-item-button wire:click="toggleItem({{ $item->id }})" :label="$item->name" :active="$item->active"
                        wire:key='{{ $item->id }}' :id="$item->id" class="flex-stretch" />
                @endforeach
            </div>
        @endforeach
    </div>
</div>
