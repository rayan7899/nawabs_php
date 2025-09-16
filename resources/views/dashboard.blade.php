<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-8 rounded-3xl p-lg-8">
        <div class="grid auto-rows-min gap-8 md:grid-cols-2">
            <div class="relative rounded-2xl bg-white dark:bg-neutral-800 shadow-xl p-4 transition hover:shadow-2xl">
                <livewire:items.add/>
            </div>
            <div class="relative rounded-2xl bg-white dark:bg-neutral-800 shadow-xl p-4 transition hover:shadow-2xl">
                <livewire:category.manage />
            </div>
        </div>
        <div class="relative w-full rounded-2xl bg-white dark:bg-neutral-800 shadow-xl p-4 transition hover:shadow-2xl">
            <livewire:items.manage />
        </div>
        {{-- <div class="relative h-full flex-1 overflow-hidden rounded-2xl border border-blue-200 dark:border-blue-700 bg-white dark:bg-neutral-900 shadow-xl flex items-center justify-center">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-blue-200 dark:stroke-blue-700" />
            <span class="relative z-10 text-blue-400 dark:text-blue-300 text-2xl font-bold tracking-wide">لوحة التحكم</span>
        </div> --}}
    </div>
</x-layouts.app>
