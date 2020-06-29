<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Отображение найденных потоков
     *
     * @param Trending $trending
     * @return Application|LengthAwarePaginator|Factory|View
     */
    public function show(Trending $trending)
    {
        $threads = Thread::search(request('q'))->paginate(25);

        if (request()->expectsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }
}
