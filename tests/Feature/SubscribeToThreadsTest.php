<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_thread()
    {
        $this->signIn();
        /** @var Thread $thread */
        $thread = create('App\Thread');
        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply',
        ]);

        $this->assertCount(1, $thread->subscription);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_thread()
    {
        $this->signIn();
        /** @var Thread $thread */
        $thread = create('App\Thread');
        $this->post($thread->path() . '/subscriptions');
        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscription);
    }
}
