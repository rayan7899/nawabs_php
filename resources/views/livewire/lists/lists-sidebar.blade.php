<div>
    <flux:navlist.group :heading="__('القوائم')" class="grid gap-1" :expandable="true">
        @foreach($this->userLists as $list)
            <flux:navlist.item 
                icon="list-bullet" 
                :href="route('lists.manage', $list)" 
                :current="request()->route('list') == $list"
                wire:navigate
            >
                {{ $list->name }}
            </flux:navlist.item>
        @endforeach
        @if($isAddingList)
            <div class="px-2 py-1 space-y-2">
                <flux:input
                    type="text"
                    wire:model="newListName"
                    wire:keydown.enter="createList"
                    wire:keydown.escape="cancelAddingList"
                    placeholder="{{ __('اسم القائمة') }}"
                    class="w-full text-sm"
                    autofocus
                />
                <div class="flex gap-1 justify-end">
                    <flux:button size="xs" variant="ghost" wire:click="cancelAddingList" class="px-2">
                        {{ __('إلغاء') }}
                    </flux:button>
                    <flux:button size="xs" wire:click="createList" class="px-2">
                        {{ __('إضافة') }}
                    </flux:button>
                </div>
                @error('newListName')
                    <p class="text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        @else
            <flux:navlist.item 
                icon="plus" 
                href="#"
                wire:click="startAddingList"
                class="text-blue-600 dark:text-blue-400"
            >
                {{ __('إضافة قائمة جديدة') }}
            </flux:navlist.item>
        @endif
    </flux:navlist.group>
</div>