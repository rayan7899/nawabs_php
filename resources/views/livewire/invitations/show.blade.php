<div class="max-w-lg">
    <flux:heading>{{ __('Invitations') }}</flux:heading>

    @forelse ($this->invitations as $invitation)
        <x-card class="bg-gray-500 dark:bg-neutral-100 w-full mt-5 flex">
            <flux:avatar size="xl" 
                name="{{$invitation->list->user->name}}" 
                color="auto" color:seed="{{$invitation->list->user->id}}" 
                class="me-4"/>

            <div class="w-full">
                <flux:text class="flex text-center justify-between mb-2">
                    {{ __('You have receive invitation:') }}
                    <span class="">{{ $invitation->created_at->diffForHumans() }}</span>
                </flux:text>
    
                <flux:heading>{{ $invitation->list->user->name }}</flux:heading>
    
                <flux:subheading>{{ $invitation->list->name }}</flux:subheading>
    
                <div class="flex justify-end gap-1">
                    <flux:button wire:click='reject({{ $invitation->id }})' 
                        class="cursor-pointer"
                        size="sm" 
                        variant="ghost">
                        {{ __('Reject') }}
                    </flux:button>
                    <flux:button wire:click='accept({{ $invitation->id }})' 
                        class="text-green-900 bg-green-100 hover:bg-green-200 cursor-pointer"
                        size="sm" 
                        variant="primary">
                        {{ __('Accept') }}
                    </flux:button>
                </div>
            </div>
        </x-card>
    @empty
        <x-card>
            <p class="text-center">{{ __('No invitations') }}</p>
        </x-card>
    @endforelse
</div>
