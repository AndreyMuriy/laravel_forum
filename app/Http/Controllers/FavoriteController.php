<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoriteController extends Controller
{
    /**
     * FavoriteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Сохранение лайка
     *
     * @param Reply $reply
     */
    public function store(Reply $reply)
    {
        $reply->favorite();
    }

    /**
     * Удаление поставленного лайка
     *
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
