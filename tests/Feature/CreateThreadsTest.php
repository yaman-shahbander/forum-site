<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function guests_may_not_create_threads()
    {
        $this->post('/threads', [])
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }


    /** @test*/
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = make(Thread::class);
        $response = $this->post('/threads', $thread->toArray());
        $this->get($response->headers->get('Location'))
                 ->assertSee($thread->title)
                 ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_require_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_require_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_require_a_valid_channel()
    {
        createMany(Channel::class);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('threads', $thread->toArray());
    }
}
