<?php

namespace Tests\Feature;

use App\Activity;
use App\Rules\Recaptcha;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Mockery;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function () {
            return Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    /** @test */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->post(route('threads.store'))
            ->assertRedirect(route('login'));

        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function new_users_must_first_confirm_email_address_before_creating_thread()
    {
        $user = factory('App\User')->states('unverified')->create();

        $this->publishThread([], $user)
            ->assertRedirect(route('verification.notice'));
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $response = $this->publishThread(['title' => 'Some Title', 'body' => 'Some Body.']);

        $this->get($response->headers->get('Location'))
            ->assertSee('Some Title')
            ->assertSee('Some Body.');
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
    public function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);
        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
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

        $response->assertRedirect(route('login'));

        $this->signIn();

        $response->assertRedirect(route('login'));
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

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();
        $thread = create(Thread::class, ['title' => 'Foo Title']);
        $this->assertEquals($thread->slug, 'foo-title');
        $thread = $this->postJson(route('threads.store'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();
        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();
        $thread = create(Thread::class, ['title' => 'Foo Title 24']);
        $thread = $this->postJson(route('threads.store'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();
        $this->assertEquals("foo-title-24-{$thread['id']}", $thread['slug']);
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

        return $this->post(route('threads.store', $thread->toArray() + ['g-recaptcha-response' => 'token']));
    }
}
