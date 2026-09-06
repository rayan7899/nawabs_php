<?php

use Livewire\Volt\Component;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;

new class extends Component {
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function openNotification($notification_id)
    {
        DatabaseNotification::find($notification_id)->markAsRead();
        $this->redirectRoute('invitations.show');
    }

    public function readAll()
    {
        $this->user->unreadNotifications->markAsRead();
    }

    public function deleteAll()
    {
        $this->user->notifications()->delete();
    }
}; ?>

<div>
    <flux:dropdown>
        <flux:button variant="ghost" class="cursor-pointer">
            <div class="relative">
                <flux:icon.bell />
                @if (count($user->unreadNotifications) > 0)
                    <div class="bg-red-600 w-2 aspect-square rounded-full absolute top-0 start-0"></div>
                @endif
            </div>
        </flux:button>

        <flux:menu keep-open class="p-0! **:m-0! min-w-sm md:min-w-lg">
            <div class="flex items-center w-full p-4 bg-zinc-50 dark:bg-zinc-600 sticky top-0">
                <flux:heading size="lg">{{ __("Notifications") }}</flux:heading>
                <flux:spacer/>
                <flux:button wire:click.prevent='deleteAll' size="xs" icon="trash" variant="ghost" class="cursor-pointer">{{__("Delete all")}}</flux:button>
                <flux:button wire:click.prevent='readAll' size="xs" icon="envelope-open" variant="ghost" class="cursor-pointer">{{__("Mark all as read")}}</flux:button>
            </div>
            @forelse ($user->notifications as $notification)
                <div wire:click="openNotification('{{$notification->id}}')"
                    class="{{ !$notification->read_at ? 'border-s-3 border-s-blue-600' : '' }} px-4 pt-2 m-0 w-full hover:bg-zinc-800/5 dark:hover:bg-zinc-600 cursor-pointer">
                    <div class="flex justify-end w-full">
                        <flux:text variant="subtle" class="text-xs ms-auto">{{ $notification->created_at->diffForHumans() }}</flux:text>
                    </div>
                    <flux:heading>{{ $notification->data['title'] ?? 'error' }}</flux:heading>
                    <flux:text>{{ $notification->data['body'] ?? 'error' }}</flux:text>
                </div>
                <flux:menu.separator class=""/>
            @empty
                <div class="flex flex-col gap-2 w-full aspect-video items-center justify-center text-center content-center">
                    <flux:text><flux:icon.inbox class="size-16"/></flux:text>
                    <flux:text class="text-lg text-center">
                        {{ __('There\'s no notifications') }}
                    </flux:text>
                </div>
            @endforelse
        </flux:menu>
    </flux:dropdown>
</div>
