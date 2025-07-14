@props(['id', 'label', 'active'])

<div id="{{ $id }}" 
    class="p-2 bg-zinc-100 dark:bg-zinc-700 rounded flex cursor-pointer @if($active) active @endif" 
    wire:click="{{ $attributes->get('wire:click') }}"
    x-data="{ active: {{ $active }} }"
    x-on:click="active ? document.getElementById('{{$id}}').classList.remove('active') : document.getElementById('{{$id}}').classList.add('active'); active = !active;">
    {{ $label }}
    <div class="inline-block my-0 mr-auto h-auto w-1 rounded self-stretch bg-neutral-300 dark:bg-white/10"></div>
</div>

<style>
    .active > div{
        background-color: var(--color-green-500);
    }
    .dark .active > div{
        background-color: var(--color-teal-500);
    }
</style>