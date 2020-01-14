<?php

namespace App\Filters;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilters extends Filters
{
    /**
     * Массив фильтров для потока
     *
     * @var array
     */
    protected $filters = ['by', 'popular'];

    /**
     * Фильтр по автору потока
     *
     * @param $username
     * @return Builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Сортировка для получения популярных
     *
     * @return Builder
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
