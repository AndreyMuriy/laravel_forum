<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Auth\Access\AuthorizationException;

class BestReplyController extends Controller
{
    /**
     * Присваивание лучшего ответа для темы
     *
     * @param Reply $reply
     * @throws AuthorizationException
     */
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);

        $reply->thread->markBestReply($reply);
    }
}
