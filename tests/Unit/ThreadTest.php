<?php

namespace Tests\Unit;

use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_thread_has_replies()
    {
        /** @var Thread $thread */
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf(Collection::class, $thread->replies);
    }
}
