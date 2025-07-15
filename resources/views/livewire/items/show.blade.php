<div>
    <flux:button icon="squares-2x2" href="/dashboard"/>
    <flux:heading size="xl" level="1" class="ms-3 inline">{{ __('الأغراض') }}</flux:heading>
    <flux:separator variant="subtle" class="mb-5 mt-3" />

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
