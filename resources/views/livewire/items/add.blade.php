<div class="p-3" dir="rtl">
    <flux:heading size="lg" class="mb-1"> {{ __('اضافة عنصر') }} </flux:heading>
    <flux:separator variant="subtle" class="mb-3" />

    <form wire:submit='save' class="">
        <flux:input wire:model='item_name' 
            type="text" 
            label="اسم العنصر" 
            class="mb-1"
            size="sm"/>

        <flux:select size="sm" class="mb-3" wire:model='category_id' placeholder="اختر تصنيف">
            @foreach($categories as $category)
                <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:button type="submit">
            إضافة
        </flux:button>
    </form>
</div>
