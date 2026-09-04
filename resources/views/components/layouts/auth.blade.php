<x-layouts.guest :title="$title ?? null">
    <div class="flex flex-col gap-6 min-h-lvh w-full items-center justify-center">
        {{ $slot }}
    </div>
</x-layouts.guest>
