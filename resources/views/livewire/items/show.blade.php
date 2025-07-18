<div>
    <flux:button icon="squares-2x2" href="/dashboard" />
    <flux:heading size="xl" level="1" class="ms-3 inline">{{ __('الأغراض') }}</flux:heading>
    <flux:separator variant="subtle" class="mb-5 mt-3" />

    <div class="columns-3 md:columns-7 lg:columns-10 xl:columns-13 2xl:columns-15 gap-1">

        @foreach ($categories as $category)
            <div class="gap-1 flex flex-col border-r-1 ps-1" style="border-color: {{ $category->color }};">
                <flux:heading style="color: {{ $category->color }};">
                    {{ $category->name }}
                </flux:heading>

                @foreach ($category->items as $item)
                    <x-item-button wire:click="toggleItem({{ $item->id }})" :label="$item->name" :active="$item->active"
                        wire:key='{{ $item->id }}' :id="$item->id" class="flex-stretch" />
                @endforeach
            </div>
        @endforeach
    </div>
</div>
