<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 17.01.20
 * Time: 0:29
 */

namespace App\Traits;

use App\Favorite;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{
    /**
     * Реляция для лайков
     *
     * @return MorphMany
     */
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Выставление лайка для сущности
     */
    public function favorite(): void
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    /**
     * Убирание лайка для сущности
     */
    public function unfavorite(): void
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->delete();
    }

    /**
     * Признак того, что пользователь уже лайкнул сущность
     *
     * @return bool
     */
    public function isFavorited(): bool
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Динамический аттрибут isFavorited
     *
     * @return bool
     */
    public function getIsFavoritedAttribute(): bool
    {
        return $this->isFavorited();
    }

    /**
     * Количество лайков для сущности
     *
     * @return int
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites->count();
    }
}
