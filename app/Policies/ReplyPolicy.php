<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Определение, может ли пользователь обновлять комментарии
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function update(User $user, Reply $reply): bool
    {
        return $reply->user_id == $user->id;
    }

    /**
     * Определение, может ли пользователь создавать комментарии
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        if (!$lastReply = $user->fresh()->lastReply) {
            return true;
        }
        return !$lastReply->wasJustPublished();
    }
}
