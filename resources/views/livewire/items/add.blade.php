<div>
    <x-slot name="breadcrumbs">
        <flux:breadcrumbs class="mb-4">
            <flux:button size="sm" icon="chevron-right" class="me-3 cursor-pointer" x-on:click="window.history.back()" />
            <flux:breadcrumbs.item>{{ __('Lists') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('lists.manage', $list) }}" wire:navigate>{{ __($list->name) }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('New Item') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot>

    <x-card class="max-w-lg">
        <flux:heading>
            {{ __('New Item') }}
        </flux:heading>
        <flux:text>
            {{ __('Add new custom item to selected list to use it in future.') }}
        </flux:text>



        <form wire:submit.prevent="add" class="mt-4 space-y-3">
            <!-- autocomplete input for item name -->
            <livewire:components.autocomplete_input wire:model='itemForm.name' :model="App\Models\Item::class" :label="__(':var Name', ['var' => __('Item')])"
                :placeholder="__('Start typing to find items')" :required="true" />
            <flux:error name="itemForm.name"/>

            <!-- autocomplete input for category name -->
            <livewire:components.autocomplete_input wire:model='categoryForm.name' :model="App\Models\Category::class" :label="__('Category')"
                :placeholder="__('Start typing to find categories')" :required="true" />
            <flux:error name="categoryForm.name"/>
            
            <div class="flex items-center gap-2">
                <flux:button type="submit">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>
    </x-card>
</div>
