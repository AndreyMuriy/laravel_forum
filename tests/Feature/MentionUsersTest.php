<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);

        /** @var \App\User $jane */
        $jane = create('App\User', ['name' => 'JaneDoe']);

        /** @var \App\Thread $thread */
        $thread = create('App\Thread');

        /** @var \App\Reply $reply */
        $reply = make('App\Reply', [
            'body' => 'Hey @JaneDoe check this out.',
        ]);

        $this->json('post', $thread->path('replies'), $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
