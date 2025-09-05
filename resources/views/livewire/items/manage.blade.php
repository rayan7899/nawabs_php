<div class="p-0 rounded-lg shadow-md w-full" dir="rtl" style="text-align: right;">
    <flux:heading size="xl" class="mb-1"> {{ __('ادارة العناصر') }} </flux:heading>
    <flux:separator variant="subtle" class="mb-3" />
    <div class="mb-4 flex flex-row-reverse items-center gap-2">
        <flux:input wire:model.live.debounce.0ms="search"
            type="search"
            icon="magnifying-glass"
            placeholder="ابحث عن غرض"
            class="border border-blue-400 dark:border-blue-700 rounded-lg w-1/2 focus:ring-2 focus:ring-blue-400 text-right bg-white dark:bg-neutral-900 text-blue-900 dark:text-blue-100 transition duration-200 shadow font-medium text-sm" />
    </div>
    @if (session()->has('message'))
        <div class="mb-4 px-3 py-2 rounded-lg bg-green-100 text-green-800 border border-green-300 shadow text-sm font-semibold flex items-center gap-1">
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
            {{ session('message') }}
        </div>
    @endif
    @foreach ($filteredCategories as $category)
        <div class="mb-4">
            <h2 class="font-bold text-base mb-3 text-blue-700 dark:text-blue-300 border-b border-blue-300 dark:border-blue-700 pb-1 tracking-wide">
                {{ $category->name }}
            </h2>
            <table class="w-full rounded-lg overflow-hidden shadow bg-white dark:bg-neutral-900 text-sm">
                <tbody>
                    @forelse ($category->items as $item)
                        <tr class="border-b last:border-b-0 hover:bg-blue-100 dark:hover:bg-blue-900 transition duration-200">
                            <td class="p-2 align-middle">
                                @if ($editItemId === $item->id)
                                    <input type="text" wire:model.defer="editItemName"
                                        class="border border-blue-400 dark:border-blue-700 rounded-lg px-2 py-1 w-full focus:ring-2 focus:ring-blue-400 text-right bg-white dark:bg-neutral-900 text-blue-900 dark:text-blue-100 transition duration-200 shadow-sm font-medium text-sm" />
                                @else
                                    <span class="text-blue-900 dark:text-blue-100 font-semibold text-sm">{{ $item->name }}</span>
                                @endif
                            </td>
                            <td class="p-2 align-middle text-end">
                                @if ($editItemId === $item->id)
                                    <button wire:click="saveEdit"
                                        class="px-2 py-1 rounded-lg bg-green-500 text-white hover:bg-green-600 transition duration-200 font-semibold shadow-sm text-sm">حفظ</button>
                                    <button wire:click="cancelEdit"
                                        class="mr-1 px-2 py-1 rounded-lg bg-gray-300 text-gray-800 hover:bg-gray-400 transition duration-200 font-semibold shadow-sm text-sm">إلغاء</button>
                                @else
                                    <button wire:click="startEdit({{ $item->id }})"
                                        class="px-2 py-1 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition duration-200 font-semibold shadow-sm text-sm">تعديل</button>
                                    <button wire:click="deleteItem({{ $item->id }})"
                                        class="mr-1 px-2 py-1 rounded-lg bg-red-500 text-white hover:bg-red-600 transition duration-200 font-semibold shadow-sm text-sm">حذف</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-2 text-gray-500 text-sm">لا توجد منتجات في هذا القسم.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach
</div>
