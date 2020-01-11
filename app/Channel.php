<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Channel
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Channel whereCreatedAt($value)
 * @method static Builder|Channel whereId($value)
 * @method static Builder|Channel whereName($value)
 * @method static Builder|Channel whereSlug($value)
 * @method static Builder|Channel whereUpdatedAt($value)
 * @method static Builder|Channel newModelQuery()
 * @method static Builder|Channel newQuery()
 * @method static Builder|Channel query()
 * @mixin \Eloquent
 */
class Channel extends Model
{

}
