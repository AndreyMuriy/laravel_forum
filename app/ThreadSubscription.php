<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ThreadSubscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $thread_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
}
