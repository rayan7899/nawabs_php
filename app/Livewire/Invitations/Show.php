<?php

namespace App\Livewire\Invitations;

use App\Enums\ListUserStatusEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public User $user;
    public function mount() {
        $this->user = Auth::user();
    }
    public function getInvitationsProperty()
    {
        return $this->user->lists([ListUserStatusEnum::PENDING->value])->get();
    }

    public function render()
    {

        return view('livewire.invitations.show');
    }
}
