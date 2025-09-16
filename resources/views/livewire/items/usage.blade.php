<div class="p-6 w-full max-w-sm mx-auto" dir="rtl">
    <h2 class="text-2xl font-bold mb-6 text-blue-700 dark:text-blue-300 text-center">سجل استخدام العنصر: {{ $item->name }}</h2>
    <ul class="relative border-r-2 border-blue-300 dark:border-blue-700 mr-4">
        @forelse ($usages as $usage)
            <li class="mb-8 mr-6">
                <div class="absolute w-5 h-5 bg-blue-500 rounded-full -right-2.5 border border-white"></div>
                <div class="bg-white dark:bg-neutral-900 rounded-lg shadow ">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-blue-700 dark:text-blue-300">{{ $usage->action->label() ?? 'error' }}</span>
                        <span class="text-xs text-gray-500">{{ $usage->created_at->translatedFormat('Y/m/d h:i A') }}</span>
                    </div>
                    <div class="text-sm text-gray-700 dark:text-gray-300">{{ $usage->description ?? '' }}</div>
                </div>
            </li>
        @empty
            <li class="mr-6 text-gray-500">لا يوجد سجل استخدام لهذا العنصر.</li>
        @endforelse
    </ul>
</div>
