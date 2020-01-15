<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Favorite;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    /** @var \App\Reply $reply */
    $reply = create('App\Reply');

    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'favorites_id' => $reply->id,
        'favorites_type' => get_class($reply),
    ];
});
