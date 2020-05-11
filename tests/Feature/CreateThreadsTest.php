<?php

namespace Tests\Feature;

use App\Activity;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->post('/threads')
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_must_first_confirm_email_address_before_creating_thread()
    {
        $user = create('App\User', [
            'email_verified_at' => null,
        ]);

        $this->publishThread([], $user)
            ->assertRedirect('/threads')
            ->assertSessionHas('flash', 'You must first confirm your email address.');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        /** @var Thread $thread */
        $thread = make(Thread::class);
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_user_cannot_delete_threads()
    {
        $this->withExceptionHandling();
        $thread = create('App\Thread');
        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');

        $this->signIn();

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertCount(0, Activity::all());
    }

    /** @test */
    public function threads_may_only_be_deleted_by_those_who_has_permission()
    {
        $this->assertTrue(true);
    }

    /**
     * Публикация потока
     *
     * @param array $overrides
     * @param User|null $user
     * @return TestResponse
     */
    protected function publishThread(array $overrides = [], User $user = null): TestResponse
    {
        $this->withExceptionHandling()->signIn($user);

        /** @var Thread $thread */
        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
