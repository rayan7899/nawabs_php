<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Modelable;

new class extends Component {
    public $model, $label, $placeholder, $required = false;
    #[Modelable]
    public $value = '';
    public bool $showSuggestions = false;

    public function updatedValue(): void
    {
        $this->showSuggestions = mb_strlen(trim($this->value)) >= 1; // if input grater than 1 show suggestions
    }

    public function getSuggestionsProperty()
    {
        $query = trim($this->value);

        if (mb_strlen($query) < 1) {
            return collect();
        }

        return $this->model::where('name', 'like', '%' . $query . '%')
            // ->whereNotIn('id', $attachedItemIds) //TODO provide attached items, get it by params as $exceptedIds
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    public function selectItem($value): void
    {
        $this->value = $value;
        $this->showSuggestions = false;
        $this->dispatch('item-selected');
    }
}; ?>

<div class="relative" @click.outside="$wire.set('showSuggestions', false)">
    <flux:field>
        <flux:label>{{ $label }} @if($required) <span class="text-red-400 ms-1">*</span> @endif</flux:label>
        <flux:input type="text" wire:model.live="value"
            :placeholder="$placeholder" 
            class="w-full" 
            :required="$required"/>
    </flux:field>

    @if ($showSuggestions && $this->suggestions->isNotEmpty())
        <div class="absolute z-1 mt-1  w-full rounded-md border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-neutral-700">
            @foreach ($this->Suggestions as $suggestion)
                <flux:button wire:click="selectItem('{{ $suggestion->name }}')" wire:key='suggestion_{{ $suggestion->name }}'
                    class="flex w-full py-2 justify-start cursor-pointer border-0">
                    <span class="ms-3">{{ $suggestion->name }}</span>
                </flux:button>
                <flux:separator />
            @endforeach
        </div>
    @endif
</div>
