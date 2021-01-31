<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * 检验系统用户与当前用户是否一致
     *
     * @param User $currentUser
     * @param User $user
     * @return boolean
     */
    public function update(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id;
    }
}
