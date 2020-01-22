<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordsActivities;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Reply
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Thread $thread
 * @method static Builder|Reply newModelQuery()
 * @method static Builder|Reply newQuery()
 * @method static Builder|Reply query()
 * @method static Builder|Reply whereBody($value)
 * @method static Builder|Reply whereCreatedAt($value)
 * @method static Builder|Reply whereId($value)
 * @method static Builder|Reply whereThreadId($value)
 * @method static Builder|Reply whereUpdatedAt($value)
 * @method static Builder|Reply whereUserId($value)
 * @mixin \Eloquent
 * @mixin Favoritable
 */
class Reply extends Model
{
    use Favoritable, RecordsActivities;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $with = ['owner', 'favorites'];

    /**
     * Автор комментария
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Статья комментария
     *
     * @return BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}

