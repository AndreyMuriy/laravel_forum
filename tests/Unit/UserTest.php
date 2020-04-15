<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        /** @var \App\User $user */
        $user = create('App\User');

        /** @var \App\Reply $reply */
        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }
}
