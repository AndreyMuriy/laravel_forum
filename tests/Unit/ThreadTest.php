<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @var Thread */
    protected $thread;

    /** Set up test */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Thread $thread */
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $this->assertEquals('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id, $this->thread->path());
    }
    
    /** @test */
    public function a_thread_has_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('\App\Channel', $this->thread->channel);
    }
    
    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $this->thread->subscribe($userId = 1);
        $this->assertEquals(1, $this->thread->subscription()->whereUserId($userId)->count());
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $this->thread->subscribe($userId = 1);
        $this->thread->unsubscribe($userId);
        $this->assertEquals(0, $this->thread->subscription()->whereUserId($userId)->count());
    }
    
    /** @test */
    public function it_knows_if_the_authenticated_user_id_subscribed_to_it()
    {
        $this->signIn();
        $this->assertFalse($this->thread->is_subscribed_to);
        $this->thread->subscribe();
        $this->assertTrue($this->thread->is_subscribed_to);
    }
}
