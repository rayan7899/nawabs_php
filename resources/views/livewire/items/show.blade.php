<div>
    <!-- top navbar -->
    <div class="flex w-full justify-between">
        <flux:brand :name="__('Nawaqs')" :href="route('lists.manage', ['list' => $selectedListId])" />

        <flux:radio.group wire:model.live="selectedListId" variant="segmented" size="sm"
            class="cursor-pointer">
            @foreach ($lists as $list)
                <flux:radio value="{{ $list->id }}" label="{{ $list->name }}" />
            @endforeach
        </flux:radio.group>
    </div>
    <flux:separator variant="subtle" />

    <div class="flex max-sm:flex-col gap-4 mt-4 h-full max-w-full">
        <!-- Categories in desktop -->
        <flux:navlist class="md:min-w-fit lg:min-w-3xs max-sm:hidden ">
            <flux:navlist.item wire:click="selectCategory()" class="cursor-pointer"
                :current="$selectedCategory?->id == null">
                {{ __("All") }}
            </flux:navlist.item>
            @foreach ($this->categories as $category)
                <flux:navlist.item wire:click="selectCategory({{ $category->id }})" class="cursor-pointer"
                    :current="$selectedCategory?->id == $category->id">
                    {{ $category->name }}
                </flux:navlist.item>
            @endforeach
        </flux:navlist>
        <flux:separator orientation="vertical" variant="subtle" class="" />

        <!-- Categories in mobile -->
        <div class="flex flex-nowrap gap-1 overflow-auto sm:hidden sticky top-0 py-4 dark:bg-neutral-800 bg-white">
            <flux:button wire:click="selectCategory()"
                variant="{{ $selectedCategory?->id == null ? 'filled' : 'ghost' }}" size="sm">
                {{ __("All") }}
            </flux:button>
            @foreach ($this->categories as $category)
                <flux:button wire:click="selectCategory({{ $category->id }})"
                    variant="{{ $selectedCategory?->id == $category->id ? 'filled' : 'ghost' }}" size="sm">
                    {{ $category->name }}
                </flux:button>
            @endforeach
        </div>

        <div x-data="{
            pressTimer: null,
            startPress(id) {
                this.clearPress();
        
                this.pressTimer = setTimeout(() => {
                    $wire.longPressed(id);
                    this.clearPress();
                }, 400);
            },
            clearPress() {
                if (this.pressTimer) {
                    clearTimeout(this.pressTimer);
                    this.pressTimer = null;
                }
            }
        }" class="flex flex-wrap gap-1.5 place-content-start w-full">
            <flux:input wire:model.live.debounce.400ms='search' size="sm" type="search" icon="magnifying-glass"
                :placeholder="__('Search')" />
            @forelse ($this->items as $item)
            {{-- @dump($item) --}}
                <x-card x-on:click="document.getElementById('button_{{ $item->id }}').classList.toggle('border-green-500')"
                    wire:click='toggleItem(null, {{ $item->id }})'
                    class="select-none flex flex-col justify-between w-23 h-23 text-center cursor-pointer overflow-hidden pb-2 px-2 m-0"
                    x-on:mousedown="startPress({{ $item->id }})"
                    x-on:touchstart.passive="startPress({{ $item->id }})" x-on:mouseup="clearPress()"
                    x-on:mouseleave="clearPress()" x-on:touchend="clearPress()">
                    <hr id="button_{{ $item->id }}"
                        class="mx-2 border-2 border-green-100 @if ($item->need_at) border-green-500 @endif rounded-md" />
                    @if ($item->quantity)
                        <flux:text>{{ $item->quantity }}</flux:text>
                    @endif
                    <flux:heading class="text-sm/4.5">{{ $item->name }}</flux:heading>
                </x-card>
            @empty
                <x-card class="m-4">
                    <flux:heading>{{ __("No items found") }}</flux:heading>
                    <flux:text>{{ __("You can add items by inter its name and category below.") }}</flux:text>

                    <form class="flex flex-col gap-3 mt-4" wire:submit="newItem">
                        <flux:input wire:model='search' label="{{__('Name')}}" />
                        <flux:input wire:model='categoryForm.name' clearable label="{{__('Category')}}" />
                        <flux:button class="w-fit cursor-pointer" 
                            type="submit" variant="filled">
                            {{__('Save')}}
                        </flux:button>
                    </form>
                </x-card>
            @endforelse
        </div>
    </div>
</div>
