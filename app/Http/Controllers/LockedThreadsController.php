<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadsController extends Controller
{
    /**
     * Блокировка потока
     *
     * @param Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->lock();
    }
}
