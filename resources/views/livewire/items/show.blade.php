<div>
    @if($list)
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
            <div class="flex flex-nowrap gap-1 overflow-auto sm:hidden sticky top-0 p-2 rounded-md dark:bg-neutral-800 bg-white">
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
                        class="select-none flex flex-col justify-between w-22.5 aspect-square text-center cursor-pointer overflow-hidden pb-2 px-2 m-0"
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
                            <!-- autocomplete input for item name -->
                            <livewire:components.autocomplete_input wire:model='search' :model="App\Models\Item::class" :label="__(':var Name', ['var' => __('Item')])"
                                :placeholder="__('Start typing to find items')" :required="true" />
                            <flux:error name="itemForm.name"/>

                            <!-- autocomplete input for category name -->
                            <livewire:components.autocomplete_input wire:model='categoryForm.name' :model="App\Models\Category::class" :label="__('Category')"
                                :placeholder="__('Start typing to find categories')" :required="true" clearable/>
                            <flux:error name="categoryForm.name"/>

                            <flux:button class="w-fit cursor-pointer" 
                                type="submit" variant="filled">
                                {{__('Save')}}
                            </flux:button>
                        </form>
                    </x-card>
                @endforelse
            </div>
        </div>
    @else
        <div class="flex justify-center w-full">
            <x-card class="max-w-lg w-full">
                <flux:heading>{{__("You don't have any list")}}  </flux:heading>
                <flux:text>{{__("Create your first list know")}}</flux:text>
                <form wire:submit='createList'
                    class="mt-3">
                    <flux:input wire:model='listForm.name'
                        :placeholder="__('Name')"/>
                    <flux:error name="listForm.name"/>

                    <flux:button type="submit" class="mt-2">
                        {{__("Save")}}
                    </flux:button>
                </form>
            </x-card>
        </div>    
    @endif
</div>
