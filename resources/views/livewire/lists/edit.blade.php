<div>
    <x-card class="max-w-lg">
        <flux:heading>{{__("Edit :var", ["var"=>__("List")])}}</flux:heading>
        <flux:text>{{__("Edit list information.")}}</flux:text>

        <form wire:submit='save' class="flex flex-col gap-3 mt-2">
            <flux:input wire:model='listForm.name' label="{{__('Name')}}"/>

            <div>
                <flux:button type="submit" variant="filled">{{__("Save")}}</flux:button>
                <flux:button x-on:click="enable_edit_list = false" variant="filled">{{__("Cancel")}}</flux:button>
            </div>
        </form>
    </x-card>
</div>
