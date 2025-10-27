<div>
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:button icon="squares-2x2" href="/dashboard" />
            <flux:heading size="xl" level="1" class="ms-3 inline">{{ __('إدارة الأغراض الافتراضية') }}</flux:heading>
        </div>
    </div>

    <flux:separator variant="subtle" class="mb-5 mt-3" />

    <!-- Add New Category Section -->
    <div class="mb-8">
        <flux:heading size="lg" level="2" class="mb-4">{{ __('إضافة قسم جديد') }}</flux:heading>
        <form wire:submit="createCategory" class="flex gap-3 items-end">
            <div class="flex-grow max-w-md">
                <flux:input
                    type="text"
                    wire:model="newCategoryName"
                    placeholder="اسم القسم"
                />
                @error('newCategoryName')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <flux:input
                    type="color"
                    wire:model="newCategoryColor"
                    class="h-10 w-20"
                />
                @error('newCategoryColor')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <flux:button type="submit">إضافة القسم</flux:button>
        </form>
    </div>

    <!-- Categories and Items Section -->
    <div class="space-y-8">
        @foreach($this->categories as $category)
            <div class="space-y-4">
                <!-- Category Header -->
                @if($editingCategoryId === $category->id)
                    <form wire:submit="updateCategory" class="flex gap-3 items-center">
                        <flux:input
                            type="text"
                            wire:model="editCategoryName"
                            class="flex-grow max-w-md"
                        />
                        <flux:input
                            type="color"
                            wire:model="editCategoryColor"
                            class="h-10 w-20"
                        />
                        <flux:button type="submit" size="sm">حفظ</flux:button>
                        <flux:button type="button" variant="ghost" size="sm" wire:click="$set('editingCategoryId', null)">إلغاء</flux:button>
                    </form>
                @else
                    <div class="flex items-center justify-between">
                        <flux:legend style="color: {{ $category->color }};" class="text-lg">
                            {{ $category->name }}
                        </flux:legend>
                        <div class="flex gap-2">
                            <flux:button
                                variant="ghost"
                                size="sm"
                                icon="pencil"
                                wire:click="startEditingCategory({{ $category->id }})"
                            />
                            <flux:button
                                variant="ghost"
                                size="sm"
                                icon="trash"
                                class="text-red-500 hover:text-red-600"
                                wire:click="deleteCategory({{ $category->id }})"
                                wire:confirm="هل أنت متأكد من حذف هذا القسم وجميع أغراضه؟"
                            />
                        </div>
                    </div>
                @endif

                <!-- Add Item Form -->
                <form wire:submit="addItem" class="flex gap-2">
                    <flux:input
                        type="text"
                        wire:model="newItemName"
                        placeholder="اسم الغرض الجديد"
                        class="flex-grow"
                        wire:click="$set('selectedCategoryId', {{ $category->id }})"
                    />
                    <flux:button type="submit" icon="plus" :disabled="$selectedCategoryId !== $category->id" />
                </form>

                <!-- Items List -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                    @foreach($category->items as $item)
                        <div class="flex items-center justify-between p-2 bg-white dark:bg-zinc-800 rounded-lg shadow-sm">
                            <span>{{ $item->name }}</span>
                            <flux:button
                                variant="ghost"
                                size="sm"
                                icon="trash"
                                wire:click="deleteItem({{ $item->id }})"
                                wire:confirm="هل أنت متأكد من حذف هذا الغرض؟"
                                class="text-red-500 hover:text-red-600"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>