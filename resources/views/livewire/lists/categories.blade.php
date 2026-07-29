<div>
    <!-- List categories as accordion and its items -->
    <!-- allow add edit and delete categories and items -->

    <flux:breadcrumbs>
        <flux:breadcrumbs.item>{{ __('Lists') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __($list->name) }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between mt-3">
        <flux:button.group>
            <flux:button :href="route('lists.newItem', $list->id)" size="sm" class="cursor-pointer">{{__("New Item")}}</flux:button>
            @if($list->type != App\Enums\ListTypeEnum::DEFAULT->value)
                <flux:button href="{{ route('lists.invite', $list) }}" size="sm" wire:navigate>
                    {{__("Invite User")}}
                </flux:button>
            @endif
        </flux:button.group>
    </div>
    

    <div class="space-y-4">
        @forelse ($this->categoriesWithItems as $category)
            <div class="bg-white dark:bg-neutral-800 p-4 rounded-lg shadow mt-2">
                <div class="flex items-center justify-between">
                    <flux:heading size="lg" class="inline-block" style="color: {{ $category->color }}">
                        {{ $category->name }}
                    </flux:heading>
                </div>

                <!-- loop items -->
                <div class="mt-3">
                    @foreach ($category->items as $item)
                        <flux:separator class="my-0" />
                        <div class="flex items-center justify-between p-2 m-0">
                            <span>{{ $item->name }}</span>
                            <flux:button variant="ghost" size="sm" icon="trash"
                                wire:click="removeItemFromList({{ $item->id }})"
                                class="text-red-500 hover:text-red-600" />
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-800 p-4 rounded-lg shadow mt-2">
                <p class="text-center text-gray-500 dark:text-gray-400">
                    {{ __('No items found') }}
                </p>
            </div>    
        @endforelse
    </div>
</div>
