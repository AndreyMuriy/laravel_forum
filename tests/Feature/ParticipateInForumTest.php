<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');

    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());
        /** @var \App\Thread $thread */
        $thread = factory('App\Thread')->create();
        /** @var \App\Reply $reply */
        $reply = factory('App\Reply')->make();
        $this->post($thread->path('replies'), $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
