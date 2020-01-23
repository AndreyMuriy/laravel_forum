<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;

class ProfileController extends Controller
{
    /**
     * Страница профайла определенного пользователя
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user),
        ]);
    }
}
