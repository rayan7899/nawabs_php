<div class="p-3" dir="rtl">
    <form wire:submit='save'></form>
    <flux:heading size="xl" class="mb-3"> {{ __('اضافة عنصر') }} </flux:heading>
    <flux:separator variant="subtle" class="mb-5" />

    <flux:input wire:model='item_name' type="text" label="اسم العنصر"  class="mb-3"/>
    <flux:button wire:click="save">
        إضافة
    </flux:button>
    <flux:button variant="subtle" wire:click="delete">
        حذف
    </flux:button>
</div>
