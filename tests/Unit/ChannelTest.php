<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_channel_consists_of_threads()
    {
        /** @var \App\Channel $channel */
        $channel = create('App\Channel');
        /** @var \App\Thread $thread */
        $thread = create('App\Thread', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
