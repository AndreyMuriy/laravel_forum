<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Thread
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property int $channel_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Reply[] $replies
 * @property-read int|null $replies_count
 * @property-read User $creator
 * @property-read Channel $channel
 * @method static Builder|Thread newModelQuery()
 * @method static Builder|Thread newQuery()
 * @method static Builder|Thread query()
 * @method static Builder|Thread whereBody($value)
 * @method static Builder|Thread whereCreatedAt($value)
 * @method static Builder|Thread whereId($value)
 * @method static Builder|Thread whereTitle($value)
 * @method static Builder|Thread whereUpdatedAt($value)
 * @method static Builder|Thread whereUserId($value)
 * @method static Builder|Thread whereChannelId($value)
 * @method static Builder|Thread filter(ThreadFilters $filters)
 * @mixin \Eloquent
 */
class Thread extends Model
{
    protected $guarded = [];

    /**
     * Получение URL для конкретного поста
     *
     * @param string|null $subPath
     * @return string
     */
    public function path(string $subPath = null): string
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id . ($subPath ? '/' . $subPath : '');
    }

    /**
     * Реляция для комментариев
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany('App\Reply');
    }

    /**
     * Реляция для автора
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Реляция для канала форума
     *
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo('App\Channel', 'channel_id');
    }

    /**
     * Добавление комментария к посту
     *
     * @param $reply
     */
    public function addReply($reply): void
    {
        $this->replies()->create($reply);
    }

    /**
     * Скоуп для фильтров
     *
     * @param Builder $builder
     * @param $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, ThreadFilters $filters): Builder
    {
        return $filters->apply($builder);
    }
}
