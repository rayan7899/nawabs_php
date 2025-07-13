<div>
    <flux:heading size="xl" level="1" class="mb-3">{{ __('الأغراض') }}</flux:heading>
    <flux:separator variant="subtle" class="mb-5" />

    <div class="grid grid-cols-3 md:grid-cols-7 lg:grid-cols-10 xl:grid-cols-13 2xl:grid-cols-15 gap-1">
        @foreach ($items as $item)
            <x-item-button wire:click="toggleItem({{ $item->id }})"
                :label="$item->name" 
                :active="$item->active" 
                wire:key='{{$item->id}}' 
                :id="$item->id" />
        @endforeach
    </div>
</div>
