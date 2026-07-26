<div>
    <flux:breadcrumbs class="mb-4">
        <flux:button size="sm" icon="chevron-right" class="me-3 cursor-pointer" x-on:click="window.history.back()"/>
        <flux:breadcrumbs.item>{{ __('Lists') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('lists.manage', $list) }}">{{ __($list->name) }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('Invite User') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="bg-white dark:bg-neutral-800 p-4 rounded-lg shadow mt-2 max-w-lg">
        <flux:heading>{{ __('Invite User') }}</flux:heading>
        <flux:text class="mt-1">
            {{ __('Invite users to interact together in this list.') }}
        </flux:text>

        <form wire:submit.prevent="sendInvitation" class="mt-4">
            <flux:input wire:model="invitedUser" type="email" name="invitedUser" :label="__('Email')" />

            <flux:button type="submit" class="mt-4">
                {{ __('Send Invitation') }}
            </flux:button>
        </form>
    </div>
</div>
