<?php

namespace App;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavoritesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavoritesType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUserId($value)
 * @mixin \Eloquent
 */
class Favorite extends Model
{
    protected $fillable = [
        'user_id', 'favorites_id', 'favorites_type', 'created_at', 'updated_at'
    ];
}
