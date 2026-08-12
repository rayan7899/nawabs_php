<?php

namespace App\Livewire\Invitations;

use App\Enums\ListUserRoleEnum;
use App\Enums\ListUserStatusEnum;
use App\Models\ItemList;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Invitees extends Component
{
    public ItemList $list;
    #[Validate('required|in:' . ListUserRoleEnum::EDITOR->value . ',' . ListUserRoleEnum::VIEWER->value)]
    public $newRole;

    #[On('refreshInvitees')]
    public function getInviteesProperty()
    {
        return $this->list->users([ListUserStatusEnum::PENDING, ListUserStatusEnum::ACCEPTED])
            ->wherePivotIn('role', [ListUserRoleEnum::EDITOR, ListUserRoleEnum::VIEWER])
            ->get() ?? [];
    }

    function cancelInvitation(User $user)
    {
        LivewireAlert::title(__('Cancel Invitation?'))
            ->text(__('This will prevent user from accessing the list.'))
            ->asConfirm()
            ->confirmButtonColor('red')->confirmButtonText(__('Yes'))
            ->denyButtonColor('gray')->denyButtonText(__('No'))
            ->onConfirm('confirmCancelInvitation', $user)
            ->show();
    }
    function confirmCancelInvitation(User $user)
    {
        try {
            $this->list->users()->updateExistingPivot($user->id, [
                'status' => ListUserStatusEnum::CANCELLED,
                'status_changed_at' => now()
            ]);
            LivewireAlert::title(__('Invitation canceled'))->success()->asToast()->show();

        } catch (\Throwable $th) {
            LivewireAlert::title(__('Failed to cancel invitation'))->error()->show();
            Log::critical("Failed to cancel invitation: " . $th->getMessage(), ['exception' => $th]);
        }
    }

    function updatePermissions(User $user)
    {
        $this->validate();
        try {
            $this->list->users([ListUserStatusEnum::ACCEPTED])->updateExistingPivot($user->id, [
                'role'              => ListUserRoleEnum::from($this->newRole),
                'role_changed_at'   => now()
            ]);
            $this->modal("managePermissions_{$user->id}")->close();
            LivewireAlert::title(__('Permissions updated'))->success()->asToast()->show();
        } catch (\Throwable $th) {
            LivewireAlert::title(__('Failed to update permissions'))->error()->show();
            Log::critical("Failed to update permissions: " . $th->getMessage(), ['exception' => $th]);
        }
    }

    public function render()
    {
        $this->authorize('viewInvitations', $this->list);
        return view('livewire.invitations.invitees');
    }
}
