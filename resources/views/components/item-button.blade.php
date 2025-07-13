@props(['id', 'label', 'active'])


<div class="p-2 bg-zinc-100 dark:bg-zinc-700 rounded flex cursor-pointer" 
    wire:click="{{ $attributes->get('wire:click') }}">
    {{ $label }}
    <div class="inline-block my-0 mr-auto h-auto w-1 rounded self-stretch @if($active) bg-green-500 dark:bg-teal-500 @else bg-neutral-300 dark:bg-white/10 @endif"></div>
</div>
