<form wire:submit="updateCategory({{$category->id}})" class="flex gap-2 py-2">
    <flux:input wire:model='categoryForm.name' :placeholder="$category->name"/>
    <flux:input type="color" wire:model='categoryForm.color' 
        class="max-w-12 **:p-0"/>

    <flux:button type="submit" x-on:click="edit_category_{{$category->id}} = false" 
        icon="check" variant="filled" class="cursor-pointer min-w-10"/>
    <flux:button x-on:click="edit_category_{{$category->id}} = false" 
        icon="x-mark" variant="filled" class="cursor-pointer min-w-10" />
</form>
