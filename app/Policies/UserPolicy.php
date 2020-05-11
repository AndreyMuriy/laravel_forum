<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Разрешение на редактирование данных пользователя
     *
     * @param User $signedUser
     * @param User $user
     * @return bool
     */
    public function update(User $signedUser, User $user)
    {
        return $signedUser->id === $user->id;
    }
}
