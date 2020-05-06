<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    /**
     * Получение имён пользователей для поиска через тэг @
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        $search = request('name');

        return User::where('name', 'LIKE', "{$search}%")
            ->take(5)
            ->pluck('name');
    }
}
