<div>
    <flux:breadcrumbs>
        <flux:button size="sm" icon="chevron-right" class="me-3 cursor-pointer" x-on:click="window.history.back()" />
        <flux:breadcrumbs.item>{{ __('Lists') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('lists.manage', $list)" wire:navigate>{{ __($list->name) }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __($item->name) }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('Usage') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>


    <x-card class="mt-3 max-w-lg">
        <ul class="relative border-r-2 border-blue-300 dark:border-blue-700 mr-4">
            @forelse ($this->usages as $usage)
                <li class="mb-8 mr-6">
                    <div class="absolute w-5 h-5 bg-blue-500 rounded-full -right-2.5 border border-white"></div>
                    <div class="">
                        <div class="flex justify-between items-center mb-2">
                            <span
                                class="font-semibold text-blue-700 dark:text-blue-300">{{ $usage->action->label() ?? 'error' }}</span>
                            <span
                                class="text-xs text-gray-500">{{ $usage->created_at->translatedFormat('Y/m/d h:i A') }}</span>
                        </div>
                        <div class="text-sm text-gray-700 dark:text-gray-300">{{ $usage->description ?? '' }}</div>
                    </div>
                </li>
            @empty
                <li class="mr-6 text-gray-500">{{ __("No item's usages recorded.") }}</li>
            @endforelse
        </ul>
    </x-card>
</div>
