<div>
    <x-modal name="create-list" :show="$errors->isNotEmpty()">
        <form wire:submit="save" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Add new list') }}
            </h2>

            <div class="mt-6">
                <flux:input wire:model="listForm.name"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Name') }}"
                    autofocus/>

                <flux:error name="listForm.name" class="mt-2" />
            </div>

            <div class="mt-6 flex gap-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button type="submit">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>
    </x-modal>
</div>