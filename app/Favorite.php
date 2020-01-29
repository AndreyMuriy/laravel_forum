<?php

namespace App;

use App\Traits\RecordsActivities;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Favorite
 *
 * @property int $id
 * @property int $user_id
 * @property int $favorites_id
 * @property string $favorites_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $favorited_id
 * @property string $favorited_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Favorite $favorited
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavoritesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavoritesType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereFavoritedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereFavoritedType($value)
 * @mixin \Eloquent
 */
class Favorite extends Model
{
    use RecordsActivities;

    protected $fillable = [
        'user_id', 'favorited_id', 'favorited_type', 'created_at', 'updated_at'
    ];

    /**
     * Отношение к субъекту активности
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
