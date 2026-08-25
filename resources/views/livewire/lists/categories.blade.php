<div x-data="{enable_edit_list: false}">
    <!-- List categories as accordion and its items -->
    <!-- allow add edit and delete categories and items -->

    <flux:breadcrumbs>
        <flux:breadcrumbs.item>{{ __('Lists') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $list->name }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between my-3">
        <flux:button.group>
            @can('update', $list)
                <flux:button x-on:click="enable_edit_list = ! enable_edit_list" size="sm">{{__("Edit :var", ["var"=>__("List")])}}</flux:button>
            @endcan
            <flux:button :href="route('lists.newItem', $list->id)" size="sm" class="cursor-pointer" wire:navigate>{{__("New Item")}}</flux:button>
            @if($list->type != App\Enums\ListTypeEnum::DEFAULT->value && $list->created_by == auth()->user()->id)
                <flux:button href="{{ route('lists.invite', $list) }}" size="sm" wire:navigate>
                    {{__("Invite User")}}
                </flux:button>
            @endif
        </flux:button.group>

        <!-- the list's members -->
        @if($list->users([App\Enums\ListUserStatusEnum::ACCEPTED->value])->count() > 1)
            <flux:avatar.group class="me-2">
                @foreach($list->users([App\Enums\ListUserStatusEnum::ACCEPTED->value])->limit(2)->get() as $user)
                    <flux:avatar color="auto" color:seed="{{$user->id}}" name="{{ $user->name }}"/>
                @endforeach
                @if ($list->users([App\Enums\ListUserStatusEnum::ACCEPTED->value])->count() > 2)
                    <flux:avatar name="+{{ $list->users([App\Enums\ListUserStatusEnum::ACCEPTED->value])->count() - 2 }}"/>
                @endif
            </flux:avatar.group>
        @endif
    </div>
    

    <div x-show="!enable_edit_list" class="space-y-4">
        @forelse ($this->categoriesWithItems as $category)
            <div x-data="{edit_category_{{$category->id}}: false}" class="bg-white dark:bg-neutral-800 p-4 rounded-lg shadow">
                <div class="flex items-center justify-between py-2" x-show="!edit_category_{{$category->id}}">
                    <flux:heading size="lg" class="inline-block" style="color: {{ $category->color }}">
                        {{ $category->name }}
                    </flux:heading>
                    <flux:button x-on:click="edit_category_{{$category->id}} = true" 
                        icon="pencil" variant="ghost" class="cursor-pointer" aria-label="{{__('Edit category')}}"/>
                </div>

                <!-- edit category section -->
                <div wire:key='{{$category->id}}' 
                    x-on:click.outside="edit_category_{{$category->id}} = false" 
                    x-show="edit_category_{{$category->id}}">
                    <livewire:category.edit-inline lazy :$category>
                </div>

                <!-- loop items -->
                @foreach ($category->items as $item)
                    <div x-data="{edit_item_{{$item->id}}: false}">
                        <flux:separator/>
                        <div x-show="!edit_item_{{$item->id}}" class="flex items-center justify-between py-2 px-4">
                            <span>{{ $item->name }}</span>
                            <flux:button variant="ghost" size="sm" icon="presentation-chart-line"
                                :href="route('item.usage', [$item, 'li' => $list->id])" wire:navigate
                                class="ms-auto"
                                aria-label="{{__('Usage')}}" />
                            <flux:button variant="ghost" size="sm" icon="trash"
                                wire:click="removeItemFromList({{ $item->id }})"
                                class="text-red-500 hover:text-red-600 cursor-pointer"
                                aria-label="{{__('Remove Item')}}" />
                            <flux:button variant="ghost" size="sm" icon="pencil"
                                x-on:click="edit_item_{{$item->id}} = true; $wire.itemForm.name = '{{$item->name}}'"
                                class="cursor-pointer"
                                aria-label="{{__('Remove Item')}}" />
                        </div>

                        <!-- edit item section -->
                        <div wire:key='{{$item->id}}' 
                            x-on:click.outside="edit_item_{{$item->id}} = false"
                            x-show="edit_item_{{$item->id}}">
                            <livewire:items.edit-inline lazy :$item>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-800 p-4 rounded-lg shadow mt-2">
                <p class="text-center text-gray-500 dark:text-gray-400">
                    {{ __('No items found') }}
                </p>
            </div>    
        @endforelse
    </div>

    @can('update', $list)
        <div x-show="enable_edit_list">
            <livewire:lists.edit :$list>
        </div>
    @endcan
</div>
