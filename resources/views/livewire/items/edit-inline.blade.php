<form wire:submit="updateItem({{ $item->id }})" class="flex gap-2 py-2">
    <flux:input size="sm" wire:model='itemForm.name' />

    <flux:button size="sm" type="submit" x-on:click="edit_item_{{ $item->id }} = false" icon="check"
        variant="filled" class="cursor-pointer" />
    <flux:button size="sm" x-on:click="edit_item_{{ $item->id }} = false" icon="x-mark" variant="filled"
        class="cursor-pointer" />
</form>
