<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionController extends Controller
{
    /**
     * Подписаться на канал
     *
     * @param string $channelId
     * @param Thread $thread
     */
    public function store(string $channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * Отписаться от канала
     *
     * @param string $channelId
     * @param Thread $thread
     */
    public function destroy(string $channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
