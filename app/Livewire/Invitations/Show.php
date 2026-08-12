<?php

namespace App\Livewire\Invitations;

use App\Enums\ListUserStatusEnum;
use App\Models\ListUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function getInvitationsProperty()
    {
        return $this->user->invitations;
    }

    public function accept(ListUser $invitation)
    {
        try {
            $invitation->status = ListUserStatusEnum::ACCEPTED->value;
            $invitation->status_changed_at = now();
            $invitation->save();
            LivewireAlert::title(__("Invitation accepted"))->success()->asToast()->show();
        } catch (\Throwable $th) {
            LivewireAlert::title(__("Failed to accept invitation"))->error()->asToast()->show();
            Log::critical("Failed to accept invitation: " . $th->getMessage(), ['exception' => $th]);
        }
    }

    public function reject(ListUser $invitation)
    {
        try {
            $invitation->status = ListUserStatusEnum::REJECTED->value;
            $invitation->status_changed_at = now();
            $invitation->save();
            LivewireAlert::title(__("Invitation rejected"))->success()->asToast()->show();
        } catch (\Throwable $th) {
            LivewireAlert::title(__("Failed to reject invitation"))->error()->asToast()->show();
            Log::critical("Failed to reject invitation: " . $th->getMessage(), ['exception' => $th]);
        }
    }

    public function render()
    {

        return view('livewire.invitations.show');
    }
}
