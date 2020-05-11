<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Trending
{
    /**
     * Получение из Redis самых популярных статей
     *
     * @return array
     */
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 4));
    }

    /**
     * Помещение/инкремент в Redis статьи
     *
     * @param Thread $thread
     */
    public function push(Thread $thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path(),
        ]));
    }

    /**
     * Сброс значений кэша для популярных статей
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    /**
     * Получение ключа для Redis
     *
     * @return string
     */
    protected function cacheKey()
    {
        return app()->environment('testing')
            ? 'testing_trending_threads'
            : 'trending_threads';
    }
}
