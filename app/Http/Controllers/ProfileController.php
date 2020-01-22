<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\Collection;

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
            'activities' => $this->getActivities($user),
        ]);
    }

    /**
     * Получение последних активностей пользователя
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getActivities(User $user): Collection
    {
        return $user->activity()
            ->latest()
            ->with('subject')
            ->take(50)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
