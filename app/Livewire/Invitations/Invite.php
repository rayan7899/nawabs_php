<?php

namespace App\Livewire\Invitations;

use App\Enums\ListInvitationStatusEnum;
use App\Enums\ListTypeEnum;
use App\Enums\ListUserRoleEnum;
use App\Enums\ListUserStatusEnum;
use App\Models\ItemList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Invite extends Component
{
    public ItemList $list;
    #[Validate('required|email|exists:users,email')]
    public string $invitedUser;
    #[Validate('required|in:'.ListUserRoleEnum::EDITOR->value.','.ListUserRoleEnum::VIEWER->value)]
    public $role;

    public function mount($listId)
    {
        $this->list = ItemList::find($listId);
        if($this->list->type == ListTypeEnum::DEFAULT->value){
            //check if list is Default can not invite any one to it.
            LivewireAlert::title(__('can not invite users to this list.'))
                ->text(__('create new list to use sharing service and invite users to it'))
                ->warning()->timer(8000)->timerProgressBar()->show();
            return;
        }
        $this->role = ListUserRoleEnum::EDITOR->value;
    }

    public function sendInvitation()
    {
        $this->authorize('invite', $this->list);
        $this->validate();
        try {
            $user = User::where('email', $this->invitedUser)->first();
            if ($user->lists([ListUserStatusEnum::PENDING->value, ListUserStatusEnum::ACCEPTED->value])
                ->where('list_id', $this->list->id)
                ->exists()
            ) {
                // check if the user has already been invited to this list
                LivewireAlert::title(__('User has already been invited.'))
                    ->warning()->timerProgressBar()->show();
                return;
            }

            if($this->list->type == ListTypeEnum::DEFAULT->value){
                //check if list is Default can not invite any one to it.
                LivewireAlert::title(__('can not invite users to this list.'))
                    ->text(__('create new list to use sharing service and invite users to it'))
                    ->warning()->timer(8000)->timerProgressBar()->show();
                return;
            }

            $this->list->users()->attach($user,[
                'role'      => $this->role,
                'status'    => ListUserStatusEnum::PENDING->value,
            ]);
            $this->reset('invitedUser');
            $this->dispatch('refreshInvitees');
            LivewireAlert::title(__('Invitation sent successfully.'))
                ->success()->asToast()->show();
        } catch (\Throwable $th) {
            Log::error('Error sending invitation: ' . $th->getMessage());
            LivewireAlert::title(__('Error sending invitation.') . $th->getCode())
                ->timer(4000)->timerProgressBar(true)->error()->show();
                throw $th;
        }
    }

    public function render()
    {
        return view('livewire.invitations.invite');
    }
}
