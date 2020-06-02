<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
use App\Filters\ThreadFilters;
use App\Traits\RecordsActivities;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Thread
 *
 * @property int $id
 * @property string $slug
 * @property int $user_id
 * @property int $channel_id
 * @property-read int|null $replies_count
 * @property int $visits
 * @property string $title
 * @property string $body
 * @property int|null $best_reply_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Channel $channel
 * @property-read User $creator
 * @property-read bool $is_subscribed_to
 * @property-read Collection|Reply[] $replies
 * @property-read Collection|ThreadSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static Builder|Thread filter(ThreadFilters $filters)
 * @method static Builder|Thread newModelQuery()
 * @method static Builder|Thread newQuery()
 * @method static Builder|Thread query()
 * @method static Builder|Thread whereBestReplyId($value)
 * @method static Builder|Thread whereBody($value)
 * @method static Builder|Thread whereChannelId($value)
 * @method static Builder|Thread whereCreatedAt($value)
 * @method static Builder|Thread whereId($value)
 * @method static Builder|Thread whereRepliesCount($value)
 * @method static Builder|Thread whereSlug($value)
 * @method static Builder|Thread whereTitle($value)
 * @method static Builder|Thread whereUpdatedAt($value)
 * @method static Builder|Thread whereUserId($value)
 * @method static Builder|Thread whereVisits($value)
 * @mixin Eloquent
 */
class Thread extends Model
{
    use RecordsActivities;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $with = ['creator', 'channel'];

    /**
     * @var array
     */
    protected $appends = ['is_subscribed_to'];

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($thread) {
            $thread->slug = $thread->title;
        });

        static::deleting(function (Thread $thread) {
            $thread->replies->each->delete();
        });
    }

    /**
     * @inheritDoc
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /***** MUTATORS *****/

    /**
     * Мутатор для аттрибута slug
     *
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $num = 2;
        $slug = Str::slug($value);
        $original = $slug;

        if (($exists = static::whereSlug($slug = Str::slug($value))->pluck('slug'))->count()) {
            do {
                $slug = "{$original}-" . $num++;
            } while ($exists->contains($slug));
        }
        $this->attributes['slug'] = $slug;
    }

    /**
     * Сохранение ID лучшего комментария
     *
     * @param Reply $reply
     */
    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }

    /**
     * Получение URL для конкретного поста
     *
     * @param string|null $subPath
     * @return string
     */
    public function path(string $subPath = null): string
    {
        return '/threads/' . $this->channel->slug . '/' . $this->slug . ($subPath ? '/' . $subPath : '');
    }

    /***** RELATIONS *****/

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
     * Реляция для подписчиков на канал
     *
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(ThreadSubscription::class, 'thread_id');
    }



    /***** SCOPES *****/

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

    /***** CUSTOM ATTRIBUTES *****/

    /**
     * Признак того, что пользователь подписан на канал
     *
     * @return bool
     */
    public function getIsSubscribedToAttribute(): bool
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /***** METHODS *****/

    /**
     * Подписка на канал
     *
     * @param int|null $userId
     * @return Thread
     */
    public function subscribe(int $userId = null): Thread
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);
        return $this;
    }

    /**
     * Отписка от канала
     *
     * @param int|null $userId
     */
    public function unsubscribe(int $userId = null): void
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }

    /**
     * Добавление комментария к посту
     *
     * @param $replyData
     * @return Reply
     */
    public function addReply($replyData): Reply
    {
        /** @var Reply $reply */
        $reply = $this->replies()->create($replyData);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * Определение, был ли поток изменён после последнего прочтения
     *
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function hasUpdatesFor(User $user): bool
    {
        $key = $user->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }
}
