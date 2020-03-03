<?php

namespace App\Http\Controllers;

use App\User;

class UserNotificationController extends Controller
{
    /**
     * UserNotificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Получить список непрочитанных уведомлений
     */
    public function index($user)
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Удаление выбранного уведомления
     *
     * @param User $user
     * @param int $notificationId
     */
    public function destroy($user, string $notificationId): void
    {
        /** @var User $user */
        $user = auth()->user();
        $user->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
