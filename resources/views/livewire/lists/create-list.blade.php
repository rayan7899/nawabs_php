<div>
    <x-modal name="create-list" :show="$errors->isNotEmpty()">
        <form wire:submit="create" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                {{ __('إنشاء قائمة جديدة') }}
            </h2>

            <div class="mt-6">
                <flux:input
                    type="text"
                    wire:model="name"
                    class="mt-1 block w-full"
                    placeholder="{{ __('اسم القائمة') }}"
                />

                <flux:error name="name" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <flux:button x-on:click="$dispatch('close')">
                    {{ __('إلغاء') }}
                </flux:button>

                <flux:button class="mr-3">
                    {{ __('إنشاء') }}
                </flux:button>
            </div>
        </form>
    </x-modal>
</div>