<div>
    <flux:navlist.group :heading="__('Lists')" class="grid gap-1" :expandable="true">
        @foreach($this->userLists as $list)
            <flux:navlist.item 
                icon="{{$list->users([App\Enums\ListUserStatusEnum::ACCEPTED->value])->count() > 1 ? 'user-group' : 'list-bullet'}}" 
                :href="route('lists.manage', $list)" 
                :current="request()->route('list') && request()->route('list')->id === $list->id"
                wire:navigate>
                {{ $list->name }}
            </flux:navlist.item>
        @endforeach
        @if($isAddingList)
            <div class="px-2 py-1 space-y-2">
                <flux:input
                    type="text"
                    wire:model="listForm.name"
                    wire:keydown.enter="createList"
                    wire:keydown.escape="cancelAddingList"
                    placeholder="{{ __('List Name') }}"
                    class="w-full text-sm"
                    autofocus
                />
                <flux:error name="listForm.name" />
                <div class="flex gap-1 justify-end">
                    <flux:button size="xs" variant="ghost" wire:click="cancelAddingList" class="px-2">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button size="xs" wire:click="createList" class="px-2">
                        {{ __('Add') }}
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
                {{ __('Add new list') }}
            </flux:navlist.item>
        @endif
    </flux:navlist.group>
</div>