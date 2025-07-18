<div class="p-3" dir="rtl">
    <form wire:submit.prevent="save" class="mb-6">

        <div class="flex gap-1 w-full mb-2">
            <div class="flex-1">
                <flux:input type="text" 
                    wire:model.defer="name" 
                    name="category_name" 
                    label="اسم التصنيف" 
                    size="sm" />
            </div>
    
            <div class="w-20">
                <flux:input type="color" 
                    wire:model.defer="color" 
                    name="category_color" 
                    size="sm" 
                    label="اللون" />
            </div>
        </div>

        <div class="flex gap-2 justify-start">
            <flux:button type="submit">{{ $isEdit ? 'تحديث' : 'إضافة' }}</flux:button>
            @if($isEdit)
                <flux:button type="button" wire:click="resetForm">إلغاء</flux:button>
            @endif
        </div>
        @if (session()->has('error'))
            <div class="text-red-500 mt-2 text-sm">{{ session('error') }}</div>
        @endif
    </form>

    <div class="overflow-x-scroll">
        <table class="min-w-full text-sm border border-zinc-200 dark:border-zinc-700 rounded text-right">
            <thead class="bg-zinc-100 dark:bg-zinc-700">
                <tr>
                    <th class="border-b p-2 font-semibold text-zinc-700 dark:text-zinc-200">#</th>
                    <th class="border-b p-2 font-semibold text-zinc-700 dark:text-zinc-200">الاسم</th>
                    <th class="border-b p-2 font-semibold text-zinc-700 dark:text-zinc-200">اللون</th>
                    <th class="border-b p-2 font-semibold text-zinc-700 dark:text-zinc-200">إجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800">
                @foreach($categories as $cat)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <td class="border-b p-2 text-center">{{ $cat->id }}</td>
                        <td class="border-b p-2">{{ $cat->name }}</td>
                        <td class="border-b p-2">
                            <span class="inline-block w-8 h-4 rounded" style="background: {{ $cat->color }};"></span>
                            <span class="mr-2 text-xs">{{ $cat->color }}</span>
                        </td>
                        <td class="border-b p-2">
                            <button wire:click="edit({{ $cat->id }})" class="text-blue-600 hover:underline me-2">تعديل</button>
                            <button wire:click="delete({{ $cat->id }})" class="text-red-600 hover:underline">حذف</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
