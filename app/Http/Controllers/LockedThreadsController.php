<?php

namespace App\Http\Controllers;

use App\Thread;
use Carbon\Carbon;

class LockedThreadsController extends Controller
{
    /**
     * Блокировка потока
     *
     * @param Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->update(['locked_at' => Carbon::now()]);
    }

    /**
     * Разблокировка потока
     *
     * @param Thread $thread
     */
    public function destroy(Thread $thread)
    {
        $thread->update(['locked_at' => null]);
    }
}
