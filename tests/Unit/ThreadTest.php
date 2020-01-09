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

    protected $thread;

    /** Set up test */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Thread $thread */
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_owner()
    {
        $this->assertInstanceOf(User::class, $this->thread->owner);
    }
}
