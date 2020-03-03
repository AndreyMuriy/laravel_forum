<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\ThreadSubscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $thread_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Thread $thread
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThreadSubscription whereUserId($value)
 * @mixin \Eloquent
 */
class ThreadSubscription extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * Получение пользователя, подписанного на поток
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получение потока для подписки
     *
     * @return BelongsTo
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Оповестить связанного пользователя о том, что добавлен комментарий
     *
     * @param Reply $reply
     */
    public function notify(Reply $reply): void
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
