<?php

namespace App\Policies;

use App\Enums\ListUserRoleEnum;
use App\Models\ItemList;
use App\Models\ListUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemListPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ItemList $list): bool
    {
        return $user->lists->contains($list);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ItemList $list): bool
    {
        return $list->created_by == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ItemList $itemList): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ItemList $itemList): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ItemList $itemList): bool
    {
        return false;
    }

    /**
     * Determine whether the user can invite users to the list.
     */
    public function invite(User $user, ItemList $itemList): bool
    {
        return ListUser::where('user_id', $user->id)
            ->where('list_id', $itemList->id)
            ->where('role', ListUserRoleEnum::OWNER->value)
            ->exists();
    }

    /**
     * Determine whether the user can view invitations for the list.
     */
    public function viewInvitations(User $user, ItemList $itemList): bool
    {
        return ListUser::where('user_id', $user->id)
            ->where('list_id', $itemList->id)
            ->where('role', ListUserRoleEnum::OWNER->value)
            ->exists();
    }
}
