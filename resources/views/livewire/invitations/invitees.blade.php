<div class="">
    <x-card>
        <flux:heading>{{ __("Invitations") }}</flux:heading>

        @forelse ($this->invitees as $user)
            <flux:separator class="mt-3 mb-3"/>
            <div class="flex gap-3">
                <flux:avatar color="auto" color:seed="{{$user->id}}" name="{{$user->name}}"/>
                <div class="flex flex-col w-full">
                    <div class="flex text-center gap-2">
                        <flux:heading>{{$user->name}}</flux:heading>
                        <flux:text size="sm">({{ __($user->pivot->role->name) }})</flux:text>
                        <flux:text size="sm" class="ms-auto">{{ $user->pivot->created_at->diffForHumans() }}</flux:text>
                    </div>

                    <flux:text size="sm">{{ __($user->email) }}</flux:text>

                    <div class="flex gap-2">
                        <flux:text class="me-auto mt-2">{{ __($user->pivot->status->name) }}</flux:text>
                        @if($user->pivot->status == App\Enums\ListUserStatusEnum::ACCEPTED)
                            <flux:modal.trigger name="managePermissions_{{ $user->id }}" class="mt-2">
                                <flux:button size="sm" 
                                    variant="primary" 
                                    class="bg-blue-100 hover:bg-blue-200 text-blue-900 cursor-pointer">
                                    {{ __('Permissions') }}
                                </flux:button>
                            </flux:modal.trigger>
                        @endif
                        @if(in_array($user->pivot->status, [App\Enums\ListUserStatusEnum::PENDING, App\Enums\ListUserStatusEnum::ACCEPTED]))
                            <flux:button wire:click='cancelInvitation({{ $user->id }})' 
                                size="sm" 
                                variant="primary" 
                                class="bg-red-100 hover:bg-red-200 text-red-900 cursor-pointer">
                                {{ __('Cancel') }}
                            </flux:button>
                        @endif
                    </div>
                </div>
            </div>
            
            <flux:modal name="managePermissions_{{ $user->id }}" class="min-w-full sm:min-w-96">
                <flux:heading>{{ __("Manage permissions") }}</flux:heading>
                <flux:text>{{ __("You can manage permission for existing users.") }}</flux:text>
                <form wire:submit.prevent="updatePermissions({{ $user->id }})" class="mt-6">
                    <flux:heading class="mb-3">{{ $user->name }}</flux:heading>
                    <flux:radio.group wire:model='newRole' :label="__('Permission')" variant="segmented" size="sm">
                        <flux:radio value="{{App\Enums\ListUserRoleEnum::EDITOR->value}}" 
                            label="{{__('Editor')}}" 
                            />
                        <flux:radio value="{{App\Enums\ListUserRoleEnum::VIEWER->value}}" 
                            label="{{__('Viewer')}}" 
                            />
                    </flux:radio.group>
        
                    <flux:button type="submit" class="mt-3">{{__("Save")}}</flux:button>
                </form>
            </flux:modal>
        @empty
            <flux:text class="text-center">{{__("No invitations")}}</flux:text>
        @endforelse
    </x-card>

</div>
