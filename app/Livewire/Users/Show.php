<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Computed(cache:true, persist:true)]
    public function getUsersProperty()
    {
        return User::paginate(5);
    }

    public function render()
    {
        return view('livewire.users.show');
    }
}
