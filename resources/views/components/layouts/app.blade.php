<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        @isset($breadcrumbs)
            {{$breadcrumbs}}
        @endisset

        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
