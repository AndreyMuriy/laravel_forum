<?php

namespace Tests\Feature;

use App\Activity;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread),
        ]);

        $activity = Activity::first();

        $this->assertEquals($thread->id, $activity->subject->id);
    }

    /** @test */
    public function it_records_activity_whe_a_reply_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->assertEquals(2, Activity::count());

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply),
        ]);

        $activity = Activity::orderByDesc('id')->first();

        $this->assertEquals($reply->id, $activity->subject->id);

    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        /** @var User $user */
        $user = auth()->user();

        create('App\Thread', ['user_id' => auth()->id()], 2);
        $user->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed($user, 50);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
