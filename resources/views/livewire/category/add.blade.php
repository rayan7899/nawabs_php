<div class="p-3" dir="rtl">
    <flux:heading size="lg" class="mb-1"> {{ __('اضافة تصنيف') }} </flux:heading>
    <flux:separator variant="subtle" class="mb-3" />

    <form wire:submit='save' class="">
        <flux:input wire:model='category_name' 
            type="text" 
            label="اسم التصنيف" 
            class="mb-3"
            size="sm"/>
        <flux:button>
            إضافة
        </flux:button>
        <flux:button type="button" variant="subtle" wire:click="delete">
            حذف
        </flux:button>
    </form>
</div>
