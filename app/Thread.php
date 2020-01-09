<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Thread
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Reply[] $replies
 * @property-read int|null $replies_count
 * @property-read User $creator
 * @method static Builder|Thread newModelQuery()
 * @method static Builder|Thread newQuery()
 * @method static Builder|Thread query()
 * @method static Builder|Thread whereBody($value)
 * @method static Builder|Thread whereCreatedAt($value)
 * @method static Builder|Thread whereId($value)
 * @method static Builder|Thread whereTitle($value)
 * @method static Builder|Thread whereUpdatedAt($value)
 * @method static Builder|Thread whereUserId($value)
 * @mixin \Eloquent
 */
class Thread extends Model
{
    protected $guarded = [];

    /**
     * Получение URL для конкретного поста
     *
     * @return string
     */
    public function path(): string
    {
        return '/threads/' . $this->id;
    }

    /**
     * Реляция для комментариев
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    /**
     * Реляция для автора
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Добавление комментария к посту
     *
     * @param $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
